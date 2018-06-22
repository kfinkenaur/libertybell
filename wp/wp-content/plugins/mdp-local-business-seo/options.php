<?php
include ( 'mdp_css.php' );
screen_icon ();
$mdpOptions = new mdpInfo();
?>
<div class="wrap">
<div class="right_block">
	<?php include ( 'mdp_contact.php' ); ?>
</div>
<div class="left_block">
<h2>Local Business SEO</h2>

<h3>
	<a href="http://www.google.com/webmasters/tools/richsnippets?q=<?php echo parse_url ( get_bloginfo ( 'url' ) , 1 ); ?>"
	   target="_blank">Preview your microdata</a></h3>

<form action="options.php" method="post" class="mdp_form">
<?php settings_fields ( $plugin_id . '_options' ); ?>
<table class="mdp_table">
<tr style="background:#eeeeee;">
	<td colspan="3"><h3>Business Information</h3></td>
</tr>
<tr>
	<td class="left">Status:</td>
	<td><select name="mdp_status">

			<?php if ( get_option ( 'mdp_status' ) == '1' ) { ?>
				<option value="1">Enabled</option>
				<option value="0">Disabled</option>
			<?php
			} else {
				?>
				<option value="0">Disabled</option>
				<option value="1">Enabled</option>
			<?php } ?>

		</select></td>
	<td></td>
