<?php
/**
 * panoramic functions and definitions
 *
 * @package panoramic
 */
define( 'PANORAMIC_THEME_VERSION' , '10.0.14' );
define( 'PANORAMIC_UPDATE_URL' , 'https://updates.outtheboxthemes.com' );

if ( ! function_exists( 'panoramic_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function panoramic_theme_setup() {
	
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 640; /* pixels */
	}
	
	$font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,600,600italic,700,700italic' );
	add_editor_style( $font_url );
	
	$font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Raleway:500,600,700,100,800,400,300' );
	add_editor_style( $font_url );
	
	add_editor_style('editor-style.css');
	
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on panoramic, use a find and replace
	 * to change 'panoramic' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'panoramic', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'panoramic' ),
        'footer' => __( 'Footer Menu', 'panoramic' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );
	
	/*
	 * Setup Custom Logo Support for theme
	* Supported from WordPress version 4.5 onwards
	* More Info: https://make.wordpress.org/core/2016/03/10/custom-logo/
	*/
	if ( function_exists( 'has_custom_logo' ) ) {
		add_theme_support( 'custom-logo' );
	}
	
	// The custom header is used if no slider is enabled
	add_theme_support( 'custom-header', array(
        'default-image' => get_template_directory_uri() . '/library/images/headers/default.jpg',
		'width'         => 1500,
		'height'        => 445,
		'flex-width'    => true,
		'flex-height'   => true,
		'header-text'   => false,
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'panoramic_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
    
    add_theme_support( 'title-tag' );
	
	add_theme_support( 'woocommerce' );
}
endif; // panoramic_theme_setup
add_action( 'after_setup_theme', 'panoramic_theme_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function panoramic_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'panoramic' ),
		'id'            => 'sidebar-1',
		'description'   => 'This sidebar will appear on the Blog or any page that uses either the Default or Left Primary Sidebar template.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Sidebar', 'panoramic' ),
		'id'            => 'secondary-sidebar',
		'description'   => 'This sidebar will appear on any page that uses either the Left Secondary Sidebar or Right Secondary Sidebar template.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );

	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'panoramic' ),
		'id'            => 'shop-sidebar',
		'description'   => 'This sidebar will appear on your WooCommerce pages.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
	
	register_sidebar(array(
		'name' => __( 'Footer', 'panoramic' ),
		'id' => 'footer',
        'description'   => '',
	));
}
add_action( 'widgets_init', 'panoramic_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function panoramic_theme_scripts() {
	wp_enqueue_style( 'panoramic-site-title-font-default', '//fonts.googleapis.com/css?family=Kaushan+Script:400', array(), PANORAMIC_THEME_VERSION );
    wp_enqueue_style( 'panoramic-body-font-default', '//fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,600,600italic,700,700italic', array(), PANORAMIC_THEME_VERSION );
    wp_enqueue_style( 'panoramic-heading-font-default', '//fonts.googleapis.com/css?family=Raleway:500,600,700,100,800,400,300', array(), PANORAMIC_THEME_VERSION );
    
    if ( get_theme_mod( 'panoramic-header-layout', customizer_library_get_default( 'panoramic-header-layout' ) ) == 'panoramic-header-layout-centered' ) {
    	wp_enqueue_style( 'panoramic-header-centered', get_template_directory_uri().'/library/css/header-centered.css', array(), PANORAMIC_THEME_VERSION );
    } else {
    	wp_enqueue_style( 'panoramic-header-standard', get_template_directory_uri().'/library/css/header-standard.css', array(), PANORAMIC_THEME_VERSION );
    }
    
	wp_enqueue_style( 'panoramic-font-awesome', get_template_directory_uri().'/library/fonts/font-awesome/css/font-awesome.css', array(), '4.7.0' );
	wp_enqueue_style( 'panoramic-style', get_stylesheet_uri(), array(), PANORAMIC_THEME_VERSION );
	
	if ( panoramic_is_woocommerce_activated() ) {
    	wp_enqueue_style( 'panoramic-woocommerce-custom', get_template_directory_uri().'/library/css/woocommerce-custom.css', array(), PANORAMIC_THEME_VERSION );
	}

	wp_enqueue_script( 'panoramic-navigation-js', get_template_directory_uri() . '/library/js/navigation.js', array(), PANORAMIC_THEME_VERSION, true );
	wp_enqueue_script( 'panoramic-caroufredsel-js', get_template_directory_uri() . '/library/js/jquery.carouFredSel-6.2.1-packed.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
	
	if ( get_theme_mod( 'panoramic-header-sticky', customizer_library_get_default( 'panoramic-header-sticky' ) ) ) {
		wp_enqueue_script( 'panoramic-waypoints-js', get_template_directory_uri() . '/library/js/waypoints.min.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
	    wp_enqueue_script( 'panoramic-waypoints-sticky-js', get_template_directory_uri() . '/library/js/waypoints-sticky.min.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
	}
	
	wp_enqueue_script( 'panoramic-custom-js', get_template_directory_uri() . '/library/js/custom.js', array('jquery'), PANORAMIC_THEME_VERSION, true );

	wp_enqueue_script( 'panoramic-skip-link-focus-fix-js', get_template_directory_uri() . '/library/js/skip-link-focus-fix.js', array(), PANORAMIC_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'panoramic_theme_scripts' );

// Recommended plugins installer
require_once get_template_directory() . '/library/includes/class-tgm-plugin-activation.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/library/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/library/includes/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/library/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/library/includes/jetpack.php';

// Helper library for the theme customizer.
require get_template_directory() . '/customizer/customizer-library/customizer-library.php';

// Define options for the theme customizer.
require get_template_directory() . '/customizer/customizer-options.php';

// Output inline styles based on theme customizer selections.
require get_template_directory() . '/customizer/styles.php';

// Additional filters and actions based on theme customizer selections.
require get_template_directory() . '/customizer/mods.php';

/**
 * Premium Upgrade Page
 */
include get_template_directory() . '/premium/premium.php';

/**
 * Enqueue panoramic custom customizer styling.
 */
function panoramic_load_customizer_script() {
    wp_enqueue_script( 'panoramic-customizer-custom-js', get_template_directory_uri() . '/customizer/customizer-library/js/customizer-custom.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
    wp_enqueue_style( 'panoramic-customizer', get_template_directory_uri() . '/customizer/customizer-library/css/customizer.css' );
}    
add_action( 'customize_controls_enqueue_scripts', 'panoramic_load_customizer_script' );

if ( ! function_exists( 'panoramic_load_dynamic_css' ) ) :
/**
 * Add CSS for mobile menu breakpoint
 */
	function panoramic_load_dynamic_css() {
		$site_branding_padding_top = get_theme_mod( 'site_branding_padding_top', customizer_library_get_default( 'site_branding_padding_top' ) );
		$site_branding_padding_bottom = get_theme_mod( 'site_branding_padding_bottom', customizer_library_get_default( 'site_branding_padding_bottom' ) );
		$mobile_menu_breakpoint = get_theme_mod( 'panoramic-mobile-menu-breakpoint', customizer_library_get_default( 'panoramic-mobile-menu-breakpoint' ) );
		
		require get_template_directory() . '/library/includes/dynamic-css.php';
		
		// TODO: Add this code when fixing the centering of the slider overlay
		//require get_template_directory() . '/library/includes/default-slider-css.php';
	}
endif;
add_action( 'wp_head', 'panoramic_load_dynamic_css' );

// Create function to check if WooCommerce exists.
if ( ! function_exists( 'panoramic_is_woocommerce_activated' ) ) :
	function panoramic_is_woocommerce_activated() {
	    if ( class_exists( 'woocommerce' ) ) {
	    	return true;
		} else {
			return false;
		}
	}
endif; // panoramic_is_woocommerce_activated

if ( panoramic_is_woocommerce_activated() ) {
    require get_template_directory() . '/library/includes/woocommerce-inc.php';
}

// Add CSS class to body by filter
function panoramic_add_body_class( $classes ) {
	//$classes[] = 'animating';
	if ( get_theme_mod( 'panoramic-layout-mode', customizer_library_get_default( 'panoramic-layout-mode' ) ) == 'panoramic-layout-mode-one-page' ) {
		$classes[] = 'panoramic-one-page-mode';
	}
	
	if ( get_theme_mod( 'panoramic-layout-woocommerce-shop-full-width', customizer_library_get_default( 'panoramic-layout-woocommerce-shop-full-width' ) ) ) {
		$classes[] = 'panoramic-shop-full-width';
	}
	
	if ( ( is_home() || is_single() || is_archive() ) && get_theme_mod( 'panoramic-blog-full-width', customizer_library_get_default( 'panoramic-blog-full-width' ) ) ) {
		$classes[] = 'full-width';
	}

	if ( !get_theme_mod( 'panoramic-layout-display-page-titles', customizer_library_get_default( 'panoramic-layout-display-page-titles' ) ) ) {
		$classes[] = 'no-page-titles';	
	}
	
	if ( ( is_home() || is_single() || is_archive() || is_search() ) && !get_theme_mod( 'panoramic-blog-display-date', customizer_library_get_default( 'panoramic-blog-display-date' ) ) && !get_theme_mod( 'panoramic-blog-display-author', customizer_library_get_default( 'panoramic-blog-display-author' ) ) ) {
		$classes[] = 'no-post-meta-data';
	} elseif ( is_home() || is_single() || is_archive() || is_search() ) {
		$classes[] = 'post-meta-data';
	}
	
	if ( ( is_home() || is_archive() || is_search() ) && !get_theme_mod( 'panoramic-layout-display-post-titles', customizer_library_get_default( 'panoramic-layout-display-post-titles' ) ) ) {
		$classes[] = 'post-archive-no-post-titles';	
	}

	if ( is_single() && !get_theme_mod( 'panoramic-layout-display-post-titles', customizer_library_get_default( 'panoramic-layout-display-post-titles' ) ) ) {
		$classes[] = 'post-single-no-post-titles';	
	}
	
	// TODO: Add this code when implementing the rounded corners theme setting
	/*
	if ( get_theme_mod( 'panoramic-styling-rounded-corners', customizer_library_get_default( 'panoramic-styling-rounded-corners' ) ) ) {
		$classes[] = 'rounded-corners';
	}
	*/

	return $classes;
}
add_filter( 'body_class', 'panoramic_add_body_class' );

// Set the number or products per row
if (!function_exists('panoramic_loop_shop_columns')) {

	function panoramic_loop_shop_columns() {
		$is_front_page = is_front_page();
		
		if ( ($is_front_page && get_theme_mod( 'panoramic-layout-mode', customizer_library_get_default( 'panoramic-layout-mode' ) ) == 'panoramic-layout-mode-one-page') || get_theme_mod( 'panoramic-layout-woocommerce-shop-full-width', customizer_library_get_default( 'panoramic-layout-woocommerce-shop-full-width' ) ) ) {
			return 4;
			
		} else {
			return 3;
		}
	}

}
add_filter('loop_shop_columns', 'panoramic_loop_shop_columns');

function panoramic_excerpt_length( $length ) {
	return get_theme_mod( 'panoramic-blog-excerpt-length', customizer_library_get_default( 'panoramic-blog-excerpt-length' ) );
}
add_filter( 'excerpt_length', 'panoramic_excerpt_length', 999 );

function panoramic_excerpt_more( $more ) {
	return ' <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . wp_kses_post( get_theme_mod( 'panoramic-blog-read-more-text', customizer_library_get_default( 'panoramic-blog-read-more-text' ) ) ) . '</a>';
}
add_filter( 'excerpt_more', 'panoramic_excerpt_more' );

function panoramic_one_page_mode_error() {
	echo '<div class="notice notice-error"><p>';
	echo 'You\'re running Panoramic in One Page mode but you haven\'t assigned a Primary Menu. Your site won\'t function properly unless you do.' ;
	echo '</p></div>';
}

// Display an error message if the user is in One Page mode but doesn't have a primary menu assigned
$locations = get_nav_menu_locations();
if ( get_theme_mod( 'panoramic-layout-mode', customizer_library_get_default( 'panoramic-layout-mode' ) ) == 'panoramic-layout-mode-one-page' && !isset( $locations[ 'primary' ] ) ) {
	add_action('admin_notices', 'panoramic_one_page_mode_error');
}

/**
 * Adjust is_home query if panoramic-slider-categories is set
 */
function panoramic_set_blog_queries( $query ) {
    
    $slider_categories = get_theme_mod( 'panoramic-slider-categories' );
    $slider_type = get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) );
    
    if ( $slider_categories && $slider_type == 'panoramic-slider-default' ) {
    	
    	$is_front_page = ( $query->get('page_id') == get_option('page_on_front') || is_front_page() );
    	
    	if ( count($slider_categories) > 0) {
    		// do not alter the query on wp-admin pages and only alter it if it's the main query
    		if ( !is_admin() && !$is_front_page  && $query->get('id') != 'slider' || !is_admin() && $is_front_page && $query->get('id') != 'slider' ){
				$query->set( 'category__not_in', $slider_categories );
    		}
    	}
    }
	    
}
add_action( 'pre_get_posts', 'panoramic_set_blog_queries' );

add_filter( 'pre_get_posts', 'tgm_io_cpt_search' );
/**
 * This function modifies the main WordPress query to include an array of 
 * post types instead of the default 'post' post type.
 *
 * @param object $query  The original query.
 * @return object $query The amended query.
 */
function tgm_io_cpt_search( $query ) {
	
    if ( $query->is_search ) {
    	//echo 'here';
    	//print_r( $query->get( 'post_type' ) );
    	//exit;
		//$query->set( 'post_type', array( 'post' ) );
    }
    
    return $query;
    
}


function panoramic_filter_recent_posts_widget_parameters( $params ) {

	$slider_categories = get_theme_mod( 'panoramic-slider-categories' );
    $slider_type = get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) );
	
	if ( $slider_categories && $slider_type == 'panoramic-slider-default' ) {
		if ( count($slider_categories) > 0) {
			// do not alter the query on wp-admin pages and only alter it if it's the main query
			$params['category__not_in'] = $slider_categories;
		}
	}
	
	return $params;
}
add_filter('widget_posts_args','panoramic_filter_recent_posts_widget_parameters');

/**
 * Adjust the widget categories query if panoramic-slider-categories is set
 */
function panoramic_set_widget_categories_args($args){
	$slider_categories = get_theme_mod( 'panoramic-slider-categories' );
    $slider_type = get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) );
	
	if ( $slider_categories && $slider_type == 'panoramic-slider-default' ) {
		if ( count($slider_categories) > 0) {
			$exclude = implode(',', $slider_categories);
			$args['exclude'] = $exclude;
		}
	}
	
	return $args;
}
add_filter('widget_categories_args', 'panoramic_set_widget_categories_args');

