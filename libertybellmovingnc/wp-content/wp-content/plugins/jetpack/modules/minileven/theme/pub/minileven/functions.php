<?php
/**
 * Minileven functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, minileven_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * @package Minileven
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 584;

/**
 * Tell WordPress to run minileven_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'minileven_setup' );

if ( ! function_exists( 'minileven_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function minileven_setup() {
	global $wp_version;

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/* Make Minileven available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Minileven, use a find and replace
	 * to change 'minileven' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'minileven', TEMPLATEPATH . '/languages' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'jetpack' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'gallery' ) );

	// Add support for custom backgrounds
	if ( version_compare( $wp_version, '3.4', '>=' ) )
		add_theme_support( 'custom-background' );
	else
		add_custom_background();

	// Add support for post thumbnails
	add_theme_support( 'post-thumbnails' );
}
endif; // minileven_setup

/**
 * Enqueue scripts and styles
 */
function minileven_scripts() {
	global $post;

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'minileven_scripts' );

function minileven_fonts() {

	/*	translators: If there are characters in your language that are not supported
		by Open Sans, translate this to 'off'. Do not translate into your own language. */

	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'minileven' ) ) {

		$opensans_subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$opensans_subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'minileven' );

		if ( 'cyrillic' == $opensans_subset )
			$opensans_subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $opensans_subset )
			$opensans_subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $opensans_subset )
			$opensans_subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';

		$opensans_query_args = array(
			'family' => 'Open+Sans:200,200italic,300,300italic,400,400italic,600,600italic,700,700italic',
			'subset' => $opensans_subsets,
		);
		wp_register_style( 'minileven-open-sans', add_query_arg( $opensans_query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}
}
add_action( 'init', 'minileven_fonts' );

/**
 * Register our sidebars and widgetized areas.
 * @since Minileven 1.0
 */
function minileven_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'jetpack' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'minileven_widgets_init' );

function minileven_posts_per_page() {
		return 5;
}
add_filter('pre_option_posts_per_page', 'minileven_posts_per_page');

/**
 * Determine the currently active theme.
 */
function minileven_actual_current_theme() {
	$removed = remove_action( 'option_stylesheet', 'jetpack_mobile_stylesheet' );
	$stylesheet = get_option( 'stylesheet' );
	if ( $removed )
		add_action( 'option_stylesheet', 'jetpack_mobile_stylesheet' );

	return $stylesheet;
}

/* This function grabs the location of the custom menus from the current theme. If no menu is set in a location
*  it will return a boolean "false". This function helps Minileven know which custom menu to display. */
function minileven_get_menu_location() {
	$theme_slug = minileven_actual_current_theme();
	$mods = get_option( "theme_mods_{$theme_slug}" );

	if ( isset( $mods['nav_menu_locations'] ) && ! empty( $mods['nav_menu_locations'] ) )
		return $mods['nav_menu_locations'];

	return false;
}

/* This function grabs the custom background image from the user's current theme so that Minileven can display it. */
function minileven_get_background() {
	$theme_slug = minileven_actual_current_theme();
	$mods = get_option( "theme_mods_$theme_slug" );

	if ( ! empty( $mods ) ) {
		return array(
			'color' => isset( $mods['background_color'] ) ? $mods['background_color'] : null,
			'image' => isset( $mods['background_image'] ) ? $mods['background_image'] : null,
			'repeat' => isset( $mods['background_repeat'] ) ? $mods['background_repeat'] : null,
			'position' => isset( $mods['background_position_x'] ) ? $mods['background_position_x'] : null,
			'attachment' => isset( $mods['attachment'] ) ? $mods['attachment'] : null,
		);
	}
	return false;
}

/**
 * Implement the Custom Header functions
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * If the user has set a static front page, show all posts on the front page, instead of a static page.
 */
if ( '1' == get_option( 'wp_mobile_static_front_page' ) )
	add_filter( 'pre_option_page_on_front', '__return_zero' );
