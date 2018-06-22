<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'market'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	$options = array();
	$imagepath =  get_template_directory_uri() . '/images/';
	
	//Basic Settings
	
	$options[] = array(
		'name' => __('Basic Settings', 'market'),
		'type' => 'heading');
			
	$options[] = array(
		'name' => __('Site Logo', 'market'),
		'desc' => __('Leave Blank to use text Heading.', 'market'),
		'id' => 'logo',
		'class' => '',
		'type' => 'upload');	
		
	$options[] = array(
		'name' => __('Copyright Text', 'market'),
		'desc' => __('Some Text regarding copyright of your site, you would like to display in the footer.', 'market'),
		'id' => 'footertext2',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'desc' => __('To have more customization options including Multiple Colors, Favicon, Analytics, Custom Header/Footer Scripts <a href="http://rohitink.com/product/market-pro/" target="_blank">Upgrade to Pro</a> at Just $24.95'),
		'std' => '',
		'type' => 'info');	
		
				
	//Design Settings
		
	$options[] = array(
		'name' => __('Layout Settings', 'market'),
		'type' => 'heading');	
	
	$options[] = array(
		'name' => "Sidebar Layout",
		'desc' => __('Select Layout for Posts & Pages.', 'market'),
		'id' => "sidebar-layout",
		'std' => "right",
		'type' => "images",
		'options' => array(
			'left' => $imagepath . '2cl.png',
			'right' => $imagepath . '2cr.png')
	);
	
	$options[] = array(
		'desc' => __('To have more Layout options including Color Schemes, Full Width Posts, Accessibility Settings to Darken Colors, etc <a href="http://rohitink.com/product/market-pro/" target="_blank">Upgrade to Pro</a> at Just $24.95'),
		'class' => 'upgrade-notice',
		'type' => 'info');
	
	$options[] = array(
		'name' => __('Custom CSS', 'market'),
		'desc' => __('Some Custom Styling for your site. Place any css codes here instead of the style.css file.', 'market'),
		'id' => 'style2',
		'std' => '',
		'type' => 'textarea');
	
	//SLIDER SETTINGS

	$options[] = array(
		'name' => __('Slider Settings', 'market'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Enable Slider', 'market'),
		'desc' => __('Check this to Enable Slider.', 'market'),
		'id' => 'slider_enabled',
		'type' => 'checkbox',
		'std' => '0' );
		
	$options[] = array(
		'desc' => __('Market Pro\'s Slider comes with Option to add Unlimited Slides, Choose Pages where to display them, Select Animation, Speed, Duration, etc. <a href="http://rohitink.com/product/market-pro/" target="_blank">Upgrade to Pro</a> at Just $24.95'),
		'class' => 'upgrade-notice',
		'type' => 'info');	
		
	$options[] = array(
		'name' => __('Using the Slider', 'market'),
		'desc' => __('This Slider supports upto 3 Images. To show only 2 Slides in the slider, upload only 2 images. Leave the rest Blank. For best results, upload images of same size.', 'market'),
		'type' => 'info');		
		
	$options[] = array(
		'name' => __('Slider Image 1', 'market'),
		'desc' => __('First Slide', 'market'),
		'id' => 'slide1',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'market'),
		'id' => 'slidetitle1',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'market'),
		'id' => 'slidedesc1',
		'std' => '',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'market'),
		'id' => 'slideurl1',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slider Image 2', 'market'),
		'desc' => __('Second Slide', 'market'),
		'class' => '',
		'id' => 'slide2',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'market'),
		'id' => 'slidetitle2',
		'std' => '',
		'type' => 'text');	
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'market'),
		'id' => 'slidedesc2',
		'std' => '',
		'type' => 'textarea');		
		
	$options[] = array(
		'desc' => __('Url', 'market'),
		'id' => 'slideurl2',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Slider Image 3', 'market'),
		'desc' => __('Third Slide', 'market'),
		'id' => 'slide3',
		'class' => '',
		'type' => 'upload');	
	
	$options[] = array(
		'desc' => __('Title', 'market'),
		'id' => 'slidetitle3',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Description or Tagline', 'market'),
		'id' => 'slidedesc3',
		'std' => '',
		'type' => 'textarea');	
			
	$options[] = array(
		'desc' => __('Url', 'market'),
		'id' => 'slideurl3',
		'std' => '',
		'type' => 'text');			
			
	//Social Settings
	
	$options[] = array(
	'name' => __('Social Settings', 'market'),
	'type' => 'heading');

	$options[] = array(
		'desc' => __('Market Pro has many more social Icons, and we also add your custom icons on request. <a href="http://rohitink.com/product/market-pro/" target="_blank">Upgrade to Pro</a> at Just $24.95'),
		'std' => '',
		'type' => 'info');

	$options[] = array(
		'name' => __('Facebook', 'market'),
		'desc' => __('Facebook Profile or Page URL i.e. http://facebook.com/username/ ', 'market'),
		'id' => 'facebook',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Twitter', 'market'),
		'desc' => __('Twitter Username', 'market'),
		'id' => 'twitter',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Google Plus', 'market'),
		'desc' => __('Google Plus profile url, including "http://"', 'market'),
		'id' => 'google',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Feeburner', 'market'),
		'desc' => __('URL for your RSS Feeds', 'market'),
		'id' => 'feedburner',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Pinterest', 'market'),
		'desc' => __('Your Pinterest Profile URL', 'market'),
		'id' => 'pinterest',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Instagram', 'market'),
		'desc' => __('Your Instagram Profile URL', 'market'),
		'id' => 'instagram',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Linked In', 'market'),
		'desc' => __('Your Linked In Profile URL', 'market'),
		'id' => 'linkedin',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Youtube', 'market'),
		'desc' => __('Your Youtube Channel URL', 'market'),
		'id' => 'youtube',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Flickr', 'market'),
		'desc' => __('Your Flickr Profile URL', 'market'),
		'id' => 'flickr',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');							
		
	$options[] = array(
		'name' => __('Support', 'market'),
		'type' => 'heading');
	
	$options[] = array(
		'desc' => __('Market WordPress theme has been Designed and Created by <a href="http://rohitink.com" target="_blank">Rohit Tripathi</a>. For any Queries or help regarding this theme, <a href="http://wordpress.org/support/theme/market/" target="_blank">use the free version support forums</a>.', 'market'),
		'type' => 'info');		
		
	$options[] = array(
		'name' => __('Live Demo Blog', 'market'),
		'desc' => __('For your convenience, we have created a <a href="http://demo.inkhive.com/market/" target="_blank">Live Demo Blog of Market</a>. You can take a look at and find out how your site would look once complete.', 'market'),
		'type' => 'info');	
		
	 $options[] = array(
	 	'name' => __('Follow Me','market'),
		'desc' => __('<a href="http://twitter.com/rohitinked" target="_blank">Follow Me on Twitter</a> or <a href="http://plus.google.com/+RohitTripathi/" target="_blank">Add Me to your Circles on Google Plus</a> to know about my upcoming themes.', 'market'),
		'type' => 'info');	
		
	$options[] = array(
		'name' => __('Improve this Theme', 'market'),
		'type' => 'heading');
	
	$options[] = array(
		'desc' => __('Market is my first eCommerce theme. So, if there are any suggestions for this theme. Please feel free to visit my blog <a href="http://rohitink.com" target="_blank">and Drop a Suggestion</a>.', 'market'),
		'type' => 'info');		
		
	return $options;
}