function panoramic_set_widget_categories_dropdown_arg($args){
	$slider_categories = get_theme_mod( 'panoramic-slider-categories' );
    $slider_type = get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) );
	
	if ( $slider_categories && $slider_type == 'panoramic-slider-default' ) {
		if ( count($slider_categories) > 0) {
			$exclude = implode(',', $slider_categories);
			$args['exclude'] = $exclude;
		}
	}
	
	return $args;
}
add_filter('widget_categories_dropdown_args', 'panoramic_set_widget_categories_dropdown_arg');

function create_slider_shortcode_field(){
 	global $post;
 	$custom_fields = get_post_custom($post->ID);
 	$slider_shortcode = $custom_fields["slider_shortcode"][0];
	
	echo '<input type="text" name="slider_shortcode" value="'. esc_html($slider_shortcode) .'" />';
}

function create_featured_image_text_field(){
 	global $post;
 	$custom_fields = get_post_custom($post->ID);
 	$featured_image_text = $custom_fields["featured_image_text"][0];
 	
 	echo '<textarea name="featured_image_text" style="height: 150px; min-width: 255px; max-width: 100%;">'. esc_html($featured_image_text) .'</textarea>';
 	echo '<i>'. esc_html( __( 'Use <h2></h2> tags around heading text and <p></p> tags around body text.', 'panoramic' ) ) .'</i>';
 	//echo '<a href="'. admin_url( 'media-upload.php?post_id=' .$post->ID. '&amp;type=image&amp;TB_iframe=1&amp;width=753&amp;height=320' ) .'" id="set-header-image" class="thickbox">Set header image</a>';
}

