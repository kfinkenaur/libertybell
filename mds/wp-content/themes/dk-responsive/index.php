<?php
/**
 * Index Template
 *
 *
 * @file           index.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}
 
get_header(); ?>
<div id="primary" class="main-content-area <?php echo implode( ' ', dk_content_classes() ); ?>">
<div class="main-content-wrapper"> 
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

			<?php dk_paging_nav(); ?>

		    <?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		   <?php endif; ?>
	         
        </div>
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
