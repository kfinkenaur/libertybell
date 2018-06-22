<?php get_header();
global $post,$wdwt_front;
$business_world_meta_date = get_post_meta($post->ID,WDWT_META,TRUE); 


$show_featured_image = $wdwt_front->get_param('show_featured_image', $business_world_meta_date, false);
 ?>
</header>
<div class="container">
    <?php 
	   if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
			<aside id="sidebar1" >
				<div class="sidebar-container clear-div">			
					<?php  dynamic_sidebar( 'sidebar-1' ); 	?>
				</div>
			</aside>
	<?php } ?>	

    <div id="blog">
		 <?php 
			if(have_posts()) : while(have_posts()) : the_post(); ?>
			  <div class="single-post">
				 <h2  class="page-header"><?php the_title(); ?></h2>
			    <?php if ( has_post_thumbnail() && $show_featured_image) { ?>
						<div class="post-thumbnail-div post-thumbnail">
								<?php echo the_post_thumbnail('business-width'); ?>
						</div> 
			  	<?php } ?>
				 <div class="entry"><?php the_content(); ?></div>
			  </div>
			<?php endwhile; ?>
			   <div class="navigation">
					<?php posts_nav_link(); ?>
			   </div>
		<?php endif; ?>
		<div class="clear"></div>
		<?php
			if(comments_open()) {  ?>
				<div class="comments-template">
					<?php echo comments_template();	?>
				</div>
		<?php }	 ?>	
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