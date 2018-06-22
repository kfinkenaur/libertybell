<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Market
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function market_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'market_jetpack_setup' );
