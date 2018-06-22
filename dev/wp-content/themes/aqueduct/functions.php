<?php
/**
 * HowlThemes functions and definitions
 *
 * @package HowlThemes
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
  $content_width = 640; /* pixels */
}

if ( ! function_exists( 'drag_themes_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function howlthemes_setup() {

  load_theme_textdomain( 'aqueduct', get_template_directory() . '/languages' );

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  /*
   * Let WordPress manage the document title.
   * By adding theme support, we declare that this theme does not use a
   * hard-coded <title> tag in the document head, and expect WordPress to
   * provide it for us.
   */
  add_theme_support( 'title-tag' );

  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  add_theme_support( 'post-thumbnails' );

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'aqueduct' ),
    'secondary' => __( 'Secondary Menu', 'aqueduct' ),
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
   
  add_theme_support( 'post-formats', array(
    'aside', 'image', 'video', 'quote', 'link',
  ) );
*/
  
}
endif; // epidermis_das_themes_setup
add_action( 'after_setup_theme', 'howlthemes_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function howlthemes_widgets_init() {
  register_sidebar( array(
    'name'          => __( 'Sidebar', 'aqueduct' ),
    'id'            => 'sidebar-1',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );
}
add_action( 'widgets_init', 'howlthemes_widgets_init' );

function howlthemes_fwidgets_init() {
  register_sidebar( array(
    'name'          => __( 'Footer', 'aqueduct' ),
    'id'            => 'footer-1',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="fwidget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="fwidget-title">',
    'after_title'   => '</h2>',
  ) );
}
add_action( 'widgets_init', 'howlthemes_fwidgets_init' );

function howlthemes_excerpt_length( $length ) {
  return 25;
}
add_filter( 'excerpt_length', 'howlthemes_excerpt_length', 999 );

/**
 * Enqueue scripts and styles.
 */
function howlthemes_scripts() {
  wp_enqueue_style( 'drag-themes-style', get_stylesheet_uri(), '', true);
    if(get_theme_mod("typography-setting")){
  wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family='. str_replace(" ", "+", get_theme_mod("typography-setting")) .':400,700');
}

else{
    wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Titillium+Web:400,600,700');
}
  wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.min.css');
        wp_enqueue_script( 'myscript', get_template_directory_uri().'/js/dragjs.js', array( 'jquery' ), '', true);
  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply', '', true);
  }
}
add_action( 'wp_enqueue_scripts', 'howlthemes_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * HowlThemes Functions
 */
require get_template_directory() . '/inc/dragfun/dragthemesfunction.php';


/*------------------------
Removing Some Default Widgets
--------------------*/
 function howlthemes_unregister_default_widgets() {
     unregister_widget('WP_Widget_Pages');
     unregister_widget('WP_Widget_Links');
     unregister_widget('WP_Widget_Meta');
     unregister_widget('WP_Widget_RSS');
     unregister_widget('WP_Nav_Menu_Widget');
     unregister_widget('WP_Widget_Recent_Posts');
 }
 add_action('widgets_init', 'howlthemes_unregister_default_widgets', 11);

/**
 * Title         : Aqua Resizer
 * Description   : Resizes WordPress images on the fly
 * Version       : 1.2.0
 * Author        : Syamil MJ
 * Author URI    : http://aquagraphite.com
 * License       : WTFPL - http://sam.zoy.org/wtfpl/
 * Documentation : https://github.com/sy4mil/Aqua-Resizer/
 *
 * @param string  $url      - (required) must be uploaded using wp media uploader
 * @param int     $width    - (required)
 * @param int     $height   - (optional)
 * @param bool    $crop     - (optional) default to soft crop
 * @param bool    $single   - (optional) returns an array if false
 * @param bool    $upscale  - (optional) resizes smaller images
 * @uses  wp_upload_dir()
 * @uses  image_resize_dimensions()
 * @uses  wp_get_image_editor()
 *
 * @return str|array
 */

if(!class_exists('Aq_Resize')) {
    class Aq_Exception extends Exception {}

    class Aq_Resize
    {
        /**
         * The singleton instance
         */
        static private $instance = null;

        /**
         * Should an Aq_Exception be thrown on error?
         * If false (default), then the error will just be logged.
         */
        public $throwOnError = false;

        /**
         * No initialization allowed
         */
        private function __construct() {}

        /**
         * No cloning allowed
         */
        private function __clone() {}

        /**
         * For your custom default usage you may want to initialize an Aq_Resize object by yourself and then have own defaults
         */
        static public function getInstance() {
            if(self::$instance == null) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        /**
         * Run, forest.
         */
        public function process( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
            try {
                // Validate inputs.
                if (!$url)
                    throw new Aq_Exception('$url parameter is required');
                if (!$width)
                    throw new Aq_Exception('$width parameter is required');
                if (!$height)
                    throw new Aq_Exception('$height parameter is required');

                // Caipt'n, ready to hook.
                if ( true === $upscale ) add_filter( 'image_resize_dimensions', array($this, 'aq_upscale'), 10, 6 );

                // Define upload path & dir.
                $upload_info = wp_upload_dir();
                $upload_dir = $upload_info['basedir'];
                $upload_url = $upload_info['baseurl'];
                
                $http_prefix = "http://";
                $https_prefix = "https://";
                $relative_prefix = "//"; // The protocol-relative URL
                
                /* if the $url scheme differs from $upload_url scheme, make them match 
                   if the schemes differe, images don't show up. */
                if(!strncmp($url,$https_prefix,strlen($https_prefix))){ //if url begins with https:// make $upload_url begin with https:// as well
                    $upload_url = str_replace($http_prefix,$https_prefix,$upload_url);
                }
                elseif(!strncmp($url,$http_prefix,strlen($http_prefix))){ //if url begins with http:// make $upload_url begin with http:// as well
                    $upload_url = str_replace($https_prefix,$http_prefix,$upload_url);      
                }
                elseif(!strncmp($url,$relative_prefix,strlen($relative_prefix))){ //if url begins with // make $upload_url begin with // as well
                    $upload_url = str_replace(array( 0 => "$http_prefix", 1 => "$https_prefix"),$relative_prefix,$upload_url);
                }
                

                // Check if $img_url is local.
                if ( false === strpos( $url, $upload_url ) )
                    throw new Aq_Exception('Image must be local: ' . $url);

                // Define path of image.
                $rel_path = str_replace( $upload_url, '', $url );
                $img_path = $upload_dir . $rel_path;

                // Check if img path exists, and is an image indeed.
                if ( ! file_exists( $img_path ) or ! getimagesize( $img_path ) )
                    throw new Aq_Exception('Image file does not exist (or is not an image): ' . $img_path);

                // Get image info.
                $info = pathinfo( $img_path );
                $ext = $info['extension'];
                list( $orig_w, $orig_h ) = getimagesize( $img_path );

                // Get image size after cropping.
                $dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
                $dst_w = $dims[4];
                $dst_h = $dims[5];

                // Return the original image only if it exactly fits the needed measures.
                if ( ! $dims && ( ( ( null === $height && $orig_w == $width ) xor ( null === $width && $orig_h == $height ) ) xor ( $height == $orig_h && $width == $orig_w ) ) ) {
                    $img_url = $url;
                    $dst_w = $orig_w;
                    $dst_h = $orig_h;
                } else {
                    // Use this to check if cropped image already exists, so we can return that instead.
                    $suffix = "{$dst_w}x{$dst_h}";
                    $dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
                    $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

                    if ( ! $dims || ( true == $crop && false == $upscale && ( $dst_w < $width || $dst_h < $height ) ) ) {
                        // Can't resize, so return false saying that the action to do could not be processed as planned.
                        throw new Aq_Exception('Unable to resize image because image_resize_dimensions() failed');
                    }
                    // Else check if cache exists.
                    elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
                        $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
                    }
                    // Else, we resize the image and return the new resized image url.
                    else {

                        $editor = wp_get_image_editor( $img_path );

                        if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) ) {
                            throw new Aq_Exception('Unable to get WP_Image_Editor: ' . 
                                                   $editor->get_error_message() . ' (is GD or ImageMagick installed?)');
                        }

                        $resized_file = $editor->save();

                        if ( ! is_wp_error( $resized_file ) ) {
                            $resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
                            $img_url = $upload_url . $resized_rel_path;
                        } else {
                            throw new Aq_Exception('Unable to save resized image file: ' . $editor->get_error_message());
                        }

                    }
                }

                // Okay, leave the ship.
                if ( true === $upscale ) remove_filter( 'image_resize_dimensions', array( $this, 'aq_upscale' ) );

                // Return the output.
                if ( $single ) {
                    // str return.
                    $image = $img_url;
                } else {
                    // array return.
                    $image = array (
                        0 => $img_url,
                        1 => $dst_w,
                        2 => $dst_h
                    );
                }

                return $image;
            }
            catch (Aq_Exception $ex) {
                error_log('Aq_Resize.process() error: ' . $ex->getMessage());

                if ($this->throwOnError) {
                    // Bubble up exception.
                    throw $ex;
                }
                else {
                    // Return false, so that this patch is backwards-compatible.
                    return false;
                }
            }
        }

        /**
         * Callback to overwrite WP computing of thumbnail measures
         */
        function aq_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
            if ( ! $crop ) return null; // Let the wordpress default function handle this.

            // Here is the point we allow to use larger image size than the original one.
            $aspect_ratio = $orig_w / $orig_h;
            $new_w = $dest_w;
            $new_h = $dest_h;

            if ( ! $new_w ) {
                $new_w = intval( $new_h * $aspect_ratio );
            }

            if ( ! $new_h ) {
                $new_h = intval( $new_w / $aspect_ratio );
            }

            $size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

            $crop_w = round( $new_w / $size_ratio );
            $crop_h = round( $new_h / $size_ratio );

            $s_x = floor( ( $orig_w - $crop_w ) / 2 );
            $s_y = floor( ( $orig_h - $crop_h ) / 2 );

            return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
        }
    }
}
if(!function_exists('aq_resize')) {

    /**
     * This is just a tiny wrapper function for the class above so that there is no
     * need to change any code in your own WP themes. Usage is still the same :)
     */
    function aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
        $aq_resize = Aq_Resize::getInstance();
        return $aq_resize->process( $url, $width, $height, $crop, $single, $upscale );
    }
}


