<?php

/**
 * Inset bottom sidebar 
 * @package Opportune
 * 
 */


if ( ! is_active_sidebar( 'insetbottom' ) ) {
	return;
}
?>

<div id="inset-bottom-sidebar">
    <div class="row">
        <div class="col-md-12">       
            <aside class="widget-area" role="complementary">		             
            	<?php dynamic_sidebar( 'insetbottom' ); ?> 	
            </aside> 
        </div>
    </div>
</div>