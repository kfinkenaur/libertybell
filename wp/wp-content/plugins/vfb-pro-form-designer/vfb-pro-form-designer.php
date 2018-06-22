<?php
/*
Plugin Name: Visual Form Builder Pro - Form Designer
Plugin URI: http://vfb.matthewmuro.com
Description: An add-on for Visual Form Builder Pro that allows customizations to the form design and template selections.
Author: Matthew Muro
Author URI: http://matthewmuro.com
Version: 1.3.1
*/

$vfb_form_designer_load = new VFB_Pro_Form_Designer();

// VFB Pro Create User class
class VFB_Pro_Form_Designer{

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
	protected $vfb_design_db_version = '1.1';

	/**
	 * The plugin API
	 *
	 * @since 1.0
	 * @var string
	 * @access protected
	 */
	protected $api_url = 'http://matthewmuro.com/plugin-api/form-designer/';

	/**
	 * Constructor. Register core filters and actions.
	 *
	 * @access public
	 */
	public function __construct() {
		global $wpdb;

		// Setup global database table names
		$this->form_table_name 		= $wpdb->prefix . 'vfb_pro_forms';
		$this->design_table_name 	= $wpdb->prefix . 'vfb_pro_form_design';

		$this->design_custom = array(
			'fieldset_background_color'  => '#eeeeee',
			'fieldset_border_color'      => '#d3d3d3',
			'fieldset_border_thickness'  => '1',
			'fieldset_border_style'      => 'solid',

			'legend_font_color'          => '#990000',
			'legend_border_color'        => '#cccccc',
			'legend_border_thickness'    => '1',
			'legend_border_style'        => 'solid',

			'section_background_color'   => '#d4d4d4',
			'section_font_color'         => '#373737',
			'section_border_color'       => '',
			'section_border_thickness'   => '0',
			'section_border_style'       => 'solid',

			'label_font_color'           => '#000000',
			'label_font_weight'          => 'bold',
			'label_font_size'            => '12',
			'required_asterisk_color'	 => '#bc1212',

			'fields_background_color'    => '#fafafa',
			'fields_font_color'          => '#000000',
			'fields_font_weight'         => 'normal',
			'fields_font_size'           => '12',

			'descriptions_font_color'    => '#000000',
			'descriptions_font_weight'   => 'normal',
			'descriptions_font_size'     => '11',

			'instructions_background_color' => '#e3e3e3',
			'instructions_font_color'       => '#000000',
			'instructions_border_color'     => '',
			'instructions_border_thickness' => '0',
			'instructions_border_style'     => 'solid',

			'paging_background_color' 	 => '#5b8498',
			'paging_hover_color' 	 	 => '#3d5865',
			'paging_font_color'	 	 	 => '#ffffff',
			'paging_font_weight'	 	 => 'normal',
			'paging_font_size'	 	 	 => '12',

			'validation_font_color'	 	 => 'red',
			'validation_font_weight'	 => 'bold',
			'validation_font_size'	 	 => '11',
			'validation_border_color'	 => 'red',
			'validation_border_thickness'=> '1',
			'validation_border_style'	 => 'solid',

			'width_type'   => 'auto',
			'width_length' => '',
		);

		// Add Display Entries to main VFB menu
		add_action( 'admin_menu', array( &$this, 'admin_menu' ), 30 );

		// Enable saving function
		add_action( 'admin_init', array( &$this, 'save' ) );

		// Check the db version and run SQL install, if needed
		add_action( 'plugins_loaded', array( &$this, 'update_db_check' ) );

		// Display Admin notices when saving
		add_action( 'admin_notices', array( &$this, 'admin_notices' ) );

		// AJAX for copying settings
		add_action( 'wp_ajax_vfb_form_designer_copy_settings', array( &$this, 'ajax_copy_settings' ) );
		add_action( 'wp_ajax_vfb_form_designer_copy_settings_save', array( &$this, 'ajax_copy_settings_save' ) );

		// Add inline styles to header
		add_action( 'wp_head', array( &$this, 'output_styles' ) );

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
	 * @since 1.1
	 */
	public function languages() {
		load_plugin_textdomain( 'vfb-pro-form-designer', false , 'vfb-pro-form-designer/languages' );
	}

	/**
	 * Check database version and run SQL install, if needed
	 *
	 * @since 1.0
	 */
	public function update_db_check() {
		// Add a database version to help with upgrades and run SQL install
		if ( !get_option( 'vfb_form_design_db_version' ) ) {
			update_option( 'vfb_form_design_db_version', $this->vfb_design_db_version );
			$this->install_db();
		}

		// If database version doesn't match, update and maybe run SQL install
		if ( version_compare( get_option( 'vfb_form_design_db_version' ), $this->vfb_design_db_version, '<' ) ) {
			update_option( 'vfb_form_design_db_version', $this->vfb_design_db_version );
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

		$design_table_name = $wpdb->prefix . 'vfb_pro_form_design';

		// Explicitly set the character set and collation when creating the tables
		$charset = ( defined( 'DB_CHARSET' && '' !== DB_CHARSET ) ) ? DB_CHARSET : 'utf8';
		$collate = ( defined( 'DB_COLLATE' && '' !== DB_COLLATE ) ) ? DB_COLLATE : 'utf8_general_ci';

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$design_sql = "CREATE TABLE $design_table_name (
				design_id BIGINT(20) NOT NULL AUTO_INCREMENT,
				form_id BIGINT(20) NOT NULL,
				enable_design TINYINT(1),
				design_type VARCHAR(25),
				design_themes VARCHAR(25),
				design_custom LONGTEXT,
				design_custom_css LONGTEXT,
				PRIMARY KEY  (design_id)
			) DEFAULT CHARACTER SET $charset COLLATE $collate;";

		dbDelta( $design_sql );
	}

	/**
	 * Save settings
	 *
	 * @access public
	 * @return void
	 */
	public function save() {
		global $wpdb;

		if ( !isset( $_REQUEST['vfb-form-design-submit'] ) )
			return;

		if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'save-form-design' ) )
			wp_die( 'Security Check' );

