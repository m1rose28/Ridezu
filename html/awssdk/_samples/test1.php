<?php

	// Enable full-blown error reporting. http://twitter.com/rasmus/status/7448448829
	error_reporting(E_ALL);
ini_set('display_errors', '1');


	// Set plain text headers
	header("Content-type: text/plain; charset=utf-8");
date_default_timezone_set('UTC');

	// Include the SDK
	require_once '../sdk.class.php';	

	// here's the code

	$s3 = new AmazonS3();
	


$bucket = 'ridezu' . strtolower($s3->key);
 
$response = $s3->create_object($bucket, 'test1.txt', array(
    'body' => 'This is my body text.'
));
 
// Success?
var_dump($response->isOK());
