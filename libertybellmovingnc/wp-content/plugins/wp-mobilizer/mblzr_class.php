<?php

/**
 * @package WP-Mobilizer
 * @link http://www.wp-mobilizer.com
 * @copyright Copyright &copy; 2013, Kilukru Media
 * @version: 1.0.6
 */

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
//ini_set('log_errors', 'On');
//ini_set('error_reporting', E_ALL);

/**
 * Include some libraries
 */
require_once( plugin_dir_path( __FILE__ ) . 'libraries/mdetect.php');

/**
 * Init the Class with MobileESP Class init
 */
class WP_Mobilizer extends MBLZR_uagent_info  {

	// Set version of element
	public $wp_version;
	public $version_css;
	public $version_js;
	public $minimum_version_functions;
	public $minimum_PHP;
	public $minimum_WP;

	// Filename of log file.
	public $log_file;

	// Flag whether there should be logging.
	public $do_log;

	// Options of the plug-in
	public $options;
	public $options_devices_themes;

	// Set admin notices informations
	public $admin_notices_infos;

	public $in_mobile_theme;
	public $themes;
	public $themes_mblzr_support;

	//function WP_Mobilizer() {
	public function __construct() {
		global $wp_version;

		// Current WP version
		$this->wp_version 	= $wp_version;

		// Minimum requirements
		$this->minimum_PHP 	= '5.0';
		$this->minimum_WP 	= '3.5.0';

		// Version of assets files
		$this->version_css 	= '1.0.6';
		$this->version_js 	= '1.0.6';

		// Version of Functions Files
		$this->minimum_version_functions	= '1.0';

		// Set admin notices into array mode
		$this->admin_notices_infos 	= array();

		// Stop the plugin if we missed the requirements
		if ( !$this->required_version() || !$this->required_version_php() ){
			return;
		}

		// Check if we missed the requirements. Do not stop plugins for this, just alert user/admin
		if ( !$this->required_chmod() ){}

		// Run the uagent_info class
		$this->uagent_info();
		$this->in_mobile_theme = false;
		
		// Check User informations
		$this->get_user_info();

		// Set options
		$this->options_devices_themes = array(
			'mblzr_iphone_theme',
			'mblzr_ipad_theme',
			'mblzr_android_theme',
			'mblzr_android_tablet_theme',
			'mblzr_blackberry_theme',
			'mblzr_blackberry_tablet_theme',
			'mblzr_windowsmobile_theme',
			'mblzr_smartphone_theme',
			'mblzr_tablet_theme',

			'mblzr_googletv_tablet_theme',
			'mblzr_gameconsole_tablet_theme',
		);

		// Hook for init element
		add_action( 'init', 						array( &$this, 'init' 						), 5 );
		add_action( 'admin_init', 					array( &$this, 'admin_init' 				) );
		add_action( 'wp_head', 						array( &$this, 'wp_head'					) );
		add_action( 'wp_footer', 					array( &$this, 'wp_footer'					) );
		//add_action( 'widgets_init', 				array( &$this, 'widgets_init'				) );

		// Add the script and style files
		add_action('admin_enqueue_scripts', 		array(&$this, 'load_scripts'				) );
		add_action('admin_enqueue_scripts', 		array(&$this, 'load_styles'					) );
		add_action('wp_enqueue_scripts', 			array(&$this, 'load_styles_frontend'		) );

		// Add the admin menu
		add_action( 'admin_menu', 					array( &$this, 'admin_menu'					) );
		add_action( 'admin_bar_menu', 				array( &$this, 'admin_bar_menu'				), 99 );

		// Filters to change the template if require
		add_filter( 'stylesheet', 					array(&$this, 'get_stylesheet'				) );
		add_filter( 'template', 					array(&$this, 'get_template'				) );

		// Add Shortcode
		add_shortcode( 'mblzr_theme_switch_link', 	array(&$this, 'theme_switch_link'			) );


		// Add Dashboard Widget
		add_action( 'wp_dashboard_setup', 			array(&$this, 'dashboard_setup'				) );


		// Hook for options elements
		add_action( 'wp_ajax_mblzr_oembed_handler', array(&$this, 'oembed_ajax_results'				) );

	}


	/**
	 * Runs after WordPress has finished loading but before any headers are sent
	 */
	public function init() {
		// Load Language files
		if ( !defined( 'WP_PLUGIN_DIR' ) ) {
			load_plugin_textdomain( 'wp_mobilizer', str_replace( ABSPATH, '', dirname( __FILE__ ) ) );
		} else {
			load_plugin_textdomain('wp_mobilizer', false, MBLZR_PLUGIN_DIRNAME . '/languages/' );
		}

		// Set options
		$this->options = array(

			array(
				"label" 	=> __('Enabled side modules in theme settings','wp_mobilizer')."",
				"desc" 		=> __('by default, it is <b>NO</b>.','wp_mobilizer'),
				"id" 		=> "mblzr_enabled_side_module_themes_settings",
				"type" 		=> "on-off",
				"std"		=> "yes"
			),

			array(
				"label" 	=> __('Enabled log file','wp_mobilizer')."",
				"desc" 		=> __('by default, it is <b>NO</b>.','wp_mobilizer') . '<br />' . '<code>CHMOD 777 ' . MBLZR_PLUGIN_DIR . 'logs' . '</code>',
				"id" 		=> "mblzr_do_log",
				"type" 		=> "on-off",
				"std"		=> "no"
			),

			array(
				"label" 	=> __('Log file by date','wp_mobilizer')."",
				"desc" 		=> __('Separate each log file per date (YYYY/MM/DD)','wp_mobilizer'),
				"id" 		=> "mblzr_do_log_date",
				"type" 		=> "on-off",
				"std"		=> "yes"
			),

			array(
				"label" 	=> __('Show themes settings in "Appearance" submenu?','wp_mobilizer')."",
				"desc" 		=> __('Disabled the theme settings in "Appearance" submenu. Just view settings mode in WP-Mobilizer','wp_mobilizer'),
				"id" 		=> "mblzr_show_theme_in_appearance_submenu",
				"type" 		=> "on-off",
				"std"		=> "no"
			),

		);

		// Set cookie for template and retrive easy the current theme
		$this->set_theme_cookie();
	}

	/**
	 * admin_init is triggered before any other hook when a user access the admin area.
	 */
	public function admin_init() {
		
		// Register a setting and its sanitization callback.
		foreach( $this->options as $option ){
			if( isset($option['id']) ){
				register_setting('mblzr-settings', $option['id'] );
			}else{
				register_setting('mblzr-settings', $option );
			}
		}

		foreach( $this->options_devices_themes as $option ){
			if( isset($option['id']) ){
				register_setting('mblzr-settings', $option['id'] );
			}else{
				register_setting('mblzr-settings', $option );
			}
		}

	}

	/**
	 * Action hook is triggered within the <head></head> section of the user's template by the wp_head() function.
	 */
	public function wp_head() {
		if ( is_feed() ) {
			return;
		}

		global $wp_query;
		global $mblzr_options;

		//$post = $wp_query->get_queried_object();

		//$this->log("another plugin interfering?");

		echo "\n<!-- WP-Mobilizer " . MBLZR_VERSION . " by Kilukru Media (www.wp-mobilizer.com)";
			//echo "[" . time() . "] ";
		echo "-->\n";
		echo "<!-- /WP-Mobilizer -->\n";

	}

