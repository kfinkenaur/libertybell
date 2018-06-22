<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

	$lang = get_bloginfo( 'language' ); 
	
	$wps_feed_url = '';
	$wps_seo_url = '';
	$wps_fb_url = '';
	$wps_gp_url = '';
	$wps_tw_url = '';
	
	/*if( $lang == 'de-DE' ) {
		$wps_feed_url = 'http://wpsocial.de/feed';
		$wps_seo_url = '//wpsocial.de/plugins/wp-social-seo-booster/';
		$wps_fb_url = '//facebook.com/WPSocialDE';
		$wps_gp_url = '//plus.google.com/103670535800573370160/posts';
		$wps_tw_url = 'danielwaser';
	} else {*/
		$wps_feed_url = 'http://wpsocial.com/feed';
		$wps_seo_url = '//wpsocial.com/product/wp-social-seo-booster-pro/';
		$wps_fb_url = '//facebook.com/WPSocial';
		$wps_gp_url = '//plus.google.com/105389611532237339285/posts';
		$wps_tw_url = 'wpsocial';
	//}

/**
 * About Box
 *
 * Show more information about the plugin, incl. support & docs links.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */	
 ?>
<div id="wps-seo-booster-about" class="post-box-container about">
	<div id="poststuff" class="metabox-holder">
		<div id="post-body" class="has-sidebar">
			<div id="post-body-content" class="has-sidebar-content">

				<div id="about_settings_postbox" class="postbox">	
									
					<h3 class="hndle">
						<span style="vertical-align: top;">WP Social</span>
					</h3>
									
					<div class="inside">
								
						<table class="form-table">
							<tr>
								<th>
									<?php _e( 'Plugin:', 'wpsseo' ); ?>
								</th>
								<td>
									<a href="<?php echo esc_url_raw( $wps_seo_url ); ?>" title="WP Social SEO Booster" target="_blank">WP Social SEO Booster</a>
								</td>
							</tr>
									
							<tr>
								<th>
									<?php _e( 'Version:', 'wpsseo' ); ?>
								</th>
								<td>
									<?php echo WPS_SEO_BOOSTER_VERSION; ?>
								</td>
							</tr>
									
							<tr>
								<th>
									<?php _e( 'Author:', 'wpsseo' ); ?>
								</th>
								<td>
									<a href="//www.danielwaser.com" target="_blank" rel="nofollow">Daniel Waser</a>
								</td>
							</tr>
							
							<tr>
								<th>
									<?php _e( 'Documentation:', 'wpsseo' ); ?>
								</th>
								<td>
									<p>
										<?php _e( 'Not quite sure how to use the plugin? Visit our Knowledge Base to learn how to use it properly.', 'wpsseo' ); ?>	
										<a href="http://wpsocial.com/knowledgebase/" target="_blank"><?php _e( 'WP Social Knowledge Base', 'wpsseo' ); ?></a>
									</p>
								</td>
							</tr>
							
						</table><!-- .form-table -->
											
					</div><!-- .inside -->
					
				</div><!-- #general_settings_postbox -->
								
			</div><!-- #post-body-content -->
		</div><!-- #post-body -->
	</div><!-- #poststuff -->
</div><!-- #wps-seo-booster-about -->	

<?php // Get RSS Feed(s)
	include_once( ABSPATH . WPINC . '/feed.php' );

	// Get a SimplePie feed object from the specified feed source.
	$rss = fetch_feed( $wps_feed_url );
	if ( !is_wp_error( $rss ) ) : // Checks that the object is created correctly 
    
	// Figure out how many total items there are, but limit it to 5. 
    $maxitems = $rss->get_item_quantity( 5 ); 

    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items( 0, $maxitems ); 
	endif;
?>

