<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * The cleanup file is used to use some functions for cleaning up WordPress and
 * adding some fixes for not so nicely behaviors.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 * @credit Ben Word (roots theme)
 * @link http://rootstheme.com
 * @license The Unlicense
 * @license URI http://unlicense.org/
 */
 
/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag and change ''s to "'s on rel_canonical()
 *
 * @since 1.0.0
 */
function wps_seo_booster_head_cleanup() {

	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
	
	if( isset( $wps_seo_booster_options['performace_header'] ) && $wps_seo_booster_options['performace_header'] == '1' ) {

		// http://wpengineer.com/1438/wordpress-header/
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

		global $wp_widget_factory;
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
		
		add_filter( 'the_generator', '__return_false' );	
		add_filter( 'style_loader_tag', 'wps_seo_booster_clean_style_tag' );
		add_filter( 'get_bloginfo_rss', 'wps_seo_booster_remove_default_description' );
	}
}

add_action( 'init', 'wps_seo_booster_head_cleanup' );

/**
 * Cleanup output of stylesheet <link> tags
 *
 * @since 1.0.0
 */
function wps_seo_booster_clean_style_tag( $input ) {

	preg_match_all( "!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches );
	// Only display media if it's print
	$media = $matches[3][0] === 'print' ? ' media="print"' : '';
	return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}

/**
 * Remove unnecessary dashboard widgets
 *
 * @link http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 *
 * @since 1.0.0
 */
function wps_seo_booster_remove_dashboard_widgets() {

	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );

	if( isset( $wps_seo_booster_options['performace_dashboard'] ) && $wps_seo_booster_options['performace_dashboard'] == '1' ) {
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	}
}

add_action( 'admin_init', 'wps_seo_booster_remove_dashboard_widgets' );

/**
 * Don't return the default description in the RSS feed if it hasn't been changed
 *
 * @since 1.0.0
 */
function wps_seo_booster_remove_default_description( $bloginfo ) {
	
	$default_tagline = 'Just another WordPress site';

	return ( $bloginfo === $default_tagline ) ? '' : $bloginfo;
}