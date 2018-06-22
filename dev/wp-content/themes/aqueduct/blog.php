<?php
/**
 * @package SherPress
 */

get_header();
?>

<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main" style="margin-top: -10px;" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

			<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>


		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

<div class="paging">
        <?php the_posts_pagination(); ?>
</div>
		</main><!-- #main -->
	</div><!-- #primary -->
	