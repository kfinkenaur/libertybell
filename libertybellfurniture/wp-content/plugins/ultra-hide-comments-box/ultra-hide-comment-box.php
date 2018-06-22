<?php
/*
Plugin Name: Ultra Hide Comment Box
Plugin URI: http://www.skinzee.com/
Description: Ultra Hide Comment Box helps to disable Add Comment box on posts belonging to specific Categories.
Version: 1.1.3
Author: Custom Wordpress Themes
Author URI: http://www.skinzee.com/
*/

/*
All functions are named with the prefix "Ultra Hidey"
*/

global $wpdb;

 /*
 
/* Ultra Hide CONSTANTS */
if (!defined('ULTRA_HIDEY_VERSION')) {
  define('ULTRA_HIDEY_VERSION', "1.0");  
}

if (!defined('ULTRA_HIDEY_DIR')) {
	define('ULTRA_HIDEY_DIR', WP_PLUGIN_DIR . '/' . "ultra-hide-comments-box/");
	}


/* During plugin installation store ultra hide plugin version + add option for storing categories list */
if (!function_exists(ultra_hidey_install)) {
    function ultra_hidey_install() {
      /* Store Ultra Hide Comment Box Version */
      add_option("ultra_hidey_version", ULTRA_HIDEY_VERSION);
      add_option("ultra_hidey_catlist", "");
      }
    }
    
    
/* Remove all data stored by PingAutomatic during plugin deactivation */

if (!function_exists(ultra_hidey_uninstall)) {
    function ultra_hidey_uninstall() {
    /* Remove Ultra Hide Version stored in wp options */
     delete_option("ultra_hidey_version");
     delete_option("ultra_hidey_catlist");
      }
    }
	
/* Add Admin Settings page as Menu */
if (!function_exists(ultra_hidey_settings)) {
    function ultra_hidey_settings() {
     add_menu_page("Ultra Hide Comment Box Settings", "Ultra Hide", "administrator", "ultra-hide-settings-page", "ultra_hidey_show_settings");
      }
    }
    
/* Settings Page for Ultra Hide Plugin */
if (!function_exists(ultra_hidey_show_settings)) {
    function ultra_hidey_show_settings() {
      require(ULTRA_HIDEY_DIR . "includes/main.php");
      }
    }
    
/* Hide Comment Box on post belonging to selected categories picked by the Admin */
if (!function_exists(ultra_hide_disable_comment_box)) {
    function ultra_hide_disable_comment_box($posts) {

    $i = 0;
    foreach ($posts as $post_info) {
      
      /* Find existing Category selection */
      $catg_selections = get_option('ultra_hidey_catlist');
      $this_post_cat = get_the_category($post_info->ID);
      if (is_array($this_post_cat)) {
      $current_cat_id = $this_post_cat[0]->cat_ID;
      }
      
      if (is_array($catg_selections) && in_array($current_cat_id, $catg_selections)) {
      $posts[$i]->comment_status = 'closed';
      }
        elseif($catg_selections == $current_cat_id) {
          $posts[$i]->comment_status = 'closed';
        }
          else {
          return $posts; 
        }
        
           $i++;
        return $posts;
      
      }        
      }
    }    

/* Check Comment posting */
if (!function_exists(comment_posting_checker2)) {
    function comment_posting_checker2($commentdata) {
      
     /* Find existing Category selection */
      $catg_selections = get_option('ultra_hidey_catlist');
      $this_post_cat = get_the_category($commentdata[comment_post_ID]);
      
      
      if (is_array($this_post_cat)) {
      $current_cat_id = $this_post_cat[0]->cat_ID;
      }
      
      if (is_array($catg_selections) && in_array($current_cat_id, $catg_selections)) {
      wp_die("Comments are closed for this post");
      }
        elseif($catg_selections == $current_cat_id) {
          wp_die("Comments are closed for this post");
        }
          else {
          return $commentdata; 
        }
        
          
        return $commentdata;
    }
  }

    
/* Enqueue CSS File */

if (!function_exists(ultra_hidey_add_styles)) {
    function ultra_hidey_add_styles() {
      
      
      if ("ultra-hide-settings-page" != $_GET['page']) {
      return;
      }
      else {
        $style_handle = "ultra-hide-css";
        $style_src = WP_PLUGIN_URL . "/ultra-hide-comments-box/css/default.css";
        wp_register_style($style_handle, $style_src);
        wp_enqueue_style($style_handle);
        }
      }
    }    
    
/* Installation and deinstallation hooks */
register_activation_hook(__FILE__, 'ultra_hidey_install');

register_deactivation_hook(__FILE__, 'ultra_hidey_uninstall');

/*
Hook for adding Admin menu
*/
add_action('admin_menu', 'ultra_hidey_settings');

/* Hook for including Stylesheet */

add_action('admin_print_styles', 'ultra_hidey_add_styles');

/* Hook for disabling Comment Box */
add_filter('the_posts', 'ultra_hide_disable_comment_box', 1, 1);

/* Spammers still post comments even if the Add Comment/ Leave Reply Box is not shown hence check all comments during comment posting */
add_filter('preprocess_comment', 	'comment_posting_checker2', 10, 1);
?>