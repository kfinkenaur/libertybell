<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Schema.org Video
 *
 * Adds the schema.org video meta tags to the post.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_video( $text ) {

	global $post;
	
	/********** Schema.org Video Values **********/	
	$wps_seo_booster_video_name = get_post_meta( $post->ID, '_wps_seo_booster_video_name', true );
	$wps_seo_booster_video_description = get_post_meta( $post->ID, '_wps_seo_booster_video_description', true );
	$wps_seo_booster_video_image = get_post_meta( $post->ID, '_wps_seo_booster_video_image', true );
	$wps_seo_booster_video_url = get_post_meta( $post->ID, '_wps_seo_booster_video_url', true );
	$wps_seo_booster_video_embed = get_post_meta( $post->ID, '_wps_seo_booster_video_embed', true );
	$wps_seo_booster_video_type = get_post_meta( $post->ID, '_wps_seo_booster_video_type', true );
	
	// Recipe Content after actual post 
	$content_after = '';
	$content_after .= '<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">';
	$content_after .= '<meta itemprop="name" content="' . $wps_seo_booster_video_name . '" />';
	$content_after .= '<meta itemprop="description" content="' . $wps_seo_booster_video_description . '" />';
	$content_after .= '<meta itemprop="thumbnailUrl" content="' . $wps_seo_booster_video_image . '" />';
	$content_after .= '<meta itemprop="contentURL" content="' . $wps_seo_booster_video_url . '"/>';
	if( $wps_seo_booster_video_embed != '' ) {
		$content_after .= '<meta itemprop="embedURL" content="' . $wps_seo_booster_video_embed . '" />';
	}
	$content_after .= '<meta itemprop="uploadDate" content="' . get_the_time('c') . '" />';
	$content_after .= '<meta itemprop="type" content="' . $wps_seo_booster_video_type . '" />';
	$content_after .= '</div>';

	return $text . $content_after;
}

/**
 * Add Schema.org Recipe
 *
 * Adds the schema.org recipe data entered by the user to the post, but
 * only if the recipe name is given.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_add_video( $post ) {

	global $post;
	
	$wps_seo_booster_video_name = get_post_meta( $post->ID, '_wps_seo_booster_video_name', true );
	
	if( $wps_seo_booster_video_name != '' && !is_home() ) {
		add_filter( "the_content", "wps_seo_booster_schema_video" );
	}
}

add_action( 'wp', 'wps_seo_booster_schema_add_video' );