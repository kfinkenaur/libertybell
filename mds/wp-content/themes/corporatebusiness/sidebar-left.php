<?php
/**
 * The sidebar containing the left widget area.
 *
 * @package CorporateBusiness
 */

if ( ! is_active_sidebar( 'sidebar-left' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-left' ); ?>
</div><!-- #secondary -->
