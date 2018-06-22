<?php
class WDWT_slider_page_class {

	public $options; 

	function __construct(){
		$this->options = array(
			'hide_slider' => array( 
				'name' => 'hide_slider', 
				'title' => __( 'Specify where slider or header image should be shown.', "business-world" ), 
				'type' => 'select', 
				'valid_options' => array(
					"Only on Homepage" => __("Only on homepage", "business-world" ),
					"Only on Front Page" => __("Only on front page", "business-world" ),
					"On all the pages and posts" => __("On all the pages and posts", "business-world" ),
					"Hide Slider" => __("Hide Slider", "business-world" ),       
				), 
				'description' => __('Tip: set "Only on front page" if front page displays "a static page".', "business-world"), 
				'section' => 'slider_main', 
				'tab' => 'slider', 
				'default' => array('On all the pages and posts'),
				'customizer' => array()
			),
			'header_img_type' => array(
        "name" => "header_img_type", 
        "title" => __("Header type", "business-world"), 
        'type' => 'radio_open', 
        "description" => "", 
        'valid_options' => array(
              'slider' => __('Slider', "business-world" ), 
              'image' => __('Parallax Image', "business-world" ), 
        ),
        'show' => array('slider'=>array('image_height','image_height_pages','animation_speed','slideshow_interval','stop_on_hover','effect','title_position','description_position','slider_head','slider_head_href','slider_head_title','slider_head_desc'),'image'=>array('parallax_img_padding','parallax_img','parallax_effect_intensity','parallax_title','parallax_desc')),
        'hide' => array('image'=>array('image_height','image_height_pages','animation_speed','slideshow_interval','stop_on_hover','effect','title_position','description_position','slider_head','slider_head_href','slider_head_title','slider_head_desc'),'slider'=>array('parallax_img_padding','parallax_img','parallax_effect_intensity','parallax_title','parallax_desc')),
        'section' => 'slider_main', 
        'tab' => 'slider', 
        'default' => 'slider',  // for new users image
        'customizer' => array()  
      ),
			'parallax_img_padding' => array(
				'name' => 'parallax_img_padding', 
				'title' => __("Parallax Image Padding", "business-world"), 
				'type' => 'text', 
				"sanitize_type" => "sanitize_text_field", 
				'valid_options' => '',
				'description' => "", 
				'section' => 'slider_main', 
				'tab' => 'slider', 
				'default' => "235",
				'unit_symbol' => 'px',
				'customizer' => array()				
			),
			'parallax_effect_intensity' => array(
				'name' => 'parallax_effect_intensity', 
				'title' => __("Parallax Effect Intensity", "business-world"), 
				'type' => 'text', 
				"sanitize_type" => "sanitize_text_field", 
				'valid_options' => '',
				'description' => __("Value between 0 and 1. 0 means normal positioning without parallax, 1 means fixed positioning.", "business-world"), 
				'section' => 'slider_main', 
				'tab' => 'slider', 
				'default' => "0.5",
				'customizer' => array()				
			),
	    'parallax_img' => array(
				'name' => 'parallax_img', 
				'title' => __("Parallax Image", "business-world"), 
				'type' => 'upload_single', 
				"sanitize_type" => "esc_url_raw", 
				'description' => __("Custom image to be used as a heading parallax image.", "business-world"), 
				'section' => 'slider_imgs', 
				'tab' => 'slider', 
				'default' => WDWT_IMG ."slide_1.jpg",
				'customizer' => array()				
			),
			'parallax_desc' => array(
				'name' => 'parallax_desc', 
				'title' => __("Parallax Description", "business-world"), 
				'type' => 'textarea', 
				"sanitize_type" => "sanitize_parallax_html_field", 
				'valid_options' => '',
				'description' => __("Use btn_red, btn_blue,btn_green, btn_trans classes for buttons ", "business-world"),  
				'section' => 'slider_imgs', 
				'tab' => 'slider', 
				'default' => "<h2>RESPONSIVE STYLISH BUSINESS THEME</h2><span class='business_world btn_red'><a href='#'>Download</a></span><span class='business_world btn_trans'><a href='#'>View Demo</a></span>",
				'customizer' => array()				
			),
			"image_height" => array(
				"name" => "image_height",
				"title" => __("Slider Height on home page", "business-world" ),
				'type' => 'text',
				"sanitize_type" => "sanitize_text_field",
				"description" => __("Slider with the width of 1024px will have this height. When resized, image dimensions ratio is preserved.", "business-world" ),
				'section' => 'slider_main',
				'tab' => 'slider',
				'default' => '640',
				'unit_symbol' => 'px',
				'customizer' => array()
			),
			
			"image_height_pages" => array(
				"name" => "image_height_pages",
				"title" => __("Slider Height on all pages and posts", "business-world" ),
				'type' => 'text',
				"sanitize_type" => "sanitize_text_field",
				"description" => __("Slider with the width of 1024px will have this height. When resized, image dimensions ratio is preserved.", "business-world" ),
				'section' => 'slider_main',
				'tab' => 'slider',
				'default' => '640',
				'unit_symbol' => 'px',
				'customizer' => array()
			),

			"animation_speed" => array(
				"name" => "animation_speed",
				"title" => __("Animation Speed", "business-world" ),
				'type' => 'text',
				"sanitize_type" => "sanitize_text_field",
				"description" => __("When using an animation for the slider, you can control its speed. You can use the provided box to fill in the optimal speed.", "business-world" ),
				'section' => 'slider_main',
				'tab' => 'slider',
				'default' => '800',
				'customizer' => array()
			),

			"slideshow_interval" => array(
				"name" => "slideshow_interval",
				"title" => __("Pause Time", "business-world" ),
				'type' => 'text',
				"sanitize_type" => "sanitize_text_field",
				"description" => __("The timing for the slider animation can be customized. You can adjust it providing timing in the corresponding box.", "business-world" ),
				'section' => 'slider_main',
				'tab' => 'slider',
				'default' => '5000',
				'customizer' => array()
			),

			"stop_on_hover" => array(
				"name" => "stop_on_hover",
				"title" => __("Stop animation while hovering", "business-world" ),
				'type' => 'checkbox',
				"sanitize_type" => "sanitize_text_field",
				"description" =>__( "By default slider animation is constant. However you can choose it to stop while hovering, checking the box for this option.", "business-world" ),
				'section' => 'slider_main',
				'tab' => 'slider',
				'default' => false,
				'customizer' => array()
			)
		);
		$this->options["effect"] = array(
			"name" => "effect",
			"title" => __("Effect", "business-world" ),
			'type' => 'select',
			"sanitize_type" => "sanitize_text_field",
			"description" => __("The animation of the slider can be customized with the help of various effects. You can choose the slider animation effect from the list included below.", "business-world" ),
			"valid_options" => array(
				"none" => "None",
				"cubeH"  =>  "Cube Horizontal",
				"cubeV"  =>  "Cube Vertical",
				"fade"  =>  "Fade",
				"sliceH"  =>  "Slice Horizontal",
				"sliceV"  =>  "Slice Vertical",
				"slideH"  =>  "Slide Horizontal",
				"slideV"  =>  "Slide Vertical",
				"scaleOut"  =>  "Scale Out",
				"scaleIn"  =>  "Scale In",
				"blockScale"  =>  "Block Scale",
				"kaleidoscope"  =>  "Kaleidoscope",
				"fan"  =>  "Fan",
				"blindH"  =>  "Blind Horizontal",
				"blindV"  =>  "Blind Vertical",
				"random"  =>  "Random",
			),
			'disabled'=> array("cubeH", "cubeV", "sliceH", "sliceV","slideH", "slideV", "scaleOut", "scaleIn", "blockScale", "kaleidoscope", "fan", "blindH", "blindV",  "random" ),
			'section' => 'slider_main',
			'tab' => 'slider',
			'default' => array('fade'),
			'customizer' => array() 
			);
				
			$this->options["title_position"] = array(
				"name" => "title_position",
				"title" => __("Title Position", "business-world" ),
				'type' => 'select',
				"description" => "",
				"valid_options" => array(
					"left-top" => "left-top",
					"left-middle"  =>  "left-middle",
					"left-bottom"  =>  "left-bottom",
					"center-top"  =>  "center-top",
					"center-middle"  =>  "center-middle",
					"center-bottom"  =>  "center-bottom",
					"right-top"  =>  "right-top",
					"right-middle"  =>  "right-middle",
					"right-bottom"  =>  "right-bottom"   
				),
				'section' => 'slider_main',
				'tab' => 'slider',
				'default' => array('right-top'),
				'customizer' => array() 
			);

			$this->options["description_position"] = array(
				"name" => "description_position",
				"title" => __("Description Position", "business-world" ),
				'type' => 'select',
				"description" => "",
				"valid_options" => array(
					"left-top" => "left-top",
					"left-middle"  =>  "left-middle",
					"left-bottom"  =>  "left-bottom",
					"center-top"  =>  "center-top",
					"center-middle"  =>  "center-middle",
					"center-bottom"  =>  "center-bottom",
					"right-top"  =>  "right-top",
					"right-middle"  =>  "right-middle",
					"right-bottom"  =>  "right-bottom"  
				),
				'section' => 'slider_main',
				'tab' => 'slider',
				'default' => array('center-middle'),
				'customizer' => array() 
			);

			$this->options["slider_head"] = array(
				"name" => "slider_head",
				"title" => "",
				'type' => 'upload_multiple',
				"sanitize_type" => "esc_url_raw",
				"option" => array(
					"imgs_href" => "slider_head_href",
					"imgs_title" =>  "slider_head_title",
					"imgs_description" => "slider_head_desc"
				),
				"description" => "",
				'section' => 'slider_imgs',
				'tab' => 'slider',
				'default' =>  WDWT_IMG."slide_1.jpg" . $this->get_delimiter(). WDWT_IMG."slide_2.jpg",
				'customizer' => array()
			);

			$this->options["slider_head_href"] = array(
				"name" => "slider_head_href",
				"title" => "",
				'type' => 'text_slider',
				"sanitize_type" => "esc_url_raw",
				"description" => "",
				'section' => 'slider_imgs',
				'tab' => 'slider',
				'default' => $this->get_delimiter(),
				'customizer' => array()     
			);

			$this->options["slider_head_title"] = array(
				"name" => "slider_head_title",
				"title" => "",
				'type' => 'text_slider',
				"sanitize_type" => "sanitize_text_field",
				"description" => "",
				'section' => 'slider_imgs',
				'tab' => 'slider',
				'default' => $this->get_delimiter(),
				'customizer' => array()    
			);

			$this->options["slider_head_desc"] = array(
				"name" => "slider_head_desc",
				"title" => "",
				'type' => 'textarea_slider',
				"sanitize_type" => "sanitize_html_field",
				"description" => __("Use btn_red, btn_blue,btn_green, btn_trans classes for buttons ", "business-world"),
				'section' => 'slider_imgs',
				'tab' => 'slider',
				'default' => "<h2>RESPONSIVE STYLISH BUSINESS THEME</h2><span class='business_world btn_red'><a href='#'>Download</a></span><span class='business_world btn_trans'><a href='#'>View Demo</a></span>".
 				$this->get_delimiter().
				"<h2>RESPONSIVE STYLISH BUSINESS THEME</h2><span class='business_world btn_red'><a href='#'>Download</a></span><span class='business_world btn_trans'><a href='#'>View Demo</a></span>",
 				'customizer' => array()   
  		);


	}

	private function get_delimiter(){
		return "||wd||";
	}
	
}