<?php
function de_naani_theme_customize_register($wp_customize) {
	
	//Body Background Color
	$wp_customize->add_setting('de_naani_options[Body_Background_Color]', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'           => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'de_naani_options[Body_Background_Color]', array(
		'label'    => 'Body Background Color',
		'section'  => 'colors',
		'settings' => 'de_naani_options[Body_Background_Color]',
	)));
	
	//Navigation Text Color　
	$wp_customize->add_setting('de_naani_options[Navigation_Text_Color]', array(
		'default'           => '#515151',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'           => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'de_naani_options[Navigation_Text_Color]', array(
		'label'    => 'Navigation Text Color',
		'section'  => 'colors',
		'settings' => 'de_naani_options[Navigation_Text_Color]',
	)));
	
	//Navigation Text Hover Color
	$wp_customize->add_setting('de_naani_options[Navigation_Text_Hover_Color]', array(
		'default'           => '#24890D',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'           => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'de_naani_options[Navigation_Text_Hover_Color]', array(
		'label'    => 'Navigation Text Hover Color',
		'section'  => 'colors',
		'settings' => 'de_naani_options[Navigation_Text_Hover_Color]',
	)));
	
	//Main Text Color
	$wp_customize->add_setting('de_naani_options[Main_Text_Color]', array(
		'default'           => '#515151',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'           => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'de_naani_options[Main_Text_Color]', array(
		'label'    => 'Main Text Color',
		'section'  => 'colors',
		'settings' => 'de_naani_options[Main_Text_Color]',
	)));
	
	//Main Text Link Color
	$wp_customize->add_setting('de_naani_options[Main_Text_Link_Color]', array(
		'default'           => '#515151',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'           => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'de_naani_options[Main_Text_Link_Color]', array(
		'label'    => 'Main Text Link Color',
		'section'  => 'colors',
		'settings' => 'de_naani_options[Main_Text_Link_Color]',
	)));
	
	//Main Text Hover Color
	$wp_customize->add_setting('de_naani_options[Main_Text_Hover_Color]', array(
		'default'           => '#dd3333',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'           => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'de_naani_options[Main_Text_Hover_Color]', array(
		'label'    => 'Main Text Hover Color',
		'section'  => 'colors',
		'settings' => 'de_naani_options[Main_Text_Hover_Color]',
	)));
	
	//Sidebar Text Color
	$wp_customize->add_setting('de_naani_options[Sidebar_Text_Color]', array(
		'default'           => '#515151',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'           => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'de_naani_options[Sidebar_Text_Color]', array(
		'label'    => 'Sidebar Text Color',
		'section'  => 'colors',
		'settings' => 'de_naani_options[Sidebar_Text_Color]',
	)));
	
	//Sidebar Text Link Color
	$wp_customize->add_setting('de_naani_options[Sidebar_Text_Link_Color]', array(
		'default'           => '#515151',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'           => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'de_naani_options[Sidebar_Text_Link_Color]', array(
		'label'    => 'Sidebar Text Link Color',
		'section'  => 'colors',
		'settings' => 'de_naani_options[Sidebar_Text_Link_Color]',
	)));
	
	//Sidebar Text Hover Color
	$wp_customize->add_setting('de_naani_options[Sidebar_Text_Hover_Color]', array(
		'default'           => '#24890D',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'           => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'de_naani_options[Sidebar_Text_Hover_Color]', array(
		'label'    => 'Sidebar Text Hover Color',
		'section'  => 'colors',
		'settings' => 'de_naani_options[Sidebar_Text_Hover_Color]',
	)));
	
	//Footer Text Color
	$wp_customize->add_setting('de_naani_options[Footer_Text_Color]', array(
		'default'           => '#1e73be',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'           => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'de_naani_options[Footer_Text_Color]', array(
		'label'    => 'Footer Text Color',
		'section'  => 'colors',
		'settings' => 'de_naani_options[Footer_Text_Color]',
	)));
	
	//Footer Text Hover Color
	$wp_customize->add_setting('de_naani_options[Footer_Text_Hover_Color]', array(
		'default'           => '#dd3333',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'           => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'de_naani_options[Footer_Text_Hover_Color]', array(
		'label'    => 'Footer Text Hover Color',
		'section'  => 'colors',
		'settings' => 'de_naani_options[Footer_Text_Hover_Color]',
	)));
	

	//title position
	$wp_customize->add_setting('de_naani_options[title_position]', array(
		'default'           => 'center',
		'type'           => 'option',
	));
	 $wp_customize->add_control( 'de_naani_options[title_position]', array(
	'settings' => 'de_naani_options[title_position]',
	'label' =>'Title Position',
	'section' => 'title_tagline',
	'type' => 'radio',
	'choices'    => array(
		'left' => 'left',
		'center' => 'center',
		'right' => 'right',
		),
	));

	//Post / Page Title Position
	$wp_customize->add_setting('de_naani_options[page_title_position]', array(
		'default'           => 'center',
		'type'           => 'option',
	));
	 $wp_customize->add_control( 'de_naani_options[page_title_position]', array(
	'settings' => 'de_naani_options[page_title_position]',
	'label' =>'Page Title Position',
	'section' => 'title_tagline',
	'type' => 'radio',
	'choices'    => array(
		'left' => 'left',
		'center' => 'center',
		'right' => 'right',
		),
	));
	
	//Menu Position
	$wp_customize->add_setting('de_naani_options[menu_position]', array(
		'default'           => 'center',
		'type'           => 'option',
	));
	 $wp_customize->add_control( 'de_naani_options[menu_position]', array(
	'settings' => 'de_naani_options[menu_position]',
	'label' =>'Menu Position',
	'section' => 'title_tagline',
	'type' => 'radio',
	'choices'    => array(
		'left' => 'left',
		'center' => 'center',
		'right' => 'right',
		),
	));

	//entry meta Position
	$wp_customize->add_setting('de_naani_options[entry_meta_position]', array(
		'default'           => 'center',
		'type'           => 'option',
	));
	 $wp_customize->add_control( 'de_naani_options[entry_meta_position]', array(
	'settings' => 'de_naani_options[entry_meta_position]',
	'label' =>'Entry Meta Position',
	'section' => 'title_tagline',
	'type' => 'radio',
	'choices'    => array(
		'left' => 'left',
		'center' => 'center',
		'right' => 'right',
		),
	));

	// Logo Image
    $wp_customize->add_setting('de_naani_options[Logo_Image]', array(
        'default'        => '',
        'type'           => 'option',
        'capability'     => 'edit_theme_options',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'de_naani_options[Logo_Image]',
        array(
            'label'     => 'Logo Image',
            'section'   => 'header_image',
            'settings'  => 'de_naani_options[Logo_Image]',
        )
    ));
	
}

