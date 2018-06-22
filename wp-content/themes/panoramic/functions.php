<?php
/**
 * panoramic functions and definitions
 *
 * @package panoramic
 */
define( 'PANORAMIC_THEME_VERSION' , '10.0.88' );
define( 'PANORAMIC_UPDATE_URL' , 'https://updates.outtheboxthemes.com' );

global $solid_nav_menu_breakpoint, $sticky_header_deactivation_breakpoint, $mobile_menu_breakpoint;
$solid_nav_menu_breakpoint = 960;

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
		$content_width = 800; /* pixels */
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
		'video' 		=> true
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'panoramic_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
    
    add_theme_support( 'title-tag' );
	
 	add_theme_support( 'woocommerce', array(
 		'gallery_thumbnail_image_width' => 300
 	) );
	
	if ( get_theme_mod( 'panoramic-woocommerce-product-image-zoom', true ) ) {	
		add_theme_support( 'wc-product-gallery-zoom' );
	}	
	
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );	
}
endif; // panoramic_theme_setup
add_action( 'after_setup_theme', 'panoramic_theme_setup' );

function panoramic_header_video_settings( $settings ) {
	if ( !wp_is_mobile() || ( wp_is_mobile() && get_theme_mod( 'panoramic-mobile-video-header', customizer_library_get_default( 'panoramic-mobile-video-header') ) ) ) {
		$settings['minWidth']  = 0;
		$settings['minHeight'] = 0;
		return $settings;
	}	
}
add_filter( 'header_video_settings', 'panoramic_header_video_settings' );

// Adjust content_width for full width pages
function panoramic_adjust_content_width() {
    global $content_width;

	if ( panoramic_is_woocommerce_activated() && is_woocommerce() ) {
		$is_woocommerce = true;
	} else {
		$is_woocommerce = false;
	}

    if ( is_page_template( 'template-full-width.php' ) || is_page_template( 'template-full-width-no-page-title.php' ) ) {
    	$content_width = 1096;
	} else if ( ( is_page_template( 'template-left-primary-sidebar.php' ) || is_page_template( 'template-left-primary-sidebar-no-page-title.php' ) || basename( get_page_template() ) === 'page.php' || is_page_template( 'template-right-primary-sidebar-no-page-title.php' ) ) && !is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 1096;
	} else if ( ( is_page_template( 'template-left-secondary-sidebar.php' ) || is_page_template( 'template-left-secondary-sidebar-no-page-title.php' ) || is_page_template( 'template-right-secondary-sidebar.php' ) || is_page_template( 'template-right-secondary-sidebar-no-page-title.php' ) ) && !is_active_sidebar( 'secondary-sidebar' ) ) {
		$content_width = 1096;
	} else if ( ( is_page_template( 'template-left-shop-sidebar.php' ) || is_page_template( 'template-left-shop-sidebar-no-page-title.php' ) || is_page_template( 'template-right-shop-sidebar.php' ) || is_page_template( 'template-right-shop-sidebar-no-page-title.php' ) ) && !is_active_sidebar( 'shop-sidebar' ) ) {
		$content_width = 1096;
    } else if ( ( is_home() || is_archive() ) && !$is_woocommerce && get_theme_mod( 'panoramic-blog-full-width-archive', customizer_library_get_default( 'panoramic-blog-full-width-archive' ) ) ) {
		$content_width = 1096;
	} else if ( is_single() && !$is_woocommerce && get_theme_mod( 'panoramic-blog-full-width-single', customizer_library_get_default( 'panoramic-blog-full-width-single' ) ) ) {
		$content_width = 1096;
	} else if ( is_search() && get_theme_mod( 'panoramic-search-results-full-width', customizer_library_get_default( 'panoramic-search-results-full-width' ) ) ) {
		$content_width = 1096;
	} else if ( panoramic_is_woocommerce_activated() && is_shop() && get_theme_mod( 'panoramic-layout-woocommerce-shop-full-width', customizer_library_get_default( 'panoramic-layout-woocommerce-shop-full-width' ) ) ) {
		$content_width = 1096;
	} else if ( panoramic_is_woocommerce_activated() && is_product() && get_theme_mod( 'panoramic-layout-woocommerce-product-full-width', customizer_library_get_default( 'panoramic-layout-woocommerce-product-full-width' ) ) ) {
		$content_width = 1096;
	} else if ( panoramic_is_woocommerce_activated() && ( is_product_category() || is_product_tag() ) && get_theme_mod( 'panoramic-layout-woocommerce-category-tag-page-full-width', customizer_library_get_default( 'panoramic-layout-woocommerce-category-tag-page-full-width' ) ) ) {
		$content_width = 1096;
	} else if ( $is_woocommerce && !is_active_sidebar( 'shop-sidebar' ) ) {
		$content_width = 1096;
	}
}
add_action( 'template_redirect', 'panoramic_adjust_content_width' );

function panoramic_review_notice() {
	$user_id = get_current_user_id();
	$message = 'Thank you for upgrading to Panoramic Premium! We hope you\'re enjoying the theme, please consider <a href="https://wordpress.org/support/theme/panoramic/reviews/#new-post" target="_blank">rating it on wordpress.org</a> :)';
	
	if ( !get_user_meta( $user_id, 'panoramic_review_notice_dismissed' ) ) {
		$class = 'notice notice-success is-dismissible';
		printf( '<div class="%1$s"><p>%2$s</p><p><a href="?panoramic-review-notice-dismissed">Dismiss this notice</a></p></div>', esc_attr( $class ), $message );
	}
}
add_action( 'admin_notices', 'panoramic_review_notice' );

function panoramic_review_notice_dismissed() {
    $user_id = get_current_user_id();
    if ( isset( $_GET['panoramic-review-notice-dismissed'] ) ) {
		add_user_meta( $user_id, 'panoramic_review_notice_dismissed', 'true', true );
	}
}
add_action( 'admin_init', 'panoramic_review_notice_dismissed' );

