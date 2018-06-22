<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Schema.org Review
 *
 * Adds the schema.org review meta tags to the post.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_review( $text ) {

	global $post;
	
	/********** Schema.org Review Values **********/	
	$wps_seo_booster_review_position = get_post_meta( $post->ID, '_wps_seo_booster_review_position', true );
	$wps_seo_booster_review_product_hidden = get_post_meta( $post->ID, '_wps_seo_booster_review_product_hidden', true );
	$wps_seo_booster_review_product_name = get_post_meta( $post->ID, '_wps_seo_booster_review_product_name', true );
	$wps_seo_booster_review_product_type = get_post_meta( $post->ID, '_wps_seo_booster_review_product_type', true );
	$wps_seo_booster_review_product_version = get_post_meta( $post->ID, '_wps_seo_booster_review_product_version', true );
	$wps_seo_booster_review_author = get_post_meta( $post->ID, '_wps_seo_booster_review_author', true );
	$wps_seo_booster_review_date = get_post_meta( $post->ID, '_wps_seo_booster_review_date', true );
	$wps_seo_booster_review_rating_value = get_post_meta( $post->ID, '_wps_seo_booster_review_rating_value', true );
	$wps_seo_booster_review_product_author = get_post_meta( $post->ID, '_wps_seo_booster_review_product_author', true );
	$wps_seo_booster_review_product_link = get_post_meta( $post->ID, '_wps_seo_booster_review_product_link', true );
	$wps_seo_booster_review_product_price = get_post_meta( $post->ID, '_wps_seo_booster_review_product_price', true );
	$wps_seo_booster_review_product_currency = get_post_meta( $post->ID, '_wps_seo_booster_review_product_currency', true );
	$wps_seo_booster_review_summary = get_post_meta( $post->ID, '_wps_seo_booster_review_summary', true );
	
	if( $wps_seo_booster_review_author == '' ) {
		$review_author = '<a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'" rel="author" class="fn">'. get_the_author() .'</a>';
	} else {
		$review_author = $wps_seo_booster_review_author;
	}
	
	if( $wps_seo_booster_review_date == '' ) {
		$review_date = get_the_date();
		$review_date2 = get_the_time('c');
	} else {
		$review_date = $wps_seo_booster_review_date;
		$review_date2 = get_the_time('c');
	}
	
	// gets the data for the rating, so that we can add it to the html markup
	$wps_seo_booster_ratings['ratings'] = get_post_meta( $post->ID, '_wps_seo_booster_star_ratings', true );
	$wps_seo_booster_ratings['casts'] = get_post_meta( $post->ID, '_wps_seo_booster_star_casts', true );
	$wps_seo_booster_ratings['ips'] = get_post_meta( $post->ID, '_wps_seo_booster_star_ips', true );
	$wps_seo_booster_ratings['avg'] = get_post_meta( $post->ID, '_wps_seo_booster_star_avg', true );
	
	// adds the editor rating, if it exists, to the general rating system
	if( $wps_seo_booster_review_rating_value != '' ) {
		$wps_seo_booster_ratings['avg'] = ( ( get_post_meta( $post->ID, '_wps_seo_booster_star_avg', true ) + $wps_seo_booster_review_rating_value ) / 2 );
	} else {
		$wps_seo_booster_ratings['avg'] = get_post_meta( $post->ID, '_wps_seo_booster_star_avg', true );
	}
	
	// Percentage
	if( isset( $wps_seo_booster_ratings['casts'] ) && $wps_seo_booster_ratings['casts'] > 0 ) {
		if( $wps_seo_booster_review_rating_value != '' ) {
			$wps_seo_booster_ratings['per'] = round( ( ( ( $wps_seo_booster_ratings['ratings'] + $wps_seo_booster_review_rating_value ) /( $wps_seo_booster_ratings['casts'] + 1 ) )/5 ) *100 );
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
	$content_reviews = '';
	$content_reviews .= '<div class="wps-seo-booster-clear"></div>';
	$content_reviews .= '<div itemscope itemtype="http://www.schema.org/Product/">';
	// displays the rating on the html markup
	if( $wps_seo_booster_ratings['casts'] >= '1' ) {
		$content_reviews .= '<meta itemprop="name" content="' . $wps_seo_booster_review_product_name . '"/>';
		$content_reviews .= '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
	
		if( $wps_seo_booster_review_rating_value != '' ) {
			$rating_count = ( $wps_seo_booster_ratings['casts'] + 1 );
		} else {
			$rating_count = $wps_seo_booster_ratings['casts'];
		}
		
		$content_reviews .= '	<meta itemprop="ratingValue" content="' . $wps_seo_booster_ratings['avg'] . '" />
								<meta itemprop="reviewCount" content="' . $rating_count . '" />';
		$content_reviews .= '</div>';
	}
	$content_reviews .= '<div itemscope itemtype="http://schema.org/Review">';
	$content_reviews .= '<div class="wps-seo-booster-review ' . $wps_seo_booster_review_position . '">';
	$content_reviews .= '<dl>';
	$content_reviews .= '<dt>' . __( 'Product', 'wpsseo' ) . '';
	$content_reviews .= '</dt>';
	$content_reviews .= '<dd>';
	$content_reviews .= '<span class="product-name" itemprop="itemreviewed"><strong>' . $wps_seo_booster_review_product_name . '</strong></span>';
	$content_reviews .= '</dd>';
	if( $wps_seo_booster_review_product_version != '' ) {
		$content_reviews .= '<dt>' . __( 'Version', 'wpsseo' ) . '';
		$content_reviews .= '</dt>';
		$content_reviews .= '<dd>';
		$content_reviews .= '<span class="product-version">' . $wps_seo_booster_review_product_version . '</span>';
		$content_reviews .= '</dd>';
	}
	if( $wps_seo_booster_review_product_type != '' ) {
		$content_reviews .= '<dt>' . __( 'Type', 'wpsseo' ) . '';
		$content_reviews .= '</dt>';
		$content_reviews .= '<dd>';
		$content_reviews .= '<span class="product-type">' . $wps_seo_booster_review_product_type . '</span>';
		$content_reviews .= '</dd>';
	}
	if( $wps_seo_booster_review_product_author != '' ) {
		$content_reviews .= '<dt>' . __( 'Product Author', 'wpsseo' ) . '';
		$content_reviews .= '</dt>';
		$content_reviews .= '<dd>';
		$content_reviews .= '<span class="product-author"><a href="' . $wps_seo_booster_review_product_link . '" rel="nofollow" target="_blank">' . $wps_seo_booster_review_product_author . '</a></span>';
		$content_reviews .= '</dd>';
	}
	$content_reviews .= '<dt>' . __( 'Reviewed by', 'wpsseo' ) . '';
	$content_reviews .= '</dt>';
	$content_reviews .= '<dd>';
	$content_reviews .= '<span itemprop="author">' . $review_author . '</span><br />' . __( 'on', 'wpsseo' ) . '&nbsp;';
	$content_reviews .= '<span class="date updated">' . $review_date . '</span>';
	$content_reviews .= '<meta itemprop="datePublished" content="' . $review_date2 . '">';
	$content_reviews .= '</dd>';
	$content_reviews .= '<dt>' . __( 'Rating', 'wpsseo' ) . '';
	$content_reviews .= '</dt>';
	$content_reviews .= '<dd>';
	$content_reviews .= '<div class="product-rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">';
	$content_reviews .= '<meta itemprop="worstRating" content = "1">';
	$content_reviews .= '<meta itemprop="ratingValue" content="' . $wps_seo_booster_review_rating_value . '">';
	$content_reviews .= '<meta itemprop="bestRating" content="5">';
	$content_reviews .= '<div class="product-rating-value"><img src="' . WPS_SEO_BOOSTER_URL . 'includes/images/stars/' . $wps_seo_booster_review_rating_value . 'stars.png" />';
	$content_reviews .= '</div>'; // end product-rating-value
	$content_reviews .= '</div>'; // end product-rating
	$content_reviews .= '</dd>';
	if( $wps_seo_booster_review_product_price != '' ) {
		$content_reviews .= '<dt>' . __( 'Price', 'wpsseo' ) . '';
		$content_reviews .= '</dt>';
		$content_reviews .= '<dd>';
		$content_reviews .= '<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
		$content_reviews .= '<span class="product-price" itemprop="price">' . $wps_seo_booster_review_product_price . '</span>';
		$content_reviews .= '<meta itemprop="priceCurrency" content="' . $wps_seo_booster_review_product_currency . '" />';
		$content_reviews .= '<link itemprop="availability" href="http://schema.org/InStock" />';
		$content_reviews .= '</div>'; // end offers
		$content_reviews .= '</dd>';
	}
	$content_reviews .= '</dl>';
	$content_reviews .= '<div class="wps-seo-booster-clear"></div>';
	$content_reviews .= '<div class="review-summary-title">' . __( 'Summary', 'wpsseo' ) . '</div>';
	$content_reviews .= '<div class="review-summary" itemprop="description">' . $wps_seo_booster_review_summary . '</div>';
	$content_reviews .= '</div><!-- .wps-seo-booster-review -->';
	$review_body_before = '';
	$review_body_before .= '<div itemprop="reviewBody">';
	
	// Review content after actual post
	$review_body_end = '';
	$review_body_end .= '</div><!-- reviewBody -->';
	$content_reviews_end = '';
	$content_reviews_end .= '</div><!-- review -->';
	$content_reviews_end .= '</div><!-- product -->';

	if( $wps_seo_booster_review_position == 'top' || $wps_seo_booster_review_position == 'top_left' || $wps_seo_booster_review_position == 'top_right' ) {
		return $content_reviews . $review_body_before . $text . $review_body_end . $content_reviews_end;
	} elseif( $wps_seo_booster_review_position == 'bottom' ) {
		return $review_body_before . $text . $review_body_end . $content_reviews . $content_reviews_end;
	} else {
		return $content_reviews . $review_body_before . $text . $review_body_end . $content_reviews_end;
	}
}

/**
 * Add Schema.org Review
 *
 * Adds the schema.org review data entered by the user to the post, but
 * only if the product name is given.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_add_review( $post ) {

	global $post;
	
	$wps_seo_booster_review_position = get_post_meta( $post->ID, '_wps_seo_booster_review_position', true );
	$wps_seo_booster_review_product_name = get_post_meta( $post->ID, '_wps_seo_booster_review_product_name', true );
	
	if( $wps_seo_booster_review_product_name != '' && !is_home() && $wps_seo_booster_review_position != 'shortcode' ) {
		add_filter( "the_content", "wps_seo_booster_schema_review" );
	}
}

add_action( 'wp', 'wps_seo_booster_schema_add_review' );