<?php
/**
 * @package panoramic
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
	<header class="entry-header">
    	<?php
    	if ( get_theme_mod( 'panoramic-layout-display-post-titles', customizer_library_get_default( 'panoramic-layout-display-post-titles' ) ) ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		}
		?>

		<div class="entry-meta">
			<?php panoramic_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
    
    <?php if( has_post_thumbnail() && get_theme_mod( 'panoramic-blog-featured-image', customizer_library_get_default( 'panoramic-blog-featured-image' ) ) ): ?>
        <div class="entry-thumbnail"><?php the_post_thumbnail( 'full' ) ?></div>
    <?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'panoramic' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php panoramic_entry_footer(); ?>
	</footer><!-- .entry-footer -->
    
</article><!-- #post-## -->
