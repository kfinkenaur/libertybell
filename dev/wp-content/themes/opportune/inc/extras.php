<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 * @package Opportune
 */


/**
 * Adds custom classes to the array of body classes.
 */
function opportune_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'opportune_body_classes' );




/**
 * Move the More Link outside from the contents last summary paragraph tag.
 */
if ( ! function_exists( 'opportune_move_more_link' ) ) :
	function opportune_move_more_link($link) {
			$link = '<p class="read-more">'.$link.'</p>';
			return $link;
		}
	add_filter('the_content_more_link', 'opportune_move_more_link');
endif;

/**
 * Prevent page scroll after clicking read more to load the full post.
 */
if ( ! function_exists( 'opportune_remove_more_link_scroll' ) ) : 
	function opportune_remove_more_link_scroll( $link ) {
		$link = preg_replace( '|#more-[0-9]+|', '', $link );
		return $link;
		}
	add_filter( 'the_content_more_link', 'opportune_remove_more_link_scroll' );
endif;	

/**
 * Gives the flexibility to change the excerpt length from the Theme Customizer to the users choice.
 * Thanks to http://bavotasan.com/2009/limiting-the-number-of-words-in-your-excerpt-or-content-in-wordpress/
 *
 * To use a custom excerpt length in a template, use
 * <?php echo excerpt(25); ?>
 */ 
	function opportune_excerpt($limit) {
	  $excerpt = explode(' ', get_the_excerpt(), $limit);
	  if (count($excerpt)>=$limit) {
	    array_pop($excerpt);
	    $excerpt = implode(" ",$excerpt).'...';
	  } else {
	    $excerpt = implode(" ",$excerpt);
	  }	
	  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	  return $excerpt;
	}
	
/**
 * Special thanks to Justin Tadlock for this.
 * http://justintadlock.com/archives/2012/08/27/post-formats-quote
 */

function opportune_my_quote_content( $content ) {

	/* Check if we're displaying a 'quote' post. */
	if ( has_post_format( 'quote' ) ) {

		/* Match any <blockquote> elements. */
		preg_match( '/<blockquote.*?>/', $content, $matches );

		/* If no <blockquote> elements were found, wrap the entire content in one. */
		if ( empty( $matches ) )
			$content = "<blockquote>{$content}</blockquote>";
	}

	return $content;
}
add_filter( 'the_content', 'opportune_my_quote_content' );