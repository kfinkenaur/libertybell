<?php
/* Some setup */
define('PPM_CAROUSEL_NAME', "Carousel Images");
define('PPM_CAROUSEL_SINGLE', "Carousel Image");
define('PPM_CAROUSEL_TYPE', "carousel-image");
define('PPM_CAROUSEL_ADD_NEW_ITEM', "Add New Carousel Image");
define('PPM_CAROUSEL_EDIT_ITEM', "Edit Carousel Image");
define('PPM_CAROUSEL_NEW_ITEM', "New Carousel Image");
define('PPM_CAROUSEL_VIEW_ITEM', "View Carousel Image");

/* Register custom post for carousel images*/
function ppm_carousel_custom_post_register() {  
    $args = array(  
        'labels' => array (
			'name' => __( PPM_CAROUSEL_NAME ),
			'singular_label' => __(PPM_CAROUSEL_SINGLE),  
			'add_new_item' => __(PPM_CAROUSEL_ADD_NEW_ITEM),
			'edit_item' => __(PPM_CAROUSEL_EDIT_ITEM),
			'new_item' => __(PPM_CAROUSEL_NEW_ITEM),
			'view_item' => __(PPM_CAROUSEL_VIEW_ITEM),
		), 
        'public' => true,  
        'show_ui' => true,  
        'capability_type' => 'post',  
        'hierarchical' => false,  
        'rewrite' => true,  
        'supports' => array('title', 'thumbnail')  
       );  
    register_post_type(PPM_CAROUSEL_TYPE , $args );  
}
add_action('init', 'ppm_carousel_custom_post_register');

/* Move featured image box under title */
add_action('do_meta_boxes', 'change_image_box');
function change_image_box()
{
    remove_meta_box( 'postimagediv', 'carousel-image', 'side' );
    add_meta_box('postimagediv', __('Upload Carousel Image'), 'post_thumbnail_meta_box', 'carousel-image', 'normal', 'high');
}
?>