<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Rhyme
 */
get_header(); ?>
	<div id="main" class="<?php echo of_get_option('layout_settings');?>">
		<?php 
		if ( have_posts() ) : ?>
			<div class="clear"></div>
			<div class="standard-posts-wrapper">
				<div class="posts-wrapper">	
				<?php 
				// Start the Loop.
				while ( have_posts() ) : the_post();		
					get_template_part('content');
				endwhile; 
				
				if (of_get_option('simple_paginaton') == '1') {
					
					// Displays links for next and previous pages. ?>
					
					<div class="simple-pagination">
						<?php posts_nav_link();	?>
					</div> <?php
					
				} else {
				
					// Previous/next post navigation.
					rhyme_paging_nav();
					
				}
				
				?>
				</div>
			</div>
			<div class="sidebar-frame">
				<div class="sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>
		<?php 
		else: ?>
			<?php get_template_part( 'content', 'none' );
		endif; ?>
	</div><!--main-->
<?php get_footer(); ?>