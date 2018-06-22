<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package panoramic
 */
global $woocommerce;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
<?php
if ( get_theme_mod( 'panoramic-layout-site', customizer_library_get_default( 'panoramic-layout-site' ) ) == 'panoramic-layout-site-boxed' ) { ?>
	<div class="boxed">
<?php
}

global $queried_object, $slider_shortcode;

$header_image_id = null;

if (!$queried_object) {
	if ( panoramic_is_woocommerce_activated() && is_woocommerce() ) {
		// If Woocommerce is active and it's the shop page set the queried object to the shop page
		if ( is_shop() ) {
			$queried_object = get_post( get_option( 'woocommerce_shop_page_id' ) );
		}
	} else {
		// Otherwise just get the queried object
		$queried_object = get_queried_object();
	}
}

if ($queried_object) {
	
	if ( ( !is_front_page() && is_page() ) || is_home() || is_singular('post') ) {
		$custom_fields = get_post_custom($queried_object->ID);
		$slider_shortcode = trim($custom_fields["slider_shortcode"][0]);
	}
	
	// If it's a single post get the header image from the custom field
	if ( is_singular('post') ) {
		$header_image_id = trim($custom_fields["header_image_id"][0]);
		
	// Otherwise get it from the term's custom meta
	} else if ( is_category() || is_tag() ) {
		$term_meta = get_option( "taxonomy_$queried_object->term_id" );
		$header_image_id = intval( $term_meta['header_image_id'] ) ? intval( $term_meta['header_image_id'] ) : 0;
	}
	
}

$margin_class = '';

// Set the margin class for the site header on secondary pages depending on whether or not a slider or header image is going to display

