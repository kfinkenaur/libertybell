<?php
/**
 * The template for displaying search results pages.
 * @package Opportune
 */

get_header(); ?>

<div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        
                <div class="container">
                
                        <div class="row">
                          <div class="col-lg-12">
                          
  			<?php if ( have_posts() ) : ?>
                            
                            <header class="page-header">
                              <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'opportune' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                            </header><!-- .page-header -->
                            
                            <?php /* Start the Loop */ ?>
                            <?php while ( have_posts() ) : the_post(); ?>
                            
                            <?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );
				?>
                            
                            <?php endwhile; ?>
                            
                            <?php opportune_blog_pagination(); ?>
                            
                            <?php else : ?>
                            
                            <?php get_template_part( 'template-parts/content', 'none' ); ?>
                            
                            <?php endif; ?>
                          </div>
                
                  </div>
                </div>
                

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
