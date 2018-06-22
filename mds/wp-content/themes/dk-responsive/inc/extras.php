<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * Custom functions
 *
 *
 * @file           extras.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function dk_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'dk_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function dk_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'dk_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function dk_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'dk-responsive' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'dk_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function dk_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'dk_setup_author' );


//set page templates
function dk_get_current_layout() {
    global $post;
	/* 404 pages */
	if( is_404() ) {
		return 'default';
	}
	$layout = '';
    $layout= esc_attr(dk_get_option('layout'));
	if(empty($layout)){
		 $layout="content-sidebar";
	}
		/* if(is_front_page() || is_archive() || is_single() || is_home() ){
			$page_template='default';
		} else {
			$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
		} */
		if(is_page()) {
		 $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
		} else {
		  $page_template='default';
		}
	
		if( 'default' != $page_template ) {
			$layout= $page_template;
		} else {
		    $layout=$layout;
		}	
		
	return apply_filters( 'dk_get_layout', $layout );
}

function dk_content_classes() {
    $layout= dk_get_current_layout();	
	if( $layout == 'content-sidebar'  )  {
		$primary_content_classes[] = 'pull-left';
		$primary_content_classes[] = 'col-md-8';
	}
	elseif( 'sidebar-content' == $layout ) {
		$primary_content_classes[] = 'pull-right';
		$primary_content_classes[] = 'col-md-8';	
	}	
	elseif( 'full-width' == $layout ) {
		$primary_content_classes[] = 'col-md-12';
	}	
		
	return apply_filters( 'dk_content_classes', $primary_content_classes );
}

function dk_sidebar_classes() {
	$sidebar_classes = array();
	$layout= dk_get_current_layout();
	if( in_array( $layout, array( 'content-sidebar' ) ) ) {
		/* $sidebar_classes[] = 'pull-right'; */
		$sidebar_classes[] = 'col-md-4';		
	}
	elseif( 'sidebar-content' == $layout ) {
		/* $sidebar_classes[] = 'pull-left'; */
		$sidebar_classes[] = 'col-md-4';
		
	}	
	return apply_filters( 'dk_sidebar_classes', $sidebar_classes );
}



//Sets the post excerpt length to 40 words.
function dk_excerpt_length( $length ) {
	return 40;
}


add_filter( 'excerpt_length', 'dk_excerpt_length' );
function dk_read_more() {
	return '<div class="read-more1"><a href="' . get_permalink() . '">' . __( 'Read more &#8250;', 'dk-responsive' ) . '</a></div><!-- end of .read-more -->';
}
function dk_excerpt_more( $more ) {
	return '<span class="ellipsis">&hellip;</span>' ;
}
add_filter( 'excerpt_more', 'dk_excerpt_more' );


// add a favicon 
function dk_site_favicon() {
    $web_favicon= dk_get_option('web_favicon');	
	if(isset($web_favicon)) {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.esc_url($web_favicon).'" />';
	} 
}
add_action('wp_head', 'dk_site_favicon');

// add a favicon to admin
function dk_admin_favicon() {
    $admin_favicon= dk_get_option('admin_favicon');
    if(isset($admin_favicon)) {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.esc_url($admin_favicon).'" />';
	} 
}
add_action('admin_head', 'dk_admin_favicon');

// retrive theme options
function dk_get_options() {
	global $dk_options;	// Global Variable
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );
	$dk_framework_settings['id']= $themename; 
	$dk_options = wp_parse_args( get_option( $dk_framework_settings['id'], array() ));	
	return $dk_options;
}
// bootstrap css

function dk_add_scripts() {	
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() .  '/bootstrap/js/bootstrap.js',array( 'jquery' ), false, false );
	if ( is_rtl() ) {
			wp_enqueue_style( 'dk-rtl-style', get_template_directory_uri() . '/rtl.css', false );
	}
}
add_action( 'wp_enqueue_scripts', 'dk_add_scripts' );
function dk_remove_footer_admin () {
echo  __( 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Designed by <a href="http://www.zenanttech.com/" target="_blank">Zenant</a>', 'dk-responsive' );
}

add_filter('admin_footer_text', 'dk_remove_footer_admin');

add_action('wp_dashboard_setup', 'dk_custom_dashboard_widgets');

function dk_custom_dashboard_widgets() {
global $wp_meta_boxes;
wp_add_dashboard_widget('custom_help_widget', 'Theme Support', 'dk_dashboard_help');
}

function dk_dashboard_help() {
echo  __( 'Welcome to DK Responsive Theme! Need help? Contact the developer <a href="mailto:dipali.dhole27@gmail.com">here</a>.visit: <a href="http://www.zenanttech.com/" target="_blank">Zenant</a>', 'dk-responsive' );
}

function dk_custom_breadcrumbs() {

  $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter = '&raquo;'; // delimiter between crumbs
  $home = 'Home'; // text for the 'Home' link
  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
  global $post;
  $homeLink = esc_url(home_url());
  if (is_home() || is_front_page()) {
    if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
  } else {
    echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
    if ( is_category() ) {
      $thisCat = get_category(get_query_var('cat'), false);
      if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
      echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
        if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
        echo $cats;
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      }
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
    } elseif ( is_attachment() ) {
      //$parent = get_post($post->post_parent);
      //$cat = get_the_category($parent->ID); $cat = $cat[0];
     // echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
    //  echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo $before . get_the_title() . $after;
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        echo $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
      }
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;
    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    }
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page','dk-responsive') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
    echo '</div>';
  }
} // end dk_custom_breadcrumbs()


function dk_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body pull-left">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); ?>
	</div>
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','dk-responsive' ); ?></em>
		<br />
	<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
		<?php
			/* translators: 1: date, 2: time */
			printf( __('%1$s at %2$s','dk-responsive'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)','dk-responsive'), '  ', '' );
		?>
	</div>

	<?php comment_text(); ?>

	<div class="reply">
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}
