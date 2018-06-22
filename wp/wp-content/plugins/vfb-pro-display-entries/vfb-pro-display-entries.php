<?php
/*
Plugin Name: Visual Form Builder Pro - Display Entries
Plugin URI: http://vfb.matthewmuro.com
Description: An add-on for Visual Form Builder Pro that displays entries on your site.
Author: Matthew Muro
Author URI: http://matthewmuro.com
Version: 1.5.4
*/

/**
 * Template tag function
 *
 * @since 1.0
 * @echo class function VFB display entries code
 */
function vfb_display_entries( $args = '' ){
	// Create new class instance
	$template_tag = new VFB_Pro_Display_Entries();

	$echo = 1;

	// Parse the arguments into an array
	$args = wp_parse_args( $args );

	extract( $args );

	// Print the output
	if ( $echo )
		echo $template_tag->display_entries( $args );
	else
		return $template_tag->display_entries( $args );
}

// Add action so themes can call via do_action( 'vfb_display_entries', $id );
add_action( 'vfb_display_entries', 'vfb_display_entries' );

$vfb_display_entries_load = new VFB_Pro_Display_Entries();

// VFB Pro Create User class
class VFB_Pro_Display_Entries{

	/**
	 * The plugin API
	 *
	 * @since 1.0
	 * @var string
	 * @access protected
	 */
	protected $api_url = 'http://matthewmuro.com/plugin-api/display-entries/';

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
		$this->form_table_name 		= $wpdb->prefix . 'vfb_pro_forms';
		$this->entries_table_name 	= $wpdb->prefix . 'vfb_pro_entries';

		// Setup our default columns
		$this->default_cols = array(
			'entries_id' 		=> __( 'Entries ID' , 'vfb_pro_display_entries'),
			'date_submitted' 	=> __( 'Date Submitted' , 'vfb_pro_display_entries'),
			'ip_address' 		=> __( 'IP Address' , 'vfb_pro_display_entries'),
			'subject' 			=> __( 'Subject' , 'vfb_pro_display_entries'),
			'sender_name' 		=> __( 'Sender Name' , 'vfb_pro_display_entries'),
			'sender_email' 		=> __( 'Sender Email' , 'vfb_pro_display_entries'),
			'emails_to' 		=> __( 'Emailed To' , 'vfb_pro_display_entries'),
		);

		// Load front-end styles and scripts
		add_action( 'wp_enqueue_scripts', array( &$this, 'css' ), 20 );

		// Register shortcode
		add_shortcode( 'vfb-display-entries', array( &$this, 'display_entries' ) );

		// Add Display Entries to main VFB menu
		add_action( 'admin_menu', array( &$this, 'admin_menu' ), 20 );

		// Display Admin notices when saving
		add_action( 'admin_notices', array( &$this, 'admin_notices' ) );

		// AJAX for loading new entry checkboxes
		add_action( 'wp_ajax_vfb_display_entries_load_options', array( &$this, 'ajax_load_options' ) );

		// AJAX for getting entries count
		add_action( 'wp_ajax_vfb_display_entries_entries_count', array( &$this, 'ajax_entries_count' ) );

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
	 * @since 2.1.2
	 */
	public function languages() {
		load_plugin_textdomain( 'vfb_pro_display_entries', false , 'vfb-pro-display-entries/languages' );
	}

	/**
	 * Enqueue CSS
	 *
	 * Add CSS to front-end
	 *
	 * @since 1.0
	 * @access public
	 */
	public function css() {
		wp_enqueue_style( 'vfb-display-entries-css', plugins_url( '/css/vfb-pro-display-entries.css', __FILE__ ), array(), '20130822' );
		wp_enqueue_style( 'vfb-jqueryui-css' );
	}

	/**
	 * Enqueue JavaScript
	 *
	 * Add JS to the front-end
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param   array   $post_data	Post data
	 * @param	int		$user_id	User ID
	 * @param	int		$form_id	Form ID
	 */
	public function scripts() {
		// Make sure scripts are only added once via shortcode
		$this->add_scripts = true;

		wp_enqueue_script( 'vfb-jquery-datatables', plugins_url( '/js/jquery.dataTables.min.js', __FILE__ ), array( 'jquery' ), '1.9.4', true );
		wp_enqueue_script( 'vfb-display-entries', plugins_url( '/js/vfb-pro-display-entries.js', __FILE__ ), array( 'jquery' ), '20130822', true );
	}

