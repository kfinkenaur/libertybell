<?php
/**
 * The template for displaying search results pages.
 *
 * 
 * Search Template
 *
 *
 * @file           search.php
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
			<?php if ( have_posts() ) : ?>			
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'dk-responsive' ), '<span>' . get_search_query() . '</span>' ); ?></h1>		

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'content', 'search' );
				?>

			<?php endwhile; ?>

			<?php dk_paging_nav(); ?>

			<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>
		</article><!-- #post-## -->
	</div>
</div><!-- #primary -->   
<?php get_sidebar(); ?>
<?php get_footer(); ?>