<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>	
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.3, minimum-scale=1.0">
<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title> 
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/site.js" type="text/javascript"></script>
<?php
session_start();
$options = get_option('mobile_theme_options');
global $_51d;
if($_51d["Html5"]!="True")
{
?>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<?php
}
wp_head();
?>
<style type="text/css">
.post-info, .post, .comments {
	border-top-color: <?php echo $options["borderColor"]; ?>;	
}

#menu-mobile li.has_children > a{
	background-image: url(<?php echo get_template_directory_uri(); ?>/img/parent.png);
	background-repeat:no-repeat;
	background-position:99% center;
}
<?php
if(isset($_51d['Javascript']) && $_51d['Javascript']!="False")
{
	?>
	
#menu-mobile-container li:hover > #menu-mobile{
	display:block;
}
<?php	
}
if(isset($_51d['SuggestedLinkSizePixels']))
{
?>
a, #search-box, .search-box{
	line-height:<?php echo $_51d['SuggestedLinkSizePixels']; ?>px !important;
}

.search_box{
	height:<?php echo ($_51d['SuggestedLinkSizePixels']+5); ?>px !important;
	
}
<?php	
}
if(isset($_51d['Javascript']) && $_51d['Javascript']!="False")
{
	?>
	
#menu-mobile-container li:hover > #menu-mobile{
	display:block;
}
<?php	
}
?>
?>
</style>
</head>
<body class="home blog">
<header id="top-bar-tile" class="clearfix">
    <div id="top-bar-content" class="clearfix">
    <div class="left">
    <ul id="menu-mobile-container">
    <li>
    <a href="#" onClick="javascript:menu();">Menu</a>
    <?php 
	wp_nav_menu( array( 
	'container' => '',
	'menu'=>'mobile',
	'menu_id'=>'menu-mobile',
	'fallback_cb' => 'fallback_menu',
	'walker'        => new wave_walker_nav_menu) ); 
	
class wave_walker_nav_menu extends Walker_Nav_Menu {
  
// add classes to ul sub-menus
public function display_element($el, &$children, $max_depth, $depth = 0, $args, &$output){
    $id = $this->db_fields['id'];    

    if(isset($children[$el->$id]))
      $el->classes[] = 'has_children';    

    parent::display_element($el, $children, $max_depth, $depth, $args, $output);
  }
}  
	
	function fallback_menu()
	{
	?>    
        <ul id="menu-mobile">
		<?php wp_list_pages('title_li='); ?>
		</ul>
    <?php
	}
	?>
    </li>
    <?php
	if(!is_home()|| !is_front_page())
	{
	?>
    <li><a href="#" onClick="history.back();return false;">Back</a></li>
    <?php
	}
	?>
    </ul>
    </div>
        <div id="search-box" class="right">  
            <form method="get" id="searchform" action="" >  
                &nbsp;<input type="text" class="search_box" value="Search..." onfocus="if(this.value == this.defaultValue) this.value = ''" name="s" id="s" placeholder="Search..." />  
            </form>
          
        </div><!-- search-box -->  
    </div><!-- top-bar-content -->  
</header>
<div id="wrapper">  
    <div id="content">
    <div id="logo">
    	<h1><a href="<?php bloginfo('url'); ?>">
        <?php if(isset($options['logo']) && $options['logo']!==""): ?>
        <img class="logo" alt="<?php bloginfo('name'); ?>" src="<?php echo $options['logo']; ?>">
        <?php else: ?>
        <?php bloginfo('name'); ?>
        <?php endif; ?>
		</a></h1> 
        <span class="slogan"><?php bloginfo('description'); ?></span>
    </div>