add_action( 'customize_register', 'de_naani_theme_customize_register' );


function de_naani_customize_css(){
	
	$de_naani_options =  get_option('de_naani_options');
	
	echo "<style type=\"text/css\">\n<!--\n";
	
	echo ".site { background-color:".esc_html($de_naani_options['Body_Background_Color'])." !important;  }";
	echo ".entry-content, .entry-summary, .mu_register,footer.entry-meta { color:".esc_attr($de_naani_options['Main_Text_Color'])." !important;  }";
	echo ".entry-content a, .entry-summary a, .mu_register a,footer.entry-meta a,.entry-header .entry-title a,.comments-link a, .entry-meta a { color:".esc_attr($de_naani_options['Main_Text_Link_Color'])." !important;  }";
	echo ".entry-content a:hover, .entry-summary a:hover, .mu_register a:hover,footer.entry-meta a:hover,.entry-header .entry-title a:hover,.comments-link a:hover, .entry-meta a:hover { color:".esc_attr($de_naani_options['Main_Text_Hover_Color'])." !important;  }";	
	echo ".site-info a { color:".esc_attr($de_naani_options['Footer_Text_Color'])." !important;  }";
	echo ".site-info a:hover { color:".esc_attr($de_naani_options['Footer_Text_Hover_Color'])." !important;  }";
	echo ".main-navigation .current_page_item > a,.main-navigation li a { color:".esc_attr($de_naani_options['Navigation_Text_Color'])." !important;  }";
	echo ".main-navigation .current_page_item > a:hover,.main-navigation li a:hover { color:".esc_attr($de_naani_options['Navigation_Text_Hover_Color'])." !important;  }";
	echo "#secondary .archive-title, #secondary .page-title, #secondary .widget-title, #secondary .entry-content th, #secondary .comment-content th { color:".esc_attr($de_naani_options['Sidebar_Text_Color'])." !important;  }";
	echo ".widget-area .widget a,.widget-area .widget a:visited { color:".esc_attr($de_naani_options['Sidebar_Text_Link_Color'])." !important;  }";
	echo ".widget-area .widget a:hover { color:".esc_attr($de_naani_options['Sidebar_Text_Hover_Color'])." !important;  }";

	if(!$de_naani_options['Logo_Image']==null){
	echo "#logo-image img{ margin-right:10px); }";
	}

//title position
	if($de_naani_options['title_position'] == 'left'){
		echo ".site-header h1, .site-header h2 { text-align:left; }";
	}
	else if($de_naani_options['title_position'] == 'center'){
		echo ".site-header h1, .site-header h2 { text-align:center; }";
	}
	else if($de_naani_options['title_position'] == 'right'){
		echo ".site-header h1, .site-header h2 { text-align:right; }";
	}
	else{
		echo ".site-header h1, .site-header h2 { text-align:center; }";
	}
//Post / Page Title Position
	if($de_naani_options['page_title_position'] == 'left'){
		echo "h1.entry-title { text-align:left; }";
	}
	else if($de_naani_options['page_title_position'] == 'center'){
		echo "h1.entry-title { text-align:center; }";
	}
	else if($de_naani_options['page_title_position'] == 'right'){
		echo "h1.entry-title { text-align:right; }";
	}
	else{
		echo "h1.entry-title { text-align:center; }";
	}
//Menu Position
	if($de_naani_options['menu_position'] == 'left'){
		echo ".nav-menu ul { text-align:left !important; }";
	}
	else if($de_naani_options['menu_position'] == 'center'){
		echo ".nav-menu ul { text-align:center !important; }";
	}
	else if($de_naani_options['menu_position'] == 'right'){
		echo ".nav-menu ul { text-align:right !important; }";
	}
	else{
		echo ".nav-menu ul { text-align:center !important; }";
	}
	
//entry meta position
	if($de_naani_options['entry_meta_position'] == 'left'){
		echo "footer.entry-meta { text-align:left; }";
	}
	else if($de_naani_options['entry_meta_position'] == 'center'){
		echo "footer.entry-meta { text-align:center; }";
	}
	else if($de_naani_options['entry_meta_position'] == 'right'){
		echo "footer.entry-meta { text-align:right; }";
	}
	else{
		echo "footer.entry-meta { text-align:center; }";
	}

	echo "-->\n</style>\n";
}
add_action('wp_head', 'de_naani_customize_css');




