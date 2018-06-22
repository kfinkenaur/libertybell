<?php
/**
 * Breadcrumbs Sidebar 
 * @package  Opportune
 */


if ( ! is_active_sidebar( 'breadcrumbs' ) ) {
	return;
}
?>
<div class="container">
  <div class="row">
    
    <div id="breadcrumbs-sidebar" class="col-lg-12">            
      <aside class="widget-area" role="complementary">		             
        <?php dynamic_sidebar( 'breadcrumbs' ); ?> 	
        </aside>
    </div>
    
  </div>
</div>