function add_meta_boxes(){
	add_meta_box('slider_shortcode_container', __( 'Slider Shortcode', 'panoramic' ), 'create_slider_shortcode_field', array('post','page'), 'side', 'low');
	add_meta_box('featured_image_text_container', __( 'Featured Image Text', 'panoramic' ), 'create_featured_image_text_field', array('page'), 'side', 'low');
}
add_action('admin_init', 'add_meta_boxes');

function save_custom_meta(){
	global $post;
  
	update_post_meta($post->ID, 'slider_shortcode', $_POST["slider_shortcode"]);
	update_post_meta($post->ID, 'featured_image_text', $_POST["featured_image_text"]);
}
add_action('save_post', 'save_custom_meta');

add_filter( 'manage_posts_columns', 'panoramic_posts_custom_column_head' );
add_action( 'manage_posts_custom_column' , 'panoramic_posts_custom_column', 10, 2 );

// Add the new column
function panoramic_posts_custom_column_head($defaults) {
	//$featured_image_column_head['featured_image'] = 'Featured Image';
	//array_splice( $defaults, 2, 0, $featured_image_column_head); 
	//$defaults['featured_image'] = 'Featured Image';
	$defaults['post_type'] = '';
	return $defaults;
}

// Add the colum content
function panoramic_posts_custom_column($column_name, $post_ID) {
    $slider_categories = get_theme_mod( 'panoramic-slider-categories' );
    $slider_type = get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) );
    
    //if ( $column_name == 'featured_image' && has_post_thumbnail( $post_ID ) ) {
    //	echo get_the_post_thumbnail( $post_ID, 'thumbnail' );
    //}

	if ( $column_name == 'post_type' && $slider_categories && count( $slider_categories ) > 0 && $slider_type == 'panoramic-slider-default' ) {
		if ( in_category( $slider_categories, $post_ID ) ) {
    		echo '<span style="color: red;">';
    		echo __( 'This post is assigned to the same category as your Default Slider category and will not show in your blog.', 'panoramic' );
    		echo '</span>';
		}
	}
}

