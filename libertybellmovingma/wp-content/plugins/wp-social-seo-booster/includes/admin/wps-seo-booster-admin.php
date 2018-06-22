<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register Settings
 *
 * Runs when the admin_init hook fires and registers 
 * the plugin settings with the WordPress settings API.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_init() {
	register_setting( 'wps_seo_booster_plugin_options', 'wps_seo_booster_options', 'wps_seo_booster_validate_options' );
}

/**
 * Add Settings Menu Page
 *
 * Runs when the admin_menu hook fires and adds a new
 * settings page and menu item.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_add_settings_page() {

	global $post;
	
	// plugin settings page
	$wps_seo_booster_admin = add_options_page( __( 'WP Social SEO Booster Settings Page', 'wpsseo' ), __( 'WP Social SEO Booster', 'wpsseo' ), 'manage_options', 'wps-seo-booster-settings', 'wps_seo_booster_settings_page' );
	
	// loads the JavaScript and style sheets needed for the plugin settings screen
	add_action( "admin_print_styles-$wps_seo_booster_admin", 'wps_seo_booster_settings_page_print_styles' );
	add_action( "admin_head-$wps_seo_booster_admin", 'wps_seo_booster_settings_page_load_scripts' );

	$wps_seo_booster_options = get_option( 'wps_seo_booster_options');
	
	/* star rating (added since version 1.3.0) */
	if( isset( $wps_seo_booster_options['enable_rating'] ) && !empty( $wps_seo_booster_options['enable_rating'] ) && $wps_seo_booster_options['enable_rating'] == '1' ) {
		
		//add new field to post/page/custom post listing page
		$all_types = get_post_types( array( 'public'=>true ), 'objects' );
		$all_types = is_array( $all_types ) ? $all_types : array();
		
		foreach( $all_types as $type ) {			
			add_action( 'manage_' . $type->name . '_posts_custom_column', 'wps_seo_booster_manage_custom_column', 10, 2 );
			add_filter( 'manage_edit-' . $type->name . '_columns', 'wps_seo_booster_add_new_columns' );				
		}	
	}
}

/**
 * Settings Page
 *
 * Renders the plugin settings page.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_settings_page() {		
	include_once( WPS_SEO_BOOSTER_ADMIN . '/forms/wps-seo-booster-plugin-settings.php' );
}

/**
 * Rolecheck
 *
 * If the user can't edit plugin options, no use running this plugin.
 *
 * @package WPSocial FB Member Lock
 * @since 1.0.0
 */
function wps_seo_booster_rolescheck() {

	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );

	if ( current_user_can( 'manage_options' ) ) {
			
		// if the user can edit plugin options, let the fun begin!
		add_action( 'admin_menu', 'wps_seo_booster_add_settings_page' ); //
		add_action( 'admin_init', 'wps_seo_booster_init' ); // registers plugin options	
		if( isset( $wps_seo_booster_options['hide_adminbar'] ) && !empty( $wps_seo_booster_options['hide_adminbar'] ) && $wps_seo_booster_options['hide_adminbar'] == '1' ) {
		} else {
			add_action( 'wp_before_admin_bar_render', 'wps_seo_booster_adminbar' ); // adds a plugin link to the admin top menu bar	
			add_action( 'wp_before_admin_bar_render', 'wps_plugins_adminbar' );
		}
		add_action( "admin_enqueue_scripts", 'wps_seo_booster_settings_page_print_scripts' ); // enqueus our java scripts
	}
} 

add_action( 'init', 'wps_seo_booster_rolescheck' );

/**
 * Validation/Sanitization Helper
 *
 * Helper function for the php strip_tags functions.
 * With that the strip_tags does work with arrays too.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_strip_tags_deep( $value ) {
	return is_array( $value ) ?
    array_map( 'strip_tags_deep', $value ) :
    strip_tags( $value );
}

/**
 * Validation/Sanitization
 *
 * Sanitize and validate input fields.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_validate_options( $input ) {
	
	// sanitize text input (strip html tags, and escape characters)
	$input['app_id'] =  wp_filter_nohtml_kses( $input['app_id'] ); 
	$input['user_id'] =  wp_filter_nohtml_kses( $input['user_id'] );
	$input['allways_image'] =  wp_filter_nohtml_kses( $input['allways_image'] );
	$input['default_image'] =  wp_filter_nohtml_kses( $input['default_image'] );
	$input['home_title'] =  wp_filter_nohtml_kses( $input['home_title'] );
	$input['home_description'] =  wp_filter_nohtml_kses( $input['home_description'] );
	$input['home_image'] =  wp_filter_nohtml_kses( $input['home_image'] );
	$input['gplus_publisher'] =  wp_filter_nohtml_kses( $input['gplus_publisher'] );
	$input['cookie_day'] =  wp_filter_nohtml_kses( $input['cookie_day'] );

	return $input;
}

/**
 * Rating Column
 *
 * Adding an extra column to the posts table which
 * includes the rating stars.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
*/
function wps_seo_booster_manage_custom_column( $column_name, $post_id ) {
		
	global $wpdb,$post,$wps_grp_currencies;;
	switch( $column_name ) {
				
		case 'rating':
			$rated_posts['ratings'] = get_post_meta( $post_id, '_wps_seo_booster_star_ratings', true );
			$rated_posts['casts'] = get_post_meta( $post_id, '_wps_seo_booster_star_casts', true );
						
			if( !empty( $rated_posts['ratings'] ) && !empty( $rated_posts['casts'] ) ) {
				$rated_posts['per'] = round( ( ( $rated_posts['ratings']/$rated_posts['casts'] )/5) *100 );
			}
							
			echo '<div class="wps-seo-booster-star-ratings">
					<div class="stars-turned-on"';
						if( !empty( $rated_posts['per'] ) ) {
					 		echo 'style="width: ' . $rated_posts['per'] . '%';
						}
						echo '"> </div>
			  		</div>';
			break;			
	}
}

/**
 * Column Title
 *
 * Adding the title for the custom column.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
*/
function wps_seo_booster_add_new_columns( $new_columns ) {
		
	$new_columns['rating'] = __( 'Rating', 'wpsseo' );
	return $new_columns;
}

/**
 * Flush Rating
 *
 * Does clear all the recived ratings from the selected
 * post types or individual posts.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
*/
function wps_seo_booster_selected_flush_rating() {
	
	if( isset( $_POST['id'] ) && !empty( $_POST['id'] ) ) {
		
		$selected_id = rtrim( $_POST['id'], ",");
		$selected_id = explode( ",", $selected_id );
		foreach ( $selected_id as $value ) {
			delete_post_meta( $value, '_wps_seo_booster_star_ratings' );
			delete_post_meta( $value, '_wps_seo_booster_star_casts' );
			delete_post_meta( $value, '_wps_seo_booster_star_ips' );
			delete_post_meta( $value, '_wps_seo_booster_star_avg' );
		}
		echo "success";
	}
	exit;
}

add_action( 'wp_ajax_selected_flush_rating', 'wps_seo_booster_selected_flush_rating' );
add_action( 'wp_ajax_nopriv_selected_flush_rating', 'wps_seo_booster_selected_flush_rating' );