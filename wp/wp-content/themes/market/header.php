<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Market
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="parallax-bg"></div>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<div id="top-bar">
		<div class="container">
			
			<div id="top-search-form" class="col-md-12">
				<?php get_template_part('searchform', 'top'); ?>
			</div>
			
			<div id="top-navigation" class="col-md-9">
				<?php wp_nav_menu( array( 'theme_location' => 'top' ) ); ?>
			</div>	

			 <div class="top-icons-container col-md-3">
				
				<?php if (class_exists('woocommerce')) :
				?>
					<div class="top-cart-icon">
						<i class="fa fa-shopping-cart"></i>
						<?php
						 global $woocommerce; ?>
	 
					<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
					</div>
				<?php endif; ?>	
					<div class="top-search-icon">
						<i class="fa fa-search"></i>
					</div>
			</div>
		
		</div>
	</div><!--#top-bar-->
	
	<div id="header-top">
		<header id="masthead" class="site-header row container" role="banner">
			<div class="site-branding col-md-6 col-xs-12">
			<?php if((of_get_option('logo', true) != "") && (of_get_option('logo', true) != 1) ) { ?>
				<h1 class="site-title logo-container"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<?php
				echo "<img class='main_logo' src='".of_get_option('logo', true)."' title='".esc_attr(get_bloginfo( 'name','display' ) )."'></a></h1>";	
				}
			else { ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1> 
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php	
			}
			?>
			</div>	
			
			<?php
			
			if ( of_get_option('facebook',true) == 1 ) :
				 get_template_part('defaults/social');
			else :
				get_template_part('social', 'default');
			endif; ?>
			
		</header><!-- #masthead -->
	</div>
	
	<div id="header-2">
		<div class="container">
		<div class="default-nav-wrapper col-md-11 col-xs-12"> 	
		   <nav id="site-navigation" class="main-navigation" role="navigation">
	         <div id="nav-container">
				<h1 class="menu-toggle"></h1>
				<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'market' ); ?>"><?php _e( 'Skip to content', 'market' ); ?></a></div>
	
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	          </div>  
			</nav><!-- #site-navigation -->
		  </div>
		  
		<div id="top-search" class="col-md-1 col-xs-12">
			<?php // get_search_form(); ?>
		</div>
		</div>
	</div>
	
	<?php
			if ( of_get_option('slide1',true) == 1 ) :
				 get_template_part('defaults/slider');
			else :
				get_template_part('slider', 'nivo');
			endif; ?>
		<div id="content" class="site-content container row clearfix clear">
		<div class="col-md-12"> 
