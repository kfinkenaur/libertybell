<?php
/**
 * Theme Options
 *
 *
 * @file           options.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */
// If this file is called directly, abort.

if ( ! defined( 'WPINC' ) ) {
    die;
}

function dk_framework_init() {    
	require( get_template_directory() . '/classes/dk-options-framework.php' );
	require( get_template_directory() . '/classes/dk-options-interface.php' );
	require ( get_template_directory() . '/classes/input-sanitization.php');	
	
	$dk_framework = new Dk_Options_Framework;
	$dk_framework->init();	
		
}
add_action( 'init', 'dk_framework_init', 20 );

function dk_framework_options () {
    $col_array = array(
		'3' => __('3-Col', 'dk-responsive'),
		'4' => __('4-Col', 'dk-responsive'),
	);	
	$slider_interval_array= array ( 
	  '2000' => __('2000', 'dk-responsive'),
	  '3000' => __('3000', 'dk-responsive'),
	  '4000' => __('4000', 'dk-responsive'),
	  '5000' => __('5000', 'dk-responsive'),
	  '6000' => __('6000', 'dk-responsive'),
	  '7000' => __('7000', 'dk-responsive'),
	  '8000' => __('8000', 'dk-responsive'),
	  '9000' => __('9000', 'dk-responsive'),
	  '10000' => __('10000', 'dk-responsive'),
    );	
		
	$slider_pause_array= array (
	    'hover' => __('hover', 'dk-responsive'),
		'false' => __('false', 'dk-responsive'),	
	);	
	
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();
	$options[] = array(
		'name' => __('General Settings', 'dk-responsive'),
		'type' => 'heading',
		'id'  => 'generalsettings',
		);
	$options['generalsettings'] =array(	 
	     'element' => array (
				array(
					'title'       => __( 'Logo Upload','dk-responsive'),
					'subtitle'    => '',
					'heading'     => '',
					'type'        => 'element',
					'id'          => 'logo_element',				
				  ),
				array(
					'title'       => __( 'Favicon Upload','dk-responsive'),
					'subtitle'    => '',
					'heading'     => '',
					'type'        => 'element',
					'id'          => 'favicon_element',				
				  ),				 
			    array(
					'title'       => __( 'Layout Settings' ,'dk-responsive'),
					'subtitle'    => '',
					'heading'     => '',
					'type'        => 'element',
					'id'          => 'layout_settings',				
				  ),
				
				array(
					'title'       => __( 'Social Media','dk-responsive'),
					'subtitle'    => '',
					'heading'     => '',
					'type'        => 'element',
					'id'          => 'social_media',				
				),
				
				array(
					'title'       => __( 'Footer settings','dk-responsive'),
					'subtitle'    => '',
					'heading'     => '',
					'type'        => 'element',
					'id'          => 'footer_settings',				
				),
				
	        ),
		  'logo_element' => array(
				array(
					'name' => __('Logo', 'dk-responsive'),
					'desc' => __('This creates a full size uploader that previews the image.', 'dk-responsive'),
					'id' => 'logo',
					'type' => 'upload'
				)
		   ),
		   'favicon_element' => array(
				array(
					'name' => __('Website Favicon', 'dk-responsive'),
					'desc' => __('Add Favicon Here.(Image sizes: 16X16,32X32)', 'dk-responsive'),
					'id' => 'web_favicon',
					'type' => 'upload'
				),
				array(
					'name' => __('Admin Favicon', 'dk-responsive'),
					'desc' => __('Add Favicon Here.(Image sizes: 16X16,32X32)', 'dk-responsive'),
					'id' => 'admin_favicon',
					'type' => 'upload'
				)
		   ),		   
		   
         'layout_settings' => array(      
				array(
					'name' => __('Layout Settings', 'dk-responsive'),
					'desc' => __('Images for layout.','dk-responsive'),
					'id' => "layout",
					'std' => "content-sidebar",
					'type' => "images",
					'options' => array(
					'full-width' => $imagepath . '1col.png',
					'sidebar-content' => $imagepath . '2cl.png',
					'content-sidebar' => $imagepath . '2cr.png')
				),
		   ),
		  
		   'social_media' => array(
				array(				
					'name' => __('Facebook', 'dk-responsive'),
					'desc' => __('Enter your facebook URL.', 'dk-responsive'),
					'id' => 'facebook',
					'std' => '',
					'type' => 'text'
				),
				array(				
					'name' => __('Twitter', 'dk-responsive'),
					'desc' => __('Enter your twitter URL.', 'dk-responsive'),
					'id' => 'twitter',
					'std' => '',
					'type' => 'text'
				),
				array(				
					'name' => __('Google+', 'dk-responsive'),
					'desc' => __('Enter your Google+ URL.', 'dk-responsive'),
					'id' => 'google',
					'std' => '',
					'type' => 'text'
				),				
				array(				
					'name' => __('YouTube', 'dk-responsive'),
					'desc' => __('Enter your YouTube URL.', 'dk-responsive'),
					'id' => 'youTube',
					'std' => '',
					'type' => 'text'
				),
		    ),
					   
           'footer_settings' => array(
				array(
					'name' => __('Footer copyright message', 'dk-responsive'),
					'desc' => __('Add footer copyright message here.','dk-responsive'),
					'id' => "copyright",
					'std' => "",
					'type' => 'textarea'
				),
				array(
					'name' => __('Footer columns', 'dk-responsive'),
					'desc' => __('Add Footer columns here.', 'dk-responsive'),
					'id' => 'footer_col',
					'std' => '3',
					'type' => 'select',
					'class' => 'mini', //mini, tiny, small
					'options' => $col_array
				),
		   ),		   
	 );	 
	$options[] = array(
		'name' => __('Home Page Settings', 'dk-responsive'),
		'type' => 'heading',
		'id'   => 'homepagesettings',
	);
	$wp_editor_settings = array(
				'wpautop' => true, // Default
				'textarea_rows' => 5,
				'media_buttons' => true
	);
	
	$options['homepagesettings'] =array(	 
	     'element' => array (
		           array(
					'title'       => __( 'Slider Settings', 'dk-responsive'),
					'subtitle'    => '',
					'heading'     => '',
					'type'        => 'element',
					'id'          => 'home_slider',				
				    ),
				    array(
					'title'       => __( 'Home Page Content Area', 'dk-responsive'),
					'subtitle'    => '',
					'heading'     => '',
					'type'        => 'element',
					'id'          => 'home_content',				
				  ),
				array(
					'title'       => __( 'Home Page Callout First Options ', 'dk-responsive'),
					'subtitle'    => '',
					'heading'     => '',
					'type'        => 'element',
					'id'          => 'home_widget1',				
				  ),
				  array(
					'title'       => __( 'Home Page Callout Second Options ', 'dk-responsive'),
					'subtitle'    => '',
					'heading'     => '',
					'type'        => 'element',
					'id'          => 'home_widget2',				
				  ),
				  array(
					'title'       => __( 'Home Page Callout Third Options ', 'dk-responsive'),
					'subtitle'    => '',
					'heading'     => '',
					'type'        => 'element',
					'id'          => 'home_widget3',				
				  ),
			 
	        ),
			'home_slider' => array(
				array(
					'name' => __('Slider Options', 'dk-responsive'),
					'desc' => __('Below every post you can see slider information section.Please checked "Display In Front Page Slider" checkbox, post will display in slider.For slider Image set featured Image of that post.', 'dk-responsive'),
					'type' => 'info'
				),				
				array(
					'name' => __('Slider Interval', 'dk-responsive'),
					'desc' => __('Specifies the amount of time to delay (in milliseconds) between one slide to another in automatic cycling.', 'dk-responsive'),
					'id' => 'slider_interval',
					'std' => '5000',
					'type' => 'select',
					'class' => 'mini', //mini, tiny, small
					'options' => $slider_interval_array
				),	
                array(
					'name' => __('Slider Pause', 'dk-responsive'),
					'desc' => __('Pauses the cycling of the carousel on mouse enter and resumes the cycling of the carousel on mouse leave.', 'dk-responsive'),
					'id' => 'slider_pause',
					'std' => 'hover',
					'type' => 'select',
					'class' => 'mini', //mini, tiny, small
					'options' => $slider_pause_array
				),	               				
		   ),
			
		  'home_content' => array(		 		  
		        array(
					'name' => __('Enable Custom Front Page', 'dk-responsive'),
					'desc' => __("Enable theme's front page", 'dk-responsive'),
					'std' => '1',
					'id' => 'front_page',								
					'type' => 'checkbox'
				),
				array(
					'name' => __('Home Page Headline', 'dk-responsive'),
					'desc' => __('Add Home Page Title', 'dk-responsive'),
					'id' => 'home_page_headline',
					'std' => '',					
					'type' => 'text'
				),
				
				array(
					'name' => __('Home Page Sub Headeline', 'dk-responsive'),
					'desc' => __('Add Home Page Sub Title', 'dk-responsive'),
					'id' => 'home_page_sub_headline',
					'std' => '',					
					'type' => 'text'
				),
				array (
				'name' => __('Home Page Content', 'dk-responsive'),
				'desc' => __('Add Home Page Content Here', 'dk-responsive'),
				'id' => 'home_page_content',
				'type' => 'editor',
				'settings' => $wp_editor_settings ),
		   ),
		   'home_widget1' => array(
		        array(
					'name' => __('Callout Image URL ', 'dk-responsive'),
					'desc' => __('Add Image URL here for example: http://yourdomain.com/abc.jpg.', 'dk-responsive'),
					'id' => 'home_widget_image_1',
					'std' => '',		
				    'type' => 'text'
				),
				array(
					'name' => __('Callout Title ', 'dk-responsive'),
					'desc' => __('Add Callout Title Here.', 'dk-responsive'),
					'id' => 'home_widget_title1',
					'std' => '',					
					'type' => 'text'
				),
				array(
					'name' => __('Callout Text', 'dk-responsive'),
					'desc' => __('Add Callout Content Here.', 'dk-responsive'),
					'id' => 'home_widget_content1',
					'std' => '',					
					'type' => 'textarea'
				),
				array (
					'name' => __('Callout URL', 'dk-responsive'),
					'desc' => __('Add "Read More" Link Here', 'dk-responsive'),
					'id' => 'home_widget_link1',
					'std' => ' ',					
					'type' => 'text'
		          ),
			),
			 'home_widget2' => array(
				array(
					'name' => __('Callout Image URL ', 'dk-responsive'),
					'desc' => __('Add Image URL here for example: http://yourdomain.com/abc.jpg.', 'dk-responsive'),
					'id' => 'home_widget_image_2',
					'std' => '',		
				    'type' => 'text'
				),
				
				array(
					'name' => __('Callout Title', 'dk-responsive'),
					'desc' => __('Add Callout Title Here.', 'dk-responsive'),
					'id' => 'home_widget_title2',
					'std' => '',					
					'type' => 'text'
				),
				array(
					'name' => __('Callout Text', 'dk-responsive'),
					'desc' => __('Add Callout Content Here.', 'dk-responsive'),
					'id' => 'home_widget_content2',
					'std' => '',					
					'type' => 'textarea'
				),
				array (
					'name' => __('Callout URL', 'dk-responsive'),
					'desc' => __('Add "Read More" Link Here', 'dk-responsive'),
					'id' => 'home_widget_link2',
					'std' => ' ',					
					'type' => 'text'
		        ),
			),
			 'home_widget3' => array(
				array(
					'name' => __('Callout Image URL ', 'dk-responsive'),
					'desc' => __('Add Image URL here for example: http://yourdomain.com/abc.jpg.', 'dk-responsive'),
					'id' => 'home_widget_image_3',
					'std' => '',		
				    'type' => 'text'
				),
				array(
					'name' => __('Callout Title', 'dk-responsive'),
					'desc' => __('Add Callout Title Here.', 'dk-responsive'),
					'id' => 'home_widget_title3',
					'std' => '',					
					'type' => 'text'
				),
				array(
					'name' => __('Callout Text', 'dk-responsive'),
					'desc' => __('Add Callout Text Here.', 'dk-responsive'),
					'id' => 'home_widget_content3',
					'std' => '',					
					'type' => 'textarea'
				),
				array (
					'name' => __('Callout URL', 'dk-responsive'),
					'desc' => __('Add "Read More" Link Here', 'dk-responsive'),
					'id' => 'home_widget_link3',
					'std' => ' ',					
					'type' => 'text'
		        ),
		   ),
	 );	
	return $options;
}