	/**
	 * Action hook is triggered at the end section of the user's template by the wp_footer() function.
	 */
	function wp_footer(){

		if( $this->in_mobile_theme === false && isset($_SESSION['mblzr_mobile_detected']) && $_SESSION['mblzr_mobile_detected'] === true && !defined('MBLZR_DISABLED_FRONTEND_FOOTER_LINK') ){
			echo '<a href="' . MBLZR_URL_FORCE_MOBILE . '" class="mblzr_force_mobile" title="' . __('Switch to mobile version of this site', 'wp_mobilizer') . '"><span>' . __('View mobile site', 'wp_mobilizer') . '</span></a>';
			echo "\n";
		}

	}

	/**
	 * Set the stylesheet for the current theme or selected theme
	 */
	public function get_stylesheet( $stylesheet = '' ) {
		$theme = $this->get_theme();

		if ( empty($theme) ) {
			return $stylesheet;
		}

		$theme = wp_get_theme($theme);

		// Don't let people peek at unpublished themes.
		if ( isset($theme['Status']) && $theme['Status'] != 'publish' ){
			return $stylesheet;
		}

		if (empty($theme)) {
			return $stylesheet;
		}

		return $theme['Stylesheet'];
	}

	/**
	 * Set the template for the current theme or selected theme
	 */
	public function get_template($template) {
		$theme = $this->get_theme();

		if (empty($theme)) {
			return $template;
		}

		$theme = wp_get_theme($theme);

		if ( empty( $theme ) ) {
			return $template;
		}

		// Don't let people peek at unpublished themes.
		if ( isset($theme['Status']) && $theme['Status'] != 'publish' ){
			return $template;
		}

		return $theme['Template'];
	}

	public function get_theme() {
		//Detect if is mobile device
		$this->detect_mobile_device();

		if ( isset($_SESSION['mblzr_force_site']) && $_SESSION['mblzr_force_site'] === true ){
			return '';
		}

		// Force mobile site
		$mblzr_smartphone_theme = get_option( 'mblzr_smartphone_theme' , '');
		if( !empty($mblzr_smartphone_theme) && isset($_SESSION['mblzr_force_mobile']) && $_SESSION['mblzr_force_mobile'] === true ){
			$this->set_in_mobile_theme();
			return $mblzr_smartphone_theme;
		}

		if ( !empty($_COOKIE["mblzr_theme" . COOKIEHASH] ) ) {
			return $_COOKIE["mblzr_theme" . COOKIEHASH];
		}else if ( ! empty($_SESSION["mblzr_theme"] ) ) {
			return $_SESSION["mblzr_theme"];
		}

		// Init var for each themes options
		if( isset($this->options_devices_themes) && is_array($this->options_devices_themes) ){
			foreach( $this->options_devices_themes as $option ){
				${$option} = get_option( $option , '');
			}
		}else{
			log( __('Please check "options_devices_themes" in WP-Mobilizer','wp_mobilizer') );
		}

		if( isset($mblzr_iphone_theme) && !empty($mblzr_iphone_theme) && $this->DetectIphoneOrIpod() ){
			$this->set_in_mobile_theme();
			return $mblzr_iphone_theme;
		}

		if( isset($mblzr_ipad_theme) && !empty($mblzr_ipad_theme) && $this->DetectIpad() ){
			$this->set_in_mobile_theme();
			return $mblzr_ipad_theme;
		}

		if( isset($mblzr_android_theme) && !empty($mblzr_android_theme) && $this->DetectAndroidPhone() ){
			$this->set_in_mobile_theme();
			return $mblzr_android_theme;
		}

		if( isset($mblzr_android_tablet_theme) && !empty($mblzr_android_tablet_theme) && $this->DetectAndroidTablet() ){
			$this->set_in_mobile_theme();
			return $mblzr_android_tablet_theme;
		}

		if( isset($mblzr_blackberry_theme) && !empty($mblzr_blackberry_theme) && ( $this->DetectBlackBerryTouch() || $this->DetectBlackBerryLow() ) ){
			$this->set_in_mobile_theme();
			return $mblzr_blackberry_theme;
		}

		if( isset($mblzr_blackberry_tablet_theme) && !empty($mblzr_blackberry_tablet_theme) && $this->DetectBlackBerryTablet() ){
			$this->set_in_mobile_theme();
			return $mblzr_blackberry_tablet_theme;
		}

		if( isset($mblzr_windowsmobile_theme) && !empty($mblzr_windowsmobile_theme) && $this->DetectWindowsMobile() ){
			$this->set_in_mobile_theme();
			return $mblzr_windowsmobile_theme;
		}

		if( isset($mblzr_smartphone_theme) && !empty($mblzr_smartphone_theme) && ( $this->DetectSmartphone() || $this->DetectTierIphone() ) ){
			$this->set_in_mobile_theme();
			return $mblzr_smartphone_theme;
		}

		if( isset($mblzr_tablet_theme) && !empty($mblzr_tablet_theme) && $this->DetectTierTablet() ){
			$this->set_in_mobile_theme();
			return $mblzr_tablet_theme;
		}

		if( isset($mblzr_googletv_tablet_theme) && !empty($mblzr_googletv_tablet_theme) && $this->DetectGoogleTV() ){
			$this->set_in_mobile_theme();
			return $mblzr_googletv_tablet_theme;
		}

		if( isset($mblzr_gameconsole_tablet_theme) && !empty($mblzr_gameconsole_tablet_theme) && $this->DetectGameConsole() ){
			$this->set_in_mobile_theme();
			return $mblzr_gameconsole_tablet_theme;
		}

		return '';
	}

	/**
	 * Set cookie to detect theme name
	 */
	public function set_theme_cookie() {
		$expire = time() + 30000000;
		$cookie_set = false;
		$cookie_data = '';

		if( isset($_GET["mblzr_theme"]) && !empty($_GET["mblzr_theme"]) ){
			$cookie_set = true;
			$cookie_data = stripslashes($_GET["mblzr_theme"]);

		}else if( isset($_GET["mblzr_force_theme"]) && !empty($_GET["mblzr_force_theme"]) ){
			$cookie_set = true;
			$cookie_data = stripslashes($_GET["mblzr_force_theme"]);

		}else if( ( isset($_GET["mblzr_force_site"]) /*&& !empty($_GET["mblzr_force_site"])*/ ) || ( isset($_GET["force_site"]) /*&& !empty($_GET["force_site"])*/ ) ){
			$cookie_set = true;
			$cookie_data = '';

		}else if( ( isset($_GET["mblzr_force_mobile"]) /*&& !empty($_GET["mblzr_force_mobile"])*/ ) || isset($_GET["force_mobile"]) /*&& !empty($_GET["force_mobile"])*/ ){
			$cookie_set = true;
			$cookie_data = '';

		}

		if ( $cookie_set === true ) {
			setcookie(
				"mblzr_theme" . COOKIEHASH,
				$cookie_data,
				$expire,
				COOKIEPATH
			);
			$redirect = remove_query_arg( array(
				'mblzr_theme',
				'mblzr_force_theme',
				'mblzr_force_site',
				'mblzr_force_mobile',
				'force_site',
				'force_mobile'
			));
			wp_redirect($redirect);
			exit;
		}
	}

