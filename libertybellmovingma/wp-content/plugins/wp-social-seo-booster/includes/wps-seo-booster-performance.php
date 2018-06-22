<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * The htaccess.php file does add some url rewriting rules to the .htaccess
 * file plus it add the thml5 boilerplate .htaccess recommendations for better
 * site perfomance.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 * @credit Ben Word (roots theme)
 * @link http://rootstheme.com
 * @license The Unlicense
 * @license URI http://unlicense.org/
 */
 
function wps_seo_booster_performance() {

	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );

	// remove dashboard widgets
	if( isset( $wps_seo_booster_options['performace_dashboard'] ) && $wps_seo_booster_options['performace_dashboard'] == '1' ) {
		add_action( 'admin_init', 'wps_seo_booster_remove_dashboard_widgets' );
	}
	
	// .htaccess file
	if( isset( $wps_seo_booster_options['performace_htaccess'] ) && $wps_seo_booster_options['performace_htaccess'] == '1' ) {
		add_action( 'admin_init', 'wps_seo_booster_htaccess_writable' );
		
		if ( get_option( 'permalink_structure' ) ) {		
			add_action( 'generate_rewrite_rules', 'wps_seo_booster_add_h5bp_htaccess' );
		}
	}
}

add_action( 'init', 'wps_seo_booster_performance' );