	/**
	 * Display Entries
	 *
	 * The shortcode function that displays the entries table
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @uses single_entry()
	 * @uses build_table()
	 *
	 * @param   array   $atts		Shortcode attributes
	 * @param	string	$output		Shortcode output
	 * @return 	string	$output		Shortcode output or inactive plugin notification
	 */
	public function display_entries( $atts, $output = '' ) {

		// Display an error message if the main plugin is not active
		if ( !class_exists( 'Visual_Form_Builder_Pro' ) )
			return '<div class="vfb-plugin-inactive"><p>' . __( 'Visual Form Builder Pro must be active in order to display entries.', 'vfb_pro_display_entries' ) . '</p></div>';

		// Add JavaScript files to the front-end, only once
		if ( !$this->add_scripts )
			$this->scripts();

		extract( $atts );

		if ( isset( $entry_id ) )
			$output = $this->single_entry( $entry_id );
		else
			$output = $this->build_table( $atts );

		return $output;
	}

	/**
	 * Single Entry display
	 *
	 * Displays a single entry instead of a table of multiple entries
	 *
	 * @since 1.4
	 * @access public
	 *
	 * @param	int		$entry_id	Entry ID
	 * @return	string	$output		Single entry table output
	 */
	public function single_entry( $entry_id ) {
		global $wpdb;

		if ( 0 == $entry_id )
			return;

		$entries = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $this->entries_table_name WHERE entries_id = %d AND entry_approved = 1 LIMIT 1", $entry_id ), ARRAY_A );

		// Return nothing if no entries found
		if ( !$entries )
			return;

		// Get serialized data
		$data = maybe_unserialize( $entries[0]['data'] );

		$output = '';
		$count = 0;
		$open_fieldset = $open_section = false;

		foreach ( $data as $entry ) :

			$name	= stripslashes( $entry['name'] );
			$value	= ( isset( $entry['value'] ) && $entry['value'] !== '' ) ? wp_specialchars_decode( stripslashes( $entry['value'] ), ENT_QUOTES ) : '&nbsp;';
			$row	= ( $count % 2 ) ? 'odd' : 'even';

			switch ( $entry['type'] ) :
				case 'submit' :
				case 'page-break' :
				case 'verification' :
				case 'secret' :
					break;

				case 'fieldset' :
					if ( $open_fieldset == true )
						$output .= '</table>';

					$output .= sprintf( '<table cellpadding="0" cellspacing="0" border="0" class="vfb-display-entries-single"><thead><tr><th colspan="2">%s</th></tr></thead>', $name );

					$open_fieldset = true;
					break;


				case 'section' :
					$output .= sprintf(
						'<tr valign="top" class="vfb-display-entries-row-%2$s"><td colspan="2">%1$s</td></tr>',
						$name,
						$row
					);
					break;

				default :
					$output .= sprintf(
						'<tr valign="top" class="vfb-display-entries-row-%3$s"><th>%1$s</th><td>%2$s</td></tr>',
						$name,
						$value,
						$row
					);
					break;

			endswitch;

			$count++;

		endforeach;

		$output .= '</table>';

		return $output;
	}

	/**
	 * Table output
	 *
	 * Called by the display_entries function
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @uses get_cols()
	 *
	 * @param   array   $post_data	Post data
	 * @param	int		$user_id	User ID
	 * @param	int		$form_id	Form ID
	 * @return	string	$output		Multiple entries table
	 */
	public function build_table( $atts ) {
		global $wpdb;

		// Set inital fields as a string
		$initial_fields = implode( ',', $this->default_cols );

		// Extract shortcode attributes, set defaults
		extract( shortcode_atts( array(
			'id'     => '',
			'page'   => 0,
			'fields' => $initial_fields
			), $atts )
		);

		$output = $headers = $rows = $where = '';

		$limit = '0,1000';

		if ( 0 !== $id )
			$where .= $wpdb->prepare( " AND form_id = %d", $id );

		if ( $page > 1 )
			$limit = ( $page - 1 ) * 1000 . ',1000';

		$entries = $wpdb->get_results( "SELECT * FROM $this->entries_table_name WHERE 1=1 AND entry_approved = 1 $where LIMIT $limit", ARRAY_A );

		// Return nothing if no entries found
		if ( !$entries )
			return;

		// Get columns
		$columns = $this->get_cols( $entries );

		// Get JSON data
		$data = json_decode( $columns, true );

		// Build array of fields to display
		$fields = array_map( 'trim', explode( ',', $fields ) );

		// Strip slashes from header values
		$fields = array_map( 'stripslashes', $fields );

		$fields_clean = array();

		// Build headers
		foreach ( $fields as $header ) {
			// Strip unique ID for a clean header
			$search = preg_replace( '/{{(\d+)}}/', '', $header );
			$field_header = $search;

			// Decode special characters
			$fields_clean[] = wp_specialchars_decode( $header, ENT_QUOTES );

			$headers .= sprintf( '<th>%s</th>', wp_specialchars_decode( stripslashes( esc_html( $field_header ) ), ENT_QUOTES ) );
		}

		// Build table rows and cells
		foreach ( $data as $row ) :
			$rows .= '<tr>';

			foreach ( $fields_clean as $label ) {
				// Decode special characters
				$label = wp_specialchars_decode( $label, ENT_QUOTES );

				// If match found, add data to cell. Otherwise blank
				$rows .= ( isset( $row[ $label ] ) && $row[ $label ] !== '' ) ? '<td>' . $row[ $label ] . '</td>' : '<td>&nbsp;</td>';
			}

			$rows .= '</tr>';
		endforeach;

		$output .= sprintf( '<table cellpadding="0" cellspacing="0" border="0" class="vfb-display-entries" id="%1$s"><thead><tr>%2$s</tr><tbody>%3$s</tbody><tfoot><tr>%2$s</tr></tfoot></table>', "vfb-display-entries-$id", $headers, $rows );

		return $output;
	}

