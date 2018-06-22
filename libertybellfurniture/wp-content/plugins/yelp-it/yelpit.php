<?php
/**
 * @package Yelp-it
 */
/*
Plugin Name: Yelp It
Plugin URI: http://coffeesnobdavis.com/yelp-it
Description: Just show a flippin Yelp blurb for a business. Name, Rating, Review Count.
Version: 0.4.3
Author: Coffeesnobdavis
Author URI: http://coffeesnobdavis.com
License: GPLv2
*/

/*
Copyright 2010-2011  Coffeesnobdavis (email: coffeesnob@coffeesnobdavis.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

require_once (dirname (__FILE__) . '/options.php');
if(!class_exists('OAuthToken', false)) {
    require_once (dirname (__FILE__) . '/lib/oauth.php');
}

// Add stylesheets
add_action('wp_print_styles', 'add_yelp_css');

function add_yelp_css() {
    $url = WP_PLUGIN_URL . '/yelp-it/style/yelp.css';
    $dir = WP_PLUGIN_DIR . '/yelp-it/style/yelp.css';

    if (file_exists($dir)) {
        wp_register_style('yelp-css', $url);
        wp_enqueue_style('yelp-css');
    }
}

function yelpit($atts) {

    $options = get_option('yelpit_settings'); // Retrieve settings array, if it exists

    // Base unsigned URL
    $unsigned_url = "http://api.yelp.com/v2/";

    // Token object built using the OAuth library
    $yelp_token = $options['yelp_token'];
    $yelp_token_secret = $options['yelp_token_secret'];

    $token = new OAuthToken($yelp_token, $yelp_token_secret);

    // Consumer object built using the OAuth library
    $yelp_consumer_key = $options['yelp_consumer_key'];
    $yelp_consumer_secret = $options['yelp_consumer_secret'];

    $consumer = new OAuthConsumer($yelp_consumer_key, $yelp_consumer_secret);

    // Yelp uses HMAC SHA1 encoding
    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

    $urlparams = shortcode_atts(array(
            'term'      => 'Four Barrel Coffee',
            'location'  => 'San Francisco, CA',
            'limit'     => 1,
            'id'        => '',
            'sort'      => '0',
            'align'     => ''
        ), $atts);

    // Set alignment and remove from the urlparams.
    $align = $urlparams['align'];
    unset($urlparams['align']);

    // If ID param is set, use business method and delete any other parameters
    if ($urlparams['id'] != '') {
        $urlparams['method'] = 'business/' . $urlparams['id'];

        unset($urlparams['term'], $urlparams['location'], $urlparams['id'], $urlparams['sort']);
    } else {
        $urlparams['method'] = 'search';
    }

    // Set method
    $unsigned_url = $unsigned_url . $urlparams['method'];

    unset($urlparams['method']);

    // Build OAuth Request using the OAuth PHP library. Uses the consumer and
    // token object created above.
    $oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url, $urlparams);

    // Sign the request
    $oauthrequest->sign_request($signature_method, $consumer, $token);

    // Get the signed URL
    $signed_url = $oauthrequest->to_url();
    
    /* Debugging */
    // echo '<pre>';
    // print_r($signed_url);
    // echo '</pre>';

    // Send Yelp API Call
    $ch = curl_init($signed_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch); // Yelp response
    curl_close($ch);

    // Handle Yelp response data
    $response = json_decode($data);

    /* Debugging */
    // echo '<pre>';
    // print_r($response);
    // echo '</pre>';

    if (isset($response->businesses)) {
        $businesses = $response->businesses;
    } else {
        $businesses = array($response);
    }

    // Instantiate output var
    $output = '';

    if (isset($response->error)) {
        $output = '<div class="yelp-error">';
        if ($response->error->id == 'EXCEEDED_REQS') {
            $output .= 'Yelp is tired -_- (Contact Yelp to increase your API call limit)';
        } else {
            $output .= $response->error->text;
        }

        $output .='</div>';
    } else if (!isset($businesses[0])) {
        $output = '<div class="yelp-error">No results</div>';
    } else {
        $target = '';
        
        // Open link in new window if set
        if ($options['yelp_open_new_window']) {
            $target = 'target="_blank" ';
        }
        
        for ( $x = 0; $x < count($businesses); $x++) {
            $output .= '<div class="yelp yelp-business '. $align .'">'
                    . '<img class="picture" src="'
                        . esc_attr($businesses[$x]->image_url) . '" />'
                    . '<div class="info">'
                        . '<a class="name" '
                            . $target
                            . 'href="' 
                            . esc_attr($businesses[$x]->url) . '" title="' 
                            . esc_attr($businesses[$x]->name) . ' Yelp page">' 
                            . $businesses[$x]->name 
                            
                        . '</a>'
                        . '<img class="rating" src="' 
                            . esc_attr($businesses[$x]->rating_img_url) 
                            . '" alt="" title="Yelp Rating" />'
                        . '<span class="review-count">' 
                            . esc_attr($businesses[$x]->review_count) 
                            . ' reviews'
                        . '</span>'
                        . '<a class="yelp-branding" href="http://www.yelp.com">
                            <img src="' . WP_PLUGIN_URL . '/yelp-it/style/yelp.png" alt="powered by Yelp" />'
                        . '</a>'
                    . '</div>'
                . '</div>';

        }
    }

    return $output;

}

add_shortcode('yelpprofile', 'yelpit');