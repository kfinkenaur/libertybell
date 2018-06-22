<?php
/**
 * Opportune Theme Customizer
 * @package Opportune
 */
 
 /**
 * We will add our theme info to the customizer as well as the Appearance admin menu
 */
 function opportune_customizer_registers() {
	
	wp_enqueue_script( 'opportune_customizer_script', get_template_directory_uri() . '/js/opportune_customizer.js', array("jquery"), '1.0', true  );
	wp_localize_script( 'opportune_customizer_script', 'opportuneCustomizerObject', array(
		'setup' => __( 'Setup Tutorials', 'opportune' ),
		'support' => __( 'Theme Support', 'opportune' ),
		'review' => __( 'Please Rate Opportune', 'opportune' ),		
		'pro' => __( 'Get the Pro Version', 'opportune' ),
	) );
}
add_action( 'customize_controls_enqueue_scripts', 'opportune_customizer_registers' );
 
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
 
function opportune_customize_register( $wp_customize ) {

	// Lets make some changes to the default Wordpress sections and controls
  	$wp_customize->remove_control('display_header_text');
  	$wp_customize->remove_control('header_textcolor');
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	


	// Setting group to show the site title  
  	$wp_customize->add_setting( 'show_site_title',  array(
		'default' => 1,
		'sanitize_callback' => 'opportune_sanitize_checkbox'
   	 ) );  
 	 $wp_customize->add_control( 'show_site_title', array(
		'type'     => 'checkbox',
		'priority' => 1,
		'label'    => esc_html__( 'Show Site Title', 'opportune' ),
		'section'  => 'title_tagline',
 	 ) );

	// Setting group to show the tagline  
	 $wp_customize->add_setting( 'show_tagline', array(
		'default' => 1,
		'sanitize_callback' => 'opportune_sanitize_checkbox'
	  ) );  
	$wp_customize->add_control( 'show_tagline', array(
		'type'     => 'checkbox',
		'priority' => 2,
		'label'    => esc_html__( 'Show Tagline', 'opportune' ),
		'section'  => 'title_tagline',
	) );
  
	// Setting group to show the tagline 
	$wp_customize->add_setting('logo_upload[logo]', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'type'           	=> 'option',
			'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'site_logo', array(
		'label'    => esc_html__('Your Logo', 'opportune'),
		'section'  => 'title_tagline',
		'settings' => 'logo_upload[logo]',
			'priority' => 3,
	)));		

			
/*
 * Create a section
 * Name: Site Options
 */    
	$wp_customize->add_section( 'site_options', array(
		'title' => esc_html__( 'Site Options', 'opportune' ),
		'priority'       => 30,
	) ); 
	
// Setting group for the boxed style
	$wp_customize->add_setting( 'boxed_style', array(
		'default' => 'fullwidth',
		'sanitize_callback' => 'opportune_sanitize_boxed_style',
	) );  
	$wp_customize->add_control( 'boxed_style', array(
		  'type' => 'radio',
		  'label' => esc_html__( 'Boxed Style', 'opportune' ),
		  'section' => 'site_options',
		  'priority' => 1,
		  'choices' => array(
			  'fullwidth' => esc_html__( 'Full Width', 'opportune' ),
			  'boxed1920' => esc_html__( 'Boxed 1920px Width', 'opportune' ),
			  'boxed1600' => esc_html__( 'Boxed 1600px Width', 'opportune' ),
			  'boxed1400' => esc_html__( 'Boxed 1400px Width', 'opportune' ),
	) ) );
// Setting group for the header style
	$wp_customize->add_setting( 'header_style', array(
		'default' => 'default',
		'sanitize_callback' => 'opportune_sanitize_header_style',
	) );  
	$wp_customize->add_control( 'header_style', array(
		  'type' => 'radio',
		  'label' => esc_html__( 'Header Style', 'opportune' ),
		  'section' => 'site_options',
		  'priority' => 2,
		  'choices' => array(
			  'default' => esc_html__( 'Logo to the Left and Menu Right', 'opportune' ),
			  'centered' => esc_html__( 'Centered Logo and Menu Below', 'opportune' ),	
	) ) );
	
