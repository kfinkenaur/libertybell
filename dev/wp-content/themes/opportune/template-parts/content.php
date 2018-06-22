<?php
/**
 * Template part for displaying posts.
 * @package Opportune
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">

<?php // Check for featured image

if ( has_post_thumbnail() ) {
	
	echo '<div class="featured-image-wrapper"><div class="featured-image">';
	the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title(), 'itemprop' => "image"));
	echo '<div class="post-date">', opportune_posted_on() ,  '</div></div></div>';
}
?>

                <div class="summary-wrapper">
              
                <header class="entry-header">
                	<?php // Check for featured image
				if ( ! has_post_thumbnail() ) {
					echo '<div class="post-date-no-thumbnail">', opportune_posted_on() ,  '</div>';
				}
			?>
               		<?php  opportune_entry_titles(); ?>		
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
        
                <footer class="entry-footer">
                        
                </footer>
        
        
                </div>
                

</article>

<div class="article-separator"></div>