	/**
	 * Get columns
	 *
	 * Loops through entry data and builds name=>value pairs
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param   array   $entries	Entries data
	 * @return	array	$output		JSON encoded array
	 */
	public function get_cols( $entries ) {

		// Initialize row index at 0
		$row = 0;
		$output = array();

		// Loop through all entries
		foreach ( $entries as $entry ) :

			foreach ( $entry as $key => $value ) :

				switch ( $key ) :
					case 'entries_id':
					case 'date_submitted':
					case 'ip_address':
					case 'subject':
					case 'sender_name':
					case 'sender_email':
						$output[ $row ][ esc_html( stripslashes( $this->default_cols[ $key ] ) ) ] = $value;
					break;

					case 'emails_to':
						$output[ $row ][ esc_html( stripslashes( $this->default_cols[ $key ] ) ) ] = implode( ',', maybe_unserialize( $value ) );
					break;

					case 'data':
						// Unserialize value only if it was serialized
						$fields = maybe_unserialize( $value );

						// Loop through our submitted data
						foreach ( $fields as $field_key => $field_value ) :
							// Cast each array as an object
							$obj = (object) $field_value;

							switch ( $obj->type ) {
								case 'fieldset' :
								case 'section' :
								case 'instructions' :
								case 'page-break' :
								case 'verification' :
								case 'secret' :
								case 'submit' :
								break;

								default :
									$output[ $row ][ esc_html( stripslashes( $obj->name ) ) . "{{{$obj->id}}}" ] = stripslashes( $obj->value );
								break;
							} //end $obj switch
						endforeach; // end $fields loop
					break;
				endswitch;

			endforeach; // end $entry loop
			$row++;
		endforeach; //end $entries loop

		return json_encode( $output );
	}

	/**
	 * Count Entries
	 *
	 * A simple count of entries for a particular form
	 *
	 * @since 1.4
	 * @access public
	 *
	 * @param	int		$form_id	Form ID
	 * @return	int		$count		Count of entries, if found, or 0
	 */
	public function count_entries( $form_id ) {
		global $wpdb;

		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $this->entries_table_name WHERE form_id = %d", $form_id ) );

		if ( !$count )
			return 0;

		return $count;
	}

	/**
	 * Admin menu
	 *
	 * Adds the Display Entries to VFB Pro menu
	 *
	 * @since 1.0
	 * @access public
	 */
	public function admin_menu() {
		$current_page = add_submenu_page( 'visual-form-builder-pro', __( 'Display Entries', 'vfb_pro_display_entries' ), __( 'Display Entries', 'vfb_pro_display_entries' ), 'vfb_edit_entries', 'vfb-addon-display-entries', array( &$this, 'admin' ) );

		// Load admin scripts
		add_action( 'load-' . $current_page, array( &$this, 'admin_scripts' ) );
	}

	/**
	 * Admin Scripts
	 *
	 * Add JS to admin
	 *
	 * @since 1.0
	 * @access public
	 */
	public function admin_scripts() {
		wp_enqueue_style( 'vfb-display-entries-admin-css', plugins_url( '/css/vfb-pro-display-entries-admin.css', __FILE__ ) );
		wp_enqueue_script( 'vfb-display-entries-admin', plugins_url( '/js/vfb-pro-display-entries-admin.js', __FILE__ ), array( 'jquery' ), false, true );
	}

