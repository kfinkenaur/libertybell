<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Author Link
 *
 * Injects author link to the header.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_google_authorship_head() {
	
	$gplus_url = '';
	
	if( is_single() ) {
		global $post;
		$gplus_url = get_the_author_meta( 'google_plus_url', $post->post_author );
	} else if( is_home() || is_front_page() ) {
		$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
		if(  $wps_seo_booster_options['gplus_home'] != '-1' ) {
			$gplus_url = get_the_author_meta( 'google_plus_url', $wps_seo_booster_options['gplus_home'] );
		}
	} 
	
	$gplus_url = apply_filters( 'wps_seo_booster_gplus_url', $gplus_url );

	if( $gplus_url )
		echo '<link rel="author" href="' . $gplus_url . '"/>' . "\n";

}

add_action( 'wp_head', 'wps_seo_booster_google_authorship_head', 0 );

/**
 * Profile Fields
 *
 * Adding an extra fields to the profile page to enter the google plus profile url.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_google_authorship_profile( $user_contactmethods ) {
	
	$google_icon = '<img style="margin-right: 5px;" src="' . WPS_SEO_BOOSTER_URL . 'includes/images/icons/google-plus.png" alt="google plus icon" height="16" /><strong>';
	$user_contactmethods['google_plus_url'] = $google_icon . __( 'WPSocial Google+ Profile URL', 'wpsseo' ). '</strong>';
  
	return $user_contactmethods;  
}

add_action( 'user_contactmethods', 'wps_seo_booster_google_authorship_profile' );

/**
 * Google Plus Publisher
 *
 * Injects a link to the Google+ page to the header.
 * <link rel="publisher" href="https://plus.google.com/ID" />
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_google_publisher_head() {
	
	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
	$gplus_publisher = $wps_seo_booster_options['gplus_publisher'];

	if( is_home() && $gplus_publisher != '' || is_front_page() && $gplus_publisher != '' ) {
		echo '<link rel="publisher" href="' . $gplus_publisher . '"/>' . "\n";	
	}
}

add_action( 'wp_head', 'wps_seo_booster_google_publisher_head', 0 );