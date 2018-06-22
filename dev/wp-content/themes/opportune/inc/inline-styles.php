<?php
/**
 * Add inline styles to the head area
 * These styles represents options from the customizer
 * @package Opportune
 */
 
 // Dynamic styles
function opportune_inline_styles($custom) {
	
// Site header bg
	$header_bg = get_theme_mod( 'header_bg', '#ffffff' );
	$custom .= "#header-wrapper { background-color:" . esc_attr($header_bg) . "}"."\n";	
//Top level menu items color
	$top_items_color = get_theme_mod( 'top_items_color', '#222' );
	$custom .= ".primary-navigation li.home a, .primary-navigation li a { color:" . esc_attr($top_items_color) . "}"."\n";
//Sub menu items color
	$submenu_items_color = get_theme_mod( 'submenu_items_color', '#727679' );
	$custom .= ".primary-navigation li li > a { color:" . esc_attr($submenu_items_color) . "}"."\n";
//Sub menu background
	$submenu_background = get_theme_mod( 'submenu_background', '#fbfbfb' );
	$custom .= ".primary-navigation ul ul { background:" . esc_attr($submenu_background) . "}"."\n";	
//Sub menu border 
	$submenu_border = get_theme_mod( 'submenu_border', '#d9d9d9' );
	$custom .= ".primary-navigation ul ul { border-color:" . esc_attr($submenu_border) . "}"."\n";		
//Top Level Hover and Active colour
	$top_level_active = get_theme_mod( 'top_level_active', '#dcc593' );
	$custom .= ".primary-navigation li.home a:hover, 
	.primary-navigation a:hover,
	.primary-navigation .current-menu-item > a,	
	.primary-navigation .current-menu-item > a,
	.primary-navigation .current-menu-ancestor > a { color:" . esc_attr($top_level_active) . "}"."\n";		
// Banner Wrapper background
	$banner_bg = get_theme_mod( 'banner_bg', '#ffffff' );
	$custom .= "#banner-wrapper { background-color:" . esc_attr($banner_bg) . "}"."\n";	
// Header bottom border
	$header_bottom_border = get_theme_mod( 'header_bottom_border', '#d9d9d9' );
	$custom .= "#header-wrapper { border-color:" . esc_attr($header_bottom_border) . ";}"."\n";				
// Content top border background and text colour
	$content_bg = get_theme_mod( 'content_bg', '#ffffff' );
	$content_text = get_theme_mod( 'content_text', '#5f5f5f' );
	$custom .= ".site-content, #site-content-bottom { background-color:" . esc_attr($content_bg) . "; color: " . esc_attr($content_text) . "}"."\n";	
// Content link colour
	$content_links = get_theme_mod( 'content_links', '#be9a4d' );
	$custom .= "a, a:visited { color:" . esc_attr($content_links) . "}"."\n";		
// Content link hover colour
	$content_links_hover = get_theme_mod( 'content_links_hover', '#616161' );
	$custom .= "a:hover { color:" . esc_attr($content_links_hover) . "}"."\n";		
// Sidebar text colour
	$sidebar_links = get_theme_mod( 'sidebar_text', '#9a9a9a' );
	$custom .= "aside, aside li a, aside li a:visited { color:" . esc_attr($sidebar_links) . "}"."\n";	
// Sidebar link hover colour
	$sidebar_links = get_theme_mod( 'sidebar_link_hover', '#be9a4d' );
	$custom .= "aside li a:hover { color:" . esc_attr($sidebar_links) . "}"."\n";
//Site title
	$site_title = get_theme_mod( 'site_title_colour', '#333' );
	$custom .= ".site-title a, .site-title a:hover { color:" . esc_attr($site_title) . "}"."\n";
//Site desc
	$site_desc = get_theme_mod( 'site_desc_colour', '#616161' );
	$custom .= ".site-description { color:" . esc_attr($site_desc) . "}"."\n";		
				
// Bottom sidebars background 
	$bottom_sidebars_bg = get_theme_mod( 'bottom_sidebars_bg', '#a4bbba' );
	$custom .= "#bottom-sidebars { background-color:" . esc_attr($bottom_sidebars_bg) . "}"."\n";	
// Bottom sidebars  text colours
	$bottom_sidebars_text = get_theme_mod( 'bottom_sidebars_text', '#ffffff' );
	$custom .= "#bottom-sidebars aside { color:" . esc_attr($bottom_sidebars_text) ."}"."\n";	
// Bottom sidebars link colour
	$bottom_sidebar_links = get_theme_mod( 'bottom_sidebar_links', '#ffffff' );
	$custom .= "#bottom-sidebars a, #bottom-sidebars a:visited { color:" . esc_attr($bottom_sidebar_links) . "}"."\n";	
// Bottom sidebars link hover colour
	$bottom_sidebar_links_hover = get_theme_mod( 'bottom_sidebar_links_hover', '#ffffff' );
	$custom .= "#bottom-sidebars a:hover { color:" . esc_attr($bottom_sidebar_links_hover) . "}"."\n";
// Button  colour
	$button_bg = get_theme_mod( 'button_bg', '#62686e' );
	$button_text = get_theme_mod( 'button_text', '#ffffff' );
	$custom .= "button, input[type='button'], input[type='submit'], input[type='reset'], .btn { color: " . esc_attr($button_text) . "; background-color:" . esc_attr($button_bg) . "}"."\n";	
	
// Button hover colour
	$button_hbg = get_theme_mod( 'button_hbg', '#dfe3e6' );
	$button_htext = get_theme_mod( 'button_htext', '#ffffff' );
	$custom .= "button:hover, input[type='button']:hover, input[type='submit']:hover, input[type='reset']:hover, .btn:hover { color: " . esc_attr($button_htext) . "; background-color:" . esc_attr($button_hbg) . "}"."\n";	
// Blog read more button
	$blog_readmore = get_theme_mod( 'blog_readmore', '#b7c7c6' );
	$custom .= ".fa.read-more-icon { color:" . esc_attr($blog_readmore) ."}"."\n";
// Blog read more button on hover
	$blog_hreadmore = get_theme_mod( 'blog_hreadmore', '#d6bb7f' );
	$custom .= ".fa.read-more-icon:hover { color:" . esc_attr($blog_hreadmore) ."}"."\n";	
// Footer Text Colour
	$footer_text = get_theme_mod( 'footer_text', '#cccccc' );
	$custom .= "#footer-sidebar aside, #copyright { color:" . esc_attr($footer_text) ."}"."\n";	
// Footer link Colour
	$footer_links = get_theme_mod( 'footer_links', '#ffffff' );
	$custom .= "#footer-menu a { color:" . esc_attr($footer_links) ."}"."\n";	
// Footer link  hover Colour
	$footer_hlinks = get_theme_mod( 'footer_hlinks', '#cccccc' );
	$custom .= "#footer-menu a:hover { color:" . esc_attr($footer_hlinks) ."}"."\n";	

// social  colour
	$social_bg = get_theme_mod( 'social_bg', '#444444' );
	$social_icon = get_theme_mod( 'social_icon', '#ffffff' );
	$custom .= ".social a { color: " . esc_attr($social_icon) . "; background-color:" . esc_attr($social_bg) . "}"."\n";	
// social  hover colour
	$social_hbg = get_theme_mod( 'social_hbg', '#dcc593' );
	$social_hicon = get_theme_mod( 'social_hicon', '#ffffff' );
	$custom .= ".social a:hover { color: " . esc_attr($social_hicon) . "; background-color:" . esc_attr($social_hbg) . "}"."\n";	

//  Back to top button bg
	$backtop_bg = get_theme_mod( 'backtop_bg', '#000000' );
	$backtop_text = get_theme_mod( 'backtop_text', '#ffffff' );
	$custom .= ".back-to-top {color:" . esc_attr($backtop_text) ."; background-color:" . esc_attr($backtop_bg) ."}"."\n";
	
//  Back to top button hover bg
	$backtop_hbg = get_theme_mod( 'backtop_hbg', '#565656' );
	$backtop_text = get_theme_mod( 'backtop_text', '#ffffff' );
	$custom .= ".back-to-top:hover { color:" . esc_attr($backtop_text) ."; background-color:" . esc_attr($backtop_hbg) ."}"."\n";
		
//  error button
	$error_button_bg = get_theme_mod( 'error_button_bg', '#a4bbba' );
	$error_button_text_colour = get_theme_mod( 'error_button_text_colour', '#ffffff' );
	$custom .= ".error-button.btn {color:" . esc_attr($error_button_text_colour) ."; background-color:" . esc_attr($error_button_bg) ."}"."\n";	
	
	
	
	
	//Output all the styles
	wp_add_inline_style( 'opportune-style', $custom );	
}
add_action( 'wp_enqueue_scripts', 'opportune_inline_styles' );	