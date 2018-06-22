<?php
/**
 * Template part for displaying single posts.
 * @package Opportune
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/Article">

		<?php if( esc_attr(get_theme_mod( 'show_single_thumbnail', 1 ) ) ) :           
             opportune_post_thumbnail(); 
         endif; ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>

		<div class="entry-meta">
		<?php opportune_posted_meta(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->


	<div class="entry-content">
		<?php the_content(); ?>
                
                <?php  // For content split into multiple pages
		opportune_multipage_nav();  ?>
                
		<?php // For post navigation with next and previous
			if( esc_attr(get_theme_mod( 'show_next_prev', 1 ) ) ) {
			opportune_post_pagination();	
			}
		?>
                
	</div><!-- .entry-content -->

	<footer class="entry-footer">
    
		<?php opportune_entry_footer(); ?>   
                     	
		<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?> 
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

