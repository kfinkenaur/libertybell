<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package Rhyme
 */
get_header(); ?>
	<div id="main" class="<?php echo of_get_option('layout_settings');?>">
		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<div id="content-box">
				<div id="post-body">
					<div <?php post_class('post-single'); ?>>
						<h1 id="post-title" <?php post_class('entry-title'); ?>><?php the_title(); ?> </h1>
						<?php if ( has_post_thumbnail() ) { ?>
							<div class="thumb-wrapper">
								<?php the_post_thumbnail('full'); ?>
							</div><!--thumb-wrapper-->
						<?php } ?>
						<div id="article">
							<?php the_content(); 
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'rhyme' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							) );
							
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template( '', true );
							} ?>
							
						</div><!--article-->
					</div><!--post-single-->
				</div><!--post-body-->
			</div><!--content-box-->
			<?php if ( of_get_option('page_sidebar_position') != 'none' ) { ?>
				<div class="sidebar-frame">
					<div class="sidebar">
						<?php get_sidebar(); ?>
					</div>
				</div>
			<?php } ?>
		<?php endwhile; ?>
	</div><!--main-->
<?php get_footer(); ?>