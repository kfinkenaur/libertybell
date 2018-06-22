<?php
get_header(); 
global $wdwt_front;
?>
</header>
<div class="container clear-div">
    <?php
        if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
			<aside id="sidebar1" >
				<div class="sidebar-container clear-div">			
				<?php  dynamic_sidebar( 'sidebar-1' ); 	?>	
				</div>
			</aside>
	<?php }  ?>
	<div id="blog" class="blog ">
	  <div class="imgBox page_404">
		 <p class="content-404"><?php _e('You are trying to reach a page that does not exist here. Either it has been moved or you typed a wrong address. Try searching:', "business-world"); ?></p>
		<?php get_search_form(); ?>
			<div class="image_404"><img src="<?php echo get_template_directory_uri().'/images/404.png' ?>" title="404" /></div>		     
		</div>
	</div>
    <?php 
	    if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
		<aside id="sidebar2"> 
			<div class="sidebar-container clear-div">
			   <?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div>
		</aside>
	<?php }	?>
</div>
<?php
get_footer(); ?>