<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package HowlThemes
 */




if ( ! function_exists( 'drag_themes_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function drag_themes_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( '<i class="fa fa-calendar-o"></i> %s', 'post date', 'aqueduct' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="entry-author" itemscope="itemscope"><i class="fa fa-user"></i><a href="'. get_author_posts_url( get_the_author_meta( "ID" )).'" rel="author"><span itemprop="name">' . get_the_author() . '</span></a></span><span class="comment-count"><i class="fa fa-comments"></i> <a href="' . get_permalink(). '/#comment">' . get_comments_number(). '</a></span>';

}
endif;

if ( ! function_exists( 'drag_themes_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function drag_themes_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ' ', 'aqueduct' ) );
		if ( $categories_list && drag_themes_categorized_blog() ) {
			printf( '<div class="cat-links"><i class="fa fa-folder-open"></i>' . __( ' Category %1$s', 'aqueduct' ) . '</div>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ' ', 'aqueduct' ) );
		if ( $tags_list ) {
			printf( '<div class="tags-links"><i class="fa fa-tags"></i>' . __( ' Tagged %1$s', 'aqueduct' ) . '</div>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'aqueduct' ), __( '1 Comment', 'aqueduct' ), __( '% Comments', 'aqueduct' ) );
		echo '</span>';
	}

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function drag_themes_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'drag_themes_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'drag_themes_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so drag_themes_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so drag_themes_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in drag_themes_categorized_blog.
 */
function drag_themes_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'drag_themes_categories' );
}
add_action( 'edit_category', 'drag_themes_category_transient_flusher' );
add_action( 'save_post',     'drag_themes_category_transient_flusher' );
