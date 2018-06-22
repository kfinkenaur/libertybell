<?php
/**
 * @file           dk-options-interface.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */

class Dk_Options_Interface {
	 static function dk_options_tabs() {
		$options = Dk_Options_Interface::_dk_framework_options();
		$menu = '';
		$counter=0;
		foreach ( $options as $value ) {
			   if(isset($value['type'])) {
				if ( $value['type'] == "heading" ) {
					$counter++;
					$class = '';
					$class = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
					$class = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower($class) ) . '-tab';
					$menu .= '<a id="options-group-'.  $counter . '-tab" class="nav-tab ' . $class .'" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#options-group-'.  $counter ) . '">' . esc_html( $value['name'] ) . '</a>';
				}
			  }
			}
		return $menu;
	 }
	 static function dk_options_fields()  {	
			global $allowedtags;
			
			$themename = get_option( 'stylesheet' );
		    $themename = preg_replace("/\W/", "_", strtolower($themename) );
			$dk_framework_settings['id']= $themename; 
			   
			if ( isset( $dk_framework_settings['id'] ) ) {
				$option_name = $dk_framework_settings['id'];
			}
			else {
				$option_name = 'dk_responsive';
			};
			$settings = get_option($option_name);		
			$options = Dk_Options_Interface::_dk_framework_options();
			
			$counter = 0;
			$menu = '';	       		
			foreach ( $options as $value ) {
				$val = '';
				$select_value = '';
				$output = '';		
				if(!empty($value['type']) && $value['type']=="heading") {             		
					$counter++;
					if ( $counter >= 2 ) {
						$output .= '</div>'."\n";
					}
					$class = '';
					$class = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
					$class = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($class) );
					$output .= '<div id="options-group-' . $counter . '" class="group ' . $class . '">';
					$output .= '<h3>' . esc_html( $value['name'] ) . '</h3>' . "\n";
					$get_tab_id=preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower($value['id']) );
				 
				foreach($options[$get_tab_id]['element'] as  $value) {
				  $get_element_id=$value['id']; 
				  $output .= '<h3 class="rwd-toggle active"><a href="#">'.$value['title'].'</a></h3>';
				  $output .= '<div class="rwd-container">'; 
				 foreach($options[$get_tab_id][$get_element_id] as $key => $value) {
							if( isset ($value['id'])) {
							 $value['id'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($value['id']) );
							$id = 'section-' . $value['id'];
							}
							$class = 'section';
							if ( isset( $value['type'] ) ) {
								$class .= ' section-' . $value['type'];
							}
							if ( isset( $value['class'] ) ) {
								$class .= ' ' . $value['class'];
							}
							$output .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";
							if ( isset( $value['name'] ) ) {
								$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
							}
							if ( $value['type'] != 'editor' ) {
								$output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
							}
							else {
								$output .= '<div class="option">' . "\n" . '<div>' . "\n";
							}
				//}

				// Set default value to $val
					if ( isset( $value['std'] ) ) {
						$val = $value['std'];
					}

				// If the option is already saved, override $val
					if ( ( $value['type'] != 'heading' ) && ( $value['type'] != 'info') ) {
						if ( isset( $settings[($value['id'])]) ) {
							$val = $settings[($value['id'])];
							// Striping slashes of non-array options
							if ( !is_array($val) ) {
								$val = stripslashes( $val );
							}
						}
					}

				// If there is a description save it for labels
					$explain_value = '';
					if ( isset( $value['desc'] ) ) {
						$explain_value = $value['desc'];
					}

					

				 
				switch ( $value['type'] ) {

				// Basic text input
				case 'text':
					$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
					break;

				// Password input
				case 'password':
					$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="password" value="' . esc_attr( $val ) . '" />';
					break;

				// Textarea
				case 'textarea':
					$rows = '8';

					if ( isset( $value['settings']['rows'] ) ) {
						$custom_rows = $value['settings']['rows'];
						if ( is_numeric( $custom_rows ) ) {
							$rows = $custom_rows;
						}
					}

					$val = stripslashes( $val );
					$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" rows="' . $rows . '">' . esc_textarea( $val ) . '</textarea>';
					break;

				// Select Box
				case 'select':
					$output .= '<select class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';

					foreach ($value['options'] as $key => $option ) {
						$output .= '<option'. selected( $val, $key, false ) .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
					}
					$output .= '</select>';
					break;

				// Image Selectors
				case "images":
					$name = $option_name .'['. $value['id'] .']';
					foreach ( $value['options'] as $key => $option ) {
						$selected = '';
						if ( $val != '' && ($val == $key) ) {
							$selected = ' of-radio-img-selected';
						}
						$output .= '<input type="radio" id="' . esc_attr( $value['id'] .'_'. $key) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" '. checked( $val, $key, false ) .' />';
						$output .= '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
						$output .= '<img src="' . esc_url( $option ) . '" alt="' . $option .'" class="of-radio-img-img' . $selected .'" onclick="document.getElementById(\''. esc_attr($value['id'] .'_'. $key) .'\').checked=true;" />';
					}
					break;

				// Uploader
				case "upload":
					$output .= Dk_Options_Framework::dk_framework_uploader( $value['id'], $val, null );
					break;

				// Editor
				case 'editor':
					$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags ) . '</div>'."\n";
					echo $output;
					$textarea_name = esc_attr( $option_name . '[' . $value['id'] . ']' );
					$default_editor_settings = array(
						'textarea_name' => $textarea_name,
						'media_buttons' => false,
						'tinymce' => array( 'plugins' => 'wordpress' )
					);
					$editor_settings = array();
					if ( isset( $value['settings'] ) ) {
						$editor_settings = $value['settings'];
					}
					$editor_settings = array_merge( $default_editor_settings, $editor_settings );
					wp_editor( $val, $value['id'], $editor_settings );
					$output = '';
					break;

				// Info
				case "info":
					$id = '';
					$class = 'section';
					if ( isset( $value['id'] ) ) {
						$id = 'id="' . esc_attr( $value['id'] ) . '" ';
					}
					if ( isset( $value['type'] ) ) {
						$class .= ' section-' . $value['type'];
					}
					if ( isset( $value['class'] ) ) {
						$class .= ' ' . $value['class'];
					}

					$output .= '<div ' . $id . 'class="' . esc_attr( $class ) . '">' . "\n";
					if ( isset($value['name']) ) {
						$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
					}
					if ( isset( $value['desc'] ) ) {
						$output .= apply_filters('dk_sanitize_info', $value['desc'] ) . "\n";
					}
					$output .= '</div>' . "\n";
					break;
					
				// Checkbox
				case "checkbox":
					$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" '. checked( $val, 'Y', false) .' />';
					$output .= '<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags) . '</label>';
					break;

				// Heading for Navigation
				case "heading":
					$counter++;
					if ( $counter >= 2 ) {
						$output .= '</div>'."\n";
					}
					$class = '';
					$class = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
					$class = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($class) );
					$output .= '<div id="options-group-' . $counter . '" class="group ' . $class . '">';
					$output .= '<h3>' . esc_html( $value['name'] ) . '</h3>' . "\n";
					break;
				}
				
				if ( ( $value['type'] != "heading" )  ) {
					$output .= '</div>';
					if ( ( $value['type'] != "checkbox" ) && ( $value['type'] != "editor" ) && ( $value['type'] != "info" )  ) {
						$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags) . '</div>'."\n";
					}
					$output .= '</div></div>'."\n";
				   }
				}
				$output .='</div>';
			
			}
		 }
		 
		 echo $output;	 
		 // Outputs closing div if there tabs
		}
			if ( Dk_Options_Interface::dk_options_tabs() != '' ) {
					echo '</div>';
			}
		}
   

	 static function &_dk_framework_options() {
			static $options = null;
				if ( !$options ) {
					// Load options 	       
					if ( function_exists( 'dk_framework_options' ) ) {
							$options = dk_framework_options();
						}
					}		
			return $options;
	}
}
?>