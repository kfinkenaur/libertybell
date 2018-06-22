<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package HowlThemes
 */

get_header(); ?>
<div class="container">
			<section class="error-404 not-found">
				<header class="page-header">
<h3><div class="fourzerofour">4<i class="fa fa-meh-o"></i>4</div><?php _e('Page not Found', 'aqueduct'); ?></h3>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'aqueduct' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		
</div>
<?php get_footer(); ?>
