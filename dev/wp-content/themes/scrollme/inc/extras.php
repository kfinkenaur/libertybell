<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package scrollme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function scrollme_body_classes( $classes ) {
	global $post;
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if( is_singular( array( 'post', 'page' )) ) {
		$post_sidebar = get_post_meta( $post->ID, 'scrollme_sidebar_layout', true );
		if( empty( $post_sidebar ) ) {
			$classes[] = 'right_sidebar';
		}else{
			$classes[] = $post_sidebar;
		}
	}

	return $classes;
}
add_filter( 'body_class', 'scrollme_body_classes' );

// Remove current class on hash menu
add_filter('nav_menu_css_class', 'scrollme_remove_current_class_hash', 10, 2 );

function scrollme_remove_current_class_hash($classes, $item) {
	$class_names = array( 'current-menu-item', 'current-menu-ancestor', 'current-menu-parent', 'current_page_parent',  'current_page_ancestor', 'current_page_item' );
	if( strpos( $item->url, '#' ) !== false ) {
		foreach( $class_names as $class_name ) {
			if(($key = array_search($class_name, $classes)) !== false) {
				unset($classes[$key]);
			}
		}

	}
	return $classes;
}

/**
 * Custom Search Form
 */
function scrollme_search_form( $form ) {
	$form = '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" >
	<div><label class="screen-reader-text" for="s">' . __( 'Search for:', 'scrollme' ) . '</label>
	<input type="search" class="search-field" placeholder="'. __('Search..', 'scrollme').'" value="' . get_search_query() . '" name="s" id="s" />
	<input type="submit" id="search-submit" value="'. __('Search..', 'scrollme').'" />
	</div>
	</form>';

	return $form;
}

add_filter( 'get_search_form', 'scrollme_search_form' );

/**
 * Sidebar Layout Class
 */
function scrollme_get_sidebar_layout()  {
	global $post;
	$post_sidebar = 'right_sidebar';

	if( is_singular() ) {
		$post_sidebar = get_post_meta( $post->ID, 'scrollme_sidebar_layout', true );
	}
	
	return $post_sidebar;
}

/** Add Editor Styles **/
function scrollme_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}

add_action( 'admin_init', 'scrollme_add_editor_styles' );

function scrollme_dynamic_style() {
    $preloader = get_theme_mod( 'scrollme_preloader' );
    
    if( isset( $preloader ) && $preloader == '' ) :
    ?>
    <style>
    .no-js #loader { display: none; }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .scrollme-preloader { position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; z-index: 9999999; background: url('<?php echo get_template_directory_uri()."/images/loading.gif"; ?>') center no-repeat #fff;}
    </style>
    <?php
    endif;
}
add_action( 'wp_head', 'scrollme_dynamic_style', 15 );

function scrollme_refine_options() {
	$scroll_sections = get_option('theme_mods_scrollme');

	for($i = 1; $i <= 7; $i++) {
		if(array_key_exists("scrollme_section_$i", $scroll_sections )){
			if(is_object($scroll_sections['scrollme_section_'.$i])) {
				$scroll_sections['scrollme_section_'.$i] = '';
			}
		}
	}
	update_option('theme_mods_scrollme', $scroll_sections);
}
scrollme_refine_options();