function dk_admin_enqueue_scripts( $hook_suffix ) {
	$template_directory_uri = get_template_directory_uri();	
	wp_enqueue_style( 'dk-theme-options', $template_directory_uri .'/inc/css/theme-options.css', false, '1.0' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'dk-theme-options', $template_directory_uri .'/inc/js/theme-options.js', array( 'jquery','wp-color-picker' ), '1.0' );
	 $template_directory_uri = get_template_directory_uri();
	/* media uplode */
	
	if ( function_exists( 'wp_enqueue_media' ) )
		wp_enqueue_media();

	wp_register_script( 'dk-media-uploader', $template_directory_uri .'/inc/js/' .'media-uploader.js', array( 'jquery' ) );
	wp_enqueue_script( 'dk-media-uploader' );
	wp_localize_script( 'dk-media-uploader', 'dk_framework_l10n', array(
		'upload' => __( 'Upload', 'dk-responsive' ),
		'remove' => __( 'Remove', 'dk-responsive' ),
	) );
	
}

add_action( 'admin_enqueue_scripts', 'dk_admin_enqueue_scripts' );

if ( ! function_exists( 'dk_get_option' ) ) :
function dk_get_option( $name, $default = false ) {
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );	
	$dk_framework_settings['id'] = $themename; 
	$options = get_option( $dk_framework_settings['id'] );
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}
	return $default;
}
endif;