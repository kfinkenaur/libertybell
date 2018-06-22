<?php
function sydneyii_license_menu() {
	add_theme_page( 'Theme License', 'Theme License', 'manage_options', 'sydneyii_license', 'sydneyii_license_page' );
}
add_action('admin_menu', 'sydneyii_license_menu');
function sydneyii_license_page() {
	$license 	= get_option( 'sydneyii_license_key' );
	$status 	= get_option( 'sydneyii_license_status' );
	?>
	<div class="wrap">
		<h2><?php _e('Theme License'); ?></h2>
		<form method="post" action="options.php">
		
			<?php settings_fields('edd_sample_license'); ?>
			
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="sydneyii_license_key" name="sydneyii_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="sydneyii_license_key"><?php _e('Enter your license key'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Activate License'); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;"><?php _e('active'); ?></span>
								<?php } else {
									wp_nonce_field( 'sydneyii_sample_nonce', 'sydneyii_sample_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_license_activate" value="<?php _e('Activate License'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>	
			<?php submit_button(); ?>
		
		</form>
	<?php
}
function sydneyii_license_register_option() {
	// creates our settings in the options table
	register_setting('edd_sample_license', 'sydneyii_license_key', 'edd_sanitize_license' );
}
add_action('admin_init', 'sydneyii_license_register_option');
function edd_sanitize_license( $new ) {
	$old = get_option( 'sydneyii_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'sydneyii_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

function sydneyii_license_activate() {
	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_activate'] ) ) {
		// run a quick security check 
	 	if( ! check_admin_referer( 'sydneyii_sample_nonce', 'sydneyii_sample_nonce' ) ) 	
			return; // get out if we didn't click the Activate button
		// retrieve the license from the database
		$license = trim( $_POST[ 'sydneyii_license_key'] );
			
		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'activate_license', 
			'license' 	=> $license, 
			'item_name' => urlencode( ATHEMES_THEME_NAME ),
			'url'       => home_url()
		);
		
		// Call the custom API.
		$response = wp_remote_post( ATHEMES_STORE_URL, array(
			'timeout'   => 15,
			'sslverify' => false,
			'body'      => $api_params
		) );
		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;
		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "active" or "inactive"
		update_option( 'sydneyii_license_status', $license_data->license );
	}
}
add_action('admin_init', 'sydneyii_license_activate');