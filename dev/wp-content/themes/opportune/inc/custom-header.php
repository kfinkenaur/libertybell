<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Opportune
 * 
 */

function opportune_custom_header() {
	$args = array(
		'default-image'   	=> esc_url(get_template_directory_uri() .'/images/fp-banner.jpg'),
		'width'         		=> 2560,
		'flex-width'    		=> true,
		'height'        		=> 700,
		'flex-height'    	=> true,
		'uploads'       		=> true,
		'header-text'  		=> false
		
	);
	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'opportune_custom_header' );