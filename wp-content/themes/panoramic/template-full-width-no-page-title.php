<?php
/**
 * Template Name: Full Width, No Page Title
 *
 */
get_header(); ?>

    <?php if ( ! is_front_page() ) : ?>
    
        <?php if ( function_exists( 'bcn_display' ) ) : ?>
        <div class="breadcrumbs">
            <?php bcn_display(); ?>
        </div>
        <?php endif; ?>
        
    <?php endif; ?>

	<div id="primary" class="content-area <?php echo esc_attr( get_theme_mod( 'panoramic-rpwe-site-content-layout', customizer_library_get_default( 'panoramic-rpwe-site-content-layout' ) ) ); ?>">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'library/template-parts/content', 'page' ); ?>

				<?php
					// If comments are open load up the comment template
					if ( comments_open() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>