// Setting group for a Copyright
	$wp_customize->add_setting( 'copyright', array(
		'default'        => esc_html__( 'Your Name', 'opportune' ),
		'sanitize_callback' => 'opportune_sanitize_text',
	) );
	$wp_customize->add_control( 'copyright', array(
		'settings' => 'copyright',
		'label'    => esc_html__( 'Your Copyright Name', 'opportune' ),
		'section'  => 'site_options',		
		'type'     => 'text',
		'priority' => 3,
	) );
// Setting group to enable font awesome 
  $wp_customize->add_setting( 'load_fontawesome',	array(
 		'default' => 1,
		'sanitize_callback' => 'opportune_sanitize_checkbox',
	) );  
  $wp_customize->add_control( 'load_fontawesome', array(
		'type'     => 'checkbox',
		'priority' => 4,
		'label'    => esc_html__( 'Load Font Awesome', 'opportune' ),
		'description' => esc_html__( 'Load Font Awesome if not you are not using a plugin for it.', 'opportune' ),
		'section'  => 'site_options',
  	) );
	
				
/*
 * Lets add some more options to the header image
 * customizer section tab
 */ 	
 
 // Setting group to show the WP Custom Header  
  $wp_customize->add_setting( 'show_custom_header',  array(
      'default' => 1,
      'sanitize_callback' => 'opportune_sanitize_checkbox',
    ) );  
  $wp_customize->add_control( 'show_custom_header', array(
    'type'     => 'checkbox',
    'priority' => 1,
    'label'    => esc_html__( 'Show or Hide the Custom Header', 'opportune' ),
	'description' => esc_html__( 'You can disable the WP Header Image from showing throughout your website.', 'opportune' ),
    'section'  => 'header_image',
  ) );	
  // Setting group to show the WP Custom Header caption box 
  $wp_customize->add_setting( 'show_header_image_caption',  array(
      'default' => 1,
      'sanitize_callback' => 'opportune_sanitize_checkbox',
    ) );  
  $wp_customize->add_control( 'show_header_image_caption', array(
    'type'     => 'checkbox',
    'priority' => 2,
    'label'    => esc_html__( 'Show the Header Image Caption Box', 'opportune' ),
	'description' => esc_html__( 'When using the WP Header Image feature, you can show or hide the caption box.', 'opportune' ),
    'section'  => 'header_image',
  ) ); 
  
// Setting group for the WP Custom Header caption box title
	$wp_customize->add_setting( 'custom_header_caption_title', array(
		'default'        => 'Modern Creativity',
		'sanitize_callback' => 'opportune_sanitize_text',
	) );
	$wp_customize->add_control( 'custom_header_caption_title', array(
		'settings' => 'custom_header_caption_title',
		'label'    => esc_html__( 'Header Caption Title', 'opportune' ),
		'section'  => 'header_image',		
		'type'     => 'text',
		'priority' => 3,
	) );

// Setting group for the WP Custom Header caption box
	$wp_customize->add_setting( 'custom_header_caption', array(
		'default'        => 'Exceptional Features on many Levels',
		'sanitize_callback' => 'opportune_sanitize_text',
	) );
	$wp_customize->add_control( 'custom_header_caption', array(
		'settings' => 'custom_header_caption',
		'label'    => esc_html__( 'Header Caption', 'opportune' ),
		'section'  => 'header_image',		
		'type'     => 'text',
		'priority' => 4,
	) );

/*
 * Create a section
 * Name: Blog Options
 */  
	$wp_customize->add_section( 'blog_options',	array(
		'title' => esc_html__( 'Blog Options', 'opportune' ),
		'priority' => 32,
	)  ); 


