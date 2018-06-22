<?php
/**
 * The top right header area
 *
 * @package panoramic
 */

if ( get_theme_mod( 'panoramic-header-top-bar-right-menu' ) ) {
	wp_nav_menu( array( menu => get_theme_mod( 'panoramic-header-top-bar-right-menu' ) ) );
}
?>