<?php
include_once(dirname(__FILE__) . '/grw-reviews-helper.php');

$place = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "grp_google_place WHERE place_id = %s", $place_id));
$reviews = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "grp_google_review WHERE google_place_id = %d", $place->id));

$rating = 0;
if ($place->rating > 0) {
    $rating = $place->rating;
} else if (count($reviews) > 0) {
    foreach ($reviews as $review) {
        $rating = $rating + $review->rating;
    }
    $rating = round($rating / count($reviews), 1);
}
$rating = number_format((float)$rating, 1, '.', '');
?>

<?php if ($view_mode != 'list') { ?>

<div class="wp-gr wpac">
    <div class="wp-google-badge<?php if ($view_mode == 'badge') { ?> wp-google-badge-fixed<?php } ?>" onclick="grw_next(this).style.display='block'">
        <div class="wp-google-border"></div>
        <div class="wp-google-badge-btn">
            <img class="wp-google-logo" src="<?php echo GRW_PLUGIN_URL; ?>/static/img/google_rating_logo_36.png" alt="powered by Google">
            <div class="wp-google-badge-score">
                <div><?php echo grw_i('Google Rating'); ?></div>
                <span class="wp-google-rating"><?php echo $rating; ?></span>
                <span class="wp-google-stars"><?php grw_stars($rating); ?></span>
            </div>
        </div>
    </div>
    <div class="wp-google-form" style="display:none">
        <div class="wp-google-head">
            <div class="wp-google-head-inner">
                <?php grw_place($rating, $place, $reviews, $dark_theme, false); ?>
            </div>
            <button class="wp-google-close" type="button" onclick="this.parentNode.parentNode.style.display='none'">×</button>
        </div>
        <div class="wp-google-body"></div>
        <div class="wp-google-content">
            <div class="wp-google-content-inner">
                <?php grw_place_reviews($place, $reviews, $place_id, $text_size); ?>
            </div>
        </div>
        <div class="wp-google-footer">
            <img src="<?php echo GRW_PLUGIN_URL; ?>/static/img/powered_by_google_on_<?php if ($dark_theme) { ?>non_<?php } ?>white.png" alt="powered by Google">
        </div>
    </div>
</div>

<?php } else { ?>

<div class="wp-gr wpac">
    <div class="wp-google-list<?php if ($dark_theme) { ?> wp-dark<?php } ?>">
        <div class="wp-google-place">
            <?php grw_place($rating, $place, $reviews, $dark_theme); ?>
        </div>
        <div class="wp-google-content-inner">
            <?php grw_place_reviews($place, $reviews, $place_id, $text_size); ?>
        </div>
    </div>
</div>
<?php } ?>