<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Register Widget
 *
 * Does register our vcard widget with WordPress.
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
function wps_seo_booster_business_widget_init() {
  register_widget( 'WPS_SEO_BOOSTER_Vcard_Business_Widget' );
}

add_action( 'widgets_init', 'wps_seo_booster_business_widget_init' );

/**
 * Widget Class
 *
 * WPS_SEO_BOOSTER_Vcard_Business_Widget Class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 * @package WPSocial SEO Booster
 * @since 1.0.0
 */
class WPS_SEO_BOOSTER_Vcard_Business_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function WPS_SEO_BOOSTER_Vcard_Business_Widget() {
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_wps_seo_booster_business_vcard', 'description' => __( 'Use this widget to add a business vCard. It does support the Microdata Rich Snippets. These snippets are used by Google, Yahoo & Bing for their listings.', 'wpsseo' ) );
		
		/* Creating the widget. */
		$this->WP_Widget( 'widget_wps_seo_booster_business_vcard', __( 'SEO Booster: Business vCard', 'wpsseo' ), $widget_ops );
		
		/* Widget options. */
		$this->alt_option_name = 'widget_wps_seo_booster_business_vcard';

		add_action( 'save_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
	}
	
	/**
	 * Outputs the content of the widget
	 */
	function widget( $args, $instance ) {
		
		$cache = wp_cache_get( 'widget_wps_seo_booster_business_vcard', 'widget' );

		if ( !is_array( $cache ) ) {
			$cache = array();
		}

		if ( !isset( $args['widget_id'] ) ) {
			$args['widget_id'] = null;
		}

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( '', 'wpsseo' ) : $instance['title'], $instance, $this->id_base );
		if ( !isset( $instance['name'] ) ) { $instance['name'] = ''; }
		if ( !isset( $instance['street_address'] ) ) { $instance['street_address'] = ''; }
		if ( !isset( $instance['locality'] ) ) { $instance['locality'] = ''; }
		if ( !isset( $instance['region'] ) ) { $instance['region'] = ''; }
		if ( !isset( $instance['postal_code'] ) ) { $instance['postal_code'] = ''; }
		if ( !isset( $instance['tel'] ) ) { $instance['tel'] = ''; }
		if ( !isset( $instance['email'] ) ) { $instance['email'] = ''; }
		if ( !isset( $instance['site_name'] ) ) { $instance['site_name'] = ''; }

		echo $before_widget;
		if ( $title ) {
			echo $before_title;
			echo $title;
			echo $after_title;
		}
		?>
			<div class="wps-seo-booster-businesscard">
				<div itemscope itemtype="http://data-vocabulary.org/Organization"> 
					<span class="name" itemprop="name"><?php echo $instance['name']; ?></span>
					<span class="address" itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
						<?php if( $instance['street_address'] != '' ) : ?>
							<span class="street-address" itemprop="street-address"><?php echo $instance['street_address']; ?></span><br />
						<?php endif; ?>
						<span class="address-inner">
							<?php if( $instance['pc_front'] == true ) : ?>
								<?php if( $instance['postal_code'] != '' ) : ?>
									<span class="postal-code" itemprop="postal-code"><?php echo $instance['postal_code']; ?></span>
								<?php endif; ?>
								<?php if( $instance['locality'] != '' ) : ?>
									<span class="locality" itemprop="locality"><?php echo $instance['locality']; ?></span><br />
								<?php endif; ?>
								<span class="address-inner">
									<?php if( $instance['region'] != '' ) : ?>
										<span class="region" itemprop="region"><?php echo $instance['region']; ?></span><br />
									<?php endif; ?>	
								</span>
							<?php else: ?>
								<?php if( $instance['locality'] != '' ) : ?>
									<span class="locality" itemprop="locality"><?php echo $instance['locality']; ?></span>,
								<?php endif; ?>
								<?php if( $instance['region'] != '' ) : ?>
									<span class="region" itemprop="region"><?php echo $instance['region']; ?></span>
								<?php endif; ?>
								<?php if( $instance['postal_code'] != '' ) : ?>
									<span class="postal-code" itemprop="postal-code"><?php echo $instance['postal_code']; ?></span><br />
								<?php endif; ?>
							<?php endif; ?>
						</span>
						<span class="address-inner">
							<?php if( $instance['country'] != '' ) : ?>
								<span class="country-name" itemprop="region"><?php echo $instance['country']; ?></span>
							<?php endif; ?>
						</span>
					</span>
				<?php if( $instance['tel'] != '' ) : ?>
					<span class="tel" itemprop="tel"><?php echo $instance['tel']; ?></span>
				<?php endif; ?>
				<?php if( $instance['email'] != '' ) : ?>
					<span class="email" itemprop="email">
					<?php if( $instance['email_link'] == true ) : ?>
					<a href="mailto:<?php echo $instance['email']; ?>">
					<?php endif; ?>
					<?php echo $instance['email']; ?>
					<?php if( $instance['email_link'] == true ) : ?>
					</a>
					<?php endif; ?>
					</span>
				<?php endif; ?>
				<?php if( $instance['site_name'] != '' ) : ?>
					<a class="url" href="<?php echo home_url('/'); ?>" itemprop="url"><?php echo $instance['site_name']; ?></a>
				<?php endif; ?>
				</div>
			</div>			
				
