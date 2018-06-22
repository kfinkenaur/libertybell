<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 * @package Opportune
 */

get_header(); ?>

<div class="container">
  <div class="row">
	<div class="col-lg-8">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			// End of the loop.
			endwhile;
			?>
            </main>
        </div>
	  </div>
      <div class="col-lg-4">
	 	 	<?php get_sidebar( 'right' ); ?> 
      </div>
	</div>
</div>

<?php get_footer(); ?>
