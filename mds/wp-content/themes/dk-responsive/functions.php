<?php
/**
 * functions Template
 *
 *
 * @file           functions.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
*/

if( !defined( 'ABSPATH' ) ) {
	exit;
} 
if ( !isset( $content_width ) ) {
			$content_width = 660;
}	
if ( ! function_exists( 'dk_setup' ) ) :
function dk_setup() {
	
   
	load_theme_textdomain( 'dk-responsive', get_template_directory() . '/languages' );	
	
	add_editor_style();
	add_theme_support( 'automatic-feed-links' );	
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'dk-responsive' ),
		'footer' => __( 'Footer Menu', 'dk-responsive' ),
	) );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );	
	add_theme_support( 'post-formats', array(
		'aside', 'image','audio','video', 'quote', 'link','chat' 
	) );
	
			
	add_theme_support( 'post-thumbnails' );	
	
	add_theme_support( 'custom-background', apply_filters( 'dk_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );	
	
   
}
endif; // dk_setup
add_action( 'after_setup_theme', 'dk_setup' );


function dk_get_option_defaults() {
	$defaults = array(
		'front_page' => 'Y'
	);
	return apply_filters( 'dk_option_defaults', $defaults );
}

/**
 * Enqueue scripts and styles.
 */
function dk_scripts() {
	wp_enqueue_style( 'dk-style', get_stylesheet_uri() );

	wp_enqueue_script( 'dk-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'dk-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dk_scripts' );


require get_template_directory() . '/inc/options.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/function-sidebar.php';
require( get_template_directory() . '/inc/slider/slider_post_type.php' );
require( get_template_directory() . '/inc/slider/slider.php' );