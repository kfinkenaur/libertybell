<?php
/**
 * The template for displaying status post formats
 *
 * 
 * @package Opportune
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">


	<header class="entry-header box vertical-align-middle">
          <?php echo get_avatar( get_the_author_meta( 'ID' ), 65 ); ?>
          
             <div class="status-title">
            <?php 
                if ( is_single() ) :
                        
                        echo '<h1 class="entry-title" itemprop="name">';		
                                if(the_title( '', '', false ) !='') the_title(); 
                                        else esc_html_e('Untitled', 'opportune'); 
                        echo '</h1>';
                          
                 else :
		             
                        echo '<h2 class="entry-title" itemprop="name"><a href="' .esc_url( get_permalink() ) .'">';		
                        if(the_title( '', '', false ) !='') the_title(); 
                                else esc_html_e('Untitled', 'opportune'); 
                        echo '</a></h2>';
                          
                    endif;
                    ?>
            <div class="status-meta">             
              <?php 
			if( esc_attr(get_theme_mod( 'show_format_label', 1 ) ) ) : 
			
			$format = get_post_format();
				if ( current_theme_supports( 'post-formats', $format ) ) {
					printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>&nbsp;&#8211;&nbsp;',
					sprintf( '<span class="screen-reader-text">%s </span>', esc_html_x( 'Format', 'Used before post format.', 'opportune' ) ),
					esc_url( get_post_format_link( $format ) ),
					esc_html(get_post_format_string( $format ) )
				);
			}
			endif;
	 		?> 
              <?php opportune_posted_on(); ?>      
            </div>
          </div>
        
      </header>
        
	<div class="entry-content">
	<?php the_content(); ?>
	</div>
	

	<footer class="entry-footer">
		<?php if( esc_attr(get_theme_mod( 'show_edit', 1 ) ) ) {
							edit_post_link( esc_html__( 'Edit this post', 'opportune' ), '<span class="edit-link">', '</span>' ); 
						}
						?>
	</footer>

</article>

