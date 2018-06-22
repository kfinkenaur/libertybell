<?php
/**
 * The bottom right header area
 *
 * @package panoramic
 */

if ( get_theme_mod( 'panoramic-header-bottom-right-menu' ) ) {
	wp_nav_menu( array( menu => get_theme_mod( 'panoramic-header-bottom-right-menu' ) ) );
}
?>
