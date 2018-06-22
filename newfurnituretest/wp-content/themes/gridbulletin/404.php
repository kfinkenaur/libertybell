<?php
/*
 * The template for displaying 404 not found.
 */
?>

<?php get_header(); ?>
<div id="content">
<div class="article">

		<h3 class="page-title"><?php _e( 'Nothing Found', 'gridbulletin' ); ?></h3>
			<p><?php _e('Sorry, no posts matched your criteria.', 'gridbulletin'); ?></p>
		<?php get_search_form(); ?>

</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