</tr>
<tr>
	<td class="left">Business Type:</td>
	<td><select name="mdp_type">
			<?php if ( get_option ( 'mdp_type' ) !== '' ) { ?>
				<option
					value="<?php echo get_option ( 'mdp_type' ); ?>"><?php echo $mdpOptions->separateCapital ( get_option ( 'mdp_type' ) ); ?></option>
				<option value="">No Type</option>
			<?php
			} else {
				?>
				<option value="">No Type</option>
			<?php } ?>
			<option value="AccountingService">Accounting Service</option>
			<option value="AdultEntertainment">Adult Entertainment</option>
			<option value="AmusementPark">Amusement Park</option>
			<option value="AnimalShelter">Animal Shelter</option>
			<option value="ArtGallery">Art Gallery</option>
			<option value="Attorney">Attorney</option>
			<option value="AutoBodyShop">Auto Body Shop</option>
			<option value="AutoDealer">Auto Dealer</option>
			<option value="AutomatedTeller">Automated Teller</option>
			<option value="AutomotiveBusiness">Automotive Business</option>
			<option value="AutoPartsStore">Auto Parts Store</option>
			<option value="AutoRental">Auto Rental</option>
			<option value="AutoRepair">Auto Repair</option>
			<option value="AutoWash">Auto Wash</option>
			<option value="Bakery">Bakery</option>
			<option value="BankOrCreditUnion">Bank Or Credit Union</option>
			<option value="BarOrPub">Bar Or Pub</option>
			<option value="BeautySalon">Beauty Salon</option>
			<option value="BedAndBreakfast">Bed And Breakfast</option>
			<option value="BikeStore">Bike Store</option>
			<option value="BookStore">Book Store</option>
			<option value="BowlingAlley">Bowling Alley</option>
			<option value="Brewery">Brewery</option>
			<option value="CafeOrCoffee Shop">Cafe Or CoffeeShop</option>
			<option value="Casino">Casino</option>
			<option value="ChildCare">Child Care</option>
			<option value="ClothingStore">Clothing Store</option>
			<option value="ComedyClub">Comedy Club</option>
			<option value="ComputerStore">Computer Store</option>
			<option value="ConvenienceStore">Convenience Store</option>
			<option value="DaySpa">Day Spa</option>
			<option value="Dentist">Dentist</option>
			<option value="DepartmentStore">Department Store</option>
			<option value="DiagnosticLab">Diagnostic Lab</option>
			<option value="DryCleaningOrLaundry">Dry Cleaning Or Laundry</option>
			<option value="Electrician">Electrician</option>
			<option value="ElectronicsStore">Electronics Store</option>
			<option value="EmergencyService">EmergencyService</option>
			<option value="EmploymentAgency">Employment Agency</option>
			<option value="EntertainmentBusiness">Entertainment Business</option>
			<option value="ExerciseGym">Exercise Gym</option>
			<option value="FastFoodRestaurant">Fast Food Restaurant</option>
			<option value="FireStation">Fire Station</option>
			<option value="FinancialService">Financial Service</option>
			<option value="Florist">Florist</option>
			<option value="FoodEstablishment">Food Establishment</option>
			<option value="FurnitureStore">Furniture Store</option>
			<option value="GardenStore">Garden Store</option>
			<option value="GasStation">Gas Station</option>
			<option value="GeneralContractor">General Contractor</option>
			<option value="GolfCourse">Golf Course</option>
			<option value="GroceryStore">Grocery Store</option>
			<option value="GovernmentOffice">Government Office</option>
			<option value="HairSalon">Hair Salon</option>
			<option value="HardwareStore">Hardware Store</option>
			<option value="HealthAndBeautyBusiness">Health And Beauty Business</option>
			<option value="HealthClub">Health Club</option>
			<option value="HobbyShop">HobbyShop</option>
			<option value="HomeAndConstructionBusiness">Home and Construction Business</option>
			<option value="HomeGoodsStore">Home Goods Store</option>
			<option value="Hospital">Hospital</option>
			<option value="Hostel">Hostel</option>
			<option value="Hotel">Hotel</option>
			<option value="HousePainter">House Painter</option>
			<option value="HVACBusiness">HVAC Business</option>
			<option value="IceCreamShop">Ice Cream Shop</option>
			<option value="InsuranceAgency">Insurance Agency</option>
			<option value="InternetCafe">Internet Cafe</option>
			<option value="JewelryStore">JewelryStore</option>
			<option value="Library">Library</option>
			<option value="LiquorStore">Liquor Store</option>
			<option value="Locksmith">Locksmith</option>
			<option value="LodgingBusiness">Lodging Business</option>
			<option value="MedicalClinic">Medical Clinic</option>
			<option value="MedicalOrganization">Medical Organization</option>
			<option value="MensClothingStore">Mens Clothing Store</option>
			<option value="MobilePhoneStore">Mobile Phone Store</option>
			<option value="Motel">Motel</option>
			<option value="MotorcycleDealer">Motorcycle Dealer</option>
			<option value="MotorcycleRepair">Motorcycle Repair</option>
			<option value="MovieRentalStore">Movie Rental Store</option>
			<option value="MovieTheater">Movie Theater</option>
			<option value="MovingCompany">Moving Company</option>
			<option value="MusicStore">Music Store</option>
			<option value="NailSalon">Nail Salon</option>
			<option value="NightClub ">Night Club</option>
			<option value="Notary">Notary</option>
			<option value="OfficeEquipmentStore">Office Equipment Store</option>
			<option value="Optician">Optician</option>
			<option value="OutletStore">Outlet Store</option>
			<option value="PawnShop">Pawn Shop</option>
			<option value="PetStore">Pet Store</option>
			<option value="Pharmacy">Pharmacy</option>
			<option value="Physician">Physician</option>
			<option value="Plumber">Plumber</option>
			<option value="PoliceStation">Police Station</option>
			<option value="PostOffice">Post Office</option>
			<option value="ProfessionalService">Professional Service</option>
			<option value="PublicSwimmingPool">Public Swimming Pool</option>
			<option value="RadioStation">Radio Station</option>
			<option value="RealEstateAgent">Real Estate Agent</option>
			<option value="RecyclingCenter">Recycling Center</option>
			<option value="Restaurant">Restaurant</option>
			<option value="RoofingContractor">Roofing Contractor</option>
			<option value="SelfStorage">Self Storage</option>
			<option value="ShoeStore">Shoe Store</option>
			<option value="ShoppingCenter">Shopping Center</option>
			<option value="SkiResort">Ski Resort</option>
			<option value="SportsActivityLocation">Sports Activity Location</option>
			<option value="SportingGoodsStore">Sporting Goods Store</option>
			<option value="SportsClub">Sports Club</option>
			<option value="Store">Store</option>
			<option value="StadiumOrArena">Stadium Or Arena</option>
			<option value="TattooParlor">Tattoo Parlor</option>
			<option value="TelevisionStation">Television Station</option>
			<option value="TennisComplex">Tennis Complex</option>
			<option value="TireShop">Tire Shop</option>
			<option value="TouristInformationCenter">Tourist Information Center</option>
			<option value="ToyStore">Toy Store</option>
			<option value="TravelAgency">Travel Agency</option>
			<option value="VeterinaryCare">Veterinary Care</option>
			<option value="WholesaleStore">Wholesale Store</option>
			<option value="Winery">Winery</option>
		</select></td>
	<td>Select your type of business.</td>