	public function set_in_mobile_theme(){
		$this->in_mobile_theme = true;
	}

	public function detect_mobile_device( $force = true ){

		if(
			$this->DetectIphoneOrIpod() ||
			$this->DetectIpad() ||
			$this->DetectAndroidPhone() ||
			$this->DetectAndroidTablet() ||
			( $this->DetectBlackBerryTouch() || $this->DetectBlackBerryLow() ) ||
			$this->DetectBlackBerryTablet() ||
			$this->DetectWindowsMobile() ||
			( $this->DetectSmartphone() || $this->DetectTierIphone() ) ||
			$this->DetectTierTablet() ||
			$this->DetectGoogleTV() ||
			$this->DetectGameConsole()
			 ){

				$this->mobile_detected();

		}

	}

	/**
	 * Set variables when mobile device is detected
	 */
	public function mobile_detected( $data_insert = true ){

		if( $data_insert === false ){
			$_SESSION['mblzr_mobile_detected'] = false;
		}else{
			$_SESSION['mblzr_mobile_detected'] = true;
		}

	}

	/**
	 * Runs after WordPress has finished loading but before any headers are sent
	 */
	function dashboard_widget_function() {
		if( defined('MBLZR_DISABLED_DASHBOARD_WIDGET') ){
			return;
		}
		
		echo '<ul class="ul-disc">';
			echo '<li>Mobilizer1 - [<a href="http://www.wp-mobilizer.com" target="_blank">' . __('More info', 'wp_mobilizer') . '</a>] [<a href="http://www.wp-mobilizer.com" target="_blank">' . __('Download', 'wp_mobilizer') . '</a>] (Free) (installed)</li>';
			echo '<li>Mobilizer2 - [<a href="http://www.wp-mobilizer.com" target="_blank">' . __('Download', 'wp_mobilizer') . '</a>] (Free)</li>';
		echo '</ul>';
	}

	/**
	 * Runs after WordPress has finished loading but before any headers are sent
	 */
	function dashboard_setup() {
		if( defined('MBLZR_DISABLED_DASHBOARD_WIDGET') ){
			return;
		}
		
		wp_add_dashboard_widget('wp_dashboard_widget', __('Mobile themes', 'wp_mobilizer'), array(&$this, 'dashboard_widget_function') );
	}

	/**
	 * Add Shortcode for WP
	 */
	function theme_switch_link( $atts ){
		extract(shortcode_atts(array(
			  'type' 				=> 'url',
			  'label' 				=> '',
			  'title' 				=> '',

			  'url_before' 			=> '',
			  'url_after' 			=> '',
			  'class' 				=> '',
			  'data' 				=> '', // Add some data in link name (ex. : data-ajax="false" )

			  'link_before' 		=> '',
			  'link_after' 			=> '',

			  'force_url_site' 		=> '',
			  'force_url_mobile' 	=> ''
		 ), $atts));

		$url_link = MBLZR_URL_FORCE_MOBILE;
		if( $this->in_mobile_theme === true ){
			$url_link = MBLZR_URL_FORCE_SITE;
		}

		if( isset($force_url_site) && !empty($force_url_site)  ){
			$url_link = add_query_arg( MBLZR_URL_FORCE_SITE_QUERY, '1', 'http://' . $_SERVER['SERVER_NAME'] );
			$label = str_replace( 'http://', '', $url_link );
		}

		if( isset($force_url_mobile) && !empty($force_url_mobile) ){
			$url_link = add_query_arg( MBLZR_URL_FORCE_MOBILE_QUERY, '1', 'http://' . $_SERVER['SERVER_NAME'] );
			$label = str_replace( 'http://', '', $url_link );
		}

		switch( $type ){
			case 'link':

				return (
					$link_before .
					'<a ' .
					'href="' . $url_link . '"' .
					( $class && !empty($class) ? 'class="' . $class . '"' : '' ) .
					( $data && !empty($data) ? $data : '' ) .
					( $title && !empty($title) ? 'title="' . $title . '"' : '' ) .
					'>' .
					$url_before .
					( $label && !empty($label) ? $label : $url_link ) .
					$url_after .
					'</a>' .
					$link_after
				);
				break;

			case 'url':
			default:

				return $url_link;

				break;

		}

		 return "";
	}

	/**
	 * Temporary inactive
	 */
	function widgets_init()
	{
		//register_widget('MBLZR_Widget');
	}

