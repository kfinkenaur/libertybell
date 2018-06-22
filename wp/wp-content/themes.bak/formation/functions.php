<?php
/**
 * Formation functions and definitions
 *
 * @package Formation
 * @since Formation 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Formation 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 654; /* pixels */

if ( ! function_exists( 'Formation_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Formation 1.0
 */
function Formation_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Formation, use a find and replace
	 * to change 'Formation' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'Formation', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'Formation' ),
	) );
	
	/**
	 * Add support for post thumbnails
	 */
	add_theme_support('post-thumbnails');
	add_image_size( 100, 300, true);
	add_image_size( 'featured', 670, 300, true );
	add_image_size( 'recent', 700, 400, true );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
}
endif; // Formation_setup
add_action( 'after_setup_theme', 'Formation_setup' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * Hooks into the after_setup_theme action.
 *
 * @since Formation 1.0
 */
function Formation_register_custom_background() {
	$args = array(
		'default-color' => 'EEE',
	);

	$args = apply_filters( 'Formation_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_theme_support( 'custom-background', $args );
	}
}
add_action( 'after_setup_theme', 'Formation_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Formation 1.0
 */
function Formation_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Primary Sidebar', 'Formation' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Secondary Sidebar', 'Formation' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Left Sidebar', 'Formation' ),
		'id' => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	
	register_sidebar(array(
			'name' => __( 'Left Footer Column', 'Formation' ),
			'id'   => 'left_column',
			'description'   => __( 'Widget area for footer left column', 'Formation' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>'
		));
		register_sidebar(array(
			'name' => __( 'Center Footer Column', 'Formation' ),
			'id'   => 'center_column',
			'description'   => __( 'Widget area for footer center column', 'Formation' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>'
		));
		register_sidebar(array(
			'name' => __( 'Right Footer Column', 'Formation' ),
			'id'   => 'right_column',
			'description'   => __( 'Widget area for footer right column', 'Formation' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>'
		));

}
add_action( 'widgets_init', 'Formation_widgets_init' );


/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );



/**
 * Enqueue scripts and styles
 */
function Formation_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	
	if (!is_admin()) {
	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
	
	if (!is_admin()) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
	
	if (!is_admin()) {
		wp_enqueue_script( 'smoothup', get_template_directory_uri() . '/js/smoothscroll.js', array( 'jquery' ), '',  true );
	}
	
	if (!is_admin()) {
	wp_enqueue_style('animate', get_template_directory_uri().'/css/animate.min.css');
	}
	
	if (!is_admin()) {
	wp_enqueue_script( 'inview', get_template_directory_uri() . '/js/Inview.js', array('jquery'));
	}
	
	if (!is_admin()) {
	wp_enqueue_script( 'theme-js', get_template_directory_uri() . '/js/animate.js', array('jquery', 'inview'));
	}
}
add_action( 'wp_enqueue_scripts', 'Formation_scripts' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );


/**
 * Implement home slider
 */

function Formation_add_scripts() {
	if (!is_admin()) {
    wp_enqueue_script('flexslider', get_template_directory_uri().'/js/jquery.flexslider-min.js', array('jquery'));
    wp_enqueue_script('flexslider-init', get_template_directory_uri().'/js/flexslider-init.js', array('jquery', 'flexslider'));
	}
}
add_action('wp_enqueue_scripts', 'Formation_add_scripts');

function Formation_add_styles() {
    wp_enqueue_style('flexslider', get_template_directory_uri().'/js/flexslider.css');
}
add_action('wp_enqueue_scripts', 'Formation_add_styles');

/**
 * Implement the Custom Logo feature
 */
function Formation_theme_customizer( $wp_customize ) {
   
   $wp_customize->add_section( 'Formation_logo_section' , array(
    'title'       => __( 'Logo', 'Formation' ),
    'description' => __( 'Upload a logo to replace the default site name and description in the header', 'Formation' ),
	'priority'    => 30,
) );
   
   $wp_customize->add_setting( 
   		'Formation_logo',
		array(
			'sanitize_callback' => 'Formation_sanitize_url',
		)
	);

   $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'Formation_logo', array(
    'label'    => __( 'Logo', 'Formation' ),
    'section'  => 'Formation_logo_section',
    'settings' => 'Formation_logo',
) ) );

}
add_action('customize_register', 'Formation_theme_customizer');

/**
 * Adds the individual section for contact details
 */
function telnumber_customizer( $wp_customize ) {
	
    $wp_customize->add_section( 'telnumber_section_one', array(
     'title'       => __( 'Contact Details', 'Formation' ),
     'description' => __( 'This is a settings section to change the contact details in the header.', 'Formation' ),
     'priority'    => 130,
        )
    );
	
	$wp_customize->add_setting(
    'telnumber_textbox_header_one', array(
    'default' => __( 'Default Contact Details', 'Formation' ),
    'sanitize_callback' => 'Formation_sanitize_text',
    )
	);
	
	$wp_customize->add_control(
	'telnumber_textbox_header_one', array(
	'label'    => __( 'Contact Details Text', 'Formation' ),
	'section' => 'telnumber_section_one',
	'type' => 'text',
		)
	);

}
add_action( 'customize_register', 'telnumber_customizer' );

/**
 * Adds the individual section for featured text box top
 */
function Formation_customizer( $wp_customize ) {
	
    $wp_customize->add_section( 'featured_section_top', array(
    'title'       => __( 'Featured Text Area', 'Formation' ),
    'description' => __( 'This is a settings section to change the homepage featured text area.', 'Formation' ),
    'priority' => 165,
        )
    );
	
	$wp_customize->add_setting(
    'featured_textbox', array(
    'default' => __( 'Default Featured Text', 'Formation' ),
    'sanitize_callback' => 'Formation_sanitize_text',
    )
);

$wp_customize->add_control(
    'featured_textbox', array(
    'label'    => __( 'Featured Text Header', 'Formation' ),
    'section' => 'featured_section_top',
    'type' => 'text',
    )
);

$wp_customize->add_setting( 
   		'featured_button_url',
		array(
			'sanitize_callback' => 'Formation_sanitize_url',
		)
	);
	
	$wp_customize->add_control(
		'featured_button_url',
		array(
			'label'    => __( 'Featured Button url', 'Formation' ),
			'section' => 'featured_section_top',
			'type' => 'text',
		)
);
}
add_action( 'customize_register', 'Formation_customizer' );


/**
 * Adds the individual section for featured text box 1
 */
function featured_text_one_customizer( $wp_customize ) {
    $wp_customize->add_section(
    'featured_section_one', array(
    'title' => __( 'Featured Text Box 1', 'Formation' ),
    'description' => __( 'This is a settings section to change the homepage featured text area.', 'Formation' ),
    'priority' => 150,
        )
    );
	
	$wp_customize->add_setting( 
   		'header-one-file-upload',
		array(
			'sanitize_callback' => 'Formation_sanitize_url',
		)
	);
 
	$wp_customize->add_control(
    new WP_Customize_Upload_Control(
        $wp_customize,
        'header-one-file-upload',
        array(
            'label' => __( 'Header Image One File Upload', 'Formation' ),
            'section' => 'featured_section_one',
            'settings' => 'header-one-file-upload'
        )
    )
	);
	
	$wp_customize->add_setting( 'header_one_url',
    array(
        'default' => __( 'Header One Link', 'Formation' ),
		'sanitize_callback' => 'Formation_sanitize_url',
    ) );
	
	$wp_customize->add_control(
		'header_one_url',
		array(
			'label'    => __( 'Header Image url', 'Formation' ),
			'section' => 'featured_section_one',
			'type' => 'text',
		)
	);
	
	$wp_customize->add_setting(
    'featured_textbox_header_one',
    array(
        'default' => __( 'Default featured text Header', 'Formation' ),
		'sanitize_callback' => 'Formation_sanitize_text',
    )
	);
	
	$wp_customize->add_control(
		'featured_textbox_header_one',
		array(
			'label' => __( 'Featured Header Text', 'Formation' ),
			'section' => 'featured_section_one',
			'type' => 'text',
		)
	);
	
	$wp_customize->add_setting(
		'featured_textbox_text_one',
		array(
			'default' => __( 'Default featured text', 'Formation' ),
			'sanitize_callback' => 'Formation_sanitize_text',
		)
	);
	
	$wp_customize->add_control(
		'featured_textbox_text_one',
		array(
			'label' => __( 'Featured text', 'Formation' ),
			'section' => 'featured_section_one',
			'type' => 'text',
		)
	);

}
add_action( 'customize_register', 'featured_text_one_customizer' );

/**
 * Adds the individual section for featured text box 2
 */
function featured_text_two_customizer( $wp_customize ) {
    $wp_customize->add_section(
        'featured_section_two',
        array(
            'title' => __( 'Featured Text Box 2', 'Formation' ),
            'description' => __( 'This is a settings section to change the homepage featured text area.', 'Formation' ),
            'priority' => 155,
        )
    );
	
	$wp_customize->add_setting( 
   		'header-two-file-upload',
		array(
			'sanitize_callback' => 'Formation_sanitize_url',
		)
	);
 
	$wp_customize->add_control(
    new WP_Customize_Upload_Control(
        $wp_customize,
        'header-two-file-upload',
        array(
            'label' => __( 'Header Image Two File Upload', 'Formation' ),
            'section' => 'featured_section_two',
            'settings' => 'header-two-file-upload'
        )
    )
	);
	
	$wp_customize->add_setting( 'header_two_url',
    array(
        'default' => __( 'Header Two Link', 'Formation' ),
		'sanitize_callback' => 'Formation_sanitize_url',
    ) );
	
	$wp_customize->add_control(
		'header_two_url',
		array(
			'label'    => __( 'Header Image url', 'Formation' ),
			'section' => 'featured_section_two',
			'type' => 'text',
		)
	);
	
	$wp_customize->add_setting(
    'featured_textbox_header_two',
    array(
        'default' => __( 'Default featured text Header', 'Formation' ),
		'sanitize_callback' => 'Formation_sanitize_text',
    )
	);
	
	$wp_customize->add_control(
		'featured_textbox_header_two',
		array(
			'label' => __( 'Featured Header text', 'Formation' ),
			'section' => 'featured_section_two',
			'type' => 'text',
		)
	);
	
	$wp_customize->add_setting(
		'featured_textbox_text_two',
		array(
			'default' => __( 'Default featured text', 'Formation' ),
			'sanitize_callback' => 'Formation_sanitize_text',
		)
	);
	
	$wp_customize->add_control(
		'featured_textbox_text_two',
		array(
			'label' => __( 'Featured text', 'Formation' ),
			'section' => 'featured_section_two',
			'type' => 'text',
		)
	);
}
add_action( 'customize_register', 'featured_text_two_customizer' );

/**
 * Adds the individual section for featured text box 3
 */
function featured_text_three_customizer( $wp_customize ) {
    $wp_customize->add_section(
        'featured_section_three',
        array(
            'title' => __( 'Featured Text Box 3', 'Formation' ),
            'description' => __( 'This is a settings section to change the homepage featured text area.', 'Formation' ),
            'priority' => 160,
        )
    );
	
	$wp_customize->add_setting( 
   		'header-three-file-upload',
		array(
			'sanitize_callback' => 'Formation_sanitize_url',
		)
	);
 
	$wp_customize->add_control(
    new WP_Customize_Upload_Control(
        $wp_customize,
        'header-three-file-upload',
        array(
            'label' => __( 'Header Image Three File Upload', 'Formation' ),
            'section' => 'featured_section_three',
            'settings' => 'header-three-file-upload'
        )
    )
	);
	
	$wp_customize->add_setting( 'header_three_url',
    array(
        'default' => __( 'Header Three Link', 'Formation' ),
		'sanitize_callback' => 'Formation_sanitize_url',
    ) );
	
	$wp_customize->add_control(
		'header_three_url',
		array(
			'label'    => __( 'Header Image url', 'Formation' ),
			'section' => 'featured_section_three',
			'type' => 'text',
		)
	);
	
	$wp_customize->add_setting(
    'featured_textbox_header_three',
    array(
        'default' => __( 'Default featured text Header', 'Formation' ),
		'sanitize_callback' => 'Formation_sanitize_text',
    )
	);
	
	$wp_customize->add_control(
		'featured_textbox_header_three',
		array(
			'label' => __( 'Featured Header text', 'Formation' ),
			'section' => 'featured_section_three',
			'type' => 'text',
		)
	);
	
	$wp_customize->add_setting(
		'featured_textbox_text_three',
		array(
			'default' => __( 'Default featured text', 'Formation' ),
			'sanitize_callback' => 'Formation_sanitize_text',
		)
	);
	
	$wp_customize->add_control(
		'featured_textbox_text_three',
		array(
			'label' => __( 'Featured text', 'Formation' ),
			'section' => 'featured_section_three',
			'type' => 'text',
		)
	);
}
add_action( 'customize_register', 'featured_text_three_customizer' );


/**
 * Implement excerpt for homepage slider
 */
function get_slider_excerpt(){
$excerpt = get_the_content();
$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$excerpt = substr($excerpt, 0, 150);
$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
return $excerpt;
}

/**
 * Implement excerpt for homepage recent posts
 */
function get_recentposts_excerpt(){
$excerpt = get_the_content();
$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$excerpt = substr($excerpt, 0, 250);
$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
return $excerpt;
}

/**
 * sanitize customizer text input
 */
 function Formation_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

function Formation_sanitize_url( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

add_filter( 'wp_title', 'Formation_wp_title' );


/**
 * Implement excerpt for homepage thumbnails
 */
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

/**
 * Filters the page title appropriately depending on the current page
 *
 * This function is attached to the 'wp_title' fiilter hook.
 *
 * @uses	home_url()
 * @uses	is_home()
 * @uses	is_front_page()
 */
function Formation_wp_title( $title ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	$site_description = get_bloginfo( 'description' );

	$filtered_title = $title . get_bloginfo( 'name' );
	$filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' | ' . $site_description: '';
	$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s', 'Formation' ), max( $paged, $page ) ) : '';

	return $filtered_title;
}

/**
 * Breadcrumbs
 *
 * This functions displays page breadcrumbs
 */
function formation_breadcrumbs() {
 
	/* === OPTIONS === */
	$text['home']     = __('Home','Formation'); // text for the 'Home' link
	$text['category'] = __('Archive by Category "%s"','Formation'); // text for a category page
	$text['search']   = __('Search Results for "%s" Query','Formation'); // text for a search results page
	$text['tag']      = __('Posts Tagged "%s"','Formation'); // text for a tag page
	$text['author']   = __('Articles Posted by %s','Formation'); // text for an author page
	$text['404']      = __('Error 404','Formation'); // text for the 404 page
 
	$show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
	$show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
	$show_title     = 1; // 1 - show the title for the links, 0 - don't show
	$delimiter      = ' / '; // delimiter between crumbs
	$before         = '<span class="current">'; // tag before the current crumb
	$after          = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */
 
	global $post;
	$home_link    = home_url('/');
	$link_before  = '<span typeof="v:Breadcrumb">';
	$link_after   = '</span>';
	$link_attr    = ' rel="v:url" property="v:title"';
	$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
	$parent_id    = $parent_id_2 = $post->post_parent;
	$frontpage_id = get_option('page_on_front');
 
	if (is_home() || is_front_page()) {
 
		if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';
 
	} else {
 
		echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
		if ($show_home_link == 1) {
			echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
			if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
		}
 
		if ( is_category() ) {
			$this_cat = get_category(get_query_var('cat'), false);
			if ($this_cat->parent != 0) {
				$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
			}
			if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
 
		} elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;
 
		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;
 
		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;
 
		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;
 
		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
				if ($show_current == 1) echo $before . get_the_title() . $after;
			}
 
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
 
		} elseif ( is_attachment() ) {
			$parent = get_post($parent_id);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
			$cats = str_replace('</a>', '</a>' . $link_after, $cats);
			if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
			echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
 
		} elseif ( is_page() && !$parent_id ) {
			if ($show_current == 1) echo $before . get_the_title() . $after;
 
		} elseif ( is_page() && $parent_id ) {
			if ($parent_id != $frontpage_id) {
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					if ($parent_id != $frontpage_id) {
						$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					}
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
			}
			if ($show_current == 1) {
				if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
				echo $before . get_the_title() . $after;
			}
 
		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
 
		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;
 
		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}
 
		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page', 'Formation') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
 
		echo '</div><!-- .breadcrumbs -->';
 
	}
} // end formation_breadcrumbs()


