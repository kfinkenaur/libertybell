<?php
/**
 * Template Name: Template Full Width
 * @package Opportune
*/

get_header(); ?>

<div class="container">
        <div class="row">	        
                <div class="col-lg-12">
                
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
        </div>  
              
</div>
    
<?php get_footer(); ?>    