// Setting group for blog layout  
	$wp_customize->add_setting( 'blog_style', array(
		'default' => 'top-featured-right',
		'sanitize_callback' => 'opportune_sanitize_blog_style',
	) );  
	$wp_customize->add_control( 'blog_style', array(
		  'type' => 'radio',
		  'label' => esc_html__( 'Blog Style', 'opportune' ),
		  'section' => 'blog_options',
		  'priority' => 1,
		  'choices' => array(	
			  	'left-featured' => esc_html__( 'Left Featured Image', 'opportune' ),	
				'top-featured' => esc_html__( 'Top Featured Image', 'opportune' ),	  
				'top-featured-center' => esc_html__( 'Top Featured Image Centered', 'opportune' ),
				'top-featured-left' => esc_html__( 'Top Featured Image Left Sidebar', 'opportune' ),
				'top-featured-right' => esc_html__( 'Top Featured Image Right Sidebar', 'opportune' ),
	) ) );
	
// Setting group for Single layout  
	$wp_customize->add_setting( 'single_layout', array(
		'default' => 'right-column',
		'sanitize_callback' => 'opportune_sanitize_single_layout',
	) );  
	$wp_customize->add_control( 'single_layout', array(
		  'type' => 'radio',
		  'label' => esc_html__( 'Single Style', 'opportune' ),
		  'section' => 'blog_options',
		  'priority' => 2,
		  'choices' => array(		
			  'right-column' => esc_html__( 'Right Column Layout', 'opportune' ),
			  'left-column' => esc_html__( 'Left Column Layout', 'opportune' ),
			  'full-width' => esc_html__( 'Full Width', 'opportune' ),
	) ) );


// Setting for content or excerpt
	$wp_customize->add_setting( 'excerpt_content', array(
		'default' => 'content',
		'sanitize_callback' => 'opportune_sanitize_excerpt',
	) );
// Control for Content or excerpt
	$wp_customize->add_control( 'excerpt_content', array(
    'label'   => esc_html__( 'Content or Excerpt', 'opportune' ),
    'section' => 'blog_options',
    'type'    => 'radio',
        'choices' => array(
            'content' => esc_html__( 'Content', 'opportune' ),
            'excerpt' => esc_html__( 'Excerpt', 'opportune' ),	
        ),
	'priority'       => 3,
    ));

// Setting group for a excerpt
	$wp_customize->add_setting( 'excerpt_limit', array(
		'default'        => '50',
		'sanitize_callback' => 'opportune_sanitize_number',
	) );
	$wp_customize->add_control( 'excerpt_limit', array(
		'settings' => 'excerpt_limit',
		'label'    => esc_html__( 'Excerpt Length', 'opportune' ),
		'section'  => 'blog_options',
		'type'     => 'text',
		'priority'   => 4,
	) );

// Setting group to show the edit links  
  $wp_customize->add_setting( 'show_edit',  array(
      'default' => 1,
      'sanitize_callback' => 'opportune_sanitize_checkbox',
    ) );  
  $wp_customize->add_control( 'show_edit', array(
    'type'     => 'checkbox',
    'priority' => 7,
    'label'    => esc_html__( 'Show Edit Link', 'opportune' ),
    'section'  => 'blog_options',
  ) );
    
// Setting group to show the categories  
  $wp_customize->add_setting( 'show_single_categories',  array(
      'default' => 1,
      'sanitize_callback' => 'opportune_sanitize_checkbox',
    )
  );  
  $wp_customize->add_control( 'show_single_categories', array(
    'type'     => 'checkbox',
    'priority' => 9,
    'label'    => esc_html__( 'Show Categories on Full Post', 'opportune' ),
    'section'  => 'blog_options',
  ) );  
  
// Setting group to show the date  
  $wp_customize->add_setting( 'show_posted_date',  array(
      'default' => 1,
      'sanitize_callback' => 'opportune_sanitize_checkbox',
    )
  );  
  $wp_customize->add_control( 'show_posted_date', array(
    'type'     => 'checkbox',
    'priority' => 10,
    'label'    => esc_html__( 'Show Posted Date', 'opportune' ),
    'section'  => 'blog_options',
  ) );

// Setting group to show tags  
  $wp_customize->add_setting( 'show_tags_list',  array(
      'default' => 1,
      'sanitize_callback' => 'opportune_sanitize_checkbox',
    )
  );  
  $wp_customize->add_control( 'show_tags_list', array(
    'type'     => 'checkbox',
    'priority' => 11,
    'label'    => esc_html__( 'Show Tags', 'opportune' ),
    'section'  => 'blog_options',
  ) );

