<?php

/**
 * Sidebar for the banner area 
 * @package Opportune
 *  
 */


if ( ! is_active_sidebar( 'banner' ) ) {
	return;
}
?>

<aside id="banner-sidebar" role="complementary">
    <div id="banner"><?php dynamic_sidebar( 'banner' ); ?></div>
</aside>

