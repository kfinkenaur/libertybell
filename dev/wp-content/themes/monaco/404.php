<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Monaco
 */

get_header(); ?>

	<div id="primary" class="full-width-content">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'Monaco' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'Monaco' ); ?></p>
				</div><!-- .page-content -->
				<aside id="search" class="widget widget_search">
					<?php get_search_form(); ?>
				</aside>

			</section><!-- .error-404 -->


		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer(); ?>