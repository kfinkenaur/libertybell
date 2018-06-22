<?php
class admin{
function nsgrp_google_reviews_on_pages_int() {
	global $wpdb;
	$table_name =@$wpdb->prefix . 'Google_Reviews_On_Pages';
	if (isset($_POST["submit"])) {
	$pid=sanitize_text_field($_POST['placeid']);
	$apikey=sanitize_text_field($_POST['key']);
	$ids=intval($_POST['ids']);
	if($ids)
	{
	$que="SELECT id FROM ".$table_name." where id=".$ids;
	$res_id=@$wpdb->get_var(@$wpdb->prepare($que));
	}
	
	//echo $res_id;
	if(@$res_id)
	{
	       @$wpdb->prepare(@$wpdb->update(
		$table_name, 
		array( 
			'placeid' => sanitize_text_field($_POST['placeid']), 
			'api_key' => sanitize_text_field($_POST['key']), 
		), array('id' => $res_id), array('%s', '%s'))); 
		
		echo '<div class="updated"><p>Settings have been updated successfully.</p></div>';  
	}
	else
	{
	@$wpdb->prepare(@$wpdb->insert(
		$table_name, 
		array( 
			'placeid' => sanitize_text_field($_POST['placeid']), 
			'api_key' => sanitize_text_field($_POST['key']), 
		) 
	));   
	 if(@$wpdb->insert_id) { 
	
	  echo '<div class="updated"><p>Settings have been Added successfully.</p></div>';
	                                                        }
 }

}
	$table_name = $wpdb->prefix .'Google_Reviews_On_Pages';
	$api_key = $wpdb->get_var(@$wpdb->prepare("SELECT api_key FROM ".$table_name));
	$placeid = $wpdb->get_var(@$wpdb->prepare("SELECT placeid FROM ".$table_name));
	$id = $wpdb->get_var(@$wpdb->prepare("SELECT id FROM ".$table_name));
echo '<div style="width:95%;border:1px solid #f5f5f5;border-radius:5px;margin-top: 10px;background-color: #FBFBFB;"><div style="width:95%;padding-left:20px;"><h1>Google API Settings</h1><form method="post" action="#">';
wp_nonce_field();
echo '<div style="margin-bottom:10px;margin-top:10px;"><span style="min-width:200px;float:left;"><lable>Google API Place Id</lable></span><span><input type="text" name="placeid" id="placeid"  style="width:300px;" value="'.$placeid.'"></span></div>
<div style="margin-bottom:10px;"><span style="min-width:200px;float:left;"><lable>Google API Key</lable></span><span ><input type="text" name="key" id="key"  style="width:300px;" value="'.$api_key.'"><input type="hidden" name="ids" id="ids"  style="width:300px;" value="'.$id.'"></span></div>
<div><input type="submit" value="Save" name="submit"  style="width:100px;"></div>
</form>';

echo '<div style="width: 100%;padding-left:20px;margin-top:10px;float:left;margin-bottom:10px;padding-top:20px;padding-bottom:20px;background-color: #E3E3E3;border-radius: 5px;" class="shortcodes"><div style="margin-bottom:10px;margin-top:10px;width:100%;float:left;"><p style="font-size:18px;font-weight:bold;">Short code for Google Reviews &nbsp;&nbsp;[reviews]</p><p style="font-size:16px;"><span style="color:#C00000;font-weight:bold;font-size:18px;">Note:</span>&nbsp;&nbsp;You can place this code in any page </p></div><div style="float:left;width:100%;"><h1>Get an API key</h1><p style="font-size:16px;">1. Go to the <a href="https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend&keyType=CLIENT_SIDE&reusekey=true&pli=1" target="_blank">Google API Console.</a></p><p style="font-size:16px;">2. Create or select a project.</p><p style="font-size:16px;">3. Click Continue to enable the API and any related services..</p><p style="font-size:16px;">4. On the Overview page search API “Google Places API Web Service” and Enable it.</p><p style="font-size:16px;">5. On the Credentials page, Select API Key get a Browser key (and set the API Credentials) </p><p style="font-size:16px;">6. Note: If you have an existing Browser key, you may use that key.</p><p style="font-size:16px;"><span style="color:#C00000;font-weight:bold;font-size:18px;">Note*</span> If  Browser key does not work, Please generate and use Server key instead.</p></div></br><div style="float:left;width:100%;"><h1>Get a Place ID</h1><p style="font-size:16px;">1. Go to the <a href="https://developers.google.com/places/place-id" target="_blank">Get Place ID</a></p><p style="font-size:16px;">2. Enter location, copy the Place ID</p></div></div></div>';
}
}
?>