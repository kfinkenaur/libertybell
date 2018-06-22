<?php
/**
 * The template for displaying quote post formats
 *
 * 
 * @package Opportune
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">


	<header class="entry-header">

        
      </header>
        
	<div class="entry-content">
	<?php the_content(); ?>
	</div>
	

	<footer class="entry-footer">
		<?php if( esc_attr(get_theme_mod( 'show_edit', 1 ) ) ) {
							edit_post_link( esc_html__( 'Edit this quote', 'opportune' ), '<span class="edit-link">', '</span>' ); 
						}
						?>
	</footer>

</article>

