<?php
/**
 * @file           dk-options-framework.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */
 
 
class Dk_Options_Framework {
	
	public function init() {
		 add_action( 'admin_menu', array( $this, 'add_dk_custom_options_page' ) ); 
		 add_action( 'admin_init', array( $this, 'settings_init' ) );

	}
	function add_dk_custom_options_page () {    
		$menu = array(		
				'page_title' => __( 'Theme Options', 'dk-responsive'),
				'menu_title' => __('Theme Options', 'dk-responsive'),
				'capability' => 'edit_theme_options',
				'menu_slug' => 'dk_options_page',
				'parent_slug' => 'themes.php',  
			 
		);	
		add_theme_page($menu['page_title'], $menu['menu_title'], $menu['capability'], $menu['menu_slug'],  array(&$this, 'dk_options_page'));	
  }  
	function dk_options_page() {
	?>
		<div id="dk-options-framework-wrap" class="wrap">
			<div class="dk-callout">
					<p><?php _e('Welcome to DK Responsive!','dk-responsive');?> </p>					
			</div>		
			<h2><?php echo __('Theme Options', 'dk-responsive'); ?></h2>
			<h2 class="nav-tab-wrapper">
				<?php  echo Dk_Options_Interface::dk_options_tabs(); ?>
			</h2>		
			<div id="dk-framework-metabox" class="metabox-holder">
				<div id="dk-framework" class="postbox">
					<?php settings_errors( 'dk_responsive' ); ?>
					<form action="options.php" method="post">
					<?php settings_fields( 'dk_responsive' ); ?>
					
					<?php echo Dk_Options_Interface::dk_options_fields(); /* Settings */ ?>
					<div class="expand"><a href="#"><?php _e("Show&frasl;Hide All", 'dk-responsive');?></a></div>
					<div id="dk-framework-submit">
						<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( 'Save Options', 'dk-responsive' ); ?>" />
						<input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restore Defaults', 'dk-responsive' ); ?>" onclick="return confirm( '<?php print esc_js( __( 'Click OK to reset. Any theme settings will be lost!', 'dk-responsive' ) ); ?>' );" />
						<div class="clear"></div>
					</div>
					</form>
					
				</div> <!-- / #container -->
			</div>
   <?php
	}
  
	function settings_init() {
		// Load Dk Framework Settings
		$themename = get_option( 'stylesheet' );
		$themename = preg_replace("/\W/", "_", strtolower($themename) );
		//$dk_framework_settings = get_option( 'dk_responsive' );	
		$dk_framework_settings['id'] = $themename; 
		// Registers the settings fields and callback
		register_setting( 'dk_responsive', $dk_framework_settings['id'],  array ( $this, 'validate_options' ) );

		// Displays notice after options save
		add_action( 'dk_framework_after_validate', array( $this, 'save_options_msg' ) );

	}
  