/*-------------------------------------------------------------
Social Media Follow Buttons
-----------------------------------------*/
function howlthemes_socialmediafollow(){
   if(get_theme_mod("fsocial_url")){
    echo'<li><a class="fblink" href="'.esc_url(get_theme_mod("fsocial_url")).'" target="blank"><i class="fa fa-facebook"></i></a></li>';
}
   if(get_theme_mod("tsocial_url")){
echo'<li><a class="twitterlink" href="'.esc_url(get_theme_mod("tsocial_url")).'" target="blank"><i class="fa fa-twitter"></i></a></li>';
}
   if(get_theme_mod("gsocial_url")){
echo'
<li><a class="gpluslink" href="'.esc_url(get_theme_mod("gsocial_url")).'" target="blank"><i class="fa fa-google-plus"></i></a></li>';
}
if(get_theme_mod("psocial_url")){
echo'
 <li><a class="pinlink" href="'.esc_url(get_theme_mod("psocial_url")).'" target="blank"><i class="fa fa-pinterest-p"></i></a></li>';
}
if(get_theme_mod("isocial_url")){
echo'
 <li><a class="instalink" href="'.esc_url(get_theme_mod("isocial_url")).'" target="blank"><i class="fa fa-instagram"></i></a></li>';
}
if(get_theme_mod("lsocial_url")){
echo'<li><a class="linkdlink" href="'.esc_url(get_theme_mod("lsocial_url")).'" target="blank"><i class="fa fa-linkedin"></i></a></li>';
}
if(get_theme_mod("ysocial_url")){
echo' <li><a class="ytubelink" href="'.esc_url(get_theme_mod("ysocial_url")).'" target="blank"><i class="fa fa-youtube"></i></a></li>';
}
if(get_theme_mod("rsocial_url")){
echo' <li><a class="rsslink" href="'.esc_url(get_theme_mod("rsocial_url")).'" target="blank"><i class="fa fa-rss"></i></a></li>';
}
}
/*------------------
* Support Core Logo
--------------------*/
function aqueduct_logo_setup() {
    add_theme_support( 'custom-logo' );
}
add_action( 'after_setup_theme', 'aqueduct_logo_setup' );


