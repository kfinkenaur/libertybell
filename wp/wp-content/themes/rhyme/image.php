<?php
/**
 * The template for displaying image attachments
 *
 * @package Rhyme
 */

// Retrieve attachment metadata.
$metadata = wp_get_attachment_metadata();

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
							<?php rhyme_the_attached_image(); ?>
							<?php the_content(); 
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'rhyme' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							) ); ?>
							
						<ul class="link-pages">	
							<li class="next-link"><?php previous_image_link( '%link', '<i class="fa fa-chevron-right"></i><strong>'.__('Previous', 'rhyme').'</strong> <span>IMAGE</span>' ); ?></li>
							<li class="previous-link"><?php next_image_link( '%link', '<i class="fa fa-chevron-left"></i><strong>'.__('Next', 'rhyme').'</strong> <span>IMAGE</span>' ); ?></li>
						</ul>
							
							<?php
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