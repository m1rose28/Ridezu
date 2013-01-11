<?php

require 'facebooksdk/src/facebook.php';

if(isset($_GET["accesstoken"])){$accesstoken=$_GET["accesstoken"];}

$facebook = new Facebook(array(
  'appId'  => '443508415694320',
  'secret' => '4dfa4c513a904dbf69a46f854b163eeb',
));

//$fbtoken="AAAGTXlmShfABALmSbzfNgRzYYZBu0O6hJ59E2js10UWqZAfBAqar9lZBvXwvyZAbhi418seafyzFZCN3qC7hC4J3HjBqM2zWNqezFewqSKAZDZD"; //mark
//$fbtoken="AAAGTXlmShfABAFiYZCynncqKdk88GLeYizDOlW10dvNgLYsx2E5Ott4hSOwAe00sDMyzdeNiIyw0ssEVQOZCFo2tT3RFZB2eIs8kSdbLgZDZD";//lynn

//set access token
$facebook->setAccessToken($accesstoken);

// Get User ID
$user = $facebook->getUser();

//connect to db

$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("ridezu");
				
$result = mysql_query("SELECT seckey FROM userprofile WHERE fbid='$user'");
		
while($row = mysql_fetch_array($result))
	{
	 $seckey=$row['seckey'];
	  }

if(isset($seckey)){ 	 

	  echo "{\"fbid\":\"$user\",\"seckey\":\"$seckey\"}";
	}

if(isset($seckey)==false && $user!="0") { 	 

	  echo "{\"fbid\":\"$user\",\"seckey\":\"na\"}";
	}

if(isset($seckey)==false && $user=="0") { 	 

	  echo "{\"fbid\":\"na\",\"seckey\":\"na\"}";
	}

?>
