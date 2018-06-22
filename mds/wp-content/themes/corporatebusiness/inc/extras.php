<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package CorporateBusiness

 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function corporatebusiness_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'corporatebusiness_body_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function corporatebusiness_wp_title( $title, $sep ) {
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
			$title .= " $sep " . sprintf( __( 'Page %s', 'corporatebusiness' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'corporatebusiness_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function corporatebusiness_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'corporatebusiness_render_title' );
endif;

/**
 * Display a link back to the site.
 *
 * @uses get_bloginfo() Gets the site link
 * @return string
 */
function corporatebusiness_site_link() {
   return '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><b>' . get_bloginfo( 'name', 'display' ) . '</b></a>';
}

/**
 * Display a Contact details on header/footer
 */
function corporatebusiness_contact( $position = "" ) {
	if ( ! get_theme_mod( "contact_$position", 1) ) return false;
	?>
	<div class="site-contact <?php echo $position;?>">
                	<?php
					// Get vars
                    $address = 	esc_html(get_theme_mod( 'address', 'Massachusetts Ave, Cambridge, MA, USA' ));
					$mail = 	esc_html(get_theme_mod( 'mail', 'info@example.com' ));
					$phone = 	esc_html(get_theme_mod( 'phone', '+1 617-253-1000' ));
					
					$addressUrl = 	esc_url(get_theme_mod( 'address_url' ));
					$mailUrl = 		esc_url(get_theme_mod( 'mail_url' ));
					$phoneUrl = 	esc_url(get_theme_mod( 'phone_url' ));
					
					// Only text
					if ($address)	$addressOut = '<span class="address"><i class="fa fa-map-marker"></i>'.$address.'</span> ';
					if ($mail)		$mailOut = '<span class="mail"><i class="fa fa-envelope-o"></i>'.$mail.'</span> ';
					if ($phone)		$phoneOut = '<span class="phone"><i class="fa fa-phone"></i>'.$phone.'</span> ';
					
					// It has url ?
					if ( $address and $addressUrl )	$addressOut = '<a href="'.$addressUrl.'">'.$addressOut.'</a> ';
					if ( $mail and $mailUrl )		$mailOut = '<a href="'.$mailUrl.'">'.$mailOut.'</a> ';
					if ( $phone and $phoneUrl )		$phoneOut = '<a href="'.$phoneUrl.'">'.$phoneOut.'</a> ';
					
					// Echo
					echo $addressOut . $mailOut . $phoneOut;
					?>
	</div>
	 <?php
}

/**
 * Display a Social Media Icons on header/footer
 */
function corporatebusiness_social_media( $position = "header" ) {
	// Position disbale?
	if ( !get_theme_mod( 'enable_sm_'.$position, 0 ) and $position != "widget" ) return;

	// Size
	$size = get_theme_mod( 'sm_icon_size', 'fa-1x' );

	// Icons
	$icons = array();
	for ($i=1;$i<=10;$i++) {
		$link = esc_url(get_theme_mod( 'sm_link'.$i, home_url( '/' )));
		$icon = esc_attr(get_theme_mod( 'sm_icon'.$i, '-hide-' ));
		$description = esc_attr(get_theme_mod( 'sm_description'.$i ), '');
		if ( $link != "" && $icon != '-hide-' ) {
			$attr = sprintf('href="%s" ',  $link );
			if ( get_theme_mod( 'sm_title'.$i ) ) $attr .= sprintf('title="%s" ', esc_attr(get_theme_mod( 'sm_title'.$i )));
			if ( get_theme_mod( 'sm_target'.$i, 1 ) ) $attr .= 'target="_blank" ';
			if ( get_theme_mod( 'sm_color'.$i ) ) $attr .= sprintf('style="color:%s;" ', get_theme_mod( 'sm_color'.$i ));
			$icons [] = sprintf('<a %1$s class="sm-icon-%5$s"><i class="fa %2$s %3$s"></i> <span class="%3$s">%4$s</span></a>', $attr, $icon, $size, $description, $position);
		}
	} // end for

	// Display Icons
	if ( count ($icons) )
		printf('<span class="sm sm-%1$s">%2$s</span>', $position, implode( " ", $icons )) ;
}