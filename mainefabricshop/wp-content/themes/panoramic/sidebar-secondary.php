<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package panoramic
 */

if ( ! is_active_sidebar( 'secondary-sidebar' ) ) {
?>
	<div id="secondary" class="widget-area" role="complementary">
		<div class="notice">
			<?php _e( 'Add widgets to the Secondary Sidebar at Appearance > Widgets', 'panoramic' ); ?>
		</div>
	</div>
<?php	
	return;
} else {
?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'secondary-sidebar' ); ?>
	</div><!-- #secondary -->
<?php
}
?>