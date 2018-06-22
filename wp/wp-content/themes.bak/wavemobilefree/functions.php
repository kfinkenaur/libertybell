<?php

//--Load jquery script
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}


// Start session for the usage on the theme (request of Desktop Version)
add_action('init', 'mySession', 1);

function mySession() {
    if(!session_id()) {
        session_start();
    }
}


//Register Sidebars (Widgets)

if ( function_exists('register_sidebar') ) 
{
	//Main Sidebar, this will be moved to the bottom of the site just before the footer
    register_sidebar(array(  
    'name' => 'Main Sidebar',
	'id' => 'primary',
    'before_widget' => '<div class="sidebar-box">',  
    'after_widget' => '</div>',  
    'before_title' => '<h3 class="sidebar-title">',  
    'after_title' => '</h3>',
));  

	//Widget for Advertisement, this will a floating ad displayed at the bottom of the site.
	register_sidebar(array(  
		'name' => 'Fixed Banner',
		'id' => 'banner',
		'description'=> 'Banner "fixed" at the bottom of the site. Use for Ad insertion. Max-height: 50px',
		'before_widget' => '<div class="ad-content">',
		'after_widget' => '</div>',  
		'before_title' => '<div class="ad-title">',  
		'after_title' => '</div>',
	));  
}


/// Additional classes insertion on sidebar widget
add_filter('dynamic_sidebar_params','custom_widget_counter');
function custom_widget_counter($params) {
	global $my_widget_num;
	$my_widget_num++;
	if($my_widget_num % 2) :
		$class .= 'even ';
	else :
		$class .= 'odd ';
	endif;
	$params[0]['before_widget'] = str_replace('class="', 'class="'.$class, $params[0]['before_widget']);
	return $params;
}

//---------- ADMIN OPTIONS --------------///////////////////////////////////////////////

//--Add theme options page
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );
function theme_options_init(){
 register_setting( 'mobile_options', 'mobile_theme_options');
} 

function theme_options_add_page() {
 add_theme_page( __( 'Mobile Theme', 'mobiletheme' ), __( 'Mobile Theme', 'mobiletheme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

//-- Include admin options page
function theme_options_do_page() { 
	include "functions-admin.php";
}


//--Color Selection
add_action('init', 'ilc_farbtastic_script');
function ilc_farbtastic_script() {
  wp_enqueue_style( 'farbtastic' );
  wp_enqueue_script( 'farbtastic' );
}
 
if (isset($_GET['page']) && $_GET['page'] == 'theme_options') {
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');
}

//-- Include additional scripts for upload of logo in the theme options
function my_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_script('my-upload');
}

//-- Include additional stylesheets for theme options
function my_admin_styles() {
wp_enqueue_style('thickbox');
}
?>