		$form_id              = absint( $_REQUEST['form_id'] );
		$enable_design        = isset( $_REQUEST['vfb-form-design-enable'] ) ? absint( $_REQUEST['vfb-form-design-enable'] ) : 0;
		$design_type          = isset( $_REQUEST['vfb-form-design-type'] ) && $enable_design ? $_REQUEST['vfb-form-design-type'] : '';
		$design_themes        = isset( $_REQUEST['vfb-design-themes'] ) && $enable_design && 'themes' == $design_type ? $_REQUEST['vfb-design-themes'] : '';
		$design_custom        = isset( $_REQUEST['vfb-design-custom'] ) && $enable_design && 'custom' == $design_type ? maybe_serialize( $_REQUEST['vfb-design-custom'] ) : '';
		$design_custom_css    = isset( $_REQUEST['vfb-design-custom-css'] ) && $enable_design && 'custom' == $design_type ? $_REQUEST['vfb-design-custom-css'] : '';

		$data = array(
			'form_id'            => $form_id,
			'enable_design'      => $enable_design,
			'design_type'        => $design_type,
			'design_themes'      => $design_themes,
			'design_custom'      => $design_custom,
			'design_custom_css'  => $design_custom_css,
		);

		// Run query to see if data exists, if yes update, if no insert
		$exists = $wpdb->get_var( $wpdb->prepare( "SELECT form_id FROM $this->design_table_name WHERE form_id = %d", $form_id ) );

