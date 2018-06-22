<?php

function ourprofiles_shortcode( $atts ) {
    global $ourprofiles_links, $ourprofiles_services, $ourprofiles_options;

    extract( shortcode_atts( array(
        'columns' => 3
    ), $atts ) );

    $ourprofiles_output_array = array();
    foreach ($ourprofiles_links as $service => $link) {
        $image = '';
        if (isset($ourprofiles_services[$service])){
            $image = OURPROFILES_HTTP_PATH . 'images/' . $ourprofiles_options['images_folder'] . '/' . $ourprofiles_services[$service]['image'];
        }
        if (!empty($link) && !empty($image)){
            $ourprofiles_output_array[$service] = array(
                'link' => $link,
                'image' => $image
            );
        }
    }

    ob_start();
?>
    <table class="our-profiles-content">
<?php
        $count = 1;
        $rows = 0;
        $tr_opened = false;
        foreach ($ourprofiles_output_array as $service => $output) {
            if ( $count == 1){
                echo '<tr>';
                $tr_opened = true;
                $rows++;
            }
?>
            <td>
                <a href="<?php echo $output['link']; ?>" target="_blank" title="Visit our profile at <?php echo $service; ?>">
                    <img src="<?php echo $output['image']; ?>" alt="Visit our profile at <?php echo $service; ?>" title="Visit our profile at <?php echo $service; ?>" >
                </a>
            </td>
<?php
            if ( $count == $columns ) {
                echo '</tr>';
                $tr_opened = false;
                $count = 1;
            } else {
                $count++;
            }
        }
        if ($rows > 1 && $count != 1){
            for ($count; $count <= $columns; $count++){
                echo "<td></td>";
            }
        }
        if ($tr_opened){
            echo '</tr>';
        }
?>
    </table>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode( 'ourprofiles', 'ourprofiles_shortcode' );

function ourprofiles_shortcode_css() {
?>

<style type="text/css">
    table.our-profiles-content {
        border: 0 none;
        width: 100%;
    }

    .our-profiles-content td {
        padding: 7px 10px;
        text-align: center;
        border: 0 none;
    }

    .our-profiles-content a {
        text-decoration: none;
    }

    .our-profiles-content img{
        box-shadow: 0 0 0;
    }
</style>

<?php
}

add_action( 'wp_head', 'ourprofiles_shortcode_css' );

?>