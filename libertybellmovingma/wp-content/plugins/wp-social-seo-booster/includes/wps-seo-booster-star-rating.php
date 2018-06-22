<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Star Rating
 *
 * Adds a star rating to the content.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 * @credit: http://wakeusup.com/2011/05/kk-star-ratings/
 */
function wps_seo_booster_star_rating_content() {
		
	global $post;
	$rating_content = '';
	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );

	// gets the data for the rating, so that we can add it to the html markup
	$wps_seo_booster_ratings['ratings'] = get_post_meta( $post->ID, '_wps_seo_booster_star_ratings', true );
	$wps_seo_booster_ratings['casts'] = get_post_meta( $post->ID, '_wps_seo_booster_star_casts', true );
	$wps_seo_booster_ratings['ips'] = get_post_meta( $post->ID, '_wps_seo_booster_star_ips', true );
	$wps_seo_booster_ratings['avg'] = get_post_meta( $post->ID, '_wps_seo_booster_star_avg', true );
	
	// Percentage
	if( isset( $wps_seo_booster_ratings['casts'] ) && $wps_seo_booster_ratings['casts'] > 0 && !empty( $wps_seo_booster_ratings['casts'] ) ) {
		$wps_seo_booster_ratings['per'] = round( ( ( $wps_seo_booster_ratings['ratings']/$wps_seo_booster_ratings['casts'])/5 ) *100 );
	}
	
	if( $wps_seo_booster_ratings['casts'] == '1' ) {
		$ratings = __( ' rating', 'wpsseo' );
	} else {
		$ratings = __( ' ratings', 'wpsseo' );
	}
	
	$wps_seo_booster_recipe_name = get_post_meta( $post->ID, '_wps_seo_booster_recipe_name', true );
	$wps_seo_booster_review_product_name = get_post_meta( $post->ID, '_wps_seo_booster_review_product_name', true );
	$wps_seo_booster_software_name = get_post_meta( $post->ID, '_wps_seo_booster_software_name', true );
	
	// check if the admin has activated the star rating	
	if( isset( $wps_seo_booster_options['enable_rating'] ) && !empty( $wps_seo_booster_options['enable_rating'] ) && $wps_seo_booster_options['enable_rating'] ) {
	
		$params = array();
		$params['path'] = WPS_SEO_BOOSTER_URL;
		
		// check the placement for the stars
		$placement_setting = get_post_meta( $post->ID,'_wps_seo_booster_placement', true );
		
		if( isset( $placement_setting ) && !empty( $placement_setting ) ) {
			$params['pos'] = $placement_setting;
		} else {
			$params['pos'] = isset( $wps_seo_booster_options['placement_rating'] ) ? $wps_seo_booster_options['placement_rating'] : '';
		}
		
		wp_enqueue_script( 'wps-seo-booster-front-script' );
			
		wp_localize_script( 'wps-seo-booster-front-script', 'star_ratings', $params );
			
		wp_localize_script( 'wps-seo-booster-front-script', 'ajaxurl', admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ) );
	}
		
	$rating_content .= '
			<div id="wps-seo-booster-' . $post->ID . '" class="wps-seo-booster-star-ratings open ' . $params['pos'] . '"><span style="display:none;" id="' . get_the_ID() . '"></span><div class="seo-booster-stars-turned-on">&nbsp;</div><div class="seo-booster-hover-panel"><a href="javascript:void();" rel="star-1"></a><a href="javascript:void();" rel="star-2"></a><a href="javascript:void();" rel="star-3"></a><a href="javascript:void();" rel="star-4"></a><a href="javascript:void();" rel="star-5"></a></div><div class="seo-booster-casting-desc">';
					
			// displays the rating on the html markup
			if( ( $wps_seo_booster_recipe_name == '' ) && ( $wps_seo_booster_review_product_name == '' ) && ( $wps_seo_booster_software_name == '' ) ) {
				if( $wps_seo_booster_ratings['casts'] >= '1' ) {
					$rating_content .= '<div class="wps-seo-booster-rating-clear">
											<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
												<meta itemprop="ratingValue" content="' . $wps_seo_booster_ratings['avg'] . '"><meta itemprop="ratingCount" content="' . $wps_seo_booster_ratings['casts'] . '">
											</div>
										</div>';
				}
			} else {

			}
			
	$rating_content .= '</div><!--.seo-booster-casting-desc-->';
	
	$rating_content .='	<div class="seo-booster-casting-thanks" style="display:none;"></div>';

	$rating_content .='	</div><!--.wps-seo-booster-star-ratings-->';
			
	return $rating_content;
}

