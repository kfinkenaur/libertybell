<?php
/*
Plugin Name: The US Regional Map
Plugin URI: http://codecanyon.net/item/interactive-us-map-wordpress-plugin/10359489?ref=clickmaps
Description: Free interactive US regional map plugin. Cutomize the 10 standard federal regions (colors, links, etc) through the admin panel and use the shortcode [us_regional_map] in your page or post to display the map.
Version: 2.0.7
Author: ClickMaps
Author URI: http://www.html5interactivemaps.com/
*/

class WP_R_Map {

	public function __construct()
	{
		$this->constant();
		$this->options = get_option( 'wp_r_map' );
		add_action('admin_menu', array($this, 'wp_r_map_options_page'));
	 	add_action( 'admin_footer', array( $this,'add_js_to_wp_footer' ) );
	 	add_action( 'wp_footer', array( $this,'add_span_tag' ) );
	 	add_action( 'wp_enqueue_scripts', array( $this,'map_r_frontend' ) );
		add_action( 'admin_enqueue_scripts', array($this,'init_admin_script') );
		add_shortcode( 'us_regional_map', array( $this, 'us_regional_map' )  );
		$this->default = array(
			 'border_color' => '#ffe2e2',
			 'short_names' => '#ffe2e2',
			 'shadow_color' => '#600000',
			 'lake_fill' => '#c3bef7',
			 'lake_outline' => '#9e76c9',

			 'up_color_1' => '#ddb8b8', 
			 'over_color_1' => '#e08433',
			 'down_color_1' => '#ffac47',
			 'url_1' => '#',
			 'open_url_1' => '_self',
			 'hover_content_1' => '<b>Standard Federal Region I</b>',
			 'enable_region_1' => 1,

			 'up_color_2' => '#dd4d4d',
			 'over_color_2' => '#e08433' ,
			 'down_color_2' => '#ffac47',
			 'url_2' => '#',
			 'open_url_2' => '_self' ,
			 'hover_content_2' => '<b>Standard Federal Region II</b>',
			 'enable_region_2' => 1,

			 'up_color_3' => '#dd8d8d',
			 'over_color_3' => '#e08433',
			 'down_color_3' => '#ffac47',
			 'url_3' => '#',
			 'open_url_3' => '_self' ,
			 'hover_content_3' => '<b>Standard Federal Region III</b>',
			 'enable_region_3' => 1,

			 'up_color_4' => '#dd4d4d',
			 'over_color_4' => '#e08433',
			 'down_color_4' => '#ffac47',
			 'url_4' => '#',
			 'open_url_4' => '_self' ,
			 'hover_content_4' => '<b>Standard Federal Region IV</b>',
			 'enable_region_4' => 1,

			 'up_color_5' => '#dd2e2e',
			 'over_color_5' => '#e08433',
			 'down_color_5' => '#ffac47',
			 'url_5' => '#',
			 'open_url_5' => '_self' ,
			 'hover_content_5' => '<b><u>Standard Federal Region V</u></b><br>*Write text and display images.<br>*Link each region to any webpage.',
			 'enable_region_5' => 1,

			 'up_color_6' => '#dd0000',
			 'over_color_6' => '#e08433',
			 'down_color_6' => '#ffac47',
			 'url_6' => '#',
			 'open_url_6' => '_self' ,
			 'hover_content_6' => '<b><u>Standard Federal Region VI</u></b><br>*Write text and display images.<br>*Link each region to any webpage.',
			 'enable_region_6' => 1,

			 'up_color_7' => '#dd9292',
			 'over_color_7' => '#e08433',
			 'down_color_7' => '#ffac47',
			 'url_7' => '#',
			 'open_url_7' => '_self' ,
			 'hover_content_7' => '<b>Standard Federal Region VII</b>',
			 'enable_region_7' => 1,

			 'up_color_8' => '#ddb8b8',
			 'over_color_8' => '#e08433' ,
			 'down_color_8' => '#ffac47',
			 'url_8' => '#',
			 'open_url_8' => '_self' ,
			 'hover_content_8' => '<b>Standard Federal Region VIII</b>',
			 'enable_region_8' => 1,

			 'up_color_9' => '#dd4444',
			 'over_color_9' => '#e08433' ,
			 'down_color_9' => '#ffac47',
			 'url_9' => '#',
			 'open_url_9' => '_self' ,
			 'hover_content_9' => '<b>Standard Federal Region IX</b>',
			 'enable_region_9' => 1,

			 'up_color_10' => '#dd8d8d',
			 'over_color_10' => '#e08433' ,
			 'down_color_10' => '#ffac47',
			 'url_10' => '#',
			 'open_url_10' => '_self' ,
			 'hover_content_10' => '<b>Standard Federal Region X</b>',
			 'enable_region_10' => 1,);

		if(isset($_POST['wp_r_map']) && !isset($_POST['preview_map']))	{
			update_option('wp_r_map', array_map('stripslashes_deep', $_POST));
			$this->options = array_map('stripslashes_deep', $_POST);
		}
		if(isset($_POST['wp_r_map']) && isset($_POST['restore_default']))	{
			update_option('wp_r_map', $this->default);
			$this->options = $this->default;
		}
		
		if(!is_array($this->options)){
			$this->options = $this->default;
		}
	}

