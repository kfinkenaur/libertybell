<?php

class Business_world_meta_layout_model extends WDWT_meta_model{
  
  public $params;
  
  function __construct(){
    
    $this->params = array( 
      'default_layout' => array(
        "name" => "default_layout", 
        "title" => __("Choose Default Layout","business-world"), 
        'type' => 'layout_open', 
        "description" => __( "Content layout.", "business-world" ), 
        'valid_options' => array( 
          array('index' => '1', 'title'=>'No Sidebar', 'description'=>''),
          array('index' => '2', 'title'=>'Right Sidebar', 'description'=>''),
          array('index' => '3', 'title'=>'Left Sidebar', 'description'=>''),
          array('index' => '4', 'title'=>'Two Right Sidebars', 'description'=>''),
          array('index' => '5', 'title'=>'Two Left Sidebars', 'description'=>''),
          array('index' => '6', 'title'=>'One Right One Left Sidebars', 'description'=>''),

        ),
        'show' => array(
                      '2'=>'main_column',
                      '3'=>'main_column',
                      '4'=>array('main_column', 'pwa_width'),
                      '5'=>array('main_column', 'pwa_width'),
                      '6'=>array('main_column', 'pwa_width'),
                      ),
        'hide' => array(),
        'img_src' => 'sprite-layouts.png',
        'img_height' => 289,
        'img_width' => 50,
        'default' =>  $this->get_param('default_layout'),
      ),
    'full_width' => array(
    'name' => 'full_width',
    'title' => __( 'Full Width', "business-world" ),
    'type' => 'checkbox',
    'description' => __( 'You can choose full width for pages and posts on the website.', "business-world" ),
    'default' => false,
    ),
    'content_area' => array(
    'name' => 'content_area',
    'title' => __( 'Content Area Width', "business-world" ),
    'type' => 'text',
    "sanitize_type" => "sanitize_text_field",
    'description' => __( 'Width of the Content Area', "business-world" ),
    'default' => '1024',
    "extend_simvol" => "px",
    ),
      'main_column' => array( 
        "name" => "main_column", 
        "title" => __("Main Column Width","business-world"), 
        'type' => 'text',
        "sanitize_type" => "sanitize_text_field",
        "description" => __("Width of the Main Column", "business-world"),
        'unit_symbol' => '%',
        'input_size' => '2',
        'default' => $this->get_param('main_column'),
      ),
      'pwa_width' => array( 
        "name" => "pwa_width", 
        "title" => __("Primary Widget Area width", "business-world"), 
        'type' => 'text',
        "sanitize_type" => "sanitize_text_field", 
        "description" => __("Width of the Primary Widget Area", "business-world"),
        'unit_symbol' => '%',
        'input_size' => '2',
        'default' => $this->get_param('pwa_width'),
      ),
      'show_featured_image' => array(
        'name' => 'show_featured_image',
        'title' => __( 'Featured Image', "business-world" ),
        'type' => 'checkbox',
        'description' => __( 'Show Featured Image in single page/post view', "business-world" ),
        'default' => $this->post_type_check() == 'page' ? false : true ,
      ),
    );

  }
 
}