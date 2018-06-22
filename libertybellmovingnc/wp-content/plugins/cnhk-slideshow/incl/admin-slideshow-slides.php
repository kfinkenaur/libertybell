<?php
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

global $cnhk_ss;
?>
<fieldset id="slides-field">
    <?php if ('' != $target) : ?>
    <?php
        $target_ss = $display_data['options']['slideshows'][$target];
        $slides = $display_data['options']['slides'];
        $order = implode('.', $target_ss['slides']);
    ?>
    <input type="hidden" name="order" id="order" value="<?php echo esc_attr($order); ?>" />
    <table class="widefat">
        <thead>
            <tr>
                <th class="thumb"><?php _e('Available Slides', CNHK_TEXTDOMAIN); ?></th>
                <th class="thumb"><?php printf(__('Slides order (from top to bottom) in "%s"', CNHK_TEXTDOMAIN), esc_html(stripslashes($target_ss['name']))); ?></th>
            </tr>
        </thead>
        <tbody>
            <td>
                <ul id="left-col">
                <?php $i = 0 ?>
                <?php foreach ($slides as $slug => $value) : ?>
                    <li position="<?php echo $i ?>" slug="<?php echo $slug; ?>"><img alt="" class="<?php echo $cnhk_ss->thumb_class($slides[$slug]['src']); ?>" src="<?php echo esc_url(CNHK_UPLOAD_URL . $slides[$slug]['src']); ?>" /></li>
                    <?php $i++; ?>
                <?php endforeach; ?>
                </ul>
            </td>
            <td>
                <ul id="right-col">
                    <?php foreach ($target_ss['slides'] as $slug) : ?>
                        <li slug="<?php echo $slug; ?>"><img alt="" class="<?php echo $cnhk_ss->thumb_class($slides[$slug]['src']); ?>" src="<?php echo esc_url(CNHK_UPLOAD_URL . $slides[$slug]['src']); ?>" /></li>
                    <?php endforeach; ?>
                    <?php //print_r($display_data['options']); ?>
                </ul>
            </td>
        </tbody>
    </table>
    <?php else : ?>
        <?php if ('' == $disabled_select) : ?>
            <p class="splash"><?php _e('Please select a slideshow.', CNHK_TEXTDOMAIN); ?></p>
        <?php else : ?>
            <p class="splash"><?php _e('Please create a slideshow first.', CNHK_TEXTDOMAIN); ?></p>
        <?php endif; ?>
    <?php endif; ?>
</fieldset><?php
