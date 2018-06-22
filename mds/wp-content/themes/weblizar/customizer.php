<?php
function weblizar_customizer( $wp_customize ) {
	wp_enqueue_style('customizr', WL_TEMPLATE_DIR_URI .'/css/customizr.css');
	
	
	
	$ImageUrl1 = get_template_directory_uri() ."/images/slide-1.jpg";
	$ImageUrl2 = get_template_directory_uri() ."/images/slide-2.jpg";
	$ImageUrl3 = get_template_directory_uri() ."/images/slide-3.jpg";
	/* Genral section */
		/* Slider Section */
	$wp_customize->add_panel( 'weblizar_theme_option', array(
    'title' => __( 'Weblizar Options','weblizar' ),
    'priority' => 1, // Mixed with top-level-section hierarchy.
	) );
	$wp_customize->add_section(
        'general_sec',
        array(
            'title' => __('Theme General Options','weblizar'),
            'description' => __('Here you can customize Your theme\'s general Settings','weblizar'),
			'panel'=>'weblizar_theme_option',
			'capability'=>'edit_theme_options',
            'priority' => 35,
        )
    );
	$wl_theme_options = weblizar_get_options();
	//var_dump($wl_theme_options['upload_image_logo']); die;
	$wp_customize->add_setting(
		'weblizar_options[_frontpage]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['_frontpage'],
			'sanitize_callback'=>'weblizar_sanitize_checkbox',
			'capability'        => 'edit_theme_options',
		)
	);
	$wp_customize->add_control( 'weblizar_front_page', array(
		'label'        => __( 'Show Front Page', 'weblizar' ),
		'type'=>'checkbox',
		'section'    => 'general_sec',
		'settings'   => 'weblizar_options[_frontpage]',
	) );
	
	$wp_customize->add_setting(
		'weblizar_options[upload_image_logo]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['upload_image_logo'],
			'sanitize_callback'=>'esc_url_raw',
			'capability'        => 'edit_theme_options',
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[height]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['height'],
			'sanitize_callback'=>'weblizar_sanitize_integer',
			'capability'        => 'edit_theme_options'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[width]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['width'],
			'sanitize_callback'=>'weblizar_sanitize_integer',
			'capability'        => 'edit_theme_options',
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[upload_image_favicon]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['upload_image_favicon'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback'=>'esc_url_raw',
		)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'weblizar_upload_image_logo', array(
		'label'        => __( 'Website Logo', 'weblizar' ),
		'section'    => 'general_sec',
		'settings'   => 'weblizar_options[upload_image_logo]',
	) ) );
	$wp_customize->add_control( 'weblizar_logo_height', array(
		'label'        => __( 'Logo Height', 'weblizar' ),
		'type'=>'number',
		'section'    => 'general_sec',
		'settings'   => 'weblizar_options[height]',
	) );
	$wp_customize->add_control( 'weblizar_logo_width', array(
		'label'        => __( 'Logo Width', 'weblizar' ),
		'type'=>'number',
		'section'    => 'general_sec',
		'settings'   => 'weblizar_options[width]',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'weblizar_upload_favicon_image', array(
		'label'        => __( 'Custom favicon', 'weblizar' ),
		'section'    => 'general_sec',
		'settings'   => 'weblizar_options[upload_image_favicon]',
	) ) );
	$wp_customize->add_setting(
	'weblizar_options[custom_css]',
		array(
		'default'=>esc_attr($wl_theme_options['custom_css']),
		'type'=>'option',
		'capability'=>'edit_theme_options',
		'sanitize_callback'=>'weblizar_sanitize_text',
		)
	);
	$wp_customize->add_control( 'custom_css', array(
		'label'        => __( 'Custom CSS', 'weblizar' ),
		'type'=>'textarea',
		'section'    => 'general_sec',
		'settings'   => 'weblizar_options[custom_css]'
	) );
	/* Slider Section */
	$wp_customize->add_section(
        'slider_sec',
        array(
            'title' => __('Theme Slider Options','weblizar'),
			'panel'=>'weblizar_theme_option',
            'description' => __('Here you can add slider images','weblizar'),
			'capability'=>'edit_theme_options',
            'priority' => 35,
			'active_callback' => 'is_front_page',
        )
    );
	$wp_customize->add_setting(
		'weblizar_options[slide_image]',
		array(
			'type'    => 'option',
			'default'=>$ImageUrl1,
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'esc_url_raw',
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_image_1]',
		array(
			'type'    => 'option',
			'default'=>$ImageUrl2,
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'esc_url_raw'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_image_2]',
		array(
			'type'    => 'option',
			'default'=>$ImageUrl3,
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'esc_url_raw',
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_title]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_title'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'weblizar_sanitize_text'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_title_1]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_title_1'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'weblizar_sanitize_text'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_title_2]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_title_2'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'weblizar_sanitize_text'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_desc]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_desc'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'weblizar_sanitize_text'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_desc_1]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_desc_1'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'weblizar_sanitize_text'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_desc_2]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_desc_2'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'weblizar_sanitize_text'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_btn_text]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_btn_text'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'weblizar_sanitize_text'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_btn_text_1]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_btn_text_1'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'weblizar_sanitize_text'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_btn_text_2]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_btn_text_2'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'weblizar_sanitize_text'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_btn_link]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_btn_link'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'esc_url_raw'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_btn_link_1]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_btn_link_1'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'esc_url_raw'
		)
	);
	$wp_customize->add_setting(
		'weblizar_options[slide_btn_link_2]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['slide_btn_link_2'],
			'capability' => 'edit_theme_options',
			'sanitize_callback'=>'esc_url_raw'
		)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'weblizar_slider_image_1', array(
		'label'        => __( 'Slider Image One', 'weblizar' ),
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_image]'
	) ) );
	$wp_customize->add_control( 'weblizar_slide_title_1', array(
		'label'        => __( 'Slider title one', 'weblizar' ),
		'type'=>'text',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_title]'
	) );
	$wp_customize->add_control( 'weblizar_slide_desc_1', array(
		'label'        => __( 'Slider description one', 'weblizar' ),
		'type'=>'text',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_desc]'
	) );
	$wp_customize->add_control( 'Slider button one', array(
		'label'        => __( 'Slider Button Text One', 'weblizar' ),
		'type'=>'text',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_btn_text]'
	) );
	
	$wp_customize->add_control( 'weblizar_slide_btnlink_1', array(
		'label'        => __( 'Slider Button Link', 'weblizar' ),
		'type'=>'url',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_btn_link]'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'weblizar_slider_image_2', array(
		'label'        => __( 'Slider Image Two ', 'weblizar' ),
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_image_1]'
	) ) );
	
	$wp_customize->add_control( 'weblizar_slide_title_2', array(
		'label'        => __( 'Slider Title Two', 'weblizar' ),
		'type'=>'text',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_title_1]'
	) );
	$wp_customize->add_control( 'weblizar_slide_desc_2', array(
		'label'        => __( 'Slider Description Two', 'weblizar' ),
		'type'=>'text',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_desc_1]'
	) );
	$wp_customize->add_control( 'weblizar_slide_btn_2', array(
		'label'        => __( 'Slider Button Text Two', 'weblizar' ),
		'type'=>'text',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_btn_text_1]'
	) );
	$wp_customize->add_control( 'weblizar_slide_btnlink_2', array(
		'label'        => __( 'Slider Link Two', 'weblizar' ),
		'type'=>'url',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_btn_link_1]'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'weblizar_slider_image_3', array(
		'label'        => __( 'Slider Image Three', 'weblizar' ),
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_image_2]'
	) ) );
	$wp_customize->add_control( 'weblizar_slide_title_3', array(
		'label'        => __( 'Slider Title Three', 'weblizar' ),
		'type'=>'text',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_title_2]'
	) );
	
	$wp_customize->add_control( 'weblizar_slide_desc_3', array(
		'label'        => __( 'Slider Description Three', 'weblizar' ),
		'type'=>'text',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_desc_2]'
	) );
	$wp_customize->add_control( 'weblizar_slide_btn_3', array(
		'label'        => __( 'Slider Button Text Three', 'weblizar' ),
		'type'=>'text',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_btn_text_2]'
	) );
	$wp_customize->add_control( 'weblizar_slide_btnlink_3', array(
		'label'        => __( 'Slider Button Link Three', 'weblizar' ),
		'type'=>'url',
		'section'    => 'slider_sec',
		'settings'   => 'weblizar_options[slide_btn_link_2]'
	) );
	
	/* Portfolio Section */
	$wp_customize->add_section(
        'portfolio_section',
        array(
            'title' => __('Portfolio Options','weblizar'),
            'description' => __('Here you can add Portfolio title,description and even portfolios','weblizar'),
			'panel'=>'weblizar_theme_option',
			'capability'=>'edit_theme_options',
            'priority' => 36,
			'active_callback' => 'is_front_page',
        )
    );

	/* Blog Option */
	$wp_customize->add_section('blog_section',array(
	'title'=>__('Site Info Option','weblizar'),
	'panel'=>'weblizar_theme_option',
	'capability'=>'edit_theme_options',
    'priority' => 37
	));
	$wp_customize->add_setting(
	'weblizar_options[site_intro_title]',
		array(
		'default'=>esc_attr($wl_theme_options['site_intro_title']),
		'type'=>'option',
		'capability'=>'edit_theme_options',
		'sanitize_callback'=>'weblizar_sanitize_text',
		)
	);
	$wp_customize->add_setting(
	'weblizar_options[site_intro_text]',
		array(
		'default'=>esc_attr($wl_theme_options['site_intro_text']),
		'type'=>'option',
		'capability'=>'edit_theme_options',
		'sanitize_callback'=>'weblizar_sanitize_text',
		)
	);
	$wp_customize->add_setting(
	'weblizar_options[blog_title]',
		array(
		'default'=>esc_attr($wl_theme_options['blog_title']),
		'type'=>'option',
		'sanitize_callback'=>'weblizar_sanitize_text',
		'capability'=>'edit_theme_options'
		)
	);
	$wp_customize->add_control( 'weblizar_blog_title', array(
		'label'        => __( 'Home Blog Title', 'weblizar' ),
		'type'=>'text',
		'section'    => 'blog_section',
		'settings'   => 'weblizar_options[blog_title]'
	) );
	$wp_customize->add_setting(
	'weblizar_options[blog_text]',
		array(
		'default'=>esc_attr($wl_theme_options['blog_text']),
		'type'=>'option',
		'sanitize_callback'=>'weblizar_sanitize_text',
		'capability'=>'edit_theme_options'
		)
	);
	$wp_customize->add_setting(
	'weblizar_options[blog_count]',
		array(
		'default'=>$wl_theme_options['blog_count'],
		'type'=>'option',
		'sanitize_callback'=>'weblizar_sanitize_text',
		'capability'=>'edit_theme_options'
		)
	);
	$count_posts = wp_count_posts();
	$published_posts = $count_posts->publish;
	$wp_customize->add_control( 'weblizar_blog_count', array(
		'label'        => __( 'Show Home Blog Post', 'weblizar' ),
		'type'=>'select',
		'section'    => 'blog_section',
		'settings'   => 'weblizar_options[blog_count]',
		'choices' => array(
            '3' => '3',
            '6' => '6',
            '9' => '9',
			'12' => '12',
			'15' => '15',
			$published_posts => 'Show All Post',
        ),
	) );
	$wp_customize->add_control( 'weblizar_blog_desc', array(
		'label'        => __( 'Home Blog Description', 'weblizar' ),
		'type'=>'textarea',
		'section'    => 'blog_section',
		'settings'   => 'weblizar_options[blog_text]'
	) );
	$wp_customize->add_control( 'weblizar_service_title', array(
		'label'        => __( 'Site Info Title', 'weblizar' ),
		'type'	=>'text',
		'section'    => 'blog_section',
		'settings'   => 'weblizar_options[site_intro_title]'
	) );
	$wp_customize->add_control( 'weblizar_service_description', array(
		'label'        => __( 'Site Info Description', 'weblizar' ),
		'type'	=>'textarea',
		'section'    => 'blog_section',
		'settings'   => 'weblizar_options[site_intro_text]'
	) );
	
	/* Service Section */
	$wp_customize->add_section('service_section',array(
	'title'=>__("Service Options","weblizar"),
	'panel'=>'weblizar_theme_option',
	'capability'=>'edit_theme_options',
    'priority' => 35,
	'active_callback' => 'is_front_page',
	));
	$wp_customize->add_setting(
		'weblizar_options[service_enable]',
		array(
			'type'    => 'option',
			'default'=>$wl_theme_options['service_enable'],
			'sanitize_callback'=>'weblizar_sanitize_checkbox',
			'capability'        => 'edit_theme_options',
		)
	);
	
	$wp_customize->add_control( 'weblizar_service_enabled', array(
		'label'        => __( 'Enable Home Service', 'weblizar' ),
		'type'=>'checkbox',
		'section'    => 'service_section',
		'settings'   => 'weblizar_options[service_enable]',
	) );
	
	for($i=1;$i<=4;$i++){
	$wp_customize->add_setting(
	'weblizar_options[service_'.$i.'_icons]',
		array(
		'default'=>esc_attr($wl_theme_options['service_'.$i.'_icons']),
		'type'=>'option',
		'capability'=>'edit_theme_options',
		'sanitize_callback'=>'weblizar_sanitize_text',
			)
	);
	$wp_customize->add_setting(
	'weblizar_options[service_'.$i.'_title]',
		array(
		'default'=>esc_attr($wl_theme_options['service_'.$i.'_title']),
		'type'=>'option',
		'capability'=>'edit_theme_options',
		'sanitize_callback'=>'weblizar_sanitize_text',
			)
	);
	$wp_customize->add_setting(
	'weblizar_options[service_'.$i.'_text]',
		array(
		'default'=>esc_attr($wl_theme_options['service_'.$i.'_text']),
		'type'=>'option',
		'sanitize_callback'=>'weblizar_sanitize_text',
		'capability'=>'edit_theme_options',
			)
	);
	$wp_customize->add_setting(
	'weblizar_options[service_'.$i.'_link]',
		array(
		'type'    => 'option',
		'default'=>$wl_theme_options['service_'.$i.'_link'],
		'capability' => 'edit_theme_options',
		'sanitize_callback'=>'esc_url_raw'
		)
	);
	}
	for($i=1;$i<=4;$i++){
	$j = array('', ' One', ' Two', ' Three');
	$wp_customize->add_control( new weblizar_Customize_Misc_Control($wp_customize, 'weblizar_options1-line', array(
            'section'  => 'service_section',
            'type'     => 'line'
        )
    ));
	$wp_customize->add_control( 'weblizar_service_icon'.$i, array(
		'label'        => __( 'service-icon-'.$i.'', 'weblizar' ),
		'description'=>__('<a href="http://fontawesome.bootstrapcheatsheets.com">FontAwesome Icons</a>','weblizar'),
		'section'  => 'service_section',
		'settings'   => 'weblizar_options[service_'.$i.'_icons]'
    ) );
	$wp_customize->add_control( 'weblizar_service_title'.$i, array(
		'label'        => __( 'service-title-'.$i.'', 'weblizar' ),
		'type'=>'text',
		'section'    => 'service_section',
		'settings'   => 'weblizar_options[service_'.$i.'_title]'
	) );
	$wp_customize->add_control( 'weblizar_service_description_'.$i, array(
		'label'        => __( 'service-text-'.$i.'', 'weblizar' ),
		'type'=>	'textarea',
		'section'    => 'service_section',
		'settings'   => 'weblizar_options[service_'.$i.'_text]'
	) );
	$wp_customize->add_control( 'weblizar_service_link_'.$i, array(
		'label'        => __( 'service-link-'.$i.'', 'weblizar' ),
		'type'=>	'url',
		'section'    => 'service_section',
		'settings'   => 'weblizar_options[service_'.$i.'_link]',
	) );
	}
	/* Social options */
	$wp_customize->add_section('social_section',array(
	'title'=>__("Social Options","weblizar"),
	'panel'=>'weblizar_theme_option',
	'capability'=>'edit_theme_options',
    'priority' => 41
	));
	/* $wp_customize->add_setting(
	'weblizar_options[social_media_in_contact_page_enabled]',
		array(
		'default'=>esc_attr($wl_theme_options['social_media_in_contact_page_enabled']),
		'type'=>'option',
		'sanitize_callback'=>'weblizar_sanitize_checkbox',
		'capability'=>'edit_theme_options'
		)
	);
	$wp_customize->add_control( 'social_media_in_contact_page_enabled', array(
		'label'        => __( 'Enable Social Media Icons in contact page', 'weblizar' ),
		'type'=>'checkbox',
		'section'    => 'social_section',
		'settings'   => 'weblizar_options[social_media_in_contact_page_enabled]'
	) ); */
	$wp_customize->add_setting(
	'weblizar_options[footer_section_social_media_enbled]',
		array(
		'default'=>esc_attr($wl_theme_options['footer_section_social_media_enbled']),
		'type'=>'option',
		'sanitize_callback'=>'weblizar_sanitize_checkbox',
		'capability'=>'edit_theme_options'
		)
	);
	$wp_customize->add_control( 'footer_section_social_media_enbled', array(
		'label'        => __( 'Enable Social Media Icons in Footer', 'weblizar' ),
		'type'=>'checkbox',
		'section'    => 'social_section',
		'settings'   => 'weblizar_options[footer_section_social_media_enbled]'
	) );
	$wp_customize->add_setting(
	'weblizar_options[social_media_facebook_link]',
		array(
		'default'=>esc_attr($wl_theme_options['social_media_facebook_link']),
		'type'=>'option',
		'sanitize_callback'=>'esc_url',
		'capability'=>'edit_theme_options'
		)
	);
	$wp_customize->add_control( 'social_media_facebook_link', array(
		'label'        => __( 'Facebook URL', 'weblizar' ),
		'type'=>'url',
		'section'    => 'social_section',
		'settings'   => 'weblizar_options[social_media_facebook_link]'
	) );
	$wp_customize->add_setting(
	'weblizar_options[social_media_twitter_link]',
		array(
		'default'=>esc_attr($wl_theme_options['social_media_twitter_link']),
		'type'=>'option',
		'sanitize_callback'=>'esc_url',
		'capability'=>'edit_theme_options'
		)
	);
	$wp_customize->add_control( 'social_media_twitter_link', array(
		'label'        =>  __('Twitter URL', 'weblizar' ),
		'type'=>'url',
		'section'    => 'social_section',
		'settings'   => 'weblizar_options[social_media_twitter_link]'
	) );
	$wp_customize->add_setting(
	'weblizar_options[social_media_linkedin_link]',
		array(
		'default'=>esc_attr($wl_theme_options['social_media_linkedin_link']),
		'type'=>'option',
		'sanitize_callback'=>'esc_url',
		'capability'=>'edit_theme_options'
		)
	);
		$wp_customize->add_control( 'social_media_linkedin_link', array(
		'label'        => __( 'LinkedIn URL', 'weblizar' ),
		'type'=>'url',
		'section'    => 'social_section',
		'settings'   => 'weblizar_options[social_media_linkedin_link]'
	) );
	$wp_customize->add_setting(
	'weblizar_options[social_media_google_plus]',
		array(
		'default'=>esc_attr($wl_theme_options['social_media_google_plus']),
		'type'=>'option',
		'sanitize_callback'=>'esc_url',
		'capability'=>'edit_theme_options'
		)
	);
		$wp_customize->add_control( 'social_media_google_plus', array(
		'label'        => __( 'Goole+ URL', 'weblizar' ),
		'type'=>'url',
		'section'    => 'social_section',
		'settings'   => 'weblizar_options[social_media_google_plus]'
	) );
	/* Footer Options */
	$wp_customize->add_section('footer_section',array(
	'title'=>__("Footer Options","weblizar"),
	'panel'=>'weblizar_theme_option',
	'capability'=>'edit_theme_options',
    'priority' => 40
	));
	$wp_customize->add_setting(
	'weblizar_options[footer_customizations]',
		array(
		'default'=>esc_attr($wl_theme_options['footer_customizations']),
		'type'=>'option',
		'sanitize_callback'=>'weblizar_sanitize_text',
		'capability'=>'edit_theme_options'
		)
	);
	$wp_customize->add_control( 'weblizar_footer_customizations', array(
		'label'        => __( 'Footer Customization Text', 'weblizar' ),
		'type'=>'text',
		'section'    => 'footer_section',
		'settings'   => 'weblizar_options[footer_customizations]'
	) );
	
	$wp_customize->add_setting(
	'weblizar_options[developed_by_text]',
		array(
		'default'=>esc_attr($wl_theme_options['developed_by_text']),
		'type'=>'option',
		'sanitize_callback'=>'weblizar_sanitize_text',
		'capability'=>'edit_theme_options'
		)
	);
	$wp_customize->add_control( 'weblizar_developed_by_text', array(
		'label'        => __( 'Footer Developed By Text', 'weblizar' ),
		'type'=>'text',
		'section'    => 'footer_section',
		'settings'   => 'weblizar_options[developed_by_text]'
	) );
	$wp_customize->add_setting(
	'weblizar_options[developed_by_weblizar_text]',
		array(
		'default'=>esc_attr($wl_theme_options['developed_by_weblizar_text']),
		'type'=>'option',
		'sanitize_callback'=>'weblizar_sanitize_text',
		'capability'=>'edit_theme_options'
		)
	);
	$wp_customize->add_control( 'weblizar_developed_by_weblizar_text', array(
		'label'        => __( 'Footer Company Text', 'weblizar' ),
		'type'=>'text',
		'section'    => 'footer_section',
		'settings'   => 'weblizar_options[developed_by_weblizar_text]'
	) );
	$wp_customize->add_setting(
	'weblizar_options[developed_by_link]',
		array(
		'default'=>esc_attr($wl_theme_options['developed_by_link']),
		'type'=>'option',
		'capability'=>'edit_theme_options',
		'sanitize_callback'=>'esc_url_raw'
		)
	);
	$wp_customize->add_control( 'weblizar_developed_by_link', array(
		'label'        => __( 'Footer Customization Link', 'weblizar' ),
		'type'=>'url',
		'section'    => 'footer_section',
		'settings'   => 'weblizar_options[developed_by_link]'
	) );	
	
	$wp_customize->add_section( 'weblizar_more' , array(
				'title'      	=> __( 'Upgrade to Weblizar Premium', 'weblizar' ),
				'priority'   	=> 999,
				'panel'=>'weblizar_theme_option',
			) );

			$wp_customize->add_setting( 'weblizar_more', array(
				'default'    		=> null,
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$wp_customize->add_control( new More_weblizar_Control( $wp_customize, 'weblizar_more', array(
				'label'    => __( 'Weblizar Premium', 'weblizar' ),
				'section'  => 'weblizar_more',
				'settings' => 'weblizar_more',
				'priority' => 1,
			) ) );
}
add_action( 'customize_register', 'weblizar_customizer' );
function weblizar_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
function weblizar_sanitize_checkbox( $input ) {
    if ( $input == 'on' ) {
        return 'on';
    } else {
        return '';
    }
}
function weblizar_sanitize_integer( $input ) {
    return (int)($input);
}
/* Custom Control Class */
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'weblizar_Customize_Misc_Control' ) ) :
class weblizar_Customize_Misc_Control extends WP_Customize_Control {
    public $settings = 'blogname';
    public $description = '';
    public function render_content() {
        switch ( $this->type ) {
            default:
           
            case 'heading':
                echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
                break;
 
            case 'line' :
                echo '<hr />';
                break;
			
        }
    }
}
endif;


