<?php
/**
 * @package accesspress_parallax
 */
$single_post_footer = of_get_option('single_post_footer');
$post_featured_image = of_get_option('post_featured_image');

$property_type = get_the_term_list(get_the_ID(), 'property-types', '', ', ', '');
$bedrooms = get_post_meta(get_the_ID(), '_listing_bedrooms', true);
$baths = get_post_meta(get_the_ID(), '_listing_bathrooms', true);
$cars = get_post_meta(get_the_ID(), '_listing_garage', true);
$proprety_download_link = get_post_meta(get_the_ID(), '_field_inputtext__1479887411', true);
$property_agent_phone = get_the_author_meta('mtl_user_phone_number');

$property_address = get_post_meta(get_the_ID(), '_listing_address', true);
$property_city = get_post_meta(get_the_ID(), '_listing_city', true);
$property_county = get_post_meta(get_the_ID(), '_listing_county', true);
$property_state = get_post_meta(get_the_ID(), '_listing_state', true);
$property_zip = get_post_meta(get_the_ID(), '_listing_zip', true);
$property_country = get_post_meta(get_the_ID(), '_listing_country', true);

$propery_sub_title = '';
$propery_sub_title .= ($property_address) ? $property_address . ', ' : '';
$propery_sub_title .= ($property_city) ? $property_city . ', ' : '';
$propery_sub_title .= ($property_county) ? $property_county : '';

$all_status = get_the_terms(get_the_ID(), 'status');
$status_ids = array();
foreach ($all_status as $status) {
    $status_ids[] = $status->term_id;
}
?>
<article id="post-<?php the_ID(); ?>" class="property-container">
    <div class="entry-content">
        <div class="left-content">
            <div class="property-summery-text">
                <?php echo get_post_meta(get_the_ID(), '_listing_home_sum', true); ?>
                <span class="property-address"><?php echo $propery_sub_title; ?></span>
            </div>
            <div class="property-info">
                <ul>
                    <li><img src="<?php echo get_stylesheet_directory_uri() . "/imgs/home-prop-single.png"; ?>" /><span><?php echo $property_type; ?></span></li>
                    <?php if($bedrooms > 0): ?><li><img src="<?php echo get_stylesheet_directory_uri() . "/imgs/bads-prop-single.png"; ?>" /><span><?php echo ($bedrooms > 0 ? $bedrooms . " beds" : $bedrooms . " bed" ); ?></span></li><?php endif; ?>
                    <?php if($baths > 0): ?><li><img src="<?php echo get_stylesheet_directory_uri() . "/imgs/baths-prop-single.png"; ?>" /><span><?php echo ($baths > 0 ? $baths . " baths" : $baths . " bath" ); ?></span></li><?php endif; ?>
                    <li><img src="<?php echo get_stylesheet_directory_uri() . "/imgs/parking-prop-single.png"; ?>" /><span><?php echo ($cars > 0 ? $cars . " cars" : $cars . " car" ); ?></span></li>
                </ul>
            </div>
            <div class="property-content">
                <span class="content-title">About this listing</span>
                <?php the_content(); ?>
            </div>
            <div class="property-share">
                <span class="property-share-text">Share this property</span>
                <ul class="property-share-icon"><li class="property-fb"><a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink(); ?>" target="_blank"><i class="fa fa-facebook-f"></i></a></li><li class="property-linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_the_permalink(); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><li><a href="mailto:<?php echo get_the_author_meta('user_email'); ?>"><i class="fa fa-envelope"></i></a></li></ul>
            </div>
            <?php if ($proprety_download_link): ?>
                <div class="property-download">
                    <span class="content-title">Downloads</span>
                    <div class="property-download-item"><i class="fa fa-file-text-o"></i> <a href="<?php echo $proprety_download_link; ?>">Detailed Listing (PDF)</a></div>
                </div>
            <?php endif; ?>
        </div>
        <div class="right-content">
            <div class="property-price-box">
                <span><?php echo get_post_meta(get_the_ID(), '_listing_price', true); ?></span>
            </div>
            <div class="property-author-img">
                <?php $user_img = get_avatar(get_the_author_meta('ID'), 100); ?>
                <?php echo ($user_img) ? $user_img : '' ?>
            </div>
            <div class="property-contact-form">
                <?php if (!empty($status_ids) && isset($status_ids[0]) && !in_array(8, $status_ids)): ?>
                    <span class="property-contact-form-title">Request a Visit</span>
                    <?php echo do_shortcode('[contact-form-7 id="134" title="Request a visit"]'); ?>
                <?php else: ?>
                    <span class="property-contact-form-title">Get in Touch</span>
                    <?php echo do_shortcode('[contact-form-7 id="351" title="Get in Touch"]'); ?>
                <?php endif; ?>
            </div>
            <div class="property-author-info">
                <div class="property-author-info-title">Agent</div>
                <ul>
                    <li class="property-author-name"><?php echo get_author_name(); ?></li>
                    <li class="property-author-email"><i class="fa fa-envelope"></i>  <?php echo get_the_author_meta('user_email'); ?></li>
                    <?php if ($property_agent_phone) { ?><li class="property-author-phone"><i class="fa fa-phone"></i>  <?php echo $property_agent_phone; ?></li><?php } ?>
                </ul>
            </div>
        </div>
    </div><!-- .entry-content -->
</article>