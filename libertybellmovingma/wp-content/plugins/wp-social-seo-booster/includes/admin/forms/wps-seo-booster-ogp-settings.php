<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Open Graph Settings
 *
 * The html markup for the open graph settings box.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
?>

<!-- beginning of the open graph settings meta box -->
<div id="wps-seo-booster-ogp" class="post-box-container">
	<div class="metabox-holder">	
		<div class="meta-box-sortables ui-sortable">
			<div id="open_graph" class="postbox">	
				<div class="handlediv" title="<?php _e( 'Click to toggle', 'wpsseo' ); ?>"><br /></div>
								
					<!-- open graph settings box title -->
					<h3 class="hndle">
						<span style='vertical-align: top;'><?php _e( 'Open Graph Settings', 'wpsseo' ); ?></span>
					</h3>
									
					<div class="inside">
										
						<table class="form-table">											
							<tbody>
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[enable_opg]"><?php _e( 'Activate Open Graph:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input name="wps_seo_booster_options[enable_opg]" type="checkbox" value="1" <?php if ( isset( $wps_seo_booster_options['enable_opg'] ) ) { checked( '1', $wps_seo_booster_options['enable_opg'] ); } ?> />
										<p><small><?php _e( 'Uncheck the box to deactivate the open graph features.', 'wpsseo' ); ?></small></p>
									</td>
								</tr>
											
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[app_id]"><?php _e( 'Facebook App ID/API Key:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input type="text" name="wps_seo_booster_options[app_id]" id="wps_seo_booster_options[app_id]" value="<?php esc_attr_e( $wps_seo_booster_options['app_id'] ); ?>" class="large-text" />
										<p><small><?php _e( 'Enter the Facebook Application ID of the Fan Page which is associated with this website.', 'wpsseo' ); ?></small></p>
									</td>
								</tr>    
										
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[user_id]"><?php _e( 'Facebook Admins:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input type="text" name="wps_seo_booster_options[user_id]" id="wps_seo_booster_options[user_id]" value="<?php esc_attr_e( $wps_seo_booster_options['user_id'] ); ?>" class="large-text" /><br />
										<p><small><?php _e( 'Enter the User ID of the Facebook Fan Page Admin. If you changed the URL of your profile and you have your name in this URL, then the ID can be found by typing the following URL in to your browser: http://graph.facebook.com/USERNAME. Replace USERNAME with your name. If you have mire than one admin for a Fan Page than enter all the ID\'s in a comma separated list. This will enable Facebook insights.', 'wpsseo' ); ?></small></p>    
									</td>
								</tr>  
											
								<tr valign="top">
									<th scope="row">
										<label><?php _e( 'About Image Usage:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<p><?php _e( 'The image is being used to post on the user\'s wall when he/she likes/shares your post. The plugin will use the images in the following order: First it will check if you have entered an image in "Always Use This Image". If that is empty it will check if you uploaded an image in the "WPSocial SEO Booster Open Graph Metabox". If this is empty too it will check for a thumbnail (featured image) and if the featured image is emtpy the plugin will scan your content and if you\'re using an image within your content the plugin will use the first image found.', 'wpsseo' ); ?></p>
									</td>
								</tr> 
											
								<tr valign="top">
									<th scope="row">
										<label><?php _e( 'Info:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<p><?php _e( 'Default Open Graph images need to be at least 200 pixels wide for Facebook to recognize them as significant objects for enhancing Facebook "EdgeRank".', 'wpsseo' ); ?></p>
									</td>
								</tr> 

								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[allways_image]"><?php _e( 'Always Use This Image:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input type="text" class="large-text" id="allways_image" name="wps_seo_booster_options[allways_image]" value="<?php echo esc_url( $wps_seo_booster_options['allways_image'] ); ?>">
										<input type="button" class="button-secondary" id="allways_image_btn" name="allways_image_btn" value="<?php echo esc_attr_e( 'Add Image', 'wpsseo' ); ?>">
										<br />
										<p><small><?php _e( 'If an image is uploaded, this will always be used on Facebook for content sharing.', 'wpsseo' ); ?></small></p>    
									</td>
								</tr> 
										
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[default_image]"><?php _e( 'Default Image:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input type="text" class="large-text" id="default_image" name="wps_seo_booster_options[default_image]" value="<?php echo esc_url( $wps_seo_booster_options['default_image'] ); ?>">
										<input type="button" class="button-secondary" id="default_image_btn" name="default_image_btn" value="<?php echo esc_attr_e( 'Add Image', 'wpsseo' ); ?>">
										<br />
										<p><small><?php _e( 'If an image is uploaded, this will be used on Facebook for content sharing if you don\'t upload a custom image with your content.', 'wpsseo' ); ?></small></p>    
									</td>
								</tr> 
											
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[content_type]"><?php _e( 'Content Type:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<select name="wps_seo_booster_options[content_type]">
											<?php   												
												$content_type = array( "article" => __( 'Article', 'wpsseo' ),"book" => __( 'Book', 'wpsseo' ),"profile" => __( 'Profile', 'wpsseo' ),"website" => __( 'Website', 'wpsseo' ),"music.album" => __( 'Music Album', 'wpsseo' ),"music.song" => __( 'Song', 'wpsseo' ),"video.movie" => __( 'Movie', 'wpsseo' ),"video.tv_show" => __( 'TV Show', 'wpsseo' ), "video" => __( 'Video', 'wpsseo' ) );
																							
												foreach ( $content_type as $key => $option ) {											
													?>
													<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_options['content_type'], $key ); ?>>
														<?php esc_html_e( $option ); ?>
													</option>
													<?php
												}															
											?> 														
										</select> 
									</td>
								</tr> 
											
								<tr valign="top">
									<th scope="row">
										<label><?php _e( 'Homepage Settings:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<p><?php _e( 'The following values will be used for the homepage. Here you can enter custom values and if you activate them then they will be used on the homepage, regardless what other settings you have for the home page. This is a great feature to customize the open graph settings for the homepage.', 'wpsseo' ); ?></p>
									</td>
								</tr> 
											
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[home_page]"><?php _e( 'Activate Homepage Values:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input name="wps_seo_booster_options[home_page]" type="checkbox" value="1" <?php if ( isset( $wps_seo_booster_options['home_page'] ) ) { checked( '1', $wps_seo_booster_options['home_page'] ); } ?> />
										<p><small><?php _e( 'Check the box to activate the homepage values.', 'wpsseo' ); ?></small></p>  
									</td>
								</tr>
											
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[home_title]"><?php _e( 'Homepage Title:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input type="text" name="wps_seo_booster_options[home_title]" id="wps_seo_booster_options[home_title]" value="<?php esc_attr_e( $wps_seo_booster_options['home_title'] ); ?>" class="large-text" />
										<p><small><?php _e( 'Enter a title for the homepage.', 'wpsseo' ); ?></small></p>    
									</td>
								</tr> 
											
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[home_description]"><?php _e( 'Homepage Description:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<textarea name="wps_seo_booster_options[home_description]" id="wps_seo_booster_options[home_description]" class="large-text" /><?php esc_attr_e( $wps_seo_booster_options['home_description'] ); ?></textarea>
										<p><small><?php _e( 'Enter a description for the homepage.', 'wpsseo' ); ?></small></p>    
									</td>
								</tr> 
											
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[home_image]"><?php _e( 'Homepage Image:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input type="text" name="wps_seo_booster_options[home_image]" id="wps_seo_booster_options[home_image]" value="<?php echo esc_url( $wps_seo_booster_options['home_image'] ); ?>" class="large-text" /><br />
										<p><small><?php _e( 'Please use the FULL URL to the image (e.g. http://www.yourdomain.com/images/image.jpg). If set, this image will be used for the homepage.', 'wpsseo' ); ?></small></p>    
									</td>
								</tr> 
													
								<tr valign="top">
									<td>
										<!-- submit button to save changes -->
										<input type="submit" value="<?php _e ( 'Save Changes', 'wpsseo' ); ?>" id="wps_seo_booster_set_submit" name="wps_seo_booster_set_submit" class="button-primary">
									</td>
								</tr>  													
							</tbody>
						</table>
										
					</div><!-- .inside -->
									
			</div><!-- #open_graph -->
		</div><!-- .meta-box-sortables ui-sortable -->
	</div><!-- .metabox-holder -->
</div><!-- #wps-seo-booster-ogp -->
<!-- end of the open graph settings meta box -->