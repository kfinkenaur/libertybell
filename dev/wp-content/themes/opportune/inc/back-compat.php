<?php
/**
 * Opportune back compat functionality
 *
 * Prevents Opportune from running on WordPress versions prior to 4.1,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.1.
 *
 * Special thanks and credit to the default theme Twenty Fifteen 
 *
 * @package Opportune
 */

/**
 * Prevent switching to Opportune on old versions of WordPress.
 * Switches to the default theme.
 *
 */
function opportune_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'opportune_upgrade_notice' );
}
add_action( 'after_switch_theme', 'opportune_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Opportune on WordPress versions prior to 4.1.
 */
function opportune_upgrade_notice() {
	$message = sprintf( esc_html__( 'Opportune requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'opportune' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 4.1.
 */
function opportune_customize() {
	wp_die( sprintf( esc_html__( 'Opportune requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'opportune' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'opportune_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 4.1.
 */
function opportune_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( esc_html__( 'Opportune requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'opportune' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'opportune_preview' );
