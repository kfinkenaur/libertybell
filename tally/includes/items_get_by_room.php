<?php

include_once 'dbconn.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$room_name=$_POST['roomName'];

switch($room_name){
		
	case "Living Room":
		$room_name='%living_room%';
		break;
	case "Dining Room":
		$room_name="%dining_room%";
		break;		
	case "Kitchen":
		$room_name='%kitchen%';
		break;
	case "Bedroom":
		$room_name="%bedroom%";
		break;		
	case "Basement":
		$room_name='%basement%';
		break;
	case "Garage":
		$room_name="%garage%";
		break;			
		
}


$dsn='mysql:host='.$hostname.';dbname=liberuy2_newwp';

$dbh=new PDO($dsn,$db_username,$db_password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
$stmt=$dbh->prepare("SELECT * FROM tally_pack_kits WHERE room_name LIKE :room_name");
$stmt->execute(array('room_name'=>$room_name));

# Get array containing all of the result rows
$resultArray = $stmt->fetchALL(PDO::FETCH_ASSOC);



echo json_encode($resultArray);