<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Schema.org Product
 *
 * Adds the schema.org product meta tags to the post.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_product( $text ) {

	global $post;
	
	/********** Schema.org Product Values **********/
	$wps_seo_booster_product_name = get_post_meta( $post->ID, '_wps_seo_booster_product_name', true );
	$wps_seo_booster_product_brand = get_post_meta( $post->ID, '_wps_seo_booster_product_brand', true );
	$wps_seo_booster_product_image = get_post_meta( $post->ID, '_wps_seo_booster_product_image', true );
	$wps_seo_booster_product_summary = get_post_meta( $post->ID, '_wps_seo_booster_product_summary', true );
	$wps_seo_booster_product_sku = get_post_meta( $post->ID, '_wps_seo_booster_product_sku', true );
	$wps_seo_booster_product_category = get_post_meta( $post->ID, '_wps_seo_booster_product_category', true );
	$wps_seo_booster_product_price = get_post_meta( $post->ID, '_wps_seo_booster_product_price', true );
	$wps_seo_booster_product_currency = get_post_meta( $post->ID, '_wps_seo_booster_product_currency', true );
	$wps_seo_booster_product_price_sale = get_post_meta( $post->ID, '_wps_seo_booster_product_price_sale', true );
	$wps_seo_booster_product_sale_ends = get_post_meta( $post->ID, '_wps_seo_booster_product_sale_ends', true );
	$wps_seo_booster_product_seller = get_post_meta( $post->ID, '_wps_seo_booster_product_seller', true );
	
	if( $wps_seo_booster_product_price_sale != '' ) {
		$wps_seo_booster_product_price_total = $wps_seo_booster_product_price_sale;
	} else {
		$wps_seo_booster_product_price_total = $wps_seo_booster_product_price;
	}
	
	
	// Product Content before actual post 
	$content_after = '';
	$content_after .= '<div itemscope itemtype="http://data-vocabulary.org/Product">';
	$content_after .= '<span style="visibility: hidden;">';
	$content_after .= '<span itemprop="name" content="' . $wps_seo_booster_product_name . '" /></span>';
	if( $wps_seo_booster_product_brand != '' ) {
		$content_after .= '<meta itemprop="brand" content="' . $wps_seo_booster_product_brand . '" />';
	}
	if( $wps_seo_booster_product_image != '' ) {
		$content_after .= '<meta itemprop="image" content="' . $wps_seo_booster_product_image . '" />';
	}
	if( $wps_seo_booster_product_summary != '' ) {
		$content_after .= '<span itemprop="description" content="' . $wps_seo_booster_product_summary . '"></span>';
	}
	if( $wps_seo_booster_product_category != '' ) {
		$content_after .= '<meta itemprop="category" content="' . $wps_seo_booster_product_category . '" />';
	}
	$content_after .= '<div itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">';
	if( $wps_seo_booster_product_sku != '' ) {
		$content_after .= '<meta itemprop="identifier" content="' . $wps_seo_booster_product_sku . '" />';
	}
	if( $wps_seo_booster_product_price_total != '' ) {
		$content_after .= '<meta itemprop="price" content="' . $wps_seo_booster_product_price_total . '" />';
	}
	if( $wps_seo_booster_product_currency != '' ) {
		$content_after .= '<meta itemprop="currency" content="' . $wps_seo_booster_product_currency . '" />';
	}
	if( $wps_seo_booster_product_sale_ends != '' ) {
		$content_after .= '<meta itemprop="priceValidUntil" content="' . $wps_seo_booster_product_sale_ends . '" />';
	}
	if( $wps_seo_booster_product_seller != '' ) {
		$content_after .= '<meta itemprop="seller" content="' . $wps_seo_booster_product_seller . '" />';
	}
	$content_after .= '<meta itemprop="condition" content="new">';
	$content_after .= '<meta itemprop="availability" content="in_stock">';
	$content_after .= '</div>'; // end offers
	$content_after .= '</span>';
	$content_after .= '</div><!-- product -->';

	return $text . $content_after;
}

/**
 * Add Schema.org Product
 *
 * Adds the schema.org product data entered by the user to the post, but
 * only if the product name is given.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_add_product() {

	global $post;
	
	$wps_seo_booster_product_name = get_post_meta( $post->ID, '_wps_seo_booster_product_name', true );
	
	if( $wps_seo_booster_product_name != '' && !is_home() ) {
		add_filter( "the_content", "wps_seo_booster_schema_product" );
	}
}

add_action( 'wp', 'wps_seo_booster_schema_add_product' );