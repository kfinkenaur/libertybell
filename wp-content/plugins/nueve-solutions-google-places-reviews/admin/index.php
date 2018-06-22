<?php
if ( ! defined( 'ABSPATH' ) ) exit;
require_once(dirname(__FILE__) . '/functions.php');
 function nsgrp_admin_manage_reviews() 
                                  {
                                     global $wpdb;   
	                             @admin::nsgrp_google_reviews_on_pages_int();
                                }
add_action('admin_menu', 'nsgrp_googlereviewsonpages');

function nsgrp_googlereviewsonpages() {
	add_menu_page( 'Google Reviews', 'Google Reviews', 'manage_options', 'Google-Reviews', 'nsgrp_admin_manage_reviews' );
}
?>