<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 * @package Opportune
 */

get_header(); ?>
                
<div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        
                <div class="container">
                        <div class="row">  
                        
							<?php if  ( esc_attr(get_theme_mod('blog_style','top-featured-right')) == 'top-featured-left' ) : get_sidebar( 'left' ); endif; ?>
                                                                                
                             <div class="col-lg-8 <?php echo esc_attr(get_theme_mod( 'blog_style', 'top-featured-right' )); ?>">
                                                            
                                    <?php if ( have_posts() ) : ?>
                                    
                                    <header class="page-header">
                                    <?php
                                        opportune_the_archive_title( '<h1 class="page-title">', '</h1>' );
                                        opportune_archive_description( '<div class="taxonomy-description">', '</div>' );
                                        ?>
                                    </header>
                    
                                    <div class="posts-layout">
                                        <?php 
                                        while ( have_posts() ) : the_post(); 
                                       
                                            get_template_part( 'template-parts/content', get_post_format() );
                                        
                                        endwhile; 
                                        ?>
                                    </div>
                                            
                                    <?php the_posts_navigation(); ?>
                                    
                        <?php else : 
                                get_template_part( 'template-parts/content', 'none' ); 
                          endif; 
                          ?>
                       </div>
                                      
                        <?php if (esc_attr(get_theme_mod('blog_style','top-featured-right')) == 'top-featured-right' ) :
                            get_sidebar( 'right' );
                        endif;  ?>
                                              
                        </div>
                </div>
        
        </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
