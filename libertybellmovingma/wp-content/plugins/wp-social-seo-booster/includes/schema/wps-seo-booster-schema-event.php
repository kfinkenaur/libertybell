<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Schema.org Event
 *
 * Adds the schema.org event meta tags to the post.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_event( $text ) {

	global $post;
	
	/********** Schema.org Event Values **********/
	$wps_seo_booster_event_name = get_post_meta( $post->ID, '_wps_seo_booster_event_name', true );
	$wps_seo_booster_event_image = get_post_meta( $post->ID, '_wps_seo_booster_event_image', true );
	$wps_seo_booster_event_description = get_post_meta( $post->ID, '_wps_seo_booster_event_description', true );
	$wps_seo_booster_event_date_start = get_post_meta( $post->ID, '_wps_seo_booster_event_date_start', true );
	$wps_seo_booster_event_date_end = get_post_meta( $post->ID, '_wps_seo_booster_event_date_end', true );
	$wps_seo_booster_event_location = get_post_meta( $post->ID, '_wps_seo_booster_event_location', true );
	$wps_seo_booster_event_location_street = get_post_meta( $post->ID, '_wps_seo_booster_event_location_street', true );
	$wps_seo_booster_event_location_locality = get_post_meta( $post->ID, '_wps_seo_booster_event_location_locality', true );
	$wps_seo_booster_event_location_region = get_post_meta( $post->ID, '_wps_seo_booster_event_location_region', true );
	$wps_seo_booster_event_type = get_post_meta( $post->ID, '_wps_seo_booster_event_type', true );
	$wps_seo_booster_event_ticket_price = get_post_meta( $post->ID, '_wps_seo_booster_event_ticket_price', true );
	$wps_seo_booster_event_ticket_price_low = get_post_meta( $post->ID, '_wps_seo_booster_event_ticket_price_low', true );
	$wps_seo_booster_event_ticket_price_high = get_post_meta( $post->ID, '_wps_seo_booster_event_ticket_price_high', true );
	$wps_seo_booster_event_ticket_price_currency = get_post_meta( $post->ID, '_wps_seo_booster_event_ticket_price_currency', true );
	$wps_seo_booster_event_ticket_count = get_post_meta( $post->ID, '_wps_seo_booster_event_ticket_count', true );
	$wps_seo_booster_event_ticket_url = get_post_meta( $post->ID, '_wps_seo_booster_event_ticket_url', true );
	
	
	// Event Content before actual post 
	$content_after = '';
	$content_after .= '<span style="visibility: hidden;">';
	$content_after .= '<span itemscope itemtype="http://data-vocabulary.org/Event">';
	$content_after .= '<meta itemprop="summary" content="' . $wps_seo_booster_event_name . '" />';
	$content_after .= '<meta itemprop="photo" content="' . $wps_seo_booster_event_image . '" />';
	$content_after .= '<meta itemprop="description" content="' . $wps_seo_booster_event_description . '" />';
	$content_after .= '<meta itemprop="startDate" content="' . $wps_seo_booster_event_date_start . '">';
	$content_after .= '<meta itemprop="endDate" content="' . $wps_seo_booster_event_date_end . '">';
	$content_after .= '<span itemprop="location" itemscope itemtype="http://data-vocabulary.org/Organization">';
	$content_after .= '<span itemprop="name" content="' . $wps_seo_booster_event_location . '"></span>';
	$content_after .= '<span itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">';
	$content_after .= '<meta itemprop="street-address" content="' . $wps_seo_booster_event_location_street . '" />';
	$content_after .= '<meta itemprop="locality" content="' . $wps_seo_booster_event_location_locality . '" />';
	$content_after .= '<meta itemprop="region" content="' . $wps_seo_booster_event_location_region . '" />';
	$content_after .= '</span>'; // end address
	$content_after .= '</span>'; // end organization
	$content_after .= '<meta itemprop="eventType" content="' . $wps_seo_booster_event_type . '" />';
	$content_after .= '<span itemprop="ticketAggregate" itemscope itemtype="http://data-vocabulary.org/Offer-aggregate">';
	$content_after .= '<meta itemprop="lowPrice" content="' . $wps_seo_booster_event_ticket_price_low . '" />';
	$content_after .= '<meta itemprop="highPrice" content="' . $wps_seo_booster_event_ticket_price_high . '" />';
	$content_after .= '<meta itemprop="currency" content="' . $wps_seo_booster_event_ticket_price_currency . '" />';
	$content_after .= '<meta itemprop="offerCount" content="' . $wps_seo_booster_event_ticket_count . '" />';
	$content_after .= '</span>'; // end offer-aggregate
	$content_after .= '<span itemprop="tickets" itemscope itemtype="http://data-vocabulary.org/Offer">';
	$content_after .= '<meta itemprop="price" content="' . $wps_seo_booster_event_ticket_price_low . '" />';
	$content_after .= '<meta itemprop="currency" content="' . $wps_seo_booster_event_ticket_price_currency . '" />';
	$content_after .= '</span>'; // end offer
	$content_after .= '</span><!-- event -->';
	$content_after .= '</span>'; // end hidden

	return $text . $content_after;
}

/**
 * Add Schema.org Event
 *
 * Adds the schema.org event data entered by the user to the post, but
 * only if the event name is given.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_add_event() {

	global $post;
	
	$wps_seo_booster_event_name = get_post_meta( $post->ID, '_wps_seo_booster_event_name', true );
	
	if( $wps_seo_booster_event_name != '' && !is_home() ) {
		add_filter( "the_content", "wps_seo_booster_schema_event" );
	}
}

add_action( 'wp', 'wps_seo_booster_schema_add_event' );