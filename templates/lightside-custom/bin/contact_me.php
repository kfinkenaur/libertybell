<?php
// check if fields passed are empty
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }
	

$name = $_POST['name'];
$phone = $_POST['phone'];
$email_address = $_POST['email'];


if (isset($_POST['contact_preference']))   // if ANY of the options was checked
  $contact_preference = $_POST['contact_preference'];    // echo the choice
else
  $contact_preference = "nothing was selected.";
  
  

$from_street = $_POST['from_street'];
$from_city = $_POST['from_city'];
$from_state = $_POST['from_state'];
$to_street = $_POST['to_street'];
$to_city = $_POST['to_city'];
$to_state = $_POST['to_state'];
$move_out = $_POST['move_out'];
$move_in = $_POST['move_in'];
$distance = $_POST['distance'];
$floor = $_POST['floor'];

$move_type = $_POST['move_type'];
$bedrooms = $_POST['bedrooms'];
$storage = $_POST['storage'];
$items = $_POST['items'];
$stuff = $_POST['stuff'];


if (isset($_POST['help_packing']))   // if ANY of the options was checked
  $help_packing = $_POST['help_packing'];    // echo the choice
else
  $help_packing = "nothing was selected.";
  
if (isset($_POST['all_contents']))   // if ANY of the options was checked
  $all_contents = $_POST['all_contents'];    // echo the choice
else
  $all_contents = "nothing was selected."; 

if (isset($_POST['park_distance']))   // if ANY of the options was checked
  $park_distance = $_POST['park_distance'];    // echo the choice
else
  $park_distance = "nothing was selected for distance from unit.";
    

if (isset($_POST['permit']))   // if ANY of the options was checked
  $permit = $_POST['permit'];    // echo the choice
else
  $permit = "nothing was selected.";

  if (isset($_POST['elevator']))   // if ANY of the options was checked
  $elevator = $_POST['elevator'];    // echo the choice
else
  $elevator = "nothing was selected.";
  
  if (isset($_POST['furniture_repair']))   // if ANY of the options was checked
  $furniture_repair = $_POST['furniture_repair'];    // echo the choice
else
  $furniture_repair = "nothing was selected.";
  
  if (isset($_POST['start_preference']))   // if ANY of the options was checked
  $start_preference = $_POST['start_preference'];    // echo the choice
else
  $start_preference = "nothing was selected.";
  
  if (isset($_POST['moved_before']))   // if ANY of the options was checked
  $moved_before = $_POST['moved_before'];    // echo the choice
else
  $moved_before = "nothing was selected.";

  

  
 

	
// create email body and send it	
$to = 'service@libertybellmoving.com'; // put your email
$email_subject = "LBMS Contact form submitted by:  $name ";
$email_body = "You have received a new message. \n\n ".
				  " Here are the details:\n \nName: $name \n ".
				  "Phone: $phone\n Email: $email_address\n ".
				  "Contact Preference: $contact_preference\n ".
				  "Type of Move: $move_type\n ".
				  "Number of Bedrooms: $bedrooms\n ".
				  "Current Address: $from_street  $from_city, $from_state\n ".
				  "New Address: $to_street  $to_city, $to_state\n ".
				  "Expected Move Out Date: $move_out\n ".
				  "Expected Move In Date: $move_in\n ".
				  
				  "\n \n Additional Details: \n Do you need help packing: $help_packing\n\n ".
				  "Are all contents in your home being moved?   $all_contents\n\n ".
				  "Is there a storage unit associated with your move?   $storage\n\n ".
				  "Are there items in the basement, attic, or garage?   $items\n\n ".
				  "Are all contents in your home being moved?   $all_contents\n\n ".
				  "In general, how much 'stuff' would you say you have?   $stuff\n\n ".
				  "Can our moving van park within 30' of the entrance of your home and your new apartment?   $park_distance\n\n ".
				  "Are parking permits needed in order to meet the 30' carry requirements?   $permit\n\n ".
				  "How many ft' from the entrance of your new apartment building is your apartment? (1-300' in 10ft increments)    $distance \n\n ".
				  "What floor are you moving to?  $floor\n\n ".
				  "Is there an elevator?   $elevator\n\n ".
				  "We also provide professional furniture refinishing and upholstery services. Do any of your furnishings need repair, refinishing or new upholstery?   $furniture_repair\n\n ".
				  "Which start time do you prefer?   $start_preference\n\n ".
				  "Have you ever used a moving company before and are you familiar with the process in general?   $moved_before\n\n ";				  
				  
$headers = "From: service@libertybellmoving.com\n";
$headers .= "Reply-To: $email_address";	
mail($to,$email_subject,$email_body,$headers);
return true;			
?>