function panoramic_admin_notice() {
	$user_id = get_current_user_id();
	
	$response = wp_remote_get( 'http://www.outtheboxthemes.com/wp-json/wp/v2/themes/panoramic/' );
	
	if( is_wp_error( $response ) ) {
		return;
	}
	
	$posts = json_decode( wp_remote_retrieve_body( $response ) );
	
	if( empty( $posts ) ) {
		return;
	} else {
		$message_id = trim( $posts[0]->premium_notification_id );
		$message 	= trim( $posts[0]->premium_notification );
		
		if ( !empty( $message ) && !get_user_meta( $user_id, 'panoramic_admin_notice_' .$message_id. '_dismissed' ) ) {
			$class = 'notice notice-success is-dismissible';
			printf( '<div class="%1$s"><p>%2$s</p><p><a href="?panoramic-admin-notice-dismissed&panoramic-admin-notice-id=%3$s">Dismiss this notice</a></p></div>', esc_attr( $class ), $message, $message_id );
		}
	}
}
add_action( 'admin_notices', 'panoramic_admin_notice' );

function panoramic_admin_notice_dismissed() {
    $user_id = get_current_user_id();
    if ( isset( $_GET['panoramic-admin-notice-dismissed'] ) ) {
    	$panoramic_admin_notice_id = $_GET['panoramic-admin-notice-id'];
		add_user_meta( $user_id, 'panoramic_admin_notice_' .$panoramic_admin_notice_id. '_dismissed', 'true', true );
	}
}
add_action( 'admin_init', 'panoramic_admin_notice_dismissed' );

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
	
		register_sidebar( array(
		'name'          => __( 'Maine Sidebar', 'panoramic' ),
		'id'            => 'sidebar-maine',
		'description'   => 'This sidebar will appear on the Blog or any page that uses either the Default or Left Primary Sidebar template.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
	
		register_sidebar( array(
		'name'          => __( 'hampshire Sidebar', 'panoramic' ),
		'id'            => 'sidebar-hampshire',
		'description'   => 'This sidebar will appear on the Blog or any page that uses either the Default or Left Primary Sidebar template.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
}
add_action( 'widgets_init', 'panoramic_widgets_init' );

function panoramic_set_variables() {
	global $solid_nav_menu_breakpoint, $sticky_header_deactivation_breakpoint, $mobile_menu_breakpoint;
	
	if ( get_theme_mod( 'panoramic-mobile-menu', true ) ) {
		if ( wp_is_mobile() && get_theme_mod( 'panoramic-mobile-menu-activate-on-mobile', false ) ) {
			$mobile_menu_breakpoint = 10000000;
			$solid_nav_menu_breakpoint = 10000000;
		} else {
			$mobile_menu_breakpoint = floatVal( get_theme_mod( 'panoramic-mobile-menu-breakpoint', 960 ) );
			
			if ( $mobile_menu_breakpoint > $solid_nav_menu_breakpoint ) {
				$solid_nav_menu_breakpoint = $mobile_menu_breakpoint;
			}
		}
	}

	if ( get_theme_mod( 'panoramic-header-sticky', false ) ) {
		if ( wp_is_mobile() && get_theme_mod( 'panoramic-header-deactivate-sticky-on-mobile', false ) ) {
			$sticky_header_deactivation_breakpoint = 10000000;
		} else if ( get_theme_mod( 'panoramic-header-sticky-has-min-width', true ) ) {
			$sticky_header_deactivation_breakpoint = floatVal( get_theme_mod( 'panoramic-header-sticky-deactivation-breakpoint', 800 ) );
		} else {
			$sticky_header_deactivation_breakpoint = 0;
		}
	} else {
		$sticky_header_deactivation_breakpoint = 0;
	}
	
	
}
add_action('init', 'panoramic_set_variables', 10);

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
	wp_enqueue_script( 'panoramic-touchswipe-js', get_template_directory_uri() . '/library/js/jquery.touchSwipe.min.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
	
	if ( get_theme_mod( 'panoramic-smart-slider', customizer_library_get_default( 'panoramic-smart-slider' ) ) || get_theme_mod( 'panoramic-smart-header-image', customizer_library_get_default( 'panoramic-smart-header-image' ) ) ) {
		wp_enqueue_script( 'panoramic-fittext-js', get_template_directory_uri() . '/library/js/jquery.fittext.min.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
		wp_enqueue_script( 'panoramic-fitbutton-js', get_template_directory_uri() . '/library/js/jquery.fitbutton.min.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
	}
	
	if ( get_theme_mod( 'panoramic-mobile-fitvids', customizer_library_get_default( 'panoramic-mobile-fitvids' ) ) ) {
		wp_enqueue_script( 'panoramic-fitvids-js', get_template_directory_uri() . '/library/js/jquery.fitvids.min.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
	}	
	
	if ( get_theme_mod( 'panoramic-blog-layout' ) == 'blog-post-masonry-grid-layout' ) {
		// Include our own Masonry and Imagesloaded libraries as the WordPress versions aren't the latest versions
		wp_enqueue_script( 'panoramic-masonry-js', get_template_directory_uri() . '/library/js/jquery.masonry.min.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
		wp_enqueue_script( 'panoramic-imagesloaded-js', get_template_directory_uri() . '/library/js/imagesloaded.min.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
	}
	
	if ( get_theme_mod( 'panoramic-header-sticky', customizer_library_get_default( 'panoramic-header-sticky' ) ) ) {
		
		// If Divi Builder is being used then don't enqueue the theme's Waypoints files and enqueue Waypoints Sticky with Divi Builder's Waypoints file as a dependency
		if ( !class_exists( 'ET_Builder_Plugin' ) ) {
			wp_enqueue_script( 'panoramic-waypoints-js', get_template_directory_uri() . '/library/js/waypoints.min.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
			wp_enqueue_script( 'panoramic-waypoints-sticky-js', get_template_directory_uri() . '/library/js/waypoints-sticky.min.js', array('jquery'), PANORAMIC_THEME_VERSION, true );
		} else {
		    wp_enqueue_script( 'panoramic-waypoints-sticky-js', get_template_directory_uri() . '/library/js/waypoints-sticky.min.js', array('jquery', 'waypoints'), PANORAMIC_THEME_VERSION, true );
		}
	}
	
	wp_enqueue_script( 'panoramic-custom-js', get_template_directory_uri() . '/library/js/custom.js', array('jquery'), PANORAMIC_THEME_VERSION, true );

	wp_enqueue_script( 'panoramic-skip-link-focus-fix-js', get_template_directory_uri() . '/library/js/skip-link-focus-fix.js', array(), PANORAMIC_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
    $variables = array(
    	'smartSlider' => get_theme_mod( 'panoramic-smart-slider', customizer_library_get_default( 'panoramic-smart-slider' ) ),
    	'sliderParagraphMargin' => get_theme_mod( 'panoramic-slider-paragraph-margin', customizer_library_get_default( 'panoramic-slider-paragraph-margin' ) ),
    	'sliderButtonMargin' => get_theme_mod( 'panoramic-slider-button-margin', customizer_library_get_default( 'panoramic-slider-button-margin' ) ),
    	'headerImageParagraphMargin' => get_theme_mod( 'panoramic-header-image-paragraph-margin', customizer_library_get_default( 'panoramic-header-image-paragraph-margin' ) ),
    	'headerImageButtonMargin' => get_theme_mod( 'panoramic-header-image-button-margin', customizer_library_get_default( 'panoramic-header-image-button-margin' ) )
    );

	wp_localize_script( 'panoramic-custom-js', 'variables', $variables );
}
add_action( 'wp_enqueue_scripts', 'panoramic_theme_scripts' );

// If Elementor is being used deregister the theme's Waypoints files and re-enqueue Waypoints Sticky with Elementor's Waypoints file as a dependency
function panoramic_enqueue_sticky_script() {
	wp_deregister_script( 'panoramic-waypoints-js' );
	
	if ( get_theme_mod( 'panoramic-header-sticky', customizer_library_get_default( 'panoramic-header-sticky' ) ) ) {
		wp_deregister_script( 'panoramic-waypoints-sticky-js' );
		wp_enqueue_script( 'panoramic-waypoints-sticky-js', get_template_directory_uri() . '/library/js/waypoints-sticky.min.js', array('jquery', 'elementor-waypoints'), PANORAMIC_THEME_VERSION, true );
	}
}
add_action( 'elementor/frontend/after_enqueue_scripts', 'panoramic_enqueue_sticky_script' );

// If Divi Builder is being used set Panoramic as a non waypoints theme
/*
function disable_divi_builder_waypoints( $themes ) {
	$themes[] = 'Panoramic';
	return $themes;
}
add_action( 'et_pb_no_waypoints_themes', 'disable_divi_builder_waypoints' );
*/

function panoramic_admin_scripts( $hook ) {
	wp_enqueue_style( 'panoramic-admin', get_template_directory_uri().'/library/css/admin.css', array(), PANORAMIC_THEME_VERSION );
    wp_enqueue_script( 'panoramic-admin-js', get_template_directory_uri() . '/library/js/admin.js', PANORAMIC_THEME_VERSION, true );
    
    $slider_categories = get_theme_mod( 'panoramic-slider-categories' );
    $slider_type = get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) );
    
    if ( $slider_categories && $slider_type == 'panoramic-slider-default' ) {
    	$slider_categories = implode(',', $slider_categories );
    } else {
    	$slider_categories = '';
    }
    
    $variables = array(
    	'sliderCategories' => $slider_categories
    );
    
    wp_localize_script( 'panoramic-admin-js', 'variables', $variables );
}
add_action( 'admin_enqueue_scripts', 'panoramic_admin_scripts' );

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

// Set the image compression
function panoramic_set_image_compression() {
	
	if ( get_theme_mod( 'panoramic-media-image-compression', customizer_library_get_default( 'panoramic-media-image-compression' ) ) ) {
		return 82;
	} else {
		return 100;
	}
	
}
add_filter('jpeg_quality', 'panoramic_set_image_compression' ); //function($arg){return 100;});

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
	 * Add Dynamic CSS
	 */
	function panoramic_load_dynamic_css() {
		global $solid_nav_menu_breakpoint, $sticky_header_deactivation_breakpoint, $mobile_menu_breakpoint;
		
		$site_branding_padding_top 			  = floatVal( get_theme_mod( 'site_branding_padding_top', customizer_library_get_default( 'site_branding_padding_top' ) ) );
		$site_branding_padding_bottom 		  = floatVal( get_theme_mod( 'site_branding_padding_bottom', customizer_library_get_default( 'site_branding_padding_bottom' ) ) );
		$panoramic_slider_has_min_width 	  = get_theme_mod( 'panoramic-slider-has-min-width', customizer_library_get_default( 'panoramic-slider-has-min-width' ) );
		$panoramic_slider_min_width 		  = floatVal( get_theme_mod( 'panoramic-slider-min-width', customizer_library_get_default( 'panoramic-slider-min-width' ) ) );
		$panoramic_header_image_has_min_width = get_theme_mod( 'panoramic-header-image-has-min-width', customizer_library_get_default( 'panoramic-header-image-has-min-width' ) );
		$panoramic_header_image_min_width 	  = floatVal( get_theme_mod( 'panoramic-header-image-min-width', customizer_library_get_default( 'panoramic-header-image-min-width' ) ) );
		$mobile_logo_breakpoint 		= floatVal( get_theme_mod( 'panoramic-mobile-logo-breakpoint', customizer_library_get_default( 'panoramic-mobile-logo-breakpoint' ) ) );
		
		require get_template_directory() . '/library/includes/dynamic-css.php';
	}
endif;
add_action( 'wp_head', 'panoramic_load_dynamic_css' );

// Function to check that it's not a single post or the category, tag or author page
if ( ! function_exists( 'panoramic_not_secondary_blog_page' ) ) :
	function panoramic_not_secondary_blog_page() {
		return ( !is_single() && !is_category() && !is_tag() && !is_author() );
	}
endif;

// Function to check if WooCommerce is active.
if ( ! function_exists( 'panoramic_is_woocommerce_activated' ) ) :
	function panoramic_is_woocommerce_activated() {
	    if ( class_exists( 'woocommerce' ) ) {
	    	return true;
		} else {
			return false;
		}
	}
endif;

if ( panoramic_is_woocommerce_activated() ) {
    require get_template_directory() . '/library/includes/woocommerce-inc.php';
}

// Add CSS class to body by filter
function panoramic_add_body_class( $classes ) {
	//$classes[] = 'animating';
	
	if( wp_is_mobile() ) {
		$classes[] = 'mobile-device';
	}
	
	if ( get_theme_mod( 'panoramic-media-crisp-images', customizer_library_get_default( 'panoramic-media-crisp-images' ) ) ) {
		$classes[] = 'crisp-images';
	}
	
	if ( get_theme_mod( 'panoramic-layout-mode', customizer_library_get_default( 'panoramic-layout-mode' ) ) == 'panoramic-layout-mode-one-page' ) {
		$classes[] = 'panoramic-one-page-mode';
	}
	
	if ( panoramic_is_woocommerce_activated() && is_shop() && get_theme_mod( 'panoramic-layout-woocommerce-shop-full-width', customizer_library_get_default( 'panoramic-layout-woocommerce-shop-full-width' ) ) ) {
		$classes[] = 'panoramic-shop-full-width';
	} else {
		$classes[] = get_theme_mod( 'panoramic-woocommerce-shop-sidebar-alignment', customizer_library_get_default( 'panoramic-woocommerce-shop-sidebar-alignment' ) );
	}

	if ( panoramic_is_woocommerce_activated() && is_product() && get_theme_mod( 'panoramic-layout-woocommerce-product-full-width', customizer_library_get_default( 'panoramic-layout-woocommerce-product-full-width' ) ) ) {
		$classes[] = 'panoramic-product-full-width';
	} else {
		$classes[] = get_theme_mod( 'panoramic-woocommerce-shop-sidebar-alignment', customizer_library_get_default( 'panoramic-woocommerce-shop-sidebar-alignment' ) );
	}
	
	if ( panoramic_is_woocommerce_activated() && ( is_product_category() || is_product_tag() ) && get_theme_mod( 'panoramic-layout-woocommerce-category-tag-page-full-width', customizer_library_get_default( 'panoramic-layout-woocommerce-category-tag-page-full-width' ) ) ) {
		$classes[] = 'panoramic-shop-full-width';
	} else {
		$classes[] = get_theme_mod( 'panoramic-woocommerce-shop-sidebar-alignment', customizer_library_get_default( 'panoramic-woocommerce-shop-sidebar-alignment' ) );
	}
	
	if ( !get_theme_mod( 'panoramic-woocommerce-breadcrumbs', customizer_library_get_default( 'panoramic-woocommerce-breadcrumbs' ) ) ) {
		$classes[] = 'panoramic-shop-no-breadcrumbs';
	}
	
	if ( panoramic_is_woocommerce_activated() && is_woocommerce() ) {
		$is_woocommerce = true;
	} else {
		$is_woocommerce = false;
	}
	
	if ( ( is_home() || is_archive() ) && !$is_woocommerce && get_theme_mod( 'panoramic-blog-full-width-archive', customizer_library_get_default( 'panoramic-blog-full-width-archive' ) ) ) {
		$classes[] = 'full-width';
	} else if ( is_single() && !$is_woocommerce && get_theme_mod( 'panoramic-blog-full-width-single', customizer_library_get_default( 'panoramic-blog-full-width-single' ) ) ) {
		$classes[] = 'full-width';
	} else if ( is_search() && get_theme_mod( 'panoramic-search-results-full-width', customizer_library_get_default( 'panoramic-search-results-full-width' ) ) ) {
		$classes[] = 'full-width';
	} else if ( $is_woocommerce && !is_active_sidebar( 'shop-sidebar' ) ) {
		$classes[] = 'full-width';
	}
		
	if ( !get_theme_mod( 'panoramic-layout-display-homepage-page-title', customizer_library_get_default( 'panoramic-layout-display-homepage-page-title' ) ) ) {
		$classes[] = 'no-homepage-page-title';
	}

	if ( !get_theme_mod( 'panoramic-layout-display-page-titles', customizer_library_get_default( 'panoramic-layout-display-page-titles' ) ) ) {
		$classes[] = 'no-page-titles';
	}
	
	if ( ( is_home() || is_single() || is_archive() || is_search() ) && !get_theme_mod( 'panoramic-blog-display-date', customizer_library_get_default( 'panoramic-blog-display-date' ) ) && !get_theme_mod( 'panoramic-blog-display-author', customizer_library_get_default( 'panoramic-blog-display-author' ) ) ) {
		$classes[] = 'no-post-meta-data';
	} elseif ( is_home() || is_single() || is_archive() || is_search() ) {
		$classes[] = 'post-meta-data';
	}
	
	if ( ( is_home() || is_archive() || is_search() ) && !get_theme_mod( 'panoramic-blog-archive-display-post-titles', customizer_library_get_default( 'panoramic-blog-archive-display-post-titles' ) ) ) {
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

// Set the number or products per page
function panoramic_loop_shop_per_page( $cols ) {
	// $cols contains the current number of products per page based on the value stored on Options -> Reading
	// Return the number of products you wanna show per page.
	$cols = get_theme_mod( 'panoramic-woocommerce-products-per-page' );
	
	return $cols;
}
add_filter( 'loop_shop_per_page', 'panoramic_loop_shop_per_page', 20 );

// Set the number or products per row
if (!function_exists('panoramic_loop_shop_columns')) {

	function panoramic_loop_shop_columns() {
		$is_front_page = is_front_page();
		
		if (
			($is_front_page && get_theme_mod( 'panoramic-layout-mode', customizer_library_get_default( 'panoramic-layout-mode' ) ) == 'panoramic-layout-mode-one-page') 
			|| ( is_shop() && get_theme_mod( 'panoramic-layout-woocommerce-shop-full-width', customizer_library_get_default( 'panoramic-layout-woocommerce-shop-full-width' ) ) )
			|| ( ( is_product_category() || is_product_tag() ) && get_theme_mod( 'panoramic-layout-woocommerce-category-tag-page-full-width', customizer_library_get_default( 'panoramic-layout-woocommerce-category-tag-page-full-width' ) ) ) 
			|| !is_active_sidebar( 'shop-sidebar' )
		) {
			return 4;
		} else {
			return 3;
		}
	}

}
add_filter( 'loop_shop_columns', 'panoramic_loop_shop_columns' );

if (!function_exists('panoramic_woocommerce_product_thumbnails_columns')) {
	function panoramic_woocommerce_product_thumbnails_columns() {
		return 3;
	}
}
add_filter ( 'woocommerce_product_thumbnails_columns', 'panoramic_woocommerce_product_thumbnails_columns' );

/**
 * Replace Read more buttons for out of stock items
 */
if (!function_exists('woocommerce_template_loop_add_to_cart')) {
	function woocommerce_template_loop_add_to_cart( $args = array() ) {
		global $product;

		if (!$product->is_in_stock()) {
			echo '<p class="stock out-of-stock">';
			echo __( 'Out of Stock', 'panoramic' );
			echo '</p>';
		} else {
			$defaults = array(
				'quantity' => 1,
				'class' => implode( ' ', array_filter( array(
				'button',
				'product_type_' . $product->get_type(),
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
				) ) )
			);
			
			$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );
			wc_get_template( 'loop/add-to-cart.php', $args );
		}
	}
}

// Set the title prefixes of the archive pages
function panoramic_get_the_archive_title( $title ) {
    if ( is_category() && !get_theme_mod( 'panoramic-blog-display-category-page-title-prefix', customizer_library_get_default( 'panoramic-blog-display-category-page-title-prefix' ) ) ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() && !get_theme_mod( 'panoramic-blog-display-tag-page-title-prefix', customizer_library_get_default( 'panoramic-blog-display-tag-page-title-prefix' ) ) ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">Posts by ' . get_the_author() . '</span>' ;
	}
	
    return $title;
}
add_filter( 'get_the_archive_title', 'panoramic_get_the_archive_title');

// Set the blog excerpt length
function panoramic_excerpt_length( $length ) {
	return get_theme_mod( 'panoramic-blog-excerpt-length', customizer_library_get_default( 'panoramic-blog-excerpt-length' ) );
}
add_filter( 'excerpt_length', 'panoramic_excerpt_length', 999 );

// Unset the blog excerpt read more text
function panoramic_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_more', 'panoramic_excerpt_more' );

// Always check if the blog excerpt needs a read more link
function panoramic_the_excerpt( $output ) {
	global $post;
	
	if ( get_theme_mod( 'panoramic-blog-read-more', customizer_library_get_default( 'panoramic-blog-read-more' ) ) ) {
		$read_more_text = wp_kses_post( get_theme_mod( 'panoramic-blog-read-more-text', customizer_library_get_default( 'panoramic-blog-read-more-text' ) ) );
		$position = get_theme_mod( 'panoramic-blog-read-more-position', customizer_library_get_default( 'panoramic-blog-read-more-position' ) );
		
		if ( !empty( $output ) ) {
			$output = '<p>'. strip_tags( $output ) .' <a href="' . get_permalink( $post->ID ) .'" class="read-more '. esc_attr( $position ) .'">'. $read_more_text .'</a></p>';
		}
	}
	
	return $output;
}
add_filter( 'the_excerpt', 'panoramic_the_excerpt' );

// Set the site logo URL
function panoramic_custom_logo_url( $html ) {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	
	$logo_link_content = '';
	
	if ( get_theme_mod( 'panoramic-logo-link-content', customizer_library_get_default( 'panoramic-logo-link-content' ) ) == "" ) {
		$logo_link_content = home_url( '/' );
	} else {
		$logo_link_content = get_permalink( get_theme_mod( 'panoramic-logo-link-content' ) );
	}	
	
	$html = sprintf( '<a href="%1$s" class="custom-logo-link %2$s" title="%3$s" rel="home" itemprop="url">%4$s</a>',
				esc_url( $logo_link_content ),
				( get_theme_mod( 'panoramic-mobile-logo' ) ? 'hide-for-mobile' : '' ),
				esc_attr( get_bloginfo( 'name', 'display' ) ),
	        	wp_get_attachment_image( $custom_logo_id, 'full', false, array(
	            	'class' => 'custom-logo',
	        		'alt' => esc_attr( get_bloginfo( 'name' ) )
				) )
	    	);

	return $html;    
}
add_filter( 'get_custom_logo', 'panoramic_custom_logo_url' );

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
add_filter( 'widget_posts_args', 'panoramic_filter_recent_posts_widget_parameters' );

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
add_filter( 'widget_categories_args', 'panoramic_set_widget_categories_args' );

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
add_filter( 'widget_categories_dropdown_args', 'panoramic_set_widget_categories_dropdown_arg' );

function panoramic_create_slider_link_content_field(){
 	global $post;
 	$custom_fields = get_post_custom($post->ID);
 	
 	$slider_link_content;
 	
 	// Get the slider link content field
 	if ( isset( $custom_fields["slider_link_content"][0] ) ) {
 		$slider_link_content = $custom_fields["slider_link_content"][0];
 	}
	
 	// Create the slider link content field
	$dropdown = '<select name="slider_link_content">';
	$dropdown .= '<option value="">Not linked</option>';
	$dropdown .= '<option value="custom" ';
	
	if ( $slider_link_content == 'custom' ) {
		$dropdown .= 'selected';
	}
	
	$dropdown .= '>Custom Link</option>';
	$dropdown .= '<optgroup label="Pages">';
	
	// Get all published pages
	$published_pages = get_pages();
	foreach ($published_pages as $published_page) {
		$dropdown .= '<option value="' .$published_page->ID. '" ';
		if ( $published_page->ID == intval( $slider_link_content ) ) $dropdown .= 'selected';
		$dropdown .= '>' .$published_page->post_title. '</option>';
	}
	// Prevent weirdness
	wp_reset_postdata();
	
	$dropdown .= '</optgroup>';
	$dropdown .= '<optgroup label="Posts">';

	// Get all published posts
	$published_posts = get_posts( array( 'posts_per_page'   => -1 ) );
	foreach ($published_posts as $published_post) {
		$dropdown .= '<option value="' .$published_post->ID. '" ';
		if ( $published_post->ID == intval( $slider_link_content ) ) $dropdown .= 'selected';		
		$dropdown .= '>' .$published_post->post_title. '</option>';
	}

	// Prevent weirdness
	wp_reset_postdata();

	$dropdown .= '</optgroup>';
	$dropdown .= '</select>';
	echo $dropdown;
	
 	$slider_link_custom = '';
 	
 	// Get the custom slider link field
 	if ( isset( $custom_fields["slider_link_custom"][0] ) ) {
 		$slider_link_custom = $custom_fields["slider_link_custom"][0];
 	}
	
 	// Create the custom slider link field
	echo '<div id="slider_link_custom" class="section">';
	echo '<label>Custom Link URL</label>';
	echo '<input type="text" name="slider_link_custom" class="" value="'. esc_html($slider_link_custom) .'" />';
	echo '</div>';

 	$slider_link_target = 'same';
 	
 	// Get the slider link target field
 	if ( isset( $custom_fields["slider_link_target"][0] ) ) {
 		$slider_link_target = $custom_fields["slider_link_target"][0];
 	}
	
 	// Create the slider link target field
	echo '<div id="slider_link_target" class="section">';
	echo '<label>Open link in</label>';
	
	$dropdown = '<select name="slider_link_target">';
	$dropdown .= '<option value="same"';
	if ( $slider_link_target == 'same' ) $dropdown .= 'selected';
	$dropdown .= '>Same Window</option>';
	$dropdown .= '<option value="new"';
	if ( $slider_link_target == 'new' ) $dropdown .= 'selected';
	$dropdown .= '>New Window</option>';
	$dropdown .= '</select>';
	echo $dropdown;
	
	echo '</div>';
}

function panoramic_create_slider_shortcode_field(){
 	global $post;
 	$custom_fields = get_post_custom($post->ID);
 	$slider_shortcode = '';
 	
 	if ( isset( $custom_fields["slider_shortcode"][0] ) ) {
 		$slider_shortcode = $custom_fields["slider_shortcode"][0];
 	}
	
	echo '<input type="text" name="slider_shortcode" value="'. esc_html($slider_shortcode) .'" />';
}

function panoramic_create_featured_image_text_field(){
 	global $post;
 	$custom_fields = get_post_custom($post->ID);
 	$featured_image_text = $custom_fields["featured_image_text"][0];
 	
 	echo '<textarea name="featured_image_text" style="height: 150px; min-width: 255px; max-width: 100%;">'. esc_html($featured_image_text) .'</textarea>';
 	echo '<i>'. esc_html( __( 'Use <h2></h2> tags around heading text and <p></p> tags around body text.', 'panoramic' ) ) .'</i>';
}

function panoramic_create_header_image_field( $post ){
	global $content_width, $_wp_additional_image_sizes;
	
	$image_id = get_post_meta( $post->ID, 'header_image_id', true );
	$old_content_width = $content_width;
	$content_width = 254;
	
	if ( $image_id && get_post( $image_id ) ) {
		if ( ! isset( $_wp_additional_image_sizes['post-thumbnail'] ) ) {
			$thumbnail_html = wp_get_attachment_image( $image_id, array( $content_width, $content_width ) );
		} else {
			$thumbnail_html = wp_get_attachment_image( $image_id, 'post-thumbnail' );
		}
		
		if ( ! empty( $thumbnail_html ) ) {
			$content = $thumbnail_html;
			$content .= '<p class="hide-if-no-js"><a href="javascript:;" id="remove_header_image_button" >' . esc_html__( 'Remove header image', 'panoramic' ) . '</a></p>';
			$content .= '<input type="hidden" id="upload_header_image" name="header_image" value="' . esc_attr( $image_id ) . '" />';
		}
		
		$content_width = $old_content_width;

	} else {
		$content = '<img src="" style="width:' . esc_attr( $content_width ) . 'px;height:auto;border:0;display:none;" />';
		$content .= '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Set header image', 'panoramic' ) . '" href="javascript:;" id="upload_header_image_button" class="set-header-image" data-uploader_title="' . esc_attr__( 'Choose an image', 'panoramic' ) . '" data-uploader_button_text="' . esc_attr__( 'Set header image', 'panoramic' ) . '">' . esc_html__( 'Set header image', 'panoramic' ) . '</a></p>';
		$content .= '<input type="hidden" id="upload_header_image" name="header_image" value="" />';

	}
	
	echo $content;	
}

function panoramic_create_header_image_text_field(){
 	global $post;
 	$custom_fields = get_post_custom($post->ID);
 	$header_image_text = $custom_fields["header_image_text"][0];
 	
 	echo '<textarea name="header_image_text" style="height: 150px; min-width: 255px; max-width: 100%;">'. esc_html($header_image_text) .'</textarea>';
 	echo '<i>'. esc_html( __( 'Use <h2></h2> tags around heading text and <p></p> tags around body text.', 'panoramic' ) ) .'</i>';
}

function panoramic_add_meta_boxes(){
	add_meta_box('slider_link_content_container', __( 'Content to link to', 'panoramic' ), 'panoramic_create_slider_link_content_field', array('post'), 'side', 'low');
	add_meta_box('slider_shortcode_container', __( 'Slider Shortcode', 'panoramic' ), 'panoramic_create_slider_shortcode_field', array('post','page'), 'side', 'low');
	add_meta_box('featured_image_text_container', __( 'Featured Image Text', 'panoramic' ), 'panoramic_create_featured_image_text_field', array('page'), 'side', 'low');
	add_meta_box('header_image_container', __( 'Header Image', 'panoramic' ), 'panoramic_create_header_image_field', array('post'), 'side', 'low');
	add_meta_box('header_image_text_container', __( 'Header Image Text', 'panoramic' ), 'panoramic_create_header_image_text_field', array('post'), 'side', 'low');
}
add_action('admin_init', 'panoramic_add_meta_boxes');

function panoramic_create_add_taxonomy_header_image_field( $term ) {
	global $content_width, $_wp_additional_image_sizes;
	
	$old_content_width = $content_width;
	$content_width = 254;

 	ob_start();
	?>
	
	<div class="form-field" id="header_image_container">
		<label for="term_meta[header_image_id]"><?php echo __( 'Header Image', 'panoramic' ); ?></label>
		<?php
		echo '<img src="" style="width:' . esc_attr( $content_width ) . 'px;height:auto;border:0;display:none;" />';
		echo '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Set header image', 'panoramic' ) . '" href="javascript:;" id="upload_header_image_button" class="set-header-image" data-uploader_title="' . esc_attr__( 'Choose an image', 'panoramic' ) . '" data-uploader_button_text="' . esc_attr__( 'Set header image', 'panoramic' ) . '">' . esc_html__( 'Set header image', 'panoramic' ) . '</a></p>';
		echo '<input type="hidden" id="upload_header_image" name="term_meta[header_image_id]" value="" />';
		?>
		<p class="description"><?php echo __( 'Choose the header image to display when viewing the archive page of this category', 'panoramic' ); ?></p>
		<?php wp_nonce_field ( 'update_term_meta', 'term_meta_nonce' ); ?>
	</div>
	
	<?php
 	ob_end_flush();
}

function panoramic_create_edit_taxonomy_header_image_field( $term ){
	global $content_width, $_wp_additional_image_sizes;
	
	$term_meta = get_option( "taxonomy_$term->term_id" );
	
	$image_id = intval( $term_meta['header_image_id'] ) ? intval( $term_meta['header_image_id'] ) : 0;
	
	$old_content_width = $content_width;
	$content_width = 254;
	
	ob_start();
	?>
	<tr class="form-field" id="header_image_container">
	<th scope="row" valign="top"><label for="term_meta[header_image_id]"><?php echo __( 'Header Image', 'panoramic' ); ?></label></th>
		<td>	
			<?php
			if ( $image_id && get_post( $image_id ) ) {
				if ( ! isset( $_wp_additional_image_sizes['post-thumbnail'] ) ) {
					$thumbnail_html = wp_get_attachment_image( $image_id, array( $content_width, $content_width ) );
				} else {
					$thumbnail_html = wp_get_attachment_image( $image_id, 'post-thumbnail' );
				}
				
				if ( ! empty( $thumbnail_html ) ) {
					$content = $thumbnail_html;
					$content .= '<p class="hide-if-no-js"><a href="javascript:;" id="remove_header_image_button" >' . esc_html__( 'Remove header image', 'panoramic' ) . '</a></p>';
					$content .= '<input type="hidden" id="upload_header_image" name="term_meta[header_image_id]" value="' . esc_attr( $image_id ) . '" />';
				}
				
				$content_width = $old_content_width;
		
			} else {
				$content = '<img src="" style="width:' . esc_attr( $content_width ) . 'px;height:auto;border:0;display:none;" />';
				$content .= '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Set header image', 'panoramic' ) . '" href="javascript:;" id="upload_header_image_button" class="set-header-image" data-uploader_title="' . esc_attr__( 'Choose an image', 'panoramic' ) . '" data-uploader_button_text="' . esc_attr__( 'Set header image', 'panoramic' ) . '">' . esc_html__( 'Set header image', 'panoramic' ) . '</a></p>';
				$content .= '<input type="hidden" id="upload_header_image" name="term_meta[header_image_id]" value="" />';
		
			}
			
			echo $content;
			?>
			<p class="description"><?php echo __( 'Choose the header image to display when viewing the archive page of this category', 'panoramic' ); ?></p>
			<?php wp_nonce_field ( 'update_term_meta', 'term_meta_nonce' ); ?>
		</td>
	</tr>
			
	<?php
	ob_end_flush();	
}

function panoramic_create_add_taxonomy_header_image_text_field( $term ) {
 	ob_start();
	?>
	
	<div class="form-field" id="header_image_text_container">
		<label for="term_meta[header_image_text]"><?php echo __( 'Header Image Text', 'panoramic' ); ?></label>
		
		<textarea name="term_meta[header_image_text]" id="term_meta[header_image_text]" rows="5" cols="40"></textarea>
		<p class="description"><?php _e( 'Enter a value for this field', 'panoramic' ); ?></p>
		<?php wp_nonce_field ( 'update_term_meta', 'term_meta_nonce' ) ?>
	</div>
	
	<?php
 	ob_end_flush();
}

function panoramic_create_edit_taxonomy_header_image_text_field( $term ) {
	$term_meta = get_option( "taxonomy_$term->term_id" );

 	ob_start();
	?>

	<tr class="form-field" id="header_image_text_container">
		<th scope="row" valign="top"><label for="term_meta[header_image_text]"><?php echo __( 'Header Image Text', 'panoramic' ); ?></label></th>
		<td>	
			<textarea name="term_meta[header_image_text]" id="term_meta[header_image_text]" rows="5" cols="40"><?php echo esc_attr( $term_meta['header_image_text'] ) ? esc_attr( $term_meta['header_image_text'] ) : ''; ?></textarea>
			<p class="description"><?php _e( 'Enter a value for this field', 'panoramic' ); ?></p>
			<?php wp_nonce_field ( 'update_term_meta', 'term_meta_nonce' ) ?>
		</td>
	</tr>
	
	<?php
 	ob_end_flush();
}

function panoramic_save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = wp_kses_post( stripslashes( $_POST['term_meta'][$key] ) );
			}
		}

		update_option( "taxonomy_$t_id", $term_meta );
	}
}  

function panoramic_category_add_form_fields( $term ) {
	if (!did_action('wp_enqueue_media')) {
		wp_enqueue_media();
	}

	panoramic_create_add_taxonomy_header_image_field( $term );
	panoramic_create_add_taxonomy_header_image_text_field( $term );
}

function panoramic_category_edit_form_fields( $term ) {
	if (!did_action('wp_enqueue_media')) {
		wp_enqueue_media();
	}

	panoramic_create_edit_taxonomy_header_image_field( $term );
	panoramic_create_edit_taxonomy_header_image_text_field( $term );
}

function panoramic_post_tag_add_form_fields( $term ) {
	if (!did_action('wp_enqueue_media')) {
		wp_enqueue_media();
	}

	panoramic_create_add_taxonomy_header_image_field( $term );
	panoramic_create_add_taxonomy_header_image_text_field( $term );
}

function panoramic_post_tag_edit_form_fields( $term ) {
	if (!did_action('wp_enqueue_media')) {
		wp_enqueue_media();
	}

	panoramic_create_edit_taxonomy_header_image_field( $term );
	panoramic_create_edit_taxonomy_header_image_text_field( $term );
}

add_action( 'category_add_form_fields', 'panoramic_category_add_form_fields', 10, 2 );
add_action( 'category_edit_form_fields', 'panoramic_category_edit_form_fields', 10, 2 );
add_action( 'create_category', 'panoramic_save_taxonomy_custom_meta', 10, 2 );
add_action( 'edited_category', 'panoramic_save_taxonomy_custom_meta', 10, 2 );

add_action( 'post_tag_add_form_fields', 'panoramic_post_tag_add_form_fields', 10, 2 );
add_action( 'post_tag_edit_form_fields', 'panoramic_post_tag_edit_form_fields', 10, 2 );
add_action( 'create_post_tag', 'panoramic_save_taxonomy_custom_meta', 10, 2 );
add_action( 'edited_post_tag', 'panoramic_save_taxonomy_custom_meta', 10, 2 );

function panoramic_save_custom_meta( $post_id ){
  	
	if ( isset( $_POST["slider_link_content"] ) ) {
		update_post_meta( $post_id, 'slider_link_content', $_POST["slider_link_content"]);
	}

	if ( isset( $_POST["slider_link_custom"] ) ) {
		update_post_meta( $post_id, 'slider_link_custom', $_POST["slider_link_custom"]);
	}

	if ( isset( $_POST["slider_link_target"] ) ) {
		update_post_meta( $post_id, 'slider_link_target', $_POST["slider_link_target"]);
	}
	
	if ( isset( $_POST["slider_shortcode"] ) ) {
		update_post_meta( $post_id, 'slider_shortcode', $_POST["slider_shortcode"]);
	}
	
	if ( isset( $_POST["featured_image_text"] ) ) {
		update_post_meta( $post_id, 'featured_image_text', $_POST["featured_image_text"]);
	}
	
	if( isset( $_POST['header_image'] ) ) {
		$image_id = (int) $_POST['header_image'];
		update_post_meta( $post_id, 'header_image_id', $image_id );
	}	
	
	if ( isset( $_POST["header_image_text"] ) ) {
		update_post_meta( $post_id, 'header_image_text', $_POST["header_image_text"]);
	}
}
add_action('save_post', 'panoramic_save_custom_meta');

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

// Add the column content
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

function panoramic_wpml_object_ids($object_id, $type) {
	if( is_array( $object_id ) ){
		$translated_object_ids = array();
		
		foreach ( $object_id as $id ) {
			$translated_object_ids[] = apply_filters( 'wpml_object_id', $id, $type, true, $current_language );
		}
		
		return $translated_object_ids;
		
	} else {
		return apply_filters( 'wpml_object_id', $object_id, $type, true, $current_language );

	}
}

function panoramic_setup_nav_menu_item($item) {

	// Add classes to the menu item.
	$item_classes = array();

	if ( is_array( $item->classes ) ) {
		$item_classes = array_diff( $item->classes, array('scroll-link', 'no-highlight') );
	}
	
	if ( get_theme_mod( 'panoramic-layout-mode', customizer_library_get_default( 'panoramic-layout-mode' ) ) == 'panoramic-layout-mode-one-page' ) {
		$pagesToDisplay = panoramic_wpml_object_ids( get_theme_mod( 'panoramic-layout-pages' ), 'page' );
		
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
	$allowedtags["a"] = array(
		'href' => true,
		'class' => true
	);
	$allowedtags["i"] = array(
		'class' => true
	);
}
add_action('init', 'panoramic_allowed_tags', 10);

function panoramic_register_required_plugins() {
	$plugins = array(
		array(
			'name'      => 'Elementor Page Builder',
			'slug'      => 'elementor',
			'required'  => false
		),
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
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false
		),
		array(
			'name'      => 'Photo Gallery by Supsystic',
			'slug'      => 'gallery-by-supsystic',
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
			'name'      => 'Instagram Slider Widget',
			'slug'      => 'instagram-slider-widget',
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

if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) ) {
	define( 'ELEMENTOR_PARTNER_ID', 2127 );
}

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

// Parse the copyright text and replace any placeholder tags
if( !function_exists('panoramic_parse_copyright_text') ) {

	function panoramic_parse_copyright_text( $str ){
		$str = str_replace(
			array( '{site-title}', '{year}'),
			array( get_bloginfo('name'), date('Y') ),
			$str
		);

		return $str;
	}

}

require get_template_directory() . '/update.php';
