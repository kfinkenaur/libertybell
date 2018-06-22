<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Schema.org Business
 *
 * Adds the schema.org bsuienss meta tags to the post.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_business( $text ) {

	global $post;
	
	/********** Schema.org Business Values **********/
	$wps_seo_booster_business_position = get_post_meta( $post->ID, '_wps_seo_booster_business_position', true );	
	$wps_seo_booster_business_hidden = get_post_meta( $post->ID, '_wps_seo_booster_business_hidden', true );
	$wps_seo_booster_business_name = get_post_meta( $post->ID, '_wps_seo_booster_business_name', true );
	$wps_seo_booster_business_street = get_post_meta( $post->ID, '_wps_seo_booster_business_street', true );
	$wps_seo_booster_business_locality = get_post_meta( $post->ID, '_wps_seo_booster_business_locality', true );
	$wps_seo_booster_business_region = get_post_meta( $post->ID, '_wps_seo_booster_business_region', true );
	$wps_seo_booster_business_pc = get_post_meta( $post->ID, '_wps_seo_booster_business_pc', true );
	$wps_seo_booster_business_tel = get_post_meta( $post->ID, '_wps_seo_booster_business_tel', true );
	$wps_seo_booster_business_email = get_post_meta( $post->ID, '_wps_seo_booster_business_email', true );
	$wps_seo_booster_business_url = get_post_meta( $post->ID, '_wps_seo_booster_business_url', true );
	
	$content_business = '';
	
	if( $wps_seo_booster_business_position == 'hidden' ) {
	
		// Business Content  
		$content_business .= '<!-- Begin of Schema.org Microdata integration by WPSocial.com SEO Booster plugin -->';
		$content_business .= '	<span itemscope itemtype="http://schema.org/Organization">';
		$content_business .= '		<meta itemprop="name" content="' . $wps_seo_booster_business_name . '">';

		$content_business .= '		<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
		if( $wps_seo_booster_business_street != '' ) {
			$content_business .= '		<meta itemprop="streetAddress" content="' . $wps_seo_booster_business_street . '">';
		}
		if( $wps_seo_booster_business_locality != '' ) {
			$content_business .= '		<meta itemprop="addressLocality" content="' . $wps_seo_booster_business_locality . '">';
		}
		if( $wps_seo_booster_business_region != '' ) {
			$content_business .= '		<meta itemprop="addressRegion" content="' . $wps_seo_booster_business_region . '">';
		}
		if( $wps_seo_booster_business_pc != '' ) {
			$content_business .= '		<meta itemprop="postalCode" content="' . $wps_seo_booster_business_pc . '">';
		}
		$content_business .= '		</span>'; // end address
		if( $wps_seo_booster_business_tel != '' ) {
			$content_business .= '	<meta itemprop="telephone" content="' . $wps_seo_booster_business_tel . '">';
		}
		if( $wps_seo_booster_business_email != '' ) {
			$content_business .= '	<meta itemprop="email" content="' . $wps_seo_booster_business_email . '">';
		}
		if( $wps_seo_booster_business_url != '' ) {
			$content_business .= '	<meta itemprop="url" content="' . $wps_seo_booster_business_url . '">';
		}
		$content_business .= '	</span>';
		$content_business .= '<!-- End of Schema.org Microdata integration by WPSocial.com SEO Booster plugin -->';	
		
		return $text . $content_business;
	
	} else {	
	
		// Business Content  
		$content_business .= '<div class="wps-seo-booster-review">';
		$content_business .= '<span itemscope itemtype="http://schema.org/Organization">';
		$content_business .= '<dl>';
		$content_business .= '<dt>' . __( 'Name', 'wpsseo' ) . '';
		$content_business .= '</dt>';
		$content_business .= '<dd>';
		$content_business .= '<span class="business-name" itemprop="name"><strong>' . $wps_seo_booster_business_name . '</strong></span>';
		$content_business .= '</dd>';
		$content_business .= '<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
		if( $wps_seo_booster_business_street != '' ) {
			$content_business .= '<dt>' . __( 'Address', 'wpsseo' ) . '';
			$content_business .= '</dt>';
			$content_business .= '<dd>';
			$content_business .= '<span class="business-address" itemprop="streetAddress">' . $wps_seo_booster_business_street . '</span>';
			$content_business .= '</dd>';
		}
		if( $wps_seo_booster_business_locality != '' ) {
			$content_business .= '<dt>' . __( '&nbsp;', 'wpsseo' ) . '';
			$content_business .= '</dt>';
			$content_business .= '<dd>';
			$content_business .= '<span class="business-locality" itemprop="addressLocality">' . $wps_seo_booster_business_locality . '</span>';
			$content_business .= '</dd>';
		}
		if( $wps_seo_booster_business_region != '' ) {
			$content_business .= '<dt>' . __( '&nbsp;', 'wpsseo' ) . '';
			$content_business .= '</dt>';
			$content_business .= '<dd>';
			$content_business .= '<span class="business-region" itemprop="addressRegion">' . $wps_seo_booster_business_region . '</span>';
			$content_business .= '</dd>';
		}
		if( $wps_seo_booster_business_pc != '' ) {
			$content_business .= '<dt>' . __( '&nbsp;', 'wpsseo' ) . '';
			$content_business .= '</dt>';
			$content_business .= '<dd>';
			$content_business .= '<span class="business-pc" itemprop="postalCode">' . $wps_seo_booster_business_pc . '</span>';
			$content_business .= '</dd>';
		}
		$content_business .= '</span>'; // end address
		if( $wps_seo_booster_business_tel != '' ) {
			$content_business .= '<dt>' . __( 'Tel.', 'wpsseo' ) . '';
			$content_business .= '</dt>';
			$content_business .= '<dd>';
			$content_business .= '<span class="business-tel" itemprop="telephone">' . $wps_seo_booster_business_tel . '</span>';
			$content_business .= '</dd>';
		}
		if( $wps_seo_booster_business_email != '' ) {
			$content_business .= '<dt>' . __( 'Email', 'wpsseo' ) . '';
			$content_business .= '</dt>';
			$content_business .= '<dd>';
			$content_business .= '<span class="business-email" itemprop="email">' . $wps_seo_booster_business_email . '</span>';
			$content_business .= '</dd>';
		}
		if( $wps_seo_booster_business_url != '' ) {
			$content_business .= '<dt>' . __( 'Website', 'wpsseo' ) . '';
			$content_business .= '</dt>';
			$content_business .= '<dd>';
			$content_business .= '<span class="business-website" itemprop="url">' . $wps_seo_booster_business_url . '</span>';
			$content_business .= '</dd>';
		}
		$content_business .= '</dl>';
		$content_business .= '</span>'; // end organization
		$content_business .= '</div>';
		$content_business .= '<div class="wps-seo-booster-clear"></div>';

		if( $wps_seo_booster_business_position == 'top' ) {
			return $content_business . $text;
		} else {
			return $text . $content_business;
		}
	}
}

/**
 * Add Schema.org Business
 *
 * Adds the schema.org business data entered by the user to the post, but
 * only if the business name is given.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_add_business() {

	global $post;
	
	$wps_seo_booster_business_position = get_post_meta( $post->ID, '_wps_seo_booster_business_position', true );
	$wps_seo_booster_business_name = get_post_meta( $post->ID, '_wps_seo_booster_business_name', true );
	
	if( $wps_seo_booster_business_name != '' && !is_home() && $wps_seo_booster_business_position != 'shortcode' ) {
		add_filter( "the_content", "wps_seo_booster_schema_business" );
	}
}

add_action( 'wp', 'wps_seo_booster_schema_add_business' );