<?php
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

global $cnhk_ss;
?>
<fieldset id="setting-field">
    <?php $legend = ('' != $target) ? sprintf(__('Settings for "%s"', CNHK_TEXTDOMAIN), esc_html(stripslashes($display_data['options']['slideshows'][$target]['name']))) : ''; ?>
    <legend><?php echo $cnhk_ss->common_texts['Settings']; ?></legend>
    <h3><?php echo $legend; ?></h3>
    <?php if ('' != $target) : ?>
    
        <label><?php _e('Effect', CNHK_TEXTDOMAIN); ?></label>
        <?php $effect_list = $cnhk_ss->data_obj->get_effects(); ?>
        <select name="fx">
        <?php foreach ($effect_list as $name => $effect) : ?>
            <option value="<?php echo esc_attr($effect); ?>"<?php selected($effect, $display_data['options']['slideshows'][$target]['fx']); ?>><?php echo $name; ?></option>
        <?php endforeach; ?>
        </select>
        <p class="desc"><?php _e('The transition effect used when switching between two slides.', CNHK_TEXTDOMAIN); ?></p>
        
        <label><?php _e('Speed', CNHK_TEXTDOMAIN); ?></label>
        <input type="text" name="speed" value="<?php echo $display_data['options']['slideshows'][$target]['speed']; ?>" /> <em><?php _e('(in milliseconds)', CNHK_TEXTDOMAIN); ?></em>
        <p class="desc"><?php _e('The speed of the transition effect.', CNHK_TEXTDOMAIN); ?></p>
        
        <label><?php _e('Timeout', CNHK_TEXTDOMAIN); ?></label>
        <input type="text" name="timeout" value="<?php echo $display_data['options']['slideshows'][$target]['timeout'] ?>" /> <em><?php _e('(in milliseconds)', CNHK_TEXTDOMAIN); ?></em>
        <p class="desc"><?php _e('The timeout before auto-switching to next slide', CNHK_TEXTDOMAIN); ?></p>
        
        <label><?php _e('Pager', CNHK_TEXTDOMAIN); ?></label>
        <input type="checkbox" name="pager" value="1" <?php checked($display_data['options']['slideshows'][$target]['pager']); ?> />
        <p class="desc"><?php _e('Tick to display paged navigations buttons.', CNHK_TEXTDOMAIN); ?></p>
        
        <label><?php _e('Prev/Next navigation', CNHK_TEXTDOMAIN); ?></label>
        <input type="checkbox" name="nav" value="1" <?php checked($display_data['options']['slideshows'][$target]['nav']); ?> />
        <p class="desc"><?php _e('Tick to display previous and next navigation buttons.', CNHK_TEXTDOMAIN); ?></p>
        
        <label><?php _e('Delay', CNHK_TEXTDOMAIN); ?></label>
        <input type="text" name="delay" value="<?php echo $display_data['options']['slideshows'][$target]['delay'] ?>" /> <em><?php _e('(in seconds)', CNHK_TEXTDOMAIN); ?></em>
        <p class="desc"><?php _e('Delay before launching slideshow, if all the images are loaded before this timeout, the slideshow is launched. A negative value prevents the slideshow to be launched before all images are loaded.', CNHK_TEXTDOMAIN);?><br />
        <?php _e('A "Loading" image will be shown until the launch.', CNHK_TEXTDOMAIN); ?>
        <?php _e('Set it to 0 (zero) to prevent preloading images with javascript.', CNHK_TEXTDOMAIN); ?></p>
        
        <label><?php _e('Skip unloaded images', CNHK_TEXTDOMAIN); ?></label>
        <input type="checkbox" name="skip" value="1" <?php checked($display_data['options']['slideshows'][$target]['skip']); ?> />
        <p class="desc"><?php _e('Skip all incompletely loaded images before starting the slideshow (after delay).', CNHK_TEXTDOMAIN); ?></p>
        
    <?php else : ?>
        <?php if ('' == $disabled_select) : ?>
            <p class="splash"><?php _e('Please select a slideshow.', CNHK_TEXTDOMAIN); ?></p>
        <?php else : ?>
            <p class="splash"><?php _e('Please create a slideshow first.', CNHK_TEXTDOMAIN); ?></p>
        <?php endif; ?>
    <?php endif; ?>
</fieldset><?php
