<?php
/*
Plugin Name: Contact Form by Best Contact Form, LLC
Plugin URI: http://www.bestcontactform.com/wordpress.php
Description: Easy Contact Forms that track Keyword data. Look under Dashboard for "Best Contact Form". 
Version: 2.01
Author: Best Contact Form LLC
Author URI: http://www.bestcontactform.com
*/
/*  Copyright 2008  Brian Gruber  (email : brian@briangruber.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*****************
*  ADD HOOKS
******************/
// add tracking code hook
add_action('wp_footer', 'bcf_print_tracking_code');

// Hook for adding admin menus
add_action('admin_menu', 'bcf_add_option_menus');

// Add Filters
add_filter('the_content','bcf_filter_form_code');

// get the url for use of graphics
$bcf_wp_url = get_bloginfo('wpurl').'/wp-content/plugins/best_contact_form/';

function bcf_add_option_menus()
{
	// add to dashboard
	if (current_user_can('administrator')) {
	 add_menu_page( 'Best Contact Form', 'Best Contact Form', 'administrator', 'best_contact_form_slug', bcf_print_main_page, 'https://www.bestcontactform.com/graphics/wp_icon.png','3.101');
	}
	// add the options page
	//add_options_page('Best Contact Form Settings', 'Best Contact Form', 8, __FILE__, 'bcf_manage_options');
}

register_activation_hook( __FILE__, 'bcf_plugin_activate' );
register_deactivation_hook( __FILE__, 'bcf_plugin_deactivate' );
register_uninstall_hook( __FILE__, 'bcf_plugin_uninstall' );

function bcf_redirect_setup(){
if (get_option('BCF_Needs_Setup')=='Plugin-Slug') {
	// show once
	delete_option('BCF_Needs_Setup');
   
	// redirect
	header('location: admin.php?page=best_contact_form_slug');
	exit;
	}
}

bcf_redirect_setup();
function bcf_plugin_uninstall()
{
	delete_option('BCF_Needs_Setup');
	
	$type = 'wordpress_uninstall';
	$url = 'bestcontactform.com/json.event.php?t=' . $type . '&o1=' . urlencode(site_url());
	bcf_track_url_curl($url);
}
function bcf_plugin_activate()
{
	// tell lucky that plugin was activated
	 add_option('BCF_Activate_Plugin','Plugin-Slug');
	 add_option('BCF_Needs_Setup','Plugin-Slug');
	  
}
function bcf_plugin_deactivate()
{
	// tell lucky that plugin was deactivated
	// add_option('Lucky_Deactivate_Plugin','Plugin-Slug');
	delete_option('BCF_Needs_Setup');
	
	$type = 'wordpress_deactivate';
	$url = 'bestcontactform.com/json.event.php?t=' . $type . '&o1=' . urlencode(site_url());
	bcf_track_url_curl($url);
}

add_action('admin_init','bcf_load_plugin');
function bcf_load_plugin() {
	
    if(is_admin())
	{
		if (get_option('BCF_Activate_Plugin')=='Plugin-Slug') {
			delete_option('BCF_Activate_Plugin');
			/* do stuff once right after activation */
			bcf_track_event('wordpress_activate');
			
			
		}
		
	}
	
}

function bcf_track_url_curl($url)
{
	$ch = @curl_init(); // create cURL handle ( )
	if ( $ch && $url) {
		// curl okay
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		// grab URL and pass it to the browser
		curl_exec($ch);

		// close cURL resource, and free up system resources
		curl_close($ch);
	}	

}
function bcf_print_main_page()
{
	
	echo '<iframe src="http://www.bestcontactform.com/members.php?wp=1&l=' . urlencode(get_bloginfo('url')) . '" width="100%" height="100%" style="min-height:850px; width:100%" frameborder=0 ></iframe>';
}
function bcf_track_event($type)
{
	$type = urlencode($type);
	
	
	 echo '<script>(function() {
		var wa = document.createElement(\'script\'); wa.type = \'text/javascript\'; wa.async = false;
		wa.src = (\'https:\' == document.location.protocol ? \'https://www\' : \'http://www\') + \'.bestcontactform.com/json.event.php?t=' . $type . '&o1=\' + encodeURIComponent(\'' . site_url() . '\');
		var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(wa, s);
	  })();
	  </script>
	  ';

    
}


function bcf_filter_form_code($content)
{
	// this code will    	
		$form_code = stripslashes(get_option( 'bcf_form_code' ));
	    $conv_code = stripslashes(get_option( 'bcf_conversion_code' ));
		
		// replace form code template
		$content=str_replace('{BCF_FORM}',$form_code,$content);
		
		// replace conversion code template
		$content=str_replace('{BCF_CONVERSION}',$conv_code,$content);

		
    
    return $content;
}

function bcf_print_tracking_code()
{
	// This function will output the BestContactForm tracking code near the bottom of the page.
	// Hooked Action: wp_footer 
	//
	
	?><script type="text/javascript"> 
(function() {
    var bca = document.createElement('script'); bca.type = 'text/javascript'; bca.async = true;
    bca.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'www.bestcontactform.com/script/code.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(bca, s);
  })();
</script>
<?
	

}
?>