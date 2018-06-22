<?php
/**
 * The template for displaying image post formats
 * @package Opportune
 * 
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">

	<header class="entry-header">
          
        <?php // Check for featured image

		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title(), 'itemprop' => "image"));
			echo '<div class="featured-image">';
			echo '<div class="image-title">';
			  opportune_entry_titles(); 
			echo '</div><div class="image-meta">';
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
			opportune_posted_on();
			 if( esc_attr(get_theme_mod( 'show_edit', 1 ) ) ) {
							edit_post_link( esc_html__( 'Edit this post', 'opportune' ), ' <span class="edit-link">', '</span>' ); 
						}
						
			echo '</div></div>';
		}
	?>
          
	<?php // If no featured image
        
                if ( !has_post_thumbnail() ) {
                        opportune_entry_titles(); 
                echo '<div class="image-meta">';
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
                        opportune_posted_on();
			if( esc_attr(get_theme_mod( 'show_edit', 1 ) ) ) {
							edit_post_link( esc_html__( 'Edit this post', 'opportune' ), ' <span class="edit-link">', '</span>' ); 
						}
                echo '</div>';
                }
        ?>
      </header>


  <div class="entry-content">

 		    <?php 
                    // This loads your choice of content or an excerpt
                    
                                $moreicon = '<span class="fa fa-arrow-circle-right read-more-icon"></span>';
                                $excerptcontent = esc_attr(get_theme_mod( 'excerpt_content', 'content' ));
                                $excerptsize = esc_attr(get_theme_mod( 'excerpt_limit', '50' ));
                                         switch ($excerptcontent) {
                                                case "content" :
                                                        the_content( $moreicon );
                                                break;
                                                case "excerpt" : 
                                                        echo '<p>' . opportune_excerpt( $excerptsize ) . '</p>' ;
                                                        echo '<p class="read-more"><a href="' . get_permalink() . '" itemprop="url">' . $moreicon . '</a>' ;
                                                break;
                                }
                          // For content split into multiple pages
                                opportune_multipage_nav();  
                        ?>
  </div>
  
  <footer class="entry-footer">  </footer>
  
</article>
