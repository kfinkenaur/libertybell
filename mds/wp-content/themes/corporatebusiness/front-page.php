<?php
/**
 * The template for displaying front page components.
 *
 * @package CorporateBusiness
 */

// Wp header
get_header();

// Theme Functions
if ( $paged <= 1 && ! is_404() ) {
	if ( get_theme_mod( 'enable_services' ) ) get_template_part('index', 'services') ;
	if ( get_theme_mod( 'enable_projects' ) ) get_template_part('index', 'projects') ;
	if ( get_theme_mod( 'enable_testimonials' ) ) get_template_part('index', 'testimonials') ;
	if ( get_theme_mod( 'enable_customers' ) ) get_template_part('index', 'customers') ;
}

/*
page_on_front: The ID of the page that should be displayed on the front page. Requires show_on_front's value to be page. 

page_for_posts: The ID of the page that displays posts. Useful when show_on_front's value is page. 

https://codex.wordpress.org/Option_Reference
*/
if ( get_option( 'show_on_front' ) == "posts" ) {
	get_template_part('index', 'homepage') ;
} elseif ( get_option( 'show_on_front' ) == "page" ) {
	get_template_part('index') ;
}

// Wp footer	
get_footer();
?>