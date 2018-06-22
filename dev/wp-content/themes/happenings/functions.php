<?php
if ( ! isset( $content_width ) ) $content_width = 900;

       function happenings_register_my_menus() {
         register_nav_menus(
           array( 'header-menu' => __( 'Header Menu', 'happenings' ) )
           );
         }
       add_action( 'init', 'happenings_register_my_menus' );

add_action( 'widgets_init', 'happenings_slug_widgets_init');
function happenings_slug_widgets_init() {
  register_sidebar(array(
    'name' => __( 'Widgetized Area', 'happenings' ),
    'id'   => 'widgetized-area',
    'description'   => __( 'This is a widgetized area.', 'happenings' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4>',
    'after_title'   => '</h4>'
  )); 

}

add_action('after_setup_theme', 'happenings_setup');
function happenings_setup(){
    load_theme_textdomain('happenings', get_template_directory() . '/languages');
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( "title-tag" );
    add_editor_style();
}

     function happenings_theme_customizer( $wp_customize ) {
    $wp_customize->add_section( 'happenings_logo_section' , array(
    'title'       => __( 'Logo', 'happenings' ),
    'priority'    => 30,
    'description' => __('Upload a logo to replace the Site Title', 'happenings' ),
) );
$wp_customize->add_setting( 'happenings_logo', array(
    'sanitize_callback'        => 'esc_url_raw',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'happenings_logo', array(
    'label'    => __( 'Logo', 'happenings' ),
    'section'  => 'happenings_logo_section',
    'settings' => 'happenings_logo',
) ) );
}
add_action('customize_register', 'happenings_theme_customizer');
add_action( 'customize_register', 'happenings_customize_register' );

$args = array(
  'default-color' => '1e1311',
  'default-image' => get_template_directory_uri() . '/images/wood.jpg',
);
add_theme_support( 'custom-background', $args );

add_theme_support( 'custom-header' );

$defaults = array(
    'default-image'          => '',
    'random-default'         => false,
    'width'                  => 900,
    'height'                 => 375,
    'flex-height'            => false,
    'flex-width'             => false,
    'default-text-color'     => '',
    'header-text'            => false,
    'uploads'                => true,
    'wp-head-callback'       => '',
    'admin-head-callback'    => '',
    'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $defaults );


function happenings_customize_register($wp_customize) {  

$wp_customize->add_section( 'slides', array(
    'title'          => __('Slides', 'happenings'),
    'priority'       => 25,
    'description'    => __('This theme requires slider images be 900 pixels wide and 375 pixels high. When slide images are present, the header image will be deactivated','happenings' ),
) );

$wp_customize->add_setting( 'first_slide', array(
  'sanitize_callback'        => 'esc_url_raw',
    'default'        => '',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'first_slide', array(
    'label'   => __('First Slide','happenings' ),
    'section' => 'slides',
    'settings'   => 'first_slide',
) ) );

$wp_customize->add_setting( 'second_slide', array(
  'sanitize_callback'        => 'esc_url_raw',
    'default'        => '',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'second_slide', array(
    'label'   => __('Second Slide','happenings' ),
    'section' => 'slides',
    'settings'   => 'second_slide',
) ) );

$wp_customize->add_setting( 'third_slide', array(
  'sanitize_callback'        => 'esc_url_raw',
    'default'        => '',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'third_slide', array(
    'label'   => __('Third Slide','happenings' ),
    'section' => 'slides',
    'settings'   => 'third_slide',
) ) );

$wp_customize->add_setting( 'fourth_slide', array(
  'sanitize_callback'        => 'esc_url_raw',
    'default'        => '',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fourth_slide', array(
    'label'   => __('Fourth Slide','happenings' ),
    'section' => 'slides',
    'settings'   => 'fourth_slide',
) ) );

$wp_customize->add_setting( 'fifth_slide', array(
  'sanitize_callback'        => 'esc_url_raw',
    'default'        => '',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fifth_slide', array(
    'label'   => __('Fifth Slide','happenings' ),
    'section' => 'slides',
    'settings'   => 'fifth_slide',
) ) );
}

function happenings_main_scripts(){
  if ( is_singular() ) wp_enqueue_script( "comment-reply" );
  // Add default posts and comments RSS feed links to head.
  wp_enqueue_script('main', get_template_directory_uri() .'/js/js.js', array('jquery'), '03052015', true);

  wp_enqueue_script('slick', get_template_directory_uri() .'/js/slick.js', array('jquery'), '03062015', true);
}
add_action('wp_enqueue_scripts', 'happenings_main_scripts');

function happenings_style_scripts() {
  wp_enqueue_style ('main_style', get_stylesheet_uri());
  wp_enqueue_style ('slick', get_template_directory_uri() .'/slick.css');
  wp_enqueue_style ('font-awesome', get_template_directory_uri() .'/font-awesome.css');
}
add_action('wp_enqueue_scripts', 'happenings_style_scripts');

function happenings_categories_postcount_filter ($variable) {
   $variable = str_replace('(', '<span class="post_count"> (', $variable);
   $variable = str_replace(')', ')</span>', $variable);
   return $variable;
}
add_filter('wp_list_categories','happenings_categories_postcount_filter');

function happenings_archive_postcount_filter ($variable) {
   $variable = str_replace('&nbsp;(', '<span class="post_count">  (', $variable);
   $variable = str_replace(')', ')</span>', $variable);
   return $variable;
}
add_filter('get_archives_link', 'happenings_archive_postcount_filter');

function happenings_links_postcount_filter ($variable) {
   $variable = str_replace('</a>', '</a><span class="post_count">', $variable);
   $variable = str_replace('</li>', '</span></li>', $variable);
   return $variable;
}
add_filter('wp_list_bookmarks','happenings_links_postcount_filter');

function happenings_recent_comments_filter ($variable) {
   $variable = str_replace('<a', '<br><a', $variable);

   return $variable;
}
add_filter('wp_list_comments_args','happenings_recent_comments_filter');

if ( ! function_exists( 'happenings_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function happenings_paging_nav() {
  global $wp_query, $wp_rewrite;

  // Don't print empty markup if there's only one page.
  if ( $wp_query->max_num_pages < 2 ) {
    return;
  }

  $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
  $pagenum_link = html_entity_decode( get_pagenum_link() );
  $query_args   = array();
  $url_parts    = explode( '?', $pagenum_link );

  if ( isset( $url_parts[1] ) ) {
    wp_parse_str( $url_parts[1], $query_args );
  }

  $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
  $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

  $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
  $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

  // Set up paginated links.
  $links = paginate_links( array(
    'base'     => $pagenum_link,
    'format'   => $format,
    'total'    => $wp_query->max_num_pages,
    'current'  => $paged,
    'mid_size' => 1,
    'add_args' => array_map( 'urlencode', $query_args ),
    'prev_text' => __( '&laquo; Prev', 'happenings' ),
    'next_text' => __( 'Next &raquo;', 'happenings' ),
  ) );

  if ( $links ) :

  ?>

  <div class="navigation paging-navigation" role="navigation">
    <div class="pagination loop-pagination">
      <?php echo $links; ?>
    </div><!-- .pagination -->
  </div><!-- .navigation -->

  <?php
  endif;
}
endif;
/* read more link */
add_filter( 'the_content_more_link', 'happenings_modify_read_more_link' );
function happenings_modify_read_more_link() {
return 
 ' <a class="more-link" href="'. get_permalink() . '">' . __( 'Continue Reading &rarr;', 'happenings' ) . '</a>'; }
       ?>