// Setting group to show share buttons  
  $wp_customize->add_setting( 'show_single_thumbnail',   array(
      'default' => 1,
      'sanitize_callback' => 'opportune_sanitize_checkbox',
    )
  );  
  $wp_customize->add_control( 'show_single_thumbnail', array(
    'type'     => 'checkbox',
    'priority' => 12,
    'label'    => esc_html__( 'Show Featured Image on Full Post', 'opportune' ),
    'section'  => 'blog_options',
  ) );

// Setting group to show published by  
  $wp_customize->add_setting( 'show_post_author',   array(
      'default' => 1,
      'sanitize_callback' => 'opportune_sanitize_checkbox',
    )
  ); 
  $wp_customize->add_control( 'show_post_author', array(
    'type'     => 'checkbox',
    'priority' => 13,
    'label'    => esc_html__( 'Show Post Author', 'opportune' ),
    'section'  => 'blog_options',
  ) );
  
  // Setting group for the post format label
  $wp_customize->add_setting( 'show_format_label',  array(
      'default' => 1,
      'sanitize_callback' => 'opportune_sanitize_checkbox'
    )
  );  
  $wp_customize->add_control( 'show_format_label', array(
    'type'        => 'checkbox',
    'priority'    => 14,
    'label'       => esc_html__( 'Show Post Format Label', 'opportune' ),
    'section'     => 'blog_options',
   ) );
  
 // Setting group for the single post next prev nav
  $wp_customize->add_setting( 'show_next_prev',  array(
      'default' => 1,
      'sanitize_callback' => 'opportune_sanitize_checkbox'
    )
  );  
  $wp_customize->add_control( 'show_next_prev', array(
    'type'        => 'checkbox',
    'priority'    => 15,
    'label'       => esc_html__( 'Show Post Next Previous Navigation', 'opportune' ),
    'section'     => 'blog_options',
   ) ); 
   
// Setting group for the sticky post title  
  $wp_customize->add_setting( 'sticky_post_label',   array(
      'default' => '',
      'sanitize_callback' => 'opportune_sanitize_text'
    )
  );  
  $wp_customize->add_control( 'sticky_post_label', array(
    'type'        => 'text',
    'priority'    => 16,
    'label'       => esc_html__( 'Sticky Post Label', 'opportune' ),
    'section'     => 'blog_options',
    'description' => esc_html__( 'Default: Featured', 'opportune' )
   ) );
   
  
   	
/*
 * Add to the Colours tab
 */

// Setting group  for the header bg	
 	$wp_customize->add_setting( 'header_bg', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg', array(
		'label'   => esc_html__( 'Header Background Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'header_bg',
		'priority' => 1,			
	) ) );	
// Site Title Colour	
 	$wp_customize->add_setting( 'site_title_colour', array(
		'default'        => '#333',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_title_colour', array(
		'label'   => esc_html__( 'Site Title Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'site_title_colour',
		'priority' => 2,			
	) ) );
// Site Description Colour	
 	$wp_customize->add_setting( 'site_desc_colour', array(
		'default'        => '#616161',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_desc_colour', array(
		'label'   => esc_html__( 'Site Description Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'site_desc_colour',
		'priority' => 3,			
	) ) );
// Top Level menu colour	
 	$wp_customize->add_setting( 'top_items_color', array(
		'default'        => '#222222',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_items_color', array(
		'label'   => esc_html__( 'Top Level Menu Item Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'top_items_color',
		'priority' => 4,			
	) ) );
// Top Level menu active and hover colour	
 	$wp_customize->add_setting( 'top_level_active', array(
		'default'        => '#dcc593',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_level_active', array(
		'label'   => esc_html__( 'Top Level Hover &amp; Active Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'top_level_active',
		'priority' => 5,			
	) ) );	
