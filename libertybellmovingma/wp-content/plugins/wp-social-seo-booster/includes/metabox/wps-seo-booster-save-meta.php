<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Save Meta Box Entries
 *
 * Saving all the information the user entered in to each
 * meta box field.
 *
 * @package WPSocial SEO Booster
 * @since	1.0.0
 */
function wps_seo_booster_save_meta( $post_id ) {

	// check for post autosave
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// Check permissions
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	/********** General Values **********/
	if ( isset( $_POST['wps_seo_booster_disable'] ) ) {	
		update_post_meta( $post_id, '_wps_seo_booster_disable', strip_tags( $_POST['wps_seo_booster_disable'] ) );
	}
	
	/********** Open Graph Values **********/
	if ( isset( $_POST['wps_seo_booster_ogp_title'] ) ) {	
		update_post_meta( $post_id, '_wps_seo_booster_ogp_title', strip_tags( $_POST['wps_seo_booster_ogp_title'] ) );
	}		
	if ( isset( $_POST['wps_seo_booster_ogp_description'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_ogp_description', strip_tags( $_POST['wps_seo_booster_ogp_description'] ) );	
	}	
	if ( isset( $_POST['wps_seo_booster_ogp_image'] ) ) {	
		update_post_meta( $post_id, '_wps_seo_booster_ogp_image', esc_url_raw( $_POST['wps_seo_booster_ogp_image'] ) );
	}		
	if ( isset( $_POST['wps_seo_booster_ogp_type'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_ogp_type', strip_tags( $_POST['wps_seo_booster_ogp_type'] ) );
	}		
	if ( isset( $_POST['wps_seo_booster_ogp_video_url'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_ogp_video_url', esc_url_raw( $_POST['wps_seo_booster_ogp_video_url'] ) );
	}		
	if ( isset( $_POST['wps_seo_booster_ogp_video_height'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_ogp_video_height', strip_tags( $_POST['wps_seo_booster_ogp_video_height'] ) );
	}		
	if ( isset( $_POST['wps_seo_booster_ogp_video_width'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_ogp_video_width', strip_tags( $_POST['wps_seo_booster_ogp_video_width'] ) );
	}		
	if ( isset( $_POST['wps_seo_booster_ogp_audio_url'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_ogp_audio_url', esc_url_raw( $_POST['wps_seo_booster_ogp_audio_url'] ) );
	}		
	if ( isset( $_POST['wps_seo_booster_ogp_audio_title'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_ogp_audio_title', strip_tags( $_POST['wps_seo_booster_ogp_audio_title'] ) );
	}		
	if ( isset( $_POST['wps_seo_booster_ogp_audio_artist'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_ogp_audio_artist', strip_tags( $_POST['wps_seo_booster_ogp_audio_artist'] ) );
	}		
	if ( isset( $_POST['wps_seo_booster_ogp_audio_album'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_ogp_audio_album', strip_tags( $_POST['wps_seo_booster_ogp_audio_album'] ) );
	}		
	if ( isset( $_POST['wps_seo_booster_ogp_post_app_id'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_ogp_post_app_id', strip_tags( $_POST['wps_seo_booster_ogp_post_app_id'] ) );
	}		
	if ( isset( $_POST['wps_seo_booster_ogp_post_fb_admins'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_ogp_post_fb_admins', strip_tags( $_POST['wps_seo_booster_ogp_post_fb_admins'] ) );
	}		
	
	/********** Schema.org Review Values **********/	
	if ( isset( $_POST['wps_seo_booster_review_position'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_position', strip_tags( $_POST['wps_seo_booster_review_position'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_review_product_name'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_product_name', strip_tags( $_POST['wps_seo_booster_review_product_name'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_review_product_type'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_product_type', strip_tags( $_POST['wps_seo_booster_review_product_type'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_review_product_version'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_product_version', strip_tags( $_POST['wps_seo_booster_review_product_version'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_review_author'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_author', strip_tags( $_POST['wps_seo_booster_review_author'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_review_date'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_date', strip_tags( $_POST['wps_seo_booster_review_date'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_review_rating_value'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_rating_value', strip_tags( $_POST['wps_seo_booster_review_rating_value'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_review_product_author'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_product_author', strip_tags( $_POST['wps_seo_booster_review_product_author'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_review_product_link'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_product_link', strip_tags( $_POST['wps_seo_booster_review_product_link'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_review_product_price'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_product_price', strip_tags( $_POST['wps_seo_booster_review_product_price'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_review_product_currency'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_product_currency', strip_tags( $_POST['wps_seo_booster_review_product_currency'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_review_summary'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_review_summary', strip_tags( $_POST['wps_seo_booster_review_summary'] ) );
	}	
	/********** Schema.org Product Values **********/	
	if ( isset( $_POST['wps_seo_booster_product_name'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_product_name', strip_tags( $_POST['wps_seo_booster_product_name'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_product_brand'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_product_brand', strip_tags( $_POST['wps_seo_booster_product_brand'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_product_image'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_product_image', strip_tags( $_POST['wps_seo_booster_product_image'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_product_summary'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_product_summary', strip_tags( $_POST['wps_seo_booster_product_summary'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_product_sku'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_product_sku', strip_tags( $_POST['wps_seo_booster_product_sku'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_product_category'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_product_category', strip_tags( $_POST['wps_seo_booster_product_category'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_product_price'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_product_price', strip_tags( $_POST['wps_seo_booster_product_price'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_product_currency'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_product_currency', strip_tags( $_POST['wps_seo_booster_product_currency'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_product_price_sale'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_product_price_sale', strip_tags( $_POST['wps_seo_booster_product_price_sale'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_product_sale_ends'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_product_sale_ends', strip_tags( $_POST['wps_seo_booster_product_sale_ends'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_product_seller'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_product_seller', strip_tags( $_POST['wps_seo_booster_product_seller'] ) );
	}

	/********** Schema.org Business Values **********/	
	if ( isset( $_POST['wps_seo_booster_business_position'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_business_position', strip_tags( $_POST['wps_seo_booster_business_position'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_business_name'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_business_name', strip_tags( $_POST['wps_seo_booster_business_name'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_business_street'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_business_street', strip_tags( $_POST['wps_seo_booster_business_street'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_business_locality'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_business_locality', strip_tags( $_POST['wps_seo_booster_business_locality'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_business_region'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_business_region', strip_tags( $_POST['wps_seo_booster_business_region'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_business_pc'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_business_pc', strip_tags( $_POST['wps_seo_booster_business_pc'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_business_tel'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_business_tel', strip_tags( $_POST['wps_seo_booster_business_tel'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_business_email'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_business_email', strip_tags( $_POST['wps_seo_booster_business_email'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_business_url'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_business_url', strip_tags( $_POST['wps_seo_booster_business_url'] ) );
	}	
	
	/********** Schema.org Person Values **********/	
	if ( isset( $_POST['wps_seo_booster_person_position'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_person_position', strip_tags( $_POST['wps_seo_booster_person_position'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_person_name'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_person_name', strip_tags( $_POST['wps_seo_booster_person_name'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_person_nickname'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_person_nickname', strip_tags( $_POST['wps_seo_booster_person_nickname'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_person_street'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_person_street', strip_tags( $_POST['wps_seo_booster_person_street'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_person_locality'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_person_locality', strip_tags( $_POST['wps_seo_booster_person_locality'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_person_region'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_person_region', strip_tags( $_POST['wps_seo_booster_person_region'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_person_pc'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_person_pc', strip_tags( $_POST['wps_seo_booster_person_pc'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_person_tel'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_person_tel', strip_tags( $_POST['wps_seo_booster_person_tel'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_person_email'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_person_email', strip_tags( $_POST['wps_seo_booster_person_email'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_person_job'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_person_job', strip_tags( $_POST['wps_seo_booster_person_job'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_person_business'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_person_business', strip_tags( $_POST['wps_seo_booster_person_business'] ) );
	}
	
	/********** Schema.org Recipes Values **********/	
	if ( isset( $_POST['wps_seo_booster_recipe_position'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_position', strip_tags( $_POST['wps_seo_booster_recipe_position'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_name'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_name', strip_tags( $_POST['wps_seo_booster_recipe_name'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_image'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_image', strip_tags( $_POST['wps_seo_booster_recipe_image'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_author'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_author', strip_tags( $_POST['wps_seo_booster_recipe_author'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_date'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_date', strip_tags( $_POST['wps_seo_booster_recipe_date'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_summary'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_summary', strip_tags( $_POST['wps_seo_booster_recipe_summary'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_prep'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_prep', strip_tags( $_POST['wps_seo_booster_recipe_prep'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_cooke'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_cooke', strip_tags( $_POST['wps_seo_booster_recipe_cooke'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_total'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_total', strip_tags( $_POST['wps_seo_booster_recipe_total'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_yield'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_yield', strip_tags( $_POST['wps_seo_booster_recipe_yield'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_serving_size'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_serving_size', strip_tags( $_POST['wps_seo_booster_recipe_serving_size'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_calories'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_calories', strip_tags( $_POST['wps_seo_booster_recipe_calories'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_fat'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_fat', strip_tags( $_POST['wps_seo_booster_recipe_fat'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_recipe_ingredients_size'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_ingredients_size',  stripslashes_deep( $_POST['wps_seo_booster_recipe_ingredients_size'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_ingredients'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_ingredients',  stripslashes_deep( $_POST['wps_seo_booster_recipe_ingredients'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_ingredients_amount'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_ingredients_amount',  stripslashes_deep( $_POST['wps_seo_booster_recipe_ingredients_amount'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_ingredients_directions'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_ingredients_directions', stripslashes_deep( $_POST['wps_seo_booster_recipe_ingredients_directions'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_rating_title'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_rating_title', strip_tags( $_POST['wps_seo_booster_recipe_rating_title'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_recipe_rating_value'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_recipe_rating_value', strip_tags( $_POST['wps_seo_booster_recipe_rating_value'] ) );
	}
	
	/********** Schema.org Software Values **********/	
	if ( isset( $_POST['wps_seo_booster_software_position'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_position', strip_tags( $_POST['wps_seo_booster_software_position'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_software_name'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_name', strip_tags( $_POST['wps_seo_booster_software_name'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_software_description'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_description', strip_tags( $_POST['wps_seo_booster_software_description'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_software_image'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_image', strip_tags( $_POST['wps_seo_booster_software_image'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_software_author'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_author', strip_tags( $_POST['wps_seo_booster_software_author'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_software_version'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_version', strip_tags( $_POST['wps_seo_booster_software_version'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_software_language'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_language', strip_tags( $_POST['wps_seo_booster_software_language'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_software_system'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_system', strip_tags( $_POST['wps_seo_booster_software_system'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_software_category'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_category', strip_tags( $_POST['wps_seo_booster_software_category'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_software_price'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_price', strip_tags( $_POST['wps_seo_booster_software_price'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_software_currency'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_currency', strip_tags( $_POST['wps_seo_booster_software_currency'] ) );
	}
	if ( isset( $_POST['wps_seo_booster_software_rating'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_rating', strip_tags( $_POST['wps_seo_booster_software_rating'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_software_rating_author'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_software_rating_author', strip_tags( $_POST['wps_seo_booster_software_rating_author'] ) );
	}	
	
	/********** Schema.org Video Values **********/	
	if ( isset( $_POST['wps_seo_booster_video_name'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_video_name', strip_tags( $_POST['wps_seo_booster_video_name'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_video_description'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_video_description', strip_tags( $_POST['wps_seo_booster_video_description'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_video_image'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_video_image', strip_tags( $_POST['wps_seo_booster_video_image'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_video_url'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_video_url', strip_tags( $_POST['wps_seo_booster_video_url'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_video_embed'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_video_embed', strip_tags( $_POST['wps_seo_booster_video_embed'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_video_type'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_video_type', strip_tags( $_POST['wps_seo_booster_video_type'] ) );
	}
	
	/********** Schema.org Event Values **********/	
	if ( isset( $_POST['wps_seo_booster_event_name'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_name', strip_tags( $_POST['wps_seo_booster_event_name'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_image'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_image', strip_tags( $_POST['wps_seo_booster_event_image'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_description'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_description', strip_tags( $_POST['wps_seo_booster_event_description'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_date_start'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_date_start', strip_tags( $_POST['wps_seo_booster_event_date_start'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_date_end'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_date_end', strip_tags( $_POST['wps_seo_booster_event_date_end'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_location'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_location', strip_tags( $_POST['wps_seo_booster_event_location'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_location_street'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_location_street', strip_tags( $_POST['wps_seo_booster_event_location_street'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_location_locality'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_location_locality', strip_tags( $_POST['wps_seo_booster_event_location_locality'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_location_region'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_location_region', strip_tags( $_POST['wps_seo_booster_event_location_region'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_type'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_type', strip_tags( $_POST['wps_seo_booster_event_type'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_ticket_price'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_ticket_price', strip_tags( $_POST['wps_seo_booster_event_ticket_price'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_ticket_price_low'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_ticket_price_low', strip_tags( $_POST['wps_seo_booster_event_ticket_price_low'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_ticket_price_high'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_ticket_price_high', strip_tags( $_POST['wps_seo_booster_event_ticket_price_high'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_ticket_price_currency'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_ticket_price_currency', strip_tags( $_POST['wps_seo_booster_event_ticket_price_currency'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_ticket_count'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_ticket_count', strip_tags( $_POST['wps_seo_booster_event_ticket_count'] ) );
	}	
	if ( isset( $_POST['wps_seo_booster_event_ticket_url'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_event_ticket_url', strip_tags( $_POST['wps_seo_booster_event_ticket_url'] ) );
	}
	
	/********** Star Rating (since version 1.0.0 **********/	
	$chk = isset( $_POST['wps_seo_booster_enable_rating_post'] ) && $_POST['wps_seo_booster_enable_rating_post'] ? 'on' : 'off';  
		update_post_meta( $post_id, '_wps_seo_booster_enable_rating_post', $chk );
		
	if ( isset( $_POST['wps_seo_booster_placement'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_placement', strip_tags( $_POST['wps_seo_booster_placement'] ) );		
	}
	
	if ( isset( $_POST['wps_seo_booster_animate'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_animate', strip_tags( $_POST['wps_seo_booster_animate'] ) );		
	}
	
	if ( isset( $_POST['wps_seo_booster_unique'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_unique', strip_tags( $_POST['wps_seo_booster_unique'] ) );		
	}
	
	if ( isset( $_POST['wps_seo_booster_unique_base'] ) ) {
		update_post_meta( $post_id, '_wps_seo_booster_unique_base', strip_tags( $_POST['wps_seo_booster_unique_base'] ) );		
	}		
}


/* Ajax function for flush rating */
function wps_seo_booster_flush_rating() {

	if( isset( $_POST['id'] ) && !empty( $_POST['id'] ) ) {
		delete_post_meta( $_POST['id'], '_wps_seo_booster_star_ratings' );
		delete_post_meta( $_POST['id'], '_wps_seo_booster_star_casts' );
		delete_post_meta( $_POST['id'], '_wps_seo_booster_star_ips' );
		delete_post_meta( $_POST['id'], '_wps_seo_booster_star_avg' );
		echo "success";
	}
	exit;
}

add_action( 'wp_ajax_flush_rating', 'wps_seo_booster_flush_rating' );
add_action( 'wp_ajax_nopriv_flush_rating', 'wps_seo_booster_flush_rating' );