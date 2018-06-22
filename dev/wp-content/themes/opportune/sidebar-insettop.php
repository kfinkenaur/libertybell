<?php

/**
 * Inset top sidebar 
 * @package Opportune
 * 
 */


if ( ! is_active_sidebar( 'insettop' ) ) {
	return;
}
?>

<div id="inset-top-sidebar">
    <div class="row">
        <div class="col-md-12">       
            <aside class="widget-area" role="complementary">		             
            	<?php dynamic_sidebar( 'insettop' ); ?> 	
            </aside> 
        </div>
    </div>
</div>