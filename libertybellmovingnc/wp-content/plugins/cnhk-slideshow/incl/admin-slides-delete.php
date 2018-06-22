<?php
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

global $cnhk_ss;

$options = $cnhk_ss->data_obj->get_data();

$slide = $options['slides'][$display_data['slug']];
$nonce_delete = wp_create_nonce('cnhk-nonce-delete');

?>
<div id="wrap-delete" class="wrap">
    <div id="icon-slides" class="icon32"></div>
    <h2><?php echo $cnhk_ss->common_texts['Slides']?></h2>
    <form method="post" action="<?php echo CNHK_SLIDES_URL; ?>">
        <input type="hidden" name="cnhk-nonce-delete" value="<?php echo $nonce_delete; ?>" />
        <input type="hidden" name="slug" value="<?php echo $display_data['slug']; ?>" />
        <table class="widefat" id="slides-list">
            <thead><th colspan="2"><?php _e('Delete permanently:', CNHK_TEXTDOMAIN); ?></th></thead>
            <tbody>
                <tr>
                    <td class="thumb"><img src="<?php echo esc_url(CNHK_UPLOAD_URL . $slide['src']); ?>" alt="" class="<?php echo $cnhk_ss->thumb_class($slide['src']); ?>" /></td>
                    <td class="alt">
                        <p><?php printf(__('Are you sure to delete permanently "%s"?', CNHK_TEXTDOMAIN), esc_html(stripslashes($slide['title'])));?></p>
                        <p>
                            <ul>
                                <li><b><?php echo $cnhk_ss->common_texts['Title']; ?> :</b> <em><?php echo esc_html(stripslashes($slide['title'])); ?></em></li>
                                <li><b><?php echo $cnhk_ss->common_texts['Link']; ?> :</b> <em><?php echo rawurldecode($slide['link']); ?></em></li>
                            </ul>
                        </p>
                        <fieldset class="yesno">
                            <legend><?php echo $cnhk_ss->common_texts['Proceed']; ?></legend>
                            <input type="submit" class="button-primary" value="<?php echo $cnhk_ss->common_texts['Delete'] ?>" />
                            <a href="<?php echo esc_url(CNHK_SLIDES_URL); ?>" class="button"><?php echo $cnhk_ss->common_texts['Cancel']; ?></a>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div><?php
