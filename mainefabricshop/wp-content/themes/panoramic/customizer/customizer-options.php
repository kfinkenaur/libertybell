<?php
/**
 * Defines customizer options
 *
 * @package Customizer Library Demo
 */

function panoramic_customizer_library_options() {
	// Theme defaults
	$top_bar_color = '#FFFFFF';
	$header_color = '#FFFFFF';
	$primary_color = '#006489';
	$secondary_color = '#3F84A4';
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
	
    $options['panoramic-logo-with-site-title'] = array(
    	'id' => 'panoramic-logo-with-site-title',
    	'label'   => __( 'Display site title and tagline with the logo', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
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
        'default' => 'panoramic-logo-with-site-title-right'
    );
    
    $options['site_branding_padding_top'] = array(
    	'id' => 'site_branding_padding_top',
    	'label'   => __( 'Padding Top', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'pixels',
    	'default' => 27
    );

    $options['site_branding_padding_bottom'] = array(
    	'id' => 'site_branding_padding_bottom',
    	'label'   => __( 'Padding Bottom', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'pixels',
    	'default' => 23
    );
    
    $options['panoramic-logo-link-content'] = array(
    	'id' => 'panoramic-logo-link-content',
    	'label'   => __( 'Content to link your logo / site title to', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'dropdown-logo-pages-posts',
    	'description' => __( 'Select the page or post you would like your logo / site title to link to.', 'panoramic' )
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
        'label'   => __( 'Site Layout', 'panoramic' ),
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
    
    $options['panoramic-layout-display-page-titles'] = array(
    	'id' => 'panoramic-layout-display-page-titles',
    	'label'   => __( 'Display Page Titles', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
    
    $options['panoramic-layout-display-post-titles'] = array(
    	'id' => 'panoramic-layout-display-post-titles',
    	'label'   => __( 'Display Post Titles', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
    
    $options['panoramic-layout-woocommerce-shop-full-width'] = array(
    	'id' => 'panoramic-layout-woocommerce-shop-full-width',
    	'label'   => __( 'Full width WooCommerce Shop page', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
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
    
    $options['panoramic-layout-navigation-opacity'] = array(
    	'id' => 'panoramic-layout-navigation-opacity',
    	'label'   => __( 'Navigation Opacity', 'panoramic' ),
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
    
    /*
    $options['panoramic-header-height'] = array(
    	'id' => 'panoramic-header-height',
    	'label'   => __( 'Height', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
    	'default' => 108
    );
    */
    
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
		'default' => __( 'Nothing Found!', 'panoramic')
    );
    $options['panoramic-website-text-no-search-results-text'] = array(
        'id' => 'panoramic-website-text-no-search-results-text',
        'label'   => __( 'No Search Results Message', 'panoramic' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'panoramic')
    );
    
    
    // Mobile Settings
    $section = 'panoramic-mobile-menu';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Mobile', 'panoramic' ),
    	'priority' => '35'
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
    
    $options['panoramic-mobile-menu-breakpoint'] = array(
    	'id' => 'panoramic-mobile-menu-breakpoint',
    	'label'   => __( 'Mobile Menu Breakpoint', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'pixels',
    	'default' => 960,
    	'description' => __( 'The screen width in pixels when the menu will go into mobile mode.', 'panoramic' )
    );
    
    $options['panoramic-mobile-back-to-top'] = array(
    	'id' => 'panoramic-mobile-back-to-top',
    	'label'   => __( 'Show the back to top button on mobile', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
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
    
    /*
    $options['panoramic-slider-text-overlay-height'] = array(
    	'id' => 'panoramic-slider-text-overlay-height',
    	'label'   => __( 'Text Overlay Height', 'panoramic' ),
    	'section' => $section,
		'type'    => 'text',
    	'default' => 50
    );

    $options['panoramic-slider-text-overlay-width'] = array(
    	'id' => 'panoramic-slider-text-overlay-width',
    	'label'   => __( 'Text Overlay Width', 'panoramic' ),
    	'section' => $section,
		'type'    => 'text',
    	'default' => 60
    );
    
    $options['panoramic-slider-text-overlay-padding'] = array(
    	'id' => 'panoramic-slider-text-overlay-padding',
    	'label'   => __( 'Text Overlay Padding', 'panoramic' ),
    	'section' => $section,
		'type'    => 'text',
    	'default' => 3.5
    );
    
    $options['panoramic-slider-text-overlay-hide-width'] = array(
    	'id' => 'panoramic-slider-text-overlay-hide-width',
    	'label'   => __( 'Text Overlay Hide Width', 'panoramic' ),
    	'section' => $section,
		'type'    => 'text',
    	'default' => 899
    );
    */
    
    $options['panoramic-slider-transition-speed'] = array(
    	'id' => 'panoramic-slider-transition-speed',
    	'label'   => __( 'Transition Speed', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
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
    	'type'    => 'text',
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
    
    
    // Header Image
    $section = 'header_image';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Header Image', 'panoramic' ),
    	'priority' => '35'
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
    
    
	// Colors
    $section = 'colors';
    $font_choices = customizer_library_get_font_choices();
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Colors', 'panoramic' ),
    	'priority' => '25'
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
    $options['panoramic-body-font-color'] = array(
    	'id' => 'panoramic-body-font-color',
    	'label'   => __( 'Body Font Color', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $body_font_color
    );
    
    
    // Blog Settings
    $section = 'panoramic-blog';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Blog', 'panoramic' ),
        'priority' => '50'
    );
    
    $choices = array(
        'blog-post-side-layout' => 'Side',
        'blog-post-top-layout' => 'Top'
    );
    $options['panoramic-blog-layout'] = array(
        'id' => 'panoramic-blog-layout',
        'label'   => __( 'Blog Post Layout', 'panoramic' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'blog-post-side-layout'
    );
    
    $choices = array(
		'panoramic-blog-archive-layout-full' => 'Full Post',
		'panoramic-blog-archive-layout-excerpt' => 'Post Excerpt'
    );
    $options['panoramic-blog-archive-layout'] = array(
        'id' => 'panoramic-blog-archive-layout',
        'label'   => __( 'Archive Layout', 'panoramic' ),
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
    
    $options['panoramic-blog-read-more-text'] = array(
    	'id' => 'panoramic-blog-read-more-text',
    	'label'   => __( 'Read More Text', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'text',
    	'default' => __( 'Read More', 'panoramic' )
    );
    
    $options['panoramic-blog-crop-featured-image'] = array(
    	'id' => 'panoramic-blog-crop-featured-image',
    	'label'   => __( 'Crop Featured Image', 'panoramic' ),
    	'section' => $section,
		'type'    => 'checkbox',
    	'default' => 1,
    	'description' => __( 'This change won\'t affect existing images in your media library.', 'panoramic' ),
    );
    
    $options['panoramic-blog-full-width'] = array(
    	'id' => 'panoramic-blog-full-width',
    	'label'   => __( 'Full width', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0
    );
    
    $options['panoramic-blog-featured-image'] = array(
    	'id' => 'panoramic-blog-featured-image',
    	'label'   => __( 'Display Featured Image on single', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
    
    $options['panoramic-blog-display-date'] = array(
    	'id' => 'panoramic-blog-display-date',
    	'label'   => __( 'Display date', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
    
    $options['panoramic-blog-display-author'] = array(
    	'id' => 'panoramic-blog-display-author',
    	'label'   => __( 'Display author', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
    
    $options['panoramic-blog-display-meta-data'] = array(
    	'id' => 'panoramic-blog-display-meta-data',
    	'label'   => __( 'Display tags and categories', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
    
    $options['panoramic-blog-display-comment-count'] = array(
    	'id' => 'panoramic-blog-display-comment-count',
    	'label'   => __( 'Display comment count', 'panoramic' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1
    );
    
    
    // website Text Settings
    $section = 'panoramic-website';

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
        'default' => __( '404!', 'panoramic')
    );
    $options['panoramic-website-text-404-page-text'] = array(
        'id' => 'panoramic-website-text-404-page-text',
        'label'   => __( '404 Page Message', 'panoramic' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'The page you were looking for cannot be found!', 'panoramic')
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
    
    /*
    $choices = array(
        'panoramic-footer-widget-amount-one' => 'One',
    	'panoramic-footer-widget-amount-two' => 'Two',
    	'panoramic-footer-widget-amount-three' => 'Three',
    	'panoramic-footer-widget-amount-four' => 'Four'
    );
    $options['panoramic-footer-widget-amount'] = array(
        'id' => 'panoramic-footer-widget-amount',
        'label'   => __( 'Number of widgets to display', 'panoramic' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'panoramic-footer-widget-amount-four'
    );
    */
    
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
    	'default' => __( 'Theme by <a href="http://www.outtheboxthemes.com">Out the Box</a>', 'panoramic' )
    );    
    
	// Adds the sections to the $options array
	$options['sections'] = $sections;

	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

	// To delete custom mods use: customizer_library_remove_theme_mods();

}
add_action( 'init', 'panoramic_customizer_library_options' );