if(class_exists('WP_Customize_Control')){
	class de_naani_customize_SelectCustomBackground_Control extends WP_Customize_Control {
		public $type = 'radio';
		public function render_content(){
			echo "<div style=\"display: none;\">\n";
			foreach($this->choices as $key=>$val){
				echo "<input type=\"radio\" name=\"_customize-radio-selectcustombg_setting\" data-customize-setting-link=\"selectcustombg_setting\" value=\"".esc_html($key)."\"";
				if($this->value()==$key) echo ' checked="checked"';
				echo ">\n";
			}
			echo "</div>\n";
		}
	}
	class de_naani_customize_SetPattern_Control extends WP_Customize_Control {
		public $type = 'radio';
		public function render_content(){
			$background_color = get_theme_mod('background_color');
			echo <<< EOM
			<style type="text/css">
				<!--
				#patternList > span.customize-control-title {
					padding-top: 15px;
				}
				#patternList > span.customize-control-title:first-child {
					padding-top: 0;
				}
				#patternList label {
					position: relative;
					display: block;
					border: 1px solid #ccc;
					-webkit-border-radius: 3px 0 0 3px;
					border-radius: 3px 0 0 3px;
					margin: 5px 0 2.5em;
					height: 64px;
					line-height: 64px;
					background-color: #{$background_color};
					background-repeat: no-repeat;
					background-position: left top;
					box-sizing: border-box;
				}
				#patternList label input {
					position: absolute;
					bottom: -1.5em;
					line-height: 1;
				}
				#patternList label span {
					position: absolute;
					bottom: -1.5em;
					left: 1.5em;
					display: block;
					line-height: 1;
				}
				-->
			</style>
			<script type="text/javascript">
			(function($){
				$(window).on('load',function(){
					var bgTab = $('<ul>').appendTo($('<div class="customize-control-image">').prependTo($('#customize-control-background_image').parent())).wrap($('<div class="library">').show());
					var bgTab_image = $('<li>Background Image</li>').appendTo(bgTab);
					var bgTab_pattern = $('<li>Pattern</li>').appendTo(bgTab);
					
					function selectImage(){
						bgTab_image.addClass('library-selected');
						bgTab_pattern.removeClass('library-selected');
						$('#customize-control-background_image').show();
						if($('#customize-control-background_image').find('.actions').find('a').css('display') != 'none'){
							$('#customize-control-background_repeat').show();
							$('#customize-control-background_position_x').show();
							$('#customize-control-background_attachment').show();
						}
						$('#customize-control-pattern_setting').hide();
					}
					function selectPattern(){
						bgTab_image.removeClass('library-selected');
						bgTab_pattern.addClass('library-selected');
						$('#customize-control-background_image').hide();
						$('#customize-control-background_repeat').hide();
						$('#customize-control-background_position_x').hide();
						$('#customize-control-background_attachment').hide();
						$('#customize-control-pattern_setting').show();
					}
					
					$('#accordion-section-background_image').on('click',function(){
						var bgcolor = $('#customize-control-background_color').find('input.color-picker-hex').val();
						$('#patternList').find('label').css('background-color',bgcolor);
					});
					
					if($('#customize-control-selectcustombg_setting').find('input[name="_customize-radio-selectcustombg_setting"]').eq(0).prop('checked')){
						selectImage();
					}else{
						selectPattern();
					}
					
					bgTab_image.on('click',function(){
						$('#customize-control-selectcustombg_setting').find('input[name="_customize-radio-selectcustombg_setting"]').eq(0).click();
						selectImage();
					});
					bgTab_pattern.on('click',function(){
						$('#customize-control-selectcustombg_setting').find('input[name="_customize-radio-selectcustombg_setting"]').eq(1).click();
						selectPattern();
					});
				});
			})(jQuery);
			</script>