// If it's not the homepage or a secondary blog page and the default slider is active and the slider is set to display on all pages
if ( ( ( !is_front_page() && is_page() ) || ( panoramic_is_woocommerce_activated() && is_shop() ) || is_home() ) && get_theme_mod( 'panoramic-slider-all-pages', customizer_library_get_default( 'panoramic-slider-all-pages' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-default' ) {
	$margin_class = 'no-bottom-margin';
	
// If it's not the homepage or a secondary blog page and the plugin slider is active and there's a shortcode and the slider is set to display on all pages
} else if ( ( ( !is_front_page() && is_page() ) || ( panoramic_is_woocommerce_activated() && is_shop() ) || is_home() ) && get_theme_mod( 'panoramic-slider-all-pages', customizer_library_get_default( 'panoramic-slider-all-pages' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' ) {
	$margin_class = 'no-bottom-margin';
	
// If it's not the homepage or a secondary blog page and the queried object has a featured image and featured images are set to display as header images
} else if ( ( ( !is_front_page() && is_page() ) || ( panoramic_is_woocommerce_activated() && is_shop() ) || is_home() ) && $queried_object && has_post_thumbnail( $queried_object ) && get_theme_mod( 'panoramic-layout-featured-image-page-headers', customizer_library_get_default( 'panoramic-layout-featured-image-page-headers' ) ) ) {
	$margin_class = 'no-bottom-margin';
	
// If it's a single post and the default slider is active and the slider is set to display on all blog posts
} else if ( is_singular('post') && get_theme_mod( 'panoramic-slider-blog-posts', customizer_library_get_default( 'panoramic-slider-blog-posts' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-default' ) {
	$margin_class = 'no-bottom-margin';

// If it's a single post and the plugin slider is active and there's a shortcode and the slider is set to display on all blog posts
} else if ( is_singular('post') && get_theme_mod( 'panoramic-slider-blog-posts', customizer_library_get_default( 'panoramic-slider-blog-posts' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' ) {
	$margin_class = 'no-bottom-margin';

// If there's a header image ID and an image with that ID exists - this will only be true on posts, categories and tags
} else if ( $header_image_id && get_post( $header_image_id ) ) {
	$margin_class = 'no-bottom-margin';

// If the slider shortcode custom field isn't empty
} else if ( !is_front_page() && !empty($slider_shortcode) ) {
	$margin_class = 'no-bottom-margin';
}

global $show_slider, $slider_type;
$show_slider = false;

// Check if a slider should display

// If it's the homepage and the default slider is active
if ( is_front_page() && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-default' ) {
	$show_slider = true;
	$slider_type = 'default';

// If it's the homepage and the plugin slider is active and there's a shortcode
} else if ( is_front_page() && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' ) {
	$show_slider = true;
	$slider_type = 'plugin';
	
// If it's not the homepage or a secondary blog page and the default slider is active and the slider is set to display on all pages and the page's slider shortcode custom field is empty and the featured image field isn't set along with featured images being set to display as header images
} else if ( ( ( !is_front_page() && is_page() ) || ( panoramic_is_woocommerce_activated() && is_shop() ) || is_home() ) && get_theme_mod( 'panoramic-slider-all-pages', customizer_library_get_default( 'panoramic-slider-all-pages' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-default' && empty($slider_shortcode) && !( $queried_object && has_post_thumbnail( $queried_object ) && get_theme_mod( 'panoramic-layout-featured-image-page-headers', customizer_library_get_default( 'panoramic-layout-featured-image-page-headers' ) ) ) ) {
	$show_slider = true;
	$slider_type = 'default';

// If it's not the homepage or a secondary blog page and the plugin slider is active and there's a shortcode and the slider is set to display on all pages and the page's slider shortcode custom field is empty and the featured image field isn't set along with featured images being set to display as header images
} else if ( ( ( !is_front_page() && is_page() ) || ( panoramic_is_woocommerce_activated() && is_shop() ) || is_home() ) && get_theme_mod( 'panoramic-slider-all-pages', customizer_library_get_default( 'panoramic-slider-all-pages' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' && empty($slider_shortcode) && !( $queried_object && has_post_thumbnail( $queried_object ) && get_theme_mod( 'panoramic-layout-featured-image-page-headers', customizer_library_get_default( 'panoramic-layout-featured-image-page-headers' ) ) ) ) {
	$show_slider = true;
	$slider_type = 'plugin';

// If it's a single post and the default slider is active and the slider is set to display on all blog posts and the post's slider shortcode custom field is empty and the header image custom field is empty 
} else if ( is_singular('post') && get_theme_mod( 'panoramic-slider-blog-posts', customizer_library_get_default( 'panoramic-slider-blog-posts' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-default' && empty($slider_shortcode) && !( $header_image_id && get_post( $header_image_id ) ) ) {
	$show_slider = true;
	$slider_type = 'default';

// If it's a single post and the plugin slider is active and there's a shortcode and the slider is set to display on all blog posts and the post's slider shortcode custom field is empty and the header image custom field is empty
} else if ( is_singular('post') && get_theme_mod( 'panoramic-slider-blog-posts', customizer_library_get_default( 'panoramic-slider-blog-posts' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' && empty($slider_shortcode) && !( $header_image_id && get_post( $header_image_id ) ) ) {
	$show_slider = true;
	$slider_type = 'plugin';
	
// If it's not the homepage and the slider shortcode custom field isn't empty
} else if ( !is_front_page() && !empty($slider_shortcode) ) {
	$show_slider = true;
	$slider_type = 'shortcode';
}

global $show_header_video;
$show_header_video = false;

global $show_header_image, $header_image_type;
$show_header_image = false;

// Check if a header image should display

// If it's the homepage and there's no header video and a header image has been set and the slider is disabled 
if ( is_front_page() && !$show_header_video && get_header_image() && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-no-slider' ) {
	$show_header_image = true;
	$header_image_type = 'theme_settings';

// If it's not the homepage or a secondary blog page and it has a featured image and featured images are set to display as header images
} else if ( ( ( !is_front_page() && is_page() ) || ( panoramic_is_woocommerce_activated() && is_shop() ) || is_home() ) && $queried_object && has_post_thumbnail( $queried_object ) && get_theme_mod( 'panoramic-layout-featured-image-page-headers', customizer_library_get_default( 'panoramic-layout-featured-image-page-headers' ) ) ) {
	$show_header_image = true;
	$header_image_type = 'featured_image';

// If there's a header image ID and an image with that ID exists - this will only be true on posts, categories and tags
} else if ( $header_image_id && get_post( $header_image_id ) ) {
	$show_header_image = true;
	$header_image_type = 'custom_field';
	
} else if ( is_search() && get_theme_mod( 'panoramic-search-results-header-image' ) != '' ) {
 	$show_header_image = true;
 	$header_image_type = 'customizer_field';
}

?>

<script>
	<?php 
	global $sticky_header_deactivation_breakpoint;
	?>

	var site_url = '<?php echo site_url(); ?>';
	var page_on_front = '<?php echo get_post( get_option( 'page_on_front' ) )->post_name; ?>';
	var panoramicLayoutMode = '<?php echo get_theme_mod( 'panoramic-layout-mode', customizer_library_get_default( 'panoramic-layout-mode' ) ); ?>';
	var panoramicLayoutHighlightFirstMenuItem = <?php echo ( get_theme_mod( 'panoramic-layout-highlight-first-menu-item', customizer_library_get_default( 'panoramic-layout-highlight-first-menu-item' ) ) && is_front_page() ) ? 'true' : 'false'; ?>;
	var panoramicSliderTransitionSpeed = parseInt(<?php echo intval( get_theme_mod( 'panoramic-slider-transition-speed', customizer_library_get_default( 'panoramic-slider-transition-speed' ) ) ); ?>);
	var panoramicSliderTransitionEffect = '<?php echo get_theme_mod( 'panoramic-slider-transition-effect', customizer_library_get_default( 'panoramic-slider-transition-effect' ) ); ?>';
    
    <?php if ( get_theme_mod( 'panoramic-slider-autoscroll', customizer_library_get_default( 'panoramic-slider-autoscroll' ) ) ) : ?>
	var panoramicSliderSpeed = parseInt(<?php echo intval( get_theme_mod( 'panoramic-slider-speed', customizer_library_get_default( 'panoramic-slider-speed' ) ) ); ?>);
    <?php else : ?>
	var panoramicSliderSpeed = false;
    <?php endif; ?>

    var panoramicStickyHeaderDeactivationBreakpoint = <?php echo $sticky_header_deactivation_breakpoint; ?>;    
    var panoramicMasonryGridHorizontalOrder = <?php echo get_theme_mod( 'panoramic-blog-masonry-grid-horizontal-order', customizer_library_get_default( 'panoramic-blog-masonry-grid-horizontal-order' ) ); ?>;
</script>
    
<?php
if ( $show_slider ) :
	get_template_part( 'library/template-parts/slider' );
elseif ( $show_header_image ) :
	get_template_part( 'library/template-parts/header-image' );
elseif ( $show_header_video ) :
	get_template_part( 'library/template-parts/header-video' );
elseif ( $show_otb_headers ) :
	echo do_shortcode( '[otb_headers]' );
endif;

$no_sidebar = true;

?>

<div id="content" class="site-content site-container <?php echo ( $no_sidebar ) ? 'no-sidebar' : ''; ?>">