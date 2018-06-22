<?php

/**
 * Plugin Name: Slider by Supsystic PRO
 * Description: Slider by Supsystic plugin - the ultimate slideshow solution. Create stunning image and video sliders with professional templates and options.
 * Version: 1.3.8
 * Author: supsystic.com
 * Author URI: http://supsystic.com
 **/

require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'wpUpdater.php');
//require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'SupsysticSliderUpdater.php');

function _supsysticSliderNotice()
{
    include dirname(__FILE__) . '/resources/notice.php';
}

/**
 * Registers the Slider by Supsystic PRO.
 * @param Rsc_Environment $env
 */
function _registerSupsysticSliderPro($env)
{
    $license = null;
    $prefix = 'SupsysticSliderPro';
    $path   = dirname(__FILE__) . '/src';

    // Add config variables
    $config = $env->getConfig();
    $config->add('pro_modules_prefix', $prefix);
    $config->add('pro_modules_path', $path);
    $config->add('plugin_product_code', 'slider_by_supsystic_pro');

    // Add PRO modules to the class loader.
    $loader = $env->getLoader();
    $loader->add($prefix, $path);

    // Get list of the current modules.
    $resolver = $env->getResolver();
    $modules  = $resolver->getModulesList();

    if (is_dir($dir = $path . '/' . $prefix . '/License')) {
        $className = $prefix . '_' . basename($dir) . '_Module';

        if (!class_exists($className)) {
            if ($env->isPluginPage()) {
                wp_die ('Cannot locate license module.');
            }

            return;
        }

        $license = new $className($env, $dir, $prefix);
        $modules->add('license', $license);
    }

    if ($license->isActive()) {
        // Get list of the PRO modules.
        $nodes = glob($path . '/' . $prefix . '/*');

        if ($nodes === false || count($nodes) === 0) {
            return;
        }

        // If we need to replace free module - replace it.
        foreach ($nodes as $node) {
            $node = str_replace('\\', '/', $node);

            if (is_dir($node) && file_exists($module = $node . '/Module.php')) {
                $className = $prefix . '_' . basename($node) . '_Module';
                $name = strtolower(basename(dirname($module)));
                $free = $modules[$name];
                $location = $free instanceof Rsc_Mvc_Module ? $free->getLocation() : $node;
                $modules[$name] = new $className($env, $location, $prefix);
            }
        }

        // Replace old list of the modules with new.
        $resolver->setModulesList($modules);
        $config->add('is_pro', true);
    }

    if (!defined('S_YOUR_SECRET_HASH_'. $config->get('plugin_product_code') . 'PRO')) {
        define(
            'S_YOUR_SECRET_HASH_'. $config->get('plugin_product_code') . 'PRO',
            'WjJGc2JHVnllUzFpZVMxemRYQnplWE4wYVdNZ1VGSlBJSEJzZFdkcGJnPT0='
        );
    }

    remove_action('admin_notices', '_supsysticSliderNotice');

    /*$updater = new SupsysticSliderUpdater();
    $updater->setDirectory(basename(dirname(__FILE__)));
    $updater->setEnvironment($env);
    $updater->setFile(basename(__FILE__));
    $updater->setProductCode($config->get('plugin_product_code'));

    $updater->subscribe();*/
}
function _setCapabilitySupsysticSlider($cap) {
	$alowedRoles = array();
	$settings = get_option('ss_settings'); // db prefix here
	if ($settings) {
		$alowedRoles = $settings['access_roles'];
	}
	if (!isset($_COOKIE[LOGGED_IN_COOKIE])) {
		return $cap;
	}

	$cookie = $_COOKIE[LOGGED_IN_COOKIE];
	$cookie_elements = explode('|', $cookie);
	$login = array_shift($cookie_elements);
	$userdata = WP_User::get_data_by('login', $login);

	$current_user = new WP_User;
	$current_user->init($userdata);
	if ($current_user) {
		foreach ($current_user->roles as $role) {
			if (in_array($role, $alowedRoles)) {
				$cap = 'read';
			}
		}
	}
	return $cap;
}

add_action('ssl_plugin_loaded', '_registerSupsysticSliderPro');
add_action('admin_notices', '_supsysticSliderNotice');
add_filter('ssl_menu_capability', '_setCapabilitySupsysticSlider');

add_filter('pre_set_site_transient_update_plugins', 'checkForPluginUpdatesliderBySupsysticPro');
add_filter('plugins_api', 'myPluginApiCallsliderBySupsysticPro', 10, 3);

if(!function_exists('getProPlugCodeSsl')) {
	function getProPlugCodeSsl() {
		return 'slider_by_supsystic_pro';
	}
}
if(!function_exists('getProPlugDirSsl')) {
	function getProPlugDirSsl() {
		return basename(dirname(__FILE__));
	}
}
if(!function_exists('getProPlugFileSsl')) {
	function getProPlugFileSsl() {
		return basename(__FILE__);
	}
}
if(!defined('S_YOUR_SECRET_HASH_'. getProPlugCodeSsl()))
	define('S_YOUR_SECRET_HASH_'. getProPlugCodeSsl(), 'NjkyMzViYzQ1YzkxNjNlZmRjMjUzYWFlNTgyMjQ5NmE=');

if(!function_exists('checkForPluginUpdatesliderBySupsysticPro')) {
	function checkForPluginUpdatesliderBySupsysticPro($checkedData) {
		if(class_exists('wpUpdaterSsl')) {
			return wpUpdaterSsl::getInstance( getProPlugDirSsl(), getProPlugFileSsl(), getProPlugCodeSsl() )->checkForPluginUpdate($checkedData);
		}
		return $checkedData;
	}
}
if(!function_exists('myPluginApiCallsliderBySupsysticPro')) {
	function myPluginApiCallsliderBySupsysticPro($def, $action, $args) {
		//var_dump($checkedData); exit();
		if(class_exists('wpUpdaterSsl')) {
			return wpUpdaterSsl::getInstance( getProPlugDirSsl(), getProPlugFileSsl(), getProPlugCodeSsl() )->myPluginApiCall($def, $action, $args);
		}
		return $def;
	}
}