<?php
/**
 * @package panoramic
 */
global $featured_image_classes, $panoramic_blog_layout;

$post_classes = array();
$panoramic_blog_layout = get_theme_mod( 'panoramic-blog-layout', customizer_library_get_default( 'panoramic-blog-layout' ) );

$post_classes[] = $panoramic_blog_layout;

if ( has_post_thumbnail() ) {
	require get_template_directory() . '/library/includes/set-featured-image-css-classes.php';
} else {
	$post_classes[] = 'no-featured-image';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( implode( ' ', $post_classes ) ); ?>>
    
    <?php
	if ( has_post_thumbnail() ) {
		get_template_part( 'library/template-parts/featured-image' );
	}
    ?>

    <div class="post-loop-content">
    
    	<header class="entry-header">
    		<?php
    		if ( get_theme_mod( 'panoramic-blog-archive-display-post-titles', customizer_library_get_default( 'panoramic-blog-archive-display-post-titles' ) ) ) {
    			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
    		}	
    		?>

    		<?php if ( 'post' == get_post_type() ) : ?>
    		<div class="entry-meta">
    			<?php panoramic_posted_on(); ?>
    		</div><!-- .entry-meta -->
    		<?php endif; ?>
    	</header><!-- .entry-header -->

    	<div class="entry-content">
    		<?php
				if ( get_theme_mod( 'panoramic-blog-archive-layout', 'panoramic-blog-archive-layout-full' ) == 'panoramic-blog-archive-layout-full' ) :
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'panoramic' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );
				else :
	    			/* translators: %s: Name of current post */
	                the_excerpt();
				endif;
    		?>

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
    
    </div>
    
    <div class="clearboth"></div>
</article><!-- #post-## -->