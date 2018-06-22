<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Rhyme
 */
get_header(); ?>
	<div id="main" class="<?php echo of_get_option('layout_settings'); ?>">
	<?php 
		if (is_front_page() && ! is_paged()) {
			
			if (of_get_option('image_slider_on') == '1') {
				
				if (of_get_option('default_slider') == 'refine') { rhyme_refine_slide(); }
				
				if (of_get_option('default_slider') == 'flex') { rhyme_flex_slider(); }
				
			}
			
			if ( of_get_option('featured_posts_on') == '1') {
				
				get_template_part( 'featured', 'posts' );
			
			}
		
			
			if (of_get_option('about_section_on') == '1') {
			
				rhyme_about_section();
				
			}
		
			if (of_get_option('content_boxes_section_on') == '1') {
			
				rhyme_content_boxes();
				
			}
			
			if (of_get_option('blog_posts_on') == '1') {
			
				get_template_part( 'content', 'posts' );
				
			}
			
		} else {
		
			get_template_part( 'content', 'posts' );
			
		} ?>

	</div><!--main-->
<?php get_footer(); ?>