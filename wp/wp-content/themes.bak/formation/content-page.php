<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Formation
 * @since Formation 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Formation' ), 'after' => '</div>' ) ); ?>
        <footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'Formation' ), '<span class="edit-link">', '</span>' ); ?>
        </footer><!-- .entry-meta -->
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
