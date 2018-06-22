<?php
/*

Plugin Name: Header and Footer Commander
Plugin URI: http://www.trottyzone.com/product/header-and-footer-commander/
Description: Inserts text above header and/or below footer of any WordPress Site
Version: 4.1
Author: Ephrain Marchan
Author URI: http://www.trottyzone.com
License: GPL2 or later
*/

/*

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

if ( ! defined( 'ABSPATH' ) ) die();

load_plugin_textdomain('fc-menu', false, dirname(plugin_basename(__FILE__)) . '/languages/');


// Hook for adding admin menus
if ( is_admin() ){ // admin actions

  // Hook for adding admin menu
  add_action( 'admin_menu', 'fc_op_page' );

       // Hook to fire farbtastic includes for using built in WordPress color picker functionality
	add_action('admin_enqueue_scripts', 'fc_farbtastic_script');

// Display the 'Settings' link in the plugin row on the installed plugins list page
	add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'fc_admin_plugin_actions', -10);


} else { // non-admin enqueues, actions, and filters


           // hook for footer
           add_action('wp_footer', 'fc_text_inputreal');
              remove_filter( 'wp_footer', 'strip_tags' );

           // hook for header
           add_action('wp_head', 'headerthing');
           add_action('wp_head', 'fc_custom_css');
               remove_filter( 'wp_head', 'strip_tags' );

}

// Include WordPress color picker functionality
function fc_farbtastic_script($hook) {

	// only enqueue farbtastic on the plugin settings page
	if( $hook != 'settings_page_fcsettings' ) 
		return;


	// load the style and script for farbtastic
	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_script( 'farbtastic' );
        wp_enqueue_media();

}

// action function for above hook
function fc_op_page() {

    // Add a new submenu under Settings:
    add_options_page(__('Header and Footer Commander','fc-menu'), __('Header and Footer Commander','fc-menu'), 'manage_options', 'fcsettings', 'fc_settings_page');

}
// fc_settings_page() displays the page content for the Header and Footer Commander submenu
function fc_settings_page() {

    //must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    // variables for the field and option names 
    $fc_text = 'fc_input_text';
    $hidden_field_name = 'fc_submit_hidden';
    $footer_field_name = 'fc_input_text';
    $fch_text = 'fch_input_text';
    $header_field_name = 'fch_input_text';
    $fc_new_bc2 = 'fc_backgroundpick2';
    $fc_new_bc1 = 'fc_backgroundpick1';
    $hidden_name_bc1 = 'fc_background1';
    $hidden_name_bc2 = 'fc_background2';
    $fc_new_tc2 = 'fc_textpick2';
    $fc_new_tc1 = 'fc_textpick1';
    $hidden_name_tc1 = 'fc_text1';
    $hidden_name_tc2 = 'fc_text2';
    $ad_image1 = 'fc_imade1';
    $ad_image2 = 'fc_imade2';
    $fc_new_up1 = 'fc_uplo1';
    $fc_new_up2 = 'fc_uplo2';
    $cssfc_new_val = 'fc_css_get';
    $cssfc_field_name = '$cssfc_fieldget';



// Read in existing option value from database
    $fc_val = get_option( $fc_text );
$fch_val = get_option( $fch_text );
$fc_bc2 = get_option( $fc_new_bc2 );
$fc_bc1 = get_option( $fc_new_bc1 );
$fc_tc2 = get_option( $fc_new_tc2 );
$fc_tc1 = get_option( $fc_new_tc1 );
$fc_upload2 = get_option( $fc_new_up2 );
$fc_upload1 = get_option( $fc_new_up1 );
$cssfc_field_val = get_option( $cssfc_new_val );

        
     //checks to see if empty then populates values

if ($fc_bc2== '')
{
$fc_bc2 = '#fff'; }
if ($fc_bc1== '')
{
$fc_bc1 = '#fff'; }
if ($fc_tc2== '')
{
$fc_tc2 = '#aaa'; }
if ($fc_tc1== '')
{
$fc_tc1 = '#aaa'; }

// See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'

    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
          

     // Read their posted value
        $fc_val = $_POST[ $footer_field_name ];
 $fch_val = $_POST[ $header_field_name ];
 $fc_bc2 = $_POST[ $hidden_name_bc2 ];
 $fc_bc1 = $_POST[ $hidden_name_bc1 ];
 $fc_tc2 = $_POST[ $hidden_name_tc2 ];
 $fc_tc1 = $_POST[ $hidden_name_tc1 ];
 $fc_upload1 = $_POST[ $ad_image1 ];
 $fc_upload2 = $_POST[ $ad_image2 ];
 $cssfc_field_val = $_POST[ $cssfc_field_name ];
add_option('checkboxhf', TRUE);
        

        // Save the posted value in the database
        update_option( $fc_text, $fc_val );  
update_option( $fch_text, $fch_val );  
update_option( $fc_new_bc2, $fc_bc2 );
update_option( $fc_new_bc1, $fc_bc1 );
update_option( $fc_new_tc2, $fc_tc2 );
update_option( $fc_new_tc1, $fc_tc1 );
update_option( $fc_new_up1, $fc_upload1 );
update_option( $fc_new_up2, $fc_upload2 );
update_option( $cssfc_new_val , $cssfc_field_val );
update_option('checkboxhf', (bool) $_POST["checkboxhf"]);


?>

<div class="updated"><p><strong><?php _e('settings saved.', 'fc-menu' ); ?></strong></p></div>

<?php 

    }



    // Now display the settings editing screen

    echo '<div class="wrap">';
    
    // icon for settings
    
     echo '<div id="icon-plugins" class="icon32"></div>';

    // header

    echo "<h2>" . __( 'Header and Footer Commander Settings', 'fc-menu' ) . "</h2>";

    // settings form and farbtastic script on click shoot out
    
    ?>
<div style="float:left;" class="updated"><p><?php _e('<strong>Supports</strong> HTML tags such as the ( a, img, blockquote, code, em, ul ) etc... Quotes ( " ) are not allowed. <strong>Thank you</strong> for downloading and using Header and Footer Commander. Enjoy! :)', 'fc-menu' ); ?></p></div>


<form name="form1" method="post" action="">

<script type="text/javascript">

		jQuery(document).ready(function() {
			jQuery('#colorpicker1').hide();
			jQuery('#colorpicker1').farbtastic("#color1");
			jQuery("#color1").click(function(){jQuery('#colorpicker1').slideToggle()});
          
		});
                
                jQuery(document).ready(function() {
			jQuery('#colorpicker2').hide();
			jQuery('#colorpicker2').farbtastic("#color2");
			jQuery("#color2").click(function(){jQuery('#colorpicker2').slideToggle()});
                        
		});

                
		jQuery(document).ready(function() {
			jQuery('#colorpicker3').hide();
			jQuery('#colorpicker3').farbtastic("#color3");
			jQuery("#color3").click(function(){jQuery('#colorpicker3').slideToggle()});
          
		});
                
                jQuery(document).ready(function() {
			jQuery('#colorpicker4').hide();
			jQuery('#colorpicker4').farbtastic("#color4");
			jQuery("#color4").click(function(){jQuery('#colorpicker4').slideToggle()});
                        
		});

jQuery(document).ready(function($){
 
 
    var custom_uploader;
 
 
    $('#upload_image_button').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#upload_image').val(attachment.url);
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
 
 
});
                  
                
 jQuery(document).ready(function(){
 
 
    var custom_uploader2;
 
 
    jQuery('#upload_image_button2').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader2) {
            custom_uploader2.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader2 = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader2.on('select', function() {
            attachment = custom_uploader2.state().get('selection').first().toJSON();
            jQuery('#upload_image2').val(attachment.url);
        });
 
        //Open the uploader dialog
        custom_uploader2.open();
 
    });
});
                  

	</script>

<style type="text/css">
#upload_image, #upload_image2 {
width: 100%;
}
#small_fc {
font-style:italic;
font-size: 11px;
}
.submit {
padding:0;
}
</style>

<table class="widefat" border="1">
<tr valign="top">
			<th scope="row" colspan="2" width="33%"><?php _e('Click on each color field to display the color picker. Click again to close it.', 'fc-menu' ); ?></th>
			<td width="33%" rowspan="4">
				<div id="colorpicker1"></div>
                                <div id="colorpicker2"></div>
                                <div id="colorpicker3"></div>
                                <div id="colorpicker4"></div>
				
			</td>
		</tr>

<tr valign="top">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<th width="33%"><?php _e("Header Text: ", 'fc-menu' ); ?> </th>
<td width="70%"><textarea name="<?php echo $header_field_name; ?>" style="height:100px;width:100%;"><?php echo $fch_val; ?></textarea></td>
</tr>

		<tr valign="top">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
			<th scope="row"><?php _e('Background color', 'fc-menu' ); ?></th>
			<td width="33%"><input type="text" maxlength="7" size="6" value="<?php echo esc_attr( $fc_bc1 ); ?>" name="<?php echo $hidden_name_bc1; ?>" id="color1" /></td>
		</tr>

                <tr valign="top">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
			<th scope="row"><?php _e('Text color', 'fc-menu' ); ?></th>
			<td width="33%"><input type="text" maxlength="7" size="6" value="<?php echo esc_attr( $fc_tc1 ); ?>" name="<?php echo $hidden_name_tc1; ?>" id="color2" /></td>
		</tr>

<tr valign="top">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<th scope="row"><?php _e('Choose Image', 'fc-menu' ); ?></th>
<td><label for="upload_image">
<input id="upload_image" type="text" size="36" name="<?php echo $ad_image1; ?>" value="<?php echo $fc_upload1; ?>" /> 
<input id="upload_image_button" class="button" type="button" value="Upload Image" />
<br /><?php _e('Enter an URL, upload or select an existing image for the banner.', 'fc-menu' ); ?>
</label></td>
</tr>


<tr valign="top">
			<th scope="row" ></th>
			<td width="33%" ></td>
		</tr>



<tr valign="top">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<th width="33%"><?php _e('Footer Text: ', 'fc-menu' ); ?>  </th>
<td width="70%"><textarea name="<?php echo $footer_field_name; ?>" style="height:100px;width:100%;"><?php echo $fc_val; ?></textarea>
</td>
</tr>


                 <tr valign="top">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
			<th scope="row"><?php _e('Background color', 'fc-menu' ); ?> </th>
			<td width="33%"><input type="text" maxlength="7" size="6" value="<?php echo esc_attr( $fc_bc2 ); ?>" name="<?php echo $hidden_name_bc2; ?>" id="color3" /></td>
		</tr>
                
                <tr valign="top">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
			<th scope="row"><?php _e('Text color', 'fc-menu' ); ?> </th>
			<td width="33%"><input type="text" maxlength="7" size="6" value="<?php echo esc_attr( $fc_tc2 ); ?>" name="<?php echo $hidden_name_tc2; ?>" id="color4" /></td>
		</tr>


<tr valign="top">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<th scope="row"><?php _e('Choose Image', 'fc-menu' ); ?></th>
<td><label for="upload_image">
<input id="upload_image2" type="text" size="36" name="<?php echo $ad_image2; ?>" value="<?php echo $fc_upload2; ?>" /> 
<input id="upload_image_button2" class="button" type="button" value="Upload Image" />
<br /><?php _e('Enter an URL, upload or select an existing image for the banner.', 'fc-menu' ); ?>
</label></td>
</tr>
  

<tr valign="top">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<th width="33%"><?php _e('Custom CSS:', 'fc-menu' ); ?><br><div id="small_fc"><?php _e('Need some help with that? Get support at our <a href="http://www.trottyzone.com/forums/forum/wordpress-themes-and-templates/">forum</a>.', 'fc-menu' ); ?></div></th>
<td width="70%"><textarea name="<?php echo $cssfc_field_name; ?>" style="height:400px;width:100%;"><?php echo $cssfc_field_val; ?></textarea></td>
</tr>
            

<tr valign="top">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<th width="33%"><?php _e('Check to Enable Both Options: ', 'fc-menu' ); ?>
<input type="checkbox" name="checkboxhf" value="checkbox" <?php if (get_option('checkboxhf')) echo "checked='checked'"; ?>/>
<br><div id="small_fc"><?php _e('Alternatively Leave any field blank if you want it disable.', 'fc-menu' ); ?></div></th>

<td width="33%"><?php submit_button(); ?>
<a href="http://www.trottyzone.com/donate/"><?php _e('Contribute', 'fc-menu' ); ?></a><?php _e(' to this fine work', 'fc-menu' ); ?>. :)
</td></tr>

</form>
</table>
<?php }


// Build array of links for rendering in installed plugins list
function fc_admin_plugin_actions($links) {

$fc_plugin_links = array(
          '<a href="options-general.php?page=fcsettings">'.__('Settings').'</a>',
           '<a href="http://www.trottyzone.com/forums/forum/website-support/">'.__('Support').'</a>', 
                             );

	return array_merge( $fc_plugin_links, $links );

}

// Display footer
      function fc_text_inputreal() {
        if(True== get_option('checkboxhf'))
             echo '<div class="footertext" align="center" style="background-image:url('.get_option('fc_uplo2').');background-color:'.get_option('fc_backgroundpick2').';color:'.get_option('fc_textpick2').';">'.get_option('fc_input_text').'</div>';
}

// Display header
      function headerthing() {
         if(True== get_option('checkboxhf'))
              echo '<div class="headertext" align="center" style="background-image:url('.get_option('fc_uplo1').');background-color:'.get_option('fc_backgroundpick1').';color:'.get_option('fc_textpick1').';">'.get_option('fch_input_text').'</div>';
}

// custom css support
      function fc_custom_css() {
 if(True== get_option('checkboxhf'))
echo '<style type="text/css">#plugin_hd_credit { clear:both;display:none; } '.get_option('fc_css_get').'</style>';
}