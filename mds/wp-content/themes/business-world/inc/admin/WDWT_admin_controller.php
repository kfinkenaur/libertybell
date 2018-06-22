<?php 
global $wdwt_options; 

/// include Layout page class
require_once( 'page_layout.php' );
/// include General Settings page class
require_once( 'page_general_settings.php' );
/// include Home page class
require_once( 'page_homepage.php' );
/// include Typography page class
require_once( 'page_typography.php' );
/// include Slider page class
require_once( 'page_slider.php' );


///include licensing page
// color control free version is also here
require_once( 'licensing.php' );

$wdwt_layout_page = new WDWT_layout_page_class();
$wdwt_general_settings_page = new WDWT_general_settings_page_class();
$wdwt_homepage_page = new WDWT_homepage_page_class();
$wdwt_typography_page = new WDWT_typography_page_class();
$wdwt_slider_page = new WDWT_slider_page_class();
$wdwt_licensing_page = new WDWT_licensing_page_class();


add_filter('option_'.WDWT_OPT, 'wdwt_options_mix_defaults');

add_filter('wdwt_new_options_new_users', 'wdwt_new_options_new_users');

add_action( 'after_setup_theme', 'wdwt_options_init', 10, 2 );



function wdwt_options_init() {
  global $wdwt_options;

  $option_defaults = wdwt_get_option_defaults();
  $new_version = $option_defaults['theme_version'];
  $options = get_option( WDWT_OPT, array() );

  if(isset($options['theme_version'])){
    $old_version = $options['theme_version'];
  }
  else{
    $old_version = '0.0.0';
  }

  if($new_version !== $old_version){
    require_once('updater.php');
    $theme_update = new Business_world_updater($new_version, $old_version);
    $options = $theme_update->get_old_params();  /* old params in new format */
  }
  /*overwrite defaults with new options*/
  $wdwt_options = apply_filters('wdwt_options_init', $options);
}

 function wdwt_options_mix_defaults($options){
  $option_defaults = WDWT_get_option_defaults();
  /*theme version is saved separately*/
  /*for the updater*/
  if(isset($option_defaults['theme_version'])){
    unset($option_defaults['theme_version']);
  }
  $options = wp_parse_args( $options, $option_defaults);
  return $options;
}

function wdwt_get_options() {
  global $wdwt_options;
  wdwt_options_init();/*refrest options*/

  return apply_filters('wdwt_get_options', $wdwt_options);
}



function wdwt_get_option_defaults() {
  $option_parameters = wdwt_get_option_parameters();
  $option_defaults = array();
  
  $current_theme = wp_get_theme();
  $option_defaults['theme_version'] = $current_theme->get( 'Version' );
  
  foreach ( $option_parameters as $option_parameter ) {
    $name =  (isset($option_parameter['name']) && $option_parameter['name'] !='' ) ? $option_parameter['name'] : false;
    if($name && isset($option_parameter['default']))
      $option_defaults[$name] = $option_parameter['default'];
  }
  
  return apply_filters( 'wdwt_get_option_defaults', $option_defaults );
}


 /**
  * new options to be enabled by default for new users only
  */

function wdwt_new_options_new_users($options){
  $options['pinned_post_enable'] = true;
  //$options['contact_us_enable'] = true;  /// PRO only
  $options['header_img_type'] = 'image';

  return $options;
}

function wdwt_get_option_parameters() {
  global  $wdwt_layout_page,       
      $wdwt_general_settings_page , 
      $wdwt_homepage_page,
      $wdwt_typography_page,
      $wdwt_slider_page;
  global $wdwt_licensing_page;

  $options=array();
  
  foreach($wdwt_layout_page->options as $kay => $x)
    $options[$kay] = $x;
	
  foreach($wdwt_general_settings_page->options as $kay =>  $x) 
    $options[$kay] = $x;
	
  foreach($wdwt_homepage_page->options as $kay =>  $x)  
    $options[$kay] = $x;
  
  foreach($wdwt_typography_page->options  as $kay => $x)  
    $options[$kay] = $x;

  foreach($wdwt_slider_page->options  as $kay => $x)  
    $options[$kay] = $x;
  
  return apply_filters( 'wdwt_get_option_parameters', $options );
}



