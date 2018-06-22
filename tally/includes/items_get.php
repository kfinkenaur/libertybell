<?php

include_once 'dbconn.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pack_kit_recid=$_POST['recid'];
$room_name=$_POST['roomName'];


$dsn='mysql:host='.$hostname.';dbname=liberuy2_newwp';

$dbh=new PDO($dsn,$db_username,$db_password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
$stmt=$dbh->prepare("SELECT * FROM tally_pack_kits WHERE pack_kit_recid =:pack_kit_recid");
$stmt->execute(array('pack_kit_recid'=>$pack_kit_recid));

# Get array containing all of the result rows
$resultArray = $stmt->fetch(PDO::FETCH_ASSOC);

	
	$newArray=array(
	
			'pack_kit_recid' => $resultArray[ 'pack_kit_recid' ],
			'room_name' => $room_name,
			'pack_kit_name' => $resultArray[ 'pack_kit_name' ],
			'bulk_item' => $resultArray[ 'bulk_item' ],
			'specialty_item' => $resultArray[ 'specialty_item' ],
			'weight' => $resultArray[ 'weight' ],
			'cubes' => $resultArray[ 'cubes' ],
			'labor_factor' => $resultArray[ 'labor_factor' ]
		);


echo json_encode($newArray);