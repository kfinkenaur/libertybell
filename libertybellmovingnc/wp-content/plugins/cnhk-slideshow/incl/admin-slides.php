<?php
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

global $cnhk_ss;

$options = $cnhk_ss->data_obj->get_data();

$default_display_data = array(
    'slides' => $options['slides'],
);

$display_data;

if (isset($display_data)) {
    $display_data = $display_data + $default_display_data;
} else {
    $display_data = $default_display_data;
}

if (isset($_GET['noflash']) && 1 == $_GET['noflash']) {
    $cnhk_ss->data_obj->noflash(1);
}
?>
<div id="wrap-slides" class="wrap"> 
    <?php $action_nonce = wp_create_nonce('slides-action-nonce'); ?>
    <script type="text/javascript">
        /* <![CDATA[ */
            cnhkSlidesData['nonceAction'] = '<?php echo $action_nonce; ?>';
        /* ]]> */
    </script>
    <div id="icon-slides" class="icon32"></div>
    <h2><?php echo $cnhk_ss->common_texts['Slides']?></h2>
    <h3 class="main-desc"><?php _e('Add new slide or edit existing ones.', CNHK_TEXTDOMAIN); ?></h3>
    <?php $cnhk_ss->display_notices(); ?>
    <form method="post" enctype="multipart/form-data" action="<?php echo CNHK_SLIDES_URL; ?>">
        <input type="hidden" name="cnhk-slides-nonce" value="<?php echo $cnhk_ss->get_nonce(); ?>" />
        <?php $_SESSION['cnhk']['nonce'] = $cnhk_ss->get_nonce(); ?>
        <fieldset id="slides-upload-fieldset">
            <legend><?php _e('Upload a new slide.', CNHK_TEXTDOMAIN); ?></legend>
            <input type="file" name="slides-file" id="slides-file" />
            <input type="submit" name="slides-upload" value="<?php esc_attr_e('Upload', CNHK_TEXTDOMAIN); ?>" class="button-primary" />
            <p class="flash-text"><?php echo $cnhk_ss->common_texts['flash_no']; ?></p>
        </fieldset>
	</form>
    <table class="widefat" id="slides-list">
        <thead>
            <th><?php _e('Slide', CNHK_TEXTDOMAIN); ?></th>
            <th><?php echo $cnhk_ss->common_texts['Title']; ?> </th>
            <th><?php echo $cnhk_ss->common_texts['Link']; ?> </th>
            <th><?php _e('Caption', CNHK_TEXTDOMAIN); ?></th>
            <th><?php _e('Action', CNHK_TEXTDOMAIN); ?></th>
        </thead>
        <tbody>
        <?php if (isset($display_data['slides']) && array() != $display_data['slides']) : ?>
            <?php foreach ($display_data['slides'] as $slug => $data) : ?>
            <tr>
                <td class="thumb"><img data-slug="<?php echo $slug ?>" class="<?php echo $cnhk_ss->thumb_class($data['src']); ?>" src="<?php echo esc_url(CNHK_UPLOAD_URL . $data['src']); ?>" alt="" title="<?php echo esc_attr($data['title']); ?>" /></td>
                <td class="alt"><span id="edit-title-<?php echo $slug; ?>" title="<?php echo $cnhk_ss->common_texts['Edit']; ?>" class="clickable"><?php echo esc_html(stripslashes($data['title'])); ?></span></td>
                <td><span id="edit-link-<?php echo $slug; ?>" title="<?php echo $cnhk_ss->common_texts['Edit']; ?>" class="clickable"><?php echo rawurldecode($data['link']); ?></span></td>
                <td><span id="edit-caption-<?php echo $slug; ?>" title="<?php echo $cnhk_ss->common_texts['Edit']; ?>" class="clickable"><?php echo $data['caption']; ?></span></td>
                <td class="alt">
                    <a id="edit-action-<?php echo $slug; ?>" href="<?php echo CNHK_SLIDES_URL . '&action=edit&id=' .$slug . '&key=' . $action_nonce; ?>" title="<?php echo $cnhk_ss->common_texts['Edit']; ?>"><?php echo $cnhk_ss->common_texts['Edit']; ?></a> | 
                    <a id="delete-action-<?php echo $slug; ?>" href="<?php echo CNHK_SLIDES_URL . '&action=delete&id=' .$slug . '&key=' . $action_nonce; ?>" title="<?php echo $cnhk_ss->common_texts['Delete']; ?>"><?php echo $cnhk_ss->common_texts['Delete']; ?></a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr id="no-slides-yet"><td colspan="5"><p class="aligncenter nothing"><?php _e('There is no slide yet!', CNHK_TEXTDOMAIN); ?></p></td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="editor-overlay">
        <div id="live-container">
            <div id="live-wrap">
            <div id="thumb-block">
                <p>
                    <h2><?php echo $cnhk_ss->common_texts['Title']; ?>: <em id="live-title">The title</em></h2>
                    <div id="live-thumb"></div>
                </p>
            </div>
                <div id="caption-block">
                <h2><?php _e('Caption', CNHK_TEXTDOMAIN); ?></h2>
                <span style="display: none" id="live-slug"></span>
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
                    wp_editor('', 'livecaption', $args);
                ?>
                </div>
                <div class="yesno">
                    <a href="#" class="button button-primary" id="live-submit"><?php echo $cnhk_ss->common_texts['Save'] ?></a>
                    <a href="#" class="button" id="live-cancel"><?php echo $cnhk_ss->common_texts['Cancel'] ?></a>
                </div>
            </div><!-- #live-wrap -->
        </div>
    </div><!-- .editor-overlay -->
</div><!-- "wrap-slides.wrap --><?php
