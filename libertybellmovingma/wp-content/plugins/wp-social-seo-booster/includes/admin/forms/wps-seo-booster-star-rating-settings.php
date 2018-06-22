<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Star Rating Settings
 *
 * The html markup for the star ratings settings box.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
?>

<!-- beginning of the star rating settings meta box -->
<div id="wps-seo-booster-star-rating-settings" class="post-box-container">
	<div class="metabox-holder">	
		<div class="meta-box-sortables ui-sortable">
			<div id="star_rating_settings" class="postbox">	
				<div class="handlediv" title="<?php _e( 'Click to toggle', 'wpsseo' ); ?>"><br /></div>

					<!-- star rating settings box title -->
					<h3 class="hndle">
						<span style='vertical-align: top;'><?php _e( 'Star Rating Settings', 'wpsseo' ); ?></span>
					</h3>

					<div class="inside">

						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[enable_rating]"><?php _e( 'Enable Star Rating:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input name="wps_seo_booster_options[enable_rating]" type="checkbox" value="1" <?php if ( isset( $wps_seo_booster_options['enable_rating'] ) ) { checked( '1', $wps_seo_booster_options['enable_rating'] ); } ?> />
										<p><small><?php _e( 'Check the box to enable the star rating. You can also use the following shortcode for custom placement for the rating stars. [wps_ratings]. If you are using the shortcode, you don\'t need to activate the rating for this post.', 'wpsseo' ); ?></small></p>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">
										<label><?php esc_attr_e( 'Enable Ratings on:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input name="wps_seo_booster_options[need_home_rating]" type="checkbox" value="1" <?php if ( isset( $wps_seo_booster_options['need_home_rating'] ) ) { checked( '1', $wps_seo_booster_options['need_home_rating'] ); } ?> ><span class="wps_star_rating_span" ><?php _e( 'Home', 'wpsseo' ); ?></span></input>
										
										<ul class="wps-seo-booster-rating-indvisual" id="wps-seo-booster-rating-indvisual">
										<?php 
											$all_types = get_post_types( array( 'public'=>true ), 'objects' );
											$all_types = is_array( $all_types ) ? $all_types : array();
											$prevent_rating_types_data = get_option( 'wps_seo_booster_options' );
											if( !empty( $prevent_rating_types_data['prevent_rating_type'] ) ) {
												$prevent_rating_types = $prevent_rating_types_data['prevent_rating_type'];
											} else {
												$prevent_rating_types = '';
											}
															
											$prevent_rating_types = is_array( $prevent_rating_types ) ? $prevent_rating_types : array();
										
											foreach( $all_types as $type ) {	
												if( !empty( $prevent_rating_types_data['prevent_rating_item_' . $type->name] ) ) {
													$items_count = count( $prevent_rating_types_data['prevent_rating_item_'.$type->name] );
												} else {
													$prevent_rating_types_data['prevent_rating_item_'.$type->name] = '';
													$items_count = 0;
												}
												
												if( $type->name != 'attachment' ) {
													if( !is_object( $type ) ) {
														continue;
													}
												
													$label = @$type->labels->name ? $type->labels->name : $type->name;
													
													$selected = ( in_array( $type->name, $prevent_rating_types ) ) ? 'checked="checked"' : '';

													$individual = '<a href="javascript:void(0);" id="wps_seo_booster_rating_indivisual_data_'.$type->name.'"  onclick="wps_seo_booster_rating_popup_indivisual(\''.$type->name.'\')" >' . __( 'Choose individual', 'wpsseo' ) . '</a>';
										?>
											<li>
												<input type="checkbox" class="wps_seo_booster_rating_all_posts" id="wps_seo_booster_rating_prevent_<?php echo $type->name;?>" name="wps_seo_booster_options[prevent_rating_type][]" value="<?php echo $type->name;?>" <?php echo $selected; ?>>
												<label for="wps_seo_booster_rating_prevent_<?php echo $type->name;?>">
													<?php echo $label;?>
												</label>
												&nbsp;&nbsp;
												<?php echo $individual;?>
												&nbsp;&nbsp;
												<label id="wps_seo_booster_rating_selected_indivisual_<?php echo $type->name;?>" class="wps_seo_booster_rating_label">
													<?php echo '( ' . $items_count . ' ) ';?><?php _e( 'Selected', 'wpsseo' ); ?>
												</label>
											</li>

										<?php 	$query = new WP_Query;
												$all_ind_items = $query->query( array(
													'post_type' => $type->name,
													'posts_per_page' => -1
												));

												$prevent_rating_types_entries = get_option( 'wps_seo_booster_options' );
												if( !empty( $prevent_rating_types_entries['prevent_rating_item_'.$type->name] ) ) {
													$prevent_rating_items = $prevent_rating_types_entries['prevent_rating_item_'.$type->name];
												} else {
													$prevent_rating_items = '';
												}
															
												$prevent_rating_items = is_array( $prevent_rating_items ) ? $prevent_rating_items : array();
										?>
																		
											<div id="wps_seo_booster_rating_indivisual_datacontent_<?php echo $type->name;?>"  class="wps-seo-booster-whitecontent">
																
												<div class="wps-seo-booster-header">
													<div class="wps-seo-booster-header-title">
														<?php esc_attr_e( 'Enable Rating', 'wpsseo' )?>
													</div>
													<div class="wps-seo-booster-close">
														<a href="javascript:void(0);" class="wps-seo-booster-close-button">
															<img src="<?php echo WPS_SEO_BOOSTER_URL . 'includes/images/tb-close.png' ?>">
														</a>
													</div>
												</div>
														
												<div class="wps_seo_booster_content_div">
													<div class="wps_seo_booster_indivisual_header">
														<div class="wps_seo_booster_indivisual_title">
															<h2><?php echo $label;?></h2>
														</div>
														<div class="wps_seo_booster_indivisual_submit">
														<?php if( !empty( $all_ind_items ) ) { ?>
															<a href="javascript:void(0);" onclick="wps_seo_booster_rating_checkall('<?php echo $type->name;?>');"><?php esc_attr_e( 'Check all', 'wpsseo' ); ?></a>
															&nbsp;&nbsp;&nbsp;
															<a href="javascript:void(0);" onclick="wps_seo_booster_rating_uncheckall('<?php echo $type->name;?>');"><?php esc_attr_e( 'Uncheck all', 'wpsseo' ); ?></a>
															&nbsp;&nbsp;&nbsp;
														<?php } ?>
															<input type="submit" value="Done" id="wps_seo_booster_rating_set_submit_indivisual" name="wps_seo_booster_set_submit" class="button-primary">
														</div>
									
														<div class="wps_seo_booster_clear"></div>
													</div>
																			
													<div class="wps_seo_booster_indivisual_entries_data">
														<ul>
													<?php 	
														if( !empty( $all_ind_items ) ) {								
															foreach( $all_ind_items as $items ) { 
																$checked = ( in_array( $items->ID, $prevent_rating_items ) ) ? 'checked="checked"' : '';
																$posttitle = $items->post_title;
																if( strlen( $posttitle ) > 50 ) {
																	$posttitle = substr( $posttitle, 0, 50 );
																	$posttitle = $posttitle.'...';
																} else {
																	$posttitle = $posttitle;
																}
													?>
															<li>
																<input type="checkbox" id="wps_seo_booster_rating_prevent_<?php echo $items->ID;?>" name="wps_seo_booster_options[prevent_rating_item_<?php echo $type->name;?>][]" value="<?php echo $items->ID;?>" <?php echo $checked; ?>>
																<label for="wps_seo_booster_rating_prevent_<?php echo $items->ID;?>">
																	<?php echo $posttitle;?>
																</label>
															</li>																				
													<?php	} 
														} else { ?>
															<li><?php esc_attr_e( 'No Entries for this type.', 'wpsseo' ); ?></li>
													<?php	} ?>
																
														</ul>
													</div>
												</div>
											</div>	
										<?php			}
											} ?>
										</ul>	
										<p><small><?php _e( 'Select for which post type or individual entry you want to reset the received ratings to zero.', 'wpsseo' ); ?></small></p>
									</td>
								</tr>
						
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[placement_rating]"><?php _e( 'Placement:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<select name="wps_seo_booster_options[placement_rating]">
											<?php 
												$placement_setting = array(
																			"top-left"		=> __( 'Top Left', 'wpsseo' ),
																			"top-right"		=> __( 'Top Right', 'wpsseo' ),
																			"bottom-left"	=> __( 'Bottom Left', 'wpsseo' ),
																			"bottom-right"	=> __( 'Bottom Right', 'wpsseo' )
																		);

												foreach ( $placement_setting as $key => $option ) {	
													?>
													<option value="<?php esc_attr_e( $key ); ?>" <?php selected( $wps_seo_booster_options['placement_rating'], $key ); ?>>
														<?php esc_html_e( $option ); ?>
													</option>
													<?php
												}	
											?> 
										</select>
										<p><small><?php _e( 'Choose the position for the rating stars.', 'wpsseo' ); ?></small></p>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[animate_rating]"><?php _e( 'Animation:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input name="wps_seo_booster_options[animate_rating]" type="checkbox" value="1" <?php if ( isset( $wps_seo_booster_options['animate_rating'] ) ) { checked( '1', $wps_seo_booster_options['animate_rating'] ); } ?> />
										<p><small><?php _e( 'Check the box if you want enable an animation for the rating stars.', 'wpsseo' ); ?></small></p> 
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[unique_rating]"><?php _e( 'Unique Rating:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input id="wps_seo_booster_unique_rating" name="wps_seo_booster_options[unique_rating]" type="checkbox" value="1" <?php if ( isset( $wps_seo_booster_options['unique_rating'] ) ) { checked( '1', $wps_seo_booster_options['unique_rating'] ); } ?> />
										<div id="wps_seo_booster_unique_base_rating">
											<input type="radio" name="wps_seo_booster_options[unique_base_rating]" value="0" <?php if( empty($wps_seo_booster_options['unique_base_rating']) ) { echo 'checked="checked"'; } ?> ><span class="wps_star_rating_span" ><?php _e( 'Based on IP', 'wpsseo' ); ?></span>
											<input type="radio" name="wps_seo_booster_options[unique_base_rating]" value="1" <?php if( isset($wps_seo_booster_options['unique_base_rating']) && !empty($wps_seo_booster_options['unique_base_rating']) ) { echo 'checked="checked"'; } ?> ><span class="wps_star_rating_span" ><?php _e( 'Based on User\'s Browser', 'wpsseo' ); ?></span>
										</div>
										<p><small><?php _e( 'Check this box if you want to enable unique ratings ( Based on IP or User\'s Browser ) which means, that the user can only rate each content one time.', 'wpsseo' ); ?></small></p>  
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[cookie_day]"><?php _e( 'Set Cookie:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input name="wps_seo_booster_options[cookie_day]" type="text" value="<?php if ( isset( $wps_seo_booster_options['cookie_day'] ) ) { echo $wps_seo_booster_options['cookie_day']; } ?>" /> ( <strong><?php _e( 'days', 'wpsseo' ); ?></strong> )
										<p><small><?php _e( 'If the cookie is set, then the user won\'t be able to rate each content more than one time.', 'wpsseo' ); ?></small></p>  
									</td>
								</tr>
								
								<tr valign="top">
									<td colspan="2">
										<!-- submit button to save changes -->
										<input type="submit" value="<?php _e ( 'Save Changes', 'wpsseo' ); ?>" id="wps_seo_booster_set_submit" name="wps_seo_booster_set_submit" class="button-primary">
									</td>
								</tr>  
							</tbody>
						</table>

					</div><!-- .inside -->
					
					<div class="seo_booster_rating_overlay"></div>

			</div><!-- #star_rating_settings -->
		</div><!-- .meta-box-sortables ui-sortable -->
	</div><!-- .metabox-holder -->
</div><!-- #wps-seo-booster-star-rating-settings -->
<!-- end of the star rating settings meta box -->