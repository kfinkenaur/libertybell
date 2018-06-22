<?php
/**
 * The template for displaying all single posts.
 *
 * 
 * Single Template
 *
 *
 * @file           single.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */

get_header(); ?>
<div id="primary" class="main-content-area <?php echo implode( ' ', dk_content_classes() ); ?>">
	<div class="main-content-wrapper"> 
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>			

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>
		</article><!-- #post-## -->
		<?php dk_post_nav(); ?>
	</div><!-- #main -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>