	/**
	 * Display save notice
	 *
	 * @access public
	 * @return void
	 */
	public function admin_notices() {
		if ( !is_plugin_active( 'visual-form-builder-pro/visual-form-builder-pro.php' ) )
			echo sprintf( '<div id="message" class="error"><p>%s</p></div>', __( 'Visual Form Builder Pro must also be installed and active in order for the Display Entries add-on to function properly.' , 'visual-form-builder-pro' ) );
	}

	/**
	 * AJAX Load Entries Fields
	 *
	 * Load entry fields via AJAX
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @uses get_cols()
	 * @uses build_options()
	 */
	public function ajax_load_options() {
		global $wpdb;

		if ( !isset( $_REQUEST['action'] ) )
			return;

		if ( $_REQUEST['action'] !== 'vfb_display_entries_load_options' )
			return;

		$form_id = absint( $_REQUEST['id'] );

		$entries_count = $this->count_entries( $form_id );

		// Return nothing if no entries found
		if ( !$entries_count ) {
			echo __( 'No entries to pull field names from.', 'vfb_pro_display_entries' );
			wp_die();
		}

		$offset = '';
		$limit = 1000;

		if ( isset( $_REQUEST['count'] ) )
			$limit = absint( $_REQUEST['count'] );
		elseif ( isset( $_REQUEST['offset'] ) ) {
			$offset = absint( $_REQUEST['offset'] );
			$offset_num = $offset * 1000;

			if ( $offset >= 1 )
				$offset = "OFFSET $offset";
		}

		// Safe to get entries now
		$entries = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT data FROM $this->entries_table_name WHERE form_id = %d AND entry_approved = 1 LIMIT $limit $offset", $form_id ), ARRAY_A );

		// Get columns
		$columns = $this->get_cols( $entries );

		// Get JSON data
		$data = json_decode( $columns, true );

		echo $this->build_options( $data );

		wp_die();
	}

	/**
	 * AJAX Count Entries
	 *
	 * Retrieve count of entries
	 * Used to conditionally display the Page to Display option
	 *
	 * @since 1.4
	 * @access public
	 *
	 * @uses count_entries()
	 */
	public function ajax_entries_count() {
		global $wpdb;

		if ( !isset( $_REQUEST['action'] ) )
			return;

		if ( $_REQUEST['action'] !== 'vfb_display_entries_entries_count' )
			return;

		$form_id = absint( $_REQUEST['id'] );

		echo $this->count_entries( $form_id );

		wp_die();
	}

	/**
	 * Build field checkboxes
	 *
	 * Called by AJAX function to load entry checkboxes
	 *
	 * @since 1.2
	 * @access public
	 *
	 * @param   array   $data		Entry data
	 */
	public function build_options( $data ) {

		$output = '';

		$array = array();
		foreach ( $data as $row ) :
			$array = array_merge( $row, $array );
		endforeach;

		$array = array_keys( $array );
		$array = array_values( array_merge( $this->default_cols, $array ) );
		$array = array_map( 'stripslashes', $array );

		foreach ( $array as $k => $v ) :
			$selected = ( in_array( $v, $this->default_cols ) ) ? ' checked="checked"' : '';

			// Strip unique ID for a clean list
			$search = preg_replace( '/{{(\d+)}}/', '', $v );

			$output .= sprintf( '<label for="vfb-display-entries-val-%1$d"><input name="entries_columns[]" class="vfb-display-entries-vals" id="vfb-display-entries-val-%1$d" type="checkbox" value="%4$s" %3$s> %2$s</label><br>', $k, $search, $selected, $v );
		endforeach;

		return $output;

	}

