<?php

/*
 *      save signature form data
 */
add_action('wp_ajax_ssing_capture_form', 'ssing_capture_form_callback');
add_action('wp_ajax_nopriv_ssing_capture_form', 'ssing_capture_form_callback');

function ssing_capture_form_callback() {
    if (isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] == 'ssing_capture_form') {
        global $wpdb;
        $table_log = $wpdb->prefix . 'ssing_log';
        $table_lead_report = $wpdb->prefix . 'ssing_lead_report';

        parse_str($_POST['form_data'], $capture_form_data);

        $log_insert = $wpdb->insert($table_log, array(
            'ssign_capture_name' => $capture_form_data['name'],
            'ssign_capture_email' => $capture_form_data['email'],
            'ssign_capture_data' => json_encode($capture_form_data),
            'date_time' => date("Y-m-d H:i:s")
                ), array('%s', '%s', '%s', '%s')
        );

        // insert record for dashboard lead report.
        $log_insert = $wpdb->insert($table_lead_report, array(
            'lead_pageid' => $_POST['page_id'],
            'lead_date' => date("Y-m-d H:i:s")
                ), array('%s', '%s')
        );
        echo "1";
    }
    wp_die();
}

/*
 *      Auto send signture data to swiftForm
 */
add_action('wp_ajax_ssignAutoPost', 'ssignAutoPost_callback');
add_action('wp_ajax_nopriv_ssignAutoPost', 'ssignAutoPost_callback');

function ssignAutoPost_callback() {
    if (isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] == 'ssignAutoPost') {
        global $wpdb;
        $table_log = $wpdb->prefix . 'ssing_log';

        $ssign_log = $wpdb->get_results("SELECT * FROM $table_log WHERE `ssign_status`=0 ORDER BY `ssign_id` LIMIT 1", ARRAY_A);
        if (!empty($ssign_log)) {
            foreach ($ssign_log as $signlog) {
                $signlog['ssign_id'];
                $form_data = json_decode($signlog['ssign_capture_data']);

                $testing_mode = get_option('ssing_beta_testing_mode');
                $swiftForm_url = $testing_mode == 1 ? "https://swiftcloud.io/forms/fh_sandbox.php" : "https://swiftcloud.io/forms/fh.php";

                $ch = curl_init();                                  // initiate curl
                $url = $swiftForm_url;        // where you want to post data
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);               // tell curl you want to post something
                $header[] = "Accept-Language: en-us,en;q=0.5";
                curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data);   // define what you want to post
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     // return the output in string format
                $output = curl_exec($ch);                          // execute
                $curl_response = curl_getinfo($ch);                // get response as array
                curl_close($ch);

                if (!empty($curl_response) && array_key_exists('redirect_url', $curl_response)) {
                    $update = $wpdb->update($table_log, array('ssign_status' => 1,), array('ssign_id' => $signlog['ssign_id']), array('%d'), array('%d'));
                }
            }
        }
    }
    wp_die();
}

?>