function aqueduct_oldlogotonew(){


  if (get_theme_mod('howl-themes_logo') && function_exists('get_custom_logo')) {
    $logo = attachment_url_to_postid( get_theme_mod( 'howl-themes_logo' ) );
    if ( is_int( $logo ) ) {
      set_theme_mod( 'custom_logo', $logo );
    }
    remove_theme_mod( 'howl-themes_logo' );
  }


 
}
add_action( 'after_setup_theme', 'aqueduct_oldlogotonew' );

function aqueduct_previous_magazine_settings() {
  
if(get_theme_mod("newsbox_one") || get_theme_mod("newsbox_two") || get_theme_mod("newsbox_three") || get_theme_mod("newsbox_four") || get_theme_mod("newsbox_five")){
// Slider
if(get_theme_mod("newsbox_one")){
  $slider_cat = get_theme_mod("newsbox_one");
  remove_theme_mod( 'newsbox_one' );
}
else{
  $slider_cat = 'none';
}

//Carousel
if(get_theme_mod("newsbox_two")){
  $carousel_cat = get_theme_mod("newsbox_two");
  remove_theme_mod( 'newsbox_two' );
}
else{
  $carousel_cat = 'none';
}

//Grid 1
if(get_theme_mod("newsbox_three")){
  $gridone_cat = get_theme_mod("newsbox_three");
  remove_theme_mod( 'newsbox_three' );
}
else{
  $gridone_cat = 'none';
}

//Grid 2
if(get_theme_mod("newsbox_four")){
  $gridtwo_cat = get_theme_mod("newsbox_four");
  remove_theme_mod( 'newsbox_four' );
}
else{
  $gridtwo_cat = 'none';
}

//Blog
if(get_theme_mod("newsbox_five")){
  $blog_cat = get_theme_mod("newsbox_five");
  remove_theme_mod( 'newsbox_five' );
}
else{
  $blog_cat = 'none';
}

$all_prev_cat = $slider_cat. ', '. $carousel_cat. ', '. $gridone_cat. ', '. $gridtwo_cat. ', '. $blog_cat. ',';
set_theme_mod( 'category_remember', $all_prev_cat );
$prev_box_arrang = '1, 2, 3, 4, 5,';
set_theme_mod( 'homebuilder', $prev_box_arrang );
}
}
add_action( 'after_setup_theme', 'aqueduct_previous_magazine_settings' );
