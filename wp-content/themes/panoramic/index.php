<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package panoramic
 */

get_header(); ?>
    
    <?php if ( ! is_front_page() ) : ?>
        
        <?php if ( function_exists( 'bcn_display' ) ) : ?>
        <div class="breadcrumbs">
            <?php bcn_display(); ?>
        </div>
        <?php endif; ?>
    
    <?php endif; ?>

	<div id="primary" class="content-area <?php echo !is_active_sidebar( 'sidebar-1' ) ? 'full-width' : ''; ?>">
		<main id="main" class="site-main" role="main">
        
        	<?php get_template_part( 'library/template-parts/page-title' ); ?>

        	<div class="archive-container">
        
				<?php if ( have_posts() ) : ?>
				
					<?php
					$panoramic_blog_layout 				 = get_theme_mod( 'panoramic-blog-layout', customizer_library_get_default( 'panoramic-blog-layout' ) );
					$panoramic_blog_masonry_grid_columns = get_theme_mod( 'panoramic-blog-masonry-grid-border', customizer_library_get_default( 'panoramic-blog-masonry-grid-border' ) );
					
					if ( $panoramic_blog_layout == 'blog-post-masonry-grid-layout' ) {
					?>
					<div class="masonry-grid-container loading <?php echo $panoramic_blog_masonry_grid_columns ? 'bordered' : ''; ?>">
					<?php
					}
					?>
		
					<?php while ( have_posts() ) : the_post(); ?>
		
						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'library/template-parts/content', get_post_format() );
						?>
		
					<?php endwhile; ?>
		
					<?php
					if ( $panoramic_blog_layout == 'blog-post-masonry-grid-layout' ) {
					?>
					</div>
					<?php
					}
					?>
					
					<?php panoramic_paging_nav(); ?>
		
				<?php else : ?>
		
					<?php get_template_part( 'library/template-parts/content', 'none' ); ?>
		
				<?php endif; ?>
				
			</div><!-- .archive-container -->

		</main><!-- #main -->
	</div><!-- #primary -->

    <?php get_sidebar(); ?>
<?php get_footer(); ?>
