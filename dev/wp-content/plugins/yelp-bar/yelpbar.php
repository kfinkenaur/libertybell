<?php
/*
Plugin Name: Yelp Bar
Plugin URI:
Description: A simple bar that sticks to the top of the window displaying a Yelp rating & review link.
Version: 1.3
Author: Noel Tock
Author URI: http://www.happytables.com
License: GPLv2

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Define Yelp Bar Version
// -----------------------------------------
    define ( 'THEMEFORCE_YELPBAR_VERSION', '1.3' );

// Actions
// -----------------------------------------
    add_action('admin_menu', 'themeforce_yelpbar_add_page');
    add_action('admin_init', 'themeforce_yelpbar_init' );
    add_action('wp_print_styles', 'load_yelpbar_css');
    add_action('wp_print_scripts', 'load_yelpbar_js');
    add_action('admin_print_styles', 'load_yelpbar_admin_css');
    add_action('wp_head', 'themeforce_yelpbar_control');

// Load CSS & JS Files
// -----------------------------------------
    function load_yelpbar_css() {
        wp_enqueue_style('yelpbar', plugins_url('css/yelpbar.css', __FILE__));
        }

    function load_yelpbar_admin_css() {
        echo '<link rel="stylesheet" href="'. plugins_url('css/yelpadmin.css', __FILE__) . '" type="text/css" />'."\n";
        }

    function load_yelpbar_js() {
        if( !wp_script_is( 'jquery' )) {
            wp_enqueue_script('jquery');}
        }

// Settings API
// -----------------------------------------

// - add defaults upon registration -

    if (get_option('themeforce_yelpbar_options')=='') {
    register_activation_hook(__FILE__, 'themeforce_yelpbar_defaults');
    }

    function themeforce_yelpbar_defaults() {
        $arr = array('activation'=>'No', 'setting_country' => 'US', 'setting_txtone' => 'users have rated our establishment', 'setting_txttwo' => 'through');
        update_option('themeforce_yelpbar_options', $arr);
    }

// - register options page -
    function themeforce_yelpbar_add_page() {
        add_options_page('Yelp Bar', 'Yelp Bar', 'manage_options', 'themeforce_yelpbar', 'themeforce_yelpbar_options_page');
        }

// - yelp status -

    function themeforce_yelpbar_status() {
    themeforce_yelpbar_forcetransient();
    $options = get_option('themeforce_yelpbar_options');
    $api = $options['setting_api'];
    if ($api == '') {
        echo 'neutral"><div class="yelpstatus"><img src ="' . plugins_url( 'images/neutral.png', __FILE__) . '" /></div><strong>Status:</strong> No API Connection attempted (no key)';
        } else {
        $yelp = themeforce_yelpbar_transient();
        if ($yelp->message->text == 'OK') {
            echo 'activated"><div class="yelpstatus"><img src ="' . plugins_url( 'images/active.png', __FILE__) . '" /></div><strong>Status:</strong> Connected to API. Don\'t forget to <a href="http://wordpress.org/extend/plugins/yelp-bar" target="_blank">rate the plugin</a>, thanks!';
            } else {
            echo 'deactivated"><div class="yelpstatus"><img src ="' . plugins_url( 'images/unactive.png', __FILE__) . '" /></div><strong>Status:</strong> Could not connect to Yelp API (Error: ' . $yelp->message->text . ')';
            }
        }
    }

// - populate options page -
    function themeforce_yelpbar_options_page() {
        ?>
        <div class="wrap" style="width:500px;">
            <?php screen_icon() ?>
            <h2>Yelp Bar</h2>

            <div id="themeforce-yelpbar" style="overflow:auto;">
			
                    <div class="yelpapi <?php themeforce_yelpbar_status(); ?></div>
                    <form action="options.php" method="post">
						<?php settings_fields('themeforce_yelpbar_options'); ?>
						<?php do_settings_sections('themeforce_yelpbar'); ?>
						<br />
						<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
                    </form>
					
			</div>
				
                <br />
				
			<div class="themeforce">
			
				<p>Do you manage a <strong>Restaurant, Pub or Cafe website</strong>? We provide solutions that allow you to easily manage your <strong>Food Menu, Events, Social Proof and more!</strong> Check us out.</p>
				<div class="themelinks"><a href="http://www.happytables.com/?utm_source=wordpress&utm_medium=plugin&utm_campaign=yelpbar" target="_blank"><img src ="<?php echo plugins_url( 'images/themeforce.jpg', __FILE__) ?>" /></a></div>
                <p style="color:#878787;font-style:italic;font-size:11px;"><strong>Note: </strong>Yelp Bar was originally designed for all the happytables clients, and will continue to be developed according to their main needs.</p>
			
			</div>
			
			<div style="clear:both"></div>
        </div>
        <?php
    }


// - register new settings -
    function themeforce_yelpbar_init() {
        register_setting('themeforce_yelpbar_options','themeforce_yelpbar_options');
        add_settings_section('themeforce_yelpbar_main', '', 'themeforce_yelpbar_main_text', 'themeforce_yelpbar');
        add_settings_field('themeforce_yelpbar_activation','Enable?','yelpbar_activation_input','themeforce_yelpbar','themeforce_yelpbar_main');
        add_settings_field('themeforce_yelpbar_setting_api','Yelp API Key','yelpbar_setting_api_input','themeforce_yelpbar','themeforce_yelpbar_main');
        add_settings_field('themeforce_yelpbar_setting_phone','Yelp API Business Phone Number','yelpbar_setting_phone_input','themeforce_yelpbar','themeforce_yelpbar_main');
        add_settings_field('themeforce_yelpbar_setting_country','Yelp API Country','yelpbar_setting_country_input','themeforce_yelpbar','themeforce_yelpbar_main');
        add_settings_field('themeforce_yelpbar_setting_txtone','Text before Rating','yelpbar_setting_txtone_input','themeforce_yelpbar','themeforce_yelpbar_main');
        add_settings_field('themeforce_yelpbar_setting_txttwo','Text before Reviews','yelpbar_setting_txttwo_input','themeforce_yelpbar','themeforce_yelpbar_main');
    }

// - display fields -
    function yelpbar_activation_input () {
        $options = get_option('themeforce_yelpbar_options');
        $items = array("Yes", "No");
        echo "<select id='activation' name='themeforce_yelpbar_options[activation]'>";
            foreach($items as $item) {
                    $selected = ($options['activation']==$item) ? 'selected="selected"' : '';
                    echo "<option value='$item' $selected>$item</option>";
            }
	echo "</select>";
    }

    function yelpbar_setting_api_input () {
        $options = get_option('themeforce_yelpbar_options');
        $value = $options['setting_api'];
        echo "<input id='setting_api' name='themeforce_yelpbar_options[setting_api]' type='text' size='40' value='$value' />";
    }

    function yelpbar_setting_phone_input () {
        $options = get_option('themeforce_yelpbar_options');
        $value = $options['setting_phone'];
        echo "<input id='setting_phone' name='themeforce_yelpbar_options[setting_phone]' type='text' size='40' value='$value' />";
    }

    function yelpbar_setting_country_input () {
        $options = get_option('themeforce_yelpbar_options');
        $items = array(
            'US',
            'AT',
            'AU',
            'BE',
            'CA',
            'CH',
            'DE',
            'DK',
            'ES',
            'FI',
            'FR',
            'GB',
            'IE',
            'IT',
            'NL',
            'NO',

        );
        echo "<select id='setting_country' name='themeforce_yelpbar_options[setting_country]'>";
            foreach($items as $item) {
                    $selected = ($options['setting_country']==$item) ? 'selected="selected"' : '';
                    echo "<option value='$item' $selected>$item</option>";
            }
	echo "</select>";
    }

    function yelpbar_setting_txtone_input () {
        $options = get_option('themeforce_yelpbar_options');
        $value = $options['setting_txtone'];
        echo "<input id='setting_api' name='themeforce_yelpbar_options[setting_txtone]' type='text' size='50' value='$value' />";
    }

    function yelpbar_setting_txttwo_input () {
        $options = get_option('themeforce_yelpbar_options');
        $value = $options['setting_txttwo'];
        echo "<input id='setting_api' name='themeforce_yelpbar_options[setting_txttwo]' type='text' size='50' value='$value' />";
    }

// - settings description -
    function themeforce_yelpbar_main_text() {
        echo 'Please enter your Yelp Phone API details here (retrieve a <a href="http://www.yelp.com/developers/getting_started/api_overview" target="_blank">key here</a>). Your phone number should not contain any special characters or spaces (i.e. "123-456-7890" should become "1234567890").';
        }

// Grab Yelp API
// -----------------------------------------
    function themeforce_yelpbar_api() {
        $options = get_option('themeforce_yelpbar_options');
        $api_key = $options['setting_api'];
        $api_phone = $options['setting_phone'];
        $api_cc = $options['setting_country'];
        $api_response = wp_remote_get("http://api.yelp.com/phone_search?phone={$api_phone}&cc={$api_cc}&ywsid={$api_key}");
        $yelpfile = wp_remote_retrieve_body($api_response);
        $yelp = json_decode($yelpfile);
        return $yelp;
    }

// Store in Transient
// -----------------------------------------

    function themeforce_yelpbar_transient() {

        // - get transient -
        $json = get_transient('themeforce_yelpbar_json');

        // - refresh transient -
        if ( false == $json ) {
            $json = themeforce_yelpbar_api();
            set_transient('themeforce_yelpbar_json', $json, 43200);
            }

        // - output data -
        return $json;
    }

// Force update Transient
// -----------------------------------------
    function themeforce_yelpbar_forcetransient() {
            $json = themeforce_yelpbar_api();
            set_transient('themeforce_yelpbar_json', $json, 43200);
            }

// IE7 Style
// -----------------------------------------			
			
	function themeforce_yelpbar_iefix() {
	echo "
	<!--[if IE 7]>
		<style>
		#yelpcontent {zoom: 1;*display: inline}
		</style>
	<![endif]-->
	";
	}
	
	add_action('wp_head','themeforce_yelpbar_iefix');
			
// Output Yelp Bar
// -----------------------------------------

    function themeforce_yelpbar_output() {
        $yelp = themeforce_yelpbar_transient();
        $options = get_option('themeforce_yelpbar_options');
        $txtone = $options['setting_txtone'];
        $txttwo = $options['setting_txttwo'];
        ob_start();
            echo '<script type="text/javascript" charset="utf-8">';
            echo 'jQuery(document).ready( function($) {';
            echo '$(\'body\').prepend(\'';
            // Shows Response Code for Debugging (as HTML Comment)
            echo '<!-- Yelp Response Code: ' . $yelp->message->text . ' - ' . $yelp->message->code . ' - ' . $yelp->message->version . ' -->';
            echo '<div id="yelpbar"><div id="yelpcontent">';
            // Display Requirement: No-follow Link back to Yelp.com
            echo '<div class="yelpimg"><a href="http://www.yelp.com"><img src ="' . plugins_url( 'images/yelp_logo_50x25.png', __FILE__) . '"></a></div>';
            // Show Venue specific details
            echo '<div class="yelptext">' . $txtone . '</div>';
            echo '<a href="' . $yelp->businesses[0]->url . '">';
            echo '<div class="yelpimg"><img src="' . $yelp->businesses[0]->rating_img_url . '" alt=" " style="padding-top:7px;" /></div>';
            echo '</a>';
            echo '<div class="yelptext">' . $txttwo . '</div>';
            echo '<div class="yelptext"><a href="' . $yelp->businesses[0]->url . '" target="_blank">';
            echo $yelp->businesses[0]->review_count . '&nbsp;' . __( 'Reviews', 'themeforce' );
            echo '</a></div></div></div>';
            echo '\');} );</script>';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

// Insert Yelp Bar Output right after <body>
// -----------------------------------------

    function themeforce_yelpbar_control() {
        $options = get_option('themeforce_yelpbar_options');
        $activation = $options['activation'];
        if ($activation == 'Yes') {
            $yelp = themeforce_yelpbar_transient();
            if ($yelp->message->text == 'OK') {
                $output = themeforce_yelpbar_output();
                echo $output;
            } else {
                echo '<!-- Yelp did not load - Response Code: ' . $yelp->message->text . ' - ' . $yelp->message->code . ' - ' . $yelp->message->version . ' -->';
            }
        } else {
             echo '<!-- Yelp is not activated -->';
        }
    }
?>