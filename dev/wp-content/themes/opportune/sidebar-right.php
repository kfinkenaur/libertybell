<?php
/**
 * Right sidebar column. 
 *
 * @package Opportune
 * @since Opportune 1.0.0
 */


if (   ! is_active_sidebar( 'blogright'  )
	&& ! is_active_sidebar( 'pageright' ) 
	)
	return;

if ( is_page() ) {   
	
	echo '<aside id="right-sidebar" class="widget-area" role="complementary">';
	dynamic_sidebar( 'pageright' );	
	echo '</aside>';	

} else {

	echo '<div class="col-lg-4"><aside id="right-sidebar" class="widget-area" role="complementary">';  
	dynamic_sidebar( 'blogright' );
	echo '</aside></div>';
		
}
?>