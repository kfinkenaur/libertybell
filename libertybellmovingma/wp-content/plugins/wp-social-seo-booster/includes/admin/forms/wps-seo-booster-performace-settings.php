<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Performance Settings
 *
 * The html markup for the performance settings box.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
?>

<!-- beginning of the performance settings meta box -->
<div id="wps-seo-booster-performance" class="post-box-container">
	<div class="metabox-holder">	
		<div class="meta-box-sortables ui-sortable">
			<div id="performance" class="postbox">	
				<div class="handlediv" title="<?php _e( 'Click to toggle', 'wpsseo' ); ?>"><br /></div>
								
					<!-- performance settings box title -->
					<h3 class="hndle">
						<span style='vertical-align: top;'><?php _e( 'Performance Settings', 'wpsseo' ); ?></span>
					</h3>
									
					<div class="inside">
										
						<table class="form-table">											
							<tbody>															
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[performace_header]"><?php _e( 'Cleanup Header:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input name="wps_seo_booster_options[performace_header]" type="checkbox" value="1" <?php if ( isset( $wps_seo_booster_options['performace_header'] ) ) { checked( '1', $wps_seo_booster_options['performace_header'] ); } ?> />
										<p><small><?php _e( 'Check this box to get the source code of the header cleaned up.', 'wpsseo' ); ?></small></p>
									</td>
								</tr>
											
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[performace_dashboard]"><?php _e( 'Dashboard Widgets:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input name="wps_seo_booster_options[performace_dashboard]" type="checkbox" value="1" <?php if ( isset( $wps_seo_booster_options['performace_dashboard'] ) ) { checked( '1', $wps_seo_booster_options['performace_dashboard'] ); } ?> />
										<p><small><?php _e( 'Check this box to remove some of the dashboard widgets.', 'wpsseo' ); ?></small></p>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[performace_htaccess]"><?php _e( 'HTML5 Boilerplate .htaccess:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input name="wps_seo_booster_options[performace_htaccess]" type="checkbox" value="1" <?php if ( isset( $wps_seo_booster_options['performace_htaccess'] ) ) { checked( '1', $wps_seo_booster_options['performace_htaccess'] ); } ?> />
										<p><small><?php _e( 'Check this box, if you want to add the HTML5 Boilerplate optimized performance entries to your site\'s .htaccess file. This will also add a bit more of security to your site.', 'wpsseo' ); ?></small></p>
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
									
			</div><!-- #performance -->
		</div><!-- .meta-box-sortables ui-sortable -->
	</div><!-- .metabox-holder -->
</div><!-- #wps-seo-booster-performance -->
<!-- end of the performance settings meta box -->