	/**
	 * Admin page
	 *
	 * Build admin page
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @uses get_cols()
	 * @uses count_entries()
	 * @uses build_options()
	 */
	public function admin() {
		global $wpdb, $current_user;

		get_currentuserinfo();

		// Save current user ID
		$user_id = $current_user->ID;

		if ( isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], array( 'vfb-addon-display-entries' ) ) && current_user_can( 'vfb_edit_entries' ) ) :

		// Query to get all forms
		$order = sanitize_sql_orderby( 'form_id ASC' );
		$where = $page_shortcode = $page_templatetag = '';
		$forms = $wpdb->get_results( "SELECT * FROM $this->form_table_name WHERE 1=1 $where AND form_status = 'publish' ORDER BY $order" );
	?>
	<div class="wrap">
		<?php screen_icon( 'options-general' ); ?>
		<h2><?php _e( 'Display Entries', 'vfb_pro_display_entries' ); ?></h2>
	<?php
		if ( !$forms ) {
			echo '<div class="vfb-form-alpha-list"><h3 id="vfb-no-forms">You currently do not have any forms.  Click on the <a href="' . esc_url( admin_url( 'admin.php?page=vfb-add-new' ) ) . '">New Form</a> button to get started.</h3></div>';
			return;
		}

		$entries_count = $this->count_entries( $forms[0]->form_id );

		// Return nothing if no entries found
		if ( !$entries_count ) :
			$no_entries = __( 'No entries to pull field names from.', 'vfb_pro_display_entries' );
		else :

			$limit = $entries_count > 1000 ? 1000 : $entries_count;

			// Safe to get entries now
			$entries = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT data FROM $this->entries_table_name WHERE form_id = %d AND entry_approved = 1 LIMIT %d", $forms[0]->form_id, $limit ), ARRAY_A );

			// Get columns
			$columns = $this->get_cols( $entries );

			// Get JSON data
			$data = json_decode( $columns, true );
		endif;
	?>
		<h3><?php _e( 'Build table output codes', 'vfb_pro_display_entries' ); ?></h3>
		<p><?php _e( 'Use the tools below to build a shortcode or template tag that will display your entries in a sortable and searchable data table.', 'vfb_pro_display_entries' ); ?></p>

		<form id="vfb-display-entries-admin-form" method="post">
			<table class="form-table">
				<tbody>
					<tr align="top">
						<th>
							<?php _e( 'Select Form', 'vfb_pro_display_entries' ); ?>
						</th>
						<td>
							<select id="vfb-display-entries-forms" name="vfb-display-entries-forms">
							<?php foreach ( $forms as $form ) : ?>
								<option value="<?php echo $form->form_id; ?>"><?php echo stripslashes( $form->form_title ); ?></option>
							<?php endforeach; ?>
							</select>
						</td>
					</tr>
<?php
				$page_shortcode = $page_templatetag = '';

				if ( $entries_count > 1000 ) :
					// Set page shortcode attribute
					$page_shortcode = ' page=1';
					$page_templatetag = '&page=1';

					$num_pages = ceil( $entries_count / 1000 );
?>
					<tr id="vfb-export-entries-pages" align="top">
						<th>
							<label class="vfb-export-label"><?php _e( 'Page to Display', 'vfb_pro_display_entries' ); ?>:</label>
						</th>
						<td>
							<select id="vfb-export-entries-rows" name="entries_page">
<?php
							for ( $i = 1; $i <= $num_pages; $i++ ) {
								echo sprintf( '<option value="%1$d">%1$s</option>', $i );
							}
?>
							</select>
							<p class="description"><?php _e( 'A large number of entries have been detected for this form. Only 1000 entries can be displayed at a time.', 'vfb_pro_display_entries' ); ?></p>
						</td>
					</tr>
<?php
				endif;
?>
					<tr align="top">
						<th>
							<?php _e( 'Fields', 'vfb_pro_display_entries' ); ?>
						</th>
						<td>
							<p><a id="vfb-display-entries-select-all" href="#"><?php _e( 'Select All', 'vfb_pro_display_entries' ); ?></a></p>
							<div id="vfb-display-entries-fields">
							<?php
								if ( isset( $no_entries ) )
									echo $no_entries;
								else
									echo $this->build_options( $data );
							?>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<?php
				// Save first form ID for initial view
				$first_form_id = $forms[0]->form_id;
			?>
			<h3><?php _e( 'Shortcode', 'vfb_pro_display_entries' ); ?></h3>
			<p><?php _e( 'Shortcodes may be used in a Post, Page, or Custom Post Type.', 'vfb_pro_display_entries' ); ?></p>
			<textarea id="vfb-display-entries-shortcode" rows="10" cols="75" class="code">[vfb-display-entries id=<?php echo $first_form_id . $page_shortcode; ?>]</textarea>

			<h3><?php _e( 'Template tag', 'vfb_pro_display_entries' ); ?></h3>
			<p><?php _e( 'Template tags can only be used in your theme PHP files.', 'vfb_pro_display_entries' ); ?></p>
			<textarea id="vfb-display-entries-template-tag" rows="10" cols="75" class="code">&lt;?php vfb_display_entries( 'id=<?php echo $first_form_id . $page_templatetag; ?>' ); ?&gt;</textarea>
		</form>
	</div> <!-- .wrap -->
	<?php
		endif;
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