</tr>
<tr>
	<td>Business Name:</td>
	<td><input type="text" name="mdp_name" value="<?php echo get_option ( 'mdp_name' ); ?>"/></td>
	<td>Will use the site name if left empty.</td>
</tr>
<tr>
	<td>Business Description:</td>
	<td><input type="text" name="mdp_description" value="<?php echo get_option ( 'mdp_description' ); ?>"
	           placeholder="Very important, try to be as descriptive as possible."/></td>
	<td>Keep less than 150 characters, will use site description if left empty.</td>
</tr>
<tr>
	<td>Website Url:</td>
	<td><input type="text" name="mdp_url" value="<?php echo get_option ( 'mdp_url' ); ?>"
	           placeholder="<?php echo get_bloginfo ( 'url' ); ?>"/></td>
	<td>Will use the website url if left empty.</td>
</tr>
<tr>
	<td>Logo / Image Location:</td>
	<td><input type="text" name="mdp_image" value="<?php echo get_option ( 'mdp_image' ); ?>"
	           placeholder="<?php echo get_bloginfo ( 'url' ); ?>/images/logo.jpg"/></td>
	<td>Not Required</td>
</tr>
<tr>
	<td>Reference Url:</td>
	<td><input type="text" name="mdp_sameas" value="<?php echo get_option ( 'mdp_sameas' ); ?>"
	           placeholder="http://wiki.<?php echo parse_url ( get_bloginfo ( 'url' ) , 1 ); ?>"/></td>
	<td>Not Required</td>
</tr>
<tr>
	<td>Payments Accepted:</td>
	<td><input type="text" name="mdp_payment_accepted"
	           value="<?php echo get_option ( 'mdp_payment_accepted' ); ?>"
	           placeholder="Visa, Master Card, Check, Cash"/></td>
	<td>Not Required</td>
</tr>
<tr>
	<td>Price Range:</td>
	<td><input type="text" name="mdp_price_range" value="<?php echo get_option ( 'mdp_price_range' ); ?>"
	           placeholder="for inexpensive $ for expensive $$$$$"/></td>
	<td>Not Required</td>
</tr>
<tr>
	<td class="left">Street Address:</td>
	<td><input type="text" value="<?php echo get_option ( 'mdp_street_address' ); ?>"
	           name="mdp_street_address"/></td>
	<td>Required if using Geo Location.</td>
</tr>
<tr>
	<td>City:</td>
	<td><input type="text" name="mdp_address_locality"
	           value="<?php echo get_option ( 'mdp_address_locality' ); ?>"/></td>
	<td>Required.</td>
</tr>
<tr>
	<td>State:</td>
	<td><input type="text" name="mdp_address_region"
	           value="<?php echo get_option ( 'mdp_address_region' ); ?>"/></td>
	<td>Required.</td>
</tr>
<tr>
	<td>Zip:</td>
	<td><input type="text" name="mdp_postal_code" value="<?php echo get_option ( 'mdp_postal_code' ); ?>"/>
	</td>
	<td>Can be left empty but not recommended.</td>
</tr>
<tr>
	<td>Country:</td>
	<td><input type="text" name="mdp_address_country"
	           value="<?php echo get_option ( 'mdp_address_country' ); ?>"/></td>
	<td>Can be left empty but not recommended.</td>
</tr>

<tr style="background:#eeeeee;">
	<td colspan="3"><h3>Geo Location</h3></td>
</tr>
<tr>
	<td>Use Geolocation</td>
	<td colspan="2"><input type="checkbox"
	                       name="mdp_geo_location" <?php if ( get_option ( 'mdp_geo_location' ) == 'on' ) {
			echo 'checked';
		} ?> /> This will use Googles api to generate your geo location from the address entered above.
	</td>
