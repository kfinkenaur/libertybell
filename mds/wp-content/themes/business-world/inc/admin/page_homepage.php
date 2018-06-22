<?php


class WDWT_homepage_page_class{
	

	public $options;
	
	function __construct(){

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$first_post=array();
		$post_in_array=get_posts( array('posts_per_page' => 1));
		if($post_in_array)
			$first_post=array($post_in_array[0]->ID);
		else
			$first_post=array();
		unset($post_in_array);
		
		add_filter("wdwt_admin_setting_output_opt_content_post_categories", array("WDWT_homepage_page_class","add_woo_categories"));
		add_filter("wdwt_admin_setting_output_opt_horizontal_tab_categories", array("WDWT_homepage_page_class","add_woo_categories"));
		add_filter("wdwt_admin_setting_output_opt_top_post_categories", array("WDWT_homepage_page_class","add_woo_categories"));
		
		add_filter("wdwt_admin_setting_output_opt_home_middle_description_post", array("WDWT_homepage_page_class","add_woo_posts"));
		add_filter("wdwt_admin_setting_output_opt_pinned_post", array("WDWT_homepage_page_class","add_woo_posts"));
		
		$this->options = array(

		"enable_dotted_navigation" => array(
			"name" => "enable_dotted_navigation",
			"title" => __("Enable Dotted Navigation", "business-world"),
			'type' => 'checkbox',
			"description" => "",
			'section' => 'main', 
			'tab' => 'homepage', 
			'default' => false,
			'customizer'=>array()
			),
		"home_middle_description_post_enable" => array(
			"name" => "home_middle_description_post_enable",
			"title" => __("Featured Post", "business-world"),
			'type' => 'checkbox_open',
			"description" => __( "Check box to display featured post", "business-world" ),
			'show' => array("home_middle_description_post"),
			'hide' => array(),
			'section' => 'featured_post', 
			'tab' => 'homepage', 
			'default' => true,
			'customizer'=>array()
			),
		"home_middle_description_post" => array(
			"name" => "home_middle_description_post",
			"title" => __("Featured Post", "business-world"), 
			'type' => 'select',
			"valid_options" => $this->get_posts(),
			"sanitize_type" => "sanitize_text_field",
			"description" => __("Select the single post", "business-world" ),
			'section' => 'featured_post', 
			'tab' => 'homepage', 
			'default' => $first_post,
			'customizer' => array()
			),
		"hide_top_posts" => array(
			"name" => "hide_top_posts",
			"title" => __("Top Posts", "business-world"), 
			'type' => 'checkbox_open',
			"description" => __("Check the box to display top posts section on the homepage.", "business-world"),
			'show' => array("top_post_cat_name", "top_post_desc", "top_post_categories"),
			'hide' => array(),
			'section' => 'top_posts', 
			'tab' => 'homepage', 
			'default' => true,
			'customizer' => array()
		),			
		"top_post_cat_name" => array(
			"name" => "top_post_cat_name",
			"title" => "", 
			'type' => 'text',
			"sanitize_type" => "sanitize_text_field",
			"description" => __("Title of top posts section", "business-world"),
			'section' => 'top_posts', 
			'tab' => 'homepage', 
			'default' => 'Our Location',
			'customizer' => array()
		),
		"top_post_desc" => array(
			"name" => "top_post_desc",
			"title" => "", 
			'type' => 'text',
			"sanitize_type" => "sanitize_text_field",
			"description" => __("Top Posts Description", "business-world"),
			'section' => 'top_posts', 
			'tab' => 'homepage', 
			'default' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames.',
			'customizer' => array()
		),
		"top_post_categories" => array(
			"name" => "top_post_categories",
			"title" => __("Top Posts", "business-world"), 
			'type' => 'select',
			'multiple' => "true",
			"sanitize_type" => "sanitize_text_field",
			"valid_options" => $this->get_categories(),
			"description" => __("Filter posts only from these categories.", "business-world"),
			'section' => 'top_posts', 
			'tab' => 'homepage', 
			'default' => array(''),
			'customizer' => array()
		),
		"hide_horizontal_tab_posts" => array(
			"name" => "hide_horizontal_tab_posts",
			"title" => __("Horizontal Tab", "business-world"), 
			'type' => 'checkbox_open',
			"description" => __("Check the box to display the horizontal posts tabs section.", "business-world"),
			'show' => array("horizontal_tab_categories"),
			'hide' => array(),
			'section' => 'posts_tabs', 
			'tab' => 'homepage', 
			'default' => true,
			'customizer' => array()
		),	
		"horizontal_tab_categories" => array(
			"name" => "horizontal_tab_categories",
			"title" => "", 
			'type' => 'select',
			'multiple' => "true",
			"sanitize_type" => "sanitize_text_field",
			"valid_options" => $this->get_categories(),
			"description" => __("Filter posts only from these categories.", "business-world"),
			'section' => 'posts_tabs', 
			'tab' => 'homepage', 
			'default' => array(''),
			'customizer' => array()
		),
		"pinned_post_enable" => array( 
			"name" => "pinned_post_enable",
			"title" => __("Pinned Post", "business-world"), 
			'type' => 'checkbox_open',  
			"description" => __("Display pinned post with parallax background.", "business-world"),
			'show' => array("pinned_bg_img","pinned_post"),
			'hide' => array(),
			'section' => 'pinned_post', 
			'tab' => 'homepage', 
			'default' => false, // for new users true
			'customizer'=>array()
		),	
		'pinned_bg_img' => array(
			'name' => 'pinned_bg_img', 
			'title' => __("Pinned Background Image", "business-world"), 
			'type' => 'upload_single', 
			"sanitize_type" => "esc_url_raw", 
			'valid_options' => '',
			'description' => __("Pinned post background image.", "business-world"), 
			'section' => 'pinned_post', 
			'tab' => 'homepage', 
			'default' => WDWT_IMG."newsletter_bg.jpg",
			'customizer' => array()				
		),
		"pinned_post" => array(
				"name" => "pinned_post",
				"title" => __("Pinned Post","business-world"), 
				'type' => 'select',
				"valid_options" => $this->get_posts(),
				"sanitize_type" => "sanitize_text_field",
				"description" => __("Select single post", "business-world"),
				'section' => 'pinned_post', 
				'tab' => 'homepage', 
				'default' => $first_post,
				'customizer' => array()
			),
		"content_posts_enable" => array( 
			"name" => "content_posts_enable",
			"title" => __("Content Posts", "business-world"), 
			'type' => 'checkbox_open',  
			"description" => __("Filter posts only from these categories", "business-world"),
      'show' => array("content_post_categories", "content_post_cat_name", "content_post_desc"),
			'hide' => array(),
			'section' => 'content_posts', 
			'tab' => 'homepage', 
			'default' => true,
			'customizer'=>array()
		),	
		"content_post_cat_name" => array(
			"name" => "content_post_cat_name",
			"title" => "", 
			'type' => 'text',
			"sanitize_type" => "sanitize_text_field",
			"description" => __("Title of content posts section", "business-world"),
			'section' => 'content_posts', 
			'tab' => 'homepage', 
			'default' => '',
			'customizer' => array()
		),	
		"content_post_desc" => array(
			"name" => "content_post_desc",
			"title" => "", 
			'type' => 'text',
			"sanitize_type" => "sanitize_text_field",
			"description" => __("Content Posts Description", "business-world"),
			'section' => 'content_posts', 
			'tab' => 'homepage', 
			'default' => '',
			'customizer' => array()
		),
		"content_post_categories" => array(
			"name" => "content_post_categories",
			"title" => "",
			'type' => 'select',
			'multiple' => "true",
			"sanitize_type" => "sanitize_text_field",
			"valid_options" => $this->get_categories(),
			"description" => __("Show posts only from these categories.","business-world"),
			'section' => 'content_posts',
			'tab' => 'homepage',
			'default' => $this->get_categories_ids(),
			'customizer'=>array()
		),
			'twitter_icon_show' => array(
        "name" => "twitter_icon_show", 
        "title" => __("Show Twitter Icon", "business-world"), 
        'type' => 'checkbox_open', 
        "description" => "",
        'show' => array('twitter_url'),
        'hide' => array(),
        'section' => 'social',  
        'tab' => 'homepage', 
        'default' => true ,
        'customizer' => array()    
      ),      
      'twitter_url' => array( 
        "name" => "twitter_url", 
        "title" => __("Enter your Twitter profile URL below.", "business-world"), 
        'type' => 'text', 
        "sanitize_type" => "esc_url_raw", 
        "description" => "", 
        'section' => 'social', 
        'tab' => 'homepage',
        'default' => '#' ,
        'customizer' => array()     
      ),   
      
      'facebook_icon_show' => array(
        "name" => "facebook_icon_show", 
        "title" => __("Show Facebook Icon", "business-world"), 
        'type' => 'checkbox_open', 
        "description" => "",
        'show' => array('facebook_url'),
        'hide' => array(),
        'section' => 'social', 
        'tab' => 'homepage', 
        'default' => true ,
        'customizer' => array()  
      ),      
      'facebook_url' => array(
        "name" => "facebook_url", 
        "title" => __("Enter your Facebook Profile URL.", "business-world"), 
        'type' => 'text', 
        "sanitize_type" => "esc_url_raw",         
        'section' => 'social', 
        'tab' => 'homepage', 
        'default' => '#' ,
        'customizer' => array()  
      ),      
      'google_icon_show' => array( 
        "name" => "google_icon_show", 
        "title" => __("Show Google+ Icon", "business-world"), 
        'type' => 'checkbox_open', 
        "description" => "", 
        
        'show' => array('google_url'),
        'hide' => array(),
        'section' => 'social', 
        'tab' => 'homepage', 
        'default' => true ,
        'customizer' => array()  
      ), 
      'google_url' => array( 
        "name" => "google_url", 
        "title" => __("Enter your Google+ Profile URL.", "business-world"), 
        'type' => 'text', 
        "sanitize_type" => "esc_url_raw", 
        'section' => 'social', 
        'tab' => 'homepage', 
        'default' => '#',
        'customizer' => array()
      ),      
      'show_rss_icon' => array( 
        "name" => "show_rss_icon", 
        "title" => __("Show RSS Icon", "business-world"), 
        'type' => 'checkbox_open', 
        "description" => "", 
        
        'show' => array('rss_url'),
        'hide' => array(),
        'section' => 'social', 
        'tab' => 'homepage', 
        'default' => true ,
        'customizer' => array()  
      ), 
      'rss_url' => array( 
        "name" => "rss_url", 
        "title" => __("Enter your RSS URL.", "business-world"), 
        'type' => 'text', 
        "sanitize_type" => "esc_url_raw", 
        'section' => 'social', 
        'tab' => 'homepage', 
        'default' => '#',
        'customizer' => array()
      ),
      'linkedin_icon_show' => array(
        "name" => "linkedin_icon_show", 
        "title" => __("Show Linkedin Icon", "business-world"), 
        'type' => 'checkbox_open', 
        "description" => "",
        'show' => array('linkedin_url'),
        'hide' => array(),
        'section' => 'social',  
        'tab' => 'homepage', 
        'default' => false ,
        'customizer' => array()    
      ),      
      'linkedin_url' => array( 
        "name" => "linkedin_url", 
        "title" => __("Enter your Linkedin profile URL below.", "business-world"), 
        'type' => 'text', 
        "sanitize_type" => "esc_url_raw", 
        "description" => "", 
        'section' => 'social', 
        'tab' => 'homepage',
        'default' => '#' ,
        'customizer' => array()     
      ),
      'youtube_icon_show' => array(
        "name" => "youtube_icon_show", 
        "title" => __("Show Youtube Icon", "business-world"), 
        'type' => 'checkbox_open', 
        "description" => "",
        'show' => array('youtube_url'),
        'hide' => array(),
        'section' => 'social',  
        'tab' => 'homepage', 
        'default' => false ,
        'customizer' => array()    
      ),      
      'youtube_url' => array( 
        "name" => "youtube_url", 
        "title" => __("Enter your Youtube profile URL below.", "business-world"), 
        'type' => 'text', 
        "sanitize_type" => "esc_url_raw", 
        "description" => "", 
        'section' => 'social', 
        'tab' => 'homepage',
        'default' => '#' ,
        'customizer' => array()     
      ),
      'instagram_icon_show' => array(
        "name" => "instagram_icon_show", 
        "title" => __("Show Instagram Icon", "business-world"), 
        'type' => 'checkbox_open', 
        "description" => "",
        'show' => array('instagram_url'),
        'hide' => array(),
        'section' => 'social',  
        'tab' => 'homepage', 
        'default' => false ,
        'customizer' => array()    
      ),      
      'instagram_url' => array( 
        "name" => "instagram_url", 
        "title" => __("Enter your Instagram profile URL below.", "business-world"), 
        'type' => 'text', 
        "sanitize_type" => "esc_url_raw", 
        "description" => "", 
        'section' => 'social', 
        'tab' => 'homepage',
        'default' => '#' ,
        'customizer' => array()     
      ),  
		);
	
	}


	


