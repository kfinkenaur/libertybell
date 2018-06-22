<?php
/**
 * Content Page Template
 *
 *
 * @file           content-page.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */
?>
<header class="entry-header">
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
</header><!-- .entry-header -->

<div class="entry-content">
	<?php the_content(); ?>
	<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'dk-responsive' ),
			'after'  => '</div>',
		) );
	?>
</div><!-- .entry-content -->
<footer class="entry-footer">
	<?php edit_post_link( __( 'Edit', 'dk-responsive' ), '<span class="edit-link">', '</span>' ); ?>
</footer><!-- .entry-footer -->