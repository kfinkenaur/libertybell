<?php

/*
 * Class for displaying the local business information
 */

if (!class_exists('LocalBusiness')) {

	class LocalBusiness
	{

		public $name;

		public function __construct()
		{

			$this->name = 'mdpLocalBusiness';

		}

		/** function/getParent
		 * Usage: create tables if not exist and activates the plugin
		 * Arg(0): null
		 * Return: if found return parent type of business
		 */
		public function getParent()
		{

			$parent = get_option('mdp_type');
			$array = array(
				'AutoBodyShop:AutomotiveBusiness',
				'AutoDealer:AutomotiveBusiness',
				'AutoPartsStore:AutomotiveBusiness',
				'AutoRental:AutomotiveBusiness',
				'AutoRepair:AutomotiveBusiness',
				'AutoWash:AutomotiveBusiness',
				'GasStation:AutomotiveBusiness',
				'MotorcycleDealer:AutomotiveBusiness',
				'MotorcycleRepair:AutomotiveBusiness',
				'FireStation:EmergencyService',
				'Hospital:EmergencyService',
				'PoliceStation:EmergencyService',
				'AdultEntertainment:EntertainmentBusiness',
				'AmusementPark:EntertainmentBusiness',
				'ArtGallery:EntertainmentBusiness',
				'Casino:EntertainmentBusiness',
				'ComedyClub:EntertainmentBusiness',
				'MovieTheater:EntertainmentBusiness',
				'NightClub:EntertainmentBusiness',
				'FinancialService:FinancialService',
				'AccountingService:FinancialService',
				'AutomatedTeller:FinancialService',
				'BankOrCreditUnion:FinancialService',
				'InsuranceAgency:FinancialService',
				'FoodEstablishment:FoodEstablishment',
				'Bakery:FoodEstablishment',
				'BarOrPub:FoodEstablishment',
				'Brewery:FoodEstablishment',
				'CafeOrCoffeeShop:FoodEstablishment',
				'FastFoodRestaurant:FoodEstablishment',
				'IceCreamShop:FoodEstablishment',
				'Restaurant:FoodEstablishment',
				'Winery:FoodEstablishment',
				'PostOffice:GovernmentOffice',
				'BeautySalon:HealthAndBeautyBusiness',
				'DaySpa:HealthAndBeautyBusiness',
				'HairSalon:HealthAndBeautyBusiness',
				'HealthClub:HealthAndBeautyBusiness',
				'NailSalon:HealthAndBeautyBusiness',
				'TattooParlor:HealthAndBeautyBusiness',
				'HomeAndConstructionBusiness:HomeAndConstructionBusiness',
				'Electrician:HomeAndConstructionBusiness',
				'GeneralContractor:HomeAndConstructionBusiness',
				'HVACBusiness:HomeAndConstructionBusiness',
				'HousePainter:HomeAndConstructionBusiness',
				'Locksmith:HomeAndConstructionBusiness',
				'MovingCompany:HomeAndConstructionBusiness',
				'Plumber:HomeAndConstructionBusiness',
				'RoofingContractor:HomeAndConstructionBusiness',
				'BedAndBreakfast:LodgingBusiness',
				'Hostel:LodgingBusiness',
				'Hotel:LodgingBusiness',
				'Motel:LodgingBusiness',
				'Dentist:MedicalOrganization',
				'DiagnosticLab:MedicalOrganization',
				'Hospital:MedicalOrganization',
				'MedicalClinic:MedicalOrganization',
				'Optician:MedicalOrganization',
				'Pharmacy:MedicalOrganization',
				'Physician:MedicalOrganization',
				'VeterinaryCare:MedicalOrganization',
				'AccountingService:ProfessionalService',
				'Attorney:ProfessionalService',
				'Dentist:ProfessionalService',
				'Electrician:ProfessionalService',
				'GeneralContractor:ProfessionalService',
				'HousePainter:ProfessionalService',
				'Locksmith:ProfessionalService',
				'Notary:ProfessionalService',
				'Plumber:ProfessionalService',
				'RoofingContractor:ProfessionalService',
				'BowlingAlley:SportsActivityLocation',
				'ExerciseGym:SportsActivityLocation',
				'GolfCourse:SportsActivityLocation',
				'HealthClub:SportsActivityLocation',
				'PublicSwimmingPool:SportsActivityLocation',
				'SkiResort:SportsActivityLocation',
				'SportsClub:SportsActivityLocation',
				'StadiumOrArena:SportsActivityLocation',
				'TennisComplex:SportsActivityLocation',
				'AutoPartsStore:Store',
				'BikeStore:Store',
				'BookStore:Store',
				'ClothingStore:Store',
				'ComputerStore:Store',
				'ConvenienceStore:Store',
				'DepartmentStore:Store',
				'ElectronicsStore:Store',
				'Florist:Store',
				'FurnitureStore:Store',
				'GardenStore:Store',
				'GroceryStore:Store',
				'HardwareStore:Store',
				'HobbyShop:Store',
				'HomeGoodsStore:Store',
				'JewelryStore:Store',
				'LiquorStore:Store',
				'MensClothingStore:Store',
				'MobilePhoneStore:Store',
				'MovieRentalStore:Store',
				'MusicStore:Store',
				'OfficeEquipmentStore:Store',
				'OutletStore:Store',
				'PawnShop:Store',
				'PetStore:Store',
				'ShoeStore:Store',
				'SportingGoodsStore:Store',
				'TireShop:Store',
				'ToyStore:Store',
				'WholesaleStore:Store'
			);

			foreach ($array as $var) {

				$val = explode(':' , $var);

				switch ($val[0]) {

					case $parent:
						$set = $val[1];
						break;
				}

			}

			if ($set) {
				return $set;
			} else {
				return false;
			}

		}

		/** function/localBusiness
		 * Usage: creates localBusiness schema and outputs information
		 * Arg(0): null
		 * Return: void
		 */
		public function showLocalBusiness()
		{

			$mdp_info = '<!--begin microdata project plugin '.VERSION.' -->';


			$mdp_info .= '<span itemscope itemtype="http://schema.org/LocalBusiness">';

			if (self::getParent())
			{
				$mdp_info .= '<span itemscope itemtype="http://schema.org/' . self::getParent() . '">';
			}

			if (get_option('mdp_type'))
			{
				$mdp_info .= '<span itemscope itemtype="http://schema.org/' . get_option('mdp_type') . '">';
			}

			/* name of business and url */
			if (get_option('mdp_name'))
			{

				if (get_option('mdp_url'))
				{
					$mdp_info .= '<link itemprop="url" href="' . get_option('mdp_url') . '"><meta itemprop="name" content="' . get_option('mdp_name') . '"/>';
				}
				else
				{
					$mdp_info .= '<link itemprop="url" href="' . get_bloginfo('url') . '"><meta itemprop="name" content="' . get_option('mdp_name') . '"/>';
				}

			} else {
				if (get_option('mdp_url'))
				{
					$mdp_info .= '<link itemprop="url" href="' . get_option('mdp_url') . '" ><meta itemprop="name" content="' . get_bloginfo('name') . '"/>';
				}
				else
				{
					$mdp_info .= '<link itemprop="url" href="' . get_bloginfo('url') . '" ><meta itemprop="name" content="' . get_bloginfo('name') . '" />';
				}
			}

			/* description of business */
			if (get_option('mdp_description'))
			{
				$mdp_info .= '<meta itemprop="description" content="' . get_option('mdp_description') . '" />';
			} else {
				$mdp_info .= '<meta itemprop="description" content="' . get_bloginfo('description') . '" />';
			}

			/* logo of business */
			if (get_option('mdp_image'))
			{
				$mdp_info .= '<meta itemprop="image" content="' . get_option('mdp_image') . '" />';
			}

			/* wiki page or other site of business association */
			if (get_option('mdp_sameas'))
			{
				$mdp_info .= '<meta itemprop="sameAs" content="' . get_option('mdp_sameas') . '" />';
			}

			$mdp_info .= '<span itemscope itemtype="http://schema.org/Place">';
			/* physical address */
			$mdp_info .= self::PostalAddress();

			/* geo location */
			//if (get_option('mdp_geo_location')) {

			$mdp_info .= self::geoLocation();

			//}

			/* rating of business*/
			$mdp_info .= self::aggregateRating();

			$mdp_info .= '</span>';
			/* type of payments visa, master card, check, cash */
			if (get_option('mdp_payment_accepted'))
			{
				$mdp_info .= '<meta itemprop="paymentAccepted" content="' . get_option('mdp_payment_accepted') . '" />';
			}

			/* price range of items*/
			if (get_option('mdp_price_range'))
			{
				$mdp_info .= '<meta itemprop="priceRange" content="' . get_option('mdp_price_range') . '" />';
			}


			/* opening hours of business */
			if ((get_option('mdp_dow')) && (get_option('mdp_open')) && (get_option('mdp_close')))
			{
				$mdp_info .= '<meta itemprop="openingHours" content="' . get_option('mdp_dow') . ' ' . get_option('mdp_open') . '-' . get_option('mdp_close') . '" />';
			}

			/* employees */
			if (get_option('mdp_employee_role'))
			{
				$mdp_info .= self::getEmployee();
			}

			/* employees */
			if (get_option('mdp_founder_role'))
			{
				$mdp_info .= self::getFounder();
			}

			/* reviews */
			if ((get_option('mdp_review')) && (get_option('mdp_review_default')))
			{
				$mdp_info .= self::getReviews();
			}

			/* member of Microdata Project */
			if ((get_option('mdp_member')) || ((get_option('mdp_member_url')) && (get_option('mdp_member_name'))))
			{
				$mdp_info .= self::member();
			}

			/* seeks SEO */
			if ((get_option('mdp_seeks')) || ((get_option('mdp_seeks_url')) && (get_option('mdp_seeks_name'))))
			{
				$mdp_info .= self::seeks();
			}

			if (self::getParent())
			{
				$mdp_info .= '</span>';
			}

			if (get_option('mdp_type'))
			{
				$mdp_info .= '</span>';
			}

			$mdp_info .= '</span>';

			$mdp_info .= '<!--end microdata project plugin '.VERSION.' -->';


			echo str_replace("\t" , " " , str_replace(array("\r" , "\n") , "" , str_replace(" " , " " , $mdp_info)));

		}

		/** function/postalAddress
		 * Usage: create postal address schema
		 * Arg(0): null
		 * Return: postal address schema
		 */
		private function PostalAddress()
		{

			$error = 0;
			$mdp_info = "";

			$mdp_info .= '<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';

			/* street address */
			if (get_option('mdp_street_address'))
			{
				$mdp_info .= '<meta itemprop="streetAddress" content="' . get_option('mdp_street_address') . '" />';
			}

			/* city */
			if (get_option('mdp_address_locality'))
			{
				$mdp_info .= '<meta itemprop="addressLocality" content="' . get_option('mdp_address_locality') . '" />';
			}
			else
			{
				$error = 1;
			}

			/* state */
			if (get_option('mdp_address_region'))
			{
				$mdp_info .= '<meta itemprop="addressRegion" content="' . get_option('mdp_address_region') . '" />';
			}
			else
			{
				$error = 1;
			}

			/* zip code */
			if (get_option('mdp_postal_code'))
			{
				$mdp_info .= '<meta itemprop="postalCode" content="' . get_option('mdp_postal_code') . '" />';
			}

			/* county is USA */
			if (get_option('mdp_address_country'))
			{
				$mdp_info .= '<meta itemprop="addressCountry" content="' . get_option('mdp_address_country') . '" />';
			}

			/* email */
			if (get_option('mdp_email'))
			{
				$mdp_info .= '<meta itemprop="email" content="' . get_option('mdp_email') . '" />';
			}

			/* telephone */
			if (get_option('mdp_telephone'))
			{
				$mdp_info .= '<meta itemprop="telephone" content="' . get_option('mdp_telephone') . '" />';
			}

			/* fax */
			if (get_option('mdp_fax_number'))
			{
				$mdp_info .= '<meta itemprop="faxNumber" content="' . get_option('mdp_fax_number') . '" />';
			}


			$mdp_info .= '</span>';

			if ($error == 0)
			{
				return $mdp_info;
			}

		}


		/** function/aggregateRating
		 * Usage: creates aggregate rating for schema
		 * Arg(0): null
		 * Return: aggregate rating schema
		 */
		private function aggregateRating()
		{

			$error = 0;
			$mdp_info = "";

			$mdp_info .= '<span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';

			/* total value i.e 1-5 should be 5 */
			if (get_option('mdp_rating_value'))
			{
				$mdp_info .= '<meta itemprop="ratingValue" content="' . get_option('mdp_rating_value') . '" />';
			}
			else
			{
				$error = 1;
			}

			/* best rating */
			if (get_option('mdp_best_rating'))
			{
				$mdp_info .= '<meta itemprop="bestRating" content="' . get_option('mdp_best_rating') . '" />';
			}
			else
			{
				$error = 1;
			}

			/* lowest rating */
			if (get_option('mdp_worst_rating'))
			{
				$mdp_info .= '<meta itemprop="worstRating" content="' . get_option('mdp_worst_rating') . '" />';
			}
			else
			{
				$error = 1;
			}

			/* how many votes, count */
			if (get_option('mdp_rating_count'))
			{
				$mdp_info .= '<meta itemprop="ratingCount" content="' . get_option('mdp_rating_count') . '" />';
			}
			else
			{
				$error = 1;
			}

			$mdp_info .= '</span>';
			if ($error == 0)
			{
				return $mdp_info;
			}

		}

		/** function/seeks
		 * Usage: creates seeks for schema
		 * Arg(0): null
		 * Return: seeks schema
		 */
		private function seeks()
		{

			$mdp_info = "";

			$mdp_info .= '<span itemprop="seeks" itemscope itemtype="http://schema.org/Demand" >';

			$mdp_info .= '<link itemprop="url" href="' . get_option('mdp_seeks_url') . '" ><meta itemprop="name" content="' . get_option('mdp_seeks_name') . '" />';

			$mdp_info .= '<meta itemprop="description" content="' . get_option('mdp_seeks_description') . '" />';

			$mdp_info .= '</span>';


			return $mdp_info;

		}



		/** function/member
		 * Usage: creates member for schema
		 * Arg(0): null
		 * Return: member schema
		 */
		private function member()
		{

			$mdp_info = "";

			$mdp_info .= '<span itemprop="member" itemscope itemtype="http://schema.org/Organization">';

			$mdp_info .= '<link itemprop="url" href="' . get_option('mdp_member_url') . '"><meta itemprop="name" content="' . get_option('mdp_member_name') . '">';

			$mdp_info .= '<meta itemprop="description" content="' . get_option('mdp_member_description') . '" />';

			$mdp_info .= '</span>';


			return $mdp_info;
		}

		/** function/geoLocation
		 * Usage: creates geo location for schema
		 * Arg(0): null
		 * Return: geo location schema
		 */
		private function geoLocation()
		{

			if ((get_option('mdp_latitude')) == "" || (get_option('mdp_longitude')) == ""
			    || (preg_match
				(
					'#[0-9]{2}\.[0-9]{2}#' , get_option
					                       (
						                       'mdp_longitude'
					                       )
				))
			) {
				self::getGeoLocation();
			}

			$mdp_info = "";

			$mdp_info .= '<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">';

			$mdp_info .= '<meta itemprop="latitude" content="' . get_option('mdp_latitude') . '" />';

			$mdp_info .= '<meta itemprop="longitude" content="' . get_option('mdp_longitude') . '" />';

			$mdp_info .= '</span>';

			return $mdp_info;

		}

		/** function/getEmployee
		 * Usage: creates employees for schema
		 * Arg(0): null
		 * Return: employees schema
		 */
		private function getEmployee()
		{

			$mdp_info = "";

			$employees = get_users('role=' . get_option('mdp_employee_role') . '&all_user_meta');

			$mdp_info .= '<span itemprop="employees" itemscope itemtype="http://schema.org/employees">';

			foreach ($employees as $employee)
			{

				if ($employee->display_name)
				{

					$employee_name = $employee->display_name;

				}
				else
				{

					$employee_name = $employee->user_nicename;
				}

				$mdp_info .= '<span itemprop="employee" itemscope itemtype="http://schema.org/Person">';


				$mdp_info .= '<link itemprop="url" href="http://microdataproject.org/author/' . $employee->user_login . '/"><meta itemprop="name" content="' . $employee_name . '"/>';

				/* email */
				if ($employee->user_email)
				{
					$mdp_info .= '<meta itemprop="email" content="' . $employee->user_email . '" />';
				}

				if ($employee->description)
				{

					$mdp_info .= '<meta itemprop="description" content="' . strip_tags($employee->description). '" />';
				}

				$mdp_info .= '</span>';
			}

			$mdp_info .= '</span>';

			return $mdp_info;

		}

		/** function/getFounder
		 * Usage: creates founders for schema
		 * Arg(0): null
		 * Return: founders schema
		 */
		private function getFounder()
		{

			$mdp_info = "";

			$founders = get_users('role=' . get_option('mdp_founder_role') . '&all_user_meta');

			$mdp_info .= '<span itemprop="founders" itemscope itemtype="http://schema.org/founders">';

			foreach ($founders as $founder)
			{

				if ($founder->display_name)
				{

					$founder_name = $founder->display_name;

				}
				else
				{

					$founder_name = $founder->user_nicename;
				}

				$mdp_info .= '<span itemprop="founder"  itemscope itemtype="http://schema.org/Person">';


				$mdp_info .= '<link itemprop="url" href="http://microdataproject.org/author/' . $founder->user_login . '/" title="' . $founder_name . '"><meta itemprop="name" content="' . $founder_name . '"/>';

				/* email */
				if ($founder->user_email)
				{
					$mdp_info .= '<meta itemprop="email" content="' . $founder->user_email . '" />';
				}

				if ($founder->description)
				{
					$mdp_info .= '<meta itemprop="description" content="' . strip_tags($founder->description). '" />';
				}

				$mdp_info .= '</span>';
			}

			$mdp_info .= '</span>';

			return $mdp_info;

		}

		public function getReviews()
		{

			global $wpdb;

			$pid = get_the_ID();
			$post = get_post($pid);
			$table_name = $wpdb->prefix . "mdp_reviews";

			$sql = "SELECT * FROM $table_name WHERE pid = '$post->ID'";
			$row = $wpdb->get_results($sql);

			if (!$row)
			{

				$mdpInfo = new mdpInfo();
				$mdpInfo->genReveiw($pid);

			}

			if (get_option('mdp_keyword'))
			{
				$mdp_keyword = get_option('mdp_keyword');
			}
			else
			{
				$mdp_keyword = get_bloginfo('name');
			}
			$review_body = str_replace('[keyword]' , $mdp_keyword , $row[0]->review_body);

			if (get_option('mdp_type'))
			{
				$type = get_option('mdp_type');
			}
			else
			{
				$type = 'LocalBusiness';
			}

			$mdp_info = "";

			$mdp_info .= '<span itemprop="reviews" itemscope itemtype="http://schema.org/reviews">';

			$mdp_info .= '<span itemscope itemtype="http://schema.org/WebPage">';

			$mdp_info .= '<link itemprop="url" href="' . get_bloginfo('url') . $_SERVER["REQUEST_URI"] . '"><meta itemprop="name" content="' . $post->post_title . '" />';

			$mdp_info .= '<span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';

			$mdp_info .= '<meta itemprop="ratingValue" content="5" />';

			$mdp_info .= '<meta itemprop="reviewCount" content="' . $row[0]->id . '" />';

			$mdp_info .= '</span>';

			$mdp_info .= '<span itemscope itemtype="http://schema.org/Review">';

			$mdp_info .= '<span itemprop="itemReviewed" itemscope itemtype="http://schema.org/' . $type . '">';

			$mdp_info .= '<link itemprop="url" href="' . get_bloginfo('url') . $_SERVER["REQUEST_URI"] . '"><meta itemprop="name" content="' . $post->post_title . '"/>';

			$mdp_info .= '</span>';

			$mdp_info .= '<meta itemprop="author" content="' . $row[0]->author . '" />';

			$mdp_info .= '<meta itemprop="datePublished" content="' . $row[0]->date_created . '" />';

			$mdp_info .= '<meta itemprop="description" content="' . $review_body . '" />';

			$mdp_info .= '<span itemprop="provider" itemscope itemtype="http://schema.org/Organization">';

			$mdp_info .= '<link itemprop="url" href="' . $row[0]->url . '" ><meta itemprop="name" content="' . $row[0]->provider . '" />';

			$mdp_info .= '<meta itemprop="description" content="' . $row[0]->description . '" />';

			$mdp_info .= '</span>';

			$mdp_info .= '</span>';

			$mdp_info .= '</span>';

			$mdp_info .= '</span>';

			return $mdp_info;

		}


		public function visuallyHiddenMdp()
		{

			echo '<style type="text/css"> .visually-hidden-mdp { border: 0; clip: rect(0 0 0 0); height: 1px; margin: -1px; overflow: hidden; padding: 0; position: absolute; width: 1px; }</style>';

		}

		public function getGeoLocation()
		{
			$address = get_option('mdp_street_address') . ', ' . get_option('mdp_address_locality') . ', ' . get_option('mdp_address_region') . ' ' . get_option('mdp_postal_code');

			// fetching lat&amp;lng from Google Maps
			$request_uri = 'http://maps.googleapis.com/maps/api/geocode/xml?address=' . urlencode($address). '&sensor=true';
			$google_xml = simplexml_load_file($request_uri);
			$lat = (string) $google_xml->result->geometry->location->lat;
			// fetching time from earth tools
			$lng = (string) $google_xml->result->geometry->location->lng;

			update_option('mdp_latitude' , $lat);
			update_option('mdp_longitude' , $lng);

		}


	}
}


add_filter('wp_head', array ( 'LocalBusiness' , 'visuallyHiddenMdp' ) );

if (get_the_content())
{
	add_filter('the_content' , array('LocalBusiness' , 'showLocalBusiness') , 20);
}
else
{
	add_filter('wp_footer' , array('LocalBusiness' , 'showLocalBusiness'));
}

$LocalBusiness = new LocalBusiness();

