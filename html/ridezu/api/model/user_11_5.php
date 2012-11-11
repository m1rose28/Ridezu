<?php
function getUsers()
{ 
global $defaultHash;

	setHeader();
/*   $hash=getHashKey();
  if ($defaultHash <> $hash)
	return;
*/
 $sql = "select * FROM userprofile where deleted <>'Y' ORDER BY fbid";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		array_walk($users, function(&$value, $key){ 
			if((!is_null($value->profileblob) || !empty($value->profileblob)) && (is_json($value->profileblob))){
			  $value->profileblob = json_decode($value->profileblob);
			}		
		});		
		echo  json_encode($users);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	
}

function getUser($id) {
	 setHeader();
	 //$sql = "SELECT * FROM userprofile WHERE id=:id and seckey=:hash and deleted <>'Y'";
	 $sql = "SELECT * FROM userprofile WHERE id=:id and deleted <>'Y'";
    try {
        $hash=getHashKey();
		
		$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
		//$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $user = $stmt->fetchObject();
		$db = null;
		//If data is not null or empty, and a valid json , then decode the data
		if((!is_null($user->profileblob) || !empty($user->profileblob))  && (is_json($user->profileblob))){
		  $user->profileblob = json_decode($user->profileblob);
		}		
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


function findByName($query)
{
   setHeader();
   //$sql = "SELECT * FROM userprofile WHERE UPPER(fname) LIKE :query and seckey=:hash and deleted <>'Y' ORDER BY fname";
   $sql = "SELECT * FROM userprofile WHERE UPPER(fname) LIKE :query and deleted <>'Y' ORDER BY fname";
    try {
		$hash=getHashKey();
		
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%".$query."%";
        $stmt->bindParam("query", $query);
		//$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        array_walk($users, function(&$value, $key){ 
			if((!is_null($value->profileblob) || !empty($value->profileblob)) && (is_json($value->profileblob))){
			  $value->profileblob = json_decode($value->profileblob);
			}		
		});		
		echo json_encode($users);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}

function findByFB($query) 
{
   setHeader();
    //$sql = "SELECT * FROM userprofile WHERE UPPER(fbid) = UPPER(:query) and seckey=:hash and deleted <>'Y'";
	$sql = "SELECT * FROM userprofile WHERE UPPER(fbid) = UPPER(:query) and deleted <>'Y'";
    try {
        $hash=getHashKey();
		
		$db = getConnection();
        $stmt = $db->prepare($sql);
        //$query = "%".$query."%";
        $stmt->bindParam("query", $query);
		//$stmt->bindParam("hash", $hash);
		$stmt->execute();
        $user = $stmt->fetchObject();
        $db = null;
        if((!is_null($user->profileblob) || !empty($user->profileblob))  && (is_json($user->profileblob))){
		  $user->profileblob = json_decode($user->profileblob);
		}
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function queryByFB($query)
{
	$sql = "SELECT * FROM userprofile WHERE fbid=:query and deleted <>'Y'";
    try {
    	$db = getConnection();
        $stmt = $db->prepare($sql);
        //$query = "%".$query."%";
        $stmt->bindParam("query", $query);
		$stmt->execute();
        $user = $stmt->fetchObject();
		$db = null;
		return $user;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//shows how to access request and body
function addUser()
{
//global $defaultHash;

  setHeader();
//  $hash=getHashKey();
//  if ($defaultHash <> $hash)
//	return;
	
  $request = Slim::getInstance()->request();
  $user = json_decode($request->getBody());
    $sql = "INSERT INTO userprofile (fbid, seckey, fname, lname, add1, add2, city,state,zip,workadd1, workadd2, workcity, workstate, workzip, preference, phone,email, homelatlong,worklatlong,originlatlong,destlatlong, miles, gassavings, co2, schedule, leavetime, hometime, timezone, dlverified, terms, insurance, ipaddress, verificationtime, profileblob, cartype, seats,frontphoto, backphoto, leftphoto, rightphoto, ridesoffered, ridestaken, balance, co2balance, milesoffered, milestaken, drivertardyslips, ridertardyslips, notificationmethod, ridereminders, deleted) 
	VALUES (:fbid, :hash, :fname, :lname, :add1, :add2, :city, :state, :zip, :workadd1, :workadd2, :workcity, :workstate, :workzip, :preference, :phone, :email, :homelatlong, :worklatlong, :originlatlong, :destlatlong, :miles, :gassavings, :co2, :schedule, :leavetime,:hometime, :timezone, :dlverified, :terms, :insurance, :ipaddress, :verificationtime, :profileblob,:cartype,:seats, :frontphoto,:backphoto,:leftphoto,:rightphoto,:ridesoffered,:ridestaken,:balance,:co2balance,:milesoffered,:milestaken,:drivertardyslips,:ridertardyslips,:notificationmethod,:ridereminders,'N')";
	
	//$sql = "INSERT INTO userprofile (fbid, seckey, fname, lname, add1, add2, city,state,zip,preference ) VALUES (:fbid, :hash, :fname, :lname, :add1, :add2, :city, :state, :zip, :preference)";
    //print_r($user);
	try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
		$stmt->bindParam("fbid", $user->fbid);
		$key= generateKey($user->fbid);
		$stmt->bindParam("hash", $key);
        $stmt->bindParam("fname", $user->fname);
        $stmt->bindParam("lname", $user->lname);
        $stmt->bindParam("add1", $user->add1);
        $stmt->bindParam("add2", $user->add2);
        $stmt->bindParam("city", $user->city);
		$stmt->bindParam("state", $user->state);
		$stmt->bindParam("zip", $user->zip);
		$stmt->bindParam("workadd1", $user->workadd1);
        $stmt->bindParam("workadd2", $user->workadd2);
        $stmt->bindParam("workcity", $user->workcity);
		$stmt->bindParam("workstate", $user->workstate);
		$stmt->bindParam("workzip", $user->workzip);
		$stmt->bindParam("preference", $user->preference);
		$stmt->bindParam("phone", $user->phone);
		$stmt->bindParam("email", $user->email);
		$stmt->bindParam("homelatlong", $user->homelatlong);
		$stmt->bindParam("worklatlong", $user->worklatlong);
		$stmt->bindParam("originlatlong", $user->originlatlong);
		$stmt->bindParam("destlatlong", $user->destlatlong);
		$stmt->bindParam("miles", $user->miles);
		$stmt->bindParam("gassavings", $user->gassavings);
		$stmt->bindParam("co2", $user->co2);
		$stmt->bindParam("schedule", $user->schedule);
		$stmt->bindParam("leavetime", $user->leavetime);
		$stmt->bindParam("hometime", $user->hometime);
		$stmt->bindParam("timezone", $user->timezone);
		$stmt->bindParam("dlverified", $user->dlverified);
		$stmt->bindParam("terms", $user->terms);
		$stmt->bindParam("insurance", $user->insurance);
		$stmt->bindParam("ipaddress", $user->ipaddress);
		$stmt->bindParam("verificationtime", $user->verificationtime);
		$stmt->bindParam("profileblob", $user->profileblob);
		$stmt->bindParam("cartype", $user->cartype);
		$stmt->bindParam("seats", $user->seats);
		$stmt->bindParam("frontphoto", $user->frontphoto);
		$stmt->bindParam("backphoto", $user->backphoto);
		$stmt->bindParam("leftphoto", $user->leftphoto);
		$stmt->bindParam("rightphoto", $user->rightphoto);
		$stmt->bindParam("ridesoffered", $user->ridesoffered);
		$stmt->bindParam("ridestaken", $user->ridestaken);
		$stmt->bindParam("balance", $user->balance);
		$stmt->bindParam("co2balance", $user->co2balance);
		$stmt->bindParam("milesoffered", $user->milesoffered);
		$stmt->bindParam("milestaken", $user->milestaken);
		$stmt->bindParam("drivertardyslips", $user->drivertardyslips);
		$stmt->bindParam("ridertardyslips", $user->ridertardyslips);
		$stmt->bindParam("notificationmethod", $user->notificationmethod);
		$stmt->bindParam("ridereminders", $user->ridereminders);
		
		//print_r ($stmt);
		$stmt->execute();
        $user->id = $db->lastInsertId();
		$user->seckey=$key;
        $db = null;
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
  

 
 function updateUser($id)
 {
	setHeader();
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $user = json_decode($body,true);
    $sql = "UPDATE userprofile SET fname=:fname, lname=:lname, add1=:add1, add2=:add2, city=:city, state=:state, zip=:zip,
	workadd1=:workadd1, workadd2=:workadd2, workcity=:workcity, workstate=:workstate, workzip=:workzip,	
	preference=:preference, phone=:phone, email=:email, homelatlong=:homelatlong,worklatlong=:worklatlong, originlatlong=:originlatlong, destlatlong=:destlatlong,
	miles=:miles, gassavings=:gassavings, co2=:co2,
	schedule=:schedule, leavetime=:leavetime, hometime=:hometime, timezone=:timezone, dlverified=:dlverified, terms=:terms, insurance=:insurance, 
	ipaddress=:ipaddress, verificationtime=:verificationtime, profileblob=:profileblob, cartype=:cartype, seats=:seats,frontphoto=:frontphoto, 
	backphoto=:backphoto, leftphoto=:leftphoto, rightphoto=:rightphoto, ridesoffered=:ridesoffered, ridestaken=:ridestaken, balance=:balance, 
	co2balance=:co2balance, milesoffered=:milesoffered, milestaken=:milestaken, drivertardyslips=:drivertardyslips, ridertardyslips=:ridertardyslips, 
	notificationmethod=:notificationmethod, ridereminders=:ridereminders 
	WHERE id=:id";
	//and seckey=:hash";
    try {
		//$hash=getHashKey();
		
        $db = getConnection();
        $stmt = $db->prepare($sql);
         $stmt->bindParam("fname", $user['fname']);
        $stmt->bindParam("lname", $user['lname']);
        $stmt->bindParam("add1", $user['add1']);
        $stmt->bindParam("add2", $user['add2']);
        $stmt->bindParam("city", $user['city']);
		$stmt->bindParam("state", $user['state']);
		$stmt->bindParam("zip", $user['zip']);
        $stmt->bindParam("workadd1", $user['workadd1']);
        $stmt->bindParam("workadd2", $user['workadd2']);
        $stmt->bindParam("workcity", $user['workcity']);
		$stmt->bindParam("workstate", $user['workstate']);
		$stmt->bindParam("workzip", $user['workzip']);
		$stmt->bindParam("preference", $user['preference']);
		$stmt->bindParam("phone", $user['phone']);
		$stmt->bindParam("email", $user['email']);
		$stmt->bindParam("homelatlong", $user['homelatlong']);
		$stmt->bindParam("worklatlong", $user['worklatlong']);
		$stmt->bindParam("originlatlong", $user['originlatlong']);
		$stmt->bindParam("destlatlong", $user['destlatlong']);
		$stmt->bindParam("miles", $user['miles']);
		$stmt->bindParam("gassavings", $user['gassavings']);
		$stmt->bindParam("co2", $user['co2']);
		$stmt->bindParam("schedule", $user['schedule']);
		$stmt->bindParam("leavetime", $user['leavetime']);
		$stmt->bindParam("hometime", $user['hometime']);
		$stmt->bindParam("timezone", $user['timezone']);
		$stmt->bindParam("dlverified", $user['dlverified']);
		$stmt->bindParam("terms", $user['terms']);
		$stmt->bindParam("insurance", $user['insurance']);
		$stmt->bindParam("ipaddress", $user['ipaddress']);
		$stmt->bindParam("verificationtime", $user['verificationtime']);
		$profl = json_encode($user['profileblob']);		
		$stmt->bindParam("profileblob", $profl);
		$stmt->bindParam("cartype", $user['cartype']);
		$stmt->bindParam("seats", $user['seats']);
		$stmt->bindParam("frontphoto", $user['frontphoto']);
		$stmt->bindParam("backphoto", $user['backphoto']);
		$stmt->bindParam("leftphoto", $user['leftphoto']);
		$stmt->bindParam("rightphoto", $user['rightphoto']);
		$stmt->bindParam("ridesoffered", $user['ridesoffered']);
		$stmt->bindParam("ridestaken", $user['ridestaken']);
		$stmt->bindParam("balance", $user['balance']);
		$stmt->bindParam("co2balance", $user['co2balance']);
		$stmt->bindParam("milesoffered", $user['milesoffered']);
		$stmt->bindParam("milestaken", $user['milestaken']);
		$stmt->bindParam("drivertardyslips", $user['drivertardyslips']);
		$stmt->bindParam("ridertardyslips", $user['ridertardyslips']);
		$stmt->bindParam("notificationmethod", $user['notificationmethod']);
		$stmt->bindParam("ridereminders", $user['ridereminders']);
        $stmt->bindParam("id", $id);
		//$stmt->bindParam("hash", $hash);
		//print_r($stmt);
	    $stmt->execute();
        $db = null;
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
 }
 function deleteUser($id)
 {
	setHeader();
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $user = json_decode($body);
    //$sql = "UPDATE userprofile SET deleted='Y' WHERE id=:id and seckey=:hash";
	$sql = "UPDATE userprofile SET deleted='Y' WHERE id=:id";
    try {
		$hash=getHashKey();
        
		$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
		//$stmt->bindParam("hash", $hash);
	    $stmt->execute();
        $db = null;
        //echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
 
 }

  
  function getNodes($fbid,$location){
    setHeader();
	
	$colname = "homelatlong";
	if( $location == 'W'){
	 $colname = "worklatlong";
	}
  
    $sql = "SELECT SUBSTRING($colname, 1, LOCATE(',', $colname) - 1) as lat,
       SUBSTRING($colname, LOCATE(',', $colname) + 1) as lon from userprofile WHERE fbid='".$fbid."'";
    try {
    	$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
		$count = $stmt->rowCount();
		if($count > 0){
		    $user = $stmt->fetchObject();
			$nodesql = "SELECT  `latlong` , ((ACOS(SIN($user->lat * PI() / 180) * SIN(SUBSTRING_INDEX( `latlong` , ',', 1 ) * PI() / 180)
			+ COS($user->lat * PI() / 180) * COS(SUBSTRING_INDEX( `latlong` , ',', 1 ) * PI() / 180) * COS(($user->lon - SUBSTRING_INDEX( `latlong` , ',', -1 )) * PI() / 180))
			* 180 / PI()) * 60 * 1.1515) AS `distance` , `name`, `campus`, `type`,`custommarker` FROM `ridenode` HAVING `distance` <= 5 ORDER BY `distance` ASC";
			$ndstmt = $db->prepare($nodesql);
			$ndstmt->execute();
			$ndcount = $ndstmt->rowCount();
            if($ndcount > 0){
				$nodes = $ndstmt->fetchAll(PDO::FETCH_ASSOC);
				$db = null;
				//print_r($nodes);
				echo json_encode($nodes);
			}else{
			    echo '{"msg":{"text":"No Nodes found."}}';
			}
		}else{
			    echo '{"msg":{"text":"No record found for the fbid."}}';
		}		
	} catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    } 
  }
  
 
 ?>