// Submenu item colour	
 	$wp_customize->add_setting( 'submenu_items_color', array(
		'default'        => '#727679',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'submenu_items_color', array(
		'label'   => esc_html__( 'Submenu Item Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'submenu_items_color',
		'priority' => 6,			
	) ) );
// Submenu background colour	
 	$wp_customize->add_setting( 'submenu_background', array(
		'default'        => '#fbfbfb',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'submenu_background', array(
		'label'   => esc_html__( 'Submenu Background', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'submenu_background',
		'priority' => 7,			
	) ) );
// Submenu border colour	
 	$wp_customize->add_setting( 'submenu_border', array(
		'default'        => '#d9d9d9',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'submenu_border', array(
		'label'   => esc_html__( 'Submenu Bottom Border', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'submenu_border',
		'priority' => 8,			
	) ) );
// Banner background	
 	$wp_customize->add_setting( 'banner_bg', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'banner_bg', array(
		'label'   => esc_html__( 'Banner Box Background', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'banner_bg',
		'priority' => 9,			
	) ) );
// Content background	
 	$wp_customize->add_setting( 'content_bg', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_bg', array(
		'label'   => esc_html__( 'Content Background Area', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'content_bg',
		'priority' => 10,			
	) ) );
// Content Top Border
 	$wp_customize->add_setting( 'header_bottom_border', array(
		'default'        => '#d9d9d9',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bottom_border', array(
		'label'   => esc_html__( 'Header Bottom Border', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'header_bottom_border',
		'priority' => 11,			
	) ) );
// Content text colour
 	$wp_customize->add_setting( 'content_text', array(
		'default'        => '#5f5f5f',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_text', array(
		'label'   => esc_html__( 'Main Content Text Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'content_text',
		'priority' => 12,			
	) ) );
// Content link colour
 	$wp_customize->add_setting( 'content_links', array(
		'default'        => '#be9a4d',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_links', array(
		'label'   => esc_html__( 'Text Link Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'content_links',
		'priority' => 13,			
	) ) );
// Content link hover colour
 	$wp_customize->add_setting( 'content_links_hover', array(
		'default'        => '#616161',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_links_hover', array(
		'label'   => esc_html__( 'Text Link Hover Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'content_links_hover',
		'priority' => 14,			
	) ) );
	
// Sidebar link  colour
 	$wp_customize->add_setting( 'sidebar_text', array(
		'default'        => '#9a9a9a',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_text', array(
		'label'   => esc_html__( 'Sidebar Text &amp; Link', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'sidebar_text',
		'priority' => 15,			
	) ) );	
// Sidebar link hover colour
 	$wp_customize->add_setting( 'sidebar_link_hover', array(
		'default'        => '#be9a4d',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_link_hover', array(
		'label'   => esc_html__( 'Sidebar Link  Hover Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'sidebar_link_hover',
		'priority' => 16,			
	) ) );	
	
	
// Bottom Sidebar Background
 	$wp_customize->add_setting( 'bottom_sidebars_bg', array(
		'default'        => '#a4bbba',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_sidebars_bg', array(
		'label'   => esc_html__( 'Bottom Sidebars Background', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'bottom_sidebars_bg',
		'priority' => 17,			
	) ) );
// Bottom Sidebar text colour
 	$wp_customize->add_setting( 'bottom_sidebars_text', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_sidebars_text', array(
		'label'   => esc_html__( 'Bottom Sidebars Text Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'bottom_sidebars_text',
		'priority' => 18,			
	) ) );
// Bottom Sidebar link colour
 	$wp_customize->add_setting( 'bottom_sidebar_links', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_sidebar_links', array(
		'label'   => esc_html__( 'Bottom Sidebars Link Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'bottom_sidebar_links',
		'priority' => 19,			
	) ) );
// Bottom Sidebar link hover colour
 	$wp_customize->add_setting( 'bottom_sidebar_links_hover', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_sidebar_links_hover', array(
		'label'   => esc_html__( 'Bottom Sidebars Link Hover Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'bottom_sidebar_links_hover',
		'priority' => 20,			
	) ) );

// Blog read more button
 	$wp_customize->add_setting( 'blog_readmore', array(
		'default'        => '#b7c7c6',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blog_readmore', array(
		'label'   => esc_html__( 'Blog Read More Button', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'blog_readmore',
		'priority' => 21,			
	) ) );

