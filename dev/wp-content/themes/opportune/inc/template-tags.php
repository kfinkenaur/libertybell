<?php
/**
 * Custom template tags for this theme.
 * Eventually, some of the functionality here could be replaced by core features.
 * @package Opportune
 */



/**
 * Header titles
 *
 * Creates the appropriate title based on the page.
 * Adds Untitled if no title is provided by the author.
*/

if ( ! function_exists( 'opportune_entry_titles' ) ) :

function opportune_entry_titles() { 
    
if ( is_single() ) :
	
        echo '<h1 class="entry-title" itemprop="name">';		
		if(the_title( '', '', false ) !='') the_title(); 
			else esc_html_e('Untitled', 'opportune'); 
	echo '</h1>';
	  
 else :
	
	if( is_sticky() && is_home() ) :
	      printf( '<div class="sticky-wrapper"><span class="featured">%s</span></div>', esc_attr(get_theme_mod( 'sticky_post_label' )) ? esc_html( get_theme_mod( 'sticky_post_label' ) ) : esc_html__( 'Featured', 'opportune' ) );
	endif;
			
	echo '<h2 class="entry-title" itemprop="name"><a href="' .esc_url( get_permalink() ) .'">';		
	if(the_title( '', '', false ) !='') the_title(); 
		else _e('Untitled', 'opportune'); 
	echo '</a></h2>';
	  
    endif;
}

endif;



/**
 * Display an optional featured image  within a wrapper div for the blog
 */
 if ( ! function_exists( 'opportune_post_thumbnail' ) ) : 
function opportune_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="single-featured-image">
        <?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title(), 'itemprop' => "image")); ?>
	</div>

	<?php else : ?>

	<div class="featured-image">
        <a class="featured-image-link" href="<?php the_permalink(); ?>" aria-hidden="true">
            <?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title(), 'itemprop' => "thumbnailUrl")); ?>
        </a>
	    <?php if( is_sticky() && is_home() ) :
              printf( '<span class="featured">%s</span>', esc_attr(get_theme_mod( 'sticky_post_label' )) ? esc_html( get_theme_mod( 'sticky_post_label' ) ) : esc_html__( 'Featured', 'opportune' ) );
            endif; ?>
	</div>
    
	<?php endif; // End is_singular()
}
endif; 









if ( ! function_exists( 'the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'opportune' ); ?></h2>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( esc_html__( 'Older posts', 'opportune' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts', 'opportune' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'opportune' ); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
				next_post_link( '<div class="nav-next">%link</div>', '%title' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'opportune_posted_on' ) ) :
function opportune_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';
	

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		_x( 'Published %s', 'post date', 'opportune' ),
		$time_string
	);
	
	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'opportune_post_meta' ) ) :
function opportune_posted_meta() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s"  itemprop="datePublished">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( 'Published %s', 'post date', 'opportune' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
if ( esc_attr(get_theme_mod( 'show_post_author', 1 )) ) :
	$byline = sprintf(
		_x( 'by %s', 'post author', 'opportune' ),
		'<span class="byline post-meta bypostauthor" itemprop="author" itemscope="" itemtype="http://schema.org/Person"><span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" itemprop="url"><span itemprop="name">' . esc_html( get_the_author() ) . '</span></a></span></span>'
	);
endif;
if ( esc_attr(get_theme_mod( 'show_posted_date', 1 )) ) :
	echo '<span class="posted-on">' . $posted_on . '</span>'; 
endif;	
echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
	if( esc_attr(get_theme_mod( 'show_edit', 1 ) ) ) {
              edit_post_link( esc_html__( 'Edit this Post', 'opportune' ), '<span class="edit-link post-meta">', '</span>' );
            }	
}
endif;

if ( ! function_exists( 'opportune_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function opportune_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		if( esc_attr(get_theme_mod( 'show_single_categories', 1 ) ) ) :
			$categories_list = get_the_category_list( esc_html__(  ', ',  'opportune'  ) );
			
			if ( $categories_list && opportune_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in: %1$s', 'opportune' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}
		endif;
		/* translators: used between list items, there is a space after the comma */
		if( esc_attr(get_theme_mod( 'show_tags_list', 1 ) ) ) :
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'opportune' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged: %1$s', 'opportune' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		endif;
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'opportune' ), esc_html__( '1 Comment', 'opportune' ), esc_html__( '% Comments', 'opportune' ) );
		echo '</span>';
	}

	
}
endif;

/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 * Custom filter for changing the default archive title labels.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
 
if ( ! function_exists( 'opportune_the_archive_title' ) ) :

function opportune_the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( ( '%s' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( esc_html__( 'Posts Tagged with %s', 'opportune' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Articles by %s', 'opportune' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Articles from: %s', 'opportune' ), get_the_date( _x( 'Y', 'yearly archives date format', 'opportune' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Articles from %s', 'opportune' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'opportune' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Articles from %s', 'opportune' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'opportune' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'opportune' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'opportune' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'opportune' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'opportune' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'opportune' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'opportune' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'opportune' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'opportune' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'opportune' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'opportune' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'opportune' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'opportune' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;  // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'opportune_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function opportune_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;  // WPCS: XSS OK.
	}
}
endif;




/**
 * Blog pagination when more than one page of post summaries.
 *
 */

if ( ! function_exists( 'opportune_blog_pagination' ) ) :
function opportune_blog_pagination() {	
	the_posts_pagination( array(
		'prev_text'      => '<span class="previous">' . esc_html__( 'Prev', 'opportune' ) . '</span>',		
		'next_text'      => '<span class="next">' . esc_html__( 'Next', 'opportune' ) . '</span>',		
		'before_page_number' => ''
	) );	
}
endif;

/**
 * Single Post previous or next navigation.
 */

if ( ! function_exists( 'opportune_post_pagination' ) ) :
function opportune_post_pagination() {
	the_post_navigation( array(	
		'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next Article', 'opportune' ) . '</span> ' .
			'<span class="screen-reader-text">' . esc_html__( 'Next Article:', 'opportune' ) . '</span> ' .
			'<span class="post-title">%title</span>',
			
		'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Previous Article', 'opportune' ) . '</span> ' .
			'<span class="screen-reader-text">' . esc_html__( 'Previous Article:', 'opportune' ) . '</span> ' .
			'<span class="post-title">%title</span>',
	) );
}
endif;

/**
 * Multi-page navigation.
 */

if ( ! function_exists( 'opportune_multipage_nav' ) ) :
function opportune_multipage_nav() {
	wp_link_pages( array(
		'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'opportune' ) . '</span>',
		'after'       => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
		'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'opportune' ) . ' </span>%',
		'separator'   => ', ',
	) );
}
endif;




/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function opportune_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'opportune_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'opportune_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so opportune_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so opportune_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in opportune_categorized_blog.
 */
function opportune_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'opportune_categories' );
}
add_action( 'edit_category', 'opportune_category_transient_flusher' );
add_action( 'save_post',     'opportune_category_transient_flusher' );