/**
 * Star Rating Content
 *
 * Adds the star rating to the content, beased on user's choice.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_filter_content( $content )	{

	global $post;
		
	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
	$home_setting = isset( $wps_seo_booster_options['need_home_rating'] ) ? $wps_seo_booster_options['need_home_rating'] : ''; 
	$enable_post_rating = get_post_meta( $post->ID, '_wps_seo_booster_enable_rating_post', true );
	
	if( !is_admin() && isset( $wps_seo_booster_options['enable_rating'] ) && !empty( $wps_seo_booster_options['enable_rating'] ) && $wps_seo_booster_options['enable_rating'] ) {
			 
		$all_types = get_post_types( array( 'public'=>true ), 'objects' );
		$all_types = is_array( $all_types ) ? $all_types : array();
			
		foreach( $all_types as $type ) {
				
			if( $type->name != 'attachment' ) {
			
				$prevent = get_option( 'wps_seo_booster_options' );
			
				if( !empty( $prevent['prevent_rating_type'] ) ) {
					$prevent_type = $prevent['prevent_rating_type'];
				} else {
					$prevent_type = '';
				}
							
				if( !empty( $prevent['prevent_rating_item_' . $post->post_type] ) ) {
					$prevent_items = $prevent['prevent_rating_item_' . $post->post_type];
				} else {
					$prevent_items = '';
				}
							
				$prevent_type = is_array( $prevent_type ) ? $prevent_type : array();
				$prevent_items = is_array( $prevent_items ) ? $prevent_items : array();	
					
				if( ( in_array( $post->post_type, $prevent_type ) && is_singular() ) || ( in_array( $post->ID, $prevent_items ) && is_singular() ) || ( ( $home_setting ) &&  ( in_array( $post->post_type, $prevent_type ) && ( is_front_page() || is_home() ) ) ) || ( ( $home_setting ) &&  ( in_array( $post->ID, $prevent_items ) && ( is_front_page() || is_home() ) ) ) || ( $enable_post_rating == 'on' ) || ( ( $home_setting ) &&  ( $enable_post_rating == 'on' ) && ( is_front_page() || is_home() ) ) ) {
							
					remove_shortcode( 'wps_ratings' );
					$content = str_replace( '[wps_ratings]', '', $content );
					$placement_setting = get_post_meta( $post->ID, '_wps_seo_booster_placement', true );
							
					if( !empty( $placement_setting ) ) {		
						$position = $placement_setting;
					} else {
						$position = $wps_seo_booster_options['placement_rating'];
					}
							
					$markup = wps_seo_booster_star_rating_content( $content );
							
					switch( $position ) {
						case 'top-left' : return $markup . $content;
						case 'top-right' : return $markup . $content;
						case 'bottom-left' : return $content . $markup;
						case 'bottom-right' : return $content . $markup;
						default : return $markup . $content;
					}
				}
			}
		}
	}
		return $content;
}

add_filter( 'the_content', 'wps_seo_booster_filter_content' );

/**
 * Star Rating Shortcode
 *
 * Adds a shortcode for a custom placement of the star rating.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.2
 */
