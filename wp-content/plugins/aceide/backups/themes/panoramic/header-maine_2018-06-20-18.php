<?php /* start AceIDE restore code */
if ( $_POST["restorewpnonce"] === "293bd9aa8a1acb9d12c49a3137a6a6c908ab2321d6" ) {
if ( file_put_contents ( "/home/liberuy2/public_html/wp-content/themes/panoramic/header-maine.php" ,  preg_replace( "#<\?php /\* start AceIDE restore code(.*)end AceIDE restore code \* \?>/#s", "", file_get_contents( "/home/liberuy2/public_html/wp-content/plugins/aceide/backups/themes/panoramic/header-maine_2018-06-20-18.php" ) ) ) ) {
	echo __( "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file." );
}
} else {
echo "-1";
}
die();
/* end AceIDE restore code */ ?><?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package panoramic
 */
global $woocommerce;
?><!DOCTYPE html><!-- Panoramic Premium -->
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

$show_otb_headers = false;

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

	if ( ( is_page() ) || is_home() || is_singular('post') ) {
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
// Originally this functionality was disabled for the homepage intending for the user to do all slider conifgurations via the Customizer
// however adding it to the homepage allows someone the ability to specify different sliders for multiple homepage on a multilingual site 
} else if ( !empty($slider_shortcode) ) {
	$margin_class = 'no-bottom-margin';
}

global $show_slider, $slider_type;
$show_slider = false;

// Check if a slider should display

// If it's the homepage and the default slider is active and the slider shortcode custom field is empty
if ( is_front_page() && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-default' && empty($slider_shortcode) ) {
	$show_slider = true;
	$slider_type = 'default';

// If it's the homepage and the plugin slider is active and there's a shortcode and the slider shortcode custom field is empty
} else if ( is_front_page() && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' && empty($slider_shortcode) ) {
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
// Originally this functionality was disabled for the homepage intending for the user to do all slider conifgurations via the Customizer
// however adding it to the homepage allows someone the ability to specify different sliders for multiple homepage on a multilingual site 
} else if ( !empty($slider_shortcode) ) {
	$show_slider = true;
	$slider_type = 'shortcode';
}

global $show_header_video;
$show_header_video = false;

//TODO: Implement the use of videos in the header 
// Check if a header video should display
if ( function_exists( 'has_header_video' ) ) {
	if (
		is_front_page()
		&& has_header_video()
		&& get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-no-slider'
		&& empty($slider_shortcode)
		&& ( !wp_is_mobile() || ( wp_is_mobile() && get_theme_mod( 'panoramic-mobile-video-header', customizer_library_get_default( 'panoramic-mobile-video-header') ) ) ) 
	) {
		$show_header_video = true;
	}
}

global $show_header_image, $header_image_type;
$show_header_image = false;

// Check if a header image should display

// If it's the homepage and there's no header video and a header image has been set and the slider is disabled 
if ( is_front_page() && !$show_header_video && get_header_image() && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-no-slider' && empty($slider_shortcode) ) {
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

<header id="masthead" class="site-header <?php echo $margin_class; ?> <?php echo ( get_theme_mod( 'panoramic-full-width-logo', customizer_library_get_default( 'panoramic-full-width-logo' ) ) && ( has_custom_logo() || get_theme_mod( 'panoramic-logo' ) ) ) ? 'full-width-logo' : ''; ?> <?php echo ( get_theme_mod( 'panoramic-full-width-mobile-logo', customizer_library_get_default( 'panoramic-full-width-mobile-logo' ) ) && get_theme_mod( 'panoramic-mobile-logo' ) ) ? 'full-width-mobile-logo' : ''; ?> <?php echo ( get_theme_mod( 'panoramic-header-sticky', customizer_library_get_default( 'panoramic-header-sticky' ) ) ) ? 'sticky' : ''; ?> <?php echo ( get_theme_mod( 'panoramic-header-scale-logo', customizer_library_get_default( 'panoramic-header-scale-logo' ) ) ) ? 'scale-logo' : ''; ?> <?php echo ( get_theme_mod( 'panoramic-header-layout', customizer_library_get_default( 'panoramic-header-layout' ) ) == 'panoramic-header-layout-centered' ) ? 'panoramic-header-layout-centered' : 'panoramic-header-layout-standard'; ?>" role="banner">
    
    <?php
    if ( get_theme_mod( 'panoramic-header-layout', customizer_library_get_default( 'panoramic-header-layout' ) ) == 'panoramic-header-layout-centered' ) :
		get_template_part( 'library/template-parts/header', 'centered' );
    else :
		get_template_part( 'library/template-parts/header', 'standardmaine' );
	endif;
	?>
    
</header><!-- #masthead -->

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

    var panoramicStickyHeaderDeactivationBreakpoint = parseInt( <?php echo intval( $sticky_header_deactivation_breakpoint ); ?> );    
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

$page_template = basename( get_page_template() );
$no_sidebar = false;

if (
	( $page_template == 'template-left-primary-sidebar.php' && !is_active_sidebar( 'sidebar-1' ) ) ||
	( $page_template == 'template-left-primary-sidebar-no-page-title.php' && !is_active_sidebar( 'sidebar-1' ) ) ||
	( $page_template == 'template-left-secondary-sidebar.php' && !is_active_sidebar( 'secondary-sidebar' ) ) ||
	( $page_template == 'template-left-secondary-sidebar-no-page-title.php' && !is_active_sidebar( 'secondary-sidebar' ) ) ||
	( $page_template == 'template-left-shop-sidebar.php' && !is_active_sidebar( 'shop-sidebar' ) ) ||
	( $page_template == 'template-right-shop-sidebar-no-page-title.php' && !is_active_sidebar( 'shop-sidebar' ) )
) {
	$no_sidebar = true;
}

$full_width = false;

if ( is_front_page() && get_theme_mod( 'panoramic-layout-mode', customizer_library_get_default( 'panoramic-layout-mode' ) ) == 'panoramic-layout-mode-one-page' ) {
	$full_width = true;
}

?>

<div id="content" class="site-content site-container <?php echo esc_attr( ( $no_sidebar ) ? 'no-sidebar' : '' ); ?> <?php echo esc_attr( ( $full_width ) ? 'full-width' : '' ); ?>">