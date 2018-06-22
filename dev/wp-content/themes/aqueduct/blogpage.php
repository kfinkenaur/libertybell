<?php

/*
Template Name: Blog
*/
get_header(); 
?>

<div class="main-outer container">
	<div id="primary" class="content-area" style="margin-top: -10px;">
		<main id="main" class="site-main" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

<?php query_posts('post_type=post&post_status=publish&posts_per_page=10&paged='. get_query_var('paged')); ?>


<?php if(have_posts()): while(have_posts()): the_post(); ?>

<?php get_template_part( 'content', get_post_format() ); ?>

<?php endwhile;?>
<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

<div class="paging">
    <?php the_posts_pagination(); ?>
</div>

	</main><!-- #main -->
	</div><!-- #primary -->
	
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