	protected function constant(){
		
		define( 'WPMMAPR_VERSION',   '1.0' );
		define( 'WPMMAPR_DIR',       plugin_dir_path( __FILE__ ) );
		define( 'WPMMAPR_URL',       plugin_dir_url( __FILE__ ) );

	}

	public function us_regional_map(){
		ob_start();
		include 'templates/map.php';
		?>
		<script type="text/javascript">
			<?php include 'regions-config.php'; ?>
		</script>
		<script type="text/javascript" src="<?php echo WPMMAPR_URL . 'map-interact.js'; ?>"></script>
		<?php
		$html = ob_get_clean();
		return $html;
	}

	public function wp_r_map_options_page() {
		add_menu_page('US Regional Map', 'US Regional Map', 'manage_options', 'wp-r-map', array($this, 'options_screen'), WPMMAPR_URL . 'images/map-icon.png');
	}

	public function options_screen()
	{
		include 'templates/admin.php';
	}

	public function admin_ajax_url(){
		$url_action = admin_url( '/' ) . 'admin-ajax.php';
		echo '<div style="display:none" id="wpurl">'. $url_action.'</div>';
	}

	public function add_js_to_wp_footer(){ ?>
		<span class="map-tip-us" id="map-tip-us" style="margin-top:-32px"></span>		
		<script type="text/javascript">
			<?php include 'regions-config.php'; ?>
		</script>
	<?php }

	public function map_r_frontend(){
		wp_enqueue_style( 'wp-mapstyle-frontend', WPMMAPR_URL . 'map-style.css', false, '1.0', 'all' );
	}

	public function add_span_tag(){
		?>
		<span class="map-tip-us" id="map-tip-us"></span>		
		<?php
	}

	public function stripslashes_deep($value) {
			$value = is_array($value) ?
				array_map(array($this, 'stripslashes_deep'), $value) : stripslashes($value);
				return $value;
		}

	public function init_admin_script(){
		if(isset($_GET['page']) && $_GET['page'] == 'wp-r-map'):
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_style('thickbox'); // call to media files in wp
		wp_enqueue_script('thickbox');
		wp_enqueue_script( 'media-upload'); 
		wp_enqueue_style( 'wp-map-style', WPMMAPR_URL . 'style.css', false, '1.0', 'all' );
		wp_enqueue_style( 'wp-mapstyle', WPMMAPR_URL . 'map-style.css', false, '1.0', 'all' );
		wp_enqueue_style( 'wp-tinyeditor', WPMMAPR_URL . 'tinyeditor.css', false, '1.0', 'all' );
		wp_enqueue_script( 'wp-map-interact', WPMMAPR_URL . 'map-interact.js', 10, '1.0', true );
		wp_enqueue_script( 'wp-map-tiny.editor', WPMMAPR_URL . 'js/tinymce.min.js', 10, '1.0', true );
		wp_enqueue_script( 'wp-map-script', WPMMAPR_URL . 'js/scripts.js', array( 'wp-color-picker' ), false, true );
		endif;	
	}
}

$wp_r_map = new WP_R_Map();