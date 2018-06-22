<?php
/**
 * A template for the blog home page.
 *
 * This template is used when a home.php file exists, otherwise it uses the index.php template.
 * This template will load your blog post summaries.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package Opportune
 */


get_header(); ?>

<div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        
                <div class="container">
                        <div class="row">
                        
                   <?php if  ( esc_attr(get_theme_mod('blog_style','top-featured-right')) == 'top-featured-left' ) :
						get_sidebar( 'left' );
					endif; ?>
                        
                    <div class="col-lg-8 <?php echo esc_attr(get_theme_mod( 'blog_style', 'top-featured-right' )); ?>">
                                
						<?php if ( have_posts() ) : ?>
                                        
                                        <?php if ( is_home() && ! is_front_page() ) : ?>
                                                <header>
                                                	<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                                                </header>
                                        <?php endif; ?>
                                        
                                        <div class="posts-layout">
									
                                            <?php while ( have_posts() ) : the_post(); ?>
                                            
                                            <?php  get_template_part( 'template-parts/content', get_post_format() ); ?>
                                            
                                            <?php endwhile; ?>
                                        
                                        </div>
                                        
                                        <?php opportune_blog_pagination(); ?>
                                        
                                        <?php else : ?>
                                        	<?php get_template_part( 'template-parts/content', 'none' ); ?>
                                        <?php endif; ?>
                                
                  </div>
                                
				<?php if (esc_attr(get_theme_mod('blog_style','top-featured-right')) == 'top-featured-right' ) :
						get_sidebar( 'right' );
					endif;  ?>
                                
                        </div>
                </div>
        
        </main>
</div>

<?php get_footer(); ?>
