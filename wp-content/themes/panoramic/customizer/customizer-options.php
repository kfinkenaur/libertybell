<?php
/**
 * Defines customizer options
 *
 * @package Customizer Library Demo
 */

function panoramic_customizer_library_options() {
	// Theme defaults
	$page_content_background_color = '#FFFFFF';
	$top_bar_color = '#FFFFFF';
	$header_color = '#FFFFFF';
	$primary_color = '#006489';
	$secondary_color = '#3F84A4';
	$mobile_menu_button_color = '#FFFFFF';
	$slider_text_overlay_background_color = '#FFFFFF';
	$zebra_stripe_even_color = '#E6E6E6';
	$header_image_text_overlay_background_color = '#FFFFFF';
	$footer_color = '#EAF1F7';
    
    $body_font_color = '#58585A';
    $heading_font_color = '#006489';

	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Adds the sections to the $options array
	$options['sections'] = $sections;
	
	$dividerCount = 0;
	
	// Site Identity
	$section = 'title_tagline';
	
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Site Identity', 'panoramic' ),
		'priority' => '25'
	);
	
	if ( ! function_exists( 'has_custom_logo' ) ) {
		$options['panoramic-logo'] = array(
			'id' => 'panoramic-logo',
			'label'   => __( 'Logo', 'panoramic' ),
			'section' => $section,
			'type'    => 'image'
		);
	}
	
    $options['panoramic-full-width-logo'] = array(
    	'id' => 'panoramic-full-width-logo',
    	'label'   => __( 'Expand the logo to fill the header', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    	'priority' => 9
    );
	
    $options['panoramic-logo-with-site-title'] = array(
    	'id' => 'panoramic-logo-with-site-title',
    	'label'   => __( 'Display the site title and tagline with the logo', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    	'priority' => 10
    );
    
    $choices = array(
        'panoramic-logo-with-site-title-right' => 'Next to the logo',
    	'panoramic-logo-with-site-title-below' => 'Below the logo'
    );
    $options['panoramic-logo-with-site-title-position'] = array(
        'id' => 'panoramic-logo-with-site-title-position',
        'label'   => __( 'Title and Tagline Position', 'panoramic' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'panoramic-logo-with-site-title-right',
    	'priority' => 20
    );
    
    $options['panoramic-logo-link-content'] = array(
    	'id' => 'panoramic-logo-link-content',
    	'label'   => __( 'Content to link your logo / site title to', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'dropdown-logo-pages-posts',
    	'description' => __( 'Select the page or post you would like your logo / site title to link to.', 'panoramic' ),
    	'priority' => 30
    );    
    
    $options['site_branding_padding_top'] = array(
    	'id' => 'site_branding_padding_top',
    	'label'   => __( 'Padding Top', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'pixels',
    	'default' => 27,
    	'priority' => 30
    );

    $options['site_branding_padding_bottom'] = array(
    	'id' => 'site_branding_padding_bottom',
    	'label'   => __( 'Padding Bottom', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'pixels',
    	'default' => 23,
    	'priority' => 30
    );
    
    
    // Layout Settings
    $section = 'panoramic-layout';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Layout', 'panoramic' ),
        'priority' => '30'
    );
    
    $choices = array(
        'panoramic-layout-site-full-width' => 'Full Width',
        'panoramic-layout-site-boxed' => 'Boxed'
    );
    $options['panoramic-layout-site'] = array(
        'id' => 'panoramic-layout-site',
        'label'   => __( 'Bound', 'panoramic' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'panoramic-layout-site-full-width'
    );
    
    $choices = array(
    	'panoramic-layout-mode-multi-page' => 'Multi-Page',
    	'panoramic-layout-mode-one-page' => 'One Page'
    );
    $options['panoramic-layout-mode'] = array(
    	'id' => 'panoramic-layout-mode',
    	'label'   => __( 'Mode', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'panoramic-layout-mode-multi-page'
    );
    
    $options['panoramic-layout-pages'] = array(
    	'id' => 'panoramic-layout-pages',
    	'label'   => __( 'Pages', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'dropdown-pages-multi',
    	'description' => __( 'Select the pages that you want to display on the front page. They will display in the same order as the navigation menu. If you choose to display any pages that are not in the navigation they will be displayed last. Hold down the Ctrl (windows) / Command (Mac) button to select multiple categories.', 'panoramic' )
    );
    
    $options['panoramic-layout-zebra-stripe'] = array(
    	'id' => 'panoramic-layout-zebra-stripe',
    	'label'   => __( 'Zebra stripe', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    );
    
    $options['panoramic-layout-zebra-stripe-even-color'] = array(
    	'id' => 'panoramic-layout-zebra-stripe-even-color',
    	'label'   => __( 'Zebra stripe even color', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $zebra_stripe_even_color
    );
    
    $options['panoramic-layout-highlight-first-menu-item'] = array(
    	'id' => 'panoramic-layout-highlight-first-menu-item',
    	'label'   => __( 'Highlight the first menu item by default', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );
    
    $options['panoramic-layout-display-page-titles'] = array(
    	'id' => 'panoramic-layout-display-page-titles',
    	'label'   => __( 'Display page titles', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );

    /*
    $options['panoramic-layout-display-homepage-page-title'] = array(
    	'id' => 'panoramic-layout-display-homepage-page-title',
    	'label'   => __( 'Display the page title on the homepage', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0
    );
    */
    
    $options['panoramic-layout-first-page-title'] = array(
    	'id' => 'panoramic-layout-first-page-title',
    	'label'   => __( 'Display the title of the first page', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );

    $options['panoramic-layout-divider'] = array(
    	'id' => 'panoramic-layout-divider',
    	'label'   => __( 'Show a dividing line between pages', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );
    
    $options['panoramic-layout-featured-image-page-headers'] = array(
    	'id' => 'panoramic-layout-featured-image-page-headers',
    	'label'   => __( 'Display Featured Images as header images on pages', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );
    
    $options['panoramic-layout-back-to-top'] = array(
    	'id' => 'panoramic-layout-back-to-top',
    	'label'   => __( 'Show the back to top button', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );
    
    
    // Styling Settings
    /*
    $section = 'panoramic-styling';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Styling', 'panoramic' ),
        'priority' => '30'
    );

    $options['panoramic-styling-rounded-corners'] = array(
    	'id' => 'panoramic-styling-rounded-corners',
    	'label'   => __( 'Rounded corners', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    );
    */
    
    
    // Header Settings
    $section = 'panoramic-header';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Header', 'panoramic' ),
    	'priority' => '35'
    );
    $choices = array(
    	'panoramic-header-layout-standard' => 'Standard',
    	'panoramic-header-layout-centered' => 'Centered'
    );
    $options['panoramic-header-layout'] = array(
    	'id' => 'panoramic-header-layout',
    	'label'   => __( 'Layout', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'panoramic-header-layout-standard'
    );

    $choices = array(
    	'panoramic-header-bound-boxed' => 'Boxed',
    	'panoramic-header-bound-full-width' => 'Full Width'
    );
    $options['panoramic-header-bound'] = array(
    	'id' => 'panoramic-header-bound',
    	'label'   => __( 'Bound', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'panoramic-header-bound-boxed'
    );
    
    $choices = array(
    	'panoramic-header-top-bar-left-info-text' => 'Info Text',
    	'panoramic-header-top-bar-left-social-links' => 'Social Links',
    	'panoramic-header-top-bar-left-shop-links' => 'Shop Links',
    	'panoramic-header-top-bar-left-menu' => 'Custom Menu',
    	'panoramic-header-top-bar-left-nothing' => 'Nothing'
    );
    $options['panoramic-header-top-bar-left'] = array(
    	'id' => 'panoramic-header-top-bar-left',
    	'label'   => __( 'Top Bar Left', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'panoramic-header-top-bar-left-info-text'
    );
    
    $options['panoramic-header-top-bar-left-menu'] = array(
    	'id' => 'panoramic-header-top-bar-left-menu',
    	'label'   => __( 'Select the Top Bar Left menu', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'dropdown-menus',
    	'description' => __( 'Create menus at Appearance > Menus', 'panoramic' )
    );

    $choices = array(
    	'panoramic-header-top-bar-right-info-text' => 'Info Text',
    	'panoramic-header-top-bar-right-social-links' => 'Social Links',
    	'panoramic-header-top-bar-right-shop-links' => 'Shop Links',
    	'panoramic-header-top-bar-right-menu' => 'Custom Menu',
    	'panoramic-header-top-bar-right-nothing' => 'Nothing'
    );
    $options['panoramic-header-top-bar-right'] = array(
    	'id' => 'panoramic-header-top-bar-right',
    	'label'   => __( 'Top Bar Right', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices
    );
    
	// Check for the panoramic-header-shop-links setting to honour the free and previous versions of the theme 
    if ( panoramic_is_woocommerce_activated() && !get_theme_mod( 'panoramic-header-top-bar-right' ) && get_theme_mod( 'panoramic-header-shop-links', true ) ) {
    	$options['panoramic-header-top-bar-right']['default'] = 'panoramic-header-top-bar-right-shop-links';
    } else {
    	$options['panoramic-header-top-bar-right']['default'] = 'panoramic-header-top-bar-right-social-links';
    }
    
    $options['panoramic-header-top-bar-right-menu'] = array(
    	'id' => 'panoramic-header-top-bar-right-menu',
    	'label'   => __( 'Select the Top Bar Right menu', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'dropdown-menus',
    	'description' => __( 'Create menus at Appearance > Menus', 'panoramic' )
    );
    
    $choices = array(
    	'panoramic-header-top-right-info-text' => 'Info Text',
    	'panoramic-header-top-right-social-links' => 'Social Links',
    	'panoramic-header-top-right-shop-links' => 'Shop Links',
    	'panoramic-header-top-right-menu' => 'Custom Menu',
    	'panoramic-header-top-right-nothing' => 'Nothing'
    );
    $options['panoramic-header-top-right'] = array(
    	'id' => 'panoramic-header-top-right',
    	'label'   => __( 'Top Right', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    );
    
    // Check for the panoramic-header-shop-links setting to honour the free and previous versions of the theme
    if ( panoramic_is_woocommerce_activated() && !get_theme_mod( 'panoramic-header-top-right' ) && get_theme_mod( 'panoramic-header-shop-links', true ) ) {
    	$options['panoramic-header-top-right']['default'] = 'panoramic-header-top-right-shop-links';
    } else {
    	$options['panoramic-header-top-right']['default'] = 'panoramic-header-top-right-info-text';
    }
    
    $options['panoramic-header-top-right-menu'] = array(
    	'id' => 'panoramic-header-top-right-menu',
    	'label'   => __( 'Select the Top Right menu', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'dropdown-menus',
    	'description' => __( 'Create menus at Appearance > Menus', 'panoramic' )
    );

    $choices = array(
    	'panoramic-header-bottom-right-info-text' => 'Info Text',
    	'panoramic-header-bottom-right-social-links' => 'Social Links',
    	'panoramic-header-bottom-right-shop-links' => 'Shop Links',
    	'panoramic-header-bottom-right-menu' => 'Custom Menu',
    	'panoramic-header-bottom-right-nothing' => 'Nothing'
    );
    $options['panoramic-header-bottom-right'] = array(
    	'id' => 'panoramic-header-bottom-right',
    	'label'   => __( 'Bottom Right', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    );
    
    // Check for the panoramic-header-shop-links setting to honour the free and previous versions of the theme
    if ( panoramic_is_woocommerce_activated() && !get_theme_mod( 'panoramic-header-bottom-right' ) && get_theme_mod( 'panoramic-header-shop-links', true ) ) {
    	$options['panoramic-header-bottom-right']['default'] = 'panoramic-header-bottom-right-nothing';
    } else {
    	$options['panoramic-header-bottom-right']['default'] = 'panoramic-header-bottom-right-social-links';
    }
    
    $options['panoramic-header-bottom-right-menu'] = array(
    	'id' => 'panoramic-header-bottom-right-menu',
    	'label'   => __( 'Select the Bottom Right menu', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'dropdown-menus',
    	'description' => __( 'Create menus at Appearance > Menus', 'panoramic' )
    );
    
    $options['panoramic-header-sticky'] = array(
    	'id' => 'panoramic-header-sticky',
    	'label'   => __( 'Sticky', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0
    );

    $options['panoramic-header-deactivate-sticky-on-mobile'] = array(
    	'id' => 'panoramic-header-deactivate-sticky-on-mobile',
    	'label'   => __( 'Disable the sticky header on mobile devices', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0
    );

    $options['panoramic-header-sticky-has-min-width'] = array(
    	'id' => 'panoramic-header-sticky-has-min-width',
    	'label'   => __( 'Set a deactivation width for the sticky header', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
    
    $options['panoramic-header-sticky-deactivation-breakpoint'] = array(
    	'id' => 'panoramic-header-sticky-deactivation-breakpoint',
    	'label'   => __( 'Deactivation Width', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'pixels',
    	'default' => 800,
    	'description' => __( 'The screen width in pixels at which the header will stop being sticky', 'panoramic' )
    );
    
    /*
    $options['panoramic-header-scale-logo'] = array(
    	'id' => 'panoramic-header-scale-logo',
    	'label'   => __( 'Sticky scales logo', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0
    );
    */
    
    $options['panoramic-show-header-top-bar'] = array(
    	'id' => 'panoramic-show-header-top-bar',
    	'label'   => __( 'Show Top Bar', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
    $options['panoramic-header-info-text'] = array(
    	'id' => 'panoramic-header-info-text',
    	'label'   => __( 'Info Text', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
    	'default' => __( '<strong><em>CALL US:</em></strong> 555-PANORAMIC', 'panoramic' )
    );
    $options['panoramic-header-search'] = array(
    	'id' => 'panoramic-header-search',
    	'label'   => __( 'Show Search', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
    
    /*
    $options['panoramic-header-height'] = array(
    	'id' => 'panoramic-header-height',
    	'label'   => __( 'Height', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
    	'default' => 108
    );
    */
    
    // Navigation Menu Settings
    $section = 'panoramic-navigation-menu';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Navigation Menu', 'panoramic' ),
    	'priority' => '35'
    );

    $options['panoramic-layout-navigation-opacity'] = array(
    	'id' => 'panoramic-layout-navigation-opacity',
    	'label'   => __( 'Opacity', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'range',
    	'default' => 0.7,
    	'input_attrs' => array(
    		'min'   => 0,
    		'max'   => 1,
    		'step'  => 0.1,
    		'style' => 'color: #000000',
    	)
    );

	$options['panoramic-animated-submenus'] = array(
    	'id' => 'panoramic-animated-submenus',
    	'label'   => __( 'Animated submenus', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0
	);

    // Social Settings
    $section = 'panoramic-social';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Social Media Links', 'panoramic' ),
    	'priority' => '35'
    );
    
    $choices = array(
    	'panoramic-social-pronoun-individual' => 'Individual',
    	'panoramic-social-pronoun-group' => 'Group'
    );
    $options['panoramic-social-pronoun'] = array(
    	'id' => 'panoramic-social-pronoun',
    	'label'   => __( 'Are you an individual or a group?', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'panoramic-social-pronoun-group'
    );
    
    $options['panoramic-social-email'] = array(
    	'id' => 'panoramic-social-email',
    	'label'   => __( 'Email Address', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-skype'] = array(
    	'id' => 'panoramic-social-skype',
    	'label'   => __( 'Skype Name', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-facebook'] = array(
    	'id' => 'panoramic-social-facebook',
    	'label'   => __( 'Facebook', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-twitter'] = array(
    	'id' => 'panoramic-social-twitter',
    	'label'   => __( 'Twitter', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-google-plus'] = array(
    	'id' => 'panoramic-social-google-plus',
    	'label'   => __( 'Google Plus', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-youtube'] = array(
    	'id' => 'panoramic-social-youtube',
    	'label'   => __( 'YouTube', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-instagram'] = array(
    	'id' => 'panoramic-social-instagram',
    	'label'   => __( 'Instagram', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-pinterest'] = array(
    	'id' => 'panoramic-social-pinterest',
    	'label'   => __( 'Pinterest', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-linkedin'] = array(
    	'id' => 'panoramic-social-linkedin',
    	'label'   => __( 'LinkedIn', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-tumblr'] = array(
    	'id' => 'panoramic-social-tumblr',
    	'label'   => __( 'Tumblr', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-flickr'] = array(
    	'id' => 'panoramic-social-flickr',
    	'label'   => __( 'Flickr', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-yelp'] = array(
    	'id' => 'panoramic-social-yelp',
    	'label'   => __( 'Yelp', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-vimeo'] = array(
    	'id' => 'panoramic-social-vimeo',
    	'label'   => __( 'Vimeo', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-etsy'] = array(
    	'id' => 'panoramic-social-etsy',
    	'label'   => __( 'Etsy', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-tripadvisor'] = array(
    	'id' => 'panoramic-social-tripadvisor',
    	'label'   => __( 'TripAdvisor', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-yahoo-groups'] = array(
    	'id' => 'panoramic-social-yahoo-groups',
    	'label'   => __( 'Yahoo! Groups', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-snapchat'] = array(
    	'id' => 'panoramic-social-snapchat',
    	'label'   => __( 'Snapchat', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-behance'] = array(
    	'id' => 'panoramic-social-behance',
    	'label'   => __( 'Behance', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-soundcloud'] = array(
    	'id' => 'panoramic-social-soundcloud',
    	'label'   => __( 'SoundCloud', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-xing'] = array(
    	'id' => 'panoramic-social-xing',
    	'label'   => __( 'Xing', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text'
    );
    $options['panoramic-social-custom-icon-code'] = array(
    	'id' => 'panoramic-social-custom-icon-code',
    	'label'   => __( 'Custom Icon Font Awesome Code', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
    	'description' => __( 'Insert the code of the Font Awesome icon you wish to display eg. fa-suitcase. 
    						You can view all available icons <a href="http://fontawesome.io/cheatsheet/" target="_blank">here</a>.', 'panoramic' )
    );
    $options['panoramic-social-custom-icon-url'] = array(
    	'id' => 'panoramic-social-custom-icon-url',
    	'label'   => __( 'Custom Icon URL', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
    	'description' => __( 'Insert the URL that you would like your custom icon to link to.', 'panoramic' )
    );
    $options['panoramic-social-custom-icon-hover-text'] = array(
    	'id' => 'panoramic-social-custom-icon-hover-text',
    	'label'   => __( 'Custom Icon Hover Text', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
    	'description' => __( 'Insert the text that you would like to appear on mouseover of your custom icon.', 'panoramic' )
    );
    
    
    // Search Settings
    $section = 'panoramic-search';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Search', 'panoramic' ),
    	'priority' => '35'
    );
    
    /*
    $options['panoramic-search-post-types'] = array(
    	'id' => 'panoramic-search-post-types',
    	'label'   => __( 'Post Types', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'dropdown-post-types-multi',
    	'description' => __( 'Select the post types that you want to include in the search results.', 'panoramic' ),
    	'default' => array('post', 'page')
    );
    */
    
	$options['panoramic-search-results-header-image'] = array(
		'id' => 'panoramic-search-results-header-image',
		'label'   => __( 'Header Image', 'panoramic' ),
		'section' => $section,
		'type'    => 'image'
	);
	
    $options['panoramic-search-results-header-image-text'] = array(
    	'id' => 'panoramic-search-results-header-image-text',
    	'label'   => __( 'Header ImageText', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'textarea',
    	'description' => esc_html( __( 'Use <h2></h2> tags around heading text and <p></p> tags around body text.', 'panoramic' ) )
    );

    $options['panoramic-search-results-full-width'] = array(
    	'id' => 'panoramic-search-results-full-width',
    	'label'   => __( 'Full width search results page', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0
    );
    
    $options['panoramic-search-placeholder-text'] = array(
    	'id' => 'panoramic-search-placeholder-text',
    	'label'   => __( 'Default Search Field Text', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
    	'default' => __( 'Search...', 'panoramic' )
    );
    
    $options['panoramic-website-text-no-search-results-heading'] = array(
    	'id' => 'panoramic-website-text-no-search-results-heading',
    	'label'   => __( 'No Search Results Heading', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
		'default' => __( 'Nothing Found!', 'panoramic' )
    );
    $options['panoramic-website-text-no-search-results-text'] = array(
        'id' => 'panoramic-website-text-no-search-results-text',
        'label'   => __( 'No Search Results Message', 'panoramic' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'panoramic' )
    );
    
    
    // Mobile Settings
    $section = 'panoramic-mobile';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Mobile', 'panoramic' ),
    	'priority' => '35'
    );
    
	$options['panoramic-mobile-logo'] = array(
		'id' => 'panoramic-mobile-logo',
		'label'   => __( 'Mobile Logo', 'panoramic' ),
		'section' => $section,
		'type'    => 'image'
	);
    
    $options['panoramic-mobile-logo-with-site-title'] = array(
    	'id' => 'panoramic-mobile-logo-with-site-title',
    	'label'   => __( 'Display the site title and tagline with the mobile logo', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    );
	
    $options['panoramic-full-width-mobile-logo'] = array(
    	'id' => 'panoramic-full-width-mobile-logo',
    	'label'   => __( 'Expand the mobile logo to fill the header', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    );
    
    $options['panoramic-mobile-logo-breakpoint'] = array(
    	'id' => 'panoramic-mobile-logo-breakpoint',
    	'label'   => __( 'Mobile Logo Activation Width', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'pixels',
    	'default' => 600,
    	'description' => __( 'The screen width in pixels at which the mobile logo will appear', 'panoramic' )
    );
    
    $options['panoramic-mobile-menu'] = array(
    	'id' => 'panoramic-mobile-menu',
    	'label'   => __( 'Enable the mobile menu', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );

    $options['panoramic-mobile-menu-activate-on-mobile'] = array(
    	'id' => 'panoramic-mobile-menu-activate-on-mobile',
    	'label'   => __( 'Activate the mobile menu on all mobile devices regardless of width', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    );
    
    $options['panoramic-mobile-menu-breakpoint'] = array(
    	'id' => 'panoramic-mobile-menu-breakpoint',
    	'label'   => __( 'Mobile Menu Activation Width', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'pixels',
    	'default' => 960,
    	'description' => __( 'The screen width in pixels at which the menu will go into mobile mode', 'panoramic' )
    );
    
	$options['panoramic-mobile-menu-button-color'] = array(
		'id' => 'panoramic-mobile-menu-button-color',
		'label'   => __( 'Mobile Menu Button Color', 'panoramic' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $mobile_menu_button_color
	);
    
    $choices = array(
    	'panoramic-mobile-menu-standard-color-scheme' => 'Standard',
    	'panoramic-mobile-menu-dark-color-scheme' => 'Dark'
    );
    $options['panoramic-mobile-menu-color-scheme'] = array(
    	'id' => 'panoramic-mobile-menu-color-scheme',
    	'label'   => __( 'Mobile Menu Color Scheme', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'panoramic-mobile-menu-standard-color-scheme'
    );
    
	$options['panoramic-mobile-video-header'] = array(
		'id' => 'panoramic-mobile-video-header',
		'label'   => __( 'Show the header video on mobile', 'panoramic' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);
    
    $options['panoramic-mobile-back-to-top'] = array(
    	'id' => 'panoramic-mobile-back-to-top',
    	'label'   => __( 'Show the back to top button on mobile', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );

    $options['panoramic-mobile-fitvids'] = array(
    	'id' => 'panoramic-mobile-fitvids',
    	'label'   => __( 'Enable FitVids', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    	'description' => __( 'Include FitVids.js for fluid width video embeds', 'panoramic' )
    );
    
    
    // Slider Settings
    $section = 'panoramic-slider';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Slider', 'panoramic' ),
        'priority' => '35'
    );
    
    $choices = array(
        'panoramic-slider-default' => 'Default Slider',
        'panoramic-slider-plugin' => 'Slider Plugin',
        'panoramic-no-slider' => 'None'
    );
    $options['panoramic-slider-type'] = array(
        'id' => 'panoramic-slider-type',
        'label'   => __( 'Slider', 'panoramic' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices
    );

	// Check for the otb_panoramic_dot_org setting to honour the free version of the theme 
    if ( get_theme_mod( 'otb_panoramic_dot_org' ) ) {
    	$options['panoramic-slider-type']['default'] = 'panoramic-no-slider';
    } else {
    	$options['panoramic-slider-type']['default'] = 'panoramic-slider-default';
    }
    
    $options['panoramic-slider-categories'] = array(
    	'id' => 'panoramic-slider-categories',
    	'label'   => __( 'Post Categories', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'dropdown-categories',
    	'description' => __( 'Select the categories of the posts you want to display in the slider. The featured image will be the slide image and the post content will display over it. Hold down the Ctrl (windows) / Command (Mac) button to select multiple categories.', 'panoramic' )
    );
    
    $options['panoramic-smart-slider'] = array(
    	'id' => 'panoramic-smart-slider',
    	'label'   => __( 'Smart mode (increased responsiveness)', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
    
    $options['panoramic-slider-all-pages'] = array(
    	'id' => 'panoramic-slider-all-pages',
    	'label'   => __( 'Display the slider on all pages', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    );
    $options['panoramic-slider-blog-posts'] = array(
    	'id' => 'panoramic-slider-blog-posts',
    	'label'   => __( 'Display the slider on the blog posts', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    );
    
    $options['panoramic-slider-display-directional-buttons'] = array(
    	'id' => 'panoramic-slider-display-directional-buttons',
    	'label'   => __( 'Display prev / next buttons', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );

    $options['panoramic-slider-display-pagination'] = array(
    	'id' => 'panoramic-slider-display-pagination',
    	'label'   => __( 'Display pagination', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
	
    $choices = array(
    	'panoramic-slider-button-style-square' => 'Square',
    	'panoramic-slider-button-style-round' => 'Round',
    );
    $options['panoramic-slider-button-style'] = array(
    	'id' => 'panoramic-slider-button-style',
    	'label'   => __( 'Button Style', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'panoramic-slider-button-style-square'
    );

    $options['panoramic-slider-text-overlay-background-color'] = array(
    	'id' => 'panoramic-slider-text-overlay-background-color',
    	'label'   => __( 'Text Overlay and Button Rollover Color', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $slider_text_overlay_background_color
    );
    
    $options['panoramic-slider-text-overlay-opacity'] = array(
    	'id' => 'panoramic-slider-text-overlay-opacity',
    	'label'   => __( 'Text Overlay Opacity', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'range',
    	'default' => 0.6,
    	'input_attrs' => array(
    		'min'   => 0,
    		'max'   => 1,
    		'step'  => 0.1,
    		'style' => 'color: #000000'
   		)
    );
    
	$options["panoramic-fieldset-divider-slider-.{$dividerCount}"] = array(
		'id' => "panoramic-fieldset-divider-slider-.{$dividerCount}",
		'section' => $section,
		'type'    => 'divider',
		'class'	  => 'default-slider'
	);
    $dividerCount++;
    
    /*
	$options['panoramic-slider-spacing-heading'] = array(
		'id' => 'panoramic-slider-spacing-heading',
		'label'   => __( 'Spacing', 'panoramic' ),
		'section' => $section,
		'type'    => 'heading'
	);
    
    $choices = array(
        '1.0' => '1.0',
        '1.1' => '1.1',
        '1.2' => '1.2',
        '1.3' => '1.3',
        '1.4' => '1.4',
        '1.5' => '1.5',
        '1.6' => '1.6',
        '1.7' => '1.7',
        '1.8' => '1.8',
        '1.9' => '1.9',
        '2.0' => '2.0'
    );
    $options['panoramic-slider-heading-line-height'] = array(
        'id' => 'panoramic-slider-heading-line-height',
        'label'   => __( 'Heading Line Height', 'panoramic' ),
        'section' => $section,
        'type'    => 'dropdown-em',
        'choices' => $choices,
    	'default' => '1.0'
    );

    $choices = array(
        '1.0' => '1.0',
        '1.1' => '1.1',
        '1.2' => '1.2',
        '1.3' => '1.3',
        '1.4' => '1.4',
        '1.5' => '1.5',
        '1.6' => '1.6',
        '1.7' => '1.7',
        '1.8' => '1.8',
        '1.9' => '1.9',
        '2.0' => '2.0'
    );
    $options['panoramic-slider-paragraph-line-height'] = array(
        'id' => 'panoramic-slider-paragraph-line-height',
        'label'   => __( 'Paragraph Line Height', 'panoramic' ),
        'section' => $section,
        'type'    => 'dropdown-em',
        'choices' => $choices,
    	'default' => '1.0'
    );
    
    $choices = array(
        '0' => '0',
        '0.1' => '0.1',
        '0.2' => '0.2',
        '0.3' => '0.3',
        '0.4' => '0.4',
        '0.5' => '0.5',
        '0.6' => '0.6',
        '0.7' => '0.7',
        '0.8' => '0.8',
        '0.9' => '0.9',
        '1.0' => '1.0',
        '1.1' => '1.1',
        '1.2' => '1.2',
        '1.3' => '1.3',
        '1.4' => '1.4',
        '1.5' => '1.5',
        '1.6' => '1.6',
        '1.7' => '1.7',
        '1.8' => '1.8',
        '1.9' => '1.9',
        '2.0' => '2.0'
    );
    $options['panoramic-slider-paragraph-margin'] = array(
        'id' => 'panoramic-slider-paragraph-margin',
        'label'   => __( 'Paragraph Top and Bottom Margin', 'panoramic' ),
        'section' => $section,
        'type'    => 'dropdown-em',
        'choices' => $choices,
    	'default' => '0.5'
    );
    
    $choices = array(
        '0' => '0',
        '0.1' => '0.1',
        '0.2' => '0.2',
        '0.3' => '0.3',
        '0.4' => '0.4',
        '0.5' => '0.5',
        '0.6' => '0.6',
        '0.7' => '0.7',
        '0.8' => '0.8',
        '0.9' => '0.9',
        '1.0' => '1.0',
        '1.1' => '1.1',
        '1.2' => '1.2',
        '1.3' => '1.3',
        '1.4' => '1.4',
        '1.5' => '1.5',
        '1.6' => '1.6',
        '1.7' => '1.7',
        '1.8' => '1.8',
        '1.9' => '1.9',
        '2.0' => '2.0'
    );
    $options['panoramic-slider-button-margin'] = array(
        'id' => 'panoramic-slider-button-margin',
        'label'   => __( 'Button Top and Bottom Margin', 'panoramic' ),
        'section' => $section,
        'type'    => 'dropdown-em',
        'choices' => $choices,
    	'default' => '0.3'
    );    
    
	$options["panoramic-fieldset-divider-slider-.{$dividerCount}"] = array(
		'id' => "panoramic-fieldset-divider-slider-.{$dividerCount}",
		'section' => $section,
		'type'    => 'divider',
		'class'	  => 'default-slider'
	);
    $dividerCount++;
    */
    
	$options['panoramic-slider-responsive-heading'] = array(
		'id' => 'panoramic-slider-responsive-heading',
		'label'   => __( 'Responsive', 'panoramic' ),
		'section' => $section,
		'type'    => 'heading',
		'description' => __( 'Select the elements to hide for smaller screens. Please ensure that all content is properly formatted with the correct HTML tags in order for this to work correctly.', 'panoramic' )
	);

	$options['panoramic-slider-hide-text-overlay'] = array(
		'id' => 'panoramic-slider-hide-text-overlay',
		'label'   => __( 'Text Overlay', 'panoramic' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);
	
	$options['panoramic-slider-hide-headings'] = array(
		'id' => 'panoramic-slider-hide-headings',
		'label'   => __( 'Headings', 'panoramic' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);

	$options['panoramic-slider-hide-paragraphs'] = array(
		'id' => 'panoramic-slider-hide-paragraphs',
		'label'   => __( 'Paragraphs', 'panoramic' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);

	$options['panoramic-slider-hide-buttons'] = array(
		'id' => 'panoramic-slider-hide-buttons',
		'label'   => __( 'Buttons', 'panoramic' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);    

    $options['panoramic-slider-has-min-width'] = array(
    	'id' => 'panoramic-slider-has-min-width',
    	'label'   => __( 'Slider image has a minimum width', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    );
    
    $options['panoramic-slider-min-width'] = array(
    	'id' => 'panoramic-slider-min-width',
    	'label'   => __( 'Minimum Width', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'pixels',
    	'default' => 600
    );
    
    /*
    $options['panoramic-slider-text-overlay-height'] = array(
    	'id' => 'panoramic-slider-text-overlay-height',
    	'label'   => __( 'Text Overlay Height', 'panoramic' ),
    	'section' => $section,
		'type'    => 'percentage',
    	'default' => 50
    );

    $options['panoramic-slider-text-overlay-width'] = array(
    	'id' => 'panoramic-slider-text-overlay-width',
    	'label'   => __( 'Text Overlay Width', 'panoramic' ),
    	'section' => $section,
		'type'    => 'percentage',
    	'default' => 60
    );
    
    $options['panoramic-slider-text-overlay-padding'] = array(
    	'id' => 'panoramic-slider-text-overlay-padding',
    	'label'   => __( 'Text Overlay Padding', 'panoramic' ),
    	'section' => $section,
		'type'    => 'percentage',
    	'default' => 3.5
    );
    */

    /*
    $options['panoramic-slider-text-overlay-hide-width'] = array(
    	'id' => 'panoramic-slider-text-overlay-hide-width',
    	'label'   => __( 'Text Overlay Hide Width', 'panoramic' ),
    	'section' => $section,
		'type'    => 'text',
    	'default' => 899
    );
    */
    
	$options["panoramic-fieldset-divider-slider-.{$dividerCount}"] = array(
		'id' => "panoramic-fieldset-divider-slider-.{$dividerCount}",
		'section' => $section,
		'type'    => 'divider',
		'class'	  => 'default-slider'
	);
	$dividerCount++;
    
    $options['panoramic-slider-transition-speed'] = array(
    	'id' => 'panoramic-slider-transition-speed',
    	'label'   => __( 'Transition Speed', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'milliseconds',
    	'default' => 450,
    	'description' => __( 'The speed it takes to transition between slides in milliseconds. 1000 milliseconds equals 1 second.', 'panoramic' )
    );
    $choices = array(
    	'uncover-fade' => 'Uncover Fade',
    	'uncover' => 'Uncover',
    	'cover-fade' => 'Cover Fade',
    	'cover' => 'Cover',
    	'fade' => 'Fade',
    	'crossfade' => 'Crossfade',
    	'scroll' => 'Scroll',
    	'directscroll' => 'Direct Scroll'
    );
    $options['panoramic-slider-transition-effect'] = array(
    	'id' => 'panoramic-slider-transition-effect',
    	'label'   => __( 'Transition Effect', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'uncover-fade'
    );
    $options['panoramic-slider-autoscroll'] = array(
    	'id' => 'panoramic-slider-autoscroll',
    	'label'   => __( 'Slideshow', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    	'description' => __( 'Autoscroll the slider to create a slideshow effect.', 'panoramic' )
    );
    $options['panoramic-slider-speed'] = array(
    	'id' => 'panoramic-slider-speed',
    	'label'   => __( 'Slideshow Speed', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'milliseconds',
    	'default' => 2500,
    	'description' => __( 'The speed of the slideshow in milliseconds. 1000 milliseconds equals 1 second.', 'panoramic' )
    );
    
    $options['panoramic-slider-plugin-shortcode'] = array(
    	'id' => 'panoramic-slider-plugin-shortcode',
    	'label'   => __( 'Slider Shortcode', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
    	'description' => __( 'Enter the shortcode given by the slider plugin you\'re using.', 'panoramic' )
    );
    
    
    // Header Media
    $section = 'header_image';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Header Media', 'panoramic' ),
    	'priority' => '35'
    );
    
    if ( get_option('page_on_front') > 0 ) {
    	$custom_fields = get_post_custom( get_option('page_on_front') );
    	$slider_shortcode = trim($custom_fields["slider_shortcode"][0]);
    }
    
	if ( !$slider_shortcode ) {
	    $options['panoramic-slider-enabled-warning'] = array(
	    	'id' => 'panoramic-slider-enabled-warning',
	    	'label'   => __( 'Please note: The header media will not display on your site as the slider is currently enabled. To make the header media visible you will first need to disable the slider.', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'warning',
	    	'priority' => 0
	    );
	} else {
	    $options['panoramic-slider-enabled-warning'] = array(
	    	'id' => 'panoramic-slider-enabled-warning',
	    	'label'   => __( 'Please note: The header media will not display on your site as you have a shortcode set in the Slider Shortcode field of your homepage. To make the header media visible you will first need to remove this.', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'warning',
	    	'priority' => 0,
			'class'    => 'dont-hide'
	    );
	}
    
    $options['panoramic-smart-header-image'] = array(
    	'id' => 'panoramic-smart-header-image',
    	'label'   => __( 'Smart mode (increased responsiveness)', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
	
    $options['panoramic-header-image-text'] = array(
    	'id' => 'panoramic-header-image-text',
    	'label'   => __( 'Text', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'textarea',
    	'description' => esc_html( __( 'Use <h2></h2> tags around heading text and <p></p> tags around body text.', 'panoramic' ) )
    );
    
	// Check for the otb_panoramic_dot_org setting to honour the free version of the theme 
    if ( get_theme_mod( 'otb_panoramic_dot_org' ) ) {
		$options['panoramic-header-image-text']['default'] = '';
    } else {
		$options['panoramic-header-image-text']['default'] = __( '<h2>Beautiful. Simple. Fresh.</h2><p>Panoramic is a stunning new theme that provides an easy way for companies or web developers to spring into action online!</p>', 'panoramic' );
    }
    
    $options['panoramic-header-image-link-content'] = array(
    	'id' => 'panoramic-header-image-link-content',
    	'label'   => __( 'Content to link to', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'dropdown-pages-posts',
    	'description' => __( 'Select the page or post you would like your Header Image to link to.', 'panoramic' )
    );    
    
    $options['panoramic-header-image-text-overlay-background-color'] = array(
    	'id' => 'panoramic-header-image-text-overlay-background-color',
    	'label'   => __( 'Text Overlay Color', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $header_image_text_overlay_background_color
    );
    
    $options['panoramic-header-image-text-overlay-opacity'] = array(
    	'id' => 'panoramic-header-image-text-overlay-opacity',
    	'label'   => __( 'Text Overlay Opacity', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'range',
    	'default' => 0.6,
    	'input_attrs' => array(
    		'min'   => 0,
    		'max'   => 1,
    		'step'  => 0.1,
    		'style' => 'color: #000000',
    	)
    );

	$options["panoramic-fieldset-divider-header-image-.{$dividerCount}"] = array(
		'id' => "panoramic-fieldset-divider-header-image-.{$dividerCount}",
		'section' => $section,
		'type'    => 'divider'
	);
    $dividerCount++;
    
	$options['panoramic-header-image-responsive-heading'] = array(
		'id' => 'panoramic-header-image-responsive-heading',
		'label'   => __( 'Responsive', 'panoramic' ),
		'section' => $section,
		'type'    => 'heading',
		'description' => __( 'Select the elements to hide for smaller screens. Please ensure that all content is properly formatted with the correct HTML tags in order for this to work correctly.', 'panoramic' )
	);

	$options['panoramic-header-image-hide-text-overlay'] = array(
		'id' => 'panoramic-header-image-hide-text-overlay',
		'label'   => __( 'Text Overlay', 'panoramic' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);
	
	$options['panoramic-header-image-hide-headings'] = array(
		'id' => 'panoramic-header-image-hide-headings',
		'label'   => __( 'Headings', 'panoramic' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);

	$options['panoramic-header-image-hide-paragraphs'] = array(
		'id' => 'panoramic-header-image-hide-paragraphs',
		'label'   => __( 'Paragraphs', 'panoramic' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);

	$options['panoramic-header-image-hide-buttons'] = array(
		'id' => 'panoramic-header-image-hide-buttons',
		'label'   => __( 'Buttons', 'panoramic' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);

    $options['panoramic-header-image-has-min-width'] = array(
    	'id' => 'panoramic-header-image-has-min-width',
    	'label'   => __( 'Header image has a minimum width', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    );
    
    $options['panoramic-header-image-min-width'] = array(
    	'id' => 'panoramic-header-image-min-width',
    	'label'   => __( 'Minimum Width', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'pixels',
    	'default' => 600
    );
	
	
	// WooCommerce
	if ( panoramic_is_woocommerce_activated() ) {
	    
	    // WooCommerce
	    $panel = 'woocommerce';
	    
	    $panels[] = array(
	    	'id' => $panel,
	    	'title' => __( 'WooCommerce', 'panoramic' ),
	    	'priority' => '30'
	    );    

	    	// Layout
		    $section = 'woocommerce-layout';
		    
		    $sections[] = array(
		    	'id' => $section,
		    	'title' => __( 'Layout', 'panoramic' ),
		    	'priority' => '10',
		    	'panel' => $panel
		    );
	    
		    $options['panoramic-woocommerce-breadcrumbs'] = array(
		    	'id' => 'panoramic-woocommerce-breadcrumbs',
		    	'label'   => __( 'Display breadcrumbs', 'panoramic' ),
		    	'section' => $section,
		    	'type'    => 'checkbox',
		    	'default' => 1,
		    );

	    	// Product Catalog
		    $section = 'woocommerce_product_catalog';
		    
		    $sections[] = array(
		    	'id' => $section,
		    	'title' => __( 'Product Catalog', 'panoramic' ),
		    	'priority' => '10',
		    	'panel' => $panel
		    );
	    
		    $options['panoramic-layout-woocommerce-shop-full-width'] = array(
		    	'id' => 'panoramic-layout-woocommerce-shop-full-width',
		    	'label'   => __( 'Full width', 'panoramic' ),
		    	'section' => $section,
		    	'type'    => 'checkbox',
		    	'priority' => '0',
		    	'default' => 0
		    );
		    
		    $options['panoramic-woocommerce-products-per-page'] = array(
		    	'id' => 'panoramic-woocommerce-products-per-page',
		    	'label'   => __( 'Products per page', 'panoramic' ),
		    	'section' => $section,
		    	'type'    => 'text',
		    	'default' => get_option('posts_per_page'),
		    	'description' => __( 'How many products should be shown per page?', 'panoramic' )
		    );
		    
	    	// Product
		    $section = 'woocommerce-product';
		    
		    $sections[] = array(
		    	'id' => $section,
		    	'title' => __( 'Product', 'panoramic' ),
		    	'priority' => '10',
		    	'panel' => $panel
		    );
		    
		    $options['panoramic-layout-woocommerce-product-full-width'] = array(
		    	'id' => 'panoramic-layout-woocommerce-product-full-width',
		    	'label'   => __( 'Full width', 'panoramic' ),
		    	'section' => $section,
		    	'type'    => 'checkbox',
		    	'default' => get_theme_mod( 'panoramic-layout-woocommerce-shop-full-width', 0 )
		    );
		    
		    $options['panoramic-woocommerce-product-image-zoom'] = array(
		    	'id' => 'panoramic-woocommerce-product-image-zoom',
		    	'label'   => __( 'Enable zoom on product image', 'panoramic' ),
		    	'section' => $section,
		    	'type'    => 'checkbox',
		    	'default' => 1,
		    );
		    
	    	// Product category / tag page
		    $section = 'woocommerce-category-tag-page';
		    
		    $sections[] = array(
		    	'id' => $section,
		    	'title' => __( 'Product Category and Tag Page', 'panoramic' ),
		    	'priority' => '10',
		    	'panel' => $panel
		    );
	    
		    $options['panoramic-layout-woocommerce-category-tag-page-full-width'] = array(
		    	'id' => 'panoramic-layout-woocommerce-category-tag-page-full-width',
		    	'label'   => __( 'Full width', 'panoramic' ),
		    	'section' => $section,
		    	'type'    => 'checkbox',
		    	'priority' => '0',
		    	'default' => get_theme_mod( 'panoramic-layout-woocommerce-shop-full-width', 0 )
		    );
	    
	    /*
	    $choices = array(
	        'panoramic-shop-left-sidebar' => 'Left',
	        'panoramic-shop-right-sidebar' => 'Right'
	    );
	    $options['panoramic-woocommerce-shop-sidebar-alignment'] = array(
	        'id' => 'panoramic-woocommerce-shop-sidebar-alignment',
	        'label'   => __( 'Shop page sidebar alignment', 'panoramic' ),
	        'section' => $section,
	        'type'    => 'select',
	        'choices' => $choices,
	    	'default' => 'panoramic-shop-right-sidebar'
	    );
		*/
	}

	
	// Colors
    $section = 'colors';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Colors', 'panoramic' ),
    	'priority' => '25'
    );    
    
    /*
    $choices = array(
    	'dark-blue' => 'Dark Blue',
    	'brown' => 'Brown',
    	'rasberry-red' => 'Rasberry Red',
    	'olive-green' => 'Olive Green',
    	'burnt-orange' => 'Burnt Orange',
    	'bright-orange' => 'Bright Orange',
    	'sunshine-yellow' => 'Sunshine Yellow',
    	'colonel-mustard' => 'Colonel Mustard',
    	'apple-green' => 'Apple Green',
    	'charcoal' => 'Charcoal',
    	'candyfloss-pink' => 'Candyfloss Pink',
    	'sky-blue' => 'Sky Blue',
    	'blue' => 'Blue',
    	'gray' => 'Gray',
    	'grape purple' => 'Grape Purple'
    );
    $options['panoramic-color-scheme'] = array(
    	'id' => 'panoramic-color-scheme',
    	'label'   => __( 'Color Scheme', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'blue',
    	'description' => 'Select a color scheme or manually set the colors below'
    );
	*/
    
    $options['panoramic-page-content-background-color'] = array(
    	'id' => 'panoramic-page-content-background-color',
    	'label'   => __( 'Page Content Background Color', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $page_content_background_color,
    );
    
	$options['panoramic-top-bar-color'] = array(
		'id' => 'panoramic-top-bar-color',
		'label'   => __( 'Top Bar Color', 'panoramic' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $top_bar_color
	);
    
	$options['panoramic-header-color'] = array(
		'id' => 'panoramic-header-color',
		'label'   => __( 'Header Color', 'panoramic' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $header_color
	);

	$options['panoramic-primary-color'] = array(
		'id' => 'panoramic-primary-color',
		'label'   => __( 'Primary Color', 'panoramic' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $primary_color
	);
	$options['panoramic-secondary-color'] = array(
		'id' => 'panoramic-secondary-color',
		'label'   => __( 'Secondary Color', 'panoramic' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondary_color
	);
	$options['panoramic-footer-color'] = array(
		'id' => 'panoramic-footer-color',
		'label'   => __( 'Footer Color', 'panoramic' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_color
	);
	
   
    // Font Settings
    $section = 'panoramic-fonts';
    $font_choices = customizer_library_get_font_choices();
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Fonts', 'panoramic' ),
    	'priority' => '25'
    );

    $options['panoramic-site-title-font'] = array(
    	'id' => 'panoramic-site-title-font',
    	'label'   => __( 'Site Title Font', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $font_choices,
    	'default' => 'Kaushan Script'
    );
    $choices = array(
    	'thin' => 'Thin',
    	'light' => 'Light',
    	'normal' => 'Normal',
    	'semi-bold' => 'Semi-bold',
    	'bold' => 'Bold',
    	'extra-bold' => 'Extra Bold'
    );
    $options['panoramic-site-title-font-weight'] = array(
    	'id' => 'panoramic-site-title-font-weight',
    	'label'   => __( 'Site Title Font Weight', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'normal'
    );

    /*
    //TODO Add Font Pairings theme setting
    $choices = array(
    	'Raleway,Lato' => 'Raleway and Lato',
    	'Josefin Sans,Merriweather' => 'Josefin Sans and Merriweather',
    	'Squada One,Roboto Condensed' => 'Squada One and Roboto Condensed',
    	'Playfair Display,Raleway' => 'Playfair Display and Raleway',
    	'Oswald,Droid Serif' => 'Oswald and Droid Serif',
    	'Prata,Lato' => 'Prata and Lato',
    	'Special Elite,Roboto' => 'Special Elite and Roboto',
    	'FjalloOne,Roboto Condensed' => '--FjalloOne and Roboto Condensed',
    	'Alegreya,Alegreya Sans' => 'Alegreya and Alegreya Sans',
    	'Slabo,Roboto' => '--Slabo and Roboto',
    	'Cardo,Cardo' => '--Cardo and Cardo',
    	'IM Fell English,Special Elite' => 'IM Fell English and Special Elite'
    );
    $options['panoramic-google-font-pairing'] = array(
    	'id' => 'panoramic-google-font-pairing',
    	'label'   => __( 'Font Pairings', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'Raleway,Lato',
    	'description' => 'Select a font pairing to use for the heading and body text.'
    );    
    */
    
    $options['panoramic-heading-font'] = array(
    	'id' => 'panoramic-heading-font',
    	'label'   => __( 'Heading Font', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $font_choices,
    	'default' => 'Raleway'
    );
    $options['panoramic-heading-font-color'] = array(
    	'id' => 'panoramic-heading-font-color',
    	'label'   => __( 'Heading Font Color', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $heading_font_color
    );
    
    $options['panoramic-body-font'] = array(
    	'id' => 'panoramic-body-font',
    	'label'   => __( 'Body Font', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $font_choices,
    	'default' => 'Lato'
    );
    
    $choices = array(
    	'300' => 'Light',
    	'400' => 'Normal'
    );    
    $options['panoramic-body-font-weight'] = array(
    	'id' => 'panoramic-body-font-weight',
    	'label'   => __( 'Body Font Weight', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => '300'
    );
    
    $options['panoramic-body-font-color'] = array(
    	'id' => 'panoramic-body-font-color',
    	'label'   => __( 'Body Font Color', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $body_font_color
    );
    
    
    // Blog Settings
    $panel = 'panoramic-blog';
    
    $panels[] = array(
    	'id' => $panel,
    	'title' => __( 'Blog', 'panoramic' ),
    	'priority' => '50'
    );    

    	// Post list
	    $section = 'panoramic-blog-archive-page';
	    
	    $sections[] = array(
	    	'id' => $section,
	    	'title' => __( 'Post List', 'panoramic' ),
	    	'priority' => '10',
	    	'panel' => $panel
	    );
    
	    $options['panoramic-blog-full-width-archive'] = array(
	    	'id' => 'panoramic-blog-full-width-archive',
	    	'label'   => __( 'Full width', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox'
	    );
	    
		// Check for the panoramic-blog-full-width setting and honour it's current value as the default value if it exists
	    if ( get_theme_mod( 'panoramic-blog-full-width' ) ) {
	    	$options['panoramic-blog-full-width-archive']['default'] = get_theme_mod( 'panoramic-blog-full-width' );
	    } else {
	    	$options['panoramic-blog-full-width-archive']['default'] = 0;
	    }
	    
	    $options['panoramic-blog-archive-display-post-titles'] = array(
	    	'id' => 'panoramic-blog-archive-display-post-titles',
	    	'label'   => __( 'Display post titles', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );
	    
	    $choices = array(
	        'blog-post-side-layout' => 'Side Featured Image',
	        'blog-post-top-layout' => 'Top Featured Image',
	    	'blog-post-masonry-grid-layout' => 'Masonry Grid'
	    );
	    $options['panoramic-blog-layout'] = array(
	        'id' => 'panoramic-blog-layout',
	        'label'   => __( 'Layout', 'panoramic' ),
	        'section' => $section,
	        'type'    => 'select',
	        'choices' => $choices,
	        'default' => 'blog-post-side-layout'
	    );
    
	    $choices = array(
	        '2' => 'Two',
	        '3' => 'Three',
	    	'4' => 'Four',
	    	'5' => 'Five'
	    );
	    $options['panoramic-blog-masonry-grid-columns'] = array(
	        'id' => 'panoramic-blog-masonry-grid-columns',
	        'label'   => __( 'Number of columns', 'panoramic' ),
	        'section' => $section,
	        'type'    => 'select',
	        'choices' => $choices,
	        'default' => '3'
	    );
    
	    $options['panoramic-blog-masonry-grid-horizontal-order'] = array(
	    	'id' => 'panoramic-blog-masonry-grid-horizontal-order',
	    	'label'   => __( 'Maintain horizontal left-to-right order', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );

	    $options['panoramic-blog-masonry-grid-border'] = array(
	    	'id' => 'panoramic-blog-masonry-grid-border',
	    	'label'   => __( 'Display a border around posts', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );
	    
	    $options['panoramic-blog-masonry-grid-gutter'] = array(
	    	'id' => 'panoramic-blog-masonry-grid-gutter',
	    	'label'   => __( 'Post Gutter', 'panoramic' ),
	    	'section' => $section,
			'type'    => 'percentage',
	    	'default' => 2.6,
	    	'description' => 'This is the spacing between the posts. It can contain decimal values. For best results it should be an even number.'
	    );
	    
		$options["panoramic-fieldset-.{$dividerCount}"] = array(
			'id' => "panoramic-fieldset-.{$dividerCount}",
			'section' => $section,
			'type'    => 'divider'
		);
	    $dividerCount++;
	    
		$options['panoramic-blog-featured-image-heading'] = array(
			'id' => 'panoramic-blog-featured-image-heading',
			'label'   => __( 'Featured Image', 'panoramic' ),
			'section' => $section,
			'type'    => 'heading'
		);

		$options['panoramic-blog-featured-image-size'] = array(
			'id' => 'panoramic-blog-featured-image-size',
			'label'   => __( 'Size', 'panoramic' ),
			'section' => $section,
			'type'    => 'dropdown-image-size',
			//'description' => 'This list consists of all of the available image sizes in your site',
			'default' => 'large'
	    );
		
	    $choices = array(
	    	'default' => 'Default',
	    	'square' => 'Square',
	    	'round' => 'Round'
	    );
	    $options['panoramic-featured-image-style'] = array(
	    	'id' => 'panoramic-featured-image-style',
	    	'label'   => __( 'Shape', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'select',
	    	'choices' => $choices,
	    	'default' => 'default',
	    	//'description' => __( '<strong>Please note:</strong> This change won\'t affect existing images in your media library. You can use the <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> plugin to regenerate these.', 'panoramic' ),
	    );
	    
	    $choices = array(
	    	'full' => 'Full',
	    	'tall' => 'Tall',
	    	'medium' => 'Medium',
	    	'short' => 'Short'
	    );
	    $options['panoramic-featured-image-height'] = array(
	    	'id' => 'panoramic-featured-image-height',
	    	'label'   => __( 'Height', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'select',
	    	'choices' => $choices,
	    	'default' => 'full'
	    );

	    $choices = array(
	    	'left-aligned' => 'Left aligned',
	    	'right-aligned' => 'Right aligned',
	    	'alternate-aligned' => 'Alternating'
	    );
	    $options['panoramic-featured-image-alignment-side-layout'] = array(
	    	'id' => 'panoramic-featured-image-alignment-side-layout',
	    	'label'   => __( 'Alignment', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'select',
	    	'choices' => $choices,
	    	'default' => 'left-aligned'
	    );
	    
	    $choices = array(
	    	'left-aligned' => 'Left aligned',
	    	'centered' => 'Center',
	    	'right-aligned' => 'Right aligned'
	    );
	    $options['panoramic-featured-image-alignment-top-layout'] = array(
	    	'id' => 'panoramic-featured-image-alignment-top-layout',
	    	'label'   => __( 'Alignment', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'select',
	    	'choices' => $choices,
	    	'default' => 'centered'
	    );
		
	    $choices = array(
	    	'no-rollover' => 'None',
	    	'opacity-rollover' => 'Opacity',
	    	'zoom-rollover' => 'Zoom'
	    );
	    $options['panoramic-featured-image-rollover-effect'] = array(
	    	'id' => 'panoramic-featured-image-rollover-effect',
	    	'label'   => __( 'Rollover Effect', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'select',
	    	'choices' => $choices,
	    	'default' => 'no-rollover'
	    );
	    
	    $options['panoramic-featured-image-rollover-effect-opacity'] = array(
	    	'id' => 'panoramic-featured-image-rollover-effect-opacity',
	    	'label'   => __( 'Opacity', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'range',
	    	'default' => 0.5,
	    	'input_attrs' => array(
	    		'min'   => 0,
	    		'max'   => 1,
	    		'step'  => 0.1,
	    		'style' => 'color: #000000',
	    	)
	    );
	    
	    $options['panoramic-featured-image-disable-style-for-mobile'] = array(
	    	'id' => 'panoramic-featured-image-disable-style-for-mobile',
	    	'label'   => __( 'Disable image style on smaller screens', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );

	    $options['panoramic-featured-image-constrain'] = array(
	    	'id' => 'panoramic-featured-image-constrain',
	    	'label'   => __( 'Fit to thumbnail size', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );
	    
	    $options['panoramic-featured-image-full-width'] = array(
	    	'id' => 'panoramic-featured-image-full-width',
	    	'label'   => __( 'Stretch', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 0
	    );
	    
	    $options['panoramic-blog-featured-image-clickable'] = array(
	    	'id' => 'panoramic-blog-featured-image-clickable',
	    	'label'   => __( 'Link to post', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 0
	    );
	    
	    /*
	    $options['panoramic-blog-crop-featured-image'] = array(
	    	'id' => 'panoramic-blog-crop-featured-image',
	    	'label'   => __( 'Crop Featured Image', 'panoramic' ),
	    	'section' => $section,
			'type'    => 'checkbox',
	    	'default' => 1,
	    	'description' => __( '<strong>Please note:</strong> This change won\'t affect existing images in your media library. You can use the <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> plugin to regenerate these.', 'panoramic' ),
	    );
	    */
	    
		$options["panoramic-fieldset-.{$dividerCount}"] = array(
			'id' => "panoramic-fieldset-.{$dividerCount}",
			'section' => $section,
			'type'    => 'divider'
		);
	    $dividerCount++;

	    $choices = array(
			'panoramic-blog-archive-layout-full' => 'Full post',
			'panoramic-blog-archive-layout-excerpt' => 'Excerpt'
	    );
	    $options['panoramic-blog-archive-layout'] = array(
	        'id' => 'panoramic-blog-archive-layout',
	        'label'   => __( 'Text Length', 'panoramic' ),
	        'section' => $section,
	        'type'    => 'select',
	        'choices' => $choices,
	        'default' => 'panoramic-blog-archive-layout-full'
	    );
    
	    $options['panoramic-blog-excerpt-length'] = array(
	    	'id' => 'panoramic-blog-excerpt-length',
	    	'label'   => __( 'Excerpt Length', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'text',
	    	'default' => 55
	    );
    
	    $options['panoramic-blog-read-more'] = array(
	    	'id' => 'panoramic-blog-read-more',
	    	'label'   => __( 'Display a Read More Link', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );
    
	    $options['panoramic-blog-read-more-text'] = array(
	    	'id' => 'panoramic-blog-read-more-text',
	    	'label'   => __( 'Read More Text', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'text',
	    	'default' => __( 'Read More', 'panoramic' )
	    );

	    $choices = array(
	        'inline' => 'Next to the excerpt',
	        'below' => 'Below the excerpt'
	    );
	    $options['panoramic-blog-read-more-position'] = array(
	        'id' => 'panoramic-blog-read-more-position',
	        'label'   => __( 'Read More Position', 'panoramic' ),
	        'section' => $section,
	        'type'    => 'select',
	        'choices' => $choices,
	        'default' => 'inline'
	    );
	    
    	// Post
	    $section = 'panoramic-blog-post-page';
	    
	    $sections[] = array(
	    	'id' => $section,
	    	'title' => __( 'Post', 'panoramic' ),
	    	'priority' => '10',
	    	'panel' => $panel
	    );
    
	    $options['panoramic-blog-full-width-single'] = array(
	    	'id' => 'panoramic-blog-full-width-single',
	    	'label'   => __( 'Full width', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 0
	    );
   	
		// Check for the panoramic-blog-full-width setting and honour it's current value as the default value if it exists
	    if ( get_theme_mod( 'panoramic-blog-full-width' ) ) {
	    	$options['panoramic-blog-full-width-single']['default'] = get_theme_mod( 'panoramic-blog-full-width' );
	    } else {
	    	$options['panoramic-blog-full-width-single']['default'] = 0;
	    }
	    
	    $options['panoramic-blog-featured-image'] = array(
	    	'id' => 'panoramic-blog-featured-image',
	    	'label'   => __( 'Display the featured image', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );
	    
	    $options['panoramic-layout-display-post-titles'] = array(
	    	'id' => 'panoramic-layout-display-post-titles',
	    	'label'   => __( 'Display the title', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );	    
	    
    	// Meta Data
	    $section = 'panoramic-blog-meta-data';
	    
	    $sections[] = array(
	    	'id' => $section,
	    	'title' => __( 'Meta Data', 'panoramic' ),
	    	'priority' => '10',
	    	'panel' => $panel
	    );
	    
		$options['panoramic-blog-meta-data-heading'] = array(
			'id' => 'panoramic-blog-meta-data-heading',
			'label'   => __( 'Select the meta data to display:', 'panoramic' ),
			'section' => $section,
			'type'    => 'heading'
		);
	    
	    $options['panoramic-blog-display-date'] = array(
	    	'id' => 'panoramic-blog-display-date',
	    	'label'   => __( 'Date', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );
    
	    $options['panoramic-blog-display-author'] = array(
	    	'id' => 'panoramic-blog-display-author',
	    	'label'   => __( 'Author', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );
    
	    $options['panoramic-blog-display-meta-data'] = array(
	    	'id' => 'panoramic-blog-display-meta-data',
	    	'label'   => __( 'Tags and categories', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );
    
	    $options['panoramic-blog-display-comment-count'] = array(
	    	'id' => 'panoramic-blog-display-comment-count',
	    	'label'   => __( 'Comment count', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );
    
    	// Page Title Prefixes
	    $section = 'panoramic-blog-page-title-prefixes';
	    
	    $sections[] = array(
	    	'id' => $section,
	    	'title' => __( 'Page Title Prefixes', 'panoramic' ),
	    	'priority' => '10',
	    	'panel' => $panel
	    );
	    
		$options['panoramic-blog-page-title-prefixes'] = array(
			'id' => 'panoramic-blog-page-title-prefixes',
			'label'   => __( 'Title prefixes will display on the following:', 'panoramic' ),
			'section' => $section,
			'type'    => 'heading'
		);
	    
	    $options['panoramic-blog-display-category-page-title-prefix'] = array(
	    	'id' => 'panoramic-blog-display-category-page-title-prefix',
	    	'label'   => __( 'Category page', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );
    
	    $options['panoramic-blog-display-tag-page-title-prefix'] = array(
	    	'id' => 'panoramic-blog-display-tag-page-title-prefix',
	    	'label'   => __( 'Tag page', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'checkbox',
	    	'default' => 1
	    );
    
	if ( class_exists( 'RPW_Extended' ) ) {
		// Recent Posts Widget Extended
	    $section = 'panoramic-recent-posts-widget-extended';
	    
	    $sections[] = array(
	    	'id' => $section,
	    	'title' => __( 'Recent Posts Widget Extended', 'panoramic' ),
	    	'priority' => '50'
	    );
	    
	    $choices = array(
	    	'rpwe-horizontal' => 'Horizontal',
	    	'rpwe-vertical' => 'Vertical'
	    );
	    $options['panoramic-rpwe-site-content-layout'] = array(
	    	'id' => 'panoramic-rpwe-site-content-layout',
	    	'label'   => __( 'Site Content Layout', 'panoramic' ),
	    	'section' => $section,
	    	'type'    => 'select',
	    	'choices' => $choices,
	    	'default' => 'rpwe-horizontal'
	    );
	}
    
    // Website Text Settings
    $section = 'panoramic-website-text';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Website Text', 'panoramic' ),
        'priority' => '50'
    );
    $options['panoramic-website-text-404-page-heading'] = array(
        'id' => 'panoramic-website-text-404-page-heading',
        'label'   => __( '404 Page Heading', 'panoramic' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( '404!', 'panoramic' )
    );
    $options['panoramic-website-text-404-page-text'] = array(
        'id' => 'panoramic-website-text-404-page-text',
        'label'   => __( '404 Page Message', 'panoramic' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'The page you were looking for cannot be found!', 'panoramic' )
    );
    
    
    // Footer Settings
    $section = 'panoramic-footer';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Footer', 'panoramic' ),
    	'priority' => '50'
    );
    
    $options['panoramic-layout-display-footer-widgets'] = array(
    	'id' => 'panoramic-layout-display-footer-widgets',
    	'label'   => __( 'Display the footer widgets', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );
    
    $choices = array(
        'one' => 'One',
    	'two' => 'Two',
    	'three' => 'Three',
    	'four' => 'Four',
    	'five' => 'Five'
    );
    $options['panoramic-footer-widget-amount'] = array(
        'id' => 'panoramic-footer-widget-amount',
        'label'   => __( 'Number of widgets to display per row', 'panoramic' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'four'
    );
    
    $options['panoramic-footer-display-bottom-bar'] = array(
    	'id' => 'panoramic-footer-display-bottom-bar',
    	'label'   => __( 'Display the footer bottom bar', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );
    
    $choices = array(
    	'panoramic-footer-bottom-bar-layout-standard' => 'Standard',
    	'panoramic-footer-bottom-bar-layout-centered' => 'Centered'
    );
    $options['panoramic-footer-bottom-bar-layout'] = array(
    	'id' => 'panoramic-footer-bottom-bar-layout',
    	'label'   => __( 'Bottom Bar Layout', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'panoramic-footer-bottom-bar-layout-standard'
    );
    
    $options['panoramic-footer-copyright-text'] = array(
    	'id' => 'panoramic-footer-copyright-text',
    	'label'   => __( 'Copyright Text', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
    	'default' => __( 'Theme by <a href="http://www.outtheboxthemes.com">Out the Box</a>', 'panoramic' ),
    	'description' => __( 'You can add the site title or current year with the following tags:<br \> <strong>Site title:</strong> {site-title} <br \> <strong>Current year:</strong> {year}', 'panoramic' )
    );
    
    
    // Media
    $section = 'panoramic-media';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Media', 'panoramic' ),
    	'priority' => '50'
    );

    $options['panoramic-media-crisp-images'] = array(
    	'id' => 'panoramic-media-crisp-images',
    	'label'   => __( 'Crisp images', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    	'description' => __( '<p>This will remove the default anti-aliasing done to scaled images by browsers creating a more crisp image.</p>', 'panoramic' )
    );    
    
    $options['panoramic-media-image-compression'] = array(
    	'id' => 'panoramic-media-image-compression',
    	'label'   => __( 'Image compression', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    	'description' => __( '<p>By default WordPress compresses resized images to 82% for increased page load speed. To retain the quality of your images 
    						after resizing them in WordPress, you can simply disable image compression.</p><p><strong>Please note:</strong> This change won\'t 
    						affect existing images in your media library.</p>', 'panoramic' )
    );    
    
	// Adds the sections to the $options array
	$options['sections'] = $sections;

	// Adds the panels to the $options array
	$options['panels'] = $panels;
	
	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

	// To delete custom mods use: customizer_library_remove_theme_mods();

}
add_action( 'init', 'panoramic_customizer_library_options' );
