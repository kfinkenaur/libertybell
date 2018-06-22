<?php
/**
 * The template for displaying search results pages.
 *
 * @package HowlThemes
 */

get_header(); ?>
<div class="main-outer container">
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main" style="margin-top: -20px;" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

		<?php if ( have_posts() ) : ?>

			<div class="archive-description">
				<h2 class="page-title"><?php printf( __( 'Search Results for: %s', 'aqueduct' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
			</div>

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

			<div class="paging">
        <?php the_posts_pagination(); ?>

</div>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
