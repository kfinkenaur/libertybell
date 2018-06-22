<?php
/**
 * The template for displaying image attachments
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
			?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/Article">
                                
					<div class="entry-content">

						<div class="entry-attachment">
							<?php
								$image_size = apply_filters( 'opportune_attachment_size', 'large' );
								echo wp_get_attachment_image( get_the_ID(), $image_size );
							?>
                                                
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header><!-- .entry-header -->
                                        
							<?php if ( has_excerpt() ) : ?>
								<div class="entry-caption">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>

						</div>

						<?php
							the_content();
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'opportune' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'opportune' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							) );
						?>
					</div>

					<footer class="entry-footer">	
                                        
                                        <nav id="image-navigation" class="navigation image-navigation">
						<div class="nav-links">
							<div class="nav-previous">
							<?php 
								$prev =  '<span class="fa fa-arrow-circle-left"></span>';
								$next =  '<span class="fa fa-arrow-circle-right"></span>';
								previous_image_link( false, $prev); 
							?>
                                                        </div>
							<div class="nav-next">
								<?php next_image_link( false, $next); ?>
                                                        </div>
						</div>
					</nav>
						
						<?php if( esc_attr(get_theme_mod( 'show_edit', 1 ) ) ) {
							edit_post_link( esc_html__( 'Edit this media', 'opportune' ), '<span class="edit-link">', '</span>' ); 
						}
						?>
					</footer>
				</article>

				<?php
				// End the loop.
				endwhile;
			?>

                                </main>
                        </div>
                
                </div>       
        </div>  
              
</div>

<?php get_footer(); ?>
