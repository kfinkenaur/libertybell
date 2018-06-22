<?php
session_start();
$_SESSION['NO_SWITCH'] = true;
if(isset($_GET['current']))
	$link = $_GET['current'];
else
	$link="/";
header("Location: ".$link);
?>