	function save_options_msg() {       
		add_settings_error( 'dk_responsive', 'save_options', __( 'Options saved.', 'dk-responsive' ), 'updated fade' );		
	}
	function validate_options( $input ) {		
		if ( isset( $_POST['reset'] ) ) {
			add_settings_error( 'dk_responsive', 'restore_defaults', __( 'Default options restored.', 'dk-responsive' ), 'updated fade' );
			return $this->get_default_values();
		}
		$clean = array();
		
		$options = Dk_Options_Interface::_dk_framework_options();
		foreach ( $options as $option ) {		    
			
			
			 if(!empty($option['type']) && $option['type']=="heading") { 
			 $get_tab_id=preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower($option['id']) );            
			 foreach($options[$get_tab_id]['element'] as  $value) {		     
			 $get_element_id=$value['id'];
			 $id="";
			 foreach($options[$get_tab_id][$get_element_id] as $key => $option) {
			 
			 if(isset($option['id'])) {
			 $id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );
			 }
			// For a value to be submitted to database it must pass through a sanitization filter
			
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = false;
			}
						
			if ( has_filter( 'dk_sanitize_' . $option['type'] ) ) {
				if(isset($id)) {
				if(isset($input[$id]) ) {					  
					$clean[$id] = apply_filters( 'dk_sanitize_' . $option['type'], $input[$id], $option );					 
				}
			 }
			}
			 
			}
		   }
		  }
		}
		// Hook to run after validation
	   do_action( 'dk_framework_after_validate', $clean );
	 
	  return $clean;
	}
	
	function get_default_values() {
		$output = array();
		$options = Dk_Options_Interface::_dk_framework_options();
		foreach ( $options as $value ) {	  	
		if(!empty($value['type']) && $value['type']=="heading") { 		
			 $get_tab_id=preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower($value['name']) );			
				foreach($options[$get_tab_id]['element'] as  $value) {
					$get_element_id=$value['id']; 			
						foreach($options[$get_tab_id][$get_element_id] as $key => $value) {				
					
							if(!empty($value['std'])) {
								if ( has_filter( 'dk_sanitize_' . $value['type'] ) ) {
									$output[$value['id']] = apply_filters( 'dk_sanitize_' . $value['type'], $value['std'], $value );
								}
							}
					}
				}
			}
		}
		
		return $output;
	}
  
	static function dk_framework_uploader( $_id, $_value, $_desc = '', $_name = '' ) {
		$themename = get_option( 'stylesheet' );
		$themename = preg_replace("/\W/", "_", strtolower($themename) );
		//$dk_framework_settings = get_option( 'dk_responsive' );
		$dk_framework_settings['id'] = $themename; 
		// Gets the unique option id
		$option_name = $dk_framework_settings['id'];

		$output = '';
		$id = '';
		$class = '';
		$int = '';
		$value = '';
		$name = '';

		$id = strip_tags( strtolower( $_id ) );

		// If a value is passed and we don't have a stored value, use the value that's passed through.
		if ( $_value != '' && $value == '' ) {
			$value = $_value;
		}

		if ($_name != '') {
			$name = $_name;
		}
		else {
			$name = $option_name.'['.$id.']';
		}

		if ( $value ) {
			$class = ' has-file';
		}
		
		$output .= '<input id="' . $id . '" class="upload' . $class . '" type="text" name="'.$name.'" value="' . $value . '" placeholder="' . __('No file chosen', 'dk-responsive') .'" />' . "\n";
		
		if ( function_exists( 'wp_enqueue_media' ) ) {
			if ( ( $value == '' ) ) {
				$output .= '<input id="upload-' . $id . '" class="upload-button button" type="button" value="' . __( 'Upload', 'dk-responsive' ) . '" />' . "\n";
			} else {
				$output .= '<input id="remove-' . $id . '" class="remove-file button" type="button" value="' . __( 'Remove', 'dk-responsive' ) . '" />' . "\n";
			}
		} else {
			$output .= '<p><i>' . __( 'Upgrade your version of WordPress for full media support.', 'dk-responsive' ) . '</i></p>';
		}

		if ( $_desc != '' ) {
			$output .= '<span class="of-metabox-desc">' . $_desc . '</span>' . "\n";
		}

		$output .= '<div class="screenshot" id="' . $id . '-image">' . "\n";

		if ( $value != '' ) {
			$remove = '<a class="remove-image">Remove</a>';
			$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
			if ( $image ) {
				$output .= '<img src="' . $value . '" alt="" />' . $remove;
			} else {
				$parts = explode( "/", $value );
				for( $i = 0; $i < sizeof( $parts ); ++$i ) {
					$title = $parts[$i];
				}

				// No output preview if it's not an image.
				$output .= '';

				// Standard generic output if it's not an image.
				$title = __( 'View File', 'dk-responsive' );
				$output .= '<div class="no-image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">'.$title.'</a></span></div>';
			}
		}
		$output .= '</div>' . "\n";				
		return $output;
	}
} ?>