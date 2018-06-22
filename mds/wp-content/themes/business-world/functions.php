<?php


/*define theme global constants*/
/*framework prefix is wdwt*/  
define("WDWT_TITLE", "Business World");
define("WDWT_SLUG", "business-world");
/*textdomain*/
define("WDWT_VAR", "business_world");
define("WDWT_META", "_".WDWT_SLUG."_meta");
define("WDWT_OPT", WDWT_VAR."_options");
define("WDWT_VERSION", wp_get_theme()->get( 'Version' ));
define("WDWT_LOGO_SHOW", true);
define("WDWT_HOMEPAGE", "https://web-dorado.com");
/*directories*/
define("WDWT_DIR", get_template_directory());
/*URLs*/
define("WDWT_URL", get_template_directory_uri());
define("WDWT_IMG", WDWT_URL.'/images/');
define("WDWT_IMG_INC", WDWT_URL.'/inc/images/');

/*include admin, options and frontend classes*/
require_once('inc/index.php');



if(!is_admin()){
  add_action('init','wdwt_front_init');  
}
/* head*/
add_action('wp_head','wdwt_include_head');
/*  Frontend scripts and styles */
add_action('wp_enqueue_scripts','wdwt_scripts_front');


/* sidebars*/
add_action('widgets_init', 'wdwt_widgets_init');
/* change body class*/
add_filter('body_class', 'wdwt_multisite_body_classes');
/* add_theme_support , textdomain etc */
add_action('after_setup_theme', 'wdwt_setup_elements');
/* excerpt more */
add_filter('excerpt_more', array(WDWT_VAR.'_frontend_functions', 'excerpt_more'));
/*   remove more in posts and pages   */
add_filter('the_content_more_link', array(WDWT_VAR.'_frontend_functions', 'remove_more_jump_link'));
/* contact page captcha */
add_action('wp_ajax_wdwt_captchareturn', 'wdwt_captcha');
add_action('wp_ajax_nopriv_wdwt_captchareturn', 'wdwt_captcha');

add_action('wp_ajax_wdwt_captcha', 'wdwt_captcha' );
add_action('wp_ajax_nopriv_wdwt_captcha', 'wdwt_captcha');

add_action('wp_ajax_wdwt_lightbox', 'wdwt_lightbox');
add_action('wp_ajax_nopriv_wdwt_lightbox', 'wdwt_lightbox');

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', array(WDWT_VAR.'_frontend_functions', 'wdwt_wrapper_start'), 10);
add_action('woocommerce_after_main_content', array(WDWT_VAR.'_frontend_functions', 'wdwt_wrapper_end'), 10);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

/*functions are below*/


function wdwt_front_init(){
   global $wdwt_options,
    $wdwt_front;
  
  global $wp_customize;
  if ( !isset( $wp_customize ) ) {
    $wdwt_front =  new business_world_front($wdwt_options);  
  }

}

function wdwt_include_head(){
 global $wdwt_front;
  $wdwt_front->layout();
  $wdwt_front->typography();
  $wdwt_front->color_control();
  $wdwt_front->favicon_img();
  $wdwt_front->custom_css();
  $wdwt_front->menu_bg_img(); 
} 
  
  


