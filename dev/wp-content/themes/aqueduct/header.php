<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package HowlThemes
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); 
get_template_part('inc/dragfun/dragtheme', 'css');

?>

</head>

<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
<div id="page" class="hfeed site">

<div class="drag-navbar">
<div class="container">

                <nav id="site-navigation" class="main-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
<div class="searchboxcontainer"><i class="fa fa-search"></i></div>
</div>
</div>
<div class="srchcontainer">
<div class="srchcontainerin">
<?php get_search_form(); ?>
</div>
</div>
	<header id="masthead" class="site-header" itemscope="itemscope" itemtype="http://schema.org/WPHeader" role="banner">
        <div class="container">
        <?php if(get_theme_mod("imageradio") == "center"){?>
		<div class="site-branding-center">
		<?php }elseif (get_theme_mod("imageradio") == "best") {?>
		<div class="masthead-logo-social"><div class="site-branding-best">
		<?php } else{?>
		<div class="site-branding">
		<?php } ?>
		<?php 
		    $logo_image = '';
		    if (function_exists('get_custom_logo')) {
		    $logo_image = has_custom_logo(); 
		    $output_logo = get_custom_logo();
		    } 
		    if(empty($logo_image)){?>
			<?php if (is_single() || is_page()) { ?>
			<h2 class="site-title" itemprop="headline"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
            <?php } else{?>
			<h1 class="site-title" itemprop="headline"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php } ?>
			<h2 class="site-description" itemprop="description"><?php bloginfo( 'description' ); ?></h2>
			<?php }
			else{
            echo $output_logo;
			}?>
		</div><!-- .site-branding -->
		<?php if(get_theme_mod("imageradio") == "center"){?>
		   <center><div class="drag-social-button-center">
	         <ul>
             <?php howlthemes_socialmediafollow(); ?>
	         </ul>
	        </div></center>

            <nav class="secondary-navigation secondary-navigation-center" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation">
		<?php }elseif (get_theme_mod("imageradio") == "best") {?>
           <div class="drag-social-button-best">
	         <ul>
             <?php howlthemes_socialmediafollow(); ?>
	         </ul>
	        </div>
	        </div> 
	         <nav class="secondary-navigation secondary-navigation-best" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation">
		<?php }
		else{?>
            <nav id="bottom-navigation" class="secondary-navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation">
	<?php } ?>
	<div class="menu-footer">
		<?php wp_nav_menu( array('container' => false, 'theme_location' => 'secondary') ); ?>
</div>
		</nav>

	</div>	
	</header><!-- #masthead -->

<?php if(get_theme_mod("imageradio") != "center" && get_theme_mod("imageradio") != "best"){?>

<div class="break-social">
<div class="container">
<div class="newsticker-holder">
<span><?php _e( 'Breaking', 'aqueduct'); ?></span>
<ul class="newsticker">
<?php
    $args = array( 
    	'numberposts' => '10',
    	'post_status' => 'publish',
    	);
	$recent_posts = wp_get_recent_posts( $args );
	foreach( $recent_posts as $recent ){
		echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
	}
?>
</ul>
</div>
<div class="drag-social-button">
	<ul>
   <?php howlthemes_socialmediafollow(); ?>
</ul>
</div>
<div class="globetoogle"><i class="fa fa-globe"></i></div>
</div>
</div>
<?php }?>
	<div id="content" class="site-content">