</tr>

<tr style="background:#eeeeee;">
	<td colspan="3"><h3>Contacts and Hours of operation</h3></td>
</tr>
<tr>
	<td>Email:</td>
	<td><input type="text" name="mdp_email" value="<?php echo get_option ( 'mdp_email' ); ?>"/></td>
	<td>Can be left empty but not recommended.</td>
</tr>
<tr>
	<td>Telephone:</td>
	<td><input type="text" name="mdp_telephone" value="<?php echo get_option ( 'mdp_telephone' ); ?>"/></td>
	<td>Can be left empty but not recommended.</td>
</tr>
<tr>
	<td>Fax:</td>
	<td><input type="text" name="mdp_fax_number" value="<?php echo get_option ( 'mdp_fax_number' ); ?>"/>
	</td>
	<td>Can be left empty but not recommended.</td>
</tr>
<tr>
	<td>Open:</td>
	<td><input type="text" name="mdp_open" value="<?php echo get_option ( 'mdp_open' ); ?>"
	           placeholder="9:00"/></td>
	<td>Can be left empty but not recommended.</td>
</tr>
<tr>
	<td>Close:</td>
	<td><input type="text" name="mdp_close" value="<?php echo get_option ( 'mdp_close' ); ?>"
	           placeholder="17:00"/></td>
	<td>Can be left empty but not recommended.</td>
</tr>
<tr>
	<td>Days of Week:</td>
	<td><input type="text" name="mdp_dow" value="<?php echo get_option ( 'mdp_dow' ); ?>"
	           placeholder="Mo, Tu, We, Th, Fr, Sa, Su or Mo - Fr"/></td>
	<td>Can be left empty but not recommended must use two letter abbreviations.</td>
</tr>

<tr style="background:#eeeeee;">
	<td colspan="3"><h3>Website Rating</h3></td>
</tr>
<tr>
	<td class="left">Rating Value:</td>
	<td><input type="text" value="<?php echo get_option ( 'mdp_rating_value' ); ?>" name="mdp_rating_value"
	           placeholder="5"/></td>
	<td>From 1 to 5, required if using rating.</td>
</tr>
<tr>
	<td>Best Rating:</td>
	<td><input type="text" name="mdp_best_rating" value="<?php echo get_option ( 'mdp_best_rating' ); ?>"
	           placeholder="5"/></td>
	<td>From 1 to 5, required if using rating.</td>
</tr>
<tr>
	<td>Worst Rating:</td>
	<td><input type="text" name="mdp_worst_rating" value="<?php echo get_option ( 'mdp_worst_rating' ); ?>"
	           placeholder="5"/></td>
	<td>From 1 to 5, required if using rating.</td>
</tr>
<tr>
	<td>Rating Count:</td>
	<td><input type="text" name="mdp_rating_count" value="<?php echo get_option ( 'mdp_rating_count' ); ?>"
	           placeholder="239"/></td>
	<td>Required if using rating.</td>
</tr>
<tr style="background:#eeeeee;">
	<td colspan="3"><h3>Employees / Founders</h3></td>
</tr>
<tr>
	<td colspan="3">Both employees and founders can be selected by roles. All the users within those roles
		will be listed in the microdata. Name, Email, and Description is added from the users profile.
		If there is no display name the nice name will be used.
	</td>
</tr>
<tr>
	<td class="left">Employee Role:</td>
	<td><select name="mdp_employee_role">
			<?php if ( get_option ( 'mdp_employee_role' ) ) { ?>
				<option
				value="<?php echo get_option ( 'mdp_employee_role' ); ?>"><?php echo ucwords ( get_option ( 'mdp_employee_role' ) ); ?></option><?php } ?>
			<option value="">None</option>
			<?php wp_dropdown_roles (); ?></select></td>
	<td>Select role to associate with employees.</td>
