<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Schema.org Software
 *
 * Adds the schema.org software meta tags to the post.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_software( $text ) {

	global $post;
	
	/********** Schema.org Software Values **********/	
	$wps_seo_booster_software_position = get_post_meta( $post->ID, '_wps_seo_booster_software_position', true );
	$wps_seo_booster_software_color = get_post_meta( $post->ID, '_wps_seo_booster_software_color', true );
	$wps_seo_booster_software_fontcolor = get_post_meta( $post->ID, '_wps_seo_booster_software_fontcolor', true );
	$wps_seo_booster_software_name = get_post_meta( $post->ID, '_wps_seo_booster_software_name', true );
	$wps_seo_booster_software_description = get_post_meta( $post->ID, '_wps_seo_booster_software_description', true );
	$wps_seo_booster_software_image = get_post_meta( $post->ID, '_wps_seo_booster_software_image', true );
	$wps_seo_booster_software_author = get_post_meta( $post->ID, '_wps_seo_booster_software_author', true );
	$wps_seo_booster_software_version = get_post_meta( $post->ID, '_wps_seo_booster_software_version', true );
	$wps_seo_booster_software_language = get_post_meta( $post->ID, '_wps_seo_booster_software_language', true );
	$wps_seo_booster_software_system = get_post_meta( $post->ID, '_wps_seo_booster_software_system', true );
	$wps_seo_booster_software_category = get_post_meta( $post->ID, '_wps_seo_booster_software_category', true );
	$wps_seo_booster_software_price = get_post_meta( $post->ID, '_wps_seo_booster_software_price', true );
	$wps_seo_booster_software_currency = get_post_meta( $post->ID, '_wps_seo_booster_software_currency', true );
	$wps_seo_booster_software_rating = get_post_meta( $post->ID, '_wps_seo_booster_software_rating', true );
	$wps_seo_booster_software_rating_author = get_post_meta( $post->ID, '_wps_seo_booster_software_rating_author', true );
	
	if( $wps_seo_booster_software_rating_author == '' ) {
		$review_author = '<a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'" rel="author" class="fn">'. get_the_author() .'</a>';
	} else {
		$review_author = $wps_seo_booster_software_rating_author;
	}
	
	// gets the data for the rating, so that we can add it to the html markup
	$wps_seo_booster_ratings['ratings'] = get_post_meta( $post->ID, '_wps_seo_booster_star_ratings', true );
	$wps_seo_booster_ratings['casts'] = get_post_meta( $post->ID, '_wps_seo_booster_star_casts', true );
	$wps_seo_booster_ratings['ips'] = get_post_meta( $post->ID, '_wps_seo_booster_star_ips', true );
	
	// adds the editor rating, if it exists, to the general rating system
	if( $wps_seo_booster_software_rating != '' ) {
		$wps_seo_booster_ratings['avg'] = ( ( get_post_meta( $post->ID, '_wps_seo_booster_star_avg', true ) + $wps_seo_booster_software_rating ) / 2 );
	} else {
		$wps_seo_booster_ratings['avg'] = get_post_meta( $post->ID, '_wps_seo_booster_star_avg', true );
	}
	
	// Percentage
	if( isset( $wps_seo_booster_ratings['casts'] ) && $wps_seo_booster_ratings['casts'] > 0 ) {
		if( $wps_seo_booster_software_rating != '' ) {
			$wps_seo_booster_ratings['per'] = round( ( ( ( $wps_seo_booster_ratings['ratings'] + $wps_seo_booster_software_rating ) /( $wps_seo_booster_ratings['casts'] + 1 ) )/5 ) *100 );
		} else {
			$wps_seo_booster_ratings['per'] = round( ( ( $wps_seo_booster_ratings['ratings']/ $wps_seo_booster_ratings['casts'] )/5 ) *100 );
		}
	}
	
	if( $wps_seo_booster_ratings['casts'] == '1' ) {
		$ratings = __( ' rating', 'wpsseo' );
	} else {
		$ratings = __( ' ratings', 'wpsseo' );
	}
	
	// Review Content before actual post 
	$content_software = '';
	$content_software .= '<div itemscope itemtype="http://schema.org/SoftwareApplication">';
	$content_software .= '	<div class="wps-seo-booster ' . $wps_seo_booster_software_color . ' wps-font-' . $wps_seo_booster_software_fontcolor . ' wps-seo-booster-software ' . $wps_seo_booster_software_position . '">';
	$content_software .= '<dl>';
	$content_software .= '<dt>' . __( 'Product', 'wpsseo' ) . '';
	$content_software .= '</dt>';
	$content_software .= '<dd>';
	$content_software .= '	<span class="software-name" itemprop="name"><strong>' . $wps_seo_booster_software_name . '</strong></span>';
	$content_software .= '</dd>';
	if( $wps_seo_booster_software_image != '' ) {
		$content_software .= '<dt>' . __( '&nbsp;' ) . '';
		$content_software .= '</dt>';
		$content_software .= '<dd>';
		$content_software .= '	<img itemprop="image" src="' . $wps_seo_booster_software_image . '" />';
		$content_software .= '</dd>';
	}
	if( $wps_seo_booster_software_author != '' ) {
		$content_software .= '<div itemscope itemtype="http://schema.org/Organization">';
		$content_software .= '	<dt>' . __( 'Author', 'wpsseo' ) . '';
		$content_software .= '	</dt>';
		$content_software .= '	<dd>';
		$content_software .= '		<span class="software-author" itemprop="name">' . $wps_seo_booster_software_author . '</span>';
		$content_software .= '	</dd>';
		$content_software .= '</div>';
	}
	if( $wps_seo_booster_software_description != '' ) {
		$content_software .= '<dt>' . __( 'Description', 'wpsseo' ) . '';
		$content_software .= '</dt>';
		$content_software .= '<dd>';
		$content_software .= '	<span class="software-description" itemprop="description">' . $wps_seo_booster_software_description . '</span>';
		$content_software .= '</dd>';
	}
	if( $wps_seo_booster_software_version != '' ) {
		$content_software .= '<dt>' . __( 'Version', 'wpsseo' ) . '';
		$content_software .= '</dt>';
		$content_software .= '<dd>';
		$content_software .= '	<span class="software-version" itemprop="softwareVersion">' . $wps_seo_booster_software_version . '</span>';
		$content_software .= '</dd>';
	}
	if( $wps_seo_booster_software_language != '' ) {
		$content_software .= '<dt>' . __( 'Language', 'wpsseo' ) . '';
		$content_software .= '</dt>';
		$content_software .= '<dd>';
		$content_software .= '	<span class="software-version" itemprop="inLanguage">' . $wps_seo_booster_software_language . '</span>';
		$content_software .= '</dd>';
	}
	if( $wps_seo_booster_software_system != '' ) {
		$content_software .= '<dt>' . __( 'Operating System', 'wpsseo' ) . '';
		$content_software .= '</dt>';
		$content_software .= '<dd>';
		$content_software .= '	<span class="software-version" itemprop="operatingSystems">' . $wps_seo_booster_software_system . '</span>';
		$content_software .= '</dd>';
	}
	if( $wps_seo_booster_software_category != '' ) {
		$content_software .= '<dt>' . __( 'Category', 'wpsseo' ) . '';
		$content_software .= '</dt>';
		$content_software .= '<dd>';
		$content_software .= '	<span class="software-version" itemprop="softwareApplicationCategory">' . $wps_seo_booster_software_category . '</span>';
		$content_software .= '</dd>';
	}
	if( $wps_seo_booster_software_price != '' ) {
		$content_software .= '<dt>' . __( 'Price', 'wpsseo' ) . '';
		$content_software .= '</dt>';
		$content_software .= '<dd>';
		$content_software .= '	<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
		$content_software .= '		<span class="product-price" itemprop="price">' . $wps_seo_booster_software_price . '</span>';
		$content_software .= '		<span itemprop="priceCurrency" content="' . $wps_seo_booster_software_currency . '" />';
		$content_software .= '	</div>'; // end offers
		$content_software .= '</dd>';
	}
	$content_software .= '<dt>' . __( 'Reviewed by', 'wpsseo' ) . '';
	$content_software .= '</dt>';
	$content_software .= '<dd>';
	$content_software .= '		<span itemprop="author">' . $review_author . '</span>';
	$content_software .= '		<meta itemprop="datePublished" content="' . get_the_time('c') . '">';
	$content_software .= '</dd>';
	if( $wps_seo_booster_software_rating != '' ) {
		$content_software .= '<dt>' . __( 'Rating', 'wpsseo' ) . '';
		$content_software .= '</dt>';
		$content_software .= '<dd>';
		// displays the rating on the html markup
		if( $wps_seo_booster_ratings['casts'] >= '1' ) {
			$content_software .= '<span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
		
			if( $wps_seo_booster_software_rating != '' ) {
				$rating_count = ( $wps_seo_booster_ratings['casts'] + 1 );
			} else {
				$rating_count = $wps_seo_booster_ratings['casts'];
			}
			
			$content_software .= '	<meta itemprop="ratingValue" content="' . $wps_seo_booster_ratings['avg'] . '" />';
			$content_software .= '	<meta itemprop="reviewCount" content="' . $rating_count . '" />';
			$content_software .= '</span>';
		} elseif ( $wps_seo_booster_software_rating != '' ) {
			$content_software .= '<span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
			$content_software .= '	<meta itemprop="ratingValue" content="' . $wps_seo_booster_software_rating . '">';
			$content_software .= '	<meta itemprop="reviewCount" content="1" />';
			$content_software .= '</span>'; // end software-rating
		}
		$content_software .= '	<div class="software-rating-value"><img src="' . WPS_SEO_BOOSTER_URL . 'includes/images/stars/' . $wps_seo_booster_software_rating . 'stars.png" />';
		$content_software .= '	</div>'; // end software-rating-value
		$content_software .= '</dd>';
	}
	$content_software .= '</dl>';
	$content_software .= '</div><!-- .wps-seo-booster-review -->';
	$content_software .= '</div><!-- SoftwareApplication -->';

	if( $wps_seo_booster_software_position == 'top' || $wps_seo_booster_software_position == 'top_left' || $wps_seo_booster_software_position == 'top_right' ) {
		return $content_software . $text;
	} elseif( $wps_seo_booster_software_position == 'bottom' ) {
		return $text . $content_software;
	} else {
		return $content_software . $text;
	}
}

add_shortcode( 'wps_seo_booster_software', 'wps_seo_booster_schema_software' );

/**
 * Add Schema.org Software
 *
 * Adds the schema.org software data entered by the user to the post, but
 * only if the product name is given.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_add_software( $post ) {

	global $post;
	
	$wps_seo_booster_software_position = get_post_meta( $post->ID, '_wps_seo_booster_software_position', true );
	$wps_seo_booster_software_name = get_post_meta( $post->ID, '_wps_seo_booster_software_name', true );
	
	if( $wps_seo_booster_software_name != '' && is_singular() && $wps_seo_booster_software_position != 'shortcode' ) {
		add_filter( "the_content", "wps_seo_booster_schema_software", 1 );
	}
}

add_action( 'wp', 'wps_seo_booster_schema_add_software' );