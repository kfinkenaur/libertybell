<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "body-content-wrapper" div.
 *
 * @package WordPress
 * @subpackage fBlogging
 * @author tishonator
 * @since fBlogging 1.0.0
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<meta name="viewport" content="width=device-width" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="body-content-wrapper">
			
			<header id="header-main">

				<div id="header-content-wrapper">

					<div id="header-logo">
						<?php fblogging_show_website_logo_image_or_title(); ?>
					</div><!-- #header-logo -->

					<nav id="navmain">
						<?php wp_nav_menu( array( 'theme_location' => 'primary',
												  'fallback_cb'    => 'wp_page_menu',
												  
												  ) ); ?>
					</nav><!-- #navmain -->
					
					<div class="clear">
					</div><!-- .clear -->

				</div><!-- #header-content-wrapper -->

			</header><!-- #header-main-fixed -->

			<?php if ( get_theme_mod('fblogging_slider_display', 1) == 1 && fblogging_slider_has_images() ) :
			
						fblogging_display_slider();
			
				  endif; ?>