	/**
	 * This action is used to add extra submenus and menu options to the admin panel's menu structure.
	 */
	function admin_menu() {

		// Create Init menu
		add_menu_page( __('WP-Mobilizer', 'wp_mobilizer'), __('WP-Mobilizer', 'wp_mobilizer'), 'manage_options', MBLZR_PLUGIN_DIRNAME, array (&$this, 'show_menu'), path_join(MBLZR_PLUGIN_IMAGES_URL, 'icons/16x16.png') );

		// Setup the sub menu
		add_submenu_page( MBLZR_PLUGIN_DIRNAME , __('Overview', 'wp_mobilizer'), __('Overview', 'wp_mobilizer'), 'manage_options', MBLZR_PLUGIN_DIRNAME, array (&$this, 'show_menu'));

		// If you want to desactivate menu options for some admin
		if( !defined('MBLZR_DISABLED_SUBMENU_PAGES') ){
			add_submenu_page( MBLZR_PLUGIN_DIRNAME , __('Options', 'wp_mobilizer'), __('Options', 'wp_mobilizer'), 'manage_options', MBLZR_PLUGIN_DIRNAME . '-options', array (&$this, 'show_menu'));
		}

		// Get themes
		$themes_mblzr_support = array();
		$themes = wp_get_themes( array('errors' => false , 'allowed' => null, 'blog_id' => 0) );
		$themes_test = array();
		if( $themes && is_array($themes) && count($themes) > 0 ){
			$this->themes = $themes;

			foreach( $themes as $theme_slug => $theme){

				$theme_tags = $theme->display( 'Tags', FALSE );
				if( $theme_tags && is_array($theme_tags) && count($theme_tags) > 0 && (
					array_search('WP-Mobilizer-Ready', 	$theme_tags) !== false ||
					array_search('WP-Mobilizer-ready', 	$theme_tags) !== false ||
					array_search('WP-MOBILIZER-READY', 	$theme_tags) !== false ||
					array_search('wp-mobilizer-ready', 	$theme_tags) !== false ||
					array_search('wpmobilizerready', 	$theme_tags) !== false ||
					array_search('WPMobilizerReady', 	$theme_tags) !== false ||
					array_search('WPMOBILIZERREADY', 	$theme_tags) !== false
				)){

					if( isset($themes_test[$theme_slug]) ){
						$this->admin_notices( sprintf(__('Sorry, your theme name "%s" already exist.', "wp_mobilizer" ), $theme->display( 'Name', FALSE ) ), true );
					}
					$themes_test[$theme_slug] = $theme;

					// Load settings file
					$theme_options_file = WP_CONTENT_DIR . '/themes/' . $theme_slug . '/backoffice/theme_settings.php';
					if( file_exists($theme_options_file) ){
						include_once( $theme_options_file );

						// Add custom functions/hook/filter for your own fields type
						$theme_options_custom_file = WP_CONTENT_DIR . '/themes/' . $theme_slug . '/backoffice/theme_custom.php';
						if( file_exists($theme_options_custom_file) ){
							include_once( $theme_options_custom_file );
						}

						//if( function_exists($theme_slug . '_admin') ){ // Remove for now
						if( isset($GLOBALS['themes_infos'][$theme_slug]) ){

							$themes_mblzr_support[$theme_slug] = array(
								'slug'				=> $theme_slug,
								'page_title'		=> $theme->display( 'Name', false ),
								'menu_title'		=> $theme->display( 'Name', false ),
								'menu_slug'			=> MBLZR_PLUGIN_DIRNAME . '-theme-' . $theme_slug,
								//'function'			=> $theme_slug . '_admin'
								'function'			=> 'wp_mobilizer_theme_admin'
							);

							if( isset($GLOBALS['themes_infos'][$theme_slug]) ){

								$theme_mblzr_compatibility = true;
								if( !is_array($GLOBALS['themes_infos'][$theme_slug]['wp-mobilizer-compatibility'][0]) ){
									$mblzr_ok  =  version_compare(MBLZR_VERSION, $GLOBALS['themes_infos'][$theme_slug]['wp-mobilizer-compatibility'][0], $GLOBALS['themes_infos'][$theme_slug]['wp-mobilizer-compatibility'][1]);
									if ( ($mblzr_ok == false) ) {
										$theme_mblzr_compatibility = false;

										// Log compatibility
										$this->log('mblzr_compatibility : mblzr [v'. MBLZR_VERSION .'] not compatible with theme [' . $theme_slug . '][v'. $GLOBALS['themes_infos'][$theme_slug]['wp-mobilizer-compatibility'][0] .'] (' . MBLZR_VERSION . ' ' . $GLOBALS['themes_infos'][$theme_slug]['wp-mobilizer-compatibility'][1] . ' ' . $GLOBALS['themes_infos'][$theme_slug]['wp-mobilizer-compatibility'][0] . ') ');
									}
								}else{
									foreach( $GLOBALS['themes_infos'][$theme_slug]['wp-mobilizer-compatibility'] as $compatibility ){

										$mblzr_ok  =  version_compare(MBLZR_VERSION, $compatibility[0], $compatibility[1]);
										if ( ($mblzr_ok == false) ) {
											$theme_mblzr_compatibility = false;

											// Log compatibility
											$this->log('mblzr_compatibility : mblzr [v'. MBLZR_VERSION .'] not compatible with theme [' . $theme_slug . '][v'. $compatibility[0] .'] (' . MBLZR_VERSION . ' ' . $compatibility[1] . ' ' . $compatibility[0] . ') ');
										}

									}
								}

								if( $theme_mblzr_compatibility == false ){
									$this->admin_notices( sprintf(__('Sorry, your theme "%s" doesn\'t works with this version of WP-Mobilizer', "wp_mobilizer" ), $theme->display( 'Name', FALSE ) ), true );
								}

							}

						}else{
							$this->admin_notices( sprintf(__('They couldn\'t view theme settings of "%s", because the function "%s" doesn\'t exist in the file "%s" .', "wp_mobilizer" ), $theme->display( 'Name', false ), $theme_slug . '_admin', $theme_options_file ), true );
						}

					}else{
						$this->admin_notices( sprintf(__('They couldn\'t view theme settings of "%s", because the file "%s" doesn\'t exist.', "wp_mobilizer" ), $theme->display( 'Name', FALSE ), $theme_options_file ), true );
					}

				}

			}
		}

		// Init global vars
		$this->themes_mblzr_support = $themes_mblzr_support;

		// Load compatible theme with WP-Mobilizer
		if( is_array($themes_mblzr_support) && count($themes_mblzr_support) > 0 ){
			
			//Add Separator
			add_submenu_page( MBLZR_PLUGIN_DIRNAME , '', '</a><em></em><span class="span_separator">' . _n('Theme settings','Themes settings', count($themes_mblzr_support),'wp_mobilizer') . '</span><a>', 'manage_options', MBLZR_PLUGIN_DIRNAME . '-separator', array (&$this, 'show_menu'));
			
			foreach( $themes_mblzr_support as $theme_slug => $theme ){
				//add_submenu_page( MBLZR_PLUGIN_DIRNAME , $theme['page_title'], $theme['menu_title'], 'manage_options', $theme['menu_slug'], $theme['function']);
				add_submenu_page( MBLZR_PLUGIN_DIRNAME , $theme['page_title'], $theme['menu_title'], 'manage_options', $theme['menu_slug'], array (&$this, 'show_theme_settings'));
			}

			//Add Separator
			add_submenu_page( MBLZR_PLUGIN_DIRNAME , '', '</a><em></em><span class="span_separator empty"></span><a>', 'manage_options', MBLZR_PLUGIN_DIRNAME . '-separator', array (&$this, 'show_menu'));
		
		}


	}

	/**
	 * Add a Separator to the Admin Menu
	 * To see menu position run $this->dump_admin_menu();
	 *
	 * @param int 	$position The position inside the menu
	 */
	function add_admin_menu_separator($position) {
		global $menu;
		$index = 0;

		foreach($menu as $offset => $section) {
			if ( substr($section[2],0,9) == 'separator' ){
				$index++;
			}
			if ( $offset>=$position ) {
				$menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
				break;
			}
		}
		ksort( $menu );
	}

	/**
	 * Add navigation on admin Toolbar
	 */
	function admin_bar_menu() {
		// If the current user can't manage options, this is all of no use, so let's not output an admin menu
		if ( !current_user_can('manage_options') )
			return;

		global $wp_admin_bar;

		//$wp_admin_bar->add_menu( array( 'id' => 'mblzr-menu', 'title' => __( 'WP-Mobilizer', 'wp_mobilizer' ), 'href' => admin_url('admin.php?page='. MBLZR_PLUGIN_DIRNAME ) ) );
		//$wp_admin_bar->add_menu( array( 'parent' => 'mblzr-menu', 'id' => 'mblzr-menu-overview', 'title' => __('Overview', 'wp_mobilizer'), 'href' => admin_url('admin.php?page='. MBLZR_PLUGIN_DIRNAME ) ) );


	}

	function show_theme_settings() {

		// Void error with blank $_GET
		if( !isset($_GET['page']) ){
			$_GET['page'] = MBLZR_PLUGIN_DIRNAME;
		}

		if( isset($this->themes_mblzr_support) && is_array($this->themes_mblzr_support) ){

			foreach( $this->themes_mblzr_support as $theme_slug => $theme ){

				if( $_GET['page'] == 'wp-mobilizer-theme-' . $theme_slug ){
					$theme_functions_file = WP_CONTENT_DIR . '/themes/' . $theme_slug . '/backoffice/theme_functions.php';
					if( file_exists($theme_functions_file) ){
						include_once ( $theme_functions_file );

						if( get_option('mblzr_enabled_side_module_themes_settings', 'yes') == 'yes' ){
							wp_mobilizer_theme_admin( $this->side_modules() );
						}else{
							wp_mobilizer_theme_admin();
						}

					}
					break;

				}

			}

		}

	}

	// load the script for the defined page and load only this code
	function show_menu() {
		$saved = false;

		if ( isset($_REQUEST['action']) && $_REQUEST['action'] == 'save-options' ) {
			$this->log("save-options");
			//foreach ($this->options as $value) {
			//	update_option( $value['id'], $_REQUEST[ $value['id'] ] );
			//}

			foreach ( $this->options as $value ) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) {
					update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
				} else {
					delete_option( $value['id'] );
				}
			}

