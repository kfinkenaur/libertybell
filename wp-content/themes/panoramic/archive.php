<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package panoramic
 */

get_header(); ?>
    
    <?php if ( function_exists( 'bcn_display' ) ) : ?>
        <div class="breadcrumbs">
            <?php bcn_display(); ?>
        </div>
    <?php endif; ?>

	<div id="primary" class="content-area <?php echo !is_active_sidebar( 'sidebar-1' ) ? 'full-width' : ''; ?>">
		<main id="main" class="site-main" role="main">
            
			<header class="page-header">
				<?php
					if ( get_theme_mod( 'panoramic-layout-display-page-titles', customizer_library_get_default( 'panoramic-layout-display-page-titles' ) ) ) :
						the_archive_title( '<h1 class="page-title">', '</h1>' );
					endif;
					
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->
			
			<div class="archive-container">
			
				<?php if ( have_posts() ) : ?>
			
					<?php
					$panoramic_blog_layout 			 	= get_theme_mod( 'panoramic-blog-layout', customizer_library_get_default( 'panoramic-blog-layout' ) );
					$panoramic_blog_masonry_grid_border = get_theme_mod( 'panoramic-blog-masonry-grid-border', customizer_library_get_default( 'panoramic-blog-masonry-grid-border' ) );
					
					if ( $panoramic_blog_layout == 'blog-post-masonry-grid-layout' ) {
					?>
					<div class="masonry-grid-container loading <?php echo $panoramic_blog_masonry_grid_border ? 'bordered' : ''; ?>">
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
