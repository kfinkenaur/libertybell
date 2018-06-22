<?php
/*
Plugin Name: Nueve Solutions - Google Places Reviews
Plugin URI: www.nuevesolutions.com
Description: Display your Google business page reviews on your wordpress pages just by adding a single shortcode. 
Version: 1.1.2
Author: Austin Web Developer
Author URI: www.nuevesolutions.com
*/
?>
<?php
	
   if ( ! defined( 'ABSPATH' ) ) exit; 
   require_once(dirname(__FILE__) . '/functions.php');
   require_once(dirname(__FILE__) . '/admin/index.php');
   require_once(dirname(__FILE__) . '/admin/functions.php');

   /* Register our stylesheet. */
   
  function nsgrp_my_reviews_css() {
                                  
                                  wp_register_style( 'myReviewsStyles', plugins_url('css/reviews.css', __FILE__) );
                                  wp_enqueue_style( 'myReviewsStyles' );
                                }
   	
   add_action( 'wp_enqueue_scripts', 'nsgrp_my_reviews_css' );

  /* To drop the table from database while uninstall the plugin */
  
  function nsgrp_google_reviews_on_pages_uninstall() {
                                                    global $wpdb;	
                                                    $table_name = $wpdb->prefix . 'Google_Reviews_On_Pages';
                                                    $sql = "DROP TABLE ". $table_name;
                                                    $wpdb->query(@$wpdb->prepare($sql));
                                                   }
												   
    /* To create the table in database while install the plugin */
    
   function nsgrp_google_reviews_on_pages_install() {
	                                              global $wpdb;
	                                              $table_name =@$wpdb->prefix . 'Google_Reviews_On_Pages';	
	                                              $charset_collate =@$wpdb->get_charset_collate();
	                                              $sql = "CREATE TABLE $table_name(id int(5) KEY NOT NULL AUTO_INCREMENT,placeid varchar(60),api_key varchar(60))$charset_collate;";
	                                              require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	                                              $wpdb->query(@$wpdb->prepare($sql));
	                                             }

   /* To Display the Google place reviews on front-end pages*/
   	
   function nsgrp_manage_reviews() 
                                  { 
                                     global $wpdb;   
	                             @reviews::nsgrp_google_reviews_on_pages();
                                }
                                
    register_activation_hook( __FILE__, 'nsgrp_google_reviews_on_pages_install' );	
    register_deactivation_hook( __FILE__, 'nsgrp_google_reviews_on_pages_uninstall' );


   /* Creating the short code to display Google place reviews on pages */
   
   add_shortcode( 'reviews', 'nsgrp_manage_reviews');	
   add_filter('widget_text','do_shortcode');


?>