// Blog read more button
 	$wp_customize->add_setting( 'blog_hreadmore', array(
		'default'        => '#d6bb7f',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blog_hreadmore', array(
		'label'   => esc_html__( 'Blog Read More Button Hover', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'blog_hreadmore',
		'priority' => 22,			
	) ) );

// Button background colour
 	$wp_customize->add_setting( 'button_bg', array(
		'default'        => '#62686e',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_bg', array(
		'label'   => esc_html__( 'Button Background Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'button_bg',
		'priority' => 23,			
	) ) );

// Button text colour
 	$wp_customize->add_setting( 'button_text', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_text', array(
		'label'   => esc_html__( 'Button Text  Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'button_text',
		'priority' => 24,			
	) ) );

// Button hover background colour
 	$wp_customize->add_setting( 'button_hbg', array(
		'default'        => '#dfe3e6',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_hbg', array(
		'label'   => esc_html__( 'Button Hover Background Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'button_hbg',
		'priority' => 25,			
	) ) );

// Button hover text colour
 	$wp_customize->add_setting( 'button_htext', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_htext', array(
		'label'   => esc_html__( 'Button Hover Text  Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'button_htext',
		'priority' => 26,			
	) ) );

// Footer text colour
 	$wp_customize->add_setting( 'footer_text', array(
		'default'        => '#cccccc',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_text', array(
		'label'   => esc_html__( 'Footer Text  Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'footer_text',
		'priority' => 27,			
	) ) );				
// Footer links colour
 	$wp_customize->add_setting( 'footer_links', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_links', array(
		'label'   => esc_html__( 'Footer Link  Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'footer_links',
		'priority' => 28,			
	) ) );
	
// Footer links hover colour
 	$wp_customize->add_setting( 'footer_hlinks', array(
		'default'        => '#cccccc',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_hlinks', array(
		'label'   => esc_html__( 'Footer Link  Hover Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'footer_hlinks',
		'priority' => 29,			
	) ) );
// Social bg
 	$wp_customize->add_setting( 'social_bg', array(
		'default'        => '#444444',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'social_bg', array(
		'label'   => esc_html__( 'Social Icon Background', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'social_bg',
		'priority' => 30,			
	) ) );	
// Social icon
 	$wp_customize->add_setting( 'social_icon', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'social_icon', array(
		'label'   => esc_html__( 'Social Icon Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'social_icon',
		'priority' => 31,			
	) ) );

// Social bg hover
 	$wp_customize->add_setting( 'social_hbg', array(
		'default'        => '#dcc593',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'social_hbg', array(
		'label'   => esc_html__( 'Social Icon Hover Background', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'social_hbg',
		'priority' => 32,			
	) ) );	
// Social icon hover
 	$wp_customize->add_setting( 'social_hicon', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'social_hicon', array(
		'label'   => esc_html__( 'Social Icon Hover Colour', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'social_hicon',
		'priority' => 33,			
	) ) );

// Back to Top background
 	$wp_customize->add_setting( 'backtop_bg', array(
		'default'        => '#000000',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'backtop_bg', array(
		'label'   => esc_html__( 'Back to Top Button Background', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'backtop_bg',
		'priority' => 34,			
	) ) );
// Back to Top background hover
 	$wp_customize->add_setting( 'backtop_hbg', array(
		'default'        => '#565656',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'backtop_hbg', array(
		'label'   => esc_html__( 'Back to Top Button Hover Background', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'backtop_hbg',
		'priority' => 35,			
	) ) );
// Back to Top text
 	$wp_customize->add_setting( 'backtop_text', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'backtop_text', array(
		'label'   => esc_html__( 'Back to Top Button Text', 'opportune' ),
		'section' => 'colors',
		'settings'   => 'backtop_text',
		'priority' => 36,			
	) ) );	
	
/*
 * Create a section
 * Name: Error Page
 */  
	$wp_customize->add_section( 'error_page',	array(
		'title' => esc_html__( 'Error Page', 'opportune' ),
		'priority' => 41,
	)  );	
	

// Setting group for the error page 
  $wp_customize->add_setting( 'error_message',	array(
 		'default'        => esc_html__( 'I know...you are upset the page you were going to is apparently missing.', 'opportune' ),
		'sanitize_callback' => 'opportune_sanitize_text',
	) );  
  $wp_customize->add_control( 'error_message', array(
		'type'     => 'text',
		'priority' => 1,
		'label'    => esc_html__( 'Error Message', 'opportune' ),
		'section'  => 'error_page',
  	) );
// Setting group for the error page  title
  $wp_customize->add_setting( 'error_title',	array(
 		'default'        => esc_html__( '404', 'opportune' ),
		'sanitize_callback' => 'opportune_sanitize_text',
	) );  
  $wp_customize->add_control( 'error_title', array(
		'type'     => 'text',
		'priority' => 2,
		'label'    => esc_html__( 'Error Title', 'opportune' ),
		'section'  => 'error_page',
  	) );	
// Setting group for the error page  button
  $wp_customize->add_setting( 'error_button',	array(
 		'default'        => esc_html__( 'Back to Home', 'opportune' ),
		'sanitize_callback' => 'opportune_sanitize_text',
	) );  
  $wp_customize->add_control( 'error_button', array(
		'type'     => 'text',
		'priority' => 3,
		'label'    => esc_html__( 'Error Button Label', 'opportune' ),
		'section'  => 'error_page',
  	) );
	
// Setting group for the error page button background
 	$wp_customize->add_setting( 'error_button_bg', array(
		'default'        => '#a4bbba',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'error_button_bg', array(
		'label'   => esc_html__( 'Error Button Background', 'opportune' ),
		'section' => 'error_page',
		'settings'   => 'error_button_bg',
		'priority' => 4,			
	) ) );	
// Setting group for the error page button text
 	$wp_customize->add_setting( 'error_button_text_colour', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'opportune_sanitize_hex_colour',
	) );	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'error_button_text_colour', array(
		'label'   => esc_html__( 'Error Button Label Colour', 'opportune' ),
		'section' => 'error_page',
		'settings'   => 'error_button_text_colour',
		'priority' => 5,			
	) ) );		
