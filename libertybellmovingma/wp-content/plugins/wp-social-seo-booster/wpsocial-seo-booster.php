<?php

/*
Plugin Name: WP Social SEO Booster
Plugin URI: http://wpsocial.com/product/wp-social-seo-booster-pro/
Description: WP Social SEO Booster adds Facebook Open Graph, Twitter Card and Google Rich Snippets to your site to boost your sites search engine visibility.
Author: Daniel Waser
Author URI: http://www.danielwaser.com
Version: 1.1.8
Text Domain: wpsseo
Domain Path: languages

WP Social SEO is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

WP Social SEO is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WP Social SEO. If not, see <http://www.gnu.org/licenses/>.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* PHP Hack to Get Plugin Headers in the .POT File */
$wps_seo_booster_plugin_header_translate = array(
	__( 'WP Social SEO Booster', 'wpsseo' ),
   	__( 'WP Social SEO Booster adds Facebook Open Graph, Twitter Card and Google Rich Snippets to your site to boost your sites search engine visibility.', 'wpsseo' ),
   	__( 'Daniel Waser', 'wpsseo' ),
   	__( 'http://wpsocial.com/', 'wpsseo' ),
);
	
/**
 * Basic Plugin Definitions 
 * 
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
if( !defined( 'WPS_SEO_BOOSTER_VERSION' ) ) {
	define( 'WPS_SEO_BOOSTER_VERSION', '1.1.8' ); // plugin version
}
if( !defined( 'WPS_SEO_BOOSTER_DIR' ) ) {
	define( 'WPS_SEO_BOOSTER_DIR', dirname( __FILE__ ) ); // plugin dir
}
if( !defined( 'WPS_SEO_BOOSTER_URL' ) ) {
	define( 'WPS_SEO_BOOSTER_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}   
if( !defined( 'WPS_SEO_BOOSTER_ADMIN' ) ) {
	define( 'WPS_SEO_BOOSTER_ADMIN', WPS_SEO_BOOSTER_DIR . '/includes/admin' ); // plugin admin dir
}  

/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_load_textdomain() {
  load_plugin_textdomain( 'wpsseo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'wps_seo_booster_load_textdomain' ); 

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'wps_seo_booster_install' );

/**
 * Plugin Setup (On Activation)
 *
 * Does the initial setup, creates tables in the database and
 * stest default values for the plugin options.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_install() {

	global $wpdb;
		
	// set default options
	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
	
	if( empty( $wps_seo_booster_options ) ) {
		$wps_seo_booster_options = array(
			'delete_options' => '',
			'hide_adminbar' => '',
			'performace_header' => '',
			'performace_dashboard' => '',
			'performace_htaccess' => '',
			'enable_opg' => '',
			'app_id' => '',
			'user_id' =>'',
			'allways_image' => '',
			'default_image' => '',
			'content_type' => 'article',
			'home_page' => '',
			'home_title' => '',
			'home_description' => '',
			'home_image' => '',
			'gplus_home' => '',
			'gplus_publisher' => '',
			'placement_rating' => '',		
			'animate_rating' => '',		
			'unique_rating' => '',		
			'unique_base_rating' => '',		
			'cookie_day' => 30
		);
		update_option( 'wps_seo_booster_options', $wps_seo_booster_options );
	}
}

/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, 'wps_seo_booster_uninstall' );

/**
 * Plugin Setup (On Deactivation)
 *
 * Deletes all the plugin options if the user has
 * set the option to do that.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_uninstall() {

	global $wpdb;
	
	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
	
	if( isset( $wps_seo_booster_options['delete_options'] ) && !empty( $wps_seo_booster_options['delete_options'] ) && $wps_seo_booster_options['delete_options'] == '1') {
		delete_option( 'wps_seo_booster_options' );
	}		
}

/**
 * Settings Link
 *
 * Adds a settings link to the plugin list.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_add_settings_link( $links, $file ) {

	static $this_plugin;
	if ( !$this_plugin ) $this_plugin = plugin_basename( __FILE__ );
	if ( $file == $this_plugin ) {
		$settings_link = '<a href="options-general.php?page=wps-seo-booster-settings">' . __( 'Settings', 'wpsseo' ) . '</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}

add_filter( 'plugin_action_links', 'wps_seo_booster_add_settings_link', 10, 2 );

/**
 * WPSocial Admin Bar
 *
 * Add WPSocial options drop down menu to the admin bar.
 * all other plugins will have a submenu in there.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
if ( !function_exists( 'wps_plugins_adminbar' ) ) {
	function wps_plugins_adminbar() {

		global $wp_admin_bar;
	
		$wp_admin_bar->add_menu( array(
			'id' => 'wps_plugins_options',
			'title' => 'WPSocial'
		) );
	}
}

/**
 * WP Social SEO Admin Bar
 *
 * Add Options menu item to Admin Bar.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_adminbar() {

	global $wp_admin_bar;

	$wp_admin_bar->add_menu( array(
		'parent' => 'wps_plugins_options',
		'id' => 'wps_seo_booster_options',
		'title' => __( 'WPSocial SEO Booster Settings', 'wpsseo' ),
		'href' => admin_url( 'options-general.php?page=wps-seo-booster-settings' )
	) );
} 

/**
 * Thumbnail Support
 *
 * Adding thumbnail support for themes which don't support it.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.1
 */
