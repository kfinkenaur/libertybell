<?php
/**
 * Call to Action Sidebar 
 * @package Opportune
 */


if ( ! is_active_sidebar( 'cta' ) ) {
	return;
}
?>
<div id="cta-sidebar">            
    <aside class="widget-area" role="complementary">		             
        <?php dynamic_sidebar( 'cta' ); ?> 	
    </aside>
</div>

