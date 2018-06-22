<?php
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

global $cnhk_ss;

$options = $cnhk_ss->data_obj->get_data();
$target = $_POST['target'];
?>
<div id="delete-content" class="tab-content">
    <form id="delete-form" action="<?php echo esc_attr(CNHK_SLIDESHOW_URL); ?>" method="post">
        <input type="hidden" name="cnhk-nonce-setting" value="<?php echo $cnhk_ss->get_nonce(); ?>" />
        <input type="hidden" name="target" value="<?php echo $target; ?>" />
        <table class="widefat">
            <thead>
                <tr><th colspan="3"><?php printf(__('Delete slideshow: "%s"', CNHK_TEXTDOMAIN), esc_html(stripslashes($options['slideshows'][$target]['name']))); ?></th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <p><?php _e('Deleting slideshow does not affect slides and other slideshows.', CNHK_TEXTDOMAIN); ?></p>
                        <fieldset class="yesno">
                            <legend><?php _e('Delete it?', CNHK_TEXTDOMAIN); ?></legend>
                            <input type="submit" name="delete-ss-submit" value="<?php echo $cnhk_ss->common_texts['Delete']; ?>" class="button-primary" />
                            <a href="<?php echo esc_url(CNHK_SLIDESHOW_URL); ?>" class="button" /><?php echo $cnhk_ss->common_texts['Cancel']; ?></a>
                        </fieldset>
                    </td>
                    <td class="alt">
                    <?php if (array() != $options['slideshows'][$target]['slides']) : ?>
                        <h3 class="splash"><?php printf(__('The slideshow "%1$s" contains %2$s slides.', CNHK_TEXTDOMAIN)
                            , esc_html(stripslashes($options['slideshows'][$target]['name']))
                            ,'<strong>' . count($options['slideshows'][$target]['slides']) . '</strong>'
                        ); ?></h3>
                    <?php else : ?>
                        <p class="splash"><?php _e('This slideshow does not contain any slides.', CNHK_TEXTDOMAIN); ?></p>
                    <?php endif; ?>
                    </td>
                    <td>
                    <?php if (array() != $options['slideshows'][$target]['slides']) : ?>
                        <ul>
                        <?php foreach ($options['slideshows'][$target]['slides'] as $slug) : ?>
                            <li><img alt="" class="<?php echo $cnhk_ss->thumb_class($options['slides'][$slug]['src']); ?>" src="<?php echo esc_url(CNHK_UPLOAD_URL . $options['slides'][$slug]['src']); ?>" /></li>
                        <?php endforeach; ?>
                        </ul>
                    <?php  endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div><!-- #delete-content.tab-content --><?php

