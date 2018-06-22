<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package panoramic
 */

if ( ! is_active_sidebar( 'shop-sidebar' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'shop-sidebar' ); ?>
</div><!-- #secondary -->
