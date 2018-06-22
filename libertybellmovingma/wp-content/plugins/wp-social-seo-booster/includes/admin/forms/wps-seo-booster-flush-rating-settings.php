<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Flush Rating Settings
 *
 * The html markup for the flush star ratings settings box.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
?>

<!-- beginning of the flush rating settings meta box -->
<div id="wps-seo-booster-flush" class="post-box-container">
	<div class="metabox-holder">	
		<div class="meta-box-sortables ui-sortable">
			<div id="flush_rating" class="postbox">
				<div class="handlediv" title="<?php _e( 'Click to toggle', 'wpsseo' ); ?>"><br /></div>
			
				<h3 class="hndle">
					<span style="vertical-align: top;"><?php esc_attr_e( 'Flush Rating', 'wpsseo' ); ?></span>
				</h3>

				<div class="inside">

					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label><?php esc_attr_e( 'Reset the Ratings:', 'wpsseo' ); ?></label>
								</th>
								<td>
									<ul class="wps-seo-booster-indvisual" id="wps-seo-booster-indivisual">
									<?php 
										$all_types = get_post_types( array( 'public'=>true ), 'objects' );
										$all_types = is_array( $all_types ) ? $all_types : array();
									
										foreach( $all_types as $type ) {										
											if( $type->name != 'attachment' ) {
												if( !is_object( $type ) ) {
													continue;
												}
											
												$label = @$type->labels->name ? $type->labels->name : $type->name;

												$individual = '<a href="javascript:void(0);" id="wps_seo_booster_indivisual_data_'.$type->name.'"  onclick="wps_seo_booster_popup_indivisual(\''.$type->name.'\')" >' . __( 'Choose individual', 'wpsseo' ) . '</a>';
									?>
										<li>
											<input type="checkbox" class="wps_seo_booster_all_posts" id="wps_seo_booster_prevent_<?php echo $type->name;?>" name="wps_seo_booster_options[prevent_type][]" value="<?php echo $type->name;?>">
											<label for="wps_seo_booster_prevent_<?php echo $type->name;?>">
												<?php echo $label;?>
											</label>
											&nbsp;&nbsp;
											<?php echo $individual;?>
											&nbsp;&nbsp;
											<label id="wps_seo_booster_selected_indivisual_<?php echo $type->name;?>" class="wps_seo_booster_label">
												<?php echo '( 0 ) Selected';?>
											</label>
										</li>

									<?php 	$query = new WP_Query;
											$all_ind_items = $query->query( array(
												'post_type' => $type->name,
												'posts_per_page' => -1
											));
									?>
																	
										<div id="wps_seo_booster_indivisual_datacontent_<?php echo $type->name;?>"  class="wps-seo-booster-whitecontent">
															
											<div class="wps-seo-booster-header">
												<div class="wps-seo-booster-header-title">
													<?php _e('Flush Rating','wpsseo')?>
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
													<?php if(!empty($all_ind_items)) { ?>
														<a href="javascript:void(0);" onclick="wps_seo_booster_checkall('<?php echo $type->name;?>');"><?php esc_attr_e( 'Check all', 'wpsseo' ); ?></a>
														&nbsp;&nbsp;&nbsp;
														<a href="javascript:void(0);" onclick="wps_seo_booster_uncheckall('<?php echo $type->name;?>');"><?php esc_attr_e( 'Uncheck all', 'wpsseo' ); ?></a>
														&nbsp;&nbsp;&nbsp;
													<?php } ?>
														<input type="submit" value="Done" id="wps_seo_booster_set_submit_indivisual" name="wps_seo_booster_set_submit" class="button-primary">
													</div>
								
													<div class="wps_seo_booster_clear"></div>
												</div>
																		
												<div class="wps_seo_booster_indivisual_entries_data">
													<ul>
												<?php 	
													if( !empty( $all_ind_items ) ) {								
														foreach( $all_ind_items as $items ) { 
															$posttitle = $items->post_title;
															if( strlen( $posttitle ) > 50 ) {
																$posttitle = substr( $posttitle, 0, 50 );
																$posttitle = $posttitle.'...';
															} else {
																$posttitle = $posttitle;
															}
												?>
														<li>
															<input type="checkbox" id="wps_seo_booster_prevent_<?php echo $items->ID;?>" name="wps_seo_booster_options[prevent_item_<?php echo $type->name;?>][]" value="<?php echo $items->ID;?>">
															<label for="wps_seo_booster_prevent_<?php echo $items->ID;?>">
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
								<td colspan="2">
									<input type="button" value="Flush Now!" id="wps_seo_booster_set_submit" class="button-primary">
									<span id="wps_seo_rate_loader">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								</td>
							</tr>
						</tbody>
					</table><!-- .form-table -->						
						
				</div><!-- .inside -->
					
			</div><!-- #flush_rating -->
		</div><!-- .meta-box-sortables ui-sortable -->
	</div><!-- .metabox-holder -->
</div><!-- #wps-seo-booster-flush -->
<!-- end of the flush rating settings meta box -->

<div class="wps-seo-booster-overlay"></div>