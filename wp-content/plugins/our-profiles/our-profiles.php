<?php
/*
Plugin Name: Review Profile Links
Plugin URI: https://www.searchcommander.com/wp-plugin-gather-reviews/
Description: This plugin allows you to enter your profile URLs in the <a href="admin.php?page=our-profiles-config">settings</a> and use a shortcode on pages or posts. Provided by Search Commander, Inc.
Version: 2.0.1
Author: Scott Hendison
Author URI: http://profiles.wordpress.org/cyber49/
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define( 'OURPROFILES_HTTP_PATH' , WP_PLUGIN_URL . '/' . str_replace(basename( __FILE__) , "" , plugin_basename(__FILE__) ) );
define( 'OURPROFILES_ABSPATH'   , WP_PLUGIN_DIR . '/' . str_replace(basename( __FILE__) , "" , plugin_basename(__FILE__) ) );

$ourprofiles_links = get_option('ourprofiles_links');
$ourprofiles_services = get_option('ourprofiles_services');
$ourprofiles_options = get_option('ourprofiles_options');

function ourprofiles_reset(){

    $default_ourprofiles_links = array(
        'Best of the Web' => '',
        'Bing' => '',
        'Citysearch' => '',
        'DexKnows' => '',
        'Foursquare' => '',
        'Facebook' => '',
        'Google' => '',
        'InsiderPages' => '',
        'Merchant Circle' => '',
        'Kudzu' => '',
        'LinkedIn' => '',
        'Local.com' => '',
        'Judy\'s Book' => '',
        'Manta' => '',
        'SuperPages' => '',
        'Yahoo Local' => '',
        'Yelp' => '',
        'Yellowee.com' => '',
        'YellowBot' => '',
        'YP.com  ' => '',
        'DemandForce' => '',
        'CustomerLobby' => '',
        'Twitter' => '',
		'tripadvisor' => '',
        'Angie\'s list' => '',
		'Houzz' => ''		
    );

    $default_ourprofiles_services = array(
        'Best of the Web' => array('image' => 'BestOfTheWeb.png', 'domain' => 'http://bestoftheweb.com/'),
        'Bing' => array('image' => 'Bing.png', 'domain' => 'http://www.bing.com/'),
        'Citysearch' => array('image' => 'Citysearch.png', 'domain' => 'http://www.citysearch.com/'),
        'DexKnows' => array('image' => 'DexKnows.png', 'domain' => 'http://www.dexknows.com/'),
        'Foursquare' => array('image' => 'Foursquare.png', 'domain' => 'http://foursquare.com/'),
        'Facebook' => array('image' => 'Facebook.png', 'domain' => 'http://www.facebook.com/'),
        'Google' => array('image' => 'Google.png', 'domain' => 'http://www.google.com/'),
        'InsiderPages' => array('image' => 'InsiderPages.png', 'domain' => 'http://www.insiderpages.com/'),
        'Merchant Circle' => array('image' => 'MerchantCircle.png', 'domain' => 'http://www.merchantcircle.com/'),
        'Kudzu' => array('image' => 'Kudzu.png', 'domain' => 'http://www.kudzubizsuccess.com/'),
        'LinkedIn' => array('image' => 'LinkedIn.png', 'domain' => 'http://www.linkedin.com/'),
        'Local.com' => array('image' => 'Local.png', 'domain' => 'http://www.local.com/'),
        'Judy\'s Book' => array('image' => 'JudysBook.png', 'domain' => 'http://www.judysbook.com/'),
        'Manta' => array('image' => 'Manta.png', 'domain' => 'http://www.manta.com/'),
        'SuperPages' => array('image' => 'SuperPages.png', 'domain' => 'http://www.superpages.com/'),
        'Yahoo Local' => array('image' => 'YahooLocal.png', 'domain' => 'http://local.yahoo.com/'),
        'Yelp' => array('image' => 'Yelp.png', 'domain' => 'http://www.yelp.com/'),
        'Yellowee.com' => array('image' => 'Yellowee.png', 'domain' => 'http://www.yellowee.com/'),
        'YellowBot' => array('image' => 'YellowBot.png', 'domain' => 'http://www.yellowbot.com/'),
        'YP.com  ' => array('image' => 'YP.png', 'domain' => 'http://www.yellowpages.com/'),
        'DemandForce' => array('image' => 'DemandForce.png', 'domain' => 'http://www.demandforce.com/'),
        'CustomerLobby' => array('image' => 'CustomerLobby.png', 'domain' => 'http://www.customerlobby.com/'),
        'Twitter' => array('image' => 'Twitter.png', 'domain' => 'http://www.twitter.com/'),
		'tripadvisor' => array('image' => 'tripadvisor.png', 'domain' => 'http://www.tripadvisor.com/'),
        'Angie\'s list' => array('image' => 'angieslist.png', 'domain' => 'http://www.angieslist.com/'),
		'Houzz' => array('image' => 'houzz.png', 'domain' => 'http://www.houzz.com/')		
    );

    $default_ourprofiles_options = array(
        'images_folder' => '150x75'
    );


    $current_ourprofiles_links = get_option('ourprofiles_links', array());
    $new_ourprofiles_links = array();
    foreach($current_ourprofiles_links as $service => $link){
        if ( isset( $default_ourprofiles_links[$service] ) ){
            $new_ourprofiles_links[$service] = $link;
            unset ($default_ourprofiles_links[$service]);
        }
    }
    $new_ourprofiles_links = array_merge($new_ourprofiles_links, $default_ourprofiles_links);
    update_option('ourprofiles_links', $new_ourprofiles_links);


    update_option('ourprofiles_services', $default_ourprofiles_services);
    update_option('ourprofiles_options',  $default_ourprofiles_options);
}

/* plugin activating */
function ourprofiles_activate() {
    if ( !current_user_can( 'activate_plugins' ) )
        return;
    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';

    ourprofiles_reset();

}
register_activation_hook( __FILE__, 'ourprofiles_activate' );

/* plugin deactivating */
function ourprofiles_deactivate() {
    if ( !current_user_can( 'activate_plugins' ) )
        return;
    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';


    delete_option('ourprofiles_services');
    delete_option('ourprofiles_options');
}

register_deactivation_hook( __FILE__, 'ourprofiles_deactivate' );


function ourprofiles_init(){
    global $ourprofiles_links, $ourprofiles_services, $ourprofiles_options;
    if (   !$ourprofiles_links
        || !$ourprofiles_services
        || !$ourprofiles_options
        || !isset($ourprofiles_options['images_folder']))
    {
        ourprofiles_reset();
    }

    // 1.0.4 update
    if (   !isset($ourprofiles_services['DemandForce'])
        || !isset($ourprofiles_services['CustomerLobby'])
        || !isset($ourprofiles_services['Twitter'])
        || !isset($ourprofiles_services['tripadvisor'])
    ){
        ourprofiles_reset();
    }

    // 1.0.10 update
    if (   !isset($ourprofiles_services['tripadvisor'])
    ){
        ourprofiles_reset();
    }
    
    // 1.0.11 update
    if (  !isset($ourprofiles_services['Angie\'s list'])
        || !isset($ourprofiles_services['Houzz'])
    ){
        ourprofiles_reset();
    }    
}

add_action( 'init' , 'ourprofiles_init' );

include_once dirname( __FILE__ ) . '/widget.php';

include_once dirname( __FILE__ ) . '/shortcode.php';

if ( is_admin() )
    require_once dirname( __FILE__ ) . '/admin.php';

?>