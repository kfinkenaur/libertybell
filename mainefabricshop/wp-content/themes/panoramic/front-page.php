<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package panoramic
 */
?>

<?php

function in_array_field($needle, $needle_field, $haystack, $strict = false) {
	if ($strict) {
		foreach ($haystack as $item) {
			if (isset($item->$needle_field) && $item->$needle_field === $needle) {
				return true;
			}
		}
	}
	else {
		foreach ($haystack as $item) {
			if (isset($item->$needle_field) && $item->$needle_field == $needle) {
				return true;
			}
		}
	}
	return false;
}

if ( get_theme_mod( 'panoramic-layout-mode', customizer_library_get_default( 'panoramic-layout-mode' ) ) == 'panoramic-layout-mode-multi-page' ) {
	if ( 'posts' == get_option( 'show_on_front' ) ) {
		include( get_home_template() );
	} else {
	    include( get_page_template() );
	}
	
} else {
	get_header();
	
	global $post;
	
	$pagesToDisplay = get_theme_mod( 'panoramic-layout-pages' );
	
	if ( $pagesToDisplay ) {
?>
	<ul class="sections <?php echo ( get_theme_mod( 'panoramic-layout-zebra-stripe', customizer_library_get_default( 'panoramic-layout-zebra-stripe' ) ) ) ? 'zebra' : ''; ?>">
		<?php
		$pages = get_pages( array(
			'sort_column' => 'menu_order',
			'include'	=> $pagesToDisplay
		) );
		
		$menuPages = array();
		$locations = get_nav_menu_locations();
		if ( isset( $locations[ 'primary' ] ) ) {
			$menu 		= wp_get_nav_menu_object( $locations[ 'primary' ] );
			$menu_items = wp_get_nav_menu_items($menu->term_id);
			
			foreach ( (array) $menu_items as $key => $menu_item ) {
				$pageId = $menu_item->object_id;

				$menuPages[] = get_page( $pageId );
			}
		}
		
		$orderedPages;

		foreach ( $menuPages as $menuPage ) {
			if ( in_array($menuPage, $pages ) ) {
				$orderedPages[] = $menuPage;
			}
		}

		foreach ( $pages as $page ) {
			if ( count($orderedPages) > 0 ) {
				if ( !in_array($page, $orderedPages ) ) {
					$orderedPages[] = $page;
				}
			} else {
				$orderedPages[] = $page;
			}
		}
		
		$pageCount = 0;
		foreach( $orderedPages as $page ) {
			$post = $page;
			setup_postdata( $post );
			
			include( locate_template( 'library/template-parts/content-section.php' ) );
			
			$pageCount++;
		}
			
		wp_reset_postdata();
		?>
	</ul>
<?php
	}
	
	get_footer();
}
?>