function panoramic_setup_nav_menu_item($item) {
	// Add classes to the menu item.
	$item_classes = array_diff( $item->classes, array('scroll-link', 'no-highlight') );
	
	if ( get_theme_mod( 'panoramic-layout-mode', customizer_library_get_default( 'panoramic-layout-mode' ) ) == 'panoramic-layout-mode-one-page' ) {
		$pagesToDisplay = get_theme_mod( 'panoramic-layout-pages' );
		
		if ( $pagesToDisplay ) {
			if ( in_array( $item->object_id, $pagesToDisplay ) ) {
				$item_classes[] = 'scroll-link';
			}
		}
		$item_classes[] = 'no-highlight';
	}
	
	$item->classes = $item_classes;

	return $item;
}

function panoramic_add_nav_menu_item_setup_function($args) {
	if( $args['theme_location'] == 'primary' ):
		add_filter( 'wp_setup_nav_menu_item','panoramic_setup_nav_menu_item' );
	endif;
	return $args;
}
add_filter( 'wp_nav_menu_args','panoramic_add_nav_menu_item_setup_function' );

function panoramic_remove_nav_menu_item_setup_function( $nav, $args ) {
	remove_filter( 'wp_setup_nav_menu_item', 'panoramic_setup_nav_menu_item' );
	return $nav;
}
add_filter('wp_nav_menu_items','panoramic_remove_nav_menu_item_setup_function', 10, 2);

