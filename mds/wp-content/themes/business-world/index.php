<?php  get_header();
global  $wdwt_front;
?>
</header>
<div class="container clear-div">
	<?php 
		if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
			<aside id="sidebar1">
				<div class="sidebar-container clear-div">
					<?php dynamic_sidebar( 'sidebar-1' );	?>
				</div>
			</aside>
	<?php } ?>
	<div id="blog" class="clear-div">
		<?php $wdwt_front -> content_posts_for_home(); ?>		
	</div>
	<?php 
	  if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
		<aside id="sidebar2">
			<div class="sidebar-container clear-div">
			  <?php  dynamic_sidebar( 'sidebar-2' ); 	?>
			</div>
		</aside>
	<?php } ?>
</div>
<?php get_footer(); ?>