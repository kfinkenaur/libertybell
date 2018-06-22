<?php
	global $wdwt_front;
?>
<!DOCTYPE html>
<html  <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta name="viewport" content="initial-scale=1.0" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head();  ?>
</head>
<body <?php body_class(); ?>>

<?php
  $slider_in_home = $wdwt_front->get_param('slider_in_home');
  $header_image = get_header_image(); ?>
<header>
 <?php 
     if(! empty($header_image)){  ?>
	   <div class="container">
			<a class="custom-header-a" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo header_image(); ?>" class="custom-header">	
			</a>
	  </div>
<?php } ?>
		<div id="header" class="home_section">			
			<div class="container clear-div">
				<?php $wdwt_front->logo(); ?>
				<div id="search-block">
					<?php get_search_form(); ?>
				</div>
				<div class="phone-menu-block">
					<nav id="top-nav">
						<div>
							<?php 
							    $business_word_show_home = true; 
								if(has_nav_menu( 'primary-menu')){
									$business_word_show_home = false;
								}
								$wdwt_menu = wp_nav_menu( array(
								            'show_home' => $business_word_show_home,
											'theme_location'  => 'primary-menu',
											'container'       => false,
											'container_class' => '',
											'container_id'    => '',
											'menu_class'      => 'top-nav-list',
											'menu_id'         => '',
											'echo'            => false,
											'fallback_cb'     => 'wp_page_menu',
											'before'          => '',
											'after'           => '',
											'link_before'     => '',
											'link_after'      => '',
											'items_wrap'      => '<ul id="top-nav-list" class=" %2$s">%3$s</ul>',
											'depth'           => 0,
											'walker'          => ''
										));
								echo $wdwt_menu;		?>	
						</div>			
					</nav>
				</div>			
			</div>
		</div>	
<?php
if(($slider_in_home=='' && !is_home()) || is_home())  
  $wdwt_front->slideshow();
 else{ ?>
   <style>
	 #blog h2.page-header:before{
		width:0 !important;
	 }
	 #blog{
		padding-top: 15px !important;
	 }
   </style>
<?php } ?>	