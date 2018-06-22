<?php
/*
 * Plugin Name: Google Places
 * Plugin URI: http://www.innovativewebdesign.in/wp-google-places-plugin/
 * Description: "Google Places" also known as "Google Maps" is a great way to find local business near your city. If you need more visibility in local search results,Maps and earth this plugin is a must.  Google Places plugin is designed specifically for Business owners to help optimize their business listing on Google Search , Places and earth. Google Places plugin is designed to help your business increase in visibility on google Local searches , maps and Google Earth.
 * Author: Ritesh Khare
 * Version: 1.0
 * Author URI: http://www.innovativewebdesign.in
 */

/*  Copyright 2012  Ritesh Khare  (email:ritesh@innovativewebdesign.in)

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

    add_action('admin_menu','GooglePlaces_admin_action');

    function GooglePlaces_admin_action(){
    add_options_page('Google places Plugin Settings','Google places Plugin Settings','manage_options','google-places-plugin-settings','Googleplaces_Plugin_Settings');
    }

    function Googleplaces_Plugin_Settings(){
        require_once'googleplaces_settings_html.php';
    }

    function check_permissions($filename) {
    if(!is_writable($filename)) {
    if(!@chmod($filename, 0666)) {
      $pathtofilename = dirname($filename);
      if(!is_writable($pathtofilename)) {
        if(!@chmod($pathtofilename, 0666)) {
          return false;
        }
      }
    }
  }
  return true;
}

register_deactivation_hook(__FILE__,'googleplaces_Plugin_deactivate');

function googleplaces_Plugin_deactivate() {
    delete_option('googleplaces_plugin_options');
}


    










?>