EOM;
			echo "<div id=\"patternList\">\n";
			$pattern_type_b = "";
			$pattern_type_a = "";
			foreach($this->choices as $key=>$val){
				$split = explode("_",$key);
				$pattern_type_a = array_pop($split);
				if(empty($pattern_type_b) || $pattern_type_a != $pattern_type_b){
					if(strpos('bgcolor',$pattern_type_a) !== FALSE){
						echo "<span class=\"customize-control-title\">Custom Background Color</span>\n";
					}else 
					if(strpos('colored',$pattern_type_a) !== FALSE){
						echo "<span class=\"customize-control-title\">Fixed Color</span>\n";
					}
					$pattern_type_b = $pattern_type_a;
				}
				echo "<label class=\"ptn_".esc_html($key)."\" style=\"background-image:url('".get_bloginfo('wpurl')."/wp-content/themes/de-naani/images/ptn_".esc_html($key).".png')\">";
				echo "<input type=\"radio\" name=\"_customize-radio-pattern_setting\" data-customize-setting-link=\"pattern_setting\" value=\"".esc_html($key)."\"";
				if($this->value()==$key) echo ' checked="checked"';
				echo "><span>".esc_html($val)."</span></label>\n";
			}
			echo "</div>\n";
		}
	}
}

function de_naani_original_customize( $wp_customize ) {
	$wp_customize->add_setting('pattern_setting',
		array(
			'default'	=> 'botan_colored',
			'type'		=> 'option',
		)
	);
	if(class_exists('de_naani_customize_SetPattern_Control')){
		$wp_customize->add_control(
			new de_naani_customize_SetPattern_Control($wp_customize,'pattern_setting',
				array(
					'settings'	=> 'pattern_setting',
					'label'		=> 'Pattern',
					'section'	=> 'background_image',
					'type'		=> 'radio',
					'choices'	=> array(
						'chiyo_bgcolor'		=> 'Chiyo',
						'botan_bgcolor'		=> 'Botan',
						'hinageshi_bgcolor'	=> 'Hinageshi',
						'chiyo_colored'		=> 'Chiyo',
						'botan_colored'		=> 'Botan',
						'hinageshi_colored'	=> 'Hinageshi',
					),
				)
			)
		);
	}
	$wp_customize->add_setting('selectcustombg_setting',
		array(
			'default'	=> 'pattern',
			'type'		=> 'option',
		)
	);
	if(class_exists('de_naani_customize_SelectCustomBackground_Control')){
		$wp_customize->add_control(
			new de_naani_customize_SelectCustomBackground_Control($wp_customize,'selectcustombg_setting',
				array(
					'settings'	=> 'selectcustombg_setting',
					'label'		=> '',
					'section'	=> 'background_image',
					'priority'	=> 1,
					'type'		=> 'radio',
					'choices'	=> array(
						'image'		=> 'image',
						'pattern'	=> 'pattern',
					),
				)
			)
		);
	}
    
}
add_action('customize_register', 'de_naani_original_customize');