	private function get_posts(){
		$args= array(
				'posts_per_page'   => 3000,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'post_type'        => 'post',
				'post_status'      => 'publish',
				 );

		$posts_array_custom=array();
		$posts_array = get_posts( $args );

		foreach($posts_array as $post){
			$key = $post->ID;
		  $posts_array_custom[$key] = $post->post_title;
		}
    if(empty($posts_array_custom)){
      $posts_array_custom = array('');
    }
		return $posts_array_custom;
	}

	private function get_categories(){
		$args= array(
				'hide_empty' => 0,
				'orderby' => 'name',
				'order' => 'ASC',
			);
		
		$categories_array_custom=array();
		$categories_array = get_categories( $args );
		
		foreach($categories_array as $category){
		  $categories_array_custom[$category->term_id] = $category->name;
		}
    if(empty($categories_array_custom)){
      $categories_array_custom = array('');
    }
		return $categories_array_custom;
	}
	private function get_categories_ids(){
		$args= array(
				'hide_empty' => 0,
				'orderby' => 'name',
				'order' => 'ASC',
			);
		
		$categories_array_custom=array();
		$categories_array = get_categories( $args );
		foreach($categories_array as $category){
		  array_push($categories_array_custom,$category->term_id);
		}
		return $categories_array_custom;
	}

	public static function add_woo_posts($posts_array){
    if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			
				$args= array(
						'posts_per_page'   => 3000,
						'orderby'          => 'post_date',
						'order'            => 'DESC',
						'post_type'        => 'product',
						'post_status'      => 'publish',
				);
						 
				$woo_posts_array = get_posts( $args ); 
				$woo_posts = array();
				foreach($woo_posts_array as $woo_post){
					$woo_posts[$woo_post->ID] = $woo_post->post_title;
				}

				$posts_array["valid_options"] = $posts_array["valid_options"] + $woo_posts;
			
		}
		return $posts_array;
	}
	
	public static function add_woo_categories($categories_array){
    if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			
				$args = array(
					'taxonomy'     => 'product_cat',
					'orderby'      => 'post_date',
					'order'        => 'DESC',
					'hide_empty'   => 0
				);
				$woo_cat_array = get_categories($args);
				$woo_categories = array();
				foreach($woo_cat_array as $woo_cat){
					$woo_categories[$woo_cat->term_id] = $woo_cat->name;
				}
				$categories_array["valid_options"] = $categories_array["valid_options"] + $woo_categories;
		}
		return $categories_array;
	}

	
}
