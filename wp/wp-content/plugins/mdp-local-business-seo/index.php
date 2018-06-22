<?php
/*
Plugin Name: Local Business SEO
Description: Local business SEO plugin will optimize your website with microdata for google, bing and yahoo. Specifying the type of business your website if for can produce a 100% ranking increase for local keywords. Works great with other seo plugins including Yoast SEO.
Version: 0.6.0
Plugin URI: http://microdataproject.org
Plugin URI: mailto:contact@microdataproject.org
Author: Christopher Dubea
Author URI: mailto:me@christopherdubeau.com
Author URI: http://christopherdubeau.com
Contributor: Sid Creations
Contributor URI: mailto:contact@sidcreations.com
Contributor URI: http://sidcreations.com


Copyright 2013  Microdata Project / Christopher Dubeau  (email : me@christopherdubeau.com, email: contact@microdataproject.org)

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


// DEFINE PLUGIN ID
define( 'MDP_LOCAL_BUSINESS_SEO_ID' , 'mdp_local_business_info' );
// DEFINE PLUGIN NICK
define( 'MDP_LOCAL_BUSINESS_SEO_NICK' , 'Local SEO' );

define('VERSION', 'Version 0.6.0');


if ( ! class_exists ( 'mdpInfo' ) ) {

	class mdpInfo
	{

		public $name;

		public function __construct ()
		{

			$this->name = 'mdpLocalBusinessInfo';

			register_activation_hook ( __FILE__ , array ( $this , 'mdp_activate' ) );
			register_deactivation_hook ( __FILE__ , array ( $this , 'mdp_deactivate' ) );
			register_uninstall_hook ( __FILE__ , array ( $this , 'mdp_uninstall' ) );

		}

		/** function/activate
		 * Usage: create tables if not exist and activates the plugin
		 * Arg(0): null
		 * Return: void
		 */

		public static function mdp_activate ()
		{

			add_option ( 'mdp_status' );
			add_option ( 'mdp_type' );
			add_option ( 'mdp_name' );
			add_option ( 'mdp_description' );
			add_option ( 'mdp_url' );
			add_option ( 'mdp_image' );
			add_option ( 'mdp_sameas' );
			add_option ( 'mdp_payment_accepted' );
			add_option ( 'mdp_street_address' );
			add_option ( 'mdp_address_locality' );
			add_option ( 'mdp_address_region' );
			add_option ( 'mdp_postal_code' );
			add_option ( 'mdp_address_country' );
			add_option ( 'mdp_email' );
			add_option ( 'mdp_telephone' );
			add_option ( 'mdp_fax_number' );
			add_option ( 'mdp_best_rating' );
			add_option ( 'mdp_rating_value' );
			add_option ( 'mdp_open' );
			add_option ( 'mdp_close' );
			add_option ( 'mdp_dow' );
			add_option ( 'mdp_seeks' );
			add_option ( 'mdp_seeks_url' );
			add_option ( 'mdp_seeks_name' );
			add_option ( 'mdp_seeks_description' );
			add_option ( 'mdp_member' );
			add_option ( 'mdp_member_url' );
			add_option ( 'mdp_member_name' );
			add_option ( 'mdp_member_description' );
			add_option ( 'mdp_geo_location' );
			add_option ( 'mdp_longitude' );
			add_option ( 'mdp_latitude' );
			add_option ( 'mdp_founder_role' );
			add_option ( 'mdp_employee_role' );
			add_option ( 'mdp_review' );
			add_option ( 'mdp_review_default' );
			add_option ( 'mdp_keyword' );


		}

		/** function/deactivate
		 * Usage: create tables if not exist and activates the plugin
		 * Arg(0): null
		 * Return: void
		 */

		public static function mdp_deactivate ()
		{

			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_status' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_type' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_name' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_description' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_url' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_image' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_sameas' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_payment_accepted' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_street_address' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_address_locality' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_address_region' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_postal_code' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_address_country' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_email' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_telephone' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_fax_number' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_best_rating' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_worst_rating' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_rating_count' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_rating_value' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_open' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_close' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_dow' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_seeks' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_seeks_url' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_seeks_name' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_seeks_description' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_member' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_member_url' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_member_name' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_member_description' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_geo_location' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_longitude' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_latitude' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_founder_role' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_employee_role' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_reviews' , 'mdp_review' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_reviews' , 'mdp_review_default' );
			unregister_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_reviews' , 'mdp_keyword' );

		}

		/** function/uninstall
		 * Usage: create tables if not exist and activates the plugin
		 * Arg(0): null
		 * Return: void
		 */

		public static function mdp_uninstall ()
		{

			delete_option ( 'mdp_status' );
			delete_option ( 'mdp_type' );
			delete_option ( 'mdp_name' );
			delete_option ( 'mdp_description' );
			delete_option ( 'mdp_url' );
			delete_option ( 'mdp_image' );
			delete_option ( 'mdp_sameas' );
			delete_option ( 'mdp_payment_accepted' );
			delete_option ( 'mdp_street_address' );
			delete_option ( 'mdp_address_locality' );
			delete_option ( 'mdp_address_region' );
			delete_option ( 'mdp_postal_code' );
			delete_option ( 'mdp_address_country' );
			delete_option ( 'mdp_email' );
			delete_option ( 'mdp_telephone' );
			delete_option ( 'mdp_fax_number' );
			delete_option ( 'mdp_best_rating' );
			delete_option ( 'mdp_rating_value' );
			delete_option ( 'mdp_open' );
			delete_option ( 'mdp_close' );
			delete_option ( 'mdp_dow' );
			delete_option ( 'mdp_seeks' );
			delete_option ( 'mdp_seeks_url' );
			delete_option ( 'mdp_seeks_name' );
			delete_option ( 'mdp_seeks_description' );
			delete_option ( 'mdp_member' );
			delete_option ( 'mdp_member_name' );
			delete_option ( 'mdp_member_url' );
			delete_option ( 'mdp_member_description' );
			delete_option ( 'mdp_geo_location' );
			delete_option ( 'mdp_longitude' );
			delete_option ( 'mdp_latitude' );
			delete_option ( 'mdp_founder_role' );
			delete_option ( 'mdp_employee_role' );
			delete_option ( 'mdp_review' );
			delete_option ( 'mdp_review_default' );
			delete_option ( 'mdp_keyword' );

		}

		/** function/file_path
		 * Usage: includes the plugin file path
		 * Arg(0): null
		 * Return: void
		 */

		public static function mdp_file_path($file) {

			return ABSPATH . 'wp-content/plugins/' . str_replace ( basename ( __FILE__ ) , "" , plugin_basename ( __FILE__ ) ) . $file;
		}


		/** function/register_settings
		 * Usage: registers the plugins options
		 * Arg(0): null
		 * Return: void
		 */
		public static function mdp_register ()
		{
			global $wpdb;

			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_status' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_type' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_name' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_description' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_url' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_image' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_sameas' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_payment_accepted' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_street_address' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_address_locality' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_address_region' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_postal_code' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_address_country' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_email' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_telephone' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_fax_number' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_best_rating' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_worst_rating' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_rating_count' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_rating_value' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_open' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_close' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_dow' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_seeks' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_seeks_name' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_seeks_url' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_seeks_description' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_member' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_member_name' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_member_url' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_member_description' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_geo_location' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_longitude' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_latitude' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_founder_role' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_options' , 'mdp_employee_role' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_reviews' , 'mdp_review' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_reviews' , 'mdp_review_default' );
			register_setting ( MDP_LOCAL_BUSINESS_SEO_ID . '_reviews' , 'mdp_keyword' );


			$table_name = $wpdb->prefix . "mdp_reviews";

			if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name )
			{
				if ( ! empty( $wpdb->charset ) )
					$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
				if ( ! empty( $wpdb->collate ) )
					$charset_collate .= " COLLATE $wpdb->collate";

				$sql = "CREATE TABLE $table_name (
			                        id mediumint(9) NOT NULL AUTO_INCREMENT,
			                        author VARCHAR(100) NOT NULL,
			                        pid VARCHAR(10) NOT NULL,
			                        review_body TEXT NOT NULL,
			                        url VARCHAR(255) NOT NULL,
			                        provider VARCHAR(100) NOT NULL,
			                        description VARCHAR(160) NOT NULL,
			                        date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			                        PRIMARY KEY  id (id),
			                        UNIQUE KEY  pid (pid)
			                        ) $charset_collate;
	                                ";

				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

				dbDelta($sql);
			}


		}

		/** function/method
		 * Usage: hooking (registering) the plugin menu
		 * Arg(0): null
		 * Return: void
		 */
		public static function mdp_menu ()
		{

			$icon_url = str_replace ( basename ( __FILE__ ) , "" , plugin_basename ( __FILE__ ) );
			add_menu_page ( MDP_LOCAL_BUSINESS_SEO_NICK . ' Plugin Options' , MDP_LOCAL_BUSINESS_SEO_NICK , '10' , MDP_LOCAL_BUSINESS_SEO_ID . '_options' , array ( 'mdpInfo' , 'mdp_options_page' ) , plugins_url ( $icon_url . 'mdp_icon32.png' ) );
			add_submenu_page(MDP_LOCAL_BUSINESS_SEO_ID . '_options', MDP_LOCAL_BUSINESS_SEO_NICK . ' Options', 'Options', '10', MDP_LOCAL_BUSINESS_SEO_ID . '_options', array('mdpInfo', 'mdp_options_page'));
			add_submenu_page(MDP_LOCAL_BUSINESS_SEO_ID . '_options', MDP_LOCAL_BUSINESS_SEO_NICK . ' Reviews', 'Reviews', '10', MDP_LOCAL_BUSINESS_SEO_ID . '_reviews', array('mdpInfo', 'mdp_reviews_page'));
		}

		/** function/options_page
		 * Usage: show options/settings for plugin
		 * Arg(0): null
		 * Return: void
		 */
		public static function mdp_options_page ()
		{

			$plugin_id = MDP_LOCAL_BUSINESS_SEO_ID;
			// display options page
			include ( self::mdp_file_path ( 'options.php' ) );

		}

		/** function/reviews_page
		 * Usage: show options/settings for plugin
		 * Arg(0): null
		 * Return: void
		 */
		public static function mdp_reviews_page ()
		{

			$plugin_id = MDP_LOCAL_BUSINESS_SEO_ID;
			// display options page
			include ( self::mdp_file_path ( 'reviews.php' ) );

		}


		public static function genReveiws()
		{
			require_once('reviews_class.php');
			$reviews = new Reviews();
			global $wpdb;
			$table_name = $wpdb->prefix . "mdp_reviews";
			$args = array ('post_status'      => 'publish');

			$posts = get_posts( $args );
			$pages = get_pages( $args );
			$array = array_merge($posts, $pages);

			foreach( $array as $val ){

				$data = explode('::', $reviews->buildReview());

				if($val->ID !== '')
				{
					$wpdb->replace(
						$table_name,
						array(
						     'pid' => $val->ID,
						     'author' => $data[0],
						     'review_body' => $data[1],
						     'provider' => $data[2],
						     'url' => $data[3],
						     'description' => $data[4],
						     'date_created' => current_time('mysql', 1)

						)
					);
				}

			}

		}


		public static function genReveiw($pid)
		{
			require_once('reviews_class.php');
			$reviews = new Reviews();
			global $wpdb;
			$table_name = $wpdb->prefix . "mdp_reviews";
			$data = explode('::', $reviews->buildReview());

			$wpdb->insert(
				$table_name,
				array(
				     'pid' => $pid,
				     'author' => $data[0],
				     'review_body' => $data[1],
				     'provider' => $data[2],
				     'url' => $data[3],
				     'description' => $data[4],
				     'date_created' => current_time('mysql', 1)

				)
			);

		}


		/** function/separateCapital
		 * Usage: separate string by capital letters with spaces
		 * Arg(0): null
		 * Return: parsed string
		 */
		public static function separateCapital ($str)
		{

			preg_match_all ( '/[A-Z][^A-Z]*/' , $str , $results );
			$result  = "";
			$results = $results[ 0 ];
			foreach ( $results as $val ) {
				$result .= $val . ' ';
			}

			return rtrim ( $result , ' ' );
		}



	}
}


add_action ( 'admin_init' , array ( 'mdpInfo' , 'mdp_register' ) );
add_action ( 'admin_menu' , array ( 'mdpInfo' , 'mdp_menu' ) );
add_action ( 'user_admin_menu' , array ( 'mdpInfo' , 'mdp_menu' ) );


if ( get_option ( 'mdp_status' ) == 1 )
{


	include ( 'mdp_info.php' );


}
$mdpInfo = new mdpInfo();

?>