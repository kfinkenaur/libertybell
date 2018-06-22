<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* ==== WPSocial Seo Booster Meta Box ==== */

/**
 * Meta Box Setup
 *
 * Seting up the meta box.
 *
 * @package WPSocial SEO Booster
 * @since	1.0.0
 */
function wps_seo_booster_metabox_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'wps_seo_booster_create_metabox' ); // adding the meta box
	
	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'wps_seo_booster_save_meta', 10, 2 );

}

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'wps_seo_booster_metabox_setup' );
add_action( 'load-post-new.php', 'wps_seo_booster_metabox_setup' );

/**
 * Create Meta Box 
 *
 * Creating the custom meta box for all registered post types.
 *
 * @package WPSocial SEO Booster
 * @since	1.0.0
 */
function wps_seo_booster_create_metabox() {

	global $current_user, $post;
	$wps_seo_booster_options = get_option( 'wps_seo_booster_options' );
	
	// check the role of the current user
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {

		add_meta_box( 
			'wps-seo-booster-meta',  
			esc_html__( 'WPSocial SEO Booster', 'wpsseo' ), 
			'wps_seo_booster_post_meta_box', 
			'post', 
			'advanced', 
			'', 
			1 
		);				
		
		if( isset( $wps_seo_booster_options['enable_rating'] ) && !empty( $wps_seo_booster_options['enable_rating'] ) && $wps_seo_booster_options['enable_rating'] ) {
								
			add_meta_box( 
				'wps-seo-booster-star-rating-meta',  
				esc_html__( 'WPSocial SEO Booster Star Rating', 'wpsseo' ), 
				'wps_seo_booster_star_rating_meta_box', 
				'post', 
				'side', 
				'high', 
				1 
			);	
		}
	}
}

/**
 * Display Meta Box 
 *
 * Displaying the meta box.
 *
 * @package WPSocial SEO Booster
 * @since	1.0.0
 */
