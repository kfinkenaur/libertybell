<?php
/**
* Avoid direct call of the file
*/
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

global $cnhk_count;
global $cnhk_ss;

$slug = $this->data_obj->sanitize(addslashes($name));

$options = $cnhk_ss->data_obj->get_data();


if (!is_array($cnhk_count)) {
    $cnhk_count = array();
}

if (!isset($options['slideshows'][$slug])) {
    return;
}

$hasCaption = false;
foreach ($options['slideshows'][$slug]['slides'] as $value) {
    if ($cnhk_ss->common_texts['NoCaption'] != $options['slides'][$value]['caption']) {
        $hasCaption = true;
        break;
    }
}

if (!isset($cnhk_count[$slug])) {
    $cnhk_count[$slug] = 1;
} else {
    $cnhk_count[$slug]++;
}

$id = 'ss-' . $slug . '-i' . $cnhk_count[$slug];
$slide_length = count($options['slideshows'][$slug]['slides']);
if (0 == $slide_length) {
    return;
}
?>
<div class="slideshow-wrapper<?php if ($options['slideshows'][$slug]['pager']) echo ' with-pager'; ?>">
    <div id="<?php echo $id; ?>" class="cnhk-slideshow">
    <?php if (0 == $options['slideshows'][$slug]['delay']) : ?>
        <?php foreach ($options['slideshows'][$slug]['slides'] as $slide) : ?>
            <?php if ($cnhk_ss->common_texts['NoLink'] == rawurldecode($options['slides'][$slide]['link'])) : ?>
                <div class="cnhk-slide">
                    <img alt="" title="<?php echo esc_attr(stripslashes($options['slides'][$slide]['title'])) ?>" src="<?php echo esc_url(CNHK_UPLOAD_URL . $options['slides'][$slide]['src']); ?>" />
                    <?php if ($cnhk_ss->common_texts['NoCaption'] != $options['slides'][$slide]['caption']) : ?>
                        <div class="slide-overlay"><?php echo $options['slides'][$slide]['caption']; ?></div>
                    <?php endif; ?>
                </div>
            <?php else :?>
                <a class="cnhk-slide" href="<?php echo esc_url(rawurldecode($options['slides'][$slide]['link'])); ?>" >
                    <img alt="" title="<?php echo esc_attr(stripslashes($options['slides'][$slide]['title'])) ?>" src="<?php echo esc_url(CNHK_UPLOAD_URL . $options['slides'][$slide]['src']); ?>" />
                    <?php if ($cnhk_ss->common_texts['NoCaption'] != $options['slides'][$slide]['caption']) : ?>
                        <div class="slide-overlay"><?php echo $options['slides'][$slide]['caption']; ?></div>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
       <?php endforeach;?>
    <?php endif; ?>
    <?php if ($options['slideshows'][$slug]['nav'] && 1 < $slide_length) : ?>
        <div class="cycle-prev"></div>
        <div class="cycle-next"></div>
    <?php endif; ?>
    </div><!-- #<?php echo $id; ?> -->
    <?php if ($options['slideshows'][$slug]['pager'] && 1 < $slide_length) : ?>
        <div class="cycle-pager"></div>
    <?php endif; ?>
</div><!-- .slideshow-wrapper --><?php
