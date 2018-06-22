<!doctype html>
<html>
    <head>
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php global $page, $paged;
       wp_title( '|', true, 'right' );
    	bloginfo( 'name' );
        echo ' (vers&atilde;o mobile)';
    	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'P&aacute;gina %s'), max( $paged, $page ) );?></title>

<meta name="HandheldFriendly" content="True" />
<meta name="MobileOptimized" content="320"/>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="cleartype" content="on" />

<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico"  type="image/x-icon" />
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri();?>/images/touch_icon.png" />

<?php if(is_single() || is_page()) { // post e paginas ?>
<meta name="keywords" content="<?php if(function_exists('csv_tags_m')) { csv_tags_m(); } ?>" />
<meta name="description" content="<?php if(function_exists('head_meta_desc_m')) { head_meta_desc_m(); } ?>" />
<?php } elseif(is_home()) { // home ?>
<meta name="keywords" content="mobile, celular," />
<meta name="description" content="<?php bloginfo('description'); ?>  (<?php _e('Mobile version', 'wp-mobile-edition') ?>)" />
<?php } else { //todas as outras ?>
<meta name="robots" content="noindex,nofollow" />
<?php }?>

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
   <?php $options = get_option('fdx3_updater_options');
   echo '<link rel="stylesheet" href="'. get_template_directory_uri(). '/css/'.$options['dark_clean'].'.css" type="text/css" />'."\n";
   echo '<link rel="stylesheet" href="'. get_template_directory_uri(). '/css/'.$options['fdx_color'].'/style-c.css" type="text/css" />';
   ?>

<?php /* http://code.google.com/intl/pt-BR/apis/libraries/devguide.html */  ?>
 <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
<?php /*  <script type="text/javascript" src="<?php echo admin_url() . 'load-scripts.php?c=0&amp;load=jquery' ?>"></script> */  ?>


        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
       jQuery(document).ready(function($) {
    	 // Init the header
	 $('.fdx_catlink > a').click(function() {

		$('.fdx_categories2').slideToggle(function () {
			if ($('.fdx_categories2').is(":visible")) {
				$('.fdx_catlink').css(
					'background', 'url(<?php bloginfo('stylesheet_directory'); ?>/images/icons/tick.png) no-repeat right center'
				);
			}
			else {
				$('.fdx_catlink').css(
					'background', 'url(<?php bloginfo('stylesheet_directory'); ?>/images/topnavsep.png) no-repeat right 6px'
				);
			}
		});

	});

	$('.fdx_searchlink > a').click(function() {

		$('.fdx_search').slideToggle(function () {
			if ($('.fdx_search').is(":visible")) {
				$('.fdx_searchlink').css(
					'background', 'url(<?php bloginfo('stylesheet_directory'); ?>/images/icons/tick.png) no-repeat right center'
				);
			}
			else {
				$('.fdx_searchlink').css(
					'background', 'url(<?php bloginfo('stylesheet_directory'); ?>/images/topnavsep.png) no-repeat right 6px'
				);
			}
		});

	});

	$('.fdx_contactlink > a').click(function() {

		$('.fdx_contact').slideToggle(function () {
			if ($('.fdx_contact').is(":visible")) {

				$('.fdx_contactlink').css(
					'background', 'url(<?php bloginfo('stylesheet_directory'); ?>/images/icons/tick.png) no-repeat right center'
				);
			}
            else {
				$('.fdx_contactlink').css(
					'background', 'url(<?php bloginfo('stylesheet_directory'); ?>/images/topnavsep.png) no-repeat right 6px'
				);
			}
		});

	});


});
        /*]]>*/
        </script>

<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
?>

<?php
$options = get_option('fdx3_updater_options');
if ( $options['fdx_text_head'] <> "" ) {
echo stripslashes($options['fdx_text_head']) . "\n";
}
?>
</head>
<body onLoad="document.getElementById('siteLoader').style.display = 'none';">
<a name="top" id="top"></a>
<div class="fdx_container">

