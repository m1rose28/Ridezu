<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("ridezu");
				
//$result = mysql_query("SELECT fullhomeaddress FROM footprint where latlong is null limit 0,500");
$result = mysql_query("SELECT fullworkaddress FROM footprint where workadd1 is null GROUP BY fullworkaddress limit 0,100");

//$mapengine="mapquest";
$mapengine="google";
		
while($row = mysql_fetch_array($result))
	{
	usleep(100000);
	$adda="";
	$addb="";
	$add1="";
	$city="";
	$zip="";
	$country="";
	$state="";
	$latlong="";
	$lat="";
	$lng="";
	$note="";
	
//	$fullhomeaddress=$row['fullhomeaddress'];
	$fullhomeaddress=$row['fullworkaddress'];


	if($mapengine=="google"){

		$url="http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($fullhomeaddress)."&sensor=false";urlencode($url);
		$data = file_get_contents($url);
	
		$json=json_decode($data,TRUE);

		$lat=$json["results"]["0"]["geometry"]["location"]["lat"];
		$lng=$json["results"]["0"]["geometry"]["location"]["lng"];
		$ac=$json["results"]["0"]["address_components"];
		$note="";
		
		foreach ($ac as $d => $value) {
		  $longname=$json["results"]["0"]["address_components"][$d]["long_name"];
		  $types=$json["results"]["0"]["address_components"][$d]["types"]["0"];
		  
		  if($types=="postal_code"){$zip=$longname;}
		  if($types=="street_number"){$adda=$longname;}
		  if($types=="route"){$addb=$longname;}
		  if($types=="locality"){$city=$longname;}
		  if($types=="administrative_area_level_1"){$state=$longname;}
		  if($types=="country"){$country=$longname;}
	
		$add1=$adda." ".$addb;
		$match=$json["results"]["0"]["geometry"]["location_type"];
	
		}
	}

	if($mapengine=="mapquest"){
	
		$url="http://open.mapquestapi.com/geocoding/v1/address?inFormat=kvp&outFormat=json&location=".urlencode($fullhomeaddress)."&thumbMaps=false";	
		$data = file_get_contents($url);
	
		$json=json_decode($data,TRUE);

		$lat=addslashes($json["results"]["0"]["locations"]["0"]["latLng"]["lat"]);
		$lng=addslashes($json["results"]["0"]["locations"]["0"]["latLng"]["lng"]);
		$note="";
		
		$add1=addslashes($json["results"]["0"]["locations"]["0"]["street"]);
		$city=addslashes($json["results"]["0"]["locations"]["0"]["adminArea5"]);
		$zip=addslashes($json["results"]["0"]["locations"]["0"]["postalCode"]);
		$country=addslashes($json["results"]["0"]["locations"]["0"]["adminArea1"]);
		$state=addslashes($json["results"]["0"]["locations"]["0"]["adminArea3"]);
	
		$match=$json["results"]["0"]["geometry"]["location_type"];
	
	}
	

  	if($add1==" "){$note="APPROXIMATE";}

	echo "<pre>";
	//print_r($json);
	$latlong=$lat.",".$lng;
	echo "<br>Address:".$add1.":".$city.":".$state.":".$zip.":".$country.":".$latlong;
	echo "<br>Match".$match;	
	if($city!=""){
		//$q="UPDATE footprint SET add1='$add1',city='$city',state='$state',zip='$zip',latlong='$latlong',note='$note' WHERE fullhomeaddress='$fullhomeaddress'";
		$q="UPDATE footprint SET workadd1='$add1',workcity='$city',workstate='$state',workzip='$zip',worklatlong='$latlong',note='$note' WHERE fullworkaddress='$fullhomeaddress'";

		$d=mysql_query($q);
		echo "<br>$d";
		echo "<br>Row updated";
		}
	
	echo "<br>$fullhomeaddress";	
	echo "<br>$url";
	echo "</pre>";
	}


?>

