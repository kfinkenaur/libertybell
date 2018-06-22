<div class="wps-seo-manual">

	<h2><?php esc_attr_e( 'Here are some of our other WordPress plugins which you might want to check out.', 'wpsseo' ); ?></h2>
	
	<?php 	$lang = get_bloginfo('language'); 
	
			$wps_seo_url = '';
			$wps_fbre_url = '';
			$wps_tb_url = '';
			$wps_fbml_url = '';
	
			if( $lang == 'de-DE' ) {
				$wps_seo_url = '//wpsocial.com/product/wp-social-seo-booster-pro/';
				$wps_fbre_url = '//wpsocial.com/product/social-review-engine/';
				$wps_tb_url = '//wpsocial.com/product/wp-social-traffic-blaster/';
				$wps_fbml_url = '//wpsocial.com/product/social-member-lock/';
			} else {
				$wps_seo_url = '//wpsocial.com/product/wp-social-seo-booster-pro/';
				$wps_fbre_url = '//wpsocial.com/product/social-review-engine/';
				$wps_tb_url = '//wpsocial.com/product/wp-social-traffic-blaster/';
				$wps_fbml_url = '//wpsocial.com/product/social-member-lock/';
			}
	?>
	
	<h3>WP Social SEO Booster Pro</h3>
	<p><?php esc_attr_e( 'This is the same plugin as the one you have installed but with more features such as:', 'wpsseo' ); ?></p>
	<p>- <?php esc_attr_e( 'Supports Pages', 'wpsseo' ); ?></p>
	<p>- <?php esc_attr_e( 'Supports All Post Types', 'wpsseo' ); ?></p>
	<p>- <?php esc_attr_e( 'Shortcodes for the Rich Snippets Templates', 'wpsseo' ); ?></p>
	<p>- <?php esc_attr_e( 'Includes styling options for all the different boxes (Reviews, Software, Recipres etc.)', 'wpsseo' ); ?></p>
	<p>- <?php esc_attr_e( 'Includes the option to add a call to action button with link within the review box', 'wpsseo' ); ?></p>
	<p>- <?php esc_attr_e( 'Supports Custom Google Itemprop entries', 'wpsseo' ); ?></p>
	<p>- <?php esc_attr_e( 'Supports all Twitter Card types', 'wpsseo' ); ?></p>
	<p>- <?php esc_attr_e( 'Unlimited Priority Support', 'wpsseo' ); ?></p>
	<p>- <?php esc_attr_e( 'Unlimited Pro Updates', 'wpsseo' ); ?></p>
	<p><a href="<?php echo esc_url_raw( $wps_seo_url ); ?>" target="_blank" rel="nofollow"><?php esc_attr_e( 'Learn More >>', 'wpsseo' ); ?></a></p>
	
	<h3>WP Social Review Engine</h3>
	<p><?php esc_attr_e( 'Add FB Review Engine to Your Blog and Turn Every Review into a Viral Profit Traffic Storm! Instantly Create a Viral Stream of Never Ending "Buyer" Traffic to ANY Product or Service and Watch Your Conversion Rates Explode!', 'wpsseo' ); ?></p>
	<p><a href="<?php echo esc_url_raw( $wps_fbre_url ); ?>" target="_blank" rel="nofollow"><?php esc_attr_e( 'Learn More >>', 'wpsseo' ); ?></a></p>
	
	<h3>WP Social Traffic Blaster</h3>
	<p><?php esc_attr_e( 'Google now looks at how "Social" your blog is and the next Step in the Social process is getting your Blog more "Shares".  Without Social Sharing on Your Blog, you are going nowhere and just adding a bunch of Social Buttons to each post isn\'t going to get people clicking and sharing. You have to Give Your Visitors a REASON to want to Share your Content. With WP Social Traffic Blaster you can Turn on the Traffic Faucet and Never Turn it Off!', 'wpsseo' ); ?></p>
	<p><a href="<?php echo esc_url_raw( $wps_tb_url ); ?>" target="_blank" rel="nofollow"><?php esc_attr_e( 'Learn More >>', 'wpsseo' ); ?></a></p>
	
	<h3>WP Social FB Member Lock</h3>
	<p><?php esc_attr_e( 'FB Member Lock allows you to create Facebook connect enabled membership sites which allow you to quickly turn ANY content you have on your blog into a squeeze page.', 'wpsseo' ); ?></p>	
	<p><a href="<?php echo esc_url_raw( $wps_fbml_url ); ?>" target="_blank" rel="nofollow"><?php esc_attr_e( 'Learn More >>', 'wpsseo' ); ?></a></p>
	
</div>