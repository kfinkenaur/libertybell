<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @package Rhyme
 */
get_header(); ?>
	<div id="main" class="<?php echo of_get_option('layout_settings');?>">
		<div id="content-box">
			<div id="post-body">
				<h1><?php _e('Nothing Found!', 'rhyme'); ?></h1>
				<div class="sorry"><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'rhyme'); ?></div>
				<?php get_search_form(); ?>
			</div><!--post-body-->
		</div><!--content-box-->
		<div class="sidebar-frame">
			<div class="sidebar">
				<?php get_sidebar(); ?>
			</div><!--sidebar-->
		</div><!--sidebar-frame-->
	</div><!--main-->
<?php get_footer(); ?>