<?php
/**
 * Title: Function
 *
 * Description: Defines theme specific functions including actions and filters.
 *
 * Please do not edit this file. This file is part of the Cyber Chimps Framework and all modifications
 * should be made in a child theme.
 *
 * @category Cyber Chimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.cyberchimps.com/
 */

// Load Core
require_once( get_template_directory() . '/cyberchimps/init.php' );

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

// Define site info
function cyberchimps_add_site_info() { ?>
	<p>&copy; Company Name</p>	
<?php }
add_action('cyberchimps_site_info', 'cyberchimps_add_site_info');

if ( ! function_exists( 'cyberchimps_comment' ) ) :

// Template for comments and pingbacks.
// Used as a callback by wp_list_comments() for displaying the comments.
function cyberchimps_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'cyberchimps' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'cyberchimps' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment hreview">
			<footer>
				<div class="comment-author reviewer vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( '%s <span class="says">' . __( 'says:', 'cyberchimps' ) . '</span>', sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'cyberchimps' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="dtreviewed"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'cyberchimps' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'cyberchimps' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for cyberchimps_comment()

// set up next and previous post links for lite themes only
function cyberchimps_next_previous_posts() {
	if( get_next_posts_link() || get_previous_posts_link() ): ?>
	<div class="more-content">
		<div class="row-fluid">
			<div class="span6 previous-post">
				<?php previous_posts_link(); ?>
			</div>
			<div class="span6 next-post">
				<?php next_posts_link(); ?>
			</div>
		</div>
	</div>
<?php
	endif;
}
add_action( 'cyberchimps_after_content', 'cyberchimps_next_previous_posts' );

// core options customization Names and URL's
//Pro or Free
function cyberchimps_theme_check() {
	$level = 'free';
	return $level;
}
//Theme Name
function cyberchimps_options_theme_name(){
	$text = 'CyberChimps';
	return $text;
}
//Theme Pro Name
function cyberchimps_upgrade_bar_pro_title() {
	$text = 'CyberChimps Pro';
	return $text;
}
//Upgrade link
function cyberchimps_upgrade_bar_pro_link() {
	$url = 'http://cyberchimps.com/store/cyberchimpspro/';
	return $url;
}
//Doc's URL
function cyberchimps_options_documentation_url() {
	$url = 'http://cyberchimps.com/guides/c/';
	return $url;
}
// Support Forum URL
function cyberchimps_options_support_forum() {
	$url = 'http://cyberchimps.com/forum/free/cyberchimps/';
	return $url;
}
add_filter( 'cyberchimps_current_theme_name', 'cyberchimps_options_theme_name', 1 );
add_filter( 'cyberchimps_upgrade_pro_title', 'cyberchimps_upgrade_bar_pro_title' );
add_filter( 'cyberchimps_upgrade_link', 'cyberchimps_upgrade_bar_pro_link' );
add_filter( 'cyberchimps_documentation', 'cyberchimps_options_documentation_url' );
add_filter( 'cyberchimps_support_forum', 'cyberchimps_options_support_forum' );

// Help Section
function cyberchimps_options_help_header() {
	$text = 'CyberChimps';
	return $text;
}
function cyberchimps_options_help_sub_header(){
	$text = __( 'CyberChimps Professional Responsive WordPress Theme', 'cyberchimps' );
	return $text;
}
add_filter( 'cyberchimps_help_heading', 'cyberchimps_options_help_header' );
add_filter( 'cyberchimps_help_sub_heading', 'cyberchimps_options_help_sub_header' );

// Branding images and defaults

// Banner default
function cyberchimps_banner_default() {
	$url = '/images/branding/banner.jpg';
	return $url;
}
add_filter( 'cyberchimps_banner_img', 'cyberchimps_banner_default' );

//theme specific skin options in array. Must always include option default
function cyberchimps_skin_color_options( $options ) {
	// Get path of image
	$imagepath = get_template_directory_uri(). '/inc/css/skins/images/';
	
	$options = array(
		'default'	=> $imagepath . 'default.png'
	);		
	return $options;
}
add_filter( 'cyberchimps_skin_color', 'cyberchimps_skin_color_options' );

// theme specific background images
function cyberchimps_background_image( $options ) {
	$imagepath =  get_template_directory_uri() . '/cyberchimps/lib/images/';
	$options = array(
			'none' => $imagepath . 'backgrounds/thumbs/none.png',
			'noise' => $imagepath . 'backgrounds/thumbs/noise.png',
			'blue' => $imagepath . 'backgrounds/thumbs/blue.png',
			'dark' => $imagepath . 'backgrounds/thumbs/dark.png',
			'space' => $imagepath . 'backgrounds/thumbs/space.png'
			);
	return $options;
}
add_filter( 'cyberchimps_background_image', 'cyberchimps_background_image' );

// theme specific typography options
function cyberchimps_typography_sizes( $sizes ) {
	$sizes = array( '8','9','10','12','14','16','20' );
	return $sizes;
}
function cyberchimps_typography_faces( $faces ) {
	$faces = array(
				'Arial, Helvetica, sans-serif'						 => 'Arial',
				'Arial Black, Gadget, sans-serif'					 => 'Arial Black',
				'Comic Sans MS, cursive'							 => 'Comic Sans MS',
				'Courier New, monospace'							 => 'Courier New',
				'Georgia, serif'									 => 'Georgia',
				'Impact, Charcoal, sans-serif'						 => 'Impact',
				'Lucida Console, Monaco, monospace'					 => 'Lucida Console',
				'Lucida Sans Unicode, Lucida Grande, sans-serif'	 => 'Lucida Sans Unicode',
				'Palatino Linotype, Book Antiqua, Palatino, serif'	 => 'Palatino Linotype',
				'Tahoma, Geneva, sans-serif'						 => 'Tahoma',
				'Times New Roman, Times, serif'						 => 'Times New Roman',
				'Trebuchet MS, sans-serif'							 => 'Trebuchet MS',
				'Verdana, Geneva, sans-serif'						 => 'Verdana',
				'Symbol'											 => 'Symbol',
				'Webdings'											 => 'Webdings',
				'Wingdings, Zapf Dingbats'							 => 'Wingdings',
				'MS Sans Serif, Geneva, sans-serif'					 => 'MS Sans Serif',
				'MS Serif, New York, serif'							 => 'MS Serif',
				);
	return $faces;
}
function cyberchimps_typography_styles( $styles ) {
	$styles = array( 'normal' => 'Normal','bold' => 'Bold' );
	return $styles;
}
add_filter( 'cyberchimps_typography_sizes', 'cyberchimps_typography_sizes' );
add_filter( 'cyberchimps_typography_faces', 'cyberchimps_typography_faces' );
add_filter( 'cyberchimps_typography_styles', 'cyberchimps_typography_styles' );

// Default for twitter bar handle
function cyberchimps_twitter_handle_filter() {
	return 'WordPress';
}
add_filter( 'cyberchimps_twitter_handle_filter', 'cyberchimps_twitter_handle_filter' );
?>