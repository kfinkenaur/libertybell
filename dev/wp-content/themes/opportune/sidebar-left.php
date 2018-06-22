<?php
/**
 * Left sidebar column for the blog and pages. 
 *
 * @package Opportune
 * @since Opportune 1.0.0
 */


if (   ! is_active_sidebar( 'pageleft'  )
	&& ! is_active_sidebar( 'blogleft' ) 
	)
	return;

if ( is_page() ) {
	
	echo '<aside id="left-sidebar" class="widget-area" role="complementary">';    
	dynamic_sidebar( 'pageleft' );
	echo '</aside>';
	
} else {
	
	echo '<div class="col-lg-4"><aside id="left-sidebar" class="widget-area" role="complementary">';   
	dynamic_sidebar( 'blogleft' );
	echo '</aside></div>';
	
}
?>