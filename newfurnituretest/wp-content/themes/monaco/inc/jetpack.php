<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package monaco
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function monaco_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'monaco_jetpack_setup' );
