<?php
 /**
 * The header for our theme.
 * Displays all of the <head> section and everything up till <div id="content">
 * @package Opportune
 */

 $boxedstyle = esc_attr(get_theme_mod( 'boxed_style', 'fullwidth' ) ) ;
 $logo_upload = get_option( 'logo_upload' );
 ?>
 
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
       
<div id="page" class="hfeed site <?php echo $boxedstyle ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'opportune' ); ?></a>

<div id="header-wrapper">
        <div class="container">
                <div class="row">	
			<?php get_template_part( 'template-parts/headers' ); ?>
                </div>
        </div>
</div>   
<aside id="banner-sidebar" role="complementary">
    <div id="banner">      
		<?php if ( get_header_image()  && get_theme_mod( 'show_custom_header', 1 ) ) : ?>
            <div class="wp-header-image">
                    <img src="<?php header_image(); ?>" width="<?php echo absint( get_custom_header()->width ); ?>" height="<?php echo absint( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<?php if( esc_attr(get_theme_mod( 'show_header_image_caption', 1 ) ) ) : ?>	
                <div class="banner-caption-content">
                <h1 class="banner-caption-content-title"><?php echo esc_html(get_theme_mod( 'custom_header_caption_title', 'Modern Creativity' )); ?></h1>
                <div class="banner-caption-content-subtitle"><?php echo esc_html(get_theme_mod( 'custom_header_caption', 'Exceptional Features on many Levels' )); ?></div>

                </div>
				<?php endif; ?>
            </div>
        <?php endif; ?>
                
        <?php dynamic_sidebar( 'banner' ); ?>
    </div>
</aside>
    
       
<div id="content" class="site-content clearfix">

<?php get_sidebar( 'breadcrumbs' ); ?>
<?php get_sidebar( 'cta' ); ?>
<?php get_sidebar( 'top' ); ?>
