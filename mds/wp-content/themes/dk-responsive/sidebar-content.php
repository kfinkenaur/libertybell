<?php
/**
 * sidebar/content Template
 *
 *
 * @file           sidebar-content.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */
 
/* template name: sidebar/content */
get_header(); ?>
<div id="primary" class="main-content-area col-md-8 pull-right">
  <div class="main-content-wrapper"> 
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>
	   </article><!-- #post-## -->
     </div>
</div><!-- #primary -->
<div id="secondary" class="widget-area col-md-4" role="complementary">    
	<?php
		if ( is_active_sidebar( 'right-sidebar' ) )  {
			dynamic_sidebar( 'right-sidebar' ); 
		} else {
	?>
		<div class="widget-wrapper widget_archive" id="archives">
			<div class="widget-title">
				<h3><?php _e( 'Archives', 'dk_responsive' ); ?></h3>
			</div>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</div>
	<?php } ?>
</div><!-- #secondary -->
<?php get_footer(); ?>