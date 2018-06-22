<div id="secondary" class="widget-area <?php echo implode( ' ', dk_sidebar_classes() ); ?>" role="complementary">
<?php
	if ( is_active_sidebar( 'left-sidebar' ) )  {
	dynamic_sidebar( 'left-sidebar' ); 
	} else {
	?>
	<div class="widget-wrapper widget_archive" id="archives">
		<div class="widget-title">
			<h3><?php _e( 'Archives', 'dk_responsive' ); ?></h3>
		</div>
		<ul>
			<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
		</ul>
	</div>
	<?php } ?>
</div><!-- #secondary -->
