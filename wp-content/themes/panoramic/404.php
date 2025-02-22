<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package panoramic
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<header class="entry-header">
				<h1 class="page-not-found"><?php echo wp_kses_post( get_theme_mod( 'panoramic-website-text-404-page-heading', customizer_library_get_default( 'panoramic-website-text-404-page-heading' ) ) ); ?></h1>
			</header><!-- .page-header -->
					
			<div class="entry-content">
				<p class="centered">
					<?php echo wp_kses_post( get_theme_mod( 'panoramic-website-text-404-page-text', customizer_library_get_default( 'panoramic-website-text-404-page-text' ) ) ); ?>
				</p>
				
				<p class="centered">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button"><?php _e( 'Back to Homepage', 'panoramic' ); ?></a>
				</p>
			</div><!-- .page-content -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
