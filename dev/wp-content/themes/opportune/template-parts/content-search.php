<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 * @package Opportune
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php opportune_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php 
		$excerptsize = esc_attr(get_theme_mod( 'excerpt_limit', '50' ));
		$moreicon = '<span class="fa fa-arrow-circle-right read-more-icon"></span>';
		
		 echo '<p>' . opportune_excerpt( $excerptsize ) . '</p>' ;
                                                        echo '<p class="read-more"><a href="' . get_permalink() . '" itemprop="url">' . $moreicon . '</a>' ;
		?>
                
                
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php opportune_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

