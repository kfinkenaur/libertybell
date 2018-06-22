<?php
/**
 * The template for displaying all single posts.
 * @package Opportune
 */

get_header(); ?>    
    
 
<div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        
                <div class="container">
                        <div class="row"> 
 
                    <?php if ( esc_attr(get_theme_mod('single_layout','right-column')) == 'left-column' ) :
						get_sidebar( 'left' );
					endif; ?>
                        
                                <div class="col-lg-8 <?php echo esc_attr(get_theme_mod( 'single_layout', 'right-column' )); ?>">
                                		
										<?php while ( have_posts() ) : the_post(); ?>
                                        <?php get_template_part( 'template-parts/content', 'single' ); ?>
                                        
                            
                                        <?php
                                            // If comments are open or we have at least one comment, load up the comment template.
                                            if ( comments_open() || get_comments_number() ) :
                                                comments_template();
                                            endif;
                                        ?>
                            
                                    <?php endwhile; // End of the loop. ?>
                                    
                                </div>
 
 
 				<?php if ( esc_attr(get_theme_mod('single_layout','right-column')) == 'right-column' ) :
						get_sidebar( 'right' );
					endif;  ?>
 
 
                        </div>
                </div>
        
        </main><!-- #main -->
</div><!-- #primary --> 
 
 
 
 
 
 
 
    
    
    
    
    
<?php get_footer(); ?>
