<?php
/**
 * Plugin Name: Auto Mobile Theme Switcher
 * Plugin URI:  http://wpextends.sinaapp.com/plugins/auto-mobile-theme-switcher.html
 * Description: Auto Mobile Theme Switcher can change the theme to be displayed according to the detected browser automatically, Make Your Site Mobile/Tablet-Friendly. 
 * Author:      WPExtends Team
 * Version:     1.2.8
 * Author URI:  http://wpextends.sinaapp.com
 */

global $auto_mobile_theme_name;

function auto_mobile_theme_switcher() {
	global $auto_mobile_theme_name;
	
	$options = get_option('wpamts_options');
	if (! empty($options) && wp_is_mobile()) {
		if (auto_mobile_theme_is_tablet() && isset($options['tablet_theme'])) {
			$auto_mobile_theme_name = $options['tablet_theme'];
		} else if (isset($options['mobile_theme'])){
			$auto_mobile_theme_name = $options['mobile_theme'];
		}
		if ($auto_mobile_theme_name) {
			add_filter('stylesheet', 'auto_mobile_theme_switch_style');
			add_filter('template', 'auto_mobile_theme_switch_template');
		}
	}
}

function auto_mobile_theme_switch_style(){
	global $auto_mobile_theme_name;
    $themes = get_themes();	
	foreach ($themes as $theme) {
	  if ($theme['Name'] == $auto_mobile_theme_name) {
	      return $theme['Stylesheet'];
	  }
	}	
	return FALSE;
}

function auto_mobile_theme_switch_template(){
	global $auto_mobile_theme_name;
    $themes = get_themes();
	foreach ($themes as $theme) {
	  if ($theme['Name'] == $auto_mobile_theme_name) {
	      return $theme['Template'];
	  }
	}	
	return FALSE;
}

function auto_mobile_theme_is_tablet() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if ( preg_match( '/(a100|a500|a501|a510|a700|dell streak|et-701|ipad|gt-n7000|gt-p1000|gt-p6200|gt-p6800|gt-p7100|gt-p7310|gt-p7510|lg-v905h|lg-v905r|kindle|rim tablet|sch-i800|silk|sl101|tablet|tf101|tf201|xoom)/i', $user_agent ) ) {
		return TRUE;
	}
	return FALSE;
}

function auto_mobile_theme_switcher_activate() {}

function auto_mobile_theme_switcher_deactivate() {}

register_activation_hook(__FILE__, 'auto_mobile_theme_switcher_activate');
register_deactivation_hook(__FILE__, 'auto_mobile_theme_switcher_deactivate');

auto_mobile_theme_switcher();
include 'auto-mobile-theme-switcher-admin.php';

?>