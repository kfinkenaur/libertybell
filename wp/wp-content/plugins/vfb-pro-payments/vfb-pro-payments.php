<?php
/*
Plugin Name: Visual Form Builder Pro - Payments
Plugin URI: http://vfb.matthewmuro.com
Description: An add-on for Visual Form Builder Pro that allows you to collect payments.
Author: Matthew Muro
Author URI: http://matthewmuro.com
Version: 1.4.5
*/

$vfb_payments_load = new VFB_Pro_Payments();

// VFB Pro Create User class
class VFB_Pro_Payments{

	/**
	 * The DB version. Used for SQL install and upgrades.
	 *
	 * Should only be changed when needing to change SQL
	 * structure or custom capabilities.
	 *
	 * @since 1.0
	 * @var string
	 * @access protected
	 */
	protected $vfb_payments_db_version = '1.0';

	/**
	 * The plugin API
	 *
	 * @since 1.0
	 * @var string
	 * @access protected
	 */
	protected $api_url = 'http://matthewmuro.com/plugin-api/payments/';

	/**
	 * Flag used to add scripts to front-end only once
	 *
	 * @since 1.0
	 * @var bool
	 * @access protected
	 */
	protected $add_scripts = false;

	/**
	 * Constructor. Register core filters and actions.
	 *
	 * @access public
	 */
	public function __construct() {
		global $wpdb;

		// Setup global database table names
		$this->field_table_name 	= $wpdb->prefix . 'vfb_pro_fields';
		$this->form_table_name 		= $wpdb->prefix . 'vfb_pro_forms';
		$this->payment_table_name 	= $wpdb->prefix . 'vfb_pro_payments';

		// Add Payments to main VFB menu
		add_action( 'admin_menu', array( &$this, 'admin_menu' ), 15 );

		// Enable saving function
		add_action( 'admin_init', array( &$this, 'save' ) );

		// Check the db version and run SQL install, if needed
		add_action( 'plugins_loaded', array( &$this, 'update_db_check' ) );

		// Load front-end styles
		add_action( 'wp_enqueue_scripts', array( &$this, 'css' ) );

		// AJAX for loading price field dropdown
		add_action( 'wp_ajax_vfb_payments_price_fields', array( &$this, 'price_fields' ) );

		// AJAX for loading price field options
		add_action( 'wp_ajax_vfb_payments_price_fields_options', array( &$this, 'price_fields_options' ) );

		// Display Admin notices when saving
		add_action( 'admin_notices', array( &$this, 'admin_notices' ) );

		// Hook into the confirmation function and redirect to PayPal
		add_action( 'vfb_confirmation', array( &$this, 'send_to_paypal' ) );

		// Load i18n
		add_action( 'plugins_loaded', array( &$this, 'languages' ) );

		// Display plugin details screen for updating
		add_filter( 'plugins_api', array( &$this, 'api_information' ), 10, 3 );

		// Hook into the plugin update check
		add_filter( 'pre_set_site_transient_update_plugins', array( &$this, 'api_check' ) );

		// For testing only
		//add_action( 'init', array( &$this, 'delete_transient' ) );
	}

	/**
	 * Load localization file
	 *
	 * @since 1.4
	 */
	public function languages() {
		load_plugin_textdomain( 'vfb-pro-payments', false , 'vfb-pro-payments/languages' );
	}

	/**
	 * Check database version and run SQL install, if needed
	 *
	 * @since 1.0
	 */
	public function update_db_check() {
		// Add a database version to help with upgrades and run SQL install
		if ( !get_option( 'vfb_payments_db_version' ) ) {
			update_option( 'vfb_payments_db_version', $this->vfb_payments_db_version );
			$this->install_db();
		}

		// If database version doesn't match, update and maybe run SQL install
		if ( version_compare( get_option( 'vfb_payments_db_version' ), $this->vfb_payments_db_version, '<' ) ) {
			update_option( 'vfb_payments_db_version', $this->vfb_payments_db_version );
			$this->install_db();
		}
	}

	/**
	 * Install database tables
	 *
	 * @since 1.0
	 */
	static function install_db() {
		global $wpdb;

		$payment_table_name = $wpdb->prefix . 'vfb_pro_payments';

		// Explicitly set the character set and collation when creating the tables
		$charset = ( defined( 'DB_CHARSET' && '' !== DB_CHARSET ) ) ? DB_CHARSET : 'utf8';
		$collate = ( defined( 'DB_COLLATE' && '' !== DB_COLLATE ) ) ? DB_COLLATE : 'utf8_general_ci';

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$payment_sql = "CREATE TABLE $payment_table_name (
				payment_id BIGINT(20) NOT NULL AUTO_INCREMENT,
				form_id BIGINT(20) NOT NULL,
				enable_payment TINYINT(1),
				merchant_type VARCHAR(25) DEFAULT 'paypal',
				merchant_details TEXT,
				currency VARCHAR(25) DEFAULT 'USD',
				show_running_total VARCHAR(1) DEFAULT '1',
				collect_shipping_address VARCHAR(255),
				collect_billing_info VARCHAR(255),
				recurring_payments VARCHAR(255),
				advanced_vars LONGTEXT,
				price_fields LONGTEXT,
				PRIMARY KEY  (payment_id)
			) DEFAULT CHARACTER SET $charset COLLATE $collate;";

