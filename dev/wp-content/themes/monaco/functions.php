<?php
/**
 * Monaco functions and definitions
 *
 * @package Monaco
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'monaco_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function monaco_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Monaco, use a find and replace
	 * to change 'monaco' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'monaco', get_template_directory() . '/languages' );

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
		'primary' => __( 'Primary Menu', 'monaco' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'monaco_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // monaco_setup
add_action( 'after_setup_theme', 'monaco_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function monaco_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'monaco' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'monaco_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function monaco_scripts() {
	wp_enqueue_style( 'monaco-style', get_stylesheet_uri() );
	wp_enqueue_script( 'monaco-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'monaco-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'monaco_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/* Font options */
add_action( 'admin_menu', 'monaco_fonts' );  

function monaco_fonts() {  
    add_theme_page( 'Fonts', 'Fonts', 'edit_theme_options', 'fonts', 'monaco_add_fonts' );  
}

function monaco_add_fonts() {  
?>
    <div class="wrap">  
        <h2>Fonts</h2>
        <form method="post" action="options.php">  
            <?php wp_nonce_field( 'update-fonts' ); ?>  
            <?php settings_fields( 'fonts' ); ?>  
            <?php do_settings_sections( 'fonts' ); ?>  
            <?php submit_button(); ?>  
        </form>  
    </div>  
<?php  
}

add_action( 'admin_init', 'monaco_font_init' );  

function monaco_font_init() {  
    register_setting( 'fonts', 'fonts' );  
    // Settings fields and sections  
    add_settings_section( 'font_section', 'Typography Options', 'monaco_font_description', 'fonts' );  
    add_settings_field( 'body-font', 'Body Font', 'monaco_body_font_field', 'fonts', 'font_section' );  
}  


function monaco_font_description() {  
    echo 'Choose the body font.';  
}  

function monaco_body_font_field() {  

    $options = (array) get_option( 'fonts' );  
    $fonts = monaco_get_fonts();  

    if ( isset( $options['body-font'] ) )  
        $current = $options['body-font'];  
    else  
        $current = 'arial';  

    ?>  
        <select name="fonts[body-font]">  
        <?php foreach( $fonts as $key => $font ): ?>  
            <option <?php if($key == $current) echo "SELECTED"; ?> value="<?php echo $key; ?>"><?php echo $font['name']; ?></option>  
        <?php endforeach; ?>  
        </select>  
    <?php  
} 

function monaco_get_fonts() {  
    $fonts = array(  
        'arial' => array(  
            'name' => 'Arial',  
            'font' => '',  
            'css' => "font-family: Arial, sans-serif;"  
        ),  
        'Port Lligat Slab' => array(  
            'name' => 'Port Lligat Slab',  
            'font' => ' @import url(//fonts.googleapis.com/css?family=Port+Lligat+Slab);',  
            'css' => " font-family: 'Port Lligat Slab', serif;"  
        ),  
        'Roboto' => array(  
            'name' => 'Roboto',  
            'font' => '@import url(//fonts.googleapis.com/css?family=Roboto);',  
            'css' => "font-family: 'Roboto', sans-serif;"  
        ),
        'Happy Monkey' => array(  
            'name' => 'Happy Monkey ',  
            'font' => '@import url(//fonts.googleapis.com/css?family=Happy+Monkey);',  
            'css' => "font-family: 'Happy Monkey', cursive;"
        ),
        'Crushed' => array(  
            'name' => 'Crushed',  
            'font' => '@import url(//fonts.googleapis.com/css?family=Crushed);',  
            'css' => " font-family: 'Crushed', cursive;"
        ),
        'New Rocker ' => array(  
            'name' => 'New Rocker ',  
            'font' => '@import url(//fonts.googleapis.com/css?family=New+Rocker);',  
            'css' => "font-family: 'New Rocker', cursive;"
        ),
        'Rosario' => array(  
            'name' => 'Rosario',  
            'font' => '@import url(//fonts.googleapis.com/css?family=Rosario);',  
            'css' => "font-family: 'Rosario', sans-serif;"
        )
    );  
     return apply_filters( 'monaco_get_fonts', $fonts );  
} 

add_action( 'wp_head', 'monaco_font_head' );  

function monaco_font_head() {  
    $options = (array) get_option( 'fonts' );  
    $fonts = monaco_get_fonts();  
    $body_key = 'arial';  

    if ( isset( $options['body-font'] ) )  
        $body_key = $options['body-font'];  

    if ( isset( $fonts[ $body_key ] ) ) {  
        $body_font = $fonts[ $body_key ];  
        echo '<style>';  
        echo $body_font['font'];  
        echo 'body { ' . $body_font['css'] . ' } ';  
        echo '</style>';  
    }  
} 

if ( ! function_exists( 'monaco_pagination' ) ) :
    function monaco_pagination() {
        global $wp_query;

        $big = 999999999; // need an unlikely integer
        
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages
        ) );
    }
endif;

//Add 3 widgets in footer
register_sidebar( array(
    'name' => __( 'Footer Area One', 'toolbox' ),
    'id' => 'sidebar-3',
    'description' => __( 'An optional widget area for your site footer', 'toolbox' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
) );

register_sidebar( array(
    'name' => __( 'Footer Area Two', 'toolbox' ),
    'id' => 'sidebar-4',
    'description' => __( 'An optional widget area for your site footer', 'toolbox' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
) );

register_sidebar( array(
    'name' => __( 'Footer Area Three', 'toolbox' ),
    'id' => 'sidebar-5',
    'description' => __( 'An optional widget area for your site footer', 'toolbox' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => "</aside>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
) );






/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


//Include shortcode file
require( get_template_directory() . '/inc/shortcode.php' );

// Enqueue Scripts/Styles for our Lightbox
function monaco_add_lightbox() {
    wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'lightbox', get_template_directory_uri() . '/js/lightbox.js', array( 'fancybox' ), false, true );
    wp_enqueue_style( 'lightbox-style', get_template_directory_uri() . '/css/jquery.fancybox.css' );
}
add_action( 'wp_enqueue_scripts', 'monaco_add_lightbox' );