			foreach ( $this->options_devices_themes as $id ) {
				if( isset( $_REQUEST[ $id ] ) ) {
					update_option( $id, $_REQUEST[ $id ]  );
				} else {
					delete_option( $id );
				}
			}



			//header("Location: admin.php?page=" . MBLZR_PLUGIN_DIRNAME . "-options&saved=true");
			//die;
			$this->log("saved");
			$saved = true;
		}

		// Get current options
		//$options = array();
		//foreach( $this->options as $option ){
		//	$options[ $option['id'] ] = get_option( $option['id'] , $option['std']);
		//}

		//$options_devices_themes = array();
		//foreach( $this->options_devices_themes as $id ){
		//	$options_devices_themes[ $id ] = get_option( $id , '' );
		//}

		// Void error with blank $_GET
		if( !isset($_GET['page']) ){
			$_GET['page'] = MBLZR_PLUGIN_DIRNAME;
		}

		switch ( $_GET['page'] ){
			case "wp-mobilizer-options" :
				include_once ( dirname (__FILE__) . '/pages/options.php' );		// wp-mobilizer_admin_options
				break;

			case "wp-mobilizer" :
			default :
				$this->page_overview();
				break;
		}

	}

	function page_overview(){

		$options = array();
		$options['mblzr_do_log'] 		= get_option('mblzr_do_log');


		$iphoneTheme = '';

		$themeList 		= wp_get_themes();
		$themeNames 	= array_keys($themeList);
		$defaultTheme 	= wp_get_theme();
		natcasesort($themeNames);

?>

<div class="wrap mblzr_wrap">
<h2><?php echo __('WP-Mobilizer', 'wp_mobilizer'); ?> - <?php echo __('Mobile Theme Switcher', 'wp_mobilizer'); ?></h2>

<div class="metabox-holder">
<table width="100%">
	<tr>
		<td valign="top">

		<?php

			$module_html = '';
			
			if( $this->is_admin() && !defined('MBLZR_HIDE_ADMIN_CONTENT') ){
			
				$module_html .= '<p>Use the following shortcode to show the theme switch link.';
				$module_html .= '<br /><code>[mblzr_theme_switch_link]</code></p>';

				$module_html .= '<p>Or use the following shortcode in templates themes to show the theme switch link.';
				$module_html .= '<br /><code>&lt;?php echo do_shortcode(\'[mblzr_theme_switch_link]\'); ?&gt;</code></p>';

				$module_html .= '<p>Or use the following PHP Constants in yours theme.';
				$module_html .= '<br /><code>&lt;?php echo MBLZR_URL_FORCE_SITE; ?&gt;</code>';
				$module_html .= '<br /><code>&lt;?php echo MBLZR_URL_FORCE_MOBILE; ?&gt;</code></p>';

				$module_html .= '<p>&nbsp;</p>';
			
			}

			$module_html .= '<p>You can also add Switch Mobile Theme link to your Menus from Custom Links section under Appearance > Menus.</p>';



			$force_url_site = add_query_arg( MBLZR_URL_FORCE_SITE_QUERY, '1', 'http://' . $_SERVER['SERVER_NAME'] );
			$force_url_site_label = str_replace( 'http://', '', $force_url_site );

			$force_url_mobile = add_query_arg( MBLZR_URL_FORCE_MOBILE_QUERY, '1', 'http://' . $_SERVER['SERVER_NAME'] );
			$force_url_mobile_label = str_replace( 'http://', '', $force_url_mobile );

			$module_html .= '<ul class="ul-disc">';
				$module_html .= '<li><strong><a target="_blank" href="' . $force_url_site . '">' . $force_url_site_label . '</a></strong> (Force Desktop / Default Theme)</li>';
				$module_html .= '<li><strong><a target="_blank" href="' . $force_url_mobile . '">' . $force_url_mobile_label . '</a></strong>  (Force Mobile Theme)</li>';
			$module_html .= '</ul>';

			echo $this->module_html( __('How to use', 'wp_mobilizer'), $module_html );

		?>

		<?php
		
			if( $this->is_admin() && !defined('MBLZR_HIDE_ADMIN_CONTENT') ){
			
				// Set images
				//$img_yes = '<img src="' . esc_url( MBLZR_PLUGIN_IMAGES_URL . 'admin/yes.png' ) . '" alt="" />';
				$img_yes = '<span class="txt_yes">&#10004;</span>'; //&check; &checkmark;
				//$img_no = '<img src="' . esc_url( MBLZR_PLUGIN_IMAGES_URL . 'admin/no.png' ) . '" alt="" />';
				$img_no = '<span class="txt_no">&#10007;</span>'; //&cross;

				$module_html = '';

				if( $this->themes && is_array($this->themes) && count($this->themes) > 0 ){
					$module_html .= '<table class="table_listing">';
					foreach( $this->themes as $theme_slug => $theme){

						$img = $img_no;
						if( isset($this->themes_mblzr_support) && is_array($this->themes_mblzr_support) && isset($this->themes_mblzr_support[$theme_slug]) ){
							$img = $img_yes;
						}

						$module_html .= '
							<tr valign="top">
								<th scope="row">' . $theme->display( 'Name', FALSE ) . ' &nbsp; <code>[' . $theme_slug . ']</code></th>
								<td>' . $img . '</td>
							</tr>
						';
					}

					$module_html .= '
						</table>
						<br />
					';
				}else{
					$module_html .= mblzr_show_essage(__('Sorry, no theme found.', 'wp_mobilizer'), true);
				}

				echo $this->module_html( __('Themes compatibility with WP-Mobilizer', 'wp_mobilizer'), $module_html );
				echo '<br />';
			
			}

		?>

		

		<?php



			$module_html = '';

			$module_html .= '
				<table class="form-table">
					<tr valign="top">
						<th scope="row">' . __('Version : ', 'wp_mobilizer') . '</th>
						<td>' . MBLZR_VERSION . '</td>
					</tr>
					<tr valign="top">
						<th scope="row">' . __('Numeric version : ', 'wp_mobilizer') . '</th>
						<td>' . MBLZR_VERSION_NUMERIC . '</td>
					</tr>
					<tr valign="top">
						<th scope="row">' . __('Minimum Functions file version : ', 'wp_mobilizer') . '</th>
						<td>' . $this->minimum_version_functions . '</td>
					</tr>
					<!--<tr valign="top">
						<th scope="row">' . __('CSS : ', 'wp_mobilizer') . '</th>
						<td>' . $this->version_css . '</td>
					</tr>
					<tr valign="top">
						<th scope="row">' . __('JS : ', 'wp_mobilizer') . '</th>
						<td>' . $this->version_js . '</td>
					</tr>-->
				</table>
				<br />
			';

			echo $this->module_html( __('Plugin Informations', 'wp_mobilizer'), $module_html, true );

		?>

		</td>
		<td width="15">&nbsp;</td>
		<td width="250" valign="top">
			<?php echo $this->side_modules(); ?>
		</td>
	</tr>
</table>


</div></div>
<?php
	}


	/**
	 * HTML for the side modules
	 */
	function side_modules (){
		$html = '';

		// Module
		$module_support = '';
		//$module_support .= '' . sprintf(__('If you have any issues, %svisit our support forum%s.', 'wp_mobilizer'), '<a href="http://www.wp-mobilizer.com" target="_blank">','</a>' );
		$module_support .= '' . sprintf(__('If you have any issues, %svisit our website%s and go on support page.', 'wp_mobilizer'), '<a href="http://www.wp-mobilizer.com?ref=plugin_wpmblzr_' . MBLZR_VERSION_NUMERIC . '" target="_blank">','</a>' );
		$html .= $this->module_html( __('Support', 'wp_mobilizer'), $module_support );


		// Module
		$module_links = '';
		$module_links .= '<ul>';
			$module_links .= '<li><a href="http://www.kilukrumedia.com/?ref=plugin_wpmblzr_' . MBLZR_VERSION_NUMERIC . '" target="_blank">Kilukru Media</a></li>';
		$module_links .= '</ul>';
		$html .= $this->module_html( __('Links', 'wp_mobilizer'), $module_links );


		// Module
		$html .= $this->module_html( __('Facebook', 'wp_mobilizer'), '<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fkilukrumedia&amp;width=185&amp;height=258&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border=false&amp;border_color=%23fff&amp;header=false&amp;appId=215419415167468" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:235px; height:258px;" allowTransparency="true"></iframe>' );

		// Module
		$module_infos_url = '//www.wp-mobilizer.com/ads/';
		switch( $_SERVER["SERVER_NAME"] ){
			case 'wp-mobilizer.local':
			case 'wp-mobilizer.dev':
			case 'wp-mobilizer.demo':
				$module_infos_url = '//wp-mobilizer.local/ads/';
				break;

			case 'wp-mobilizer.klklabs.com':
				$module_infos_url = '//wp-mobilizer.klklabs.com/ads/';
				break;

		}

		$module_infos_url .= '?ref=plugin_wpmblzr_' . MBLZR_VERSION_NUMERIC;

		$html .= $this->module_html( __('Informations', 'wp_mobilizer'), '<iframe src="' . $module_infos_url . '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:235px; height:200px;" allowTransparency="true"></iframe>' );


		// Return HTML
		return $html;
	}


	/**
	 * HTML block eache block for side module
	 */
	function module_html( $title, $content = '', $toggle = false ){
		$html = '';

		if( $toggle == true ){

			$html .= '<div class="postbox">';
				$html .= '<div class="handlediv" title="Click to toggle"><br /></div><h3 class="hndle"><span>' . $title . '</span></h3>';
				$html .= '<div class="inside">';
					$html .= '' . $content . '';
					$html .= '<div class="clear"></div>';
				$html .= '</div>';
			$html .= '</div>';
			$html .= '<br/>';

		}else{

			$html .= '<table class="wp-list-table widefat fixed bookmarks">';
				$html .= '<thead>';
					$html .= '<tr>';
						$html .= '<th>';
						$html .= '' . $title . '';
						$html .= '</th>';
					$html .= '</tr>';
				$html .= '</thead>';
				$html .= '<tbody>';
					$html .= '<tr>';
						$html .= '<td>';
						$html .= '' . $content . '';
						$html .= '</td>';
					$html .= '</tr>';
				$html .= '</tbody>';
			$html .= '</table>';
			$html .= '<br/>';

		}

		return $html;
	}


	/**
	 * Function to show theme settings
	 */
	function show_theme_admin_options( $themename = '' ){

		if( empty($themename) ){
			echo mblzr_show_essage( __('Sorry, you need to give a $themename for "admin_options".', "wp_mobilizer" ), true );
			return false;
		}

		?>

		<div class="wrap mblzr_wrap"><form method="post" style="margin:0;padding:0;">
			<h2><?php echo $GLOBALS['themes_infos'][$themename]['title_setting_page']; ?></h2>

			<div class="metabox-holder">
				<table width="100%">
					<tr>
						<td valign="top"><?php


							foreach ($GLOBALS['themes_options'][$themename] as $value) {
								if( ( isset($value['delete']) && $value['delete'] == true ) || isset($value['delete_option']) && $value['delete_option'] == true ){
									continue;
								}
								mblzr_display_form_elements( $value, $themename );
							}


						?></td><?php

							if( get_option('mblzr_enabled_side_module_themes_settings', 'yes') == 'yes' ){
								?><td width="15">&nbsp;</td>
								  <td width="250" valign="top">
									<?php echo $this->side_modules(); ?>
								  </td><?php
							}
					?></tr>
				</table>
			</div>
		</form></div>

		<?php /*
		<form method="post">
		<p class="submit">
		<input name="reset" type="submit" value="<?php echo __('Reset','mobilizer1'); ?>" />
		<input type="hidden" name="action" value="reset" />
		</p>
		</form> */ ?>

		<script type="text/javascript">// <![CDATA[
		(function($) {
			$(document).ready( function(){

			});
		})(jQuery);
		// ]]>
		</script>

		<?php

	}


	/**
	 * Save Themes Options
	 */
	function theme_save_options($themename, $redirect = true, $_file_){

		if( !isset($GLOBALS['themes_options'][$themename]) ){
			echo mblzr_show_essage( sprintf(__('Sorry, your $themename value "%s" doesn\'t exist in %s.', "wp_mobilizer" ), $themename, '$GLOBALS[\'themes_options\']'), true );
			return false;
		}

		if( isset($_REQUEST['action']) && $_REQUEST['action'] == 'save' ) {

			/*foreach ($GLOBALS['themes_options'][$themename] as $value) {
				if( !isset($value['id']) || empty($value['id']) ){
					continue;
				}
				update_option( $value['id'], $_REQUEST[ $value['id'] ] );
			}*/

			foreach ($GLOBALS['themes_options'][$themename] as $field) {
				if( !isset($field['id']) || empty($field['id']) ){
					continue;
				}

				if( isset($field['id']) && ( $field['delete'] == true || $field['delete_field'] == true ) ){
					delete_option( $field['id'] );
					continue;
				}

				/*if ( ! isset( $field['multiple'] ) ){
					$field['multiple'] = ( 'multicheck' == $field['type'] ) ? true : false;
				}*/

				$old = get_option( $field['id'], ( isset($field['std']) ? $field['std'] : null ) );
				$new = isset( $_REQUEST[$field['id']] ) ? $_REQUEST[$field['id']] : null;

				// I could set taximony for moment ... I don't have $element_id
				//if ( in_array( $field['type'], array( 'taxonomy_select', 'taxonomy_radio', 'taxonomy_multicheck' ) ) )  {
				//	$new = wp_set_object_terms( $element_id, $new, $field['taxonomy'] );
				//}

				if ( ($field['type'] == 'textarea') || ($field['type'] == 'textarea_small') ) {
					$new = htmlspecialchars( $new );
				}

				if ( ($field['type'] == 'textarea_code') ) {
					$new = htmlspecialchars_decode( $new );
				}

				if ( $field['type'] == 'text_date_timestamp' ) {
					$new = strtotime( $new );
				}

				if ( $field['type'] == 'text_datetime_timestamp' ) {
					$string = $new['date'] . ' ' . $new['time'];
					$new = strtotime( $string );
				}

				if( has_filter( 'mblzr_validate_' . $field['type'] ) ){
					$new = apply_filters('mblzr_validate_' . $field['type'], $new, $field);
				}

				/*
				// validate value
				if ( isset( $field['validate_func']) ) {
					$ok = call_user_func( array( 'mblzr_Meta_Box_Validate', $field['validate_func']), $new );
					if ( $ok === false ) { // pass away when meta value is invalid
						continue;
					}
				} elseif ( $field['multiple'] ) {
					delete_post_meta( $post_id, $name );
					if ( !empty( $new ) ) {
						foreach ( $new as $add_new ) {
							add_post_meta( $post_id, $name, $add_new, false );
						}
					}
				} elseif ( '' !== $new && $new != $old  ) {
					update_post_meta( $post_id, $name, $new );
				} elseif ( '' == $new ) {
					delete_post_meta( $post_id, $name );
				}
				*/

				if( isset( $_REQUEST[ $field['id'] ] ) ) {
					update_option( $field['id'], $new );
				} else {
					delete_option( $field['id'] );
				}

			}

			if( $redirect === true ){
				header("Location: themes.php?page=" . basename($_file_) . "&saved=true");
				die;
			}else{
				$_REQUEST['saved'] = 'true';
				$_GET['saved'] = 'true';
			}
		} else if( isset($_REQUEST['action']) && $_REQUEST['action'] == 'reset' ) {
			foreach ($GLOBALS['themes_options'][$themename] as $field) {
				if( !isset($field['id']) || empty($field['id']) ){
					continue;
				}
				delete_option( $field['id'] );
			}

			if( $redirect === true ){
				header("Location: themes.php?page=" . basename($_file_) . "&reset=true");
				die;
			}else{
				$_REQUEST['reset'] = 'true';
				$_GET['reset'] = 'true';
			}
		}

	}


	/**
	 * Handles our oEmbed ajax request
	 */
	function oembed_ajax_results() {
		global $wp_embed;

		// verify our nonce
		if ( ! ( isset( $_REQUEST['mblzr_ajax_nonce'], $_REQUEST['oembed_url'] ) && wp_verify_nonce( $_REQUEST['mblzr_ajax_nonce'], 'ajax_nonce' ) ) )
			die();

		// sanitize our search string
		$oembed_string = sanitize_text_field( $_REQUEST['oembed_url'] );

		if ( empty( $oembed_string ) ) {
			$return = '<p class="ui-state-error-text">'. __( 'Please Try Again', 'wp_mobilizer' ) .'</p>';
			$found = 'not found';
		} else {
			$oembed_url = esc_url( $oembed_string );
			// Post ID is needed to check for embeds
			//if ( isset( $_REQUEST['post_id'] ) )
			//	$GLOBALS['post'] = get_post( $_REQUEST['post_id'] );
			// ping WordPress for an embed
			$check_embed = $wp_embed->run_shortcode( '[embed]'. $oembed_url .'[/embed]' );
			// fallback that WordPress creates when no oEmbed was found
			$fallback = $wp_embed->maybe_make_link( $oembed_url );

			if ( $check_embed && $check_embed != $fallback ) {
				// Embed data
				$return = '<div class="embed_status">'. $check_embed .'<a href="#" class="mblzr_remove_file_button" rel="'. $_REQUEST['field_id'] .'">'. __( 'Remove Embed', 'wp_mobilizer' ) .'</a></div>';
				// set our response id
				$found = 'found';

			} else {
				// error info when no oEmbeds were found
				$return = '<p class="ui-state-error-text">'.sprintf( __( 'No oEmbed Results Found for %s. View more info at', 'wp_mobilizer' ), $fallback ) .' <a href="http://codex.wordpress.org/Embeds" target="_blank">codex.wordpress.org/Embeds</a>.</p>';
				// set our response id
				$found = 'not found';
			}
		}

		// send back our encoded data
		echo json_encode( array( 'result' => $return, 'id' => $found ) );
		die();
	}


	/**
	 * Load JavaScripts
	 */
	function load_scripts() {
		// Check if they are in admin
		if( is_admin() ){
			// Set the common scripts
			wp_register_script('mblzr_admin_htmlhead_common', path_join(
				MBLZR_PLUGIN_JS_URL,
				'admin/htmlhead_common' . ( $this->get_filetime_forfile() ) . '.js'
			), array('jquery'), $this->get_version_number($this->version_js) );
			wp_enqueue_script( 'mblzr_admin_htmlhead_common' );

			// Commin WP Admin Load scripts
			//wp_enqueue_script('postbox');
			//wp_enqueue_script('page');

		}

		// no need to go on if it's not a plugin page
		if( !isset($_GET['page']) )
			return;

		// If we're on a NextGen Page
		if ( preg_match("/mblzr|wp_mobilizer|wp-mobilizer/", $_GET['page']) ) {

			$mblzr_script_array = array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'media-upload', 'thickbox' );
			// if we're 3.5 or later, user wp-color-picker
			if ( version_compare(3.5, $this->wp_version, '<=') !== false ) {
				$mblzr_script_array[] = 'wp-color-picker';
			} else {
				// otherwise use the older 'farbtastic'
				$mblzr_script_array[] = 'farbtastic';
			}

			// Global enqueue elements
			wp_enqueue_script( 'thickbox' );
			//wp_enqueue_script( $mblzr_script_array );

			wp_register_script( 'mblzr-timepicker', path_join(
				MBLZR_PLUGIN_JS_URL,
				'admin/jquery.timePicker.min' . ( $this->get_filetime_forfile() ) . '.js'
			), array('jquery'), $this->get_version_number($this->version_js) );
			wp_enqueue_script( 'mblzr-timepicker' );


			// JS for Common plugin page
			wp_register_script('mblzr_admin_htmlhead', path_join(
				MBLZR_PLUGIN_JS_URL,
				'admin/htmlhead' . ( $this->get_filetime_forfile() ) . '.js'
			), array('jquery'), $this->get_version_number($this->version_js) );
			wp_enqueue_script('mblzr_admin_htmlhead');
			

			// JS for Options page
			wp_register_script('mblzr_admin_options', path_join(
				MBLZR_PLUGIN_JS_URL,
				'admin/htmlhead_options' . ( $this->get_filetime_forfile() ) . '.js'
			), $mblzr_script_array, $this->get_version_number($this->version_js) );
			//wp_localize_script( 'mblzr_admin_options', 'mblzr_ajax_data', array( 'ajax_nonce' => wp_create_nonce( 'ajax_nonce' ), 'post_id' => get_the_ID() ) );
			wp_localize_script( 'mblzr_admin_options', 'mblzr_ajax_data', array( 'ajax_nonce' => wp_create_nonce( 'ajax_nonce' ) ) );
			wp_enqueue_script( 'mblzr_admin_options' );




			/*switch ($_GET['page']) {
				case "wp-mobilizer-options" :
					wp_enqueue_script( 'mblzr_admin_options' );
				break;

				case MBLZR_PLUGIN_DIRNAME :
					//wp_enqueue_style( 'thickbox' );
					break;
			}*/
		}

	}

	/**
	 * Load CSS styles
	 */
	function load_styles() {
		// Check if they are in admin
		if( is_admin() ){
			// Set the common style
			wp_register_style( 'mblzr_admin_common', MBLZR_PLUGIN_CSS_URL .'admin/styles_common' . ( $this->get_filetime_forfile() ) . '.css', false, $this->get_version_number($this->version_css), 'screen' );
			wp_enqueue_style( 'mblzr_admin_common' );
		}

		// no need to go on if it's not a plugin page
		if( !isset($_GET['page']) )
			return;

		// If we're on a WP-Mobilizer Page
		if ( preg_match("/mblzr|wp_mobilizer|wp-mobilizer/", $_GET['page']) ) {

			$mblzr_style_array = array( 'thickbox' );
			// if we're 3.5 or later, user wp-color-picker
			if ( version_compare(3.5, $this->wp_version, '<=') !== false ) {
				$mblzr_style_array[] = 'wp-color-picker';
			} else {
				// otherwise use the older 'farbtastic'
				$mblzr_style_array[] = 'farbtastic';
			}

			// Global enqueue elements
			wp_enqueue_style( 'thickbox' );

			// load the admin styles
			wp_register_style( 'mblzr_admin', MBLZR_PLUGIN_CSS_URL . 'admin/styles' . ( $this->get_filetime_forfile() ) . '.css', false, $this->get_version_number($this->version_css), 'screen' );
			wp_enqueue_style( 'mblzr_admin' );

			// load the admin options styles
			wp_register_style( 'mblzr_admin_options', MBLZR_PLUGIN_CSS_URL . 'admin/styles_options' . ( $this->get_filetime_forfile() ) . '.css', $mblzr_style_array, $this->get_version_number($this->version_css), 'screen' );
			wp_enqueue_style( 'mblzr_admin_options' );

			/*switch ($_GET['page']) {
				case "wp-mobilizer-options" :
					wp_enqueue_style( 'mblzr_admin_options' );
				break;

				case MBLZR_PLUGIN_DIRNAME :
					//wp_enqueue_style( 'thickbox' );
					break;
			}*/
		}

	}

	/**
	 * Load CSS styles on Frontend
	 */
	function load_styles_frontend() {
		// Check if they not are in admin
		if( !defined('MBLZR_DISABLED_FRONTEND_CSS') && !is_admin() ){
			// Set the common style
			wp_register_style( 'mblzr_common', MBLZR_PLUGIN_CSS_URL . 'styles' . ( $this->get_filetime_forfile() ) . '.css', false, $this->get_version_number($this->version_css), 'screen' );
			wp_enqueue_style( 'mblzr_common' );
			//mblzr_force_mobile
		}

	}

	/**
	 * Check if the version of WP is compatible with this plugins minimum requirment.
	 */
	function required_version() {
		global $wp_version;

		// Check for WP version installation
		$wp_ok  =  version_compare($wp_version, $this->minimum_WP, '>=');

		if ( ($wp_ok == FALSE) ) {
			$this->admin_notices( sprintf(__('Sorry, WP-Mobilizer works only under WordPress %s or higher', "wp_mobilizer" ), $this->minimum_WP ), true );
			return false;
		}

		return true;

	}

	/**
	 * Check if the version of PHP of this server is compatible with this plugins minimum requirment.
	 */
	function required_version_php() {
		global $wp_version;

		// Check for PHP version installation
		$wp_ok  =  version_compare(PHP_VERSION, $this->minimum_PHP, '>=');

		if ( ($wp_ok == FALSE) ) {
			$this->admin_notices( sprintf(__('Sorry, WP-Mobilizer works only under PHP %s or higher', "wp_mobilizer" ), $this->minimum_PHP ), true );

			return false;
		}

		return true;

	}

	/**
	 * Check CHMOD for some directory
	 */
	function required_chmod() {

		// Run log if setting is correct
		if ( get_option('mblzr_do_log', '') == 'yes' ) {
			$this->do_log = true;
		} else {
			$this->do_log = false;
		}

		if( $this->do_log == true ){
			$log_directory = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . '';

			$log_directory_perms = substr(sprintf('%o', fileperms($log_directory)), -4);
			if( $log_directory_perms != 0777 || $log_directory_perms != '0777' || $log_directory_perms != 1777 || $log_directory_perms != '1777' ){
				if( !chmod($log_directory, 0777) ){
					$this->admin_notices( sprintf(__('Important, the directory <strong>"%s"</strong> must be in CHMOD %s.', "wp_mobilizer" ), MBLZR_PLUGIN_DIR . 'logs', 777 ), true );
					return false;
				}
			}

			$this->log_file = $log_directory . 'wp-mobilizer' . ( get_option('mblzr_do_log_date', true) == true ? '_' . date('Y-m-d') : '' ) . '.log';
		}

		return true;

	}

	/**
	 * Notice admin with some messages
	 */
	function admin_notices( $text, $errormsg = false ) {
		// Add text to admin notice info
		$this->admin_notices_infos[] = mblzr_show_essage($text, $errormsg);

		add_action(
			'admin_notices',
			create_function(
				'',
				'global $mblzr; if( is_array($mblzr->admin_notices_infos) && count($mblzr->admin_notices_infos) > 0 ){foreach($mblzr->admin_notices_infos as $notice){ echo $notice; } $mblzr->admin_notices_infos = array(); };'
			)
		);

	}
	
	/**
	* ADD Filetime into file if KM_FILEMTIME_REWRITE constant exist
	* 
	* @param mixed $default
	* @return mixed
	*/
	public function get_filetime_forfile( $default = '' ){
		
		if( !defined('KM_FILEMTIME_REWRITE') || !defined('MBLZR_VERSION_FILETIME') ){
			return $default;
		}
		
		return '-' . MBLZR_VERSION_FILETIME;
		
	}
	
	/**
	* Return null value if KM_FILEMTIME_REWRITE constant exist
	* 
	* @param mixed $default
	*/
	public function get_version_number( $default ){
		
		if( !defined('KM_FILEMTIME_REWRITE') ){
			return $default;
		}
		
		return null;
		
	}
	
	/**
	 * Set log file datas
	 */
	public function log( $message ) {
		if ( $this->do_log ) {
			error_log(date('Y-m-d H:i:s') . " " . $message . "\n", 3, $this->log_file);
		}
	}

	/**
	 * Check current user is an admin
	 *
	 */
	public function is_admin() {
		return current_user_can('level_8');
	}
	
	/**
	* Check Role for the user
	* 
	* @param mixed $role
	*/
	public function is_role( $role ){
		
		if( $this->current_user == false ){
			return false;
		}
		
		if( @reset($current_user->roles) == $role ){
			return true;
		}else{
			return false;
		}
		
	}
	
	/**
	* Return current ID User
	* 
	* @param mixed $role
	*/
	public function id_user( $role ){
		
		if( $this->current_user == false ){
			return false;
		}else{
			return $this->current_user->ID;
		}
		
	}
	
	/**
	* Get user informations
	* 
	*/
	public function get_user_info(){
		global $current_user;
		
		if( function_exists('get_currentuserinfo') ){
			get_currentuserinfo();
		}
		
		if( isset($current_user) && $current_user ){
			$this->current_user = $current_user;
		}

	}

	/**
	 * Dump menu var
	 */
	function dump_admin_menu() {
		if ( is_admin() ) {
			$this->dump($GLOBALS['menu']);
		}
	}

	/**
	 * Dump var
	 */
	public function dump( $var ) {
		header('Content-Type:text/plain');
		var_dump( $var );
		exit;
	}


}