function panoramic_allowed_tags() {
	global $allowedtags;
	$allowedtags["h1"] = array();
	$allowedtags["h2"] = array();
	$allowedtags["h3"] = array();
	$allowedtags["h4"] = array();
	$allowedtags["h5"] = array();
	$allowedtags["h6"] = array();
	$allowedtags["p"] = array();
	$allowedtags["br"] = array();
}
add_action('init', 'panoramic_allowed_tags', 10);

// Set the size of the Blog Featured Image
function panoramic_set_blog_featured_image_sizes() {
	add_image_size( 'panoramic_blog_img_side', 352, 230, get_theme_mod( 'panoramic-blog-crop-featured-image', customizer_library_get_default( 'panoramic-blog-crop-featured-image' ) ) );
	add_image_size( 'panoramic_blog_img_top', 1100, 440, true );
}

add_action('init', 'panoramic_set_blog_featured_image_sizes', 10);

function panoramic_register_required_plugins() {
	$plugins = array(
		array(
			'name'      => 'Page Builder by SiteOrigin',
			'slug'      => 'siteorigin-panels',
			'required'  => false
		),
		array(
			'name'      => 'SiteOrigin Widgets Bundle',
			'slug'      => 'so-widgets-bundle',
			'required'  => false
		),
		array(
			'name'      => 'Recent Posts Widget Extended',
			'slug'      => 'recent-posts-widget-extended',
			'required'  => false
		),
		array(
			'name'      => 'SiteOrigin CSS',
			'slug'      => 'so-css',
			'required'  => false
		),
		array(
			'name'      => 'Meta Slider',
			'slug'      => 'ml-slider',
			'required'  => false
		),
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false
		),
		array(
			'name'      => 'Breadcrumb NavXT',
			'slug'      => 'breadcrumb-navxt',
			'required'  => false
		),
		array(
			'name'      => 'WooCommerce',
			'slug'      => 'woocommerce',
			'required'  => false
		),
		array(
			'name'      => 'Anti-Spam',
			'slug'      => 'anti-spam',
			'required'  => false
		),
		array(
			'name'      => 'Yoast SEO',
			'slug'      => 'wordpress-seo',
			'required'  => false
		)
	);

	$config = array(
		'id'           => 'panoramic',            // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => ''                       // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'panoramic_register_required_plugins' );


// Create the custom Social Media Links widget
class panoramic_social_media_links_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'panoramic_social_media_links_widget', 

			// Widget name will appear in UI
			__('Panoramic Social Media Links', 'panoramic'), 

			// Widget description
			array( 'description' => __( 'Displays the social media links set at Appearance > Customize > Social Media Links', 'panoramic' ), ) 
		);
	}

	// Creating the widget front-end
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// This is where you run the code and display the output
		get_template_part( 'library/template-parts/social-links' );
		
		echo $args['after_widget'];
	}
		
	// Widget back-end 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Contact Us', 'panoramic' );
		}
		// Widget admin form
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:', 'panoramic' ); ?>
			</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
	<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

// Register and load the custom widgets
function panoramic_load_custom_widgets() {
	register_widget( 'panoramic_social_media_links_widget' );
}
add_action( 'widgets_init', 'panoramic_load_custom_widgets' );


require get_template_directory() . '/update.php';
