<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Profile Fields
 *
 * Adding an extra field to the profile page to enter the twitter user name.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_twitter_card_profile( $user_contactmethods ) {
	
	$twitter_icon = '<img style="margin-right: 5px;" src="' . WPS_SEO_BOOSTER_URL . 'includes/images/icons/twitter.png" alt="twitter icon" height="16" /><strong>';
	$user_contactmethods['twitter_card_user'] = $twitter_icon . __( 'WPSocial Twitter ID', 'wpsseo' ). '</strong>';
  
	return $user_contactmethods;  
}

add_action( 'user_contactmethods', 'wps_seo_booster_twitter_card_profile' );