if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'More_weblizar_Control' ) ) :
class More_weblizar_Control extends WP_Customize_Control {

	/**
	* Render the content on the theme customizer page
	*/
	public function render_content() {
		?>
		<label style="overflow: hidden; zoom: 1;">
			<div class="col-md-2 col-sm-6 upsell-btn">					
					<a style="margin-bottom:20px;margin-left:20px;" href="https://weblizar.com/themes/weblizar-premium-theme/" target="blank" class="btn btn-success btn"><?php _e('Upgrade to Weblizar Premium','weblizar'); ?> </a>
			</div>
			<div class="col-md-4 col-sm-6">
				<img class="enigma_img_responsive " src="<?php echo WL_TEMPLATE_DIR_URI .'/core/theme-options/images/weblizar-detail.png'?>">
			</div>			
			<div class="col-md-3 col-sm-6">
				<h3 style="margin-top:10px;margin-left: 20px;text-decoration:underline;color:#333;"><?php echo _e( 'Weblizar Premium - Features','weblizar'); ?></h3>
					<ul style="padding-top:20px">
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div> <?php _e('Responsive Design','weblizar'); ?></li>						
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div><?php _e('15+ Templates','weblizar'); ?> </li></li>
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div><?php _e('Patterns Background','weblizar'); ?>    </li>
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div><?php _e('Isotope Effect','weblizar'); ?>  </li>
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div><?php _e('12 types Themes Colors Scheme','weblizar'); ?>  </li>
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div> <?php _e('5 portfolio Templates','weblizar'); ?> </li>
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div><?php _e('Rich Short codes','weblizar'); ?> </li>
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div> <?php _e('Translation Ready','weblizar'); ?> </li>
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div><?php _e('Coming Soon Mode','weblizar'); ?>  </li>
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div><?php _e('Image Background','weblizar'); ?></li>	
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div> <?php _e('Google Fonts','weblizar'); ?>  </li>
						<li class="upsell-enigma"> <div class="dashicons dashicons-yes"></div><?php _e('Ultimate Portfolio layout with Isotope effect','weblizar'); ?></li>
						
					
					</ul>
			</div>
			<div class="col-md-2 col-sm-6 upsell-btn">					
					<a style="margin-bottom:20px;margin-left:20px;" href="https://weblizar.com/themes/weblizar-premium-theme/" target="blank" class="btn btn-success btn"><?php _e('Upgrade to Weblizar Premium','weblizar'); ?> </a>
			</div>
			<span class="customize-control-title"><?php _e( 'Enjoying Weblizar?', 'weblizar' ); ?></span>
			<p>
				<?php
					printf( __( 'If you Like our Products , Please do Rate us on %sWordPress.org%s?  We\'d really appreciate it!', 'weblizar' ), '<a target="" href="https://wordpress.org/support/view/theme-reviews/weblizar?filter=5">', '</a>' );
				?>
			</p>
		</label>
		<?php
	}
}
endif;
?>