		<?php
		echo $after_widget;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_wps_seo_booster_business_vcard', $cache, 'widget' );
	}

	/**
	 * Updates the widget control options for the particular instance of the widget
	 */
	function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;
		
		/* Set the instance to the new instance. */
		$instance = $new_instance;
		
		/* Check boxes */
		$instance['pc_front'] = ( isset( $new_instance['pc_front'] ) ? 1 : 0 );
		$instance['email_link'] = ( isset( $new_instance['email_link'] ) ? 1 : 0 );
			
		/* Input fields */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );
		$instance['street_address'] = strip_tags( $new_instance['street_address'] );
		$instance['locality'] = strip_tags( $new_instance['locality'] );
		$instance['region'] = strip_tags( $new_instance['region'] );
		$instance['postal_code'] = strip_tags( $new_instance['postal_code'] );
		$instance['country'] = strip_tags( $new_instance['country'] );
		$instance['tel'] = strip_tags( $new_instance['tel'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['site_name'] = strip_tags( $new_instance['site_name'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_wps_seo_booster_business_vcard'] ) ) {
		  delete_option( 'widget_wps_seo_booster_business_vcard' );
		}

		return $instance;
	}
	
	/**
	 * Flushing the widget cache
	 */
	function flush_widget_cache() {
		wp_cache_delete( 'widget_wps_seo_booster_business_vcard', 'widget' );
	}

	/*
	 * Displays the widget form in the admin panel
	 */
	function form( $instance ) {
	
		$defaults = array( 'pc_front' => 'false', 'email_link' => 'false' );
		
        $instance = wp_parse_args( ( array ) $instance, $defaults );
	
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$name = isset( $instance['name'] ) ? esc_attr( $instance['name'] ) : '';
		$street_address = isset( $instance['street_address'] ) ? esc_attr( $instance['street_address'] ) : '';
		$locality = isset( $instance['locality'] ) ? esc_attr( $instance['locality'] ) : '';
		$region = isset( $instance['region'] ) ? esc_attr( $instance['region'] ) : '';
		$postal_code = isset( $instance['postal_code'] ) ? esc_attr( $instance['postal_code'] ) : '';
		$country = isset( $instance['country'] ) ? esc_attr( $instance['country'] ) : '';
		$tel = isset( $instance['tel'] ) ? esc_attr( $instance['tel'] ) : '';
		$email = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
		$site_name = isset( $instance['site_name'] ) ? esc_attr( $instance['site_name'] ) : '';
	  
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title (optional):', 'wpsseo' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php _e( 'Business Name:', 'wpsseo' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'street_address ') ); ?>"><?php _e( 'Street Address:', 'wpsseo' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'street_address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'street_address' ) ); ?>" type="text" value="<?php echo esc_attr( $street_address ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'locality' ) ); ?>"><?php _e( 'City/Locality:', 'wpsseo' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'locality ') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'locality' ) ); ?>" type="text" value="<?php echo esc_attr( $locality ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'region' ) ); ?>"><?php _e( 'State/Region:', 'wpsseo' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'region' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'region' ) ); ?>" type="text" value="<?php echo esc_attr( $region ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'postal_code' ) ); ?>"><?php _e( 'Zipcode/Postal Code:', 'wpsseo' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'postal_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'postal_code' ) ); ?>" type="text" value="<?php echo esc_attr( $postal_code ); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['pc_front'], true ); ?> id="<?php echo $this->get_field_id( 'pc_front' ); ?>" name="<?php echo $this->get_field_name( 'pc_front' ); ?>" /> 
				<label for="<?php echo $this->get_field_id( 'pc_front' ); ?>"><?php _e( 'Postal Code on front of City?', 'wpsseo'); ?></label>  
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'country' ) ); ?>"><?php _e( 'Country:', 'wpsseo' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'country' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'country' ) ); ?>" type="text" value="<?php echo esc_attr( $country ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tel' ) ); ?>"><?php _e( 'Telephone:', 'wpsseo' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tel' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tel' ) ); ?>" type="text" value="<?php echo esc_attr( $tel ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php _e( 'Email:', 'wpsseo' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['email_link'], true ); ?> id="<?php echo $this->get_field_id( 'email_link' ); ?>" name="<?php echo $this->get_field_name( 'email_link' ); ?>" /> 
				<label for="<?php echo $this->get_field_id( 'email_link' ); ?>"><?php _e( 'Link Email Address?', 'wpsseo'); ?></label>  
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'site_name' ) ); ?>"><?php _e( 'Website Name:', 'wpsseo' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'site_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'site_name' ) ); ?>" type="text" value="<?php echo esc_attr( $site_name ); ?>" />
			</p>
		<?php
	}
}