function wps_seo_booster_rating_shortcode( $atts, $content = null )	{

	extract( shortcode_atts( array(	
	    'position' => 'left'  
	), $atts ) );
	
	global $post;
	$rating_content = '';

	// gets the data for the rating, so that we can add it to the html markup
	$wps_seo_booster_ratings['ratings'] = get_post_meta( $post->ID, '_wps_seo_booster_star_ratings', true );
	$wps_seo_booster_ratings['casts'] = get_post_meta( $post->ID, '_wps_seo_booster_star_casts', true );
	$wps_seo_booster_ratings['ips'] = get_post_meta( $post->ID, '_wps_seo_booster_star_ips', true );
	$wps_seo_booster_ratings['avg'] = get_post_meta( $post->ID, '_wps_seo_booster_star_avg', true );
	
	// Percentage
	if( isset( $wps_seo_booster_ratings['casts'] ) && $wps_seo_booster_ratings['casts'] > 0 && !empty( $wps_seo_booster_ratings['casts'] ) ) {
		$wps_seo_booster_ratings['per'] = round( ( ( $wps_seo_booster_ratings['ratings']/$wps_seo_booster_ratings['casts'])/5 ) *100 );
	}
	
	if( $wps_seo_booster_ratings['casts'] == '1' ) {
		$ratings = __( ' rating', 'wpsseo' );
	} else {
		$ratings = __( ' ratings', 'wpsseo' );
	}
	
	$wps_seo_booster_recipe_name = get_post_meta( $post->ID, '_wps_seo_booster_recipe_name', true );
	$wps_seo_booster_review_product_name = get_post_meta( $post->ID, '_wps_seo_booster_review_product_name', true );
	$wps_seo_booster_software_name = get_post_meta( $post->ID, '_wps_seo_booster_software_name', true );
	
	$params = array();
	$params['path'] = WPS_SEO_BOOSTER_URL;
				
	wp_enqueue_script( 'wps-seo-booster-front-script' );
			
	wp_localize_script( 'wps-seo-booster-front-script', 'star_ratings', $params );
			
	wp_localize_script( 'wps-seo-booster-front-script', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
		
	$rating_content .= '<div id="wps-seo-booster-' . $post->ID . '" class="wps-seo-booster-star-ratings open ' . $position . '">';
	$rating_content .= '<span style="display:none;" id="' . get_the_ID() . '">&nbsp;</span>';
	$rating_content .= '<div class="seo-booster-stars-turned-on">&nbsp;</div>';
	$rating_content .= '<div class="seo-booster-hover-panel">';
	$rating_content .= '<a href="javascript:void();" rel="star-1"></a>';
	$rating_content .= '<a href="javascript:void();" rel="star-2"></a>';
	$rating_content .= '<a href="javascript:void();" rel="star-3"></a>';
	$rating_content .= '<a href="javascript:void();" rel="star-4"></a>';
	$rating_content .= '<a href="javascript:void();" rel="star-5"></a></div>';
	$rating_content .= '<div class="seo-booster-casting-desc">';
	
			// displays the rating on the html markup
			if( ( $wps_seo_booster_recipe_name == '' ) && ( $wps_seo_booster_review_product_name == '' ) && ( $wps_seo_booster_software_name == '' ) ) {
				if( $wps_seo_booster_ratings['casts'] >= '1' ) {
					$rating_content .= '<div class="wps-seo-booster-rating-clear">
											<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
												<meta itemprop="ratingValue" content="' . $wps_seo_booster_ratings['avg'] . '"><meta itemprop="ratingCount" content="' . $wps_seo_booster_ratings['casts'] . '">
											</div>
										</div>';
				}
			} else {

			}
			
	$rating_content .= '</div><!--.seo-booster-casting-desc-->';
	
	$rating_content .='	<div class="seo-booster-casting-thanks" style="display:none;"></div>'; //

	$rating_content .='	</div><!--.wps-seo-booster-star-ratings-->';
			
	return $rating_content;
}

add_shortcode( 'wps_ratings', 'wps_seo_booster_rating_shortcode' );
	
/**
 * Star Rating Ajax
 *
 * Handles all the ajax function for the star ratings.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_get_data() {
		
	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
	
	$userip = $_SERVER['REMOTE_ADDR'];
	$post_Id = $_POST['id'];
	
	$wps_seo_booster_ratings['ratings'] = get_post_meta( $post_Id, '_wps_seo_booster_star_ratings', true ) ? get_post_meta( $post_Id, '_wps_seo_booster_star_ratings', true ) : false;
	$wps_seo_booster_unique_setting = get_post_meta( $post_Id, '_wps_seo_booster_unique', true );
	$wps_seo_booster_unique_base_setting = get_post_meta( $post_Id, '_wps_seo_booster_unique_base', true );
	
	$wps_seo_booster_recipe_name = get_post_meta( $post_Id, '_wps_seo_booster_recipe_name', true );
	$wps_seo_booster_review_product_name = get_post_meta( $post_Id, '_wps_seo_booster_review_product_name', true );
	$wps_seo_booster_software_name = get_post_meta( $post_Id, '_wps_seo_booster_software_name', true );
	
	if( isset( $post_Id ) && ( ( !strcmp( $_POST['op'], 'get' ) || $wps_seo_booster_ratings['ratings'] ) || ( !strcmp( $_POST['op'], 'put' ) && isset( $_POST['stars'] ) ) ) ) {
		
		if( !strcmp( $_POST['op'], 'put' ) ) {

			if( $wps_seo_booster_ratings['ratings'] ) {
				$wps_seo_booster_ratings['casts'] = get_post_meta( $post_Id, '_wps_seo_booster_star_casts', true );
				$wps_seo_booster_ratings['ips'] = get_post_meta( $post_Id, '_wps_seo_booster_star_ips', true );
				update_post_meta( $post_Id, '_wps_seo_booster_star_ratings', $wps_seo_booster_ratings['ratings'] + $_POST['stars'] );
				update_post_meta( $post_Id, '_wps_seo_booster_star_casts', $wps_seo_booster_ratings['casts'] + 1 );
					
				$unique_ip = explode( '|',$wps_seo_booster_ratings['ips'] );	
				if( !( in_array( $userip, $unique_ip ) ) ) {
					update_post_meta( $post_Id, '_wps_seo_booster_star_ips', $wps_seo_booster_ratings['ips'].'|'.$userip );		
				}
				
				$total_rating = get_post_meta( $post_Id, '_wps_seo_booster_star_casts', true );
				$rating = get_post_meta( $post_Id, '_wps_seo_booster_star_ratings', true );
				if( isset( $total_rating ) && !empty( $total_rating ) && $total_rating ) {
					update_post_meta( $post_Id, '_wps_seo_booster_star_avg', round( $rating / $total_rating,2 ) );
				}
			} else {
				update_post_meta( $post_Id, '_wps_seo_booster_star_ratings', $_POST['stars'] );
				update_post_meta( $post_Id, '_wps_seo_booster_star_casts', 1 );
				update_post_meta( $post_Id, '_wps_seo_booster_star_avg', $_POST['stars'] );
				
				if( $wps_seo_booster_unique_setting ) {				
					if( isset( $wps_seo_booster_unique_base_setting ) && empty( $wps_seo_booster_unique_base_setting ) ) {					
						update_post_meta( $post_Id, '_wps_seo_booster_star_ips', $userip );
					}						
				} else {					
					if( isset( $wps_seo_booster_options['unique_rating'] ) && $wps_seo_booster_options['unique_rating'] == '1' ) {
						if( isset( $wps_seo_booster_options['unique_base_rating'] ) && !empty( $wps_seo_booster_options['unique_base_rating'] ) && $wps_seo_booster_options['unique_base_rating'] == '1' ) {								
							update_post_meta( $post_Id, '_wps_seo_booster_star_ips', $userip );
						}
					}
				}
			}
				
			if( $wps_seo_booster_unique_setting ) {				
				if( isset( $wps_seo_booster_unique_base_setting ) && !empty( $wps_seo_booster_unique_base_setting ) && $wps_seo_booster_unique_setting == '1' ) {						
					if( isset( $wps_seo_booster_options['cookie_day'] ) && !empty( $wps_seo_booster_options['cookie_day'] ) && empty( $_COOKIE['wps_seo_booster_rating_'.$post_Id] ) ) {							
						setcookie( 'wps_seo_booster_rating_'.$post_Id, "1", time()+60*60*24*intval( $wps_seo_booster_options['cookie_day'] ), "/" ); // setCookie
					}
				}
			} else {					
				if( isset( $wps_seo_booster_options['unique_rating'] ) && $wps_seo_booster_options['unique_rating'] == '1' ) {					
					if( isset( $wps_seo_booster_options['unique_base_rating'] ) && !empty( $wps_seo_booster_options['unique_base_rating'] ) && $wps_seo_booster_options['unique_base_rating'] == '1' ) {						
						if( isset( $wps_seo_booster_options['cookie_day'] ) && !empty( $wps_seo_booster_options['cookie_day'] ) && empty( $_COOKIE['wps_seo_booster_rating_'.$post_Id] ) ) {				
							setcookie( 'wps_seo_booster_rating_'.$post_Id, "1", time()+60*60*24*intval( $wps_seo_booster_options['cookie_day'] ), "/" ); // setCookie								
						}
					}
				}
			}
		}
			
		$Ip = array();
		$wps_seo_booster_ratings['ratings'] = get_post_meta( $post_Id, '_wps_seo_booster_star_ratings', true );
		$wps_seo_booster_ratings['casts'] = get_post_meta( $post_Id, '_wps_seo_booster_star_casts', true );
		$wps_seo_booster_ratings['ips'] = get_post_meta( $post_Id, '_wps_seo_booster_star_ips', true );
		$wps_seo_booster_ratings['avg'] = get_post_meta( $post_Id, '_wps_seo_booster_star_avg', true );
			
		// Percentage
		if( isset( $wps_seo_booster_ratings['casts'] ) && !empty( $wps_seo_booster_ratings['casts'] ) && $wps_seo_booster_ratings['casts'] ) {
			$wps_seo_booster_ratings['per'] = round( ( ( $wps_seo_booster_ratings['ratings']/$wps_seo_booster_ratings['casts'])/5 ) *100 );
		}
			
		// Can user rate?
		$Ip = explode( '|',$wps_seo_booster_ratings['ips'] );	
		
		if( $wps_seo_booster_unique_setting ) {				
			if( $wps_seo_booster_unique_setting == '1' ) {					
				if( isset( $wps_seo_booster_unique_base_setting ) && empty( $wps_seo_booster_unique_base_setting ) ) {						
					$wps_seo_booster_ratings['open'] = ( in_array( $userip, $Ip ) ) ? 'no' : 'yes';						
				} else if( isset( $wps_seo_booster_unique_base_setting ) && !empty( $wps_seo_booster_unique_base_setting ) && $wps_seo_booster_unique_base_setting == '1' ) {							
					if( isset( $wps_seo_booster_options['cookie_day'] ) && !empty( $wps_seo_booster_options['cookie_day'] ) && !empty( $_COOKIE['wps_seo_booster_rating_'.$post_Id] ) && $_COOKIE['wps_seo_booster_rating_'.$post_Id] == '1' ) {							
						$wps_seo_booster_ratings['open'] = 'no'; // if cookie is set.
					} else {				
						$wps_seo_booster_ratings['open'] = 'yes';
					}						
				} else {						
					$wps_seo_booster_ratings['open'] = ( in_array( $userip, $Ip ) ) ? 'no' : 'yes';
				}
			} else {
				$wps_seo_booster_ratings['open'] = 'yes';
			}
		} else {				
			if( isset( $wps_seo_booster_options['unique_rating'] ) && $wps_seo_booster_options['unique_rating'] == '1' ) {					
				if( isset( $wps_seo_booster_options['unique_base_rating'] ) && empty( $wps_seo_booster_options['unique_base_rating'] ) ) {
					$wps_seo_booster_ratings['open'] = ( in_array( $userip, $Ip ) ) ? 'no' : 'yes';						
				} else if( isset( $wps_seo_booster_options['unique_base_rating'] ) && !empty( $wps_seo_booster_options['unique_base_rating'] ) && $wps_seo_booster_options['unique_base_rating'] == '1' ) {							
					if( isset( $wps_seo_booster_options['cookie_day'] ) && !empty( $wps_seo_booster_options['cookie_day'] ) && !empty( $_COOKIE['wps_seo_booster_rating_'.$post_Id] ) && $_COOKIE['wps_seo_booster_rating_'.$post_Id] == '1' ) {					
						$wps_seo_booster_ratings['open'] = 'no'; 							
					} else {							
						$wps_seo_booster_ratings['open'] = 'yes';							
					}						
				} else {
						$wps_seo_booster_ratings['open'] = ( in_array( $userip, $Ip ) ) ? 'no' : 'yes';
				}
			} else {
				$wps_seo_booster_ratings['open'] = 'yes';
			}
		}	
			
		// Legend
		if( $wps_seo_booster_ratings['casts'] == '1' ) {
			$ratings = __( ' rating', 'wpsseo' );
		} else {
			$ratings = __( ' ratings', 'wpsseo' );
		}
		
		//show rating description on page load
		if( ( $wps_seo_booster_recipe_name == '' ) && ( $wps_seo_booster_review_product_name == '' ) && ( $wps_seo_booster_software_name == '' ) ) {
			if( $wps_seo_booster_ratings['casts'] >= '1' ) {
				$wps_seo_booster_ratings['legend'] = '<div class="wps-seo-booster-rating-clear">
														<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
															<span itemprop="ratingValue">' . $wps_seo_booster_ratings['avg'] . '</span>/5 ( ' . $wps_seo_booster_ratings['per'] . '% )<br />' . __( 'based on ', 'wpsseo' ) . '<span itemprop="ratingCount">' . $wps_seo_booster_ratings['casts'] . $ratings . '</span>
														</div>
													</div>';
			}
		} else {
			if( $wps_seo_booster_ratings['casts'] >= '1' ) {
				$wps_seo_booster_ratings['legend'] = '
												<div class="wps-seo-booster-rating-clear">
													' . $wps_seo_booster_ratings['avg'] . '/5 ( ' . $wps_seo_booster_ratings['per'] . '% )<br />' . __( 'based on ', 'wpsseo' ) . $wps_seo_booster_ratings['casts'] . $ratings . '
												</div>';
			}
		}
			
		// animate
		$wps_seo_booster_animate_setting = get_post_meta( $post_Id, '_wps_seo_booster_animate', true );

		if( $wps_seo_booster_animate_setting ) {
			if( $wps_seo_booster_animate_setting == '1' ) {
				$wps_seo_booster_ratings['animate'] = $wps_seo_booster_animate_setting;				
			} else {
				$wps_seo_booster_ratings['animate'] = '';
			}	
		} else {
			$wps_seo_booster_ratings['animate'] = isset( $wps_seo_booster_options['animate_rating'] ) ? $wps_seo_booster_options['animate_rating'] : '';				
		}
			
		$result = '1$##$'.$wps_seo_booster_ratings['per'].'$##$'.$wps_seo_booster_ratings['legend'].'$##$'.$wps_seo_booster_ratings['open'].'$##$'.$wps_seo_booster_ratings['animate'].'$##$'.$post_Id;

		echo $result;
		exit;
	} else {
		$result = '2$##$';
		echo $result;
		exit;				
	}
}
	
add_action( 'wp_ajax_get_data', 'wps_seo_booster_get_data' );
add_action( 'wp_ajax_nopriv_get_data', 'wps_seo_booster_get_data' );