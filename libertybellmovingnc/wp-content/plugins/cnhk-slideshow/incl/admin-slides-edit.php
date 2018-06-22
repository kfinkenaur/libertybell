<?php
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

global $cnhk_ss;

$options = $cnhk_ss->data_obj->get_data();

$slide = $options['slides'][$display_data['slug']];
$nonce_edit = wp_create_nonce('cnhk-nonce-edit');

?>
<div id="wrap-edit" class="wrap">
    <div id="icon-slides" class="icon32"></div>
    <h2><?php echo $cnhk_ss->common_texts['Slides']?></h2>
    <?php $cnhk_ss->display_notices(); ?>
    <form method="post" action="<?php echo CNHK_SLIDES_URL; ?>">
        <input type="hidden" name="cnhk-nonce-edit" value="<?php echo $nonce_edit; ?>" />
        <input type="hidden" name="slug" value="<?php echo $display_data['slug']; ?>" />
        <table class="widefat" id="slide-detail">
            <thead><th colspan="2"><?php printf(__('Edit %s?', CNHK_TEXTDOMAIN), stripslashes($slide['title']));?></th></thead>
            <tbody>
                <tr>
                    <td class="thumb"><img src="<?php echo esc_url(CNHK_UPLOAD_URL . $slide['src']); ?>" alt="" class="<?php echo $cnhk_ss->thumb_class($slide['src']); ?>"/></td>
                    <td class="alt">
                        <label for="slide-title"><?php echo $cnhk_ss->common_texts['Title']; ?></label><br />
                        <input type="text" name="title" id="slide-title" value="<?php echo esc_html(stripslashes($slide['title'])) ; ?>" />
                        <p><em><?php _e('The title is used to identify the slide. It is also used for building the filename.', CNHK_TEXTDOMAIN); ?></em></p>
                        <label for="slide-link"><?php echo $cnhk_ss->common_texts['Link']; ?></label><br />
                        <input type="text" name="link" id="slide-link" value="<?php echo rawurldecode($slide['link']); ?>" />
                        <p><em><?php _e('The link toward which this slide leads', CNHK_TEXTDOMAIN); ?></em></p>
                        <label for="slidecaption"><?php echo _e('Caption', CNHK_TEXTDOMAIN); ?></label><br />
                        <div>
                            <?php 
                                $args = array(
                                    'media_buttons' => false,
                                    'quicktags' => false,
                                    'tinymce'   => array(
                                        'theme_advanced_buttons1' => 'fontselect, fontsizeselect,bold,italic,underline, strikethrough, justifyleft, justifycenter, justifyright, justifyfull, bullist, numlist, cut, copy, paste, undo, redo',
                                        'theme_advanced_buttons2' => '',
                                        'theme_advanced_buttons3' => '',
                                    ),
                                );
                                $cap_content = ($cnhk_ss->common_texts['NoCaption'] == $slide['caption']) ? '' : $slide['caption'];
                                wp_editor($cap_content, 'slidecaption', $args);
                            ?>
                        </div>
                        <fieldset class="yesno">
                            <legend><?php echo $cnhk_ss->common_texts['Proceed']; ?></legend>
                            <input type="submit" class="button-primary" value="<?php echo $cnhk_ss->common_texts['Save'] ?>" />
                            <a href="<?php echo esc_url(CNHK_SLIDES_URL); ?>" class="button"><?php echo $cnhk_ss->common_texts['Cancel']; ?></a>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div><?php