function wdwt_get_tabs() {
  $tabs= array();

  $tabs['layout_editor'] = array(
    'name' => 'layout_editor',
    'title' => __( 'Layout Editor', "business-world" ),
    'sections' => array(
      'layouts' => array(
        'name' => 'layouts',
        'title' => __( 'Layout Editor', "business-world" ),
        'description' => ''
      )
    ),
  'description' => wdwt_section_descr('layout_editor')
  );

  $tabs['general'] = array(
    'name' => 'general',
    'title' => __( 'General', "business-world" ),
    'sections' => array(
      'general_main' => array(
        'name' => 'general_main',
        'title' => __( 'General - Main', "business-world" ),
        'description' => ''
      ),
    ),
  'description' => wdwt_section_descr('general')
  );

  $tabs['homepage'] = array(
    'name' => 'homepage',
    'title' => __( 'Homepage', "business-world" ),
    'sections' => array(
      'main' => array(
        'name' => 'main',
        'title' => __( 'Main', "business-world" ),
        'description' => ''
      ),
      'featured_post' => array(
        'name' => 'featured_post',
        'title' => __( 'Featured Post', "business-world" ),
        'description' => ''
      ),
      'top_posts' => array(
        'name' => 'top_posts',
        'title' => __( 'Top Posts', "business-world" ),
        'description' => ''
      ),
      'posts_tabs' => array(
        'name' => 'posts_tabs',
        'title' => __( 'Posts Tabs', "business-world" ),
        'description' => ''
      ),
      'pinned_post' => array(
        'name' => 'pinned_post',
        'title' => __( 'Pinned Post', "business-world" ),
        'description' => ''
      ),
      'content_posts' => array(
        'name' => 'content_posts',
        'title' => __( 'Content Posts', "business-world" ),
        'description' => ''
      ),
      'social' => array(
        'name' => 'social',
        'title' => __( 'Social links', "business-world" ),
        'description' => ''
      ),

    ),
    'description' => wdwt_section_descr('homepage'),
  );

  

  $tabs['typography'] = array(
    'name' => 'typography',
    'title' => __( 'Typography', "business-world" ),
    'description' => wdwt_section_descr('typography'),
    'sections' => array(
      'text_headers' => array(
        'name' => 'text_headers',
        'title' => __( 'Typography - Text Headers', "business-world" ),
        'description' => ''
      ),
      'primary_font' => array(
        'name' => 'primary_font',
        'title' => __( 'Typography - Primary Font' , "business-world"),
        'description' => ''
      ),
      'inputs_textareas' => array(
        'name' => 'inputs_textareas',
        'title' => __( 'Typography - Inputs and Text Areas', "business-world" ),
        'description' => ''
      )
    ),
    
  );


  $tabs['slider'] = array(
    'name' => 'slider',
    'title' => __( 'Slider', "business-world" ),
    'description' => wdwt_section_descr('slider'),
    'sections' => array(
      'slider_main' => array(
        'name' => 'slider_main',
        'title' => __( 'General', "business-world" ),
        'description' => ''
      ),
      'slider_imgs' => array(
        'name' => 'slider_imgs',
        'title' => __( 'Images' , "business-world"),
        'description' => ''
      ),
    ),
  );


  /* NO if WDWT_IS_PRO*/
    $tabs['color_control'] = array(
      'name' => 'color_control',
      'title' => __( 'Color Control', "business-world" ),
      'sections' => array(
        'color_control' => array(
          'name' => 'color_control',
          'title' => __( 'Color Control', "business-world" ),
          'description' => ''
        )
      ),
    'description' => wdwt_section_descr('color_control')
    );


  $tabs['licensing'] = 
      array(
        'name' => 'licensing',
        'title' => __( 'Upgrade to PRO', "business-world" ),
        'sections' => array(
          'licensing' => array(
            'name' => 'licensing',
            'title' => __( 'Upgrade to PRO', "business-world" ),
            'description' => ''
          )
        ),
        'description' =>  ''
      );

    
  return apply_filters( 'wdwt_get_tabs', $tabs );
}