<?php
/**
 * Plugin Name: TG Facebook Meta Tags
 * Plugin URI : http://www.tekgazet.com/tg-facebook-meta-tags-plugin
 * Description: Add Facebook Open Graph meta tags to your posts so that image and other details are shown properly when your content is shared on Facebook.
 * Version: 1.0
 * Author: Ashok Dhamija
 * Author URI: http://tilakmarg.com/dr-ashok-dhamija/
 * License: GPLv2 or later
 */
 
 /*
  Copyright 2015 Ashok Dhamija web: http://tilakmarg.com/dr-ashok-dhamija/

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
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
 
// Add a menu for our option page
add_action('admin_menu', 'tg_facebook_meta_tags_add_page');
function tg_facebook_meta_tags_add_page() {
	add_options_page( 'TG Facebook Meta Tags Plugin', 'TG Facebook Meta Tags', 'manage_options', 'tg_facebook_meta_tags', 'tg_facebook_meta_tags_option_page' );
}

// Draw the option page
function tg_facebook_meta_tags_option_page() {
	
	//Check if it is first time after installation, if so, set default values
	$valid = array();
	$valid = get_option( 'tg_facebook_meta_tags_options' );
	if( !$valid ) {	
		$valid['sitename'] = 1;
		$valid['title'] = 1;
		$valid['url'] = 1;
		$valid['description'] = 1;
		$valid['image'] = 1;
		$valid['imagedefault'] = '';
				
		update_option( 'tg_facebook_meta_tags_options', $valid );
	}
	
	?>
	<div class="wrap">
		<h2>TG Facebook Meta Tags Page</h2>
		<form action="options.php" method="post">
			<?php settings_fields('tg_facebook_meta_tags_options'); ?>
			<?php do_settings_sections('tg_facebook_meta_tags'); ?>
			<input name="Submit" type="submit" value="Save Changes" />
			<input name="Submit2" type="submit" value="Reset to Default Values" />	
			<input name="Submit3" type="submit" value="Cancel changes" />
		</form>
	</div>
	<?php
}

// Register and define the settings
add_action('admin_init', 'tg_facebook_meta_tags_admin_init');
function tg_facebook_meta_tags_admin_init(){
	register_setting(
		'tg_facebook_meta_tags_options',
		'tg_facebook_meta_tags_options',
		'tg_facebook_meta_tags_validate_options'
	);
	
	add_settings_section(
		'tg_facebook_meta_tags_about',
		'About the plugin - TG Facebook Meta Tags',
		'tg_facebook_meta_tags_section_about_text',
		'tg_facebook_meta_tags'
	);
		
	add_settings_section(
		'tg_facebook_meta_tags_main',
		'Plugin Settings',
		'tg_facebook_meta_tags_section_text',
		'tg_facebook_meta_tags'
	);

	add_settings_field(
		'tg_facebook_meta_tags_sitename',
		'Add Meta Tag for site-name?',
		'tg_facebook_meta_tags_setting_input_sitename',
		'tg_facebook_meta_tags',
		'tg_facebook_meta_tags_main'
	);
	
	add_settings_field(
		'tg_facebook_meta_tags_title',
		'Add Meta Tag for title of post being shared?',
		'tg_facebook_meta_tags_setting_input_title',
		'tg_facebook_meta_tags',
		'tg_facebook_meta_tags_main'
	);
	
	add_settings_field(
		'tg_facebook_meta_tags_url',
		'Add Meta Tag for URL or link of post being shared?',
		'tg_facebook_meta_tags_setting_input_url',
		'tg_facebook_meta_tags',
		'tg_facebook_meta_tags_main'
	);
	
	add_settings_field(
		'tg_facebook_meta_tags_description',
		'Add Meta Tag for brief description of post being shared?',
		'tg_facebook_meta_tags_setting_input_description',
		'tg_facebook_meta_tags',
		'tg_facebook_meta_tags_main'
	);
			
	add_settings_field(
		'tg_facebook_meta_tags_image',
		'Add Meta Tag for image for post being shared?',
		'tg_facebook_meta_tags_setting_input_image',
		'tg_facebook_meta_tags',
		'tg_facebook_meta_tags_main'
	);
	
	add_settings_field(
		'tg_facebook_meta_tags_imagedefault',
		'Upload a new Image or select an image from media library for default image to be shown with Facebook shares:',
		'tg_facebook_meta_tags_setting_input_imagedefault',
		'tg_facebook_meta_tags',
		'tg_facebook_meta_tags_main'
	);
	
}

// Draw the section header
function tg_facebook_meta_tags_section_about_text() {
	echo '<p><b>TG Facebook Meta Tags</b> is a plugin developed by <a href="http://tilakmarg.com/dr-ashok-dhamija/" target="_blank">Ashok Dhamija</a>. For any help or support issues, please leave your comments at <a href="http://www.tekgazet.com/tg-facebook-meta-tags-plugin" target="_blank">TG Facebook Meta Tags Plugin Page</a>, where you can also read more about the detailed functioning of this plugin. If you like this plugin, please vote favorably for it at its <a href="https://wordpress.org/plugins/tg-facebook-meta-tags/" target="_blank">WordPress plugin page</a>.</p><p>Many a time, when someone shares content on Facebook, either no image is shown or wrong image is shown or image of wrong size is shown. Likewise, sometimes, wrong brief description of the content is shown. This plugin adds appropriate Facebook Open Graph meta tags in the HTML code of your website so that image and other details could be shown properly when your content is shared on Facebook. You can continue to use any sharing buttons or methods, this plugin will insert the correct meta tags for Facebook sharing in the html code of your posts.</p><hr />';
}


// Draw the section header
function tg_facebook_meta_tags_section_text() {
	echo '<p>Enter your settings here. You can change these settings any time later. In most situations, the default settings may be sufficient and you may not require to change them. Of course, you may still have to provide a default image in the last setting.</p>';
	//Display the Save Changes and Reset buttons at the top
	echo '<input name="Submit" type="submit" value="Save Changes" />  ';
	echo '<input name="Submit2" type="submit" value="Reset to Default Values" />  ';	
	echo '<input name="Submit3" type="submit" value="Cancel changes" />';
}

// Display and fill the form field
function tg_facebook_meta_tags_setting_input_sitename() {
	// get option 'sitename' value from the database
	$options = get_option( 'tg_facebook_meta_tags_options' );
	$sitename = $options['sitename'];
	
	// echo the field	
	$msg1 = '<input type="checkbox" id="sitename" name="tg_facebook_meta_tags_options[sitename]" value="1"' . checked( 1, $sitename, false ) . '/>';
    echo $msg1;
	echo '<p>Select it to add meta tag for your site-name. The site-name will be automatically taken from your WordPress settings.<p>';
}

// Display and fill the form field
function tg_facebook_meta_tags_setting_input_title() {
	// get option 'title' value from the database
	$options = get_option( 'tg_facebook_meta_tags_options' );
	$title = $options['title'];
	// echo the field
	$msg1 = '<input type="checkbox" id="title" name="tg_facebook_meta_tags_options[title]" value="1"' . checked( 1, $title, false ) . '/>';
    echo $msg1;
	echo '<p>Select it to add meta tag for the title of your post being displayed. It will be automatically taken from your post.<p>';
}

// Display and fill the form field
function tg_facebook_meta_tags_setting_input_url() {
	// get option 'url' value from the database
	$options = get_option( 'tg_facebook_meta_tags_options' );
	$url = $options['url'];
	// echo the field
	$msg1 = '<input type="checkbox" id="url" name="tg_facebook_meta_tags_options[url]" value="1"' . checked( 1, $url, false ) . '/>';
    echo $msg1;
	echo '<p>Select it to add meta tag for the URL of your post being displayed. It will be automatically taken from your post.<p>';
}

// Display and fill the form field
function tg_facebook_meta_tags_setting_input_description() {
	// get option 'description' value from the database
	$options = get_option( 'tg_facebook_meta_tags_options' );
	$description = $options['description'];
	// echo the field
	$msg1 = '<input type="checkbox" id="description" name="tg_facebook_meta_tags_options[description]" value="1"' . checked( 1, $description, false ) . '/>';
    echo $msg1;
	echo '<p>Select it to add meta tag for the description of your post being displayed. It is automatically taken from the <b>Excerpt</b> of your post. <a href="http://www.tekgazet.com/what-is-excerpt-in-wordpress-and-how-to-add-it-manually-for-a-post/wordpress2/2863.html" target="_blank">Learn more</a> about what is <b>Excerpt</b> and how to add it manually for a post in WordPress. If no excerpt has been added manually, and if your theme does not create automatic excerpts in posts, then this plugin will automatically create a 55-word description on-the-fly from the beginning of the post.<p>';
}

// Display and fill the form field
function tg_facebook_meta_tags_setting_input_image() {
	// get option 'image' value from the database
	$options = get_option( 'tg_facebook_meta_tags_options' );
	$image = $options['image'];
	// echo the field
	$msg1 = '<input type="checkbox" id="image" name="tg_facebook_meta_tags_options[image]" value="1"' . checked( 1, $image, false ) . '/>';
    echo $msg1;
	echo '<p>Select it to add meta tag for displaying an image with your post being displayed. If selected, preference will be given to <b>featured</b> or <b>thumbnail</b> image for the post to be added as meta tag image for that post. However, if no featured image is found for a post, the default image (set in the next option) will be added as meta tag for that post. <a href="http://www.tekgazet.com/what-is-featured-or-thumbnail-image-in-wordpress-and-how-to-set-it-for-a-post/wordpress2/2864.html" target="_blank">Learn more</a> about how to set featured image for a post in WordPress.<p>';
}

add_action( 'wp_enqueue_scripts', 'tg_facebook_meta_tags_scripts' );
function tg_facebook_meta_tags_scripts() {
	// jQuery
	wp_enqueue_script('jquery');
}
add_action( 'admin_enqueue_scripts', 'tg_facebook_meta_tags_scripts2' );
function tg_facebook_meta_tags_scripts2() {
	// This will enqueue the Media Uploader script
	wp_enqueue_media();
}

// Display and fill the form field
function tg_facebook_meta_tags_setting_input_imagedefault() {
	// get option 'imagedefault' value from the database
	$options = get_option( 'tg_facebook_meta_tags_options' );
	$imagedefault = $options['imagedefault'];
	// echo the field
	//echo "<input id='imagedefault' size='70' name='tg_facebook_meta_tags_options[imagedefault]' type='text' value='$imagedefault' />";
	echo "<input id='imagedefault' size='70' name='tg_facebook_meta_tags_options[imagedefault]' type='text' value='$imagedefault' />";
	echo '<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload New Image">' ;
	echo '<p>Click <b>Upload New Image</b> button above to upload an image or select an existing image from the media library; its URL path will be filled up automatically. Or, alternatively, manually enter the full URL path of an image here, but, in that case, please ensure that the URL specified here actually has the desired image. The image uploaded or selected here will be shown as default image in the meta tags if no specific featured or thumbnail image is set for an individual post. </p><p><b>Note:</b> For best results, the default image should generally be of the size of 1200 x 630 pixels for best displays on high resolution devices. At the minimum, you should use images that are 600 x 315 pixels to display links to posts with larger images. If you use an image of some other size, try to keep your image as close to 1.91:1 aspect ratio as possible to display the full image in Facebook News Feed without any cropping. The minimum image size is 200 x 200 pixels, otherwise it may not appear or may not appear properly.<p>';
 
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#upload-btn').click(function(e) {
			e.preventDefault();
			var image = wp.media({ 
				title: 'Upload Image',
				// mutiple: true if you want to upload multiple files at once
				multiple: false
			}).open()
			.on('select', function(e){
				// This will return the selected image from the Media Uploader, the result is an object
				var uploaded_image = image.state().get('selection').first();
				// We convert uploaded_image to a JSON object to make accessing it easier
				// Output to the console uploaded_image
				console.log(uploaded_image);
				var imagedefault = uploaded_image.toJSON().url;
				// Let's assign the url value to the input field
				$('#imagedefault').val(imagedefault);
			});
		});
	});
	</script>
	<?php	
}

// Validate user input 
function tg_facebook_meta_tags_validate_options( $input ) {		
	$valid = array();	
	$options = get_option( 'tg_facebook_meta_tags_options' );

	//Reset to default values, if needed
	if ( isset( $_POST['Submit2'] ) ) 
	{ 
		$valid['sitename'] = 1;
		$valid['title'] = 1;
		$valid['url'] = 1;
		$valid['description'] = 1;
		$valid['image'] = 1;
		$valid['imagedefault'] = '';	
		
		//Show message for defaults restored
		add_settings_error(
			'tg_facebook_meta_tags_option_page',
			'tg_facebook_meta_tags_texterror',
			'Default values have been restored.',
			'updated'
			);	
			
		return $valid;
	}

	//Cancel changes, if needed
	if ( isset( $_POST['Submit3'] ) ) 
	{ 		
		$valid['sitename'] = $options['sitename'] ;
		$valid['title'] = $options['title'] ;
		$valid['url'] = $options['url'] ;
		$valid['description'] = $options['description'] ;
		$valid['image'] = $options['image'] ;
		$valid['imagedefault'] = $options['imagedefault'] ;
						
		//Show message for defaults restored
		add_settings_error(
			'tg_facebook_meta_tags_option_page',
			'tg_facebook_meta_tags_texterror',
			'Cancelled the changes made.',
			'updated'
			);	
			
		return $valid;
	}	
	
	//check whether imagedefault is correctly entered
	$valid['imagedefault'] = esc_url( $input['imagedefault'] );	
	if( $valid['imagedefault'] != $input['imagedefault'] ) {
		//restore the old value
		$valid['imagedefault'] = $options['imagedefault'] ;
		//set error
		add_settings_error(
			'tg_facebook_meta_tags_imagedefault',
			'tg_facebook_meta_tags_texterror',
			'Error: Please enter a valid URL for the default image. Changes made have been cancelled.',
			'error'
		);		
	}
		
	$valid['sitename'] = $input['sitename'] ;
	$valid['title'] = $input['title'] ;
	$valid['url'] = $input['url'] ;
	$valid['description'] = $input['description'] ;
	$valid['image'] = $input['image'] ;
	//$valid['imagedefault'] = $input['imagedefault'] ;
				
	return $valid;		
}


add_action( 'wp_head', 'tg_facebook_meta_tags_add_metatags' );

function tg_facebook_meta_tags_add_metatags() {
  if( is_single() ) {
	$options = get_option( 'tg_facebook_meta_tags_options' );
	
	$output = '' ;
	$atleastone = '' ;
	
	if ( ( $options['sitename'] == 1) || ( $options['title'] == 1) || ( $options['url'] == 1) || ( $options['description'] == 1) || ( 		$options['image'] == 1) ) { 
		$output = PHP_EOL . '<!-- Following meta-tags generated by TG Facebook Meta Tags Plugin : http://www.tekgazet.com/tg-facebook-meta-tags-plugin --> ' .PHP_EOL ;
		
		$output .= '<link rel="canonical" href="' . get_permalink() . '" /> ' . PHP_EOL ;
		$atleastone = 1 ;
	}	
		
	if ( $options['url'] == 1) {  
		$output .= '<meta property="og:url" content="' . get_permalink() . '" /> ' . PHP_EOL ;
		
	}	
	
	if ( $atleastone == 1) {  	
		$output .= '<meta property="og:type" content="article" /> ' . PHP_EOL ;	
	}
	
	if ( $options['title'] == 1) {  
		$output .= '<meta property="og:title" content="' . get_the_title() . '" /> ' . PHP_EOL ;
		
	}
	
	if ( $options['sitename'] == 1) {  
		$output .= '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '" /> ' . PHP_EOL ;
		
	}	
	
	if ( $options['description'] == 1) {  
		$excerpt = get_queried_object()->post_excerpt;
		if ( $excerpt == '') {
			$text = strip_shortcodes( get_queried_object()->post_content );
            $text = apply_filters('the_content', $text);
            $text = str_replace(']]>', ']]&gt;', $text);
            $text = addslashes( strip_tags($text) );
           	$excerpt = tg_facebook_meta_tags_create_excerpt ( $text );				
		}	
		$output .= '<meta property="og:description" content="' . $excerpt . '" /> ' . PHP_EOL ;
		
	}
		
    if ( $options['image'] == 1) {  
		if ( has_post_thumbnail() ){
			$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' ); 
			$output .= '<meta property="og:image" content="' . $image[0] . '"/> ' . PHP_EOL ;
			
		}
		else {	//set default image
			if ($options['imagedefault'] != '') { 
				$output .= '<meta property="og:image" content="' . $options['imagedefault'] . '"/> ' . PHP_EOL . PHP_EOL ;
				
			}	
		}
	}
	
	echo $output ;	
  }
}


function tg_facebook_meta_tags_create_excerpt( $content, $length = 55 ){
    $the_string = preg_replace( '#\s+#', ' ', $content );
    $words = explode( ' ', $the_string );
    if( count($words) <= $length ) {
        $result = $content;
	}
    else {
        $result = implode( ' ', array_slice( $words, 0, $length ) );
		$result .= '...' ;
	}
    return $result;
}


?>
