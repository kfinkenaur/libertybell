<?php
// FMStudio v1.0 - do not remove comment, needed for DreamWeaver support
# FileName="Connection_php_FileMaker.htm"
# Type="FileMaker"
# FileMaker="true"
$path = preg_replace("#^(.*[/\\\\])[^/\\\\]*[/\\\\][^/\\\\]*$#",'\1',__FILE__);
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
require_once('FileMaker.php');
require_once('FileMaker/FMStudio_Tools.php');
$hostname_WebStore = "67.244.35.99";
$database_WebStore = "LibertyBellJobTracker";
$username_WebStore = "php";
$password_WebStore = "php";

$WebStore = new FileMaker($database_WebStore, $hostname_WebStore, $username_WebStore, $password_WebStore); 


$connected = $WebStore->listLayouts();

If(FileMaker::isError($connected)){
	
        echo "there is a problem connecting to the database";
		
		//echo "there is an issue connecting with php to this pick_pull_portal database";
		
		
} else {
	
        echo 'connected';
		
}





$my_hostname = $hostname_WebStore;

$my_database = $database_WebStore;

?>