function wps_seo_booster_post_meta_box( $post ) {

	/********** General Values **********/	
	$wps_seo_booster_disable = get_post_meta( $post->ID, '_wps_seo_booster_disable', true );

	/********** Open Graph Values **********/	
	$wps_seo_booster_ogp_title = get_post_meta( $post->ID, '_wps_seo_booster_ogp_title', true );
	$wps_seo_booster_ogp_description = get_post_meta( $post->ID, '_wps_seo_booster_ogp_description', true );
	$wps_seo_booster_ogp_image = get_post_meta( $post->ID, '_wps_seo_booster_ogp_image', true );
	$wps_seo_booster_ogp_type = get_post_meta( $post->ID, '_wps_seo_booster_ogp_type', true );
	$wps_seo_booster_ogp_video_url = get_post_meta( $post->ID, '_wps_seo_booster_ogp_video_url', true );
	$wps_seo_booster_ogp_video_height = get_post_meta( $post->ID, '_wps_seo_booster_ogp_video_height', true );
	$wps_seo_booster_ogp_video_width = get_post_meta( $post->ID, '_wps_seo_booster_ogp_video_width', true );
	$wps_seo_booster_ogp_audio_url = get_post_meta( $post->ID, '_wps_seo_booster_ogp_audio_url', true );
	$wps_seo_booster_ogp_audio_title = get_post_meta( $post->ID, '_wps_seo_booster_ogp_audio_title', true );
	$wps_seo_booster_ogp_audio_artist = get_post_meta( $post->ID, '_wps_seo_booster_ogp_audio_artist', true );
	$wps_seo_booster_ogp_audio_album = get_post_meta( $post->ID, '_wps_seo_booster_ogp_audio_album', true );
	$wps_seo_booster_ogp_post_app_id = get_post_meta( $post->ID, '_wps_seo_booster_ogp_post_app_id', true );
	$wps_seo_booster_ogp_post_fb_admins = get_post_meta( $post->ID, '_wps_seo_booster_ogp_post_fb_admins', true );
	
	/********** Schema.org Review Values **********/	
	$wps_seo_booster_review_position = get_post_meta( $post->ID, '_wps_seo_booster_review_position', true );
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
	
	/********** Schema.org Business Values **********/	
	$wps_seo_booster_business_position = get_post_meta( $post->ID, '_wps_seo_booster_business_position', true );
	$wps_seo_booster_business_name = get_post_meta( $post->ID, '_wps_seo_booster_business_name', true );
	$wps_seo_booster_business_street = get_post_meta( $post->ID, '_wps_seo_booster_business_street', true );
	$wps_seo_booster_business_locality = get_post_meta( $post->ID, '_wps_seo_booster_business_locality', true );
	$wps_seo_booster_business_region = get_post_meta( $post->ID, '_wps_seo_booster_business_region', true );
	$wps_seo_booster_business_pc = get_post_meta( $post->ID, '_wps_seo_booster_business_pc', true );
	$wps_seo_booster_business_tel = get_post_meta( $post->ID, '_wps_seo_booster_business_tel', true );
	$wps_seo_booster_business_email = get_post_meta( $post->ID, '_wps_seo_booster_business_email', true );
	$wps_seo_booster_business_url = get_post_meta( $post->ID, '_wps_seo_booster_business_url', true );
	
	/********** Schema.org Person Values **********/	
	$wps_seo_booster_person_position = get_post_meta( $post->ID, '_wps_seo_booster_person_position', true );
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
	$wps_seo_booster_recipe_ingredients_size = get_post_meta( $post->ID, '_wps_seo_booster_recipe_ingredients_size', true );
	$wps_seo_booster_recipe_ingredients = get_post_meta( $post->ID, '_wps_seo_booster_recipe_ingredients', true );
	$wps_seo_booster_recipe_ingredients_amount = get_post_meta( $post->ID, '_wps_seo_booster_recipe_ingredients_amount', true );
	$wps_seo_booster_recipe_ingredients_directions = get_post_meta( $post->ID, '_wps_seo_booster_recipe_ingredients_directions', true );
	$wps_seo_booster_recipe_rating_title = get_post_meta( $post->ID, '_wps_seo_booster_recipe_rating_title', true );
	$wps_seo_booster_recipe_rating_value = get_post_meta( $post->ID, '_wps_seo_booster_recipe_rating_value', true );
	
	/********** Schema.org Video Values **********/	
	$wps_seo_booster_video_name = get_post_meta( $post->ID, '_wps_seo_booster_video_name', true );
	$wps_seo_booster_video_description = get_post_meta( $post->ID, '_wps_seo_booster_video_description', true );
	$wps_seo_booster_video_image = get_post_meta( $post->ID, '_wps_seo_booster_video_image', true );
	$wps_seo_booster_video_url = get_post_meta( $post->ID, '_wps_seo_booster_video_url', true );
	$wps_seo_booster_video_embed = get_post_meta( $post->ID, '_wps_seo_booster_video_embed', true );
	$wps_seo_booster_video_type = get_post_meta( $post->ID, '_wps_seo_booster_video_type', true );
	
	/********** Schema.org Software Values **********/	
	$wps_seo_booster_software_position = get_post_meta( $post->ID, '_wps_seo_booster_software_position', true );
	$wps_seo_booster_software_name = get_post_meta( $post->ID, '_wps_seo_booster_software_name', true );
	$wps_seo_booster_software_description = get_post_meta( $post->ID, '_wps_seo_booster_software_description', true );
	$wps_seo_booster_software_image = get_post_meta( $post->ID, '_wps_seo_booster_software_image', true );
	$wps_seo_booster_software_author = get_post_meta( $post->ID, '_wps_seo_booster_software_author', true );
	$wps_seo_booster_software_version = get_post_meta( $post->ID, '_wps_seo_booster_software_version', true );
	$wps_seo_booster_software_language = get_post_meta( $post->ID, '_wps_seo_booster_software_language', true );
	$wps_seo_booster_software_system = get_post_meta( $post->ID, '_wps_seo_booster_software_system', true );
	$wps_seo_booster_software_category = get_post_meta( $post->ID, '_wps_seo_booster_software_category', true );
	$wps_seo_booster_software_rating = get_post_meta( $post->ID, '_wps_seo_booster_software_rating', true );
	$wps_seo_booster_software_price = get_post_meta( $post->ID, '_wps_seo_booster_software_price', true );
	$wps_seo_booster_software_currency = get_post_meta( $post->ID, '_wps_seo_booster_software_currency', true );
	$wps_seo_booster_software_rating_author = get_post_meta( $post->ID, '_wps_seo_booster_software_rating_author', true );
	
	/********** Schema.org Event Values **********/	
	$wps_seo_booster_event_date_start = get_post_meta( $post->ID, '_wps_seo_booster_event_date_start', true );
	$wps_seo_booster_event_name = get_post_meta( $post->ID, '_wps_seo_booster_event_name', true );
	$wps_seo_booster_event_image = get_post_meta( $post->ID, '_wps_seo_booster_event_image', true );
	$wps_seo_booster_event_description = get_post_meta( $post->ID, '_wps_seo_booster_event_description', true );
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
	
	?>
	
	<div class="wps-seo-booster-metabox-tabs-div">
        <ul class="metabox-tabs" id="metabox-tabs">
			<li class="active general"><a class="active" href="javascript:void(null);"><?php _e( 'General', 'wpsseo' ); ?></a></li>
            <li class="opengraph"><a href="javascript:void(null);"><?php _e( 'Open Graph', 'wpsseo' ); ?></a></li>
            <li class="review"><a href="javascript:void(null);"><?php _e( 'Review', 'wpsseo' ); ?></a></li>
			<li class="product"><a href="javascript:void(null);"><?php _e( 'Product', 'wpsseo' ); ?></a></li>
			<li class="business"><a href="javascript:void(null);"><?php _e( 'Business', 'wpsseo' ); ?></a></li>
			<li class="person"><a href="javascript:void(null);"><?php _e( 'People', 'wpsseo' ); ?></a></li>
			<li class="recipes"><a href="javascript:void(null);"><?php _e( 'Recipes', 'wpsseo' ); ?></a></li>
			<li class="software"><a href="javascript:void(null);"><?php _e( 'Software', 'wpsseo' ); ?></a></li>
			<li class="videos"><a href="javascript:void(null);"><?php _e( 'Videos', 'wpsseo' ); ?></a></li>
			<li class="event"><a href="javascript:void(null);"><?php _e( 'Event', 'wpsseo' ); ?></a></li>
        </ul>
		
		<?php
			/* ==== Begin WPSocial Seo Booster General Meta Box Values ==== */

			/**
			 * Display General 
			 *
			 * Displaying the general values within the WPSocial SEO Booster meta box.
			 *
			 * @package WPSocial SEO Booster
			 * @since	1.1.1
			 */
		?>
		
		<div class="general">
			<h4 class="heading"><?php _e( 'General', 'wpsseo' ); ?></h4>
			<table class="form-table">
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_disable"><?php _e( 'Disable SEO Booster: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<select name="wps_seo_booster_disable" id="wps_seo_booster_disable">
							<?php   												
								$disable_seobooster = array( "" => __( 'No', 'wpsseo' ),"1" => __( 'Yes', 'wpsseo' ) );
																		
								foreach ( $disable_seobooster as $key => $option ) {											
									?>
									<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_disable, $key ); ?>>
										<?php esc_html_e( $option ); ?>
									</option>
									<?php
								}															
							?> 														
						</select> 
						<p><?php _e( 'Choose "Yes" if you want to disable all of the SEO Booster features for this post.', 'wpsseo' ); ?></p>
					</td>
				</tr>
			</table>
		</div><!-- .general -->
		
		<?php
			/* ==== Begin WPSocial Seo Booster Open Graph Meta Box Values ==== */

			/**
			 * Display Open Graph 
			 *
			 * Displaying the open graph values within the WPSocial SEO Booster meta box.
			 *
			 * @package WPSocial SEO Booster
			 * @since	1.0.0
			 */
		?>
        <div class="opengraph">
			<h4 class="heading"><?php _e( 'Open Graph', 'wpsseo' ); ?></h4>
			<table class="form-table">
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_title"><?php _e( 'Open Graph Title: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" name="wps_seo_booster_ogp_title" id="wps_seo_booster_ogp_title"  value="<?php esc_attr_e( $wps_seo_booster_ogp_title ); ?>" />  
						<p><?php _e( 'Add a custom title for your post. This will be used to post on an user\'s wall when they like/share your post. If you use any SEO plugin or if your theme does support a custom title for SEO, then the plugin will use the title you used within the plugin or the theme and you can leave that empty if you like. <strong>If you enter a value here, the plugin will use it, regardless if you have other values within the SEO plugin or theme.</strong>', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign='top'>
					<th>
						<label for="wps_seo_booster_ogp_description"><?php _e( 'Open Graph Description:', 'wpsseo' ); ?></label>
					</th>
					<td>
						<textarea id="wps_seo_booster_ogp_description" name="wps_seo_booster_ogp_description" class="large-text" rows="3"><?php esc_attr_e( $wps_seo_booster_ogp_description ); ?></textarea>
						<p><?php _e( 'Add a custom description for your post. This will be used to post on an user\'s wall when they like/share your post. If you use any SEO plugin or if your theme does support a custom description for SEO, then the plugin will use the description you used within the plugin or the theme and you can leave that empty if you like. <strong>If you enter a value here, the plugin will use it, regardless if you have other values within the SEO plugin or theme.</strong>', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_image"><?php _e( 'Custom Open Graph Image: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" id="wps_seo_booster_upload_image" name="wps_seo_booster_ogp_image" value="<?php echo esc_url( $wps_seo_booster_ogp_image ); ?>">
						<input type="button" class="button-secondary" id="wps_seo_booster_upload_button" rel="<?php echo $post->ID; ?>" value="<?php echo esc_attr_e( 'Add Image', 'wpsseo' ); ?>">
						<p><?php _e( 'If an image is uploaded, then this will be used when this content is being shared.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_type"><?php _e( 'Open Graph Content Type: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<select name="wps_seo_booster_ogp_type" id="wps_seo_booster_ogp_type">
							<?php   												
								$content_type = array( "article" => __( 'Article', 'wpsseo' ),"book" => __( 'Book', 'wpsseo' ),"profile" => __( 'Profile', 'wpsseo' ),"website" => __( 'Website', 'wpsseo' ),"music.album" => __( 'Music Album', 'wpsseo' ),"music.song" => __( 'Song', 'wpsseo' ),"video.movie" => __( 'Movie', 'wpsseo' ),"video.tv_show" => __( 'TV Show', 'wpsseo' ), "video" => __( 'Video', 'wpsseo' ) );
																		
								foreach ( $content_type as $key => $option ) {											
									?>
									<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_ogp_type, $key ); ?>>
										<?php esc_html_e( $option ); ?>
									</option>
									<?php
								}															
							?> 														
						</select>
						<p><?php _e( 'Choose a custom content type for your post from the list above. If you leave this empty the default value from the settings page will be taken.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_video_url"><?php _e( 'Video URL: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" name="wps_seo_booster_ogp_video_url" id="wps_seo_booster_ogp_video_url"  value="<?php echo esc_url( $wps_seo_booster_ogp_video_url ); ?>" />  
						<p><?php _e( 'Please use the FULL URL to the video (e.g. http://www.yourdomain.com/videos/video.mp4).', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_video_height"><?php _e( 'Video Height: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_ogp_video_height" id="wps_seo_booster_ogp_video_height"  value="<?php esc_attr_e( $wps_seo_booster_ogp_video_height ); ?>" />  
						<p><?php _e( 'Enter the height of your video. (Example: 320px)', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_video_width"><?php _e( 'Video Width: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_ogp_video_width" id="wps_seo_booster_ogp_video_width"  value="<?php esc_attr_e( $wps_seo_booster_ogp_video_width ); ?>" />  
						<p><?php _e( 'Enter the width of your video. (Example: 640px)', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_audio_url"><?php _e( 'Audio URL: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" name="wps_seo_booster_ogp_audio_url" id="wps_seo_booster_ogp_audio_url"  value="<?php echo esc_url( $wps_seo_booster_ogp_audio_url ); ?>" />  
						<p><?php _e( 'Please use the FULL URL to the audio (e.g. http://www.yourdomain.com/audios/audio.mp3).', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_audio_title"><?php _e( 'Audio Title: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_ogp_audio_title" id="wps_seo_booster_ogp_audio_title"  value="<?php esc_attr_e( $wps_seo_booster_ogp_audio_title ); ?>" />  
						<p><?php _e( 'Enter the title for your audio.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_audio_artist"><?php _e( 'Audio Artist: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_ogp_audio_artist" id="wps_seo_booster_ogp_audio_artist"  value="<?php esc_attr_e( $wps_seo_booster_ogp_audio_artist ); ?>" />  
						<p><?php _e( 'Enter the name of the artist of the audio.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_audio_album"><?php _e( 'Audio Album: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_ogp_audio_album" id="wps_seo_booster_ogp_audio_album"  value="<?php esc_attr_e( $wps_seo_booster_ogp_audio_album ); ?>" />  
						<p><?php _e( 'Enter the name of the album for the audio.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_post_app_id"><?php _e( 'Facebook App ID: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_ogp_post_app_id" id="wps_seo_booster_ogp_post_app_id"  value="<?php esc_attr_e( $wps_seo_booster_ogp_post_app_id ); ?>" />  
						<p><?php _e( 'Enter a custom Facebook App ID.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_ogp_post_fb_admins"><?php _e( 'Facebook Admins: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_ogp_post_fb_admins" id="wps_seo_booster_ogp_post_fb_admins"  value="<?php esc_attr_e( $wps_seo_booster_ogp_post_fb_admins ); ?>" />  
						<p><?php _e( 'Enter the ID of a Facebook admin.', 'wpsseo' ); ?></p>
					</td>
				</tr>
			</table>
		</div><!-- .opengraph -->
		<?php
			/* ==== End WPSocial Seo Booster Open Graph Meta Box Values ==== */
		?>
	
		<?php
			/* ==== Begin WPSocial Seo Booster Schema.org Review Meta Box Values ==== */

			/**
			 * Display Review 
			 *
			 * Displaying the schema.org (microdata) review values within the WPSocial SEO Booster meta box.
			 *
			 * @package WPSocial SEO Booster
			 * @since	1.0.0
			 */
		?>
        <div class="review">
			<h4 class="heading"><?php _e( 'Rich Snippets Review', 'wpsseo' ); ?></h4>
			<table class="form-table">	
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_review_position"><?php _e( 'Display Position: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<select name="wps_seo_booster_review_position" id="wps_seo_booster_review_position">
							<?php   												
								$review_position = array( "top" => __( 'Top', 'wpsseo' ),"top_left" => __( 'Top Left', 'wpsseo' ),"top_right" => __( 'Top Right', 'wpsseo' ),"bottom" => __( 'Bottom', 'wpsseo' ) );
																		
								foreach ( $review_position as $key => $option ) {											
									?>
									<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_review_position, $key ); ?>>
										<?php esc_html_e( $option ); ?>
									</option>
									<?php
								}															
							?> 														
						</select> 
						<p><?php _e( 'Choose the position on where you want to show your review information. Top means above the actual post content, bottom means below the actual post content.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_review_product_name"><?php _e( 'Product Name: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_review_product_name" id="wps_seo_booster_review_product_name"  value="<?php esc_attr_e( $wps_seo_booster_review_product_name ); ?>" />  
						<p><?php _e( 'Enter the name of the product for which you\'re writing the review for.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_review_product_type"><?php _e( 'Product Type (optional): ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_review_product_type" id="wps_seo_booster_review_product_type"  value="<?php esc_attr_e( $wps_seo_booster_review_product_type ); ?>" />  
						<p><?php _e( 'Enter the type of the product. Example: if you\'re writing a review about WPSocial SEO Booster, the product type could be WordPress Plugin. This is optional and not used for the Google Rich Snippets.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_review_product_version"><?php _e( 'Product Version (optional): ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_review_product_version" id="wps_seo_booster_review_product_version"  value="<?php esc_attr_e( $wps_seo_booster_review_product_version ); ?>" />  
						<p><?php _e( 'Enter the version of the product like: 1.0. This is optional and not used for the Google Rich Snippets.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign='top'>
					<th>
						<label for="wps_seo_booster_review_author"><?php _e( 'Author Name:', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_review_author" id="wps_seo_booster_review_author"  value="<?php esc_attr_e( $wps_seo_booster_review_author ); ?>" />
						<p><?php _e( 'Enter the name of the author who wrote the review. Leave it empty if you want to use the author from WordPress.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_review_date"><?php _e( 'Date: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_review_date" id="wps_seo_booster_review_date"  value="<?php esc_attr_e( $wps_seo_booster_review_date ); ?>" />  
						<p><?php _e( 'Enter a publihing date for the review. Use the following date format: 2012-06-11. Leave it empty if you want to use the publishing date from WordPress.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_review_rating_value"><?php _e( 'Rating Value: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<select name="wps_seo_booster_review_rating_value" id="wps_seo_booster_review_rating_value">
							<?php   												
								$review_rating_value = array( "" => __( 'Select a Rating', 'wpsseo' ),"1" => __( '1 Star', 'wpsseo' ),"1.5" => __( '1.5 Stars', 'wpsseo' ),"2" => __( '2 Stars', 'wpsseo' ),"2.5" => __( '2.5 Stars', 'wpsseo' ),"3" => __( '3 Stars', 'wpsseo' ),"3.5" => __( '3.5 Stars', 'wpsseo' ),"4" => __( '4 Stars', 'wpsseo' ),"4.5" => __( '4.5 Stars', 'wpsseo' ),"5" => __( '5 Stars', 'wpsseo' ) );
																		
								foreach ( $review_rating_value as $key => $option ) {	
									?>
									<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_review_rating_value, $key ); ?>>
										<?php esc_html_e( $option ); ?>
									</option>
									<?php
								}
							?> 														
						</select>
						<p><?php _e( 'Choose your rating for the product.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_review_product_author"><?php _e( 'Product Author (optional): ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_review_product_author" id="wps_seo_booster_review_product_author"  value="<?php esc_attr_e( $wps_seo_booster_review_product_author ); ?>" />  
						<p><?php _e( 'Enter the name of the Product Author/Company. Example: for the WPSocial SEO Booster plugin you could enter WPSocial.com here. This is optional and not used for the Google Rich Snippets.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_review_product_link"><?php _e( 'Product Link (optional): ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" name="wps_seo_booster_review_product_link" id="wps_seo_booster_review_product_link"  value="<?php esc_attr_e( $wps_seo_booster_review_product_link ); ?>" />  
						<p><?php _e( 'Enter the link to the product you\'re reviewing. This is optional and will only be used to add a link to the author. So if you don\'t use an author within the field above, you can leave that empty too. This is optional and not used for the Google Rich Snippets.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_review_product_price"><?php _e( 'Product Price: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_review_product_price" id="wps_seo_booster_review_product_price"  value="<?php esc_attr_e( $wps_seo_booster_review_product_price ); ?>" />  
						<p><?php _e( 'Enter the price for the product.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_review_product_currency"><?php _e( 'Price Curtrency: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_review_product_currency" id="wps_seo_booster_review_product_currency"  value="<?php esc_attr_e( $wps_seo_booster_review_product_currency ); ?>" />  
						<p><?php _e( 'Enter the currency for the price. Example: if the currency is US Dollars enter USD.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_review_summary"><?php _e( 'Summary: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<textarea id="wps_seo_booster_review_summary" name="wps_seo_booster_review_summary" class="large-text" rows="3"><?php esc_attr_e( $wps_seo_booster_review_summary ); ?></textarea>
						<p><?php _e( 'Enter a summary for your review.', 'wpsseo' ); ?></p>
					</td>
				</tr>
			</table>
        </div><!-- .review -->
		<?php
			/* ==== End WPSocial Seo Booster Schema.org Review Meta Box Values ==== */
		?>
		
		<?php
			/* ==== Begin WPSocial Seo Booster Schema.org Product Meta Box Values ==== */

			/**
			 * Display Product 
			 *
			 * Displaying the schema.org (microdata) product values within the WPSocial SEO Booster meta box.
			 *
			 * @package WPSocial SEO Booster
			 * @since	1.0.0
			 */
		?>
        <div class="product">
			<h4 class="heading"><?php _e( 'Rich Snippets Product', 'wpsseo' ); ?></h4>
			<table class="form-table">	
				<tr valign="top">
					<th>
						<label><?php _e( 'Info: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<p><?php _e( 'The Rich Snippets for Products are only being added to the code and won\'t be displayed within your content.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_product_name"><?php _e( 'Product Name: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_product_name" id="wps_seo_booster_product_name"  value="<?php esc_attr_e( $wps_seo_booster_product_name ); ?>" />  
						<p><?php _e( 'Enter the name of the product.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_product_brand"><?php _e( 'Product Brand: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_product_brand" id="wps_seo_booster_product_brand"  value="<?php esc_attr_e( $wps_seo_booster_product_brand ); ?>" />  
						<p><?php _e( 'Enter the name of the brand for the product.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_product_image"><?php _e( 'Product Image: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" id="wps_seo_booster_upload_image" name="wps_seo_booster_product_image" value="<?php echo esc_url( $wps_seo_booster_product_image ); ?>">
						<input type="button" class="button-secondary" id="wps_seo_booster_upload_button" rel="<?php echo $post->ID; ?>" value="<?php echo esc_attr_e( 'Add Image', 'wpsseo' ); ?>">
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_product_summary"><?php _e( 'Product Description: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<textarea id="wps_seo_booster_product_summary" name="wps_seo_booster_product_summary" class="large-text" rows="3"><?php esc_attr_e( $wps_seo_booster_product_summary ); ?></textarea>
						<p><?php _e( 'Enter a short description for the product.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign='top'>
					<th>
						<label for="wps_seo_booster_product_sku"><?php _e( 'Product SKU:', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_product_sku" id="wps_seo_booster_product_sku"  value="<?php esc_attr_e( $wps_seo_booster_product_sku ); ?>" />
						<p><?php _e( 'If the product has a SKU, enter it here.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_product_category"><?php _e( 'Product Category: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" name="wps_seo_booster_product_category" id="wps_seo_booster_product_category"  value="<?php esc_attr_e( $wps_seo_booster_product_category ); ?>" />  
						<p><?php _e( 'Enter a product category. For example, Books-Fiction, Tools, or Cars. You can include multiple categories like: Hardware > Tools > Anvils. Any value is accepted, but Google recognizes the categories described <a href="http://support.google.com/merchants/bin/answer.py?hl=en&answer=160081" target="_blank">in this article</a>.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_product_price"><?php _e( 'Product Price: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_product_price" id="wps_seo_booster_product_price"  value="<?php esc_attr_e( $wps_seo_booster_product_price ); ?>" />  
						<p><?php _e( 'Enter the price for the product.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_product_currency"><?php _e( 'Price Currency: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_product_currency" id="wps_seo_booster_product_currency"  value="<?php esc_attr_e( $wps_seo_booster_product_currency ); ?>" />  
						<p><?php _e( 'Enter the currency for the price. Example: if the currency is US Dollars enter USD.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_product_price_sale"><?php _e( 'On Sale Price: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_product_price_sale" id="wps_seo_booster_product_price_sale"  value="<?php esc_attr_e( $wps_seo_booster_product_price_sale ); ?>" />  
						<p><?php _e( 'If the product is on sale or has a special offer (price reduction), enter the special price here.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_product_sale_ends"><?php _e( 'On Sale Ends: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_product_sale_ends" id="wps_seo_booster_product_sale_ends"  value="<?php esc_attr_e( $wps_seo_booster_product_sale_ends ); ?>" />  
						<p><?php _e( 'If the product is on sale but for limited time only, then enter the end date of the offer here. The date should have the following format: 2012-12-31.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_product_seller"><?php _e( 'Name of the Seller: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_product_seller" id="wps_seo_booster_product_seller"  value="<?php esc_attr_e( $wps_seo_booster_product_seller ); ?>" />  
						<p><?php _e( 'Enter the name of the seller here.', 'wpsseo' ); ?></p>
					</td>
				</tr>
			</table>
        </div><!-- .product -->
		<?php
			/* ==== End WPSocial Seo Booster Schema.org Product Meta Box Values ==== */
		?>
		
		<?php
			/* ==== Begin WPSocial Seo Booster Schema.org Business Meta Box Values ==== */

			/**
			 * Display Business 
			 *
			 * Displaying the schema.org (microdata) business values within the WPSocial SEO Booster meta box.
			 *
			 * @package WPSocial SEO Booster
			 * @since	1.0.0
			 */
		?>
        <div class="business">
			<h4 class="heading"><?php _e( 'Rich Snippets Business', 'wpsseo' ); ?></h4>
			<table class="form-table">	
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_business_position"><?php _e( 'Display Position: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<select name="wps_seo_booster_business_position" id="wps_seo_booster_business_position">
							<?php   												
								$business_position = array( "top" => __( 'Top', 'wpsseo' ),"top_left" => __( 'Top Left', 'wpsseo' ),"top_right" => __( 'Top Right', 'wpsseo' ),"bottom" => __( 'Bottom', 'wpsseo' ) );
																		
								foreach ( $business_position as $key => $option ) {											
									?>
									<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_business_position, $key ); ?>>
										<?php esc_html_e( $option ); ?>
									</option>
									<?php
								}															
							?> 														
						</select>  
						<p><?php _e( 'Choose the position on where you want to show your review information. Top means above the actual post content, bottom means below the actual post content and hidden means that the info is only being added to the html code but can\'t be seen on the content.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_business_name"><?php _e( 'Business Name: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_business_name" id="wps_seo_booster_business_name"  value="<?php esc_attr_e( $wps_seo_booster_business_name ); ?>" />  
						<p><?php _e( 'Enter the business name.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_business_street"><?php _e( 'Street: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_business_street" id="wps_seo_booster_business_street"  value="<?php esc_attr_e( $wps_seo_booster_business_street ); ?>" />  
						<p><?php _e( 'Enter the street address.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_business_locality"><?php _e( 'Locality: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_business_locality" id="wps_seo_booster_business_locality"  value="<?php esc_attr_e( $wps_seo_booster_business_locality ); ?>" />  
						<p><?php _e( 'Enter the locality.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_business_region"><?php _e( 'Region: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_business_region" id="wps_seo_booster_business_region"  value="<?php esc_attr_e( $wps_seo_booster_business_region ); ?>" /> 
						<p><?php _e( 'Enter the region.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign='top'>
					<th>
						<label for="wps_seo_booster_business_pc"><?php _e( 'Postal Code:', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_business_pc" id="wps_seo_booster_business_pc"  value="<?php esc_attr_e( $wps_seo_booster_business_pc ); ?>" />
						<p><?php _e( 'Enter the postal code.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_business_tel"><?php _e( 'Telephone: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_business_tel" id="wps_seo_booster_business_tel"  value="<?php esc_attr_e( $wps_seo_booster_business_tel ); ?>" />  
						<p><?php _e( 'Enter the telephone number', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_business_email"><?php _e( 'Email: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_business_email" id="wps_seo_booster_business_email"  value="<?php esc_attr_e( $wps_seo_booster_business_email ); ?>" />  
						<p><?php _e( 'Enter the email address.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_business_url"><?php _e( 'URL: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" name="wps_seo_booster_business_url" id="wps_seo_booster_business_url"  value="<?php esc_attr_e( $wps_seo_booster_business_url ); ?>" />  
						<p><?php _e( 'Enter the URL of the business website.', 'wpsseo' ); ?></p>
					</td>
				</tr>
			</table>
        </div><!-- .business -->
		<?php
			/* ==== End WPSocial Seo Booster Schema.org Business Meta Box Values ==== */
		?>
		
		<?php
			/* ==== Begin WPSocial Seo Booster Schema.org Person Meta Box Values ==== */

			/**
			 * Display Person 
			 *
			 * Displaying the schema.org (microdata) person values within the WPSocial SEO Booster meta box.
			 *
			 * @package WPSocial SEO Booster
			 * @since	1.0.0
			 */
		?>
        <div class="person">
			<h4 class="heading"><?php _e( 'Rich Snippets Person', 'wpsseo' ); ?></h4>
			<table class="form-table">
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_person_position"><?php _e( 'Display Position: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<select name="wps_seo_booster_person_position" id="wps_seo_booster_person_position">
							<?php   												
								$person_position = array( "top" => __( 'Top', 'wpsseo' ),"top_left" => __( 'Top Left', 'wpsseo' ),"top_right" => __( 'Top Right', 'wpsseo' ),"bottom" => __( 'Bottom', 'wpsseo' ) );
																		
								foreach ( $person_position as $key => $option ) {											
									?>
									<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_person_position, $key ); ?>>
										<?php esc_html_e( $option ); ?>
									</option>
									<?php
								}															
							?> 														
						</select> 
						<p><?php _e( 'Choose the position on where you want to show your information. Top means above the actual post content, bottom means below the actual post content.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_person_name"><?php _e( 'Name: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_person_name" id="wps_seo_booster_person_name"  value="<?php esc_attr_e( $wps_seo_booster_person_name ); ?>" />  
						<p><?php _e( 'Enter the full name.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_person_nickname"><?php _e( 'Nick Name: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_person_nickname" id="wps_seo_booster_person_nickname"  value="<?php esc_attr_e( $wps_seo_booster_person_nickname ); ?>" />  
						<p><?php _e( 'Enter a nick name if you have one.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_person_street"><?php _e( 'Street: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_person_street" id="wps_seo_booster_person_street"  value="<?php esc_attr_e( $wps_seo_booster_person_street ); ?>" />  
						<p><?php _e( 'Enter the street address.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_person_locality"><?php _e( 'Locality: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_person_locality" id="wps_seo_booster_person_locality"  value="<?php esc_attr_e( $wps_seo_booster_person_locality ); ?>" />  
						<p><?php _e( 'Enter the locality.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_person_region"><?php _e( 'Region: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_person_region" id="wps_seo_booster_person_region"  value="<?php esc_attr_e( $wps_seo_booster_person_region ); ?>" /> 
						<p><?php _e( 'Enter the region.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign='top'>
					<th>
						<label for="wps_seo_booster_person_pc"><?php _e( 'Postal Code:', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_person_pc" id="wps_seo_booster_person_pc"  value="<?php esc_attr_e( $wps_seo_booster_person_pc ); ?>" />
						<p><?php _e( 'Enter the postal code.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_person_tel"><?php _e( 'Telephone: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_person_tel" id="wps_seo_booster_person_tel"  value="<?php esc_attr_e( $wps_seo_booster_person_tel ); ?>" />  
						<p><?php _e( 'Enter the telephone number', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_person_email"><?php _e( 'Email: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_person_email" id="wps_seo_booster_person_email"  value="<?php esc_attr_e( $wps_seo_booster_person_email ); ?>" />  
						<p><?php _e( 'Enter the email address.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_person_job"><?php _e( 'Job Title: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_person_job" id="wps_seo_booster_person_job"  value="<?php esc_attr_e( $wps_seo_booster_person_job ); ?>" />  
						<p><?php _e( 'Enter your job title.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_person_business"><?php _e( 'Business: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_person_business" id="wps_seo_booster_person_business"  value="<?php esc_attr_e( $wps_seo_booster_person_business ); ?>" />  
						<p><?php _e( 'Enter the name of the business you work for.', 'wpsseo' ); ?></p>
					</td>
				</tr>
			</table>
        </div><!-- .person -->
		<?php
			/* ==== End WPSocial Seo Booster Schema.org Person Meta Box Values ==== */
		?>
		
		<?php
			/* ==== Begin WPSocial Seo Booster Schema.org Recipes Meta Box Values ==== */

			/**
			 * Display Recipes 
			 *
			 * Displaying the schema.org (microdata) recipes values within the WPSocial SEO Booster meta box.
			 *
			 * @package WPSocial SEO Booster
			 * @since	1.0.0
			 */
		?>
        <div class="recipes">
			<h4 class="heading"><?php _e( 'Rich Snippets Recipes', 'wpsseo' ); ?></h4>
			<table class="form-table">	
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_position"><?php _e( 'Display Position: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<select name="wps_seo_booster_recipe_position" id="wps_seo_booster_recipe_position">
							<?php   												
								$recipe_position = array( "top" => __( 'Top', 'wpsseo' ),"bottom" => __( 'Bottom', 'wpsseo' ) );
																		
								foreach ( $recipe_position as $key => $option ) {											
									?>
									<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_recipe_position, $key ); ?>>
										<?php esc_html_e( $option ); ?>
									</option>
									<?php
								}															
							?> 														
						</select> 
						<p><?php _e( 'Choose the position on where you want to show your information. Top means above the actual post content, bottom means below the actual post content.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_name"><?php _e( 'Name of the Recipe: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_recipe_name" id="wps_seo_booster_recipe_name"  value="<?php esc_attr_e( $wps_seo_booster_recipe_name ); ?>" />  
						<p><?php _e( 'Enter the name for the recipe.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_image"><?php _e( 'Image: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" id="wps_seo_booster_upload_image" name="wps_seo_booster_recipe_image" value="<?php echo esc_url( $wps_seo_booster_recipe_image ); ?>">
						<input type="button" class="button-secondary" id="wps_seo_booster_upload_button" rel="<?php echo $post->ID; ?>" value="<?php echo esc_attr_e( 'Add Image', 'wpsseo' ); ?>">
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_author"><?php _e( 'Author Name: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_recipe_author" id="wps_seo_booster_recipe_author"  value="<?php esc_attr_e( $wps_seo_booster_recipe_author ); ?>" />  
						<p><?php _e( 'Enter the name of the author for the recipe.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_date"><?php _e( 'Date: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_recipe_date" id="wps_seo_booster_recipe_date"  value="<?php esc_attr_e( $wps_seo_booster_recipe_date ); ?>" />
						<p><?php _e( 'Enter a publishing date for the recipe. To use the one from the post, just leave it empty. If you\'re using a date it should have the following format: 2012-05-11.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_summary"><?php _e( 'Summary: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<textarea id="wps_seo_booster_recipe_summary" name="wps_seo_booster_recipe_summary" class="large-text" rows="3"><?php esc_attr_e( $wps_seo_booster_recipe_summary ); ?></textarea> 
						<p><?php _e( 'Enter a summary for the recipe.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_prep"><?php _e( 'Prep Time: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_recipe_prep" id="wps_seo_booster_recipe_prep"  value="<?php esc_attr_e( $wps_seo_booster_recipe_prep ); ?>" /> 
						<p><?php _e( 'Enter the time for the preparation in minutes. The time will automatically be converted in hours and minutes if the value is higher than 60.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_cooke"><?php _e( 'Cooke Time: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_recipe_cooke" id="wps_seo_booster_recipe_cooke"  value="<?php esc_attr_e( $wps_seo_booster_recipe_cooke ); ?>" />
						<p><?php _e( 'Enter the cooking time in minutes. The time will automatically be converted in hours and minutes if the value is higher than 60.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_total"><?php _e( 'Total Time: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_recipe_total" id="wps_seo_booster_recipe_total"  value="<?php esc_attr_e( $wps_seo_booster_recipe_total ); ?>" />
						<p><?php _e( 'Enter the total time in minutes. The time will automatically be converted in hours and minutes if the value is higher than 60.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_yield"><?php _e( 'Yield: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_recipe_yield" id="wps_seo_booster_recipe_yield"  value="<?php esc_attr_e( $wps_seo_booster_recipe_yield ); ?>" />
						<p><?php _e( 'Example: 1 9" pie (8 servings)', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_serving_size"><?php _e( 'Serving Size: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_recipe_serving_size" id="wps_seo_booster_recipe_serving_size"  value="<?php esc_attr_e( $wps_seo_booster_recipe_serving_size ); ?>" />
						<p><?php _e( 'Example: 1 medium slice', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_calories"><?php _e( 'Calories: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_recipe_calories" id="wps_seo_booster_recipe_calories"  value="<?php esc_attr_e( $wps_seo_booster_recipe_calories ); ?>" />
						<p><?php _e( 'Enter the calories per serving. Example: 250', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_fat"><?php _e( 'Fat: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_recipe_fat" id="wps_seo_booster_recipe_fat"  value="<?php esc_attr_e( $wps_seo_booster_recipe_fat ); ?>" />
						<p><?php _e( 'Enter the fat per serving. Example: 12g', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_ingredients_size"><?php _e( 'Ingredients: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<p><?php _e( 'Enter the ingredients. In the first field the amount (example: 1/2 ). In the second field the size (example: cup). In the third field the ingredient (example: white sugar). To add more ingredients, click on the green plus icon.', 'wpsseo' ); ?></p>
						
						<table class="wps_seo_booster_repeat_ingredients_table">
							<thead>
								<tr>
									<td>
										<p><?php _e( 'Amount', 'wpsseo' ); ?></p>
									</td>
									<td>
										<p><?php _e( 'Size', 'wpsseo' ); ?></p>
									</td>
									<td>
										<p><?php _e( 'Ingredient', 'wpsseo' ); ?></p>
									</td>
									
									<td>
										<img class="wps_seo_booster_recipe_ingredients_add_more" src="<?php echo WPS_SEO_BOOSTER_URL; ?>/includes/images/plus.png" alt="<?php _e( 'add more', 'wpsseo' ); ?>" />
									</td>
								</tr>
							</thead>
							<tbody>
								<!-- start repeating group ingredients -->
								<div class="wps_seo_booster_repeat_ingredients">
									
									<?php 
											if( isset( $wps_seo_booster_recipe_ingredients_size ) && count( $wps_seo_booster_recipe_ingredients_size ) > 0 ) {
												for( $i=0; $i<count( $wps_seo_booster_recipe_ingredients_size ); $i++ ) { ?>
														<tr class="wps_seo_booster_repeat_ingredients_tr">
															<td>
																<input type="text" class="wps_seo_booster_recipe_ingredients_amount" name="wps_seo_booster_recipe_ingredients_amount[]" id="wps_seo_booster_recipe_ingredients_amount"  size="10" value="<?php isset( $wps_seo_booster_recipe_ingredients_amount[$i] ) ? esc_attr_e( $wps_seo_booster_recipe_ingredients_amount[$i] ) : ''; ?>" />
															</td>
															<td>
																<input type="text" class="wps_seo_booster_recipe_ingredients_size" name="wps_seo_booster_recipe_ingredients_size[]" id="wps_seo_booster_recipe_ingredients_size"  size="20" value="<?php isset( $wps_seo_booster_recipe_ingredients_size[$i] ) ? esc_attr_e( $wps_seo_booster_recipe_ingredients_size[$i] ) : ''; ?>" />
															</td>
															<td>
																<input type="text" class="wps_seo_booster_recipe_ingredients" name="wps_seo_booster_recipe_ingredients[]" id="wps_seo_booster_recipe_ingredients" size="40" value="<?php isset( $wps_seo_booster_recipe_ingredients[$i] ) ? esc_attr_e( $wps_seo_booster_recipe_ingredients[$i] ) : ''; ?>" />
															</td>
															<?php if($i > 0) {?>
																<td>
																	<img class="wps_seo_booster_recipe_ingredients_minus" src="<?php echo WPS_SEO_BOOSTER_URL; ?>/includes/images/minus.png" alt="<?php _e( 'delete', 'wpsseo' ); ?>" />
																</td>
															<?php } ?>
														</tr>
									<?php 		} // end for
											} else {
									?>		
												<tr class="wps_seo_booster_repeat_ingredients_tr">
													<td>
														<input type="text" class="wps_seo_booster_recipe_ingredients_amount" name="wps_seo_booster_recipe_ingredients_amount[]" id="wps_seo_booster_recipe_ingredients_amount"  size="10" />
													</td>
													<td>
														<input type="text" class="wps_seo_booster_recipe_ingredients_size" name="wps_seo_booster_recipe_ingredients_size[]" id="wps_seo_booster_recipe_ingredients_size"  size="20" />
													</td>
													<td>
														<input type="text" class="wps_seo_booster_recipe_ingredients" name="wps_seo_booster_recipe_ingredients[]" id="wps_seo_booster_recipe_ingredients" size="40"/>
													</td>
												</tr>
									<?php			
											}
									?>
								</div>
								<!-- end repeating group ingredients -->
							</tbody>
						</table>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_ingredients_directions"><?php _e( 'Directions: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<table class="wps_seo_booster_repeat_directions_table">
							<thead>
								<tr>
									<td>
										<p><?php _e( 'Enter the directions here.', 'wpsseo' ); ?></p>
									</td>
									
									<td>
										<img class="wps_seo_booster_recipe_directions_add_more" src="<?php echo WPS_SEO_BOOSTER_URL; ?>/includes/images/plus.png" alt="<?php _e( 'add more', 'wpsseo' ); ?>" />
									</td>
								</tr>
							</thead>
							<tbody>
								<!-- start repeating group directions -->
								<div class="wps_seo_booster_repeat_directions">
									
									<?php 
											if( isset( $wps_seo_booster_recipe_ingredients_directions ) && count( $wps_seo_booster_recipe_ingredients_directions ) > 0 ) {
												for( $i=0; $i<count( $wps_seo_booster_recipe_ingredients_directions ); $i++ ) { ?>
														<tr class="wps_seo_booster_repeat_directions_tr">
															<td>
																<textarea id="wps_seo_booster_recipe_ingredients_directions" name="wps_seo_booster_recipe_ingredients_directions[]" class="wps_seo_booster_directions" cols="60" rows="4"><?php isset( $wps_seo_booster_recipe_ingredients_directions[$i] ) ? esc_attr_e( $wps_seo_booster_recipe_ingredients_directions[$i] ) : ''; ?></textarea> 
															</td>
															<?php if($i > 0) {?>
																<td>
																	<img class="wps_seo_booster_recipe_directions_minus" src="<?php echo WPS_SEO_BOOSTER_URL; ?>/includes/images/minus.png" alt="<?php _e( 'delete', 'wpsseo' ); ?>" />
																</td>
															<?php } ?>
														</tr>
									<?php 		} // end for
											} else {
									?>		
												<tr class="wps_seo_booster_repeat_directions_tr">
													<td>
														<textarea id="wps_seo_booster_recipe_ingredients_directions" name="wps_seo_booster_recipe_ingredients_directions[]" class="wps_seo_booster_directions" cols="60" rows="4"></textarea> 
													</td>
												</tr>
									<?php			
											}
									?>
								</div>
								<!-- end repeating group directions -->
							</tbody>
						</table>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_rating_title"><?php _e( 'Rating Title: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_recipe_rating_title" id="wps_seo_booster_recipe_rating_title"  value="<?php esc_attr_e( $wps_seo_booster_recipe_rating_title ); ?>" />
						<p><?php _e( 'Enter the title for the rating.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_recipe_rating_value"><?php _e( 'Your Rating: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<select name="wps_seo_booster_recipe_rating_value" id="wps_seo_booster_recipe_rating_value">
							<?php   												
								$recipe_rating = array( "" => __( 'Select a Rating', 'wpsseo' ), "1" => __( '1 Star', 'wpsseo' ),"1.5" => __( '1.5 Stars', 'wpsseo' ),"2" => __( '2 Stars', 'wpsseo' ),"2.5" => __( '2.5 Stars', 'wpsseo' ),"3" => __( '3 Stars', 'wpsseo' ),"3.5" => __( '3.5 Stars', 'wpsseo' ),"4" => __( '4 Stars', 'wpsseo' ),"4.5" => __( '4.5 Stars', 'wpsseo' ),"5" => __( '5 Stars', 'wpsseo' ) );
																		
								foreach ( $recipe_rating as $key => $option ) {											
									?>
									<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_recipe_rating_value, $key ); ?>>
										<?php esc_html_e( $option ); ?>
									</option>
									<?php
								}															
							?> 														
						</select> 
						<p><?php _e( 'Choose your rating for the recipe.', 'wpsseo' ); ?></p>
					</td>
				</tr>
			</table>
        </div><!-- .recipe -->
		<?php
			/* ==== End WPSocial Seo Booster Schema.org Recipe Meta Box Values ==== */
		?>
		
		<?php
			/* ==== Begin WPSocial Seo Booster Schema.org Software Meta Box Values ==== */

			/**
			 * Display Software 
			 *
			 * Displaying the schema.org (microdata) software values within the WPSocial SEO Booster meta box.
			 *
			 * @package WPSocial SEO Booster
			 * @since	1.0.0
			 */
		?>
        <div class="software">
			<h4 class="heading"><?php _e( 'Rich Snippets Software', 'wpsseo' ); ?></h4>
			<table class="form-table">	
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_position"><?php _e( 'Display Position: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<select name="wps_seo_booster_software_position" id="wps_seo_booster_software_position">
							<?php   												
								$software_position = array( "top" => __( 'Top', 'wpsseo' ),"top_left" => __( 'Top Left', 'wpsseo' ),"top_right" => __( 'Top Right', 'wpsseo' ),"bottom" => __( 'Bottom', 'wpsseo' ) );
																		
								foreach ( $software_position as $key => $option ) {											
									?>
									<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_software_position, $key ); ?>>
										<?php esc_html_e( $option ); ?>
									</option>
									<?php
								}															
							?> 														
						</select> 
						<p><?php _e( 'Choose the position on where you want to show your information. Top means above the actual post content, bottom means below the actual post content.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_name"><?php _e( 'Name: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_software_name" id="wps_seo_booster_software_name"  value="<?php esc_attr_e( $wps_seo_booster_software_name ); ?>" />  
						<p><?php _e( 'The name of the software.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_description"><?php _e( 'Description: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<textarea id="wps_seo_booster_software_description" name="wps_seo_booster_software_description" class="large-text" rows="3"><?php esc_attr_e( $wps_seo_booster_software_description ); ?></textarea> 
						<p><?php _e( 'The description of the software.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_image"><?php _e( 'Image: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" id="wps_seo_booster_upload_image" name="wps_seo_booster_software_image" value="<?php echo esc_url( $wps_seo_booster_software_image ); ?>">
						<input type="button" class="button-secondary" id="wps_seo_booster_upload_button" rel="<?php echo $post->ID; ?>" value="<?php echo esc_attr_e( 'Add Image', 'wpsseo' ); ?>">
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_author"><?php _e( 'Author: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_software_author" id="wps_seo_booster_software_author"  value="<?php esc_attr_e( $wps_seo_booster_software_author ); ?>" />  
						<p><?php _e( 'The author of the software.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_version"><?php _e( 'Version: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_software_version" id="wps_seo_booster_software_version"  value="<?php esc_attr_e( $wps_seo_booster_software_version ); ?>" /> 
						<p><?php _e( 'The software version.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_language"><?php _e( 'Language: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_software_language" id="wps_seo_booster_software_language"  value="<?php esc_attr_e( $wps_seo_booster_software_language ); ?>" />  
						<p><?php _e( 'The language of the software', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_system"><?php _e( 'Operating System: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_software_system" id="wps_seo_booster_software_system"  value="<?php esc_attr_e( $wps_seo_booster_software_system ); ?>" />  
						<p><?php _e( 'Operating systems required (for example, "Windows 7", "OSX 10.6", "Android 1.6")', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_category"><?php _e( 'Category: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" name="wps_seo_booster_software_category" id="wps_seo_booster_software_category"  value="<?php esc_attr_e( $wps_seo_booster_software_category ); ?>" />  
						<p><?php _e( 'The type of software application (for example, BusinessApplication or GameApplication). Must be one of the <a href="http://support.google.com/webmasters/bin/answer.py?hl=en&answer=1645527" target="_blank">supported software application types</a>.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_price"><?php _e( 'Price: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_software_price" id="wps_seo_booster_software_price"  value="<?php esc_attr_e( $wps_seo_booster_software_price ); ?>" />  
						<p><?php _e( 'Enter the price for the software.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_currency"><?php _e( 'Price Currency: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_software_currency" id="wps_seo_booster_software_currency"  value="<?php esc_attr_e( $wps_seo_booster_software_currency ); ?>" />  
						<p><?php _e( 'Enter the currency for the price. Example: if the currency is US Dollars enter USD.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_software_rating"><?php _e( 'Rating Value: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<select name="wps_seo_booster_software_rating" id="wps_seo_booster_software_rating">
							<?php   												
								$software_rating_value = array( "" => __( 'Select a Rating', 'wpsseo' ),"1" => __( '1 Star', 'wpsseo' ),"1.5" => __( '1.5 Stars', 'wpsseo' ),"2" => __( '2.5 Stars', 'wpsseo' ),"3" => __( '3 Stars', 'wpsseo' ),"3.5" => __( '3.5 Stars', 'wpsseo' ),"4" => __( '4 Stars', 'wpsseo' ),"4.5" => __( '4.5 Stars', 'wpsseo' ),"5" => __( '5 Stars', 'wpsseo' ) );
																		
								foreach ( $software_rating_value as $key => $option ) {	
									?>
									<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_software_rating, $key ); ?>>
										<?php esc_html_e( $option ); ?>
									</option>
									<?php
								}
							?> 														
						</select> 
						<p><?php _e( 'Your rating for the software.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign='top'>
					<th>
						<label for="wps_seo_booster_software_rating_author"><?php _e( 'Rating Author Name:', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_software_rating_author" id="wps_seo_booster_software_rating_author"  value="<?php esc_attr_e( $wps_seo_booster_software_rating_author ); ?>" />
						<p><?php _e( 'Enter the name of the author who wrote the review. Leave it empty if you want to use the author from WordPress.', 'wpsseo' ); ?></p>
					</td>
				</tr>
			</table>
        </div><!-- .software -->
		<?php
			/* ==== End WPSocial Seo Booster Schema.org Software Meta Box Values ==== */
		?>
		
		<?php
			/* ==== Begin WPSocial Seo Booster Schema.org Video Meta Box Values ==== */

			/**
			 * Display Video 
			 *
			 * Displaying the schema.org (microdata) video values within the WPSocial SEO Booster meta box.
			 *
			 * @package WPSocial SEO Booster
			 * @since	1.0.0
			 */
		?>
        <div class="videos">
			<h4 class="heading"><?php _e( 'Rich Snippets Videos', 'wpsseo' ); ?></h4>
			<table class="form-table">	
				<tr valign="top">
					<th>
						<label><?php _e( 'Info: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<p><?php _e( 'Note that while Google supports video markup, they currently use it only to improve their video search results.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_video_name"><?php _e( 'Name: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_video_name" id="wps_seo_booster_video_name"  value="<?php esc_attr_e( $wps_seo_booster_video_name ); ?>" />  
						<p><?php _e( 'The title of the video.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_video_description"><?php _e( 'Description: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<textarea id="wps_seo_booster_video_description" name="wps_seo_booster_video_description" class="large-text" rows="3"><?php esc_attr_e( $wps_seo_booster_video_description ); ?></textarea> 
						<p><?php _e( 'The description of the video.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_video_image"><?php _e( 'Video Thumbnail Image: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" id="wps_seo_booster_upload_image" name="wps_seo_booster_video_image" value="<?php echo esc_url( $wps_seo_booster_video_image ); ?>">
						<input type="button" class="button-secondary" id="wps_seo_booster_upload_button" rel="<?php echo $post->ID; ?>" value="<?php echo esc_attr_e( 'Add Image', 'wpsseo' ); ?>">
						<p><?php _e( 'Images must be at least 160 x 90 pixels and at most 1920x1080 pixels. We recommend images in .jpg, .png, or. gif formats.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_video_url"><?php _e( 'Video URL: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" name="wps_seo_booster_video_url" id="wps_seo_booster_video_url"  value="<?php esc_attr_e( $wps_seo_booster_video_url ); ?>" />  
						<p><?php _e( 'A URL pointing to the actual video media file. This file should be in .mpg, .mpeg, .mp4, .m4v, .mov, .wmv, .asf, .avi, .ra, .ram, .rm, .flv, or other video file format. All files must be accessible via HTTP. Example: http://www.example.com/video123.flv', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_video_embed"><?php _e( 'Embed URL: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" name="wps_seo_booster_video_embed" id="wps_seo_booster_video_embed"  value="<?php esc_attr_e( $wps_seo_booster_video_embed ); ?>" /> 
						<p><?php _e( 'A URL pointing to a player for the specific video. Usually this is the information in the src element of an <code>< embed ></code> tag. Example: Dailymotion: http://www.dailymotion.com/swf/x1o2g', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_video_type"><?php _e( 'Video Type: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_video_type" id="wps_seo_booster_video_type"  value="<?php esc_attr_e( $wps_seo_booster_video_type ); ?>" />  
						<p><?php _e( 'Enter the type of the video. Example: application/x-shockwave-flash', 'wpsseo' ); ?></p>
					</td>
				</tr>
			</table>
        </div><!-- .videos -->
		<?php
			/* ==== End WPSocial Seo Booster Schema.org Video Meta Box Values ==== */
		?>
		
		<?php
			/* ==== Begin WPSocial Seo Booster Schema.org Event Meta Box Values ==== */

			/**
			 * Display Event 
			 *
			 * Displaying the schema.org (microdata) event values within the WPSocial SEO Booster meta box.
			 *
			 * @package WPSocial SEO Booster
			 * @since	1.0.0
			 */
		?>
        <div class="event">
			<h4 class="heading"><?php _e( 'Rich Snippets Event', 'wpsseo' ); ?></h4>
			<table class="form-table">	
				<tr valign="top">
					<th>
						<label><?php _e( 'Info: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<p><?php _e( 'The Rich Snippets for an Event are only being added to the code and won\'t be displayed within your content.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_name"><?php _e( 'Event Name: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_event_name" id="wps_seo_booster_event_name"  value="<?php esc_attr_e( $wps_seo_booster_event_name ); ?>" />  
						<p><?php _e( 'Enter the name of the event.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_image"><?php _e( 'Event Image: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" id="wps_seo_booster_upload_image" name="wps_seo_booster_event_image" value="<?php echo esc_url( $wps_seo_booster_event_image ); ?>">
						<input type="button" class="button-secondary" id="wps_seo_booster_upload_button" rel="<?php echo $post->ID; ?>" value="<?php echo esc_attr_e( 'Add Image', 'wpsseo' ); ?>">
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_description"><?php _e( 'Event Description: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<textarea id="wps_seo_booster_event_description" name="wps_seo_booster_event_description" class="large-text" rows="3"><?php esc_attr_e( $wps_seo_booster_event_description ); ?></textarea> 
						<p><?php _e( 'Enter a short description for the event.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_date_start"><?php _e( 'Start Date: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_event_date_start" id="wps_seo_booster_event_date_start"  value="<?php esc_attr_e( $wps_seo_booster_event_date_start ); ?>" />  
						<p><?php _e( 'Enter the start date for the event. The date format has to be like: 2012-10-15T19:00:00', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_date_end"><?php _e( 'End Date: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_event_date_end" id="wps_seo_booster_event_date_end"  value="<?php esc_attr_e( $wps_seo_booster_event_date_end ); ?>" />  
						<p><?php _e( 'Enter the end date for the event. The date format has to be like: 2012-10-15T19:00:00', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_location"><?php _e( 'Event Location: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_event_location" id="wps_seo_booster_event_location"  value="<?php esc_attr_e( $wps_seo_booster_event_location ); ?>" />
						<p><?php _e( 'Enter the location for the event. Example: Warfield Theatre', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign='top'>
					<th>
						<label for="wps_seo_booster_event_location_street"><?php _e( 'Street:', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_event_location_street" id="wps_seo_booster_event_location_street"  value="<?php esc_attr_e( $wps_seo_booster_event_location_street ); ?>" />
						<p><?php _e( 'Enter the street of the event location.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_location_locality"><?php _e( 'Locality: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_event_location_locality" id="wps_seo_booster_event_location_locality"  value="<?php esc_attr_e( $wps_seo_booster_event_location_locality ); ?>" />  
						<p><?php _e( 'Enter the locality of the event location', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_location_region"><?php _e( 'Region: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_event_location_region" id="wps_seo_booster_event_location_region"  value="<?php esc_attr_e( $wps_seo_booster_event_location_region ); ?>" />  
						<p><?php _e( 'Enter the region of the event location.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_type"><?php _e( 'Event Type: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" name="wps_seo_booster_event_type" id="wps_seo_booster_event_type"  value="<?php esc_attr_e( $wps_seo_booster_event_type ); ?>" />  
						<p><?php _e( 'Enter the type of the event. Example: Concert', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_ticket_price"><?php _e( 'Ticket Price: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_event_ticket_price" id="wps_seo_booster_event_ticket_price"  value="<?php esc_attr_e( $wps_seo_booster_event_ticket_price ); ?>" />  
						<p><?php _e( 'Enter the price for a ticket here. If there are different price classes available use the fields below for the lowest and highest price.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_ticket_price_low"><?php _e( 'Ticket Price Low: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_event_ticket_price_low" id="wps_seo_booster_event_ticket_price_low"  value="<?php esc_attr_e( $wps_seo_booster_event_ticket_price_low ); ?>" />  
						<p><?php _e( 'Enter the lowest ticket price.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_ticket_price_high"><?php _e( 'Ticket Price High: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_event_ticket_price_high" id="wps_seo_booster_event_ticket_price_high"  value="<?php esc_attr_e( $wps_seo_booster_event_ticket_price_high ); ?>" />  
						<p><?php _e( 'Enter the highest ticket price.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_ticket_price_currency"><?php _e( 'Ticket Price Currency: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_event_ticket_price_currency" id="wps_seo_booster_event_ticket_price_currency"  value="<?php esc_attr_e( $wps_seo_booster_event_ticket_price_currency ); ?>" />  
						<p><?php _e( 'Enter the currency for the ticket price. Example: if the price is in US Dollars enter USD.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_ticket_count"><?php _e( 'Tickets Available: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="small-text" name="wps_seo_booster_event_ticket_count" id="wps_seo_booster_event_ticket_count"  value="<?php esc_attr_e( $wps_seo_booster_event_ticket_count ); ?>" />  
						<p><?php _e( 'Enter the amount of available tickets.', 'wpsseo' ); ?></p>
					</td>
				</tr>
				
				<tr valign="top">
					<th>
						<label for="wps_seo_booster_event_ticket_url"><?php _e( 'Ticket URL: ', 'wpsseo' ); ?></label>
					</th>
					<td>
						<input type="text" class="large-text" name="wps_seo_booster_event_ticket_url" id="wps_seo_booster_event_ticket_url"  value="<?php esc_attr_e( $wps_seo_booster_event_ticket_url ); ?>" />  
						<p><?php _e( 'Enter the URL from where the tickets can be purchased.', 'wpsseo' ); ?></p>
					</td>
				</tr>
			</table>
        </div><!-- .event -->
		<?php
			/* ==== End WPSocial Seo Booster Schema.org Product Meta Box Values ==== */
		?>
		
    </div>
	
	<?php
}

function wps_seo_booster_star_rating_meta_box() {

	global $post;
	
	/********** Star Rating Values **********/	
	$wps_seo_booster_enable_rating_post = get_post_meta( $post->ID, '_wps_seo_booster_enable_rating_post', true );	
	$wps_seo_booster_placement = get_post_meta( $post->ID, '_wps_seo_booster_placement', true );
	$wps_seo_booster_animate = get_post_meta( $post->ID, '_wps_seo_booster_animate', true );
	$wps_seo_booster_unique = get_post_meta( $post->ID, '_wps_seo_booster_unique', true );	
	$wps_seo_booster_unique_base = get_post_meta( $post->ID,'_wps_seo_booster_unique_base', true );
	
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
		
	?>
	<span id="wps_seo_booster_flush_message"></span>
	<table width="100%">	
		<?php if( ( in_array( $post->post_type, $prevent_type ) ) || ( in_array( $post->ID, $prevent_items ) ) ) { } else { ?>
		<tr valign="top">
			<td>
				<label for="wps_seo_booster_enable_rating_post"><?php _e( 'Enable: ', 'wpsseo' ); ?></label>
			</td>
			<td>
				<input type="checkbox" id="wps_seo_booster_enable_rating_post" name="wps_seo_booster_enable_rating_post" <?php if( $wps_seo_booster_enable_rating_post == 'on' ) { ?>checked="checked"<?php } ?> />
				<p><?php _e( 'Check this box to enable the rating stars for this post.', 'wpsseo' ); ?></p>
			</td>
		</tr>
		<?php } ?>
		
		<tr valign="top">
			<td width="30%">
				<label for="wps_seo_booster_placement"><?php _e( 'Placement: ', 'wpsseo' ); ?></label>
			</td>
			<td>
				<select name="wps_seo_booster_placement">

					<?php
						$placement_setting = array(
							""				=> __( '', 'wpsseo' ),
							"top-left"		=> __( 'Top Left', 'wpsseo' ),
							"top-right"		=> __( 'Top Right', 'wpsseo' ),
							"bottom-left"	=> __( 'Bottom Left', 'wpsseo' ),
							"bottom-right"	=> __( 'Bottom Right', 'wpsseo' )
						);

						foreach ( $placement_setting as $key => $option ) {	
							?>
							<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_placement, $key ); ?>>
								<?php esc_html_e( $option ); ?>
							</option>
							<?php
						}	
					?> 														

				</select>
				<p><?php _e( 'Choose a custom position for the rating stars.', 'wpsseo' ) ?></p>
			</td>
		</tr>
		
		<tr valign="top">
			<td>
				<label for="wps_seo_booster_animate"><?php _e( 'Animation: ', 'wpsseo' ); ?></label>
			</td>
			<td>
				<select name="wps_seo_booster_animate">

					<?php
						$animate_setting = array( 
							""		=> __( '', 'wpsseo' ),
							"1"		=> __( 'On', 'wpsseo' ),
							"2"		=> __( 'Off', 'wpsseo' )
						);

						foreach ( $animate_setting as $key => $option ) {
							?>
							<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_animate, $key ); ?>>
								<?php esc_html_e( $option ); ?>
							</option>
							<?php
						}
					?> 														

				</select>
				<br />
				<p><?php _e( 'Choose wheter you want to use an animation for the rating stars.', 'wpsseo' ) ?></p>
			</td>
		</tr>
		
		<tr valign="top">
			<td>
				<label for="wps_seo_booster_unique"><?php _e( 'Unique Rating : ', 'wpsseo' ); ?></label>
			</td>
			<td>
				<select id="wps_seo_booster_unique" name="wps_seo_booster_unique">

					<?php
						$unique_setting = array(
							""		=> __( '', 'wpsseo' ),
							"1"		=> __( 'On', 'wpsseo' ),
							"2"		=> __( 'Off', 'wpsseo' )
						);

						foreach ( $unique_setting as $key => $option ) {	
							?>
							<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_unique, $key ); ?>>
								<?php esc_html_e( $option ); ?>
							</option>
							<?php
						}
					?> 														

				</select>
				
				<div id="wps_seo_booster_unique_base">
					<input type="radio" name="wps_seo_booster_unique_base" value="0" <?php if( empty( $wps_seo_booster_unique_base ) ) { echo 'checked="checked"'; } ?> ><span class="wps_star_rating_span" ><?php _e( 'Based on IP', 'wpsseo' ); ?></span>
					<br />
					<input type="radio" name="wps_seo_booster_unique_base" value="1" <?php if( isset( $wps_seo_booster_unique_base ) && !empty( $wps_seo_booster_unique_base ) ) { echo 'checked="checked"'; } ?> ><span class="wps_star_rating_span" ><?php _e( 'Based on User\'s Browser', 'wpsseo' ); ?></span>
				</div>
				<p><?php _e( 'Choose if you want to enable unique ratings ( Based on IP or User\'s Browser ) which means, that the user can only rate each content one time.', 'wpsseo' ) ?></p>
			</td>
		</tr>
		
		<tr valign="top">
			<td id="wps_seo_booster_flush_label">
				<label for="wps_seo_booster_flush_rating"><?php _e( 'Flush the Ratings: ', 'wpsseo' ); ?></label>
			</td>
			<td>
				<img class="wps-seo-rating-loader" id="wps_seo_meta_loader" src="<?php echo WPS_SEO_BOOSTER_URL.'/includes/images/rating-loader.gif';?>" />
				<input type="button" id="wps_seo_booster_flush_rating" class="button-secondary wps-seo-meta-flush-btn" rel="<?php echo $post->ID;?>" value="<?php _e( 'Flush Now!', 'wpsseo' ); ?>" /><br />
				<p><?php _e( 'If you want to clear all the received ratings for this post, then click on the Flush Now button. This will then delete all the ratings in the database and this post won\'t show any ratings anymore.', 'wpsseo' ) ?></p>
			</td>
		</tr>
	</table>
	<?php
}

include_once( WPS_SEO_BOOSTER_DIR . '/includes/metabox/wps-seo-booster-save-meta.php' ); // including save meta mox values function