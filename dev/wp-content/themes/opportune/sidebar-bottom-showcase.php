<?php
/**
 * A full width sidebar at the bottom of the page 
 * @package Opportune
 * 
 */

if (   ! is_active_sidebar( 'bottom-showcase'  )	)
		return;
	// If we get this far, we have widgets. Let do this.
?>
<aside id="bottom-showcase-sidebar" class="widget-area clearfix" role="complementary">
                    <?php dynamic_sidebar( 'bottom-showcase' ); ?>
</aside>
