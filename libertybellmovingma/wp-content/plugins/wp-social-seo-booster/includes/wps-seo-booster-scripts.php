<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Enqueuing Styles
 *
 * Loads the required stylesheets for displaying the theme settings page in the WordPress admin section.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_settings_page_print_styles() {

	// loads the required styles for the plugin settings page
	wp_register_style( 'wps-seo-booster-admin', WPS_SEO_BOOSTER_URL . 'includes/css/wps-seo-booster-admin.css', array(), null );
	wp_enqueue_style( 'wps-seo-booster-admin' );
		
	// load the required styles for the meta boxes
	wp_enqueue_style( array( 'thickbox' ) );
}

// adding the admin css to posts for the shortcode popup
add_action( 'admin_print_scripts-post.php', 'wps_seo_booster_settings_page_print_styles' );
add_action( 'admin_print_scripts-post-new.php', 'wps_seo_booster_settings_page_print_styles' );
add_action( 'admin_print_scripts-post-edit.php', 'wps_seo_booster_settings_page_print_styles' );

/**
 * Enqueuing Scripts
 *
 * Loads the JavaScript files required for managing the meta boxes on the theme settings
 * page, which allows users to arrange the boxes to their liking plus all the other java
 * script files needed for the settings page.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_settings_page_print_scripts( $hook_suffix ) {

	if ( $hook_suffix == 'settings_page_wps-seo-booster-settings' ) {
			
		// loads the required scripts for the meta boxes
		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'postbox' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );
	}
}

/**
 * Loading Additional Java Script
 *
 * Loads the JavaScript required for toggling the meta boxes on the theme settings page.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_settings_page_load_scripts() { 

	wp_register_script( 'wps-seo-booster-settings', WPS_SEO_BOOSTER_URL . 'includes/js/wps-seo-booster-settings.js', array( 'jquery' ), null );
	wp_enqueue_script( 'wps-seo-booster-settings' );
		
	?>				
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready( function($) {
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				postboxes.add_postbox_toggles( 'settings_page_wps-seo-booster-settings' );
			});
			//]]>
		</script>
	<?php
}

/**
 * Enqueue Scripts
 *
 * Loads the needed JavaScript file for the tabbed meta box.
 *
 * @package WPSocial Seo Booster
 * @since 1.0.0
 */	
function wps_seo_booster_print_meta_scripts() {
	
	wp_enqueue_script( 'wps-seo-booster-meta', WPS_SEO_BOOSTER_URL . 'includes/js/wps-seo-booster-meta.js', array( 'jquery' ), null );
	wp_enqueue_script( 'wps-seo-booster-meta' );
	wp_localize_script('wps-seo-booster-meta','wps_seo_booster_obj',array('url' => WPS_SEO_BOOSTER_URL));
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
}

add_action( 'load-post.php', 'wps_seo_booster_print_meta_scripts' );
add_action( 'load-post-new.php', 'wps_seo_booster_print_meta_scripts' );

/**
 * Enqueue Styles
 *
 * Loads the css file for the tabbed meta box.
 *
 * @package WPSocial Seo Booster
 * @since 1.0.0
 */	
function wps_seo_booster_print_meta_css() {
	
	wp_register_style( 'wps-seo-booster-meta-style', WPS_SEO_BOOSTER_URL . 'includes/css/wps-seo-booster-meta.css', array(), null );
	wp_enqueue_style( 'wps-seo-booster-meta-style' );
	// does also include the css for the star ratings (admin)
}

add_action( 'admin_print_styles-post.php', 'wps_seo_booster_print_meta_css' );
add_action( 'admin_print_styles-post-new.php', 'wps_seo_booster_print_meta_css' );
add_action( 'admin_print_styles-post-edit.php', 'wps_seo_booster_print_meta_css' );

/**
 * Enqueue Styles
 *
 * Loads the css file for the front end.
 *
 * @package WPSocial Seo Booster
 * @since 1.0.0
 */	
function wps_seo_booster_front_end_print_styles() {

	wp_register_style( 'wps-seo-booster-front', WPS_SEO_BOOSTER_URL . 'includes/css/wps-seo-booster-front.css', array(), null );
	wp_enqueue_style( 'wps-seo-booster-front' );
	// does also include the css for the star ratings (front)
}

add_action( 'wp_print_styles', 'wps_seo_booster_front_end_print_styles' );

/**
 * Enqueue Scripts
 *
 * Loads the java script for the star rating.
 *
 * @package WPSocial Seo Booster
 * @since 1.0.0
 */	
function wps_seo_booster_front_end_print_scripts() {

	wp_register_script( 'wps-seo-booster-front-script', WPS_SEO_BOOSTER_URL . 'includes/js/wps-seo-booster-star-ratings.js', array( 'jquery' ), null );
	wp_localize_script( 'wps-seo-booster-front-script', 'Wps_Seo_Ratings', array( 'successmsg' => __( 'Thanks!', 'wpsseo' ) ) );
	// the script is being enqueued in the file wps-seo-booster-star-rating.php (function: wps_seo_booster_star_rating_content).
}

add_action( 'wp_print_scripts', 'wps_seo_booster_front_end_print_scripts' );