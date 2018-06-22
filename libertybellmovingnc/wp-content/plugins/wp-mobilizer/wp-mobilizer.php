<?php
/*
Plugin Name: WP-Mobilizer
Plugin URI: http://www.wp-mobilizer.com
Description: WP-Mobilizer detects over 5,000 mobile devices and displays. You choose the theme you want for devices. Supports most of the mobile platform including iphone, ipad, ipod, windows mobile, parm os, blackberry, android.
Version: 1.0.6
Author: Kilukru Media
Author URI: http://www.kilukrumedia.com
*/


/*
Copyright (C) 2012-2013 Kilukru Media, kilukrumedia.com (info AT kilukrumedia DOT com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * @package WP-Mobilizer
 * @version 1.0
 * @link http://www.wp-mobilizer.com
 */

if ( !session_id() ){ session_start(); } // Start session just in case

if ( ! defined( 'MBLZR_VERSION' ) )
{	define( 'MBLZR_VERSION', '1.0.6' ); }

if ( ! defined( 'MBLZR_VERSION_NUMERIC' ) )
{	define( 'MBLZR_VERSION_NUMERIC', '1006001' ); }

if ( ! defined( 'MBLZR_VERSION_FILETIME' ) )
{	define( 'MBLZR_VERSION_FILETIME', '1382389760' ); } //Set by echo time();

if ( ! defined( 'MBLZR_PLUGIN_DIR' ) )
{	define( 'MBLZR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); }

if ( ! defined( 'MBLZR_PLUGIN_BASENAME' ) )
{	define( 'MBLZR_PLUGIN_BASENAME', plugin_basename( __FILE__ ) ); }

if ( ! defined( 'MBLZR_PLUGIN_DIRNAME' ) )
{	define( 'MBLZR_PLUGIN_DIRNAME', dirname( MBLZR_PLUGIN_BASENAME ) ); }

if ( ! defined( 'MBLZR_PLUGIN_URL' ) )
{	define( 'MBLZR_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); }

if ( ! defined( 'MBLZR_PLUGIN_CSS_URL' ) )
{	define( 'MBLZR_PLUGIN_CSS_URL', MBLZR_PLUGIN_URL . 'css/' ); }
if ( ! defined( 'MBLZR_PLUGIN_IMAGES_URL' ) )
{	define( 'MBLZR_PLUGIN_IMAGES_URL', MBLZR_PLUGIN_URL . 'images/' ); }
if ( ! defined( 'MBLZR_PLUGIN_JS_URL' ) )
{	define( 'MBLZR_PLUGIN_JS_URL', MBLZR_PLUGIN_URL . 'js/' ); }

if ( ! defined( 'MBLZR_URL_FORCE' ) )
{	define( 'MBLZR_URL_FORCE', remove_query_arg( array(
		'mblzr_theme',
		'mblzr_force_theme',
		'mblzr_force_site',
		'mblzr_force_mobile',
		'force_site',
		'force_mobile'
	)) );}
if ( ! defined( 'MBLZR_URL_FORCE_SITE_QUERY' ) )
{	define( 'MBLZR_URL_FORCE_SITE_QUERY', 'force_site' ); }
if ( ! defined( 'MBLZR_URL_FORCE_SITE' ) )
{	define( 'MBLZR_URL_FORCE_SITE', add_query_arg( array(MBLZR_URL_FORCE_SITE_QUERY => 'true'), MBLZR_URL_FORCE) ); }
if ( ! defined( 'MBLZR_URL_FORCE_MOBILE_QUERY' ) )
{	define( 'MBLZR_URL_FORCE_MOBILE_QUERY', 'force_mobile' ); }
if ( ! defined( 'MBLZR_URL_FORCE_MOBILE' ) )
{	define( 'MBLZR_URL_FORCE_MOBILE', add_query_arg( array(MBLZR_URL_FORCE_MOBILE_QUERY => 'true'), MBLZR_URL_FORCE) ); }


if ( ! defined( 'WP_CONTENT_URL' ) )
{	define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' ); }
if ( ! defined( 'WP_ADMIN_URL' ) )
{	define( 'WP_ADMIN_URL', get_option( 'siteurl' ) . '/wp-admin' ); }
if ( ! defined( 'WP_CONTENT_DIR' ) )
{	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' ); }
if ( ! defined( 'WP_PLUGIN_URL' ) )
{	define( 'WP_PLUGIN_URL', WP_CONTENT_URL. DIRECTORY_SEPARATOR . 'plugins' ); }
if ( ! defined( 'WP_PLUGIN_DIR' ) )
{	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'plugins' ); }

/**
 * Options to disabled elements
 */
//MBLZR_DISABLED_FRONTEND_FOOTER_LINK
//MBLZR_DISABLED_FRONTEND_CSS


if ( class_exists( 'WP_Mobilizer' ) ) {
	add_action( 'activation_notice', 'mblzr_class_defined_error' );
	return;
}

//Force elements by requests by the visitor.
if ( isset($_GET['mblzr_theme']) && !empty($_GET['mblzr_theme']) ){
	$_SESSION['mblzr_theme']			= $_GET['mblzr_theme'];
	$_SESSION['mblzr_force_theme']		= false;
	$_SESSION['mblzr_force_mobile']		= false;
	$_SESSION['mblzr_force_site']		= false;
}else if ( isset($_GET['mblzr_force_theme']) && !empty($_GET['mblzr_force_theme']) ){
	$_SESSION['mblzr_force_theme']		= $_GET['mblzr_force_theme'];
	$_SESSION['mblzr_theme']			= false;
	$_SESSION['mblzr_force_mobile']		= false;
	$_SESSION['mblzr_force_site']		= false;
}else if ( ( isset($_GET['mblzr_force_mobile']) /*&& $_GET['mblzr_force_mobile']*/ ) || ( isset($_GET['force_mobile']) /*&& $_GET['force_mobile']*/ ) ){
	$_SESSION['mblzr_force_mobile']		= true;
	$_SESSION['mblzr_force_theme']		= false;
	$_SESSION['mblzr_theme']			= false;
	$_SESSION['mblzr_force_site']		= false;
}else if ( ( isset($_GET['mblzr_force_site']) /*&& $_GET['mblzr_force_site']*/ ) || ( isset($_GET['force_site']) /*&& $_GET['force_site']*/ ) ){
	$_SESSION['mblzr_force_site']		= true;
	$_SESSION['mblzr_force_theme']		= false;
	$_SESSION['mblzr_force_mobile']		= false;
	$_SESSION['mblzr_theme']			= false;
}

// Require functions before Class
require_once( MBLZR_PLUGIN_DIR . 'mblzr_functions.php');
require_once( MBLZR_PLUGIN_DIR . 'mblzr_class.php');

global $mblzr, $mblzr_options, $mblzr_activation;

$mblzr_activation = false;
$mblzr = new WP_Mobilizer();

////checking to see if things need to be updated

register_activation_hook( __FILE__, 'mblzr_activate' );

add_action( 'init', 'mblzr_update_settings_check' );

////end checking to see if things need to be updated


