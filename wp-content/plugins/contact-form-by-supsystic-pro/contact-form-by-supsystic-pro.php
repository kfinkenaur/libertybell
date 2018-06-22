<?php
/**
 * Plugin Name: Contact Form by Supsystic PRO
 * Description: Contact Form by Supsystic PRO version.
 * Plugin URI: https://supsystic.com/
 * Author: supsystic.com
 * Author URI: https://supsystic.com/
 * Version: 1.0.12
 **/
	require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'wpUpdater.php');
	
	register_activation_hook(__FILE__, 'formBySupsysticProActivateCallback');
    register_deactivation_hook(__FILE__, array('modInstallerCfs', 'deactivate'));
    register_uninstall_hook(__FILE__, array('modInstallerCfs', 'uninstall'));
	
	add_filter('pre_set_site_transient_update_plugins', 'checkForPluginUpdateformBySupsysticPro');
    add_filter('plugins_api', 'myPluginApiCallformBySupsysticPro', 10, 3);
    
	if(!function_exists('getProPlugCodeCfs')) {
		function getProPlugCodeCfs() {
			return 'contact_form_by_supsystic_pro';
		}
	}
	if(!function_exists('getProPlugDirCfs')) {
		function getProPlugDirCfs() {
			return basename(dirname(__FILE__));
		}
	}
	if(!function_exists('getProPlugFileCfs')) {
		function getProPlugFileCfs() {
			return basename(__FILE__);
		}
	}
	if(!defined('S_YOUR_SECRET_HASH_'. getProPlugCodeCfs()))
		define('S_YOUR_SECRET_HASH_'. getProPlugCodeCfs(), 'gnhejfbB#G*#(GHG#hgGHGHIHGsioHGDgshghisdg');
	
    if(!function_exists('checkForPluginUpdateformBySupsysticPro')) {
        function checkForPluginUpdateformBySupsysticPro($checkedData) {
            if(class_exists('wpUpdaterCfs')) {
                return wpUpdaterCfs::getInstance( getProPlugDirCfs(), getProPlugFileCfs(), getProPlugCodeCfs() )->checkForPluginUpdate($checkedData);
            }
			return $checkedData;
        }
    }
    if(!function_exists('myPluginApiCallformBySupsysticPro')) {
        function myPluginApiCallformBySupsysticPro($def, $action, $args) {
            if(class_exists('wpUpdaterCfs')) {
                return wpUpdaterCfs::getInstance( getProPlugDirCfs(), getProPlugFileCfs(), getProPlugCodeCfs() )->myPluginApiCall($def, $action, $args);
            }
			return $def;
        }
    }
	/**
	 * Check if there are base (free) version installed
	 */
	if(!function_exists('formBySupsysticProActivateCallback')) {
		function formBySupsysticProActivateCallback() {
			if(class_exists('frameCfs')) {
				$arguments = func_get_args();
				call_user_func_array(array('modInstallerCfs', 'check'), $arguments);
			}
		}
	}
	add_action('admin_notices', 'formBySupsysticProInstallBaseMsg');
	if(!function_exists('formBySupsysticProInstallBaseMsg')) {
		function formBySupsysticProInstallBaseMsg() {
			if(!get_option('cfs_full_installed') || !class_exists('frameCfs')) {
				$plugName = 'Contact Form by Supsystic';
				$plugWpUrl = 'https://wordpress.org/plugins/contact-form-by-supsystic';
				$html = '<div class="error"><p><strong style="font-size: 15px;">
					Please install Free (Base) version of '. $plugName. ' plugin, you can get it <a target="_blank" href="'. $plugWpUrl. '">here</a> or use Wordpress plugins search functionality, 
					activate it, then deactivate and activate again PRO version of '. $plugName. '. 
					In this way you will have full and upgraded PRO version of '. $plugName. '.</strong></p></div>';
				echo $html;
			}
		}
	}