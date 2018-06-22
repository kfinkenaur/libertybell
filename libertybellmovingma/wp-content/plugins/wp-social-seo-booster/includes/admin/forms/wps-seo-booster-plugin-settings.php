<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Settings Page
 *
 * The code for the plugins main settings page
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
 ?>
<div class="wrap">

	<!-- wpsocial logo -->
	<img src="<?php echo WPS_SEO_BOOSTER_URL . 'includes/images/wps-logo.png'; ?>" style="height: 40px; width: 123px; margin: 10px 10px 10px 0; float:left;" alt="WPSocial.com Logo" />
		
	<!-- plugin name -->
	<h2 style="line-height: 40px; display: block;"><?php esc_attr_e( 'SEO Booster Settings', 'wpsseo' ); ?></h2><br />
	
	<!-- beginning of the plugin options form -->
	<form method="post" action="options.php">
		
		<?php settings_fields( 'wps_seo_booster_plugin_options' ); ?>
		<?php $wps_seo_booster_options = get_option( 'wps_seo_booster_options' ); ?>
			
		<!-- beginning of the left meta box section -->
		<div class="content">
				
			<?php
				/**
				 * Settings Boxes
				 *
				 * Including all the different settings boxes for the plugin options.
				 *
				 * @package WPSocial SEO Booster
				 * @since 1.0.0
				 */
			?>
				 
			<h2 class="nav-tab-wrapper wps-seo-h2">
			
				<a class="nav-tab nav-tab-active" href="#wps-seo-tab-0"><?php esc_attr_e( 'Settings', 'wpsseo' ); ?></a>
				<a class="nav-tab" href="#wps-seo-tab-1"><?php esc_attr_e( 'WP Social', 'wpsseo' ); ?></a>
				
			</h2><!--nav-tab-wrapper-->
			
			<div class="wps-seo-content">
			
				<div class="wps-seo-tab-content" id="wps-seo-tab-0"> 
				
					<?php
				
					// General
					include( WPS_SEO_BOOSTER_ADMIN . '/forms/wps-seo-booster-general-settings.php' );
					
					// Performance
					include( WPS_SEO_BOOSTER_ADMIN . '/forms/wps-seo-booster-performace-settings.php' );
					
					// Open Graph
					include( WPS_SEO_BOOSTER_ADMIN . '/forms/wps-seo-booster-ogp-settings.php' );
					
					// Google Authorship
					include( WPS_SEO_BOOSTER_ADMIN . '/forms/wps-seo-booster-google-settings.php' );

					// Star Rating
					include( WPS_SEO_BOOSTER_ADMIN . '/forms/wps-seo-booster-star-rating-settings.php' );

					// Flush Star Rating
					include( WPS_SEO_BOOSTER_ADMIN . '/forms/wps-seo-booster-flush-rating-settings.php' );
				
					?>
				
				</div>
		 	
				<div class="wps-seo-tab-content" id="wps-seo-tab-1">
						
					<?php
				
					// WP Social Plugins
					include( WPS_SEO_BOOSTER_ADMIN . '/forms/wps-seo-booster-wpsocial.php' );
				
					?>

				</div>
		 	
			</div>
			
		</div><!-- .content -->
			
	</form><!-- end of plugin options form -->
		
	<!-- including the about box -->
	<?php include( WPS_SEO_BOOSTER_ADMIN . '/wps-seo-booster-about-box.php' ); // the plugins about meta box ?>
	
</div><!-- .wrap -->