</tr>
<tr>
	<td class="left">Founder Role:</td>
	<td><select name="mdp_founder_role">
			<?php if ( get_option ( 'mdp_founder_role' ) ) { ?>
				<option
				value="<?php echo get_option ( 'mdp_founder_role' ); ?>"><?php echo ucwords ( get_option ( 'mdp_founder_role' ) ); ?></option><?php } ?>
			<option value="">None</option>
			<?php wp_dropdown_roles (); ?></select></td>
	<td>Select role to associate with founders.</td>
</tr>

<tr style="background:#eeeeee;">
	<td colspan="3"><h3>Seeks / Demand</h3></td>
</tr>
<tr>
	<td colspan="3">Seeks sets a demand through microdata, this can effectively build your ranking through
		the use of microdata sharing. Setting a seeks to a website that is growing through Seo can
		instantly effect your ranking. The default method uses the microdata from multiple websites.
	</td>
</tr>

<tr>
	<td>Use Seeks:</td>
	<td colspan="2"><input type="checkbox" name="mdp_seeks"
	                       id="mdp_seeks" <?php if ( get_option ( 'mdp_seeks' ) == 'on' ) {
			echo 'checked';
		} ?> />
	</td>
</tr>
<tr>
	<td>Seeks Name:</td>
	<td><input type="text" name="mdp_seeks_name" id="mdp_seeks_name"
	           value="<?php echo get_option ( 'mdp_seeks_name' ); ?>" placeholder="Seo"/></td>
	<td>Required if using seeks.</td>
</tr>
<tr>
	<td>Seeks Url:</td>
	<td><input type="text" name="mdp_seeks_url" id="mdp_seeks_url"
	           value="<?php echo get_option ( 'mdp_seeks_url' ); ?>" placeholder="http://sidcreations.com"/>
	</td>
	<td>Required if using seeks.</td>
</tr>
<tr>
	<td>Seek Description:</td>
	<td><input type="text" name="mdp_seeks_description" id="mdp_seeks_description"
	           value="<?php echo get_option ( 'mdp_seeks_description' ); ?>"/></td>
	<td>Not required</td>
</tr>

<tr style="background:#eeeeee;">
	<td colspan="3"><h3>Member</h3></td>
</tr>
<tr>
	<td colspan="3">Member does just that it states you are a member of this website/organization. The
		purpose of this is to share microdata on a algorithmic level without sharing content. This can
		can boost your sites ranking if the site you select as a member does produce effective and
		efficient microdata. The default method uses the microdata from the <a
			href="http://microdataproject.org">Microdata Project</a> website.
	</td>
</tr>
<tr>
	<td>Use Member:</td>
	<td colspan="2"><input type="checkbox"
	                       name="mdp_member" <?php if ( get_option ( 'mdp_member' ) == 'on' ) {
			echo 'checked';
		} ?> />
	</td>
</tr>
<tr>
	<td>Member Name:</td>
	<td><input type="text" name="mdp_member_name" value="<?php echo get_option ( 'mdp_member_name' ); ?>"
	           placeholder="Microdata Project"/></td>
	<td>Required if using seeks.</td>
</tr>
<tr>
	<td>member Url:</td>
	<td><input type="text" name="mdp_member_url" value="<?php echo get_option ( 'mdp_member_url' ); ?>"
	           placeholder="http://microdataproject.org"/></td>
	<td>Required if using seeks.</td>
</tr>
<tr>
	<td>Member Description:</td>
	<td><input type="text" name="mdp_member_description"
	           value="<?php echo get_option ( 'mdp_member_description' ); ?>"/></td>
	<td>Not required</td>
</tr>
<tr>
	<td>Member Name:</td>
	<td><input type="text" name="mdp_member_name" value="<?php echo get_option ( 'mdp_member_name' ); ?>"
	           placeholder="Microdata Project"/></td>
	<td>Required if using seeks.</td>
</tr>
<tr>
	<td colspan="3"></td>
</tr>
<tr>
	<td colspan="3"><?php submit_button (); ?></td>
</tr>
</table>
</form>
<h3>
	<a href="http://www.google.com/webmasters/tools/richsnippets?q=<?php echo parse_url ( get_bloginfo ( 'url' ) , 1 ); ?>"
	   target="_blank">Preview your microdata</a></h3>
</div>
</div>