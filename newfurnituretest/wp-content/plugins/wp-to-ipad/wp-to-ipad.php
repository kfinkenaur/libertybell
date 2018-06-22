<?php
/*
Plugin Name: WP-to-iPad free
Plugin URI: http://wp-to-ipad.kinoa.com/
Author: Kinoa
Author URI: http://www.kinoa.com/
Version: 1.4
Description: With WP-to-iPad you can easily create and publish an iPad magazine with WordPress. Offer your WordPress blog readers an optimized version for iPad with just a few clicks! Opt for the paid version to take advantage of various options to customize your iPad magazine.

*/

define( 'KPAD_PLUGIN_DIR', dirname(__FILE__) );
define( 'KPAD_PLUGIN_URL', plugins_url() . '/' . basename( dirname(__FILE__) ) );
require_once KPAD_PLUGIN_DIR . "/classes/wpti.class.php";
require_once KPAD_PLUGIN_DIR . "/classes/config.class.php";

$config = new Wpti_Config();

$wpti = new Wpti;

