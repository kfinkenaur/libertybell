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
  
if ( stristr( $_SERVER['SERVER_SOFTWARE'], 'apache' ) || stristr( $_SERVER['SERVER_SOFTWARE'], 'litespeed' ) !== false ) {

	// Show an admin notice if .htaccess isn't writable
	function wps_seo_booster_htaccess_writable() {
	
		if ( !is_writable( get_home_path() . '.htaccess' ) ) {
			if ( current_user_can( 'administrator' ) ) {
				add_action( 'admin_notices', create_function( '', "echo '<div class=\"error\"><p>" . sprintf( __( 'Please make sure your <a href="%s">.htaccess</a> file is writable ', 'wpsseo' ), admin_url( 'options-permalink.php' ) ) . "</p></div>';" ) );
			}
		}
	}
	
	// add the contents of h5bp-htaccess into the .htaccess file
	function wps_seo_booster_add_h5bp_htaccess( $content ) {
    
		global $wp_rewrite;
		$home_path = function_exists( 'get_home_path' ) ? get_home_path() : ABSPATH;
		$htaccess_file = $home_path . '.htaccess';
		$mod_rewrite_enabled = function_exists( 'got_mod_rewrite' ) ? got_mod_rewrite() : false;

		if( ( !file_exists( $htaccess_file ) && is_writable( $home_path ) && $wp_rewrite->using_mod_rewrite_permalinks()) || is_writable( $htaccess_file ) ) {
			if ( $mod_rewrite_enabled ) {
				$h5bp_rules = extract_from_markers( $htaccess_file, 'HTML5 Boilerplate' );
					if ( $h5bp_rules === array() ) {
					$filename = dirname(__FILE__) . '/h5bp-htaccess';
					return insert_with_markers( $htaccess_file, 'HTML5 Boilerplate', extract_from_markers( $filename, 'HTML5 Boilerplate' ) );
				}
			}
		}

		return $content;
	}
}

function wps_seo_booster_performance() {

	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );

	if( isset( $wps_seo_booster_options['performace_htaccess'] ) && $wps_seo_booster_options['performace_htaccess'] == '1' ) {
		add_action( 'admin_init', 'wps_seo_booster_htaccess_writable' );
		
		if ( get_option( 'permalink_structure' ) ) {		
			add_action( 'generate_rewrite_rules', 'wps_seo_booster_add_h5bp_htaccess' );
		}
	}
}

add_action( 'init', 'wps_seo_booster_performance' );