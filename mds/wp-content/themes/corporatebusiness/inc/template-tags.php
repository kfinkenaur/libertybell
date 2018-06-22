<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package CorporateBusiness

 */

if ( ! function_exists( 'corporatebusiness_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function corporatebusiness_posted_on() {
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

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	if ( get_theme_mod( 'display_post_date' , 1) )
		echo '<span class="posted-on"><i class="fa fa-calendar"></i> ' . $posted_on . '</span>';
	
	edit_post_link( __( 'Edit', 'corporatebusiness' ), '<span class="edit-link"><i class="fa fa-edit"></i> ', '</span>' );
	
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link"><i class="fa fa-comments"></i> ';
		comments_popup_link( __( 'Leave a comment', 'corporatebusiness' ), __( '1 Comment', 'corporatebusiness' ), __( '% Comments', 'corporatebusiness' ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'corporatebusiness_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function corporatebusiness_entry_footer() {
	if ( is_sticky() && is_home() && ! is_paged() ) {printf( '<span class="sticky-post"><i class="fa fa-star"></i> %s</span>', __( 'Featured', 'corporatebusiness' ) );}
	
	$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';
	if ( get_theme_mod( 'display_post_author' , 1) ) echo '<span class="byline"><i class="fa fa-user"></i> ' . $byline . '</span>';
	
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'corporatebusiness' ) );
		if ( get_theme_mod( 'display_post_categories' , 1) && $categories_list && corporatebusiness_categorized_blog() ) {
			printf( '<span class="cat-links"><i class="fa fa-folder"></i> ' . '%1$s' . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'corporatebusiness' ) );
		if ( get_theme_mod( 'display_post_tags' , 1) && $tags_list ) {
			printf( '<span class="tags-links"><i class="fa fa-tags"></i> ' . '%1$s' . '</span>', $tags_list );
		}
	}
}
endif;

