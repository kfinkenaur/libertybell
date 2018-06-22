<?php
/*
Plugin Name: PPM Carousel
Plugin URI: http://perfectpointmarketing.com/plugins/ppm-carousel-wordpress-plugin
Description: This plugin will add a responsive carousel.
Author: Perfect Point Marketing
Author URI: http://perfectpointmarketing.com
Version: 1.1
*/


/*Some Set-up*/
define('PPM_CAROUSEL_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );


/* Adding Latest jQuery from Wordpress */
function ppm_carousel_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'ppm_carousel_latest_jquery');

/* Adding Plugin javascript file */
wp_enqueue_script('ppm-carousel-plugin-script', PPM_CAROUSEL_PLUGIN_PATH.'js/jquery.carouFredSel-6.2.1-packed.js', array('jquery'));

/* 	Adding Plugin Helper File
	------------------------------------
	This will Include
		* jQuery throttle / debounce - v1.1 - 3/7/2010
		* Mouse Scroll - Brandon Aaron - v 3.0.6
		* touchSwipe - jQuery Plugin - v 1.3.3
		* jQuery Transit - CSS3 transitions and transformations
*/
wp_enqueue_script('ppm-carousel-plugin-script', PPM_CAROUSEL_PLUGIN_PATH.'js/helper-plugins/plugin-helper.js', array('jquery'));

/* Adding plugin javascript active file */
wp_enqueue_script('ppm-carousel-plugin-script-active', PPM_CAROUSEL_PLUGIN_PATH.'js/active.js', array('jquery'));

/* Adding Plugin custm CSS file */
wp_enqueue_style('ppm-carousel-plugin-style', PPM_CAROUSEL_PLUGIN_PATH.'css/plugin-style.css');



/* Generates Slider Shortcode */
function ppmcarosel($atts, $content = null) {
	return ('<div class="image_carousel"><div id="foo2">'.do_shortcode($content).'</div><div class="clearfix"></div><a class="prev" id="foo2_prev" href="#"><span>prev</span></a><a class="next" id="foo2_next" href="#"><span>next</span></a></div>');
}
add_shortcode ("ppmcarosel", "ppmcarosel");

function ppmimages($atts, $content = null) {
	return ('<img src="'.$content.'" alt=""/>');
}
add_shortcode ("ppmimages", "ppmimages");


/* Add Slider Shortcode Button on Post Visual Editor */
function ppmcarousel_button_function() {
	add_filter ("mce_external_plugins", "ppmcarosel_button_js");
	add_filter ("mce_buttons", "ppmcarosel_button");
}

function ppmcarosel_button_js($plugin_array) {
	$plugin_array['ppmcarous'] = plugins_url('js/custom-button.js', __FILE__);
	return $plugin_array;
}

function ppmcarosel_button($buttons) {
	array_push ($buttons, 'ppmcarosel');
	return $buttons;
}
add_action ('init', 'ppmcarousel_button_function'); 


/*Files to Include*/
require_once('carousel-img-type.php');

/* Carousel Loop */
function ppm_get_carousel(){
	$ppmcarousel= '<div class="image_carousel via_shortcode"><div id="foo2">';
	$efs_query= "post_type=carousel-image&posts_per_page=-1";
	query_posts($efs_query);
	if (have_posts()) : while (have_posts()) : the_post(); 
		$img= get_the_post_thumbnail( $post->ID, 'large' );	
		$ppmcarousel.=''.$img.'';		
	endwhile; endif; wp_reset_query();
	$ppmcarousel.= '</div><div class="clearfix"></div><a class="prev" id="foo2_prev" href="#"><span>prev</span></a><a class="next" id="foo2_next" href="#"><span>next</span></a></div>';
	return $ppmcarousel;
}

/**add the shortcode for the slider- for use in editor**/
function ppm_insert_carousel($atts, $content=null){
	$ppmcarousel= ppm_get_carousel();
	return $ppmcarousel;
}
add_shortcode('ppm_all_carousel', 'ppm_insert_carousel');

/**add template tag- for use in themes**/
function ppm_carousel(){
	print ppm_get_carousel();
}
?>