		dbDelta( $payment_sql );
	}

	/**
	 * Load styles to front-end
	 *
	 * @since 1.0
	 */
	public function css() {
		wp_enqueue_style( 'vfb-payments-css', plugins_url( '/css/vfb-pro-payments.css', __FILE__ ) );
	}

	/**
	 * Load scripts to front-end only once
	 *
	 * @since 1.0
	 */
	public function scripts() {
		// Make sure scripts are only added once via shortcode
		$this->add_scripts = true;

		wp_enqueue_script( 'vfb-pro-payments', plugins_url( '/js/vfb-pro-payments.js', __FILE__ ), array( 'jquery' ), false, true );
	}

	/**
	 * Add admin menu
	 *
	 *
	 * @since 1.0
	 */
	public function admin_menu() {
		$current_page = add_submenu_page( 'visual-form-builder-pro', __( 'Payments', 'vfb-pro-payments' ), __( 'Payments', 'vfb-pro-payments' ), 'vfb_edit_forms', 'vfb-payments', array( &$this, 'admin' ) );

		// Load admin scripts
		add_action( 'load-' . $current_page, array( &$this, 'admin_scripts' ) );
	}

	/**
	 * Admin scripts and styles
	 *
	 * @since 1.0
	 */
	public function admin_scripts() {
		wp_enqueue_style( 'vfb-payments-admin-css', plugins_url( '/css/vfb-pro-payments-admin.css', __FILE__ ), array(), '20130717' );
		wp_enqueue_script( 'vfb-payments-admin', plugins_url( '/js/vfb-pro-payments-admin.js', __FILE__ ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'jquery-form-validation', plugins_url( 'visual-form-builder-pro/js/jquery.validate.min.js' ), array( 'jquery' ), '1.9.0', true );
	}

	/**
	 * Display saving messages in admin
	 *
	 * @since 1.0
	 */
	public function admin_notices() {
		if ( !is_plugin_active( 'visual-form-builder-pro/visual-form-builder-pro.php' ) )
			echo sprintf( '<div id="message" class="error"><p>%s</p></div>', __( 'Visual Form Builder Pro must also be installed and active in order for the Payments add-on to function properly.' , 'visual-form-builder-pro' ) );

		if ( !isset( $_REQUEST['vfb-payments-submit'] ) )
			return;

		echo sprintf( '<div id="message" class="updated"><p>%s</p></div>', __( 'Payment settings have been saved.' , 'vfb-pro-payments' ) );
	}

	/**
	 * Display settings page
	 *
	 *
	 * @since 1.0
	 */
	public function admin() {
		global $wpdb;

		$order 		= sanitize_sql_orderby( 'form_id ASC' );
		$forms 		= $wpdb->get_results( "SELECT * FROM $this->form_table_name ORDER BY $order" );

		// Die if no existing form is selected
		if ( !$forms ) :
			echo '<div class="vfb-form-alpha-list"><h3 id="vfb-no-forms">You currently do not have any forms.  Click <a href="' . esc_url( admin_url( 'admin.php?page=vfb-add-new' ) ) . '">here to get started</a>.</h3></div>';

		else :
			$form_selected_id = ( isset( $_REQUEST['form_id'] ) ) ? (int) $_REQUEST['form_id'] : $forms[0]->form_id;
			$form 		= $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->form_table_name WHERE form_id = %d", $form_selected_id ) );
			$payments 	= $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->payment_table_name WHERE form_id = %d", $form_selected_id ) );

			$enable_payment           = ( !empty( $payments->enable_payment ) ) ? esc_html( $payments->enable_payment ) : '';
			$merchant_type            = ( !empty( $payments->merchant_type ) ) ? esc_html( $payments->merchant_type ) : 'paypal';
			$merchant_details         = ( !empty( $payments->merchant_details ) ) ? maybe_unserialize( $payments->merchant_details ) : '';
			$currency                 = ( !empty( $payments->currency ) ) ? esc_html( $payments->currency ) : 'USD';
			$show_running_total       = ( !empty( $payments->show_running_total ) ) ? esc_html( $payments->show_running_total ) : '';
			$collect_shipping_address = ( !empty( $payments->collect_shipping_address ) ) ? esc_html( $payments->collect_shipping_address ) : '';
			$collect_billing_info     = ( !empty( $payments->collect_billing_info ) ) ? maybe_unserialize( $payments->collect_billing_info ) : '';
			$recurring_payments       = ( !empty( $payments->recurring_payments ) ) ? maybe_unserialize( $payments->recurring_payments ) : '';
			$advanced_vars       	  = ( !empty( $payments->advanced_vars ) ) ? maybe_unserialize( $payments->advanced_vars ) : '';
			$price_fields             = ( !empty( $payments->price_fields ) ) ? maybe_unserialize( $payments->price_fields ) : '';
?>
	<div class="wrap">
		<?php screen_icon( 'options-general' ); ?>
		<h2><?php _e( 'Payments', '' ); ?></h2>
        <form method="post" id="design-switcher">
            <label for="form_id"><strong><?php _e( 'Select form:', 'vfb-pro-payments' ); ?></strong></label>
            <select name="form_id" id="form_id">
<?php
		foreach ( $forms as $form ) :
			echo sprintf( '<option value="%1$d" %2$s id="%3$s">%4$s</option>',
				$form->form_id,
				selected( $form->form_id, $form_selected_id, 0 ),
				$form->form_key,
				stripslashes( $form->form_title )
			);
		endforeach;
?>
		</select>
        <?php submit_button( __( 'Select', 'vfb-pro-payments' ), 'secondary', 'submit', false ); ?>
        </form>

		<form id="vfb-pro-payments-form" method="post">
			<input name="action" type="hidden" value="save-payments" />
			<input name="form_id" type="hidden" value="<?php echo $form_selected_id; ?>" />
			<?php wp_nonce_field( 'save-payments' ); ?>

			<table class="form-table">
				<tbody>
					<tr align="top">
						<th>
							<label for="vfb-payment-enable" class="">
								<?php _e( 'Enable Payment' , 'vfb-pro-payments'); ?>
							</label>
						</th>
						<td>
							<input type="checkbox" id="vfb-payment-enable" name="vfb-payment-enable" value="1"<?php checked( $enable_payment, '1' ); ?> />
						</td>
					</tr>
				</tbody>
			</table>

			<h3><?php _e( 'Merchant Settings' , 'vfb-pro-payments'); ?></h3>
			<table class="form-table">
				<tbody>
					<tr align="top">
						<th>
							<label for="vfb-payment-merchant-type" class="">
								<?php _e( 'Select a Merchant' , 'vfb-pro-payments'); ?>
							</label>
						</th>
						<td>
							<select id="vfb-payment-merchant-type" name="vfb-payment-merchant-type">
								<option value="paypal"<?php selected( $merchant_type, 'paypal' ); ?>><?php _e( 'PayPal Standard' , 'vfb-pro-payments'); ?></option>
								<!--<option value="paypalpro"<?php selected( $merchant_type, 'paypalpro' ); ?>><?php _e( 'PayPal Pro' , 'vfb-pro-payments'); ?></option>-->
							</select>
						</td>
					</tr>

					<?php
						$merchant_email 	= ( !empty( $merchant_details['email'] ) ) ? esc_html( $merchant_details['email'] ) : '';
					?>
					<tr align="top">
						<th>
							<label for="vfb-payment-merchant-details-email" class="">
								<?php _e( 'Account Email' , 'vfb-pro-payments'); ?>
							</label>
						</th>
						<td>
							<input type="text" class="regular-text" id="vfb-payment-merchant-details-email" name="vfb-payment-merchant-details[email]" value="<?php echo $merchant_email; ?>" />
						</td>
					</tr>
				</tbody>
			</table>


			<h3><?php _e( 'Payment Options' , 'vfb-pro-payments'); ?></h3>
			<table class="form-table">
				<tbody>
					<tr align="top">
						<th>
							<label for="vfb-payment-currency" class="">
								<?php _e( 'Currency' , 'vfb-pro-payments'); ?>
							</label>
						</th>
						<td>
							<?php
		                        // Setup currencies array
                                $currencies = array(
                                	'USD' => '&#36; - U.S. Dollar',
                                	'AUD' => 'A&#36; - Australian Dollar',
                                	'BRL' => 'R&#36; - Brazilian Real',
                                	'GBP' => '&#163; - British Pound',
                                	'CAD' => 'C&#36; - Canadaian Dollar',
                                	'CZK' => '&#75;&#269; - Czech Koruny',
                                	'DKK' => '&#107;&#114; - Danish Krone',
                                	'EUR' => '&#8364; - Euro',
                                	'HKD' => '&#36; - Hong Kong Dollar',
                                	'HUF' => '&#70;&#116; - Hungarian Forint',
                                	'ILS' => '&#8362; - Israeli New Sheqel',
                                	'JPY' => '&#165; - Japanese Yen',
                                	'MYR' => '&#82;&#77; - Malaysian Ringgit',
                                	'MXN' => '&#36; - Mexican Peso',
                                    'NOK' => '&#107;&#114; - Norwegian Krone',
									'NZD' => 'NZ&#36; - New Zealand Dollar',
                                	'PHP' => '&#80;&#104;&#11; - Philippine Peso',
                                	'PLN' => '&#122;&#322; - Polish Zloty',
                                	'SGD' => 'S&#36; - Singapore Dollar',
                                	'SEK' => '&#107;&#114; - Swedish Krona',
                                	'CHF' => '&#67;&#72;&#70; - Swiss Franc',
                                	'TWD' => 'NT&#36; - Taiwan New Dollar',
                                	'THB' => '&#3647; - Thai Baht',
                                	'TRY' => 'TRY - Turkish Lira',
                                );
	                        ?>
	                        <select id="vfb-payment-currency" name="vfb-payment-currency">
	                            <?php foreach( $currencies as $key => $val ) : ?>
	                                <option value="<?php echo $key; ?>"<?php selected( $currency, $key ); ?>><?php echo $val; ?></option>
	                            <?php endforeach; ?>
	                        </select>
						</td>
					</tr>

					<tr align="top">
						<th>
							<label for="vfb-payment-show-running-total" class="">
								<?php _e( 'Show Running Total' , 'vfb-pro-payments'); ?>
							</label>
						</th>
						<td>
	                        <input type="checkbox" id="vfb-payment-show-running-total" name="vfb-payment-show-running-total" value="1"<?php checked( $show_running_total, '1' ); ?> />
						</td>
					</tr>

					<tr align="top">
						<th>
							<label for="vfb-payment-collect-shipping-address" class="">
								<?php _e( 'Collect Shipping Address' , 'vfb-pro-payments'); ?>
							</label>
						</th>
						<td>
	                        <input type="checkbox" id="vfb-payment-collect-shipping-address" name="vfb-payment-collect-shipping-address" value="1"<?php checked( $collect_shipping_address, '1' ); ?> />
						</td>
					</tr>

					<?php
						$billing_setting 	= ( !empty( $collect_billing_info['setting'] ) ) ? esc_html( $collect_billing_info['setting'] ) : '';
						$billing_name 	= ( !empty( $collect_billing_info['name'] ) ) ? esc_html( $collect_billing_info['name'] ) : '';
						$billing_address 	= ( !empty( $collect_billing_info['address'] ) ) ? esc_html( $collect_billing_info['address'] ) : '';
						$billing_email 	= ( !empty( $collect_billing_info['email'] ) ) ? esc_html( $collect_billing_info['email'] ) : '';
					?>
					<tr align="top">
						<th>
							<label for="vfb-payment-collect-billing-info" class="">
								<?php _e( 'Collect Billing Info' , 'vfb-pro-payments'); ?>
							</label>
						</th>
						<td>
	                        <input type="checkbox" class="vfb-payment-toggles" id="vfb-payment-collect-billing-info" name="vfb-payment-collect-billing-info[setting]" value="1"<?php checked( $billing_setting, '1' ); ?> />

	                        <div class="vfb-payment-collect-billing-info-options<?php echo ( $billing_setting ) ? ' active' : ''; ?>">
	                        	<h4><?php _e( 'Select an Name field' , 'vfb-pro-payments'); ?></h4>
		                        <select id="vfb-payment-billing-name" name="vfb-payment-collect-billing-info[name]"<?php echo ( !$billing_setting ) ? ' disabled="disabled"' : ''; ?>>
									<?php $this->collection_fields( $form_selected_id, 'name', $billing_name ); ?>
								</select>

								<h4><?php _e( 'Select an Address field' , 'vfb-pro-payments'); ?></h4>
								<select id="vfb-payment-billing-address" name="vfb-payment-collect-billing-info[address]"<?php echo ( !$billing_setting ) ? ' disabled="disabled"' : ''; ?>>
									<?php $this->collection_fields( $form_selected_id, 'address', $billing_address ); ?>
								</select>

								<h4><?php _e( 'Select an Email field' , 'vfb-pro-payments'); ?></h4>
								<select id="vfb-payment-billing-email" name="vfb-payment-collect-billing-info[email]"<?php echo ( !$billing_setting ) ? ' disabled="disabled"' : ''; ?>>
									<?php $this->collection_fields( $form_selected_id, 'email', $billing_email ); ?>
								</select>
	                        </div>
						</td>
					</tr>

					<?php
						$recurring_setting 	= ( !empty( $recurring_payments['setting'] ) ) ? esc_html( $recurring_payments['setting'] ) : '';
						$recurring_period 	= ( !empty( $recurring_payments['period'] ) ) ? absint( $recurring_payments['period'] ) : '';
						$recurring_time 	= ( !empty( $recurring_payments['time'] ) ) ? esc_html( $recurring_payments['time'] ) : '';
					?>
					<tr align="top">
						<th>
							<label for="vfb-payment-recurring-payments" class="">
								<?php _e( 'Recurring Payments' , 'vfb-pro-payments'); ?>
							</label>
						</th>
						<td>
	                        <input type="checkbox" class="vfb-payment-toggles" id="vfb-payment-recurring-payments" name="vfb-payment-recurring-payments[setting]" value="1"<?php checked( $recurring_setting, '1' ); ?> />
							<div class="vfb-payment-recurring-payments-options<?php echo ( $recurring_setting ) ? ' active' : ''; ?>">
								<h4><?php _e( 'Request Payment Every' , 'vfb-pro-payments'); ?></h4>
								<select name="vfb-payment-recurring-payments[period]"<?php echo ( !$recurring_setting ) ? ' disabled="disabled"' : ''; ?>>
									<option value="1"<?php selected( $recurring_period, '1' ); ?>>1</option>
									<option value="2"<?php selected( $recurring_period, '2' ); ?>>2</option>
									<option value="3"<?php selected( $recurring_period, '3' ); ?>>3</option>
									<option value="4"<?php selected( $recurring_period, '4' ); ?>>4</option>
									<option value="5"<?php selected( $recurring_period, '5' ); ?>>5</option>
									<option value="6"<?php selected( $recurring_period, '6' ); ?>>6</option>
									<option value="7"<?php selected( $recurring_period, '7' ); ?>>7</option>
									<option value="8"<?php selected( $recurring_period, '8' ); ?>>8</option>
									<option value="9"<?php selected( $recurring_period, '9' ); ?>>9</option>
									<option value="10<?php selected( $recurring_period, '10' ); ?>">10</option>
								</select>
								<select name="vfb-payment-recurring-payments[time]"<?php echo ( !$recurring_setting ) ? ' disabled="disabled"' : ''; ?>>
									<option value="D"<?php selected( $recurring_time, 'D' ); ?>>Day(s)</option>
									<option value="W"<?php selected( $recurring_time, 'W' ); ?>>Week(s)</option>
									<option value="M"<?php selected( $recurring_time, 'M' ); ?>>Month(s)</option>
									<option value="Y"<?php selected( $recurring_time, 'Y' ); ?>>Year(s)</option>
								</select>
							</div>
						</td>
					</tr>

					<?php
						$advanced_vars_setting 	= ( !empty( $advanced_vars['setting'] ) ) ? esc_html( $advanced_vars['setting'] ) : '';
						$advanced_vars_vars 	= ( !empty( $advanced_vars['variables'] ) ) ? esc_html( $advanced_vars['variables'] ) : '';
					?>
					<tr align="top">
						<th>
							<label for="vfb-payment-advanced-variables" class="">
								<?php _e( 'Advanced Variables' , 'vfb-pro-payments'); ?>
							</label>
						</th>
						<td>
	                        <input type="checkbox" class="vfb-payment-toggles" id="vfb-payment-advanced-variables" name="vfb-payment-advanced-variables[setting]" value="1"<?php checked( $advanced_vars_setting, '1' ); ?> />

	                        <div class="vfb-payment-advanced-variables-options<?php echo ( $advanced_vars_setting ) ? ' active' : ''; ?>">
								<p class="description"><?php _e( 'Set additional PayPal variables to further customize the checkout experience for your customers.', 'vfb-pro-payments' ); ?> <a href="https://www.x.com/developers/paypal/documentation-tools/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables" target="_blank"><?php _e( 'Technical HTML Variables' , 'vfb-pro-payments'); ?></a></p>
								<textarea id="vfb-payment-advanced-variables-vars" class="vfb-payment-textarea code" cols="30" rows="10" name="vfb-payment-advanced-variables[variables]"<?php echo ( !$advanced_vars_setting ) ? ' disabled="disabled"' : ''; ?>><?php echo $advanced_vars_vars; ?></textarea>
								<p class="description"><?php _e( 'Use a line break between each variable.' , 'vfb-pro-payments'); ?></p>
								<p>
									<strong>Example:</strong><br>
<pre>
return=<?php bloginfo( 'url' ); ?>/success
cancel_return=<?php bloginfo( 'url' ); ?>/cancel
</pre>
								</p>

	                        </div>
						</td>
					</tr>

				</tbody>
			</table>

			<h3><?php _e( 'Assign Prices' , 'vfb-pro-payments'); ?></h3>
			<p><?php _e( 'Assign Prices to existing form fields. Only Select, Radio, Checkbox, and Currency fields are allowed.' , 'vfb-pro-payments' ); ?></p>
			<table class="form-table">
				<tbody>
					<tr align="top">
						<th>
							<label for="vfb-payment-fields" class="">
								<?php _e( 'Price Fields' , 'vfb-pro-payments' ); ?>
							</label>
						</th>
						<td>
						<?php
							$existing_fields = array();

							if ( $price_fields ) :
								foreach ( $price_fields as $field_id => $values ) :
									$this->price_fields_options( $field_id, $values );
									$existing_fields[] = $field_id;
									echo '<input type="hidden" class="vfb-payment-field-ids" name="vfb-payment-field-ids[]" value="' . $field_id . '" />';
								endforeach;
							endif;
						?>
							<h4 class="vfb-payment-assign-prices-header"><?php _e( 'Assign Prices to a Field' , 'vfb-pro-payments' ); ?></h4>
							<select id="vfb-payment-fields" name="vfb-payment-fields">
								<?php $this->price_fields( $form_selected_id, $existing_fields ); ?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>

			<?php submit_button( __( 'Save', 'vfb-pro-payments' ), 'primary', 'vfb-payments-submit' ); ?>
		</form>
		<?php endif; ?>
	</div>
	<?php
	}

	/**
	 * Output PayPal account details
	 *
	 * @since 1.0
	 */
	public function account_details( $form_id ) {
		global $wpdb;

		$output = '';

		// Run query to see if data exists, if yes update, if no insert
		$account_details = $wpdb->get_var( $wpdb->prepare( "SELECT merchant_details FROM $this->payment_table_name WHERE form_id = %d", $form_id ) );

		if ( !$account_details )
			return;

		$details 	= ( !empty( $account_details ) ) ? maybe_unserialize( $account_details ) : '';
		$email 		= ( !empty( $details['email'] ) ) ? esc_html( $details['email'] ) : '';

		$output .= '<input type="hidden" name="business" value="' . $email . '">';

		return $output;
	}

	/**
	 * Get currency denomination symbol for running total output
	 *
	 * @since 1.3
	 */
	public function currency_denomination( $form_id ) {
		global $wpdb;

		// Run query to see if data exists, if yes update, if no insert
		$currency = $wpdb->get_var( $wpdb->prepare( "SELECT currency FROM $this->payment_table_name WHERE form_id = %d", $form_id ) );

		if ( !$currency )
			return;

		$currency_code 	= ( !empty( $currency ) ) ? esc_html( $currency ) : 'USD';

		$currencies = array(
			'USD' => '&#36;',			// U.S. Dollar
			'AUD' => 'A&#36;',			// Austrailian Dollar
			'BRL' => 'R&#36;',			// Brazilian Real
			'GBP' => '&#163;',			// British Pound
			'CAD' => 'C&#36;',			// Canadian Dollar
			'CZK' => '&#75;&#269;',		// Czech Koruny
			'DKK' => '&#107;&#114;',	// Danish Kroner
			'EUR' => '&#8364;',			// Euro
			'HKD' => '&#36;',			// Hong Kong Dollar
			'HUF' => '&#70;&#116;',		// Hungarian Forint
			'ILS' => '&#8362;',			// Israeli Shegal
			'JPY' => '&#165;',			// Japanese Yen
			'MXN' => '&#36;',			// Mexican Peso
			'TWD' => 'NT&#36;',			// Taiwan New Dollars
			'NZD' => 'NZ&#36;',			// New Zealand Dollar
			'NOK' => '&#107;&#114;',	// Norwegian Kroner
			'PHP' => '&#80;&#104;&#11;',// Philippine Peso
			'PLN' => '&#122;&#322;',	// Polish Zloty
			'SGD' => 'S&#36;',			// Singapore Dollar
			'SEK' => '&#107;&#114;',	// Swedish Kronor
			'CHF' => '&#67;&#72;&#70;', // Swiss Francs
			'THB' => '&#3647;'			// Thai Baht
		);

		return $currencies[ $currency_code ];
	}

	/**
	 * Output PayPal currency code
	 *
	 * @since 1.0
	 */
	public function currency_code( $form_id ) {
		global $wpdb;

		$output = '';

		// Run query to see if data exists, if yes update, if no insert
		$currency = $wpdb->get_var( $wpdb->prepare( "SELECT currency FROM $this->payment_table_name WHERE form_id = %d", $form_id ) );

		if ( !$currency )
			return;

		$currency_code 	= ( !empty( $currency ) ) ? esc_html( $currency ) : 'USD';

		$output .= '<input type="hidden" name="currency_code" value="' . $currency_code . '">';

		return $output;
	}

	/**
	 * Check if payment has been enabled for this form
	 *
	 * @since 1.0
	 */
	public function enable_payment( $form_id ) {
		global $wpdb;

		$output = '';

		// Run query to see if data exists, if yes update, if no insert
		$enable_payment = $wpdb->get_var( $wpdb->prepare( "SELECT enable_payment FROM $this->payment_table_name WHERE form_id = %d", $form_id ) );

		if ( !$enable_payment )
			return;

		return true;
	}

	/**
	 * AJAX response for loading price fields
	 *
	 * @since 1.0
	 */
	public function price_fields( $form_id, $existing_fields = array() ) {
		global $wpdb;

		$output = $where = '';

		if ( isset( $_REQUEST['field_id'] ) || !empty( $existing_fields ) ) {
			$field = ( isset( $_REQUEST['field_id'] ) ) ? $_REQUEST['field_id'] : $existing_fields;
			$field_id = implode( ',', array_map( 'absint', $field ) );
			$where .= "AND field_id NOT IN($field_id)";
		}

		if ( isset( $_REQUEST['form_id'] ) )
			$form_id = absint( $_REQUEST['form_id'] );


		$fields = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $this->field_table_name WHERE form_id = %d AND field_type IN('select','radio','checkbox','currency') $where", $form_id ) );



		foreach ( $fields as $field ) :
			$output .= '<option value="' . $field->field_id . '">' . stripslashes( $field->field_name ) . ' (' . $field->field_type . ')</option>';
		endforeach;

		$output = '<option value="" selected="selected"></option>' . $output;

		echo $output;

		if ( defined('DOING_AJAX') && DOING_AJAX )
			wp_die();
	}

	/**
	 * AJAX response to load price field options
	 *
	 * @since 1.0
	 */
	public function price_fields_options( $field_id, $values = array() ) {
		global $wpdb;

		$where = '';

		if ( isset( $_REQUEST['field_id'] ) )
			$field_id = absint( $_REQUEST['field_id'] );

		// Field Options
		$field_options = $wpdb->get_var( $wpdb->prepare( "SELECT field_options, field_name, field_type FROM $this->field_table_name WHERE field_id = %d $where", $field_id ) );

		// Field Name
		$field_name = $wpdb->get_var( null, 1 );

		//Field Type
		$field_type = $wpdb->get_var( null, 2 );

		echo '<div class="vfb-pricing-fields-container">';
		echo '<h3>' . $field_name . '<a class="vfb-payment-remove-field" href="' . esc_url( wp_nonce_url( admin_url( 'admin.php?page=vfb-payments&amp;action=delete_price_field&amp;field=' . $field_id ), 'delete-price-field-' . $field_id ) ) . '">' . __( 'Remove', 'vfb-pro-payments' ) . '</a></h3>';

		if ( $field_type == 'currency' ) {
			echo __( 'Amount Based on User Input', 'vfb-pro-payments' );
			echo '<input type="hidden" name="vfb-payment-field[' . $field_id . '][]" value="" />';
			echo '</div>';

			if ( defined('DOING_AJAX') && DOING_AJAX )
				wp_die();

			return;
		}


		$options = maybe_unserialize( $field_options );

		// Set default price at 0.00
		$price = '0.00';

		// Counter for label attr
		$i = 0;

		foreach ( $options as $key => $value ) :
			if ( array_key_exists( $key, $values ) )
				$price = esc_html( $values[ $key ] );

			echo sprintf( '<div class="vfb-payment-field-names"><label for="vfb-payment-field-%1$d">%2$s</label><input type="text" id="vfb-payment-field-%1$d" name="vfb-payment-field[%3$d][]" value="%4$s" class="vfb-clean-currency" /></div>', $i, stripslashes( $value ), $field_id, esc_attr( $price ) );

			++$i;
		endforeach;

		echo '</div>';

		if ( defined('DOING_AJAX') && DOING_AJAX )
			wp_die();
	}

	/**
	 * Returns field names for Collect Billing Info
	 *
	 * @since 1.0
	 */
	public function collection_fields( $form_id, $type, $selected ) {
		global $wpdb;

		$fields = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $this->field_table_name WHERE form_id = %d AND field_type = '%s'", $form_id, $type ) );

		echo '<option value=""' . selected( $selected, '', 1 ) . '></option>';

		if ( !$fields ) {
			echo '<option value="">' . sprintf( __( '(No %s fields found)', 'vfb-pro-payments' ), $type ) . '</option>';
			return;
		}

		foreach ( $fields as $field ) :
			echo '<option value="' . $field->field_id . '"' . selected( $selected, $field->field_id, 1 ) . '>' . stripslashes( $field->field_name ) . '</option>';
		endforeach;
	}

	/**
	 * Check it Running Total box should be output
	 *
	 * @since 1.0
	 */
	public function show_running_total( $form_id ) {
		global $wpdb;

		$show_running_total = $wpdb->get_var( $wpdb->prepare( "SELECT show_running_total FROM $this->payment_table_name WHERE form_id = %d", $form_id ) );

		if ( !$show_running_total )
			return false;

		return true;
	}

	/**
	 * JSON output for field prices and their names
	 *
	 * @since 1.0
	 */
	public function running_total( $form_id ) {
		global $wpdb;

		$payments = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->payment_table_name WHERE form_id = %d", $form_id ) );

		if ( !$payments )
			return false;

		$enable_payment           = ( !empty( $payments->enable_payment ) ) ? esc_html( $payments->enable_payment ) : '';
		$merchant_type            = ( !empty( $payments->merchant_type ) ) ? esc_html( $payments->merchant_type ) : 'paypal';
		$merchant_details         = ( !empty( $payments->merchant_details ) ) ? maybe_unserialize( $payments->merchant_details ) : '';
		$currency                 = ( !empty( $payments->currency ) ) ? esc_html( $payments->currency ) : '';
		$show_running_total       = ( !empty( $payments->show_running_total ) ) ? esc_html( $payments->show_running_total ) : '';
		$collect_shipping_address = ( !empty( $payments->collect_shipping_address ) ) ? maybe_unserialize( $payments->collect_shipping_address ) : '';
		$collect_billing_info     = ( !empty( $payments->collect_billing_info ) ) ? maybe_unserialize( $payments->collect_billing_info ) : '';
		$recurring_payments       = ( !empty( $payments->recurring_payments ) ) ? maybe_unserialize( $payments->recurring_payments ) : '';
		$price_fields             = ( !empty( $payments->price_fields ) ) ? maybe_unserialize( $payments->price_fields ) : '';

		if ( !$enable_payment )
			return false;

		//if ( !$show_running_total )
		//	return false;

		// Add JavaScript files to the front-end, only once
		if ( !$this->add_scripts )
			$this->scripts();

		$test = array();

		if ( $price_fields ) :
			foreach ( $price_fields as $field_id => $values ) :
				$test[] = array(
					'id' => $field_id,
					'prices' => $values
				);
			endforeach;
		endif;

		return json_encode( $test );
	}

	/**
	 * Output Running Total box
	 *
	 * @since 1.0
	 */
	public function running_total_output( $form_id ) {
		$total = '';

		// Get denomination
		$denomination = $this->currency_denomination( $form_id );

		// Allow denomination to be filtered
		$denomination = apply_filters( 'vfb_payments_denomination', $denomination, $form_id );

		$total .= '<div class="vfb-payment-total-container">';
			$total .= '<h3>' . __( 'Total', 'vfb-pro-payments' );
			$total .= '<div class="vfb-total-container">';
				$total .= '<span class="vfb-denomination">' . $denomination . '</span><span class="vfb-total">0.00</span>';
			$total .= '</div></h3>';
			$total .= '<div class="vfb-payment-items"></div>';
		$total .= '</div>';

		return $total;
	}

	/**
	 * PayPal output for Recurring Payments
	 *
	 * @since 1.0
	 */
	public function recurring_payments( $form_id ) {
		global $wpdb;

		$output = '';

		// Run query to see if data exists, if yes update, if no insert
		$recurring = $wpdb->get_var( $wpdb->prepare( "SELECT recurring_payments FROM $this->payment_table_name WHERE form_id = %d", $form_id ) );

		// All recurring settings
		$recurring_payments = ( !empty( $recurring ) ) ? maybe_unserialize( $recurring ) : '';

		// Recurring Payments checkbox
		$recurring_setting 	= ( !empty( $recurring_payments['setting'] ) ) ? esc_html( $recurring_payments['setting'] ) : '';

		// If Recurring Payments checkbox is not checked, end function
		if ( !$recurring_setting )
			return;

		$recurring_period 	= ( !empty( $recurring_payments['period'] ) ) ? absint( $recurring_payments['period'] ) : '';
		$recurring_time 	= ( !empty( $recurring_payments['time'] ) ) ? esc_html( $recurring_payments['time'] ) : '';

		$output .= '<input type="hidden" name="p3" value="' . $recurring_period . '">';
		$output .= '<input type="hidden" name="t3" value="' . $recurring_time . '">';
		$output .= '<input type="hidden" name="src" value="1">';

		return $output;
	}

	/**
	 * Check if this form is collecting the shipping address
	 *
	 * @since 1.0
	 */
	public function collect_shipping_address( $form_id ) {
		global $wpdb;

		$address = $wpdb->get_var( $wpdb->prepare( "SELECT collect_shipping_address FROM $this->payment_table_name WHERE form_id = %d", $form_id ) );

		if ( !$address )
			return;

		return true;
	}

	/**
	 * Check if this form is collecting billing info
	 *
	 * @since 1.0
	 */
	public function collect_billing_info( $form_id ) {
		global $wpdb;

		$billing = $wpdb->get_var( $wpdb->prepare( "SELECT collect_billing_info FROM $this->payment_table_name WHERE form_id = %d", $form_id ) );

		if ( !$billing )
			return;

		return maybe_unserialize( $billing );
	}

	/**
	 * Get Advanced variables for PayPal output
	 *
	 * @since 1.0
	 */
	public function advanced_vars( $form_id ) {
		global $wpdb;

		$output = '';

		$advanced = $wpdb->get_var( $wpdb->prepare( "SELECT advanced_vars FROM $this->payment_table_name WHERE form_id = %d", $form_id ) );

		if ( !$advanced )
			return;

		// All advanced settings
		$advanced_vars = ( !empty( $advanced ) ) ? maybe_unserialize( $advanced ) : '';

		// Advanced Vars checkbox
		$advanced_setting 	= ( !empty( $advanced_vars['setting'] ) ) ? esc_html( $advanced_vars['setting'] ) : '';

		// If Advanced Vars checkbox is not checked, end function
		if ( !$advanced_setting )
			return;

		$all_variables 	= ( !empty( $advanced_vars['variables'] ) ) ? esc_html( $advanced_vars['variables'] ) : '';



		return $all_variables;
	}

	/**
	 * Redirect to PayPal and send all available data based on settings
	 *
	 * @since 1.0
	 */
	public function send_to_paypal() {

		if ( !isset( $_REQUEST['vfb-submit'] ) )
			return;

		$form_id = absint( $_REQUEST['form_id'] );

		$enable_payment = $this->enable_payment( $form_id );

		if ( !$enable_payment )
			return;

		// Get global settings
		$vfb_settings 	= get_option( 'vfb-settings' );

		// Settings - skip total zero
		$settings_skip_total_zero	= isset( $vfb_settings['skip-total-zero'] ) ? true : false;

		$output = $query_string = $total = '';

		$paypal_url 	= 'https://www.paypal.com/cgi-bin/webscr';
		$paypal_command	= ( isset( $_REQUEST['cmd'] ) ) ? esc_html( $_REQUEST['cmd'] ) : '_cart';
		$account_email 	= ( isset( $_REQUEST['business'] ) ) ? sanitize_email( $_REQUEST['business'] ) : '';
		$currency_code 	= ( isset( $_REQUEST['currency_code'] ) ) ? esc_html( $_REQUEST['currency_code'] ) : 'USD';
		$shipping_address = ( isset( $_REQUEST['no_shipping'] ) ) ? absint( $_REQUEST['no_shipping'] ) : 1;

		$data = array(
			'cmd'            => $paypal_command,
			'business'       => $account_email,
			'currency_code'  => $currency_code,
			'no_shipping'	 => $shipping_address
		);

		// Recurring Payments
		if ( isset( $_REQUEST['p3'] ) && isset( $_REQUEST['t3'] ) && isset( $_REQUEST['a3'] ) ) :
			$recurring_period 	= ( isset( $_REQUEST['p3'] ) ) ? absint( $_REQUEST['p3'] ) : '';
			$recurring_time 	= ( isset( $_REQUEST['t3'] ) ) ? esc_html( $_REQUEST['t3'] ) : '';
			$recurring_amount 	= ( isset( $_REQUEST['a3'] ) ) ? esc_html( $_REQUEST['a3'] ) : '';
			$recurring_note 	= ( isset( $_REQUEST['no_note'] ) ) ? absint( $_REQUEST['no_note'] ) : '1';
			$recurring_setting 	= ( isset( $_REQUEST['src'] ) ) ? absint( $_REQUEST['src'] ) : '0';

			$data['p3']      = $recurring_period;
			$data['t3']      = $recurring_time;
			$data['a3']      = $recurring_amount;
			$data['no_note'] = $recurring_note;
			$data['src']	 = $recurring_setting;
		endif;

		// Add to Cart, get items
		if ( '_cart' == $paypal_command ) :

			// Initial item count
			$item_count = 1;

			// Find the items and save the count
			foreach ( $_REQUEST as $k => $v ) :
				if ( strpos( $k, 'item_name_' ) === 0)
					++$item_count;
			endforeach;

			// Add item names and prices to our data array
			for ( $i = 1; $i < $item_count; $i++ ) {
				$item_name = ( isset( $_REQUEST[ "item_name_$i" ] ) ) ? esc_html( $_REQUEST[ "item_name_$i" ] ) : '';
				$item_amount = ( isset( $_REQUEST[ "amount_$i" ] ) ) ? (float) $_REQUEST[ "amount_$i" ] : '';

				$data[ "item_name_$i" ] = $item_name;
				$data[ "amount_$i" ] = $item_amount;

				$total += $item_amount;
			}

			$data['upload'] = 1;
		endif;

		$skip_total_zero = apply_filters( 'vfb_payments_skip_total_zero', $settings_skip_total_zero, $form_id );

		if ( $skip_total_zero && empty( $total ) )
			return;

		$billing = $this->collect_billing_info( $form_id );

		// Billing Info
		if ( $billing ) :

			$name_ID     = 'vfb-' . $billing['name'];
			$address_ID  = 'vfb-' . $billing['address'];
			$email_ID    = 'vfb-' . $billing['email'];

			$billing_name    = ( isset( $_REQUEST[ $name_ID ] ) ) ? array_map( 'esc_html', $_REQUEST[ $name_ID ] ) : '';
			$billing_address = ( isset( $_REQUEST[ $address_ID ] ) ) ? array_map( 'esc_html', $_REQUEST[ $address_ID ] ) : '';
			$billing_email   = ( isset( $_REQUEST[ $email_ID ] ) ) ? sanitize_email( $_REQUEST[ $email_ID ] ) : '';

			$data['first_name']  = $billing_name['first'];
			$data['last_name']   = $billing_name['last'];
			$data['email']       = $billing_email;
			$data['address1']    = $billing_address['address'];
			$data['address2']    = $billing_address['address-2'];
			$data['city']        = $billing_address['city'];
			$data['state']       = $billing_address['state'];
			$data['zip']         = $billing_address['zip'];
			$data['country']     = $billing_address['country'];

			$data['address_override'] = 1;
		endif;

		$advanced_vars = $this->advanced_vars( $form_id );

		if ( $advanced_vars ) :

			$vars = explode( "\n", $advanced_vars );

            foreach ( $vars as $var ) :
            	// Split out variable and data
            	$parts = explode( '=', $var, 2 );

            	$var_name     = $parts[0];
            	$var_value    = $parts[1];

            	$data[ "$var_name" ] = $var_value;

            endforeach;

		endif;

		$extra_vars = apply_filters( 'vfb_payments_paypal_extra_vars', array(), $form_id );

		// Merge our PayPal data with possible additions via filter
		$data = array_merge( $data, $extra_vars );

		// Build query string for PayPal URL
		foreach ( array_keys( $data ) as $k ) {
			$query_string .= $k . '=' . urlencode( $data[ $k ] ) . '&';
		}

		wp_redirect( "$paypal_url?$query_string" );
		exit();
	}

	/**
	 * Save settings in database
	 *
	 * @since 1.0
	 */
	public function save() {
		global $wpdb;

		if ( !isset( $_REQUEST['vfb-payments-submit'] ) )
			return;

		if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'save-payments' ) )
			wp_die( 'Security Check' );

		$form_id                  = absint( $_REQUEST['form_id'] );
		$enable_payment           = ( isset( $_REQUEST['vfb-payment-enable'] ) ) ? $_REQUEST['vfb-payment-enable'] : '';
		$merchant_type            = ( isset( $_REQUEST['vfb-payment-merchant-type'] ) ) ? $_REQUEST['vfb-payment-merchant-type'] : '';
		$merchant_details         = ( isset( $_REQUEST['vfb-payment-merchant-details'] ) ) ? maybe_serialize( $_REQUEST['vfb-payment-merchant-details'] ) : '';
		$currency                 = $_REQUEST['vfb-payment-currency'];
		$show_running_total       = ( isset( $_REQUEST['vfb-payment-show-running-total'] ) ) ? $_REQUEST['vfb-payment-show-running-total'] : '';
		$collect_shipping_address = ( isset( $_REQUEST['vfb-payment-collect-shipping-address'] ) ) ? $_REQUEST['vfb-payment-collect-shipping-address'] : '';
		$collect_billing_info     = ( isset( $_REQUEST['vfb-payment-collect-billing-info'] ) ) ? maybe_serialize( $_REQUEST['vfb-payment-collect-billing-info'] ) : '';
		$recurring_payments       = ( isset( $_REQUEST['vfb-payment-recurring-payments'] ) ) ? maybe_serialize( $_REQUEST['vfb-payment-recurring-payments'] ) : '';
		$advanced_vars       	  = ( isset( $_REQUEST['vfb-payment-advanced-variables'] ) ) ? maybe_serialize( $_REQUEST['vfb-payment-advanced-variables'] ) : '';
		$pricing_fields           = ( isset( $_REQUEST['vfb-payment-field'] ) ) ? maybe_serialize( $_REQUEST['vfb-payment-field'] ) : '';

		$data = array(
			'form_id'                    => $form_id,
			'enable_payment'             => $enable_payment,
			'merchant_type'              => $merchant_type,
			'merchant_details'           => $merchant_details,
			'currency'                   => $currency,
			'show_running_total'         => $show_running_total,
			'collect_shipping_address'   => $collect_shipping_address,
			'collect_billing_info'       => $collect_billing_info,
			'recurring_payments'         => $recurring_payments,
			'advanced_vars'         	 => $advanced_vars,
			'price_fields'				 => $pricing_fields
		);

		// Run query to see if data exists, if yes update, if no insert
		$exists = $wpdb->get_var( $wpdb->prepare( "SELECT form_id FROM $this->payment_table_name WHERE form_id = %d", $form_id ) );

		if ( !$exists )
			$wpdb->insert( $this->payment_table_name, $data );
		else
			$wpdb->update( $this->payment_table_name, $data, array( 'form_id' => $form_id ) );
	}


	/**
	 * Delete transients on page load
	 *
	 * FOR TESTING PURPOSES ONLY
	 *
	 * @since 1.0
	 */
	public function delete_transient() {
		delete_site_transient( 'update_plugins' );
	}

	/**
	 * Check the plugin versions to see if there's a new one
	 *
	 * @since 1.0
	 */
	public function api_check( $transient ) {

		// If no checked transiest, just return its value without hacking it
		if ( empty( $transient->checked ) )
			return $transient;

		// Append checked transient information
		$plugin_slug = plugin_basename( __FILE__ );

		// POST data to send to your API
		$args = array(
			'action' 		=> 'update-check',
			'plugin_name' 	=> $plugin_slug,
			'version' 		=> $transient->checked[ $plugin_slug ],
		);

		// Send request checking for an update
		$response = $this->api_request( $args );

		// If response is false, don't alter the transient
		if ( false !== $response )
			$transient->response[ $plugin_slug ] = $response;

		return $transient;
	}

	/**
	 * Send a request to the alternative API, return an object
	 *
	 * @since 1.0
	 */
	public function api_request( $args ) {

		// Send request
		$request = wp_remote_post( $this->api_url, array( 'body' => $args ) );

		// If request fails, stop
		if ( is_wp_error( $request ) ||	wp_remote_retrieve_response_code( $request ) != 200	)
			return false;

		// Retrieve and set response
		$response = maybe_unserialize( wp_remote_retrieve_body( $request ) );

		// Read server response, which should be an object
		if ( is_object( $response ) )
			return $response;
		else
			return false;
	}

	/**
	 * Return the plugin details for the plugin update screen
	 *
	 * @since 1.0
	 */
	public function api_information( $false, $action, $args ) {

		$plugin_slug = plugin_basename( __FILE__ );

		// Check if requesting info
		if ( !isset( $args->slug ) )
			return $false;

		// Check if this plugins API is about this plugin
		if ( isset( $args->slug ) && $args->slug != $plugin_slug )
			return $false;

		// POST data to send to your API
		$args = array(
			'action' 		=> 'plugin_information',
			'plugin_name' 	=> $plugin_slug,
		);

		// Send request for detailed information
		$response = $this->api_request( $args );

		// Send request checking for information
		$request = wp_remote_post( $this->api_url, array( 'body' => $args ) );

		return $response;
	}

}