function wdwt_scripts_front(){
   global $wdwt_options, $wdwt_front;
   $wdwt_front =  new Business_world_front($wdwt_options);
   
   $animation_speed = esc_js($wdwt_front->get_param('animation_speed'));
   $effect = $wdwt_front->get_param('effect');
   if(is_home())
     $image_height = esc_js($wdwt_front->get_param('image_height'));
   else  
     $image_height = esc_js($wdwt_front->get_param('image_height_pages'));

   $stop_on_hover = esc_js($wdwt_front->get_param('stop_on_hover'));
   $parallax_img_padding = esc_js($wdwt_front->get_param('parallax_img_padding'));
   $slideshow_interval = esc_js($wdwt_front->get_param('slideshow_interval'));

   $hide_slider = $wdwt_front->get_param('hide_slider');
   $header_img_type = $wdwt_front->get_param('header_img_type');
   $imgs_url = $wdwt_front->get_param('slider_head');
   $imgs_url = explode('||wd||',$imgs_url);
   $business_world_slider_options=array(
    "wdwt_animation_speed" => $animation_speed,
    "wdwt_effect" => esc_js($effect[0]),
    "wdwt_image_height" => $image_height,
    "wdwt_slideshow_interval" => $slideshow_interval,
    "wdwt_stop_on_hover" => $stop_on_hover,
  );
   $business_world_options=array(
    "wdwt_pinned_padding" => $parallax_img_padding
  );
  
  wp_enqueue_script('wdwt_response', WDWT_URL.'/inc/js/responsive.js', array('jquery'), WDWT_VERSION);
  wp_localize_script('wdwt_response', 'business_world_options', $business_world_options);
  wp_enqueue_script('wdwt_custom_js', WDWT_URL.'/inc/js/javascript.js', array('jquery'), WDWT_VERSION);
    
  wp_enqueue_style( WDWT_SLUG.'-style', get_stylesheet_uri(), array(), WDWT_VERSION );
  wp_enqueue_script('wdwt_hover_effect',WDWT_URL.'/inc/js/jquery-hover-effect.js', array(), WDWT_VERSION);
  wp_enqueue_script( 'comment-reply' );

  if( ($hide_slider[0]!="Hide Slider" && ((is_home() && $hide_slider[0]=="Only on Homepage") || (is_front_page() && $hide_slider[0]=="Only on Front Page") || $hide_slider[0]=="On all the pages and posts")) && count($imgs_url) && is_array($imgs_url)){
    if($header_img_type == "slider"){ 
      wp_enqueue_script('business_world_slider_js', WDWT_URL.'/inc/js/slider.js',array('jquery'));
      wp_localize_script('business_world_slider_js', 'business_world_slider_options', $business_world_slider_options);
      wp_enqueue_style( 'wdwt_slideshow-style', WDWT_URL.'/slideshow/style.css', array(), WDWT_VERSION );
    }else{
      wp_enqueue_script('jquery-parallax', WDWT_URL.'/inc/js/parallax.js', array('jquery'), WDWT_VERSION);
    }
  }

    // Styles/Scripts for popup.
    wp_enqueue_style('wdwt_font-awesome', WDWT_URL . '/inc/css/font-awesome/font-awesome.css', array(), WDWT_VERSION); // temporary instead of '4.2.0'
    wp_enqueue_script('wdwt_jquery_mobile', WDWT_URL . '/inc/js/jquery.mobile.min.js', array(), WDWT_VERSION);
    wp_enqueue_script('wdwt_mCustomScrollbar', WDWT_URL . '/inc/js/jquery.mCustomScrollbar.concat.min.js', array(), WDWT_VERSION);
    wp_enqueue_style('wdwt_mCustomScrollbar', WDWT_URL . '/inc/css/jquery.mCustomScrollbar.css', array(), WDWT_VERSION);
    wp_enqueue_script('wdwt_jquery-fullscreen', WDWT_URL . '/inc/js/jquery.fullscreen-0.4.1.js', array(), '0.4.1');
  
    wp_enqueue_script('wdwt_lightbox_loader', WDWT_URL.'/inc/js/lightbox.js', array(), WDWT_VERSION);
    wp_localize_script( 'wdwt_lightbox_loader', 'admin_ajax_url', admin_url('admin-ajax.php') );
    
   
}



  /*************************************/
  /*   REGISTR SIDBARS [WIDGET AREA]   */
  /*************************************/

function wdwt_widgets_init()
{

    // Area 1, located at the top of the sidebar.

    register_sidebar(array(
            'name' => __( 'Primary Widget Area', "business-world" ),
            'id' => 'sidebar-1',
            'description' =>  __( 'The primary widget area', "business-world" ),
            'before_widget' => '<div id="%1$s" class="widget-area %2$s">',
            'after_widget' => '</div> ',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        )
    );
  
    // Area 2, located below the Primary Widget Area in the sidebar. Empty by default.

    register_sidebar(array(
            'name' => __( 'Secondary Widget Area', "business-world" ),
            'id' => 'sidebar-2',
            'description' => __('The secondary widget area', "business-world" ),
            'before_widget' => '<div id="%1$s" class="widget-area %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );  
  
  register_sidebar(array(
            'name' => __( 'Footer Widget Area', "business-world" ),
            'id' => 'footer-widget-area',
            'description' => __('The footer widget area', "business-world" ),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
   
}



  /*************************************/
  /*        BODY CLASS BAD CLASS       */
  /*************************************/

function wdwt_multisite_body_classes($classes){
  foreach($classes as $key=>$class)
  {
    if($class=='blog')
    $classes[$key]='blog_body';
  }
  return $classes;
  
}

  /*************************************/
  /* CALL FUNCTIONS AFTER THEME SETUP  */
  /*************************************/

function wdwt_setup_elements()
{
    add_theme_support( 'title-tag' );

  // add custom header in admin menu
  add_theme_support( 'custom-header', array(
      'default-text-color'  => '220e10',
    'default-image'       => '',
    'header-text'         => false,
    'height'              => 230,
    'width'               => 1024
    
  ) );
  
  // add custom background in admin menu
   $theme_defaults = array(
    'default-color'          => 'fff',
    'default-image'          => '',
    );
    add_theme_support('custom-background', $theme_defaults );
    
    
    if(!get_theme_mod('background_color',false))
    set_theme_mod('background_color','ffffff');

  // For Post thumbnail
  add_theme_support('post-thumbnails');
    set_post_thumbnail_size(150, 150);
  add_image_size( 'business-width', 250, 230, true );
  
  // requerid  features
  add_theme_support('automatic-feed-links');
  
  /// include language
  load_theme_textdomain("business-world", WDWT_DIR.'/languages' );
  
  // registr menu,
    register_nav_menu('primary-menu', __( 'Primary Menu', "business-world" ));
  
  // for editor styles
  add_editor_style();
  
  if ( ! isset( $content_width ) ) $content_width = 1024;


  /*WooCommerce support*/
  add_theme_support( 'woocommerce' );
}



function wdwt_lightbox (){

  $action = $_POST['action'];
  if($action == "wdwt_lightbox"){
    require_once('inc/front/WDWT_lightbox.php');
    $lightbox = new WDWT_Lightbox();
    $lightbox->view();
  }
  die();
}

?>
