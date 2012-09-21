<?php
function getUsers()
{ 
global $defaultHash;

	setHeader();
   $hash=getHashKey();
  if ($defaultHash <> $hash)
	return;

 $sql = "select * FROM userprofile where deleted <>'Y' ORDER BY fbid";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	
}

function getUser($id) {
	 setHeader();
	 $sql = "SELECT * FROM userprofile WHERE id=:id and seckey=:hash and deleted <>'Y'";
    try {
        $hash=getHashKey();
		
		$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
		$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $user = $stmt->fetchObject();
        $db = null;
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


function findByName($query)
{
   setHeader();
   $sql = "SELECT * FROM userprofile WHERE UPPER(fname) LIKE :query and seckey=:hash and deleted <>'Y' ORDER BY fname";
    try {
		$hash=getHashKey();
		
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%".$query."%";
        $stmt->bindParam("query", $query);
		$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"users": ' . json_encode($users) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}

function findByFB($query) 
{
   setHeader();
    $sql = "SELECT * FROM userprofile WHERE UPPER(fbid) = UPPER(:query) and seckey=:hash and deleted <>'Y'";
    try {
        $hash=getHashKey();
		
		$db = getConnection();
        $stmt = $db->prepare($sql);
        //$query = "%".$query."%";
        $stmt->bindParam("query", $query);
		$stmt->bindParam("hash", $hash);
		$stmt->execute();
        $user = $stmt->fetchObject();
        $db = null;
        echo '{"user": ' . json_encode($user) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}



//shows how to access request and body
function addUser()
{
global $defaultHash;

  setHeader();
  $hash=getHashKey();
  if ($defaultHash <> $hash)
	return;
	
  $request = Slim::getInstance()->request();
  $user = json_decode($request->getBody());
    $sql = "INSERT INTO userprofile (fbid, seckey, fname, lname, add1, add2, city,state,zip,workadd1, workadd2, workcity, workstate, workzip, preference, phone,email, homelatlong,worklatlong,originlatlong,destlatlong, schedule, leavetime, hometime, timezone, dlverified, terms, insurance, ipaddress, verificationtime, profileblob, cartype, seats,frontphoto, backphoto, leftphoto, rightphoto, ridesoffered, ridestaken, balance, co2balance, milesoffered, milestaken, drivertardyslips, ridertardyslips, notificationmethod, ridereminders, deleted) 
	VALUES (:fbid, :hash, :fname, :lname, :add1, :add2, :city, :state, :zip, :workadd1, :workadd2, :workcity, :workstate, :workzip, :preference, :phone, :email, :homelatlong, :worklatlong, :originlatlong, :destlatlong, :schedule, :leavetime,:hometime, :timezone, :dlverified, :terms, :insurance, :ipaddress, :verificationtime, :profileblob,:cartype,:seats, :frontphoto,:backphoto,:leftphoto,:rightphoto,:ridesoffered,:ridestaken,:balance,:co2balance,:milesoffered,:milestaken,:drivertardyslips,:ridertardyslips,:notificationmethod,:ridereminders,'N')";
	
	//$sql = "INSERT INTO userprofile (fbid, seckey, fname, lname, add1, add2, city,state,zip,preference ) VALUES (:fbid, :hash, :fname, :lname, :add1, :add2, :city, :state, :zip, :preference)";
    
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
    $user = json_decode($body);
    $sql = "UPDATE userprofile SET fname=:fname, lname=:lname, add1=:add1, add2=:add2, city=:city, state=:state, zip=:zip,
	workadd1=:workadd1, workadd2=:workadd2, workcity=:workcity, workstate=:workstate, workzip=:workzip,	
	preference=:preference, phone=:phone, email=:email, homelatlong=:homelatlong,worklatlong=:worklatlong, originlatlong=:originlatlong, destlatlong=:destlatlong,
	schedule=:schedule, leavetime=:leavetime, hometime=:hometime, timezone=:timezone, dlverified=:dlverified, terms=:terms, insurance=:insurance, 
	ipaddress=:ipaddress, verificationtime=:verificationtime, profileblob=:profileblob, cartype=:cartype, seats=:seats,frontphoto=:frontphoto, 
	backphoto=:backphoto, leftphoto=:leftphoto, rightphoto=:rightphoto, ridesoffered=:ridesoffered, ridestaken=:ridestaken, balance=:balance, 
	co2balance=:co2balance, milesoffered=:milesoffered, milestaken=:milestaken, drivertardyslips=:drivertardyslips, ridertardyslips=:ridertardyslips, 
	notificationmethod=:notificationmethod, ridereminders=:ridereminders 
	WHERE id=:id and seckey=:hash";
    try {
		$hash=getHashKey();
		
        $db = getConnection();
        $stmt = $db->prepare($sql);
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
        $stmt->bindParam("id", $id);
		$stmt->bindParam("hash", $hash);
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
    $sql = "UPDATE userprofile SET deleted='Y' WHERE id=:id and seckey=:hash";
    try {
		$hash=getHashKey();
        
		$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
		$stmt->bindParam("hash", $hash);
	    $stmt->execute();
        $db = null;
        //echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
 
 }

 ?>