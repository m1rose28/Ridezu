<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../util.php';
require '../model/user.php';
require '../model/notification.php';
require '../model/node.php';

$company="";

// first let's see if there are any pending jobs (this is in notifications)

	$sql = "SELECT company FROM newemployeeload where status='PENDING' limit 0,1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	try { 
		$stmt->execute();
		$data = $stmt->fetchObject();
		print_r($data);
		if(isset($data->company)){$company=$data->company;}
		echo $company;
		}
	catch (PDOException $e){
		//echo $e->getMessage();
		}

// then if a pending item exists lets process (otherwise do nothing)

if($company!=""){

// next lets get a group of users for that company..

	$sql = "SELECT fname,lname,id,add1,state,city,zip,attempts,email,campuslatlong,campus FROM newemployeestaging where company=:company and latlong is null limit 0,10";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("company", $company);
	//echo $sql;
	try { 
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_OBJ);
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
		}
	catch (PDOException $e){
		//echo $e->getMessage();
		}

// let's see how many people are in the array. if 0, then the job is done

	$countlog = count($data);

// next lets walk through each item with and look for a latlong
	
	foreach ($data as $value) {
		//print_r($value);
		$fname=$value->fname;
		$lname=$value->lname;
		$id=$value->id;
		$add1=$value->add1;
		$state=$value->state;
		$city=$value->city;
		$zip=$value->zip;
		$attempts=$value->attempts;	
		$email=$value->email;	
		$campuslatlong=$value->campuslatlong;	
		$campus=$value->campus;	
		$fullhomeaddress=$add1." ".$city.", ".$state." ".$zip;
		//echo $fullhomeaddress;

//ok let's try first to get the data via mapquest

		$url="http://open.mapquestapi.com/geocoding/v1/address?inFormat=kvp&outFormat=json&location=".urlencode($fullhomeaddress)."&thumbMaps=false";	
		$mapquestdata = file_get_contents($url);
		$success=1;
		
		//echo "<br>$url";
	
		$json=json_decode($mapquestdata,TRUE);
		
		//print_r($json);

		if(isset($json["results"]["0"]["locations"]["0"]["latLng"]["lat"])){
			$lat=addslashes($json["results"]["0"]["locations"]["0"]["latLng"]["lat"]);
			$lng=addslashes($json["results"]["0"]["locations"]["0"]["latLng"]["lng"]);
			$latlong=$lat.",".$lng;
			$src="Mapquest";
			}
			else {$success=0;echo "let's get it from google";}

//if I can't get a lat long from mapquest, lets next try to get it from google

		if($success==0){
		
			$url="http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($fullhomeaddress)."&sensor=false";urlencode($url);
			$googledata = file_get_contents($url);
		
			$json=json_decode($googledata,TRUE);

			//print_r($json);
	
			$lat=$json["results"]["0"]["geometry"]["location"]["lat"];
			$lng=$json["results"]["0"]["geometry"]["location"]["lng"];
			$latlong=$lat.",".$lng;
			$src="Google";
			$success="1";	
			}

// now that we have a lat/long let's add it to the db

	   $sql = "UPDATE newemployeestaging SET latlong=:latlong,source=:source WHERE id=:id";
	   $db = getConnection();
	   $stmt = $db->prepare($sql);
	   $stmt->bindParam("latlong", $latlong);
	   $stmt->bindParam("id", $id);
	   $stmt->bindParam("source", $src);
	   try { 
		   $stmt->execute();
		   }
	   catch (PDOException $e){
		   //echo $e->getMessage();
		   }				

// and now that we have added it to the temp table, let's add it to the main table 

	   try {
			$sql = "insert userprofile(fbid,seckey,fname,lname,email,add1,state,city,zip,company,campus,homelatlong,worklatlong,originlatlong,destlatlong,origindesc,destdesc,deleted,preference,leavetime,hometime,timezone)
		   	values (:fbid,:seckey,:fname,:lname,:email,:add1,:state,:city,:zip,:company,:campus,:homelatlong,:worklatlong,:originlatlong,:destlatlong,:origindesc,:destdesc,'N','EMAIL','08:00:00','17:00:00','PDT')";
		
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("fbid", $email);
				$seckey=generateKey($email);
			$stmt->bindParam("seckey",$seckey);			  
			$stmt->bindParam("fname", $fname);
			$stmt->bindParam("lname", $lname);
			$stmt->bindParam("email", $email);
			$stmt->bindParam("add1", $add1);
			$stmt->bindParam("city", $city);
			$stmt->bindParam("state", $state);
			$stmt->bindParam("zip", $zip);
			$stmt->bindParam("company", $company);
			$stmt->bindParam("campus", $campus);
			$stmt->bindParam("homelatlong", $latlong);
			$stmt->bindParam("worklatlong", $campuslatlong);
			
			//get origin node
			$originnode = getNearestPNRNode($latlong,5);
			$stmt->bindParam("originlatlong", $originnode->latlong);
			$stmt->bindParam("origindesc", $originnode->name);
	
			//set work node		
			$stmt->bindParam("destlatlong",$campuslatlong);
			$stmt->bindParam("destdesc",$company);
	
			$stmt->execute();
	   } catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
	   }	 	

//and add to the login table

        $userid = $db->lastInsertId();
        $db = null;

		//now add user to login table

		$sql = "INSERT INTO login (userprofile_id, user_key, password, fbid, seckey) VALUES (:userprofile_id, :user_key, :loginpassword, :fbid, :hash)";
        $db = getConnection();
        $stmt = $db->prepare($sql);
		$stmt->bindParam("userprofile_id", $userid);
		$stmt->bindParam("user_key", $email);
		$loginpassword=null;
		$stmt->bindParam("loginpassword", $loginpassword);
		$stmt->bindParam("fbid", $email);
		$stmt->bindParam("hash", $seckey);
		$stmt->execute();
        $db = null;


	}


// if I am completely done with the job then I should close off newemployeeload and send an email notification

	   echo $countlog;

	   if($countlog==0) {

		   $sql = "SELECT totalrecords,company FROM newemployeeload where status='PENDING' limit 0,1";
		   $db = getConnection();
		   $stmt = $db->prepare($sql);
		   try { 
			   $stmt->execute();
			   $data = $stmt->fetchObject();
			   print_r($data);
			   $c='$employees='.$data->totalrecords;
			   $company=$data->company;
			   //echo $company;
			   }
		   catch (PDOException $e){
			   //echo $e->getMessage();
			   }

		   $sql = "UPDATE newemployeeload SET status='COMPLETE' WHERE company=:company";
		   $db = getConnection();
		   $stmt = $db->prepare($sql);
		   $stmt->bindParam("company", $company);
		   try { 
			   $stmt->execute();
			   $fbid="504711218";
			   generateNotification($fbid,NULL,'LOADEMPLOYEE',NULL,$c,'EMAIL',NULL);
			   
			   }
		   catch (PDOException $e){
			   //echo $e->getMessage();
			   }
	   	
	   		}
		
// this closes out the page
	}

echo "done";
?>