/**
 * Social Media Links on Contributors template
 */
function author_social_media( $socialmedialinks ) {

    $socialmedialinks['google_profile'] = 'Google+ URL';
    $socialmedialinks['twitter_profile'] = 'Twitter URL';
    $socialmedialinks['facebook_profile'] = 'Facebook URL';
    $socialmedialinks['linkedin_profile'] = 'Linkedin URL';

 return $socialmedialinks;
 }
 
add_filter( 'user_contactmethods', 'author_social_media', 10, 1);

/**
 * Custom "more" link format
 */
function new_excerpt_more($more) {
       global $post;
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/**
 * Adds the individual section for client logo 1
 */
function client_logo_one_customizer( $wp_customize ) {
    $wp_customize->add_section(
    'logo_section_one', array(
    'title' => __( 'Client logo 1', 'Formation' ),
    'description' => __( 'This is a settings section to change the homepage logo area one.', 'Formation' ),
    'priority' => 850,
        )
    );

	$wp_customize->add_setting( 
   		'logo-one-file-upload',
		array(
			'sanitize_callback' => 'Formation_sanitize_url',
		)
	);
 
	$wp_customize->add_control(
    new WP_Customize_Upload_Control(
        $wp_customize,
        'logo-one-file-upload',
        array(
            'label' => __( 'Client logo One File Upload', 'Formation' ),
            'section' => 'logo_section_one',
            'settings' => 'logo-one-file-upload'
        )
    )
	);
	
	$wp_customize->add_setting( 'logo_one_url',
    array(
        'default' => __( 'logo One Link', 'Formation' ),
		'sanitize_callback' => 'Formation_sanitize_url',
    ) );
	
	$wp_customize->add_control(
		'logo_one_url',
		array(
			'label'    => __( 'Client logo one url', 'Formation' ),
			'section' => 'logo_section_one',
			'type' => 'text',
		)
	);

}
add_action( 'customize_register', 'client_logo_one_customizer' );


/**
 * Adds the individual section for client logo 2
 */
function client_logo_two_customizer( $wp_customize ) {
    $wp_customize->add_section(
    'logo_section_two', array(
    'title' => __( 'Client logo 2', 'Formation' ),
    'description' => __( 'This is a settings section to change the homepage logo area two.', 'Formation' ),
    'priority' => 900,
        )
    );

	$wp_customize->add_setting( 
   		'logo-two-file-upload',
		array(
			'sanitize_callback' => 'Formation_sanitize_url',
		)
	);
 
	$wp_customize->add_control(
    new WP_Customize_Upload_Control(
        $wp_customize,
        'logo-two-file-upload',
        array(
            'label' => __( 'Client logo two File Upload', 'Formation' ),
            'section' => 'logo_section_two',
            'settings' => 'logo-two-file-upload'
        )
    )
	);
	
	$wp_customize->add_setting( 'logo_two_url',
    array(
        'default' => __( 'logo two Link', 'Formation' ),
		'sanitize_callback' => 'Formation_sanitize_url',
    ) );
	
	$wp_customize->add_control(
		'logo_two_url',
		array(
			'label'    => __( 'Client logo two url', 'Formation' ),
			'section' => 'logo_section_two',
			'type' => 'text',
		)
	);

}
add_action( 'customize_register', 'client_logo_two_customizer' );


/**
 * Adds the individual section for client logo 3
 */
function client_logo_three_customizer( $wp_customize ) {
    $wp_customize->add_section(
    'logo_section_three', array(
    'title' => __( 'Client logo 3', 'Formation' ),
    'description' => __( 'This is a settings section to change the homepage logo area three.', 'Formation' ),
    'priority' => 950,
        )
    );

	$wp_customize->add_setting( 
   		'logo-three-file-upload',
		array(
			'sanitize_callback' => 'Formation_sanitize_url',
		)
	);
 
	$wp_customize->add_control(
    new WP_Customize_Upload_Control(
        $wp_customize,
        'logo-three-file-upload',
        array(
            'label' => __( 'Client logo three File Upload', 'Formation' ),
            'section' => 'logo_section_three',
            'settings' => 'logo-three-file-upload'
        )
    )
	);
	
	$wp_customize->add_setting( 'logo_three_url',
    array(
        'default' => __( 'logo three Link', 'Formation' ),
		'sanitize_callback' => 'Formation_sanitize_url',
    ) );
	
	$wp_customize->add_control(
		'logo_three_url',
		array(
			'label'    => __( 'Client logo three url', 'Formation' ),
			'section' => 'logo_section_three',
			'type' => 'text',
		)
	);

}
add_action( 'customize_register', 'client_logo_three_customizer' );


/**
 * Adds the individual section for client logo 4
 */
function client_logo_four_customizer( $wp_customize ) {
    $wp_customize->add_section(
    'logo_section_four', array(
    'title' => __( 'Client logo 4', 'Formation' ),
    'description' => __( 'This is a settings section to change the homepage logo area four.', 'Formation' ),
    'priority' => 1000,
        )
    );

	$wp_customize->add_setting( 
   		'logo-four-file-upload',
		array(
			'sanitize_callback' => 'Formation_sanitize_url',
		)
	);
 
	$wp_customize->add_control(
    new WP_Customize_Upload_Control(
        $wp_customize,
        'logo-four-file-upload',
        array(
            'label' => __( 'Client logo four File Upload', 'Formation' ),
            'section' => 'logo_section_four',
            'settings' => 'logo-four-file-upload'
        )
    )
	);
	
	$wp_customize->add_setting( 'logo_four_url',
    array(
        'default' => __( 'logo four Link', 'Formation' ),
		'sanitize_callback' => 'Formation_sanitize_url',
    ) );
	
	$wp_customize->add_control(
		'logo_four_url',
		array(
			'label'    => __( 'Client logo four url', 'Formation' ),
			'section' => 'logo_section_four',
			'type' => 'text',
		)
	);

}
add_action( 'customize_register', 'client_logo_four_customizer' );