if ( ! function_exists( 'corporatebusiness_archive_title' ) ) :
function corporatebusiness_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = '<i class="fa fa-folder-open"></i> '. sprintf( __( 'Category: %s', 'corporatebusiness' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = '<i class="fa fa-tag"></i> ' . sprintf( __( 'Tag: %s', 'corporatebusiness' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = '<i class="fa fa-user"></i> ' . sprintf( __( 'Author: %s', 'corporatebusiness' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = '<i class="fa fa-calendar-o"></i> ' . sprintf( __( 'Year: %s', 'corporatebusiness' ), get_the_date( _x( 'Y', 'yearly archives date format', 'corporatebusiness' ) ) );
	} elseif ( is_month() ) {
		$title = '<i class="fa fa-calendar-o"></i> ' . sprintf( __( 'Month: %s', 'corporatebusiness' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'corporatebusiness' ) ) );
	} elseif ( is_day() ) {
		$title = '<i class="fa fa-calendar-o"></i> ' . sprintf( __( 'Day: %s', 'corporatebusiness' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'corporatebusiness' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'corporatebusiness' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'corporatebusiness' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'corporatebusiness' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'corporatebusiness' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'corporatebusiness' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'corporatebusiness' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'corporatebusiness' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'corporatebusiness' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'corporatebusiness' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'corporatebusiness' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'corporatebusiness' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'corporatebusiness' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;

if ( ! function_exists( 'corporatebusiness_archive_description' ) ) :
function corporatebusiness_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function corporatebusiness_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'corporatebusiness_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'corporatebusiness_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so corporatebusiness_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so corporatebusiness_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in corporatebusiness_categorized_blog.
 */
function corporatebusiness_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'corporatebusiness_categories' );
}
add_action( 'edit_category', 'corporatebusiness_category_transient_flusher' );
add_action( 'save_post',     'corporatebusiness_category_transient_flusher' );


function corporatebusiness_theme_comment($comment,$args,$depth){
	$GLOBALS['comment'] = $comment;
	
	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) {
?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php echo __( 'Pingback:', 'corporatebusiness' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'corporatebusiness' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

<?php
	}else{
?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-author"><?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
        
			<div class="comment-meta">
            	<span class="fn"><?php echo get_comment_author_link();?></span>
				<span><?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'corporatebusiness' ), get_comment_date(), get_comment_time() ); ?></span>
                <?php edit_comment_link( __( 'Edit', 'corporatebusiness' ), '<span><i class="fa fa-edit"></i> ', '</span>' ); ?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php echo __( 'Your comment is awaiting moderation.', 'corporatebusiness' ); ?></p>
				<?php endif; ?>
			</div>

			<div class="mscon comment-content"><?php comment_text();?></div>

			<div class="reply"><?php comment_reply_link( array_merge( $args, array('reply_text' => '<i class="fa fa-retweet"></i>', 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
            
            <div class="clear"></div>
		</div>
<?php
	}
}

function corporatebusiness_image_navigation(){
?>
<nav role="navigation" id="page-nav-below" class="navigation-image nav-links">
    <div class="nav-previous"><?php previous_image_link( false, '<i class="fa fa-chevron-left"></i> '. __( 'Previous', 'corporatebusiness' ) ); ?></div>
	<div class="nav-next"><?php next_image_link( false, __( 'Next', 'corporatebusiness' ) . ' <i class="fa fa-chevron-right"></i>' ); ?></div>
</nav><!-- #image-navigation -->
<?php
}

function corporatebusiness_posts_navigation(){
	if(function_exists('wp_pagenavi')) {
		wp_pagenavi();
	}else{
		if(function_exists('the_posts_pagination')){
			the_posts_pagination( array(
				'prev_text'          => '<i class="fa fa-arrow-left"></i>',
				'next_text'          => '<i class="fa fa-arrow-right"></i>',
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'corporatebusiness' ) . ' </span>',
			) );
		}else{
	?>
        <div id="page-nav-below">
			<?php if ( get_next_posts_link() ) : ?>
            <div class="nav-previous"><i class="fa fa-arrow-left"></i> <?php next_posts_link( __( 'Older posts', 'corporatebusiness' ) ); ?></div>
            <?php endif; ?>
    
            <?php if ( get_previous_posts_link() ) : ?>
            <div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'corporatebusiness' ) ); ?> <i class="fa fa-arrow-right"></i></div>
            <?php endif; ?>
        </div>
	<?php
				}
	}
}

function corporatebusiness_post_navigation(){
	global $post;
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous ) return;

	echo '<div role="navigation" id="nav-below" class="navigation-post">';
	previous_post_link( '<div class="nav-previous">%link</div>', '<i class="fa fa-arrow-left"></i> %title');
	next_post_link( '<div class="nav-next">%link</div>', '%title <i class="fa fa-arrow-right"></i>'); 
	echo '<div class="clear"></div>';
	echo '</div>';
}
/*
Contains the closing of the #content div and all content after
Proudly powered by WordPress
<span class="sep"> &amp; </span>
<strong>CorporateBusiness WordPress Theme</strong> by <a href="http://dinozoom.com"><strong>Dinozoom.com</strong></a>.
*/
function corporatebusiness_wp_footer () { ?>
	<?php global $paged;
	if( get_theme_mod( 'enable_cta', 1 ) && is_front_page() && $paged <= 1 && ! is_404() ):?>
	<div id="cta">
    	<div class="text">
        	<div class="title"><?php echo esc_attr(get_theme_mod('cta_title', __('Hello, World!', 'corporatebusiness')) );?></div>
            <div class="desc"><?php echo esc_attr(get_theme_mod('cta_text', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...') );?></div>
    	</div>
        <?php if ( get_theme_mod('cta_button_url', '#') ): ?>
        <div class="button">
        	<a href="<?php echo esc_url(get_theme_mod('cta_button_url', '#') );?>"><?php echo esc_attr(get_theme_mod('cta_button_text', __('Hello, World!', 'corporatebusiness')) );?></a>
        </div>
        <?php endif;?>
        <div class="clear"></div>
    </div><!-- #cta -->
    <?php endif;?>
	</div><!-- #content -->
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
        	<div class="footer-social-media"><?php corporatebusiness_social_media ("footer");?></div>
        	<div class="site-description">
				<?php corporatebusiness_contact( "footer" );?>
			</div>
            <?php if( get_theme_mod( 'footer_map' ) ) printf( '<div class="footer-embed-map">%1$s</div>', get_theme_mod('footer_map') );?>
            
        	<div class="copyright">
				<?php printf( __( 'Copyright &copy; %1$d %2$s.', 'corporatebusiness' ), date('Y'), corporatebusiness_site_link() );?>
			
			<?php printf( __( 'Proudly powered by %s', 'corporatebusiness' ), 'WordPress' ); ?>
			<span class="sep"> &amp; </span>
			<?php printf(
			__( '%1$s by %2$s.', 'corporatebusiness' ),
			'<strong>'.__('Corporate Business WordPress Theme', 'corporatebusiness' ).'</strong>',
			'<a href="'.esc_url('http://dinozoom.com').'"><strong>Dinozoom.com</a></strong>' ); ?>
            </div><!-- .copyright -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
    <div id="back_top"><i class="fa fa-angle-up"></i></div>
</div><!-- #page -->
<?php wp_footer(); ?>
</body></html>
<?php
} // end function
?>