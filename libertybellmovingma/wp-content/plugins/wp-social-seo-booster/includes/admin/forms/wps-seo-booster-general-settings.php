<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * General Settings
 *
 * The html markup for the general settings box.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
?>

<!-- beginning of the general settings meta box -->
<div id="wps-seo-booster-general" class="post-box-container">
	<div class="metabox-holder">	
		<div class="meta-box-sortables ui-sortable">
			<div id="general" class="postbox">	
				<div class="handlediv" title="<?php _e( 'Click to toggle', 'wpsseo' ); ?>"><br /></div>
								
					<!-- general settings box title -->
					<h3 class="hndle">
						<span style='vertical-align: top;'><?php _e( 'General Settings', 'wpsseo' ); ?></span>
					</h3>
									
					<div class="inside">
										
						<table class="form-table">											
							<tbody>															
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[delete_options]"><?php _e( 'Delete Options:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input name="wps_seo_booster_options[delete_options]" type="checkbox" value="1" <?php if ( isset( $wps_seo_booster_options['delete_options'] ) ) { checked( '1', $wps_seo_booster_options['delete_options'] ); } ?> />
										<p><small><?php _e( 'Check this box, if you want to delete all the options from your database when you deactivate the plugin.', 'wpsseo' ); ?></small></p>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[hide_adminbar]"><?php _e( 'Hide Admin Bar Menu:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input name="wps_seo_booster_options[hide_adminbar]" type="checkbox" value="1" <?php if ( isset( $wps_seo_booster_options['hide_adminbar'] ) ) { checked( '1', $wps_seo_booster_options['hide_adminbar'] ); } ?> />
										<p><small><?php _e( 'Check this box, if you want to hide the admin bar entry.', 'wpsseo' ); ?></small></p>
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
									
			</div><!-- #general -->
		</div><!-- .meta-box-sortables ui-sortable -->
	</div><!-- .metabox-holder -->
</div><!-- #wps-seo-booster-general -->
<!-- end of the general settings meta box -->