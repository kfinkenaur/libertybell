<?php
/*
 *      SwiftSignature Lead Report(Dashboard widget)
 */
add_action('wp_dashboard_setup', 'swiftsign_lead_report', 10, 2);

function swiftsign_lead_report() {
    $ssing_dashboard_widget_flag = get_option("ssing_dashboard_widget_flag");
    if ($ssing_dashboard_widget_flag) {
        wp_add_dashboard_widget(
                'swift_signature_lead_report', 'SwiftCloud e-Signatures', 'swiftsign_lead_report_output'
        );
    }
}

function swiftsign_lead_report_output() {
    wp_enqueue_script('chart-min', plugins_url('/js/Chart.min.js', __FILE__), '', '', true);
    wp_enqueue_style('swift-admin-style', plugins_url('/css/admin.css', __FILE__), '', '', '');

    global $wpdb;
    $daycount = 0;

    $table_lead_report = $wpdb->prefix . 'ssing_lead_report';
    $qry = 'SELECT lead_date, COUNT( * ) AS lead_count FROM ' . $table_lead_report . ' WHERE month(curdate()) = month(lead_date) group by day(lead_date)';
    $get_data = $wpdb->get_results($qry);
    if (isset($get_data) && !empty($get_data)) {
        foreach ($get_data as $lead_report_date) {
            $x_axis[] = '"' . date('M jS', strtotime($lead_report_date->lead_date)) . '"';
            $y_axis[] = $lead_report_date->lead_count;
            $daycount++;
        }
        $x_axis = implode(",", $x_axis);
        $y_axis = implode(",", $y_axis);
    }
    ?>
    <div style="width: 100%">
        <?php if (!empty($get_data)) { ?>
            <div><canvas id="swiftSignatureCanvas" height="500" width="500"></canvas></div>
            <div class="swift_summery_report">
                <div class="top-lead-page">
                    <?php
                    $ssign_total_qry = 'SELECT COUNT(*) AS total_submission FROM ' . $table_lead_report;
                    $ssign_total_submission = $wpdb->get_results($ssign_total_qry);
                    ?>
                    <h3 class="top-lead-title"><strong>Total Submission: <?php echo $ssign_total_submission[0]->total_submission; ?></strong></h3>
                </div><!-- /top-lead-page-->
                <div class="top-pages-viewed">
                    <h3 class="top-pages-title"><strong>Top Captured Pages:</strong></h3>
                    <?php
                    $qry1 = 'SELECT lead_pageid, COUNT(lead_pageid) as lead_pagecount FROM ' . $table_lead_report . ' GROUP BY lead_pageid LIMIT 5';
                    $get_PageCount_data = $wpdb->get_results($qry1);
                    foreach ($get_PageCount_data as $page_count) {
                        ?>
                        <p class="top-lead-list"><a href="<?php echo get_permalink($page_count->lead_pageid); ?>" target="_blank"><?php echo get_the_title($page_count->lead_pageid) . ": " . $page_count->lead_pagecount; ?></a></p>
                        <?php } ?>
                </div>
            </div>
            <?php
        } else {
            echo "<div style='text-align:center'><h2>No data to report</h2></div>";
        }
        ?>
    </div>
    <script type="text/javascript">
        var ssign_leadreport_data = {
            labels: [<?php echo $x_axis; ?>],
            datasets: [
                {
                    fillColor: "rgba(25, 106, 188,0.2)",
                    strokeColor: "rgba(25, 106, 188,1)",
                    pointColor: "rgba(25, 106, 188,1)",
                    pointStrokeColor: "rgba(25, 106, 188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(25, 106, 188,1)",
                    data: [<?php echo $y_axis; ?>]
                }
            ]
        };

        var ssign_leadreport_option = {
            animationEasing: "easeInOutExpo",
            scaleBeginAtZero: true,
            scaleShowGridLines: true,
            scaleShowVerticalLines: false,
            scaleGridLineColor: "rgba(0,0,0,0.2)",
            responsive: true,
            bezierCurve: false,
            pointDotRadius: 3,
            pointDotStrokeWidth: 1,
            pointHitDetectionRadius: 0,
            tooltipFillColor: "rgba(255,255,255,1)",
            tooltipFontColor: "#000",
            tooltipTitleFontStyle: "bold",
            tooltipCaretSize: 8,
            tooltipCornerRadius: 1
        };

        jQuery(document).ready(function() {
            var ssign_ctx = document.getElementById("swiftSignatureCanvas").getContext("2d");
            window.swiftSignLeadReport = new Chart(ssign_ctx).Line(ssign_leadreport_data, ssign_leadreport_option);
        });

    </script>
    <?php
}

function ss_getLeadPageId() {
    //c=55604&confirm=1&firstname=Test+Test
    global $wpdb;
    if (isset($_COOKIE['sma_lead_page_id']) && !empty($_COOKIE['sma_lead_page_id']) && isset($_GET['c']) && !empty($_GET['c']) && isset($_GET['confirm']) && !empty($_GET['confirm']) && $_GET['confirm'] == 1) {
        $today_date = date('Y-m-d');
        $pageid = $_COOKIE['sma_lead_page_id'];
        $wpdb->insert(
                $wpdb->prefix . 'sma_lead_report', array('lead_date' => $today_date, 'lead_pageid' => $pageid), array('%s', '%d')
        );
        setcookie('sma_log_id', 0, time() - 3600);
    }
}

add_action('init', 'ss_getLeadPageId', 1);

function ss_hidden_pageid() {
    global $post;
    $post_id = (isset($post->ID) && !empty($post->ID)) ? $post->ID : get_the_ID();
    if ($post_id) {
        echo '<input type="hidden" name="sma_lead_page_id" id="sma_lead_page_id" value="' . $post_id . '" />';
    }
}

add_action('wp_head', 'ss_hidden_pageid', 2);
?>