<div id="wps-social" class="post-box-container about">
	<div id="poststuff" class="metabox-holder">
		<div id="post-body" class="has-sidebar">
			<div id="post-body-content" class="has-sidebar-content">

				<div id="about_settings_postbox" class="postbox">	
									
					<h3 class="hndle">
						<span style="vertical-align: top;"><?php esc_attr_e( 'Latest News from WPSocial.com', 'wpsseo' ); ?></span>
					</h3>
									
					<div class="inside">
								
						<table class="form-table">
							<tr valign="top">
								<td>
									<ul <?php if ( $maxitems == 0 ) { echo ''; } else { echo 'style="margin-top: -16px;"'; } ?>">
										<?php 
											if ( $maxitems == 0 ) echo '<li>' . __( 'No items.', 'wpsseo' ) . '</li>';
											else
											
											// Loop through each feed item and display each item as a hyperlink.
											foreach ( $rss_items as $item ) : 
										?>
											<li>
												<div class="icon-option">
													<a href='<?php echo esc_url( $item->get_permalink() ); ?>' title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>' target="_blank"><img src="<?php echo WPS_SEO_BOOSTER_URL . 'includes/images/icons/wps.png'; ?>" alt="WPSocial News" title="<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>" />									
													<?php echo esc_html( $item->get_title() ); ?></a>
												</div>
											</li>
										<?php endforeach; ?>
									</ul>
								</td>
							</tr>
							
							<tr>
								<td valign="middle">
									<div class="icon-option"><a href="<?php echo esc_url_raw( $wps_fb_url ); ?>" target="_blank"><img src="<?php echo WPS_SEO_BOOSTER_URL . 'includes/images/icons/facebook.png'; ?>" alt="WP Social Facebook" title="<?php _e( 'Like WP Social on Facebook', 'wpsseo' ); ?>" /><?php _e( 'Like WP Social on Facebook', 'wpsseo' ); ?></a></div>
									<div class="icon-option"><a href="<?php echo esc_url_raw( $wps_gp_url ); ?>" target="_blank"><img src="<?php echo WPS_SEO_BOOSTER_URL . 'includes/images/icons/google-plus.png'; ?>" alt="WP Social Google+" title="<?php _e( 'Circle WP Social on Google+', 'wpsseo' ); ?>" /><?php _e( 'Circle WP Social on Google+', 'wpsseo' ); ?></a></div>
									<div class="icon-option"><a href="//twitter.com/<?php echo esc_attr_e( $wps_tw_url ); ?>" target="_blank"><img src="<?php echo WPS_SEO_BOOSTER_URL . 'includes/images/icons/twitter.png'; ?>" alt="WP Social Twitter" title="<?php _e( 'Follow WP Social on Twitter', 'wpsseo' ); ?>" /><?php _e( 'Follow WP Social on Twitter', 'wpsseo' ); ?></a></div>
									<div class="icon-option"><a href="<?php echo esc_url_raw( $wps_feed_url ); ?>" target="_blank"><img src="<?php echo WPS_SEO_BOOSTER_URL . 'includes/images/icons/rss.png'; ?>" alt="Subscribe with RSS" title="<?php _e( 'Subscribe with RSS', 'wpsseo' ); ?>" /><?php _e( 'Subscribe with RSS', 'wpsseo' ); ?></a></div>
									<div class="icon-option"><a href="http://wpsocial.com/wp-social-updates-discounts/" target="_blank"><img src="<?php echo WPS_SEO_BOOSTER_URL . 'includes/images/icons/email.png'; ?>" alt="Subscribe by email" title="<?php _e( 'Subscribe by email', 'wpsseo' ); ?>" /><?php _e( 'Subscribe by email', 'wpsseo' ); ?></a></div>
									<div class="clear"></div>
								</td>
							</tr>
									
						</table><!-- .form-table -->
											
					</div><!-- .inside -->
					
				</div><!-- #general_settings_postbox -->
								
			</div><!-- #post-body-content -->
		</div><!-- #post-body -->
	</div><!-- #poststuff -->
</div><!-- #wps-social-about -->			