function de_naani_pattern_body_class( $classes ) {
	if(get_option('selectcustombg_setting')=="pattern"){
		$classes[] = "pattern_background";
	}
	if($pattern = get_option('pattern_setting')){
		$classes[] = "ptn_".$pattern;
	}
	return $classes;
}
add_filter('body_class', 'de_naani_pattern_body_class');


require_once(dirname(__FILE__).'/include/class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'de_naani_register_required_plugins' );
function de_naani_register_required_plugins() {
 
    $plugins = array(
 
        array(
            'name'                  => 'GMO Font Agent', // The plugin name
            'slug'                  => 'gmo-font-agent', // The plugin slug (typically the folder name)
 //           'source'                => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
 //           'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
 //           'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
 //           'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
 //           'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),
 
        array(
            'name'      => 'GMO Showtime',
            'slug'      => 'gmo-showtime',
            'required'  => false,
        ),
 
    );
  
    $config = array(
        'domain'            =>  'denaani',           // Text domain - likely want to be the same as your theme.
        'default_path'      => '',                           // Default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'themes.php',         // Default parent menu slug
        'parent_url_slug'   => 'themes.php',         // Default parent URL slug
        'menu'              => 'install-required-plugins',   // Menu slug
        'has_notices'       => true,                         // Show admin notices or not
        'is_automatic'      => false,            // Automatically activate plugins after installation or not
        'message'           => '',               // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                                => __( 'Install Required Plugins', 'denaani' ),
            'menu_title'                                => __( 'Install Plugins', 'denaani' ),
            'installing'                                => __( 'Installing Plugin: %s', 'denaani' ), // %1$s = plugin name
            'oops'                                      => __( 'Something went wrong with the plugin API.', 'denaani' ),
            'notice_can_install_required'               => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                                    => __( 'Return to Required Plugins Installer', 'denaani' ),
            'plugin_activated'                          => __( 'Plugin activated successfully.', 'denaani' ),
            'complete'                                  => __( 'All plugins installed and activated successfully. %s', 'denaani' ) // %1$s = dashboard link
        )
    );
 
    tgmpa( $plugins, $config );
 
}


$de_naani_custom_background_defaults = array(
        'default-color' => 'ffffff',
);
add_theme_support( 'custom-background', $de_naani_custom_background_defaults );


/* footer widgets */

function denaani_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'denaani' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'denaani' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 3', 'denaani' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 4', 'denaani' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'denaani_widgets_init' );