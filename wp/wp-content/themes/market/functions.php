<?php
/**
 * Market functions and definitions
 *
 * @package Market
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/**
 * Initialize Options Panel
 */
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once get_template_directory() . '/inc/options-framework.php';
}

if ( ! function_exists( 'market_setup' ) ) :

function market_setup() {

	load_theme_textdomain( 'market', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_image_size('homepage-banner',400,350,true);

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'market' ),
		'top' => __( 'Top Menu', 'market' ),
	) );

	add_theme_support( 'custom-background', apply_filters( 'market_custom_background_args', array(
		'default-color' => 'f7f7f7',
		'default-image' => '',
	) ) );
	add_theme_support( 'post-formats', array( 'video' ) );
	
	add_theme_support( 'woocommerce' );
	}
	
endif; // market_setup
add_action( 'after_setup_theme', 'market_setup' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
//remove_filter('woocommerce_show_page_title');	

function market_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'market' ),
		'description'   => __( 'This is the Primary Sidebar. It will be displayed on Posts Pages.', 'market'),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Left', 'market' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Center', 'market' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Right', 'market' ),
		'id'            => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'market_widgets_init' );

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
	
});
</script>
<?php
}

function market_scripts() {
	wp_enqueue_style( 'market-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,700,600' );
	wp_enqueue_style( 'market-basic-style', get_stylesheet_uri() );
	if ( (function_exists( 'of_get_option' )) && (of_get_option('sidebar-layout', true) != 1) ) {
		if (of_get_option('sidebar-layout', true) ==  'right') {
			wp_enqueue_style( 'market-layout', get_template_directory_uri()."/css/layouts/content-sidebar.css" );
		}
		else {
			wp_enqueue_style( 'market-layout', get_template_directory_uri()."/css/layouts/sidebar-content.css" );
		}	
	}
	else {
		wp_enqueue_style( 'market-layout', get_template_directory_uri()."/css/layouts/content-sidebar.css" );
	}
				
	wp_enqueue_style( 'market-bootstrap-style', get_template_directory_uri()."/css/bootstrap/bootstrap.min.css", array('market-layout') );
		
	if ( (function_exists( 'of_get_option' )) && (of_get_option('theme-skin', true) != 1) ) {
		wp_enqueue_style( 'market-main-skin', get_template_directory_uri()."/css/skins/".of_get_option('theme-skin').".css", array('market-layout','market-bootstrap-style') );
	}
	else {
		wp_enqueue_style( 'market-main-skin', get_template_directory_uri()."/css/skins/default.css", array('market-layout','market-bootstrap-style') );
	}
	wp_enqueue_script( 'market-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'market-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
		
	wp_enqueue_style( 'market-nivo-slider-default-theme', get_template_directory_uri()."/css/nivo/slider/themes/default/default.css" );
	
	wp_enqueue_style( 'market-nivo-slider-style', get_template_directory_uri()."/css/nivo/slider/nivo.css" );
	
	wp_enqueue_script( 'market-nivo-slider', get_template_directory_uri() . '/js/nivo.slider.js', array('jquery') );
		
	wp_enqueue_script( 'market-mm', get_template_directory_uri() . '/js/mm.js', array('jquery') );
	
	wp_enqueue_script( 'market-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery') );
			
	wp_enqueue_script( 'market-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery') );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'market-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'market_scripts' );
function market_custom_head_codes() {
 if ( (function_exists( 'of_get_option' )) && (of_get_option('style2', true) != 1) ) {
	echo "<style>".of_get_option('style2', true)."</style>";
 }
 
  echo "<script>jQuery(window).load(function() { jQuery('#slider').nivoSlider({effect:'boxRandom', pauseTime: 5000 }); });</script>";
 
	 echo "<script>jQuery(document).ready( function() { jQuery('.main-navigation ul.menu').mobileMenu({switchWidth: 768}); });</script>";
	 echo "<style>h1.menu-toggle {display: none !important;}.td_mobile_menu_wrap select{margin-left:-20px;margin-top: 20px;}</style>";
}	
add_action('wp_head', 'market_custom_head_codes');

function market_nav_menu_args( $args = '' )
{
    $args['container'] = false;
    return $args;
} // function
add_filter( 'wp_page_menu_args', 'market_nav_menu_args' );

function market_pagination() {
	global $wp_query;
	$big = 12345678;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $wp_query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
	            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
	            echo '<div class="pagination"><div><ul>';
	            echo '<li><span>'. $paged . ' of ' . $wp_query->max_num_pages .'</span></li>';
	            foreach ( $page_format as $page ) {
	                    echo "<li>$page</li>";
	            }
	           echo '</ul></div></div>';
	 }
}
if (class_exists('woocommerce')) {
	add_filter('add_to_cart_fragments', 'market_header_add_to_cart_fragment');
 
	function market_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		
		ob_start();
		
		?>
		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
		<?php
		
		$fragments['a.cart-contents'] = ob_get_clean();
		
		return $fragments;
		
	}
	
	/**
	 * Set Default Thumbnail Sizes for Woo Commerce Product Pages, on Theme Activation
	 */
	global $pagenow;
	if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) 			add_action( 'init', 'market_woocommerce_image_dimensions', 1 );
	/**
	 * Define image sizes
	 */
	function market_woocommerce_image_dimensions() {
	  	$catalog = array(
			'width' 	=> '500',	// px
			'height'	=> '500',	// px
			'crop'		=> 1 		// true
		);
		$single = array(
			'width' 	=> '600',	// px
			'height'	=> '600',	// px
			'crop'		=> 1 		// true
		);	 
		$thumbnail = array(
			'width' 	=> '350',	// px
			'height'	=> '350',	// px
			'crop'		=> 0 		// false
		);	 
		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
	}
}
/**
 * Custom Functions for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/jetpack.php';