<?php
 function getConnection() {
	$dbhost="localhost";
	$dbuser="ridezu";
	$dbpass="ridezu123";
	$dbname="ridezu";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}

function setHeader()
{ 
 $app = Slim::getInstance();
 $app->response()->header("Content-Type", "application/json");
}
 
function getHashKey()
{
	$app = Slim::getInstance();
	$req= $app->request();
	$hashkey=$req->headers('X-Signature');
	return $hashkey;
}
 
 function generateKey($id)
 {
	$key = md5( "xyx".$id."xyx");
	return $key;
 }

 ?>