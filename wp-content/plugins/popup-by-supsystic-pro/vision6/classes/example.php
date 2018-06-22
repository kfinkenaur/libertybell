<?php

    require_once('api.class.php');

    //
    // :TODO: Set the API endpoint URL and your API key
    //
    // Please refer to the documentation for instructions on how to generate an API key.
    //
    // Replace <your_login_hostname> with the hostname you use to access the system.
    // This is the same hostname which appears in your browsers address bar after you log into the system.
    //
    $url = 'http://<your_login_hostname>/api/jsonrpcserver';
    $api_key = 'YOUR-API-KEY';


    // Create API wrapper object
    $api = new Api($url, $api_key, '3.0');

    // Enable request debugging
    $api->setDebug(true);

    // Call getSessionInfo
    $result = $api->invokeMethod('getSessionInfo');

    print_r($result);

?>