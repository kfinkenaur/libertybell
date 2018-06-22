<?php
/**
 * The template used for displaying page content in page.php
 * @package Opportune
 */

?>

<?php opportune_post_thumbnail(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/WebPage">
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
        <time class="entry-date" datetime="<?php the_date(); ?>" itemprop="datePublished" pubdate></time>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
                
		<?php  // For content split into multiple pages
		opportune_multipage_nav();  ?>
                
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php 
		if( esc_attr(get_theme_mod( 'show_edit', 1 ) ) ) : 
			edit_post_link( esc_html__( 'Edit', 'opportune' ), '<span class="edit-link">', '</span>' ); 	
		endif;
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

