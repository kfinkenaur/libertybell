<?php
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

global $cnhk_ss;

$options = $cnhk_ss->data_obj->get_data();

$default_display_data = array(
    'options' => $options,
);

$display_data;

if (isset($display_data)) {
    $display_data = $display_data + $default_display_data;
} else {
    $display_data = $default_display_data;
}

$disabled_select = (array() == $display_data['options']['slideshows']) ? ' disabled="disabled"' : '';


?>
<div id="setting-content" class="tab-content">
    <form id="slideshow-form" action="<?php echo esc_attr(CNHK_SLIDESHOW_URL) . '&tab=' . $_GET['tab']; ?>" method="post">
        <input type="hidden" name="cnhk-nonce-setting" value="<?php echo $cnhk_ss->get_nonce(); ?>" />
        <fieldset id="create-field">
            <legend><?php echo $cnhk_ss->common_texts['Create']; ?></legend>
            <label><?php _e('Add a new slideshow <em>(the name must be unique)</em> :', CNHK_TEXTDOMAIN); ?></label>
            <input type="text" name="new-ss" value="" class="regular-text"/>
            <input type="submit" name="create-ss" value="<?php echo esc_attr($cnhk_ss->common_texts['Create']); ?>" class="button-primary" /><br />
        </fieldset>
        <fieldset id="select-field">
            <legend><?php echo $cnhk_ss->common_texts['Select']; ?></legend>
            <label><?php _e('Select a slideshow to edit :', CNHK_TEXTDOMAIN); ?></label>
            <select name="target" id="target"<?php echo $disabled_select; ?>>
                <option name="none" value="none"><?php if('' == $disabled_select) _e('Available slideshows', CNHK_TEXTDOMAIN); else _e('No slideshow available', CNHK_TEXTDOMAIN); ?></option>
                <?php foreach ($display_data['options']['slideshows'] as $id => $ss) :?>
                    <?php $selected_select = ($id == $target) ? ' selected="selected"' : ''; ?>
                    <option value="<?php echo $id; ?>"<?php echo $selected_select; ?>><?php echo esc_html(stripslashes($ss['name'])); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="select-ss" id="select-ss" value="<?php echo esc_attr($cnhk_ss->common_texts['Edit']); ?>" class="button"<?php echo $disabled_select; ?> />
            <input type="submit" name="delete-ss" id="delete-ss" value="<?php echo esc_attr($cnhk_ss->common_texts['Delete']); ?>" class="button"<?php echo $disabled_select; ?> />
            <input type="submit" name="save-ss" id="save-ss" value="<?php echo esc_attr_e('Save Changes', CNHK_TEXTDOMAIN); ?>" class="button-primary"<?php echo $disabled_select; ?> />
        </fieldset>
    <?php
    switch ($_GET['tab']) {
        case 'slides' :
            include_once(CNHK_INCL_DIR . 'admin-slideshow-slides.php');
            break;
        default :
            include_once(CNHK_INCL_DIR . 'admin-slideshow-setting.php');
    }
    ?>

    </form>
</div><!-- #setting-content.tab-content --><?php
