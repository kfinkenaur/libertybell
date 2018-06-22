<?php
/*
 * The template for displaying search results.
 */
?>

<?php get_header(); ?>
<div id="content">
	<?php if ( have_posts() ) : ?>

		<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'gridbulletin' ), get_search_query() ); ?></h1>
			
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content-list' ); ?>
		<?php endwhile; ?>

		<div class="post-nav">
			<?php next_posts_link(); ?>
			<?php previous_posts_link(); ?>
		</div>

	<?php else: ?>
		<h1 class="page-title"><?php _e( 'Nothing Found', 'gridbulletin' ); ?></h1>
		<p><?php _e('Sorry, no posts matched your criteria.', 'gridbulletin'); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>