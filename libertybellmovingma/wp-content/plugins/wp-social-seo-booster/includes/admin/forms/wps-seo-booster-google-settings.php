<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Google Authorship Settings
 *
 * The html markup for the google authorship settings box.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
?>

<!-- beginning of the google authorship settings meta box -->
<div id="wps-seo-booster-google-authorship" class="post-box-container">
	<div class="metabox-holder">	
		<div class="meta-box-sortables ui-sortable">
			<div id="google_authorship" class="postbox">	
				<div class="handlediv" title="<?php _e( 'Click to toggle', 'wpsseo' ); ?>"><br /></div>
									
					<!-- google authorship settings box title -->
					<h3 class="hndle">
						<span style='vertical-align: top;'><?php _e( 'Google Authorship Markup Settings', 'wpsseo' ); ?></span>
					</h3>
									
					<div class="inside">
										
						<table class="form-table">											
							<tbody>											
								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[gplus_home]"><?php _e( 'Homepage Author:', 'wpsseo' ); ?></label>
									</th>
									<td>
									<?php wp_dropdown_users( array( 'show_option_none' => __( 'Don\'t show', 'wpsseo' ), 'name' => 'wps_seo_booster_options[gplus_home]', 'class' => 'select','selected' => isset( $wps_seo_booster_options['gplus_home'] ) ? $wps_seo_booster_options['gplus_home'] : '' ) ); ?>
									<p><small><?php _e( 'Choose a user for the homepage. This will be used for the <code>rel="author"</code> on the homepage. Make sure the chosen user did enter his/her Google+ profile link on their profile page.', 'wpsseo' ); ?></small></p>
									</td>
								</tr>   

								<tr valign="top">
									<th scope="row">
										<label for="wps_seo_booster_options[gplus_publisher]"><?php _e( 'Google Plus Publisher:', 'wpsseo' ); ?></label>
									</th>
									<td>
										<input type="text" name="wps_seo_booster_options[gplus_publisher]" id="wps_seo_booster_options[gplus_publisher]" value="<?php echo esc_url( $wps_seo_booster_options['gplus_publisher'] ); ?>" class="large-text" />
										<p><small><?php _e( 'Enter your Google Plus page URL (example: <code>https://plus.google.com/105389611532237339285</code>) here if you have set up a "Google+ Page" for your organization or product, and the plugin will put a rel="publisher" link to the specified Google+ page on your home page.', 'wpsseo' ); ?><code><?php echo bloginfo( 'wpurl' ); ?></code></small></p>
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
							
			</div><!-- #google_authorship -->
		</div><!-- .meta-box-sortables ui-sortable -->
	</div><!-- .metabox-holder -->
</div><!-- #wps-seo-booster-google-authorship -->
<!-- end of the google autoship settings meta box -->