function wps_seo_booster_add_thumbnail_support() {

	if( !current_theme_supports( 'post-thumbnails' ) ) {
		add_theme_support( 'post-thumbnails' );
	}
}

add_action( 'init', 'wps_seo_booster_add_thumbnail_support' );

/**
 * Includes
 *
 * Includes all the needed files for our plugin.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */  
if( is_admin() ) {
	include( WPS_SEO_BOOSTER_DIR . '/includes/metabox/wps-seo-booster-meta.php' ); // including the meta box			
	include( WPS_SEO_BOOSTER_DIR . '/includes/wps-seo-booster-twitter-card.php' ); // including twitter profile id
	include( WPS_SEO_BOOSTER_DIR . '/includes/wps-seo-booster-htaccess.php' ); // including the htaccess rewrite file
} else {
	include( WPS_SEO_BOOSTER_DIR . '/includes/wps-seo-booster-ogp.php' ); // including the open graph functions
	include( WPS_SEO_BOOSTER_DIR . '/includes/schema/wps-seo-booster-schema-review.php' ); // including schema.org review microdata
	include( WPS_SEO_BOOSTER_DIR . '/includes/schema/wps-seo-booster-schema-product.php' ); // including schema.org product microdata
	include( WPS_SEO_BOOSTER_DIR . '/includes/schema/wps-seo-booster-schema-business.php' ); // including schema.org business microdata
	include( WPS_SEO_BOOSTER_DIR . '/includes/schema/wps-seo-booster-schema-person.php' ); // including schema.org person microdata
	include( WPS_SEO_BOOSTER_DIR . '/includes/schema/wps-seo-booster-schema-recipe.php' ); // including schema.org recipe microdata
	include( WPS_SEO_BOOSTER_DIR . '/includes/schema/wps-seo-booster-schema-software.php' ); // including schema.org software microdata
	include( WPS_SEO_BOOSTER_DIR . '/includes/schema/wps-seo-booster-schema-video.php' ); // including schema.org video microdata
	include( WPS_SEO_BOOSTER_DIR . '/includes/schema/wps-seo-booster-schema-event.php' ); // including schema.org event microdata
}
include( WPS_SEO_BOOSTER_DIR . '/includes/admin/wps-seo-booster-admin.php' ); // including plugin admin functions
include( WPS_SEO_BOOSTER_DIR . '/includes/wps-seo-booster-scripts.php' ); // including the java script and css files
include( WPS_SEO_BOOSTER_DIR . '/includes/wps-seo-booster-google-authorship.php' ); // including google authorship
include( WPS_SEO_BOOSTER_DIR . '/includes/wps-seo-booster-star-rating.php' ); // including the star ratings
include( WPS_SEO_BOOSTER_DIR . '/includes/widgets/vcard-widget-business.php' ); // including the business vcard widget
include( WPS_SEO_BOOSTER_DIR . '/includes/widgets/wps-seo-booster-ratings-widget.php' ); // including the star ratings widget
include( WPS_SEO_BOOSTER_DIR . '/includes/wps-seo-booster-cleanup.php' ); // including the cleanup file