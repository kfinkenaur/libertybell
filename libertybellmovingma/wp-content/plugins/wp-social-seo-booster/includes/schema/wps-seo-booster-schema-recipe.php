<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
 
/**
 * Set Time
 *
 * Converts the entered minutes in to hours and minutes.
 *
 * @package WPSocial SEO Booster
 * @credit Tammy Hart, ReciPress (http://www.recipress.com)
 * @since 1.0.0
 */
function wps_seo_booster_recipe_time( $minutes, $attr = null ) {

    if( $minutes != '' ) {
		$time = '';
		$hours = '';
		
		if( $minutes > 60 ) {
			$hours = floor( $minutes / 60 );
			$minutes = $minutes - floor( $minutes/60 ) * 60;
		}
		
		if( $attr == 'iso' ) {
			$time = $hours . ':' . $minutes;
			$time = strtotime( $time );
			if( $hours != '' ) $time = 'PT' . $hours . 'H' . $minutes . 'M';
			else $time = 'PT'.$minutes.'M';
		} else {
			$h = __( 'hrs', 'wpsseo' );
			$m = __( 'mins', 'wpsseo' );
			if( $hours < 2 ) $h = __( 'hr', 'wpsseo' );
			if( $minutes < 02 ) $m = __( 'min', 'wpsseo' );
			if( $hours != '' ) $time = $hours . ' ' . $h . ' ' . $minutes . ' ' . $m;
			else $time = $minutes . ' ' . $m;
		} 	
	
		return $time;
	}
}

 
/**
 * Schema.org Recipe
 *
 * Adds the schema.org recipe meta tags to the post.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_schema_recipe( $text ) {

	global $post;
	
	/********** Schema.org Recipes Values **********/	
	$wps_seo_booster_recipe_position = get_post_meta( $post->ID, '_wps_seo_booster_recipe_position', true );
	$wps_seo_booster_recipe_name = get_post_meta( $post->ID, '_wps_seo_booster_recipe_name', true );
	$wps_seo_booster_recipe_image = get_post_meta( $post->ID, '_wps_seo_booster_recipe_image', true );
	$wps_seo_booster_recipe_author = get_post_meta( $post->ID, '_wps_seo_booster_recipe_author', true );
	$wps_seo_booster_recipe_date = get_post_meta( $post->ID, '_wps_seo_booster_recipe_date', true );
	$wps_seo_booster_recipe_summary = get_post_meta( $post->ID, '_wps_seo_booster_recipe_summary', true );
	$wps_seo_booster_recipe_prep = get_post_meta( $post->ID, '_wps_seo_booster_recipe_prep', true );
	$wps_seo_booster_recipe_cooke = get_post_meta( $post->ID, '_wps_seo_booster_recipe_cooke', true );
	$wps_seo_booster_recipe_total = get_post_meta( $post->ID, '_wps_seo_booster_recipe_total', true );
	$wps_seo_booster_recipe_yield = get_post_meta( $post->ID, '_wps_seo_booster_recipe_yield', true );
	$wps_seo_booster_recipe_serving_size = get_post_meta( $post->ID, '_wps_seo_booster_recipe_serving_size', true );
	$wps_seo_booster_recipe_calories = get_post_meta( $post->ID, '_wps_seo_booster_recipe_calories', true );
	$wps_seo_booster_recipe_fat = get_post_meta( $post->ID, '_wps_seo_booster_recipe_fat', true );
	$ingredients_amount = get_post_meta( $post->ID, '_wps_seo_booster_recipe_ingredients_amount', true );
	$ingredients_size = get_post_meta( $post->ID, '_wps_seo_booster_recipe_ingredients_size', true );
	$ingredients = get_post_meta( $post->ID, '_wps_seo_booster_recipe_ingredients', true );
	$wps_seo_booster_recipe_ingredients_directions = get_post_meta( $post->ID, '_wps_seo_booster_recipe_ingredients_directions', true );
	$wps_seo_booster_recipe_rating_title = get_post_meta( $post->ID, '_wps_seo_booster_recipe_rating_title', true );
	$wps_seo_booster_recipe_rating_value = get_post_meta( $post->ID, '_wps_seo_booster_recipe_rating_value', true );
	
	//$ingredients = wps_seo_booster_recipe_ingedients();
	$prep_time_post = get_post_meta( $post->ID, '_wps_seo_booster_recipe_prep', true );
	$cooke_time_post = get_post_meta( $post->ID, '_wps_seo_booster_recipe_cooke', true );
	$total_time_post = get_post_meta( $post->ID, '_wps_seo_booster_recipe_total', true );
	
	$attr = '';
	
	// preparing prep time
	$prep_time = wps_seo_booster_recipe_time( $prep_time_post, $attr );
	
	// preparing cooke time
	$cooke_time = wps_seo_booster_recipe_time( $cooke_time_post, $attr );
	
	// preparing total time
	$total_time = wps_seo_booster_recipe_time( $total_time_post, $attr );
	
	// gets the data for the rating, so that we can add it to the html markup
	$wps_seo_booster_ratings['ratings'] = get_post_meta( $post->ID, '_wps_seo_booster_star_ratings', true );
	$wps_seo_booster_ratings['casts'] = get_post_meta( $post->ID, '_wps_seo_booster_star_casts', true );
	$wps_seo_booster_ratings['ips'] = get_post_meta( $post->ID, '_wps_seo_booster_star_ips', true );
	
	// adds the editor rating, if it exists, to the general rating system
	if( $wps_seo_booster_recipe_rating_value != '' ) {
		$wps_seo_booster_ratings['avg'] = ( ( get_post_meta( $post->ID, '_wps_seo_booster_star_avg', true ) + $wps_seo_booster_recipe_rating_value ) / 2 );
	} else {
		$wps_seo_booster_ratings['avg'] = get_post_meta( $post->ID, '_wps_seo_booster_star_avg', true );
	}
	
	// Percentage
	if( isset( $wps_seo_booster_ratings['casts'] ) && $wps_seo_booster_ratings['casts'] > 0 ) {
		if( $wps_seo_booster_recipe_rating_value != '' ) {
			$wps_seo_booster_ratings['per'] = round( ( ( ( $wps_seo_booster_ratings['ratings'] + $wps_seo_booster_recipe_rating_value ) /( $wps_seo_booster_ratings['casts'] + 1 ) )/5 ) *100 );
		} else {
			$wps_seo_booster_ratings['per'] = round( ( ( $wps_seo_booster_ratings['ratings']/ $wps_seo_booster_ratings['casts'] )/5 ) *100 );
		}
	}
	
	if( $wps_seo_booster_ratings['casts'] == '1' ) {
		$ratings = __( ' rating', 'wpsseo' );
	} else {
		$ratings = __( ' ratings', 'wpsseo' );
	}
	
	// Recipe Content
	$content_recipe = '';
	$content_recipe .= '<div class="wps-seo-booster-recipe-clear"></div><div class="wps-seo-booster-recipe">';
	$content_recipe .= '<div class="hrecipe" itemscope itemtype="http://schema.org/Recipe">';
	
	$content_recipe .= '<span class="item" itemprop="name"><strong class="fn">' . $wps_seo_booster_recipe_name . '</strong></span>';
	
	if( $wps_seo_booster_recipe_author != '' ) {
		$content_recipe .= '<span class="recipe-author author" itemprop="author">' . __( 'By: ', 'wpsseo' ) . $wps_seo_booster_recipe_author . '</span>';
	}
	
	if( $wps_seo_booster_recipe_date != '' ) {
		$content_recipe .= '<span class="recipe-date published" itemprop="datePublished">' . __( 'Published: ', 'wpsseo' ) . $wps_seo_booster_recipe_date . '<span class="value-title" title="' . get_the_time('c') . '"></span></span>';
	}
	
	$content_recipe .= '<span class="recipe-time">';
	
	if( $prep_time != '' ) {
		$content_recipe .= '<span class="preptime"><meta itemprop="prepTime" content="' . wps_seo_booster_recipe_time( $prep_time_post, $attr='iso' ) . '"><strong>' . __( 'Prep time: ', 'wpsseo' ) . '</strong>' . $prep_time . ' <span class="value-title" title="' . wps_seo_booster_recipe_time( $prep_time_post, $attr='iso' ) . '"></span></span>';
	}
	
	if( $cooke_time != '' ) {
		$content_recipe .= '<span class="cooktime"><meta itemprop="cookTime" content="' . wps_seo_booster_recipe_time( $cooke_time_post, $attr='iso' ) . '"><strong>' . __( 'Cook time: ', 'wpsseo' ) . '</strong>' . $cooke_time . ' <span class="value-title" title="' . wps_seo_booster_recipe_time( $cooke_time_post, $attr='iso' ) . '"></span></span>';
	}
	
	if( $total_time != '' ) {
		$content_recipe .= '<span class="duration"><meta itemprop="totalTime" content="' . wps_seo_booster_recipe_time( $total_time_post, $attr='iso' ) . '"><strong>' . __( 'Total time: ', 'wpsseo' ) . '</strong>' . $total_time . '<span class="value-title" title="' . wps_seo_booster_recipe_time( $total_time_post, $attr='iso' ) . '"></span></span>';
	}
	
	$content_recipe .= '</span>';
	
	if( $wps_seo_booster_recipe_image != '' ) {
		$content_recipe .= '<span class="recipe-image"><img class="photo" src="' . $wps_seo_booster_recipe_image . '" itemprop="image" alt="' . $wps_seo_booster_recipe_name . '" title="' . $wps_seo_booster_recipe_name . '"></span>';
	}	
	
	if( $wps_seo_booster_recipe_summary != '' ) {
		$content_recipe .= '<span class="recipe-summary"><strong>' . __( 'Summary', 'wpsseo' ) . '</strong>';
		$content_recipe .= '<span class="recipe summary" itemprop="description">' . $wps_seo_booster_recipe_summary . '</span></span>';
	}
	
	// displays the rating on the html markup
	if( $wps_seo_booster_ratings['casts'] >= '1' ) {
		$content_recipe .= '<div class="review hreview-aggregate" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
		$content_recipe .= '<meta itemprop="itemreviewed" content="' . $wps_seo_booster_recipe_name . '"/>';
	
		if( $wps_seo_booster_recipe_rating_value != '' ) {
			$rating_count = ( $wps_seo_booster_ratings['casts'] + 1 );
		} else {
			$rating_count = $wps_seo_booster_ratings['casts'];
		}
		
		$content_recipe .= '<span class="rating">
								<meta itemprop="ratingValue" content="' . $wps_seo_booster_ratings['avg'] . '" />
								<span class="average">
									<span class="value-title" title="' . $wps_seo_booster_ratings['avg'] . '" ></span>
								</span>
								<span class="count">
									<meta itemprop="reviewCount" content="' . $rating_count . '" />
									<span class="value-title" title="' . $rating_count . '"></span>
								</span>
							</span>';
		$content_recipe .= '</div>';
	} elseif( $wps_seo_booster_recipe_rating_value != '' ) {
		$content_recipe .= '<div class="review hreview-aggregate" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
		$content_recipe .= '<meta itemprop="itemreviewed" content="' . $wps_seo_booster_recipe_name . '"/>';
		$content_recipe .= '<span class="rating">';
		$content_recipe .= '		<meta itemprop="ratingValue" content="' . $wps_seo_booster_recipe_rating_value . '">
								<span class="average">
									<span class="value-title" title="' . $wps_seo_booster_recipe_rating_value . '" ></span>
								</span>';
		$content_recipe .= '		<span class="count">
									<meta itemprop="reviewCount" content="1">
									<span class="value-title" title="1"></span>
								</span>';
		$content_recipe .= '</span>';
		$content_recipe .= '</div>';
	}
		
	if( $ingredients_size != '' ) {
		$content_recipe .= '<ul class="ingredient">';
		$content_recipe .= '<span class="recipe-ingredients">';
		$content_recipe .= '<strong>' . __( 'Ingredients', 'wpsseo' ) . '</strong>';		
		$jj = -1;			
		foreach( $ingredients_size as $ingredient ) {	
			$jj++;		
			$content_recipe .= '<li><span class="amount" itemprop="ingredients">' . $ingredients_amount[$jj] . ' ' . $ingredient . '</span> <span class="name" itemprop="ingredients">' . $ingredients[$jj] . '</span></li>';
		}		
		$content_recipe .= '</span>';
		$content_recipe .= '</ul>';
	}
	
	if( $wps_seo_booster_recipe_ingredients_directions != '' ) {
		$content_recipe .= '<ol class="directions">';
		$content_recipe .= '<span class="recipe-directions">';
		$content_recipe .= '<strong>' . __( 'Directions', 'wpsseo' ) . '</strong>';
		$content_recipe .= '<span class="instructions" itemprop="recipeInstructions">';		
		foreach( $wps_seo_booster_recipe_ingredients_directions as $direction ) {			
			$content_recipe .= '<li>' . $direction . '</li>';			
		}		
		$content_recipe .= '</span>';
		$content_recipe .= '</span>';
		$content_recipe .= '</ol>';	
	}
	
	if( $wps_seo_booster_recipe_yield != '' ) {
		$content_recipe .= '<span class="recipe-yield">';
		$content_recipe .= '<strong>' . __( 'Yield', 'wpsseo' ) . '</strong>';
		$content_recipe .= '<span class="yield" itemprop="recipeYield">' . $wps_seo_booster_recipe_yield . '</span>';
		$content_recipe .= '</span>';
	}
	
	$content_recipe .= '<div class="nutrition" itemprop="nutrition" itemscope itemtype="http://schema.org/NutritionInformation">';
	if( $wps_seo_booster_recipe_serving_size != '' ) {
		$content_recipe .= '<div><strong>' . __( 'Serving size: ', 'wpsseo' ) . '</strong><span class="servingsize" itemprop="servingSize">' . $wps_seo_booster_recipe_serving_size . '</span></div>';
	}
	
	if( $wps_seo_booster_recipe_calories != '' ) {
		$content_recipe .= '<div><strong>' . __( 'Calories per serving: ', 'wpsseo' ) . '</strong><span class="calories" itemprop="calories">' . $wps_seo_booster_recipe_calories . '</span></div>';
	}
	
	if( $wps_seo_booster_recipe_fat != '' ) {
		$content_recipe .= '<div><strong>' . __( 'Fat per serving: ', 'wpsseo' ) . '</strong><span class="fat" itemprop="fatContent">' . $wps_seo_booster_recipe_fat . '</span></div>';
	}
	$content_recipe .= '</div>'; // end nutrition
	
	if( $wps_seo_booster_recipe_rating_value != '' ) {
		$content_recipe .= '<span class="recipe-rating">';
		$content_recipe .= '<strong>' . $wps_seo_booster_recipe_rating_title . '</strong>';
		$content_recipe .= '<span class="recipe-stars"><img src="' . WPS_SEO_BOOSTER_URL . 'includes/images/stars/' . $wps_seo_booster_recipe_rating_value . 'stars.png" alt="' . __( 'Rating', 'wpsseo' ) . '" title="' . __( 'Rating', 'wpsseo' ) . '"></span>';
		$content_recipe .= '</span>';
	}
	
	$content_recipe .= '<div class="wps-seo-booster-recipe-clear"></div>';
	$content_recipe .= '</div><!-- /itemtype Recipe -->';
	$content_recipe .= '</div><!-- .wps-seo-booster-recipe -->';

	if( $wps_seo_booster_recipe_position == 'top' ) {
		return $content_recipe . $text;
	} else {
		return $text . $content_recipe;
	}
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
function wps_seo_booster_schema_add_recipe( $post ) {

	global $post;
	
	$wps_seo_booster_recipe_position = get_post_meta( $post->ID, '_wps_seo_booster_recipe_position', true );
	$wps_seo_booster_recipe_name = get_post_meta( $post->ID, '_wps_seo_booster_recipe_name', true );
	
	if( $wps_seo_booster_recipe_name != '' && !is_home() && is_singular() && $wps_seo_booster_recipe_position != 'shortcode' ) {
		add_filter( "the_content", "wps_seo_booster_schema_recipe", 1 );
	}
}

add_action( 'wp', 'wps_seo_booster_schema_add_recipe' );