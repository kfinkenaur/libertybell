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

if (!$queried_object) {
	$queried_object = get_queried_object();
}

if ($queried_object) {
	$custom_fields = get_post_custom($queried_object->ID);
	$slider_shortcode = trim($custom_fields["slider_shortcode"][0]);
}

$margin_class = '';

if ( !is_front_page() && !is_single() && get_theme_mod( 'panoramic-slider-all-pages', customizer_library_get_default( 'panoramic-slider-all-pages' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-default' ) {
	$margin_class = 'no-bottom-margin';
} else if ( !is_front_page() && !is_single() && get_theme_mod( 'panoramic-slider-all-pages', customizer_library_get_default( 'panoramic-slider-all-pages' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' ) {
	$margin_class = 'no-bottom-margin';
} else if ( !is_front_page() && !is_single() && $queried_object && has_post_thumbnail( $queried_object ) ) {
	$margin_class = 'no-bottom-margin';
} else if ( !is_front_page() && is_single() && get_theme_mod( 'panoramic-slider-blog-posts', customizer_library_get_default( 'panoramic-slider-blog-posts' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-default' ) {
	$margin_class = 'no-bottom-margin';
} else if ( !is_front_page() && is_single() && get_theme_mod( 'panoramic-slider-blog-posts', customizer_library_get_default( 'panoramic-slider-blog-posts' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' ) {
	$margin_class = 'no-bottom-margin';
} else if ( !empty($slider_shortcode) ) {
	$margin_class = 'no-bottom-margin';
}

global $show_slider, $slider_type;
$show_slider = false;

// Check if a slider should display
if ( is_front_page() && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-default' && empty($slider_shortcode) ) {
	$show_slider = true;
	$slider_type = 'default';
} else if ( is_front_page() && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' && empty($slider_shortcode) ) {
	$show_slider = true;
	$slider_type = 'plugin';
} else if ( !is_front_page() && !is_single() && get_theme_mod( 'panoramic-slider-all-pages', customizer_library_get_default( 'panoramic-slider-all-pages' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-default' && empty($slider_shortcode) ) {
	$show_slider = true;
	$slider_type = 'default';
} else if ( !is_front_page() && !is_single() && get_theme_mod( 'panoramic-slider-all-pages', customizer_library_get_default( 'panoramic-slider-all-pages' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' && empty($slider_shortcode) ) {
	$show_slider = true;
	$slider_type = 'plugin';
} else if ( !is_front_page() && is_single() && get_theme_mod( 'panoramic-slider-blog-posts', customizer_library_get_default( 'panoramic-slider-blog-posts' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-default' && empty($slider_shortcode) ) {
	$show_slider = true;
	$slider_type = 'default';
} else if ( !is_front_page() && is_single() && get_theme_mod( 'panoramic-slider-blog-posts', customizer_library_get_default( 'panoramic-slider-blog-posts' ) ) && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' && empty($slider_shortcode) ) {
	$show_slider = true;
	$slider_type = 'plugin';
} else if ( !empty($slider_shortcode) ) {
	$show_slider = true;
	$slider_type = 'shortcode';
}

global $show_header_image, $header_image_type;
$show_header_image = false;

// Check if a header image should display
if ( is_front_page() && get_header_image() && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-no-slider' ) {
	$show_header_image = true;
	$header_image_type = 'theme_settings';
} else if ( !is_front_page() && !is_single() && $queried_object && has_post_thumbnail( $queried_object ) ) {
	$show_slider = false;
	$show_header_image = true;
	$header_image_type = 'featured_image';
}
?>

<header id="masthead" class="site-header <?php echo $margin_class; ?> <?php echo ( get_theme_mod( 'panoramic-header-sticky', customizer_library_get_default( 'panoramic-header-sticky' ) ) ) ? 'sticky' : ''; ?> <?php echo ( get_theme_mod( 'panoramic-header-scale-logo', customizer_library_get_default( 'panoramic-header-scale-logo' ) ) ) ? 'scale-logo' : ''; ?> <?php echo ( get_theme_mod( 'panoramic-header-layout', customizer_library_get_default( 'panoramic-header-layout' ) ) == 'panoramic-header-layout-centered' ) ? 'panoramic-header-layout-centered' : 'panoramic-header-layout-standard'; ?>" role="banner">
    
    <?php
    if ( get_theme_mod( 'panoramic-header-layout', customizer_library_get_default( 'panoramic-header-layout' ) ) == 'panoramic-header-layout-centered' ) :
		get_template_part( 'library/template-parts/header', 'centered' );
    else :
		get_template_part( 'library/template-parts/header', 'standard' );
	endif;
	?>
    
</header><!-- #masthead -->

<script>
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
</script>
    
	<?php
	if ( $show_slider ) :
		get_template_part( 'library/template-parts/slider' );
	elseif ( $show_header_image ) :
		get_template_part( 'library/template-parts/header-image' );
	elseif ( $show_otb_headers ) :
		echo do_shortcode( '[otb_headers]' );
	endif;
	?>

<div id="content" class="site-content site-container <?php echo ( is_front_page() && get_theme_mod( 'panoramic-layout-mode', customizer_library_get_default( 'panoramic-layout-mode' ) ) == 'panoramic-layout-mode-one-page' ) ? 'full-width' : ''; ?>">