		if ( !$exists )
			$wpdb->insert( $this->design_table_name, $data );
		else
			$wpdb->update( $this->design_table_name, $data, array( 'form_id' => $form_id ) );
	}

	/**
	 * ajax_copy_settings function.
	 *
	 * @access public
	 * @return void
	 */
	public function ajax_copy_settings() {
		global $wpdb;

		$form_id = isset( $_GET['form_id'] ) ? absint( $_GET['form_id'] ) : 0;
		$forms = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $this->form_table_name WHERE 1=1 AND form_id != %d ORDER BY form_id ASC", $form_id ) );
?>
<div id="vfb-form-design-copy-settings-container">
	<form id="vfb-form-design-copy-settings" class="media-upload-form type-form validate">
		<h3 class="media-title"><?php _e( 'Copy Form Settings', 'vfb-pro-form-designer' ); ?></h3>
		<p><?php _e( 'Select one or more forms to copy your settings to', 'vfb-pro-form-designer' ); ?></p>
		<div class="vfb-form-design-forms-list">
		<?php
			foreach ( $forms as $form )
				echo sprintf( '<label for="vfb-form-design-copy-%1$d"><input type="checkbox" id="vfb-form-design-copy-%1$d" name="vfb_design_copy[]" value="%1$d" /> %2$s</label><br>',
					$form->form_id,
					stripslashes( $form->form_title )
				);

			submit_button( __( 'Copy', 'vfb-pro-form-designer' ), 'primary', 'vfb-form-design-submit' );
		?>
		</div>
		<input type="hidden" name="form_id" value="<?php echo $form_id; ?>" />
	</form>
</div>
<?php

		die(1);
	}

	/**
	 * ajax_copy_settings_save function.
	 *
	 * @access public
	 * @return void
	 */
	public function ajax_copy_settings_save() {
		global $wpdb;

		if ( !isset( $_REQUEST['action'] ) )
			return;

		if ( $_REQUEST['action'] == 'vfb_form_designer_copy_settings_save' ) {
			//return;

		parse_str( $_REQUEST['data'], $data );

		$copy_ids = (array) $data['vfb_design_copy'];
		$form_id  = absint( $data['form_id'] );

		if ( empty( $copy_ids ) )
			return;

		// Get current design settings
		$design_custom        = $wpdb->get_var( $wpdb->prepare( "SELECT design_custom, design_custom_css FROM $this->design_table_name WHERE form_id = %d", $form_id ) );
		$design_custom_css    = $wpdb->get_var( null, 1 );

		foreach ( $copy_ids as $id ) {
			// Run query to see if data exists, if yes update, if no insert
			$exists = $wpdb->get_var( $wpdb->prepare( "SELECT form_id FROM $this->design_table_name WHERE form_id = %d", $id ) );

			$new_data = array(
				'form_id'           => $id,
				'enable_design'		=> 1,
				'design_type'		=> 'custom',
				'design_custom'     => $design_custom,
				'design_custom_css' => $design_custom_css,
			);

			if ( !$exists )
				$wpdb->insert( $this->design_table_name, $new_data );
			else
				$wpdb->update( $this->design_table_name, $new_data, array( 'form_id' => $id ) );
		}
		}

		die(1);
	}

	/**
	 * Add admin menu
	 *
	 * @access public
	 * @return void
	 */
	public function admin_menu() {
		$current_page = add_submenu_page( 'visual-form-builder-pro', __( 'Form Design', 'vfb-pro-form-designer' ), __( 'Form Design', 'vfb-pro-form-designer' ), 'vfb_edit_email_design', 'vfb-addon-form-design', array( &$this, 'admin' ) );

		// Load admin scripts
		add_action( 'load-' . $current_page, array( &$this, 'admin_scripts' ) );
	}

	/**
	 * Add admin scripts
	 *
	 * @access public
	 * @return void
	 */
	public function admin_scripts() {
		wp_enqueue_style( 'vfb-form-design-admin-css', plugins_url( '/css/vfb-pro-form-designer-admin.css', __FILE__ ) );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'thickbox' );

		wp_enqueue_script( 'vfb-form-design-admin', plugins_url( '/js/vfb-pro-form-design-admin.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), false, true );
		wp_enqueue_script( 'thickbox' );
	}

	/**
	 * Display save notice
	 *
	 * @access public
	 * @return void
	 */
	public function admin_notices() {
		if ( !is_plugin_active( 'visual-form-builder-pro/visual-form-builder-pro.php' ) )
			echo sprintf( '<div id="message" class="error"><p>%s</p></div>', __( 'Visual Form Builder Pro must also be installed and active in order for the Form Designer add-on to function properly.' , 'visual-form-builder-pro' ) );

		if ( !isset( $_REQUEST['vfb-form-design-submit'] ) )
			return;

		echo sprintf( '<div id="vfb-form-design-admin-notice" class="updated"><p>%s</p></div>', __( 'Form design have been saved.', 'vfb-pro-form-designer' ) );
	}

	/**
	 * Display admin
	 *
	 * @access public
	 * @return void
	 */
	public function admin() {
		global $wpdb, $current_user;

		// Query to get all forms
		$order = sanitize_sql_orderby( 'form_id ASC' );
		$where = apply_filters( 'vfb_pre_get_forms_emaildesign', '' );
		$forms = $wpdb->get_results( "SELECT * FROM $this->form_table_name WHERE 1=1 $where ORDER BY $order" );

		if ( !current_user_can( 'vfb_edit_email_design' ) )
			wp_die( __( 'You do not currently have permissions to edit the form design', 'vfb-pro-form-designer' ) );


		if ( isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], array( 'vfb-addon-form-design' ) ) ) :

	?>
	<div class="wrap">
		<?php screen_icon( 'options-general' ); ?>
		<h2><?php _e( 'Form Design', 'vfb-pro-form-designer' ); ?></h2>
		<?php
		if ( !$forms ) :
			echo '<div class="vfb-form-alpha-list"><h3 id="vfb-no-forms">You currently do not have any forms.  Click on the <a href="' . esc_url( admin_url( 'admin.php?page=vfb-add-new' ) ) . '">New Form</a> button to get started.</h3></div>';

		else :

		$form_selected_id = ( isset( $_REQUEST['form_id'] ) ) ? absint( $_REQUEST['form_id'] ) : absint( $forms[0]->form_id );
		$design           = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->design_table_name WHERE form_id = %d", $form_selected_id ) );

		// Setup variables
		$enable_design = $design_type = $design_themes = $design_custom_css = '';

		// Load custom design defaults
		$design_custom = $this->design_custom;

		// Get design variables
		if ( $design ) :
			$enable_design   = ( !empty( $design->enable_design ) ) ? esc_html( $design->enable_design ) : '';
			$design_type     = ( !empty( $design->design_type ) ) ? esc_html( $design->design_type ) : '';
			$design_themes   = ( !empty( $design->design_themes ) ) ? esc_html( $design->design_themes ) : '';
			$design_custom   = ( !empty( $design->design_custom ) ) ? array_merge( $this->design_custom, maybe_unserialize( $design->design_custom ) ) : $this->design_custom;
			$design_custom_css = !empty( $design->design_custom_css ) ? stripslashes( esc_html( $design->design_custom_css ) ) : '';
		endif;

		?>
		<form method="post" id="design-switcher">
            <label for="form_id"><strong><?php _e( 'Select form to design:', 'vfb-pro-form-designer' ); ?></strong></label>
            <select name="form_id">
		<?php
		foreach ( $forms as $form ) {
			echo sprintf( '<option value="%1$d" %2$s id="%3$s">%4$s</option>',
				$form->form_id,
				selected( $form->form_id, $form_selected_id, 0 ),
				$form->form_key,
				stripslashes( $form->form_title )
			);
		}
		?>
		</select>
        <?php submit_button( __( 'Select', 'vfb-pro-form-designer' ), 'secondary', 'submit', false ); ?>
        </form>
	<div id="vfb-form-designer">
		<form method="post" id="form-design-options">
			<input name="action" type="hidden" value="save-form-design" />
			<input name="form_id" type="hidden" value="<?php echo $form_selected_id; ?>" />
			<?php wp_nonce_field( 'save-form-design' ); ?>

			<table class="form-table">
				<tbody>
					<tr align="top">
						<th>
							<label for="vfb-form-design-enable">
								<?php _e( 'Enable Form Design', 'vfb-pro-form-designer' ); ?>
							</label>
						</th>
						<td>
							<input type="checkbox" id="vfb-form-design-enable" name="vfb-form-design-enable" value="1"<?php checked( $enable_design, '1' ); ?> />
						</td>
					</tr>
					<tr align="top" class="form-design-types<?php echo ( $enable_design ) ? ' active' : ''; ?>">
						<th>
							<?php _e( 'Design Type', 'vfb-pro-form-designer' ); ?>
						</th>
						<td>
							<label for="form-design-type-color-themes">
								<input type="radio" id="form-design-type-color-themes" class="vfb-design-types-options" name="vfb-form-design-type" value="themes"<?php checked( $design_type, 'themes' ); ?>> <?php _e( 'Color Themes' ); ?>
							</label><br>
							<label for="form-design-type-custom">
								<input type="radio" id="form-design-type-custom" class="vfb-design-types-options" name="vfb-form-design-type" value="custom"<?php checked( $design_type, 'custom' ); ?>> <?php _e( 'Custom Design' ); ?>
							</label>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="vfb-form-design-themes-container<?php echo ( 'themes' == $design_type ) ? ' active' : ''; ?>">
				<h3><?php _e( 'Color Themes', 'vfb-pro-form-designer' ); ?></h3>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<td>
								<div class="layout vfb-color-scheme">
									<label class="description">
										<input type="radio" name="vfb-design-themes" value="light"<?php checked( $design_themes, 'light' ); ?>>
										<div class="vfb-color-palette">
											<span class="vfb-color" style="background:#d4d4d4;"></span>
											<span class="vfb-color" style="background:#ffffff;"></span>
											<span class="vfb-color" style="background:#bd0000;"></span>
											<span class="vfb-color" style="background:#f3f3f3;"></span>
										</div>
										<?php _e( 'Light', 'vfb-pro-form-designer' ); ?>
									</label>
								</div>
								<div class="layout vfb-color-scheme">
									<label class="description">
										<input type="radio" name="vfb-design-themes" value="dark"<?php checked( $design_themes, 'dark' ); ?>>
										<div class="vfb-color-palette">
											<span class="vfb-color" style="background:#000000;"></span>
											<span class="vfb-color" style="background:#434343;"></span>
											<span class="vfb-color" style="background:#bbbbbb;"></span>
											<span class="vfb-color" style="background:#3a3a3a;"></span>
										</div>
										<?php _e( 'Dark', 'vfb-pro-form-designer' ); ?>
									</label>
								</div>
								<div class="layout vfb-color-scheme">
									<label class="description">
										<input type="radio" name="vfb-design-themes" value="primary"<?php checked( $design_themes, 'primary' ); ?>>
										<div class="vfb-color-palette">
											<span class="vfb-color" style="background:#85FF00;"></span>
											<span class="vfb-color" style="background:#3A83AB;"></span>
											<span class="vfb-color" style="background:#FFE200;"></span>
											<span class="vfb-color" style="background:#FF005E;"></span>
										</div>
										<?php _e( 'Primary', 'vfb-pro-form-designer' ); ?>
									</label>
								</div>
								<div class="layout vfb-color-scheme">
									<label class="description">
										<input type="radio" name="vfb-design-themes" value="pastel"<?php checked( $design_themes, 'pastel' ); ?>>
										<div class="vfb-color-palette">
											<span class="vfb-color" style="background:#e6c6ac;"></span>
											<span class="vfb-color" style="background:#e6d2ac;"></span>
											<span class="vfb-color" style="background:#e6acac;"></span>
											<span class="vfb-color" style="background:#678a8a;"></span>
										</div>
										<?php _e( 'Pastel', 'vfb-pro-form-designer' ); ?>
									</label>
								</div>
								<div class="layout vfb-color-scheme">
									<label class="description">
										<input type="radio" name="vfb-design-themes" value="neutral"<?php checked( $design_themes, 'neutral' ); ?>>
										<div class="vfb-color-palette">
											<span class="vfb-color" style="background:#cabd8f;"></span>
											<span class="vfb-color" style="background:#2e455e;"></span>
											<span class="vfb-color" style="background:#635422;"></span>
											<span class="vfb-color" style="background:#cf5c2a;"></span>
										</div>
										<?php _e( 'Neutral', 'vfb-pro-form-designer' ); ?>
									</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="vfb-form-design-custom-container<?php echo ( 'custom' == $design_type ) ? ' active' : ''; ?>">
				<h3><?php _e( 'Custom Design', 'vfb-pro-form-designer' ); ?></h3>

				<h4><?php _e( 'Fieldsets', 'vfb-pro-form-designer' ); ?></h4>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<th>
								<label for="vfb-fieldset-background-color">
									<?php _e( 'Background Color', 'vfb-pro-form-designer' ); ?>
								</label>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[fieldset_background_color]" id="vfb-fieldset-background-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['fieldset_background_color']; ?>" data-default-color="#eeeeee" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[fieldset_border_color]" id="vfb-fieldset-border-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['fieldset_border_color']; ?>" data-default-color="#d3d3d3" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Thickness', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[fieldset_border_thickness]">
									<?php $this->border_thickness_helper( $design_custom['fieldset_border_thickness'] ); ?>
								</select>
								px
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Style', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[fieldset_border_style]">
									<?php $this->border_style_helper( $design_custom['fieldset_border_style'] ); ?>
								</select>
							</td>
						</tr>
					</tbody>
				</table>

				<h4><?php _e( 'Legends', 'vfb-pro-form-designer' ); ?></h4>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<th>
								<?php _e( 'Font Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[legend_font_color]" id="vfb-legend-font-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['legend_font_color']; ?>" data-default-color="#990000" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[legend_border_color]" id="vfb-legend-border-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['legend_border_color']; ?>" data-default-color="#cccccc" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Thickness', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[legend_border_thickness]">
									<?php $this->border_thickness_helper( $design_custom['legend_border_thickness'] ); ?>
								</select>
								px
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Style', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[legend_border_style]">
									<?php $this->border_style_helper( $design_custom['legend_border_style'] ); ?>
								</select>
							</td>
						</tr>
					</tbody>
				</table>

				<h4><?php _e( 'Sections', 'vfb-pro-form-designer' ); ?></h4>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<th>
								<?php _e( 'Background Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[section_background_color]" id="vfb-section-background-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['section_background_color']; ?>" data-default-color="#d4d4d4" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[section_font_color]" id="vfb-section-font-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['section_font_color']; ?>" data-default-color="#373737" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[section_border_color]" id="vfb-section-border-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['section_border_color']; ?>" data-default-color="" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Thickness', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[section_border_thickness]">
									<?php $this->border_thickness_helper( $design_custom['section_border_thickness'] ); ?>
								</select>
								px
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Style', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[section_border_style]">
									<?php $this->border_style_helper( $design_custom['section_border_style'] ); ?>
								</select>
							</td>
						</tr>
					</tbody>
				</table>

				<h4><?php _e( 'Labels', 'vfb-pro-form-designer' ); ?></h4>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<th>
								<?php _e( 'Font Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[label_font_color]" id="vfb-label-font-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['label_font_color']; ?>" data-default-color="#000000" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Weight', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[label_font_weight]">
									<?php $this->font_weight_helper( $design_custom['label_font_weight'] ); ?>
								</select>
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Size', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[label_font_size]">
									<?php $this->font_size_helper( $design_custom['label_font_size'] ); ?>
								</select>

							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Required Asterisk Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[required_asterisk_color]" id="vfb-required-asterisk-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['required_asterisk_color']; ?>" data-default-color="#bc1212" />
							</td>
						</tr>
					</tbody>
				</table>

				<h4><?php _e( 'Fields', 'vfb-pro-form-designer' ); ?></h4>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<th>
								<?php _e( 'Background Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[fields_background_color]" id="vfb-field-background-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['fields_background_color']; ?>" data-default-color="#000000" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[fields_font_color]" id="vfb-field-font-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['fields_font_color']; ?>" data-default-color="#000000" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Weight', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[fields_font_weight]">
									<?php $this->font_weight_helper( $design_custom['fields_font_weight'] ); ?>
								</select>
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Size', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[fields_font_size]">
									<?php $this->font_size_helper( $design_custom['fields_font_size'] ); ?>
								</select>
								px
							</td>
						</tr>
					</tbody>
				</table>

				<h4><?php _e( 'Descriptions', 'vfb-pro-form-designer' ); ?></h4>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<th>
								<?php _e( 'Font Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[descriptions_font_color]" id="vfb-desc-font-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['descriptions_font_color']; ?>" data-default-color="#000000" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Weight', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[descriptions_font_weight]">
									<?php $this->font_weight_helper( $design_custom['descriptions_font_weight'] ); ?>
								</select>
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Size', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[descriptions_font_size]">
									<?php $this->font_size_helper( $design_custom['descriptions_font_size'] ); ?>
								</select>
								px
							</td>
						</tr>
					</tbody>
				</table>

				<h4><?php _e( 'Instructions', 'vfb-pro-form-designer' ); ?></h4>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<th>
								<?php _e( 'Background Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[instructions_background_color]" id="vfb-instruct-background-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['instructions_background_color']; ?>" data-default-color="#e3e3e3" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[instructions_font_color]" id="vfb-instruct-font-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['instructions_font_color']; ?>" data-default-color="#000000" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[instructions_border_color]" id="vfb-instruct-border-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['section_border_color']; ?>" data-default-color="" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Thickness', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[instructions_border_thickness]">
									<?php $this->border_thickness_helper( $design_custom['instructions_border_thickness'] ); ?>
								</select>
								px
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Style', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[instructions_border_style]">
									<?php $this->border_style_helper( $design_custom['instructions_border_style'] ); ?>
								</select>
							</td>
						</tr>
					</tbody>
				</table>

				<h4><?php _e( 'Paging Button', 'vfb-pro-form-designer' ); ?></h4>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<th>
								<?php _e( 'Background Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[paging_background_color]" id="vfb-background-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['paging_background_color']; ?>" data-default-color="#5b8498" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Hover Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[paging_hover_color]" id="vfb-paging-hover-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['paging_hover_color']; ?>" data-default-color="#3d5865" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[paging_font_color]" id="vfb-paging-font-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['paging_font_color']; ?>" data-default-color="#ffffff" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Weight', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[paging_font_weight]">
									<?php $this->font_weight_helper( $design_custom['paging_font_weight'] ); ?>
								</select>
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Size', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[paging_font_size]">
									<?php $this->font_size_helper( $design_custom['paging_font_size'] ); ?>
								</select>
								px
							</td>
						</tr>
					</tbody>
				</table>

				<h4><?php _e( 'Validation Errors', 'vfb-pro-form-designer' ); ?></h4>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<th>
								<?php _e( 'Font Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[validation_font_color]" id="vfb-validation-font-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['validation_font_color']; ?>" data-default-color="#ff0000" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Weight', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[validation_font_weight]">
									<?php $this->font_weight_helper( $design_custom['validation_font_weight'] ); ?>
								</select>
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Font Size', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[validation_font_size]">
									<?php $this->font_size_helper( $design_custom['validation_font_size'] ); ?>
								</select>
								px
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Color', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<input type="text" name="vfb-design-custom[validation_border_color]" id="vfb-validation-border-color" class="vfb-form-colorPicker" value="<?php echo $design_custom['validation_border_color']; ?>" data-default-color="#ff0000" />
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Thickness', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[validation_border_thickness]">
									<?php $this->border_thickness_helper( $design_custom['validation_border_thickness'] ); ?>
								</select>
								px
							</td>
						</tr>
						<tr align="top">
							<th>
								<?php _e( 'Border Style', 'vfb-pro-form-designer' ); ?>
							</th>
							<td>
								<select name="vfb-design-custom[validation_border_style]">
									<?php $this->border_style_helper( $design_custom['validation_border_style'] ); ?>
								</select>
							</td>
						</tr>
					</tbody>
				</table>

				<h4><?php _e( 'Form Width', 'vfb-pro-form-designer' ); ?></h4>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<th>
								<label for="vfb-design-width-type"><?php _e( 'Width', 'vfb-pro-form-designer' ); ?></label>
							</th>
							<td>
								<input type="number" name="vfb-design-custom[width_length]" id="vfb-design-width-length" class="small-text vfb-design-width-<?php echo 'auto' == $design_custom['width_type'] ? 'hide' : 'show'; ?>" value="<?php echo $design_custom['width_length']; ?>" />
								<select id="vfb-design-width-type" name="vfb-design-custom[width_type]">
									<option value="auto"<?php selected( $design_custom['width_type'], 'auto' ); ?>>auto</option>
									<option value="px"<?php selected( $design_custom['width_type'], 'px' ); ?>>px</option>
									<option value="%"<?php selected( $design_custom['width_type'], '%' ); ?>>%</option>
								</select>
							</td>
						</tr>
					</tbody>
				</table>

				<h4><?php _e( 'Custom CSS Rules', 'vfb-pro-form-designer' ); ?></h4>
				<table class="form-table">
					<tbody>
						<tr align="top">
							<td>
								<p><?php _e( 'Enter additional CSS rules', 'visual-form-builder-pro' ); ?></p>
								<textarea name="vfb-design-custom-css" id="vfb-design-custom-css" class="large-text code" cols="30" rows="10"><?php echo $design_custom_css; ?></textarea>
							</td>
						</tr>
					</tbody>
				</table>

				<div class="clear"></div>

				<h4><?php _e( 'Copy Custom Design Settings', 'vfb-pro-form-designer' ); ?></h4>
				<p><?php _e( 'Easily and quickly transfer your custom design settings from this form to another form.', 'vfb-pro-form-designer' ); ?></p>
				<?php if ( empty( $enable_design ) ) : ?>
					<p style="color: red"><?php _e( 'You must save your custom design settings before you can copy them.', 'vfb-pro-form-designer' ); ?></p>
				<?php else : ?>
					<a id="vfb-design-custom-copy" href="<?php echo add_query_arg( array( 'action' => 'vfb_form_designer_copy_settings', 'form_id' => $form_selected_id, 'width' => '640' ), admin_url( 'admin-ajax.php' ) ); ?>" class="button thickbox" title="Copy Form Settings">
						<?php _e( 'Copy Settings' , 'visual-form-builder-pro'); ?>
					</a>
				<?php endif; ?>
			</div>
			<?php submit_button( __( 'Save', 'vfb-pro-form-designer' ), 'primary', 'vfb-form-design-submit' ); ?>
		<?php endif; ?>
		</form>
	</div> <!-- vfb-form-designer -->

	<div id="vfb-design-custom-preview">
		<h2>Form Preview</h2>
		<p>Save options to view your recent changes.</p>
		<iframe frameborder="0" scrolling="auto" src="<?php echo esc_url( add_query_arg( array( 'form' => $form_selected_id ), plugins_url( 'visual-form-builder-pro/form-preview.php' ) ) ); ?>"></iframe>
	</div> <!-- vfb-design-custom-preview -->

	</div> <!-- .wrap -->

	<?php
		endif;
	}

	/**
	 * A font size helper function
	 *
	 * @access public
	 * @param mixed $field_name
	 * @return void
	 */
	public function font_size_helper( $field_name ){
?>
        <option value="8"<?php selected( $field_name, 8 ); ?>>8</option>
        <option value="9"<?php selected( $field_name, 9 ); ?>>9</option>
        <option value="10"<?php selected( $field_name, 10 ); ?>>10</option>
        <option value="11"<?php selected( $field_name, 11 ); ?>>11</option>
        <option value="12"<?php selected( $field_name, 12 ); ?>>12</option>
        <option value="13"<?php selected( $field_name, 13 ); ?>>13</option>
        <option value="14"<?php selected( $field_name, 14 ); ?>>14</option>
        <option value="15"<?php selected( $field_name, 15 ); ?>>15</option>
        <option value="16"<?php selected( $field_name, 16 ); ?>>16</option>
        <option value="18"<?php selected( $field_name, 18 ); ?>>18</option>
        <option value="20"<?php selected( $field_name, 20 ); ?>>20</option>
        <option value="24"<?php selected( $field_name, 24 ); ?>>24</option>
        <option value="28"<?php selected( $field_name, 28 ); ?>>28</option>
        <option value="32"<?php selected( $field_name, 32 ); ?>>32</option>
        <option value="36"<?php selected( $field_name, 36 ); ?>>36</option>
<?php
	}

	/**
	 * A font weight helper function
	 *
	 * @access public
	 * @param mixed $field_name
	 * @return void
	 */
	public function font_weight_helper( $field_name ){
?>
        <option value="normal"<?php selected( $field_name, 'normal' ); ?>>Normal</option>
		<option value="bold"<?php selected( $field_name, 'bold' ); ?>>Bold</option>
		<option value="italic"<?php selected( $field_name, 'italic' ); ?>>Italic</option>
<?php
	}

	/**
	 * A border thickness helper function
	 *
	 * @access public
	 * @param mixed $field_name
	 * @return void
	 */
	public function border_thickness_helper( $field_name ){
?>
        <option value="0"<?php selected( $field_name, 0 ); ?>>0</option>
		<option value="1"<?php selected( $field_name, 1 ); ?>>1</option>
		<option value="2"<?php selected( $field_name, 2 ); ?>>2</option>
		<option value="3"<?php selected( $field_name, 3 ); ?>>3</option>
		<option value="4"<?php selected( $field_name, 4 ); ?>>4</option>
		<option value="5"<?php selected( $field_name, 5 ); ?>>5</option>
		<option value="6"<?php selected( $field_name, 6 ); ?>>6</option>
		<option value="7"<?php selected( $field_name, 7 ); ?>>7</option>
		<option value="8"<?php selected( $field_name, 8 ); ?>>8</option>
		<option value="9"<?php selected( $field_name, 9 ); ?>>9</option>
		<option value="10"<?php selected( $field_name, 10 ); ?>>10</option>
<?php
	}

	/**
	 * A border style helper function
	 *
	 * @access public
	 * @param mixed $field_name
	 * @return void
	 */
	public function border_style_helper( $field_name ){
?>
        <option value="solid"<?php selected( $field_name, 'solid' ); ?>>Solid</option>
		<option value="dotted"<?php selected( $field_name, 'dotted' ); ?>>Dotted</option>
		<option value="dashed"<?php selected( $field_name, 'dashed' ); ?>>Dashed</option>
		<option value="double"<?php selected( $field_name, 'double' ); ?>>Double</option>
<?php
	}

	/**
	 * Output theme or custom design
	 *
	 * @access public
	 * @return void
	 */
	public function output_styles() {
		$designs = $this->get_styles();

		// Stop if no form designs found
		if ( !$designs )
			return;

		foreach ( $designs as $design ) :
			$form_id         = absint( $design->form_id );
			$enable_design   = absint( $design->enable_design );
			$design_type     = ( !empty( $design->design_type ) ) ? esc_html( $design->design_type ) : '';
			$design_themes   = ( !empty( $design->design_themes ) ) ? esc_html( $design->design_themes ) : '';
			$design_custom   = ( !empty( $design->design_custom ) ) ? array_merge( $this->design_custom, maybe_unserialize( $design->design_custom ) ) : $this->design_custom;
			$design_custom_css = !empty( $design->design_custom_css ) ? stripslashes( $design->design_custom_css ) : '';

			// Stop if form designs is not enabled for this form
			if ( !$enable_design )
				continue;

			// Stop if no design type has been selected
			if ( '' == $design_type )
				continue;

			switch ( $design_type ) :

				case 'themes' :
					echo "\n";
?>
<link rel='stylesheet' href='<?php echo plugins_url( "css/themes/vfb-pro-theme-$design_themes.css", __FILE__ ); ?>?ver=20130918' type='text/css' media='all' />
<?php
				break;

				case 'custom' :

					$width_type = 'auto';
					$width_length = '';

					// Only use custom settings when the width isn't set to auto
					if ( 'auto' !== $design_custom['width_type'] ) {
						$width_type = esc_html( $design_custom['width_type'] );
						$width_length = absint( $design_custom['width_length'] );
					}
?>
<style type="text/css">
	/* Form Width */
	div#vfb-form-<?php echo $form_id; ?> {
		width: <?php echo $width_length . $width_type; ?>;
	}
	/* Fieldsets */
	.vfb-form-<?php echo $form_id; ?> fieldset {
		background-color: <?php echo esc_html( $design_custom['fieldset_background_color'] ); ?>;
		border: <?php echo sprintf( '%1$dpx %2$s %3$s', $design_custom['fieldset_border_thickness'], $design_custom['fieldset_border_style'], $design_custom['fieldset_border_color'] ); ?>;
	}

	/* Legends */
	.vfb-form-<?php echo $form_id; ?> .vfb-legend {
		border-bottom: <?php echo sprintf( '%1$dpx %2$s %3$s', $design_custom['legend_border_thickness'], $design_custom['legend_border_style'], $design_custom['legend_border_color'] ); ?>;
		color: <?php echo esc_html( $design_custom['legend_font_color'] ); ?>;
	}

	/* Sections */
	.vfb-form-<?php echo $form_id; ?> .vfb-section-div {
		background-color: <?php echo esc_html( $design_custom['section_background_color'] ); ?>;
		border: <?php echo sprintf( '%1$dpx %2$s %3$s', $design_custom['section_border_thickness'], $design_custom['section_border_style'], $design_custom['section_border_color'] ); ?>;
		color: <?php echo esc_html( $design_custom['section_font_color'] ); ?>;
	}

		.vfb-form-<?php echo $form_id; ?> .vfb-section-div h4 {
			border-bottom: <?php echo sprintf( '%1$dpx %2$s %3$s', $design_custom['section_border_thickness'], $design_custom['section_border_style'], $design_custom['section_border_color'] ); ?>;
		}

	/* Labels */
	.vfb-form-<?php echo $form_id; ?> label.vfb-desc,
	.vfb-form-<?php echo $form_id; ?> .verification,
	.vfb-form-<?php echo $form_id; ?> .vfb-page-counter {
		font-weight: <?php echo esc_html( $design_custom['label_font_weight'] ); ?>;
		font-size: <?php echo esc_html( $design_custom['label_font_size'] ); ?>px;
		color: <?php echo esc_html( $design_custom['label_font_color'] ); ?>;
	}

		.vfb-form-<?php echo $form_id; ?> label .vfb-required-asterisk {
			color: <?php echo esc_html( $design_custom['required_asterisk_color'] ); ?>;
		}

	/* Fields */
	.vfb-form-<?php echo $form_id; ?> input.vfb-text,
	.vfb-form-<?php echo $form_id; ?> textarea.vfb-textarea {
		background-color: <?php echo esc_html( $design_custom['fields_background_color'] ); ?>;
		font-weight: <?php echo esc_html( $design_custom['fields_font_weight'] ); ?>;
		font-size: <?php echo esc_html( $design_custom['fields_font_size'] ); ?>px;
		color: <?php echo esc_html( $design_custom['fields_font_color'] ); ?>;
	}

	/* Descriptions */
	.vfb-form-<?php echo $form_id; ?> li span label {
		font-weight: <?php echo esc_html( $design_custom['descriptions_font_weight'] ); ?>;
		font-size: <?php echo esc_html( $design_custom['descriptions_font_size'] ); ?>px;
		color: <?php echo esc_html( $design_custom['descriptions_font_color'] ); ?>;
	}

	/* Instructions */
	.vfb-form-<?php echo $form_id; ?> .vfb-item-instructions {
	    background-color: <?php echo esc_html( $design_custom['instructions_background_color'] ); ?>;
	    border: <?php echo sprintf( '%1$dpx %2$s %3$s', $design_custom['instructions_border_thickness'], $design_custom['instructions_border_style'], $design_custom['instructions_border_color'] ); ?>;
	    color: <?php echo esc_html( $design_custom['instructions_font_color'] ); ?>;
	}

	/* Paging Button */
	.vfb-form-<?php echo $form_id; ?> .vfb-page-next {
		background-color: <?php echo esc_html( $design_custom['paging_background_color'] ); ?>;
		font-weight: <?php echo esc_html( $design_custom['paging_font_weight'] ); ?>;
		font-size: <?php echo esc_html( $design_custom['paging_font_size'] ); ?>px;
		color: <?php echo esc_html( $design_custom['paging_font_color'] ); ?>;
	}

		.vfb-form-<?php echo $form_id; ?> .vfb-page-next:hover {
			background-color: <?php echo esc_html( $design_custom['paging_hover_color'] ); ?>;
		}

	/* Validation */
	.vfb-form-<?php echo $form_id; ?> input.vfb-text.vfb-error,
	.vfb-form-<?php echo $form_id; ?> input[type="text"].vfb-text.vfb-error,
	.vfb-form-<?php echo $form_id; ?> input[type="tel"].vfb-text.vfb-error,
	.vfb-form-<?php echo $form_id; ?> input[type="email"].vfb-text.vfb-error,
	.vfb-form-<?php echo $form_id; ?> input[type="url"].vfb-text.vfb-error,
	.vfb-form-<?php echo $form_id; ?> select.vfb-select.vfb-error,
	.vfb-form-<?php echo $form_id; ?> textarea.vfb-textarea.vfb-error {
		border: <?php echo sprintf( '%1$dpx %2$s %3$s', $design_custom['validation_border_thickness'], $design_custom['validation_border_style'], $design_custom['validation_border_color'] ); ?>;
	}

		.vfb-form-<?php echo $form_id; ?> label.vfb-error {
			font-weight: <?php echo esc_html( $design_custom['validation_font_weight'] ); ?>;
			font-size: <?php echo esc_html( $design_custom['validation_font_size'] ); ?>px;
			color: <?php echo esc_html( $design_custom['validation_font_color'] ); ?>;
		}

<?php
echo "/* Custom Rules */\n";
echo $design_custom_css;
?>

</style>
<?php
				break;

			endswitch;
		endforeach;
	}

	/**
	 * get_styles function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_styles() {

		global $wpdb;

		$designs = $wpdb->get_results( "SELECT * FROM $this->design_table_name ORDER BY form_id ASC" );

		// Stop if no form designs found
		if ( !$designs )
			return;

		return $designs;
	}

	/**
	 * get_theme function.
	 *
	 * @access public
	 * @param mixed $form_id (default: null)
	 * @return void
	 */
	public function get_theme( $form_id = null ) {

		if ( !$form_id )
			return;

		global $wpdb;

		$theme = $wpdb->get_var( $wpdb->prepare( "SELECT design_themes FROM $this->design_table_name WHERE form_id = %d", $form_id ) );

		if ( !$theme )
			return;

		return $theme;
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
