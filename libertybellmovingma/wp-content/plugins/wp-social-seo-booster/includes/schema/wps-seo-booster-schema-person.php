<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Schema.org Person
 *
 * Adds the schema.org person meta tags to the post.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_person( $text ) {

	global $post;
	
	/********** Schema.org Person Values **********/	
	$wps_seo_booster_person_position = get_post_meta( $post->ID, '_wps_seo_booster_person_position', true );
	$wps_seo_booster_person_hidden = get_post_meta( $post->ID, '_wps_seo_booster_person_hidden', true );
	$wps_seo_booster_person_name = get_post_meta( $post->ID, '_wps_seo_booster_person_name', true );
	$wps_seo_booster_person_nickname = get_post_meta( $post->ID, '_wps_seo_booster_person_nickname', true );
	$wps_seo_booster_person_street = get_post_meta( $post->ID, '_wps_seo_booster_person_street', true );
	$wps_seo_booster_person_locality = get_post_meta( $post->ID, '_wps_seo_booster_person_locality', true );
	$wps_seo_booster_person_region = get_post_meta( $post->ID, '_wps_seo_booster_person_region', true );
	$wps_seo_booster_person_pc = get_post_meta( $post->ID, '_wps_seo_booster_person_pc', true );
	$wps_seo_booster_person_tel = get_post_meta( $post->ID, '_wps_seo_booster_person_tel', true );
	$wps_seo_booster_person_email = get_post_meta( $post->ID, '_wps_seo_booster_person_email', true );
	$wps_seo_booster_person_job = get_post_meta( $post->ID, '_wps_seo_booster_person_job', true );
	$wps_seo_booster_person_business = get_post_meta( $post->ID, '_wps_seo_booster_person_business', true );
	
	
	// Business Content before actual post 
	$content_person = '';
	$content_person .= '<div class="wps-seo-booster-review">';
	$content_person .= '<span itemscope itemtype="http://schema.org/Person">';
	$content_person .= '<dl>';
	$content_person .= '<dt>' . __( 'My Name', 'wpsseo' ) . '';
	$content_person .= '</dt>';
	$content_person .= '<dd>';
	$content_person .= '<span class="people-name" itemprop="name"><strong>' . $wps_seo_booster_person_name . '</strong></span>';
	$content_person .= '</dd>';
	if( $wps_seo_booster_person_nickname != '' ) {
		$content_person .= '<dt>' . __( 'People call me', 'wpsseo' ) . '';
		$content_person .= '</dt>';
		$content_person .= '<dd>';
		$content_person .= '<span class="people-nickname">' . $wps_seo_booster_person_nickname . '</span>';
		$content_person .= '</dd>';
	}
	$content_person .= '<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
	if( $wps_seo_booster_person_street != '' ) {
		$content_person .= '<dt>' . __( 'Address', 'wpsseo' ) . '';
		$content_person .= '</dt>';
		$content_person .= '<dd>';
		$content_person .= '<span class="people-address" itemprop="streetAddress">' . $wps_seo_booster_person_street . '</span>';
		$content_person .= '</dd>';
	}
	if( $wps_seo_booster_person_locality != '' ) {
		$content_person .= '<dt>' . __( '&nbsp;', 'wpsseo' ) . '';
		$content_person .= '</dt>';
		$content_person .= '<dd>';
		$content_person .= '<span class="people-locality" itemprop="addressLocality">' . $wps_seo_booster_person_locality . '</span>';
		$content_person .= '</dd>';
	}
	if( $wps_seo_booster_person_region != '' ) {
		$content_person .= '<dt>' . __( '&nbsp;', 'wpsseo' ) . '';
		$content_person .= '</dt>';
		$content_person .= '<dd>';
		$content_person .= '<span class="people-region" itemprop="addressRegion">' . $wps_seo_booster_person_region . '</span>';
		$content_person .= '</dd>';
	}
	if( $wps_seo_booster_person_pc != '' ) {
		$content_person .= '<dt>' . __( '&nbsp;', 'wpsseo' ) . '';
		$content_person .= '</dt>';
		$content_person .= '<dd>';
		$content_person .= '<span class="people-pc" itemprop="postalCode">' . $wps_seo_booster_person_pc . '</span>';
		$content_person .= '</dd>';
	}
	$content_person .= '</span>'; // end address
	if( $wps_seo_booster_person_tel != '' ) {
		$content_person .= '<dt>' . __( 'Tel.', 'wpsseo' ) . '';
		$content_person .= '</dt>';
		$content_person .= '<dd>';
		$content_person .= '<span class="people-tel" itemprop="telephone">' . $wps_seo_booster_person_tel . '</span>';
		$content_person .= '</dd>';
	}
	if( $wps_seo_booster_person_email != '' ) {
		$content_person .= '<dt>' . __( 'Email', 'wpsseo' ) . '';
		$content_person .= '</dt>';
		$content_person .= '<dd>';
		$content_person .= '<span class="people-email" itemprop="email">' . $wps_seo_booster_person_email . '</span>';
		$content_person .= '</dd>';
	}
	if( $wps_seo_booster_person_job != '' ) {
		$content_person .= '<dt>' . __( 'Job Title', 'wpsseo' ) . '';
		$content_person .= '</dt>';
		$content_person .= '<dd>';
		$content_person .= '<span class="people-website" itemprop="jobTitle">' . $wps_seo_booster_person_job . '</span>';
		$content_person .= '</dd>';
	}
	if( $wps_seo_booster_person_business != '' ) {
		$content_person .= '<dt>' . __( 'I work for', 'wpsseo' ) . '';
		$content_person .= '</dt>';
		$content_person .= '<dd>';
		$content_person .= '<span class="people-work" itemprop="affiliation">' . $wps_seo_booster_person_business . '</span>';
		$content_person .= '</dd>';
	}
	$content_person .= '</dl>';
	$content_person .= '</span>'; // end person
	$content_person .= '</div>'; // end review
	$content_person .= '<div class="wps-seo-booster-clear"></div>';

	if( $wps_seo_booster_person_position == 'top' ) {
		return $text . $content_person;
	} else {
		return $content_person . $text;
	}
}

/**
 * Add Schema.org Person
 *
 * Adds the schema.org person data entered by the user to the post, but
 * only if the name is given.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_add_person() {

	global $post;
	
	$wps_seo_booster_person_position = get_post_meta( $post->ID, '_wps_seo_booster_person_position', true );
	$wps_seo_booster_person_name = get_post_meta( $post->ID, '_wps_seo_booster_person_name', true );
	
	if( $wps_seo_booster_person_name != '' && !is_home() && $wps_seo_booster_person_position != 'shortcode' ) {
		add_filter( "the_content", "wps_seo_booster_schema_person" );
	}
}

add_action( 'wp', 'wps_seo_booster_schema_add_person' );