// Setting group for the error page image	
   $wp_customize->add_setting( 'error_image', array(
            'default' => get_template_directory_uri() . '/images/error404.png',
            'sanitize_callback' => 'esc_url_raw',
     ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'error_image', array(
               'label'          => esc_html__( 'Upload your own Error Image', 'opportune' ),
			   'description' => esc_html__( 'I recommend an image height of 332px', 'opportune' ),
               'type'           => 'image',
               'section'        => 'error_page',
               'settings'       => 'error_image',
               'priority'       => 6,
     ) ) );	
		

	
}
add_action( 'customize_register', 'opportune_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function opportune_customize_preview_js() {
	wp_enqueue_script( 'opportune_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'opportune_customize_preview_js' );



/**
 * This is our theme sanitization settings.
 * Remember to sanitize any additional theme settings you add to the customizer.
 */

// adds sanitization callback function for the header style : radio
	function opportune_sanitize_header_style( $input ) {
		$valid = array(
			  'default' => esc_html__( 'Logo to the Left and Menu Right', 'opportune' ),
			  'centered' => esc_html__( 'Centered Logo and Menu Below', 'opportune' ),		
		);
	 
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	} 

// adds sanitization callback function for the boxed style : radio
	function opportune_sanitize_boxed_style( $input ) {
		$valid = array(
			  'fullwidth' => esc_html__( 'Full Width', 'opportune' ),
			  'boxed1920' => esc_html__( 'Boxed 1920px Width', 'opportune' ),
			  'boxed1600' => esc_html__( 'Boxed 1600px Width', 'opportune' ),
			  'boxed1400' => esc_html__( 'Boxed 1400px Width', 'opportune' ),
		);

		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}


// adds sanitization callback function for the blog style : radio
	function opportune_sanitize_blog_style( $input ) {
		$valid = array(
			  	'left-featured' => esc_html__( 'Left Featured Image', 'opportune' ),	
				'top-featured' => esc_html__( 'Top Featured Image', 'opportune' ),	  
				'top-featured-center' => esc_html__( 'Top Featured Image Centered', 'opportune' ),
				'top-featured-left' => esc_html__( 'Top Featured Image Left Sidebar', 'opportune' ),
				'top-featured-right' => esc_html__( 'Top Featured Image Right Sidebar', 'opportune' ),
		);

		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}

// adds sanitization callback function for the single layout : radio
	function opportune_sanitize_single_layout( $input ) {
		$valid = array(
			  'right-column' => esc_html__( 'Right Column Layout', 'opportune' ),
			  'left-column' => esc_html__( 'Left Column Layout', 'opportune' ),
			  'full-width' => esc_html__( 'Full Width', 'opportune' ),
		);

		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}
	
// adds sanitization callback function for the featured image : radio
	function opportune_sanitize_featured_image( $input ) {
		$valid = array(
			  'left' => esc_html__( 'Left Position', 'opportune' ),
			  'top' => esc_html__( 'Top', 'opportune' ),
			  'centered' => esc_html__( 'Top Centered', 'opportune' ),
		);

		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}	
	
	
	
// adds sanitization callback function for the excerpt : radio
	function opportune_sanitize_excerpt( $input ) {
		$valid = array(
			'content' => esc_html__( 'Content', 'opportune' ),
			'excerpt' => esc_html__( 'Excerpt', 'opportune' ),
		);
	 
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}		
	
	
// adds sanitization callback function for the single style : radio
	function opportune_sanitize_single_style( $input ) {
		$valid = array(
			  'single-right' => esc_html__( 'Single with Right Sidebar', 'opportune' ),
			  'single-left' => esc_html__( 'Single with Left Sidebar', 'opportune' ),
			  'single' => esc_html__( 'Single without Left &amp; Right Sidebar', 'opportune' ),
		);
	 
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}	

// adds sanitization callback function : textarea
if ( ! function_exists( 'opportune_sanitize_textarea' ) ) :
  function opportune_sanitize_textarea( $value ) {
    if ( !current_user_can('unfiltered_html') )
			$value  = stripslashes( wp_filter_post_kses( addslashes( $value ) ) ); // wp_filter_post_kses() expects slashed

    return $value;
  }
endif;

// adds sanitization callback function for numeric data : number
if ( ! function_exists( 'opportune_sanitize_number' ) ) :
	function opportune_sanitize_number( $value ) {
		$value = (int) $value; // Force the value into integer type.
		return ( 0 < $value ) ? $value : null;
	}
endif;

// adds sanitization callback function : colors
if ( ! function_exists( 'opportune_sanitize_hex_colour' ) ) :
	function opportune_sanitize_hex_colour( $color ) {
		if ( $unhashed = sanitize_hex_color_no_hash( $color ) )
			return '#' . $unhashed;
	
		return $color;
	}
endif;

// adds sanitization callback function : text 
if ( ! function_exists( 'opportune_sanitize_text' ) ) :
	function opportune_sanitize_text( $input ) {
		return wp_kses_post( force_balance_tags( $input ) );
	}
endif;

// adds sanitization callback function : url
if ( ! function_exists( 'opportune_sanitize_url' ) ) :
	function opportune_sanitize_url( $value) {
		$value = esc_url( $value);
		return $value;
	}
endif;

// adds sanitization callback function : checkbox
if ( ! function_exists( 'opportune_sanitize_checkbox' ) ) :
	function opportune_sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		} else {
			return '';
		}
	}	 
endif;

// adds sanitization callback function : absolute integer
if ( ! function_exists( 'opportune_sanitize_integer' ) ) :
function opportune_sanitize_integer( $input ) {
	return absint( $input );
}
endif;


// adds sanitization callback function for uploading : uploader
if ( ! function_exists( 'opportune_sanitize_upload' ) ) :
	add_filter( 'opportune_sanitize_image', 'opportune_sanitize_upload' );
	add_filter( 'opportune_sanitize_file', 'opportune_sanitize_upload' );

	function opportune_sanitize_upload( $input ) {        
			$output = '';        
			$filetype = wp_check_filetype($input);       
			if ( $filetype["ext"] ) {        
					$output = $input;        
			}       
			return $output;
	}
endif;


?>