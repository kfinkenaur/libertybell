<?php
/**
 * @file           input-sanitization.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */

/* Sanitization for text input  */
add_filter( 'dk_sanitize_text', 'sanitize_text_field' );
/* Sanitization for password input */
add_filter( 'dk_sanitize_password', 'sanitize_text_field' );
/* Sanitization for select input */
add_filter( 'dk_sanitize_select', 'dk_sanitize_enum', 10, 2 );
/* Sanitization for image selector  */
add_filter( 'dk_sanitize_images', 'dk_sanitize_enum', 10, 2 );

/*  Sanitization for textarea field */

add_filter( 'dk_sanitize_textarea', 'dk_sanitize_textarea' );
function dk_sanitize_textarea( $input ) {
	global $allowedposttags;	
	$output = wp_kses( $input, $allowedposttags);
	return $input;
}
/* File upload sanitization.  */ 
function dk_sanitize_upload( $input ) {
	$output = '';
	$filetype = wp_check_filetype( $input );
	if ( $filetype["ext"] ) {
		$output = esc_url( $input );
	}
	return $output;
}
add_filter( 'dk_sanitize_upload', 'dk_sanitize_upload' );

/* Sanitization for editor input. */
function dk_sanitize_editor( $input ) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$output = $input;
	}
	else {
		global $allowedtags;
		$output = wpautop( wp_kses( $input, $allowedtags) );
	}
	return $output;
}
add_filter( 'dk_sanitize_editor', 'dk_sanitize_editor' );

/* Sanitization of input with allowed tags and wpautotop.  */
function dk_sanitize_allowedtags( $input ) {
	global $allowedtags;
	$output = wpautop( wp_kses( $input, $allowedtags ) );
	return $output;
}

/* Sanitization of input with allowed post tags and wpautotop.  */
function dk_sanitize_allowedposttags( $input ) {
	global $allowedposttags;
	$output = wpautop( wp_kses( $input, $allowedposttags) );
	return $output;
}

/* Validates that the $input is one of the avilable choices  */
function dk_sanitize_enum( $input, $option ) {
	$output = '';
	if ( array_key_exists( $input, $option['options'] ) ) {
		$output = $input;
	}
	return $output;
}
function dk_sanitize_checkbox( $input ) {
	if ( $input ) {
		$output = 'Y';
	} else {
		$output = 'N';
	}
	return $output;
}
add_filter( 'dk_sanitize_checkbox', 'dk_sanitize_checkbox' );
?>