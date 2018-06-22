<?php
/**
 * Header Template
 *
 *
 * @file           header.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */
?>
<!DOCTYPE html>
<!--[if !IE]>
<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>
<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>
<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>
<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="header">
	<div class="container">
			<div class="col-md-12 headerTop">
				<div class="col-md-3">			   
					 <div class="Logo col-md-12">
						<div class="row">
							<?php
							$logo = dk_get_option('logo');
							if(!empty($logo)) {
							?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
									<img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo( 'name' ); ?>"  />
								</a>
							<?php
							} else {
							?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
								</a>
							<?php } ?>
						 </div>					
					</div>
				</div>
				<div class="text-right col-md-9">
					<?php get_search_form( ); ?>                	
				</div>
		</div>
	</div>
<div class="clearfix"></div>  
<nav id="site-navigation" class="main-navigation" role="navigation">
	<div class="container">
		<div class="col-md-12">
			<button class="menu-toggle">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>		
			</button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		  </div>
	</div>
</nav><!-- #site-navigation -->  
</div>
<?php if(is_front_page()) { ?>
	<?php echo dk_slider_template(); ?>
<?php } ?>
<div class="content">
    	<div class="container">
        	<div class="contentArea col-md-12">
				<?php if (function_exists('dk_custom_breadcrumbs')) dk_custom_breadcrumbs(); ?>