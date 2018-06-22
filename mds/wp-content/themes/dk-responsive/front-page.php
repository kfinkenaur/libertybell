<?php
/**
 * Front Page Template
 *
 *
 * @file           front-page.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

$front_page='';
$front_page = esc_html( dk_get_option('front_page'));

if ( ('posts' == get_option( 'show_on_front' )) && ($front_page !='Y') ) {
	get_template_part( 'home' );
} elseif ( ('page' == get_option( 'show_on_front' ))&& ($front_page !='Y') ) {
	 $template = get_post_meta( get_option( 'page_on_front' ), '_wp_page_template', true );
	 $template = ( $template == 'default' ) ? 'index.php' : $template;
	locate_template( $template, true );
} else {
	get_header('home');   
	get_template_part( 'home-area' );	
	get_footer();
}
?>