<div class="fdx_header">
<div class="fdx_logo">
<?php $options = get_option('fdx3_updater_options');
if ( $options['fdx_logo_url'] <> "" ) { echo '<a href="'.get_bloginfo('url').'"><img alt="*" border="0" width="170" height="30" src="'.$options['fdx_logo_url'].'" /></a>';}
?>
</div>

<div class="fdx_social">
<?php $options = get_option('fdx3_updater_options');
if ( $options['fdx_google_url'] <> "" ) { echo '<a href="'.$options['fdx_google_url'].'"><img alt="*" border="0" width="24" height="24" src="'. get_template_directory_uri(). '/images/icons/google.png" /></a>';}
if ( $options['fdx_ink_url'] <> "" ) { echo '<a href="'.$options['fdx_ink_url'].'"><img alt="*" border="0" width="24" height="24" src="'. get_template_directory_uri(). '/images/icons/in.png" /></a>';}
if ( $options['fdx_facebook_url'] <> "" ) {echo '<a href="'.$options['fdx_facebook_url'].'"><img alt="*" border="0" width="24" height="24" src="'. get_template_directory_uri(). '/images/icons/face.png" /></a>';}
if ( $options['fdx_twitter_url'] <> "" ) { echo '<a href="'.$options['fdx_twitter_url'].'"><img alt="*" border="0" width="24" height="24" src="'. get_template_directory_uri(). '/images/icons/twitter.png" /></a>';}
if ( $options['fdx_feed_url'] <> "" ) { echo '<a href="'.$options['fdx_feed_url'].'"><img alt="*" border="0" width="24" height="24" src="'. get_template_directory_uri(). '/images/icons/rss.png" /></a>';}
?>
</div>
</div>

<div class="fdx_topnav" align="center">
<ul>
<li class="fdx_home"><a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/home.png" border="0" alt="" width="17" height="16"/></a></li>
<li class="fdx_contactlink" style="padding-top: 6px"><a href="#"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/menu.png" border="0" alt="" width="20" height="20"/></a></li>
<li class="fdx_catlink" style="padding-top: 6px"><a href="#"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/cat.png" border="0" alt="" width="22" height="20"/></a></li>
<li class="fdx_searchlink" style="padding-top: 6px"><a href="#"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/search.png" border="0" alt="" width="20" height="20"/></a></li>
<li class="fdx_home2"><a href="/contact/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/mail.png" border="0" alt="" width="21" height="16"/></a></li>
</ul>
</div>

<div class="fdx_search">
<div style="clear:both;height:8px;"></div>

<div class="fdx_topheading"><?php _e('Search', 'wp-mobile-edition') ?></div>
 <div class="fdx_article fdx_page">
  <fieldset style="width: 275px"><legend><?php _e('Search for', 'wp-mobile-edition') ?></legend>

<form role="search" method="get" action="<?php bloginfo('url'); ?>">
<input name="s" id="s" value="<?php _e('Enter text here', 'wp-mobile-edition') ?>..." onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" class="fdx_searchbar"/>
<input type="submit" id="searchsubmit" value="<?php _e('Search', 'wp-mobile-edition') ?>" />
</form>
</fieldset>
  </div> 

</div>

<div style="clear:both;height:8px;"></div>

<div class="fdx_categories fdx_categories2">
<div class="fdx_topheading"><?php _e('Categories', 'wp-mobile-edition') ?></div>
<ul>
<?php wp_list_categories('orderby=name&title_li=&depth=4'); ?>
</ul>
</div>

<div class="fdx_contact">
<div class="fdx_topheading"><?php _e('Menu', 'wp-mobile-edition') ?></div>
<div class="fdx_categories" style="display: inline !important">
<ul>
<?php wp_nav_menu( array( 'menu' => 'fdx-menu', 'link_before' => '<div class="togle">', 'link_after' => '</div>', 'items_wrap' => '%3$s', 'depth' => '1' ) ); ?>
</ul>
</div>
</div>