<?php

//require '../util.php';


function getUsers()
{ 
global $defaultHash;

	setHeader();
/*   $hash=getHashKey();
  if ($defaultHash <> $hash)
	return;
*/
 $sql = "select * FROM userprofile where deleted <>'Y' ORDER BY id limit 0,20";
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
  authorize($query);
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

function findByLogin($login, $pwd) 
{
  //    authorize($query);
    setHeader();

    $sql = "SELECT u.* FROM login l, userprofile u " .
             " WHERE UPPER(l.user_key) = UPPER(:login) " .
             "   and UPPER(l.password) = UPPER(sha1(:pwd)) " .
             "   and l.userprofile_id = u.id " .
             "   and u.deleted <> 'Y' ";
    try {
        $hash=getHashKey();
        
        $db = getConnection();
        $stmt = $db->prepare($sql);
 
        $stmt->bindParam("login", $login);
        $stmt->bindParam("pwd", $pwd);
 
        $stmt->execute();
        $user = $stmt->fetchObject();

        if ($user == FALSE) {
		  echo '{"loginresult":{"text":"invalid credentials"}}';
        } else {
          if((!is_null($user->profileblob) || !empty($user->profileblob))  && (is_json($user->profileblob))){
            $user->profileblob = json_decode($user->profileblob);
          }
        }
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function updatePwdLogin($login, $pwd, $newpwd) {

  setHeader();
  //  echo '{"login":{' . $login . '}}';
    $sql = "SELECT l.user_key FROM login l, userprofile u " .
             " WHERE UPPER(l.user_key) = UPPER(:login) " .
             "   and UPPER(l.password) = UPPER(sha1(:pwd)) " .
             "   and l.userprofile_id = u.id " .
	  "   and u.deleted <> 'Y' ";

    try {
	  $hash=getHashKey();

	  $db = getConnection();
	  $stmt = $db->prepare($sql);

	  $stmt->bindParam("login", $login);
	  $stmt->bindParam("pwd", $pwd);

	  $stmt->execute();
	  $user = $stmt->fetchObject();

	  if ($user == FALSE) {
		echo '{"updatepasswordresult":{"text":"invalid credentials"}}';
	  } else {
		$sql = "UPDATE login set password = sha1(:newpwd) where user_key = :login";
        $stmt= $db->prepare($sql);

		$stmt->bindParam("login", $login);
		$stmt->bindParam("newpwd", $newpwd);
		$stmt->execute();
		echo '{"updatepasswordresult":{"text":"success"}}';
	  }
    } catch(PDOException $e) {
	  echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


function findPublicDataByFB($query)
{
  setHeader();
	$sql = "SELECT id,fbid,fname,lname,city,state,workcity,workstate,createdon,origindesc,destdesc,co2,profileblob,cartype,seats,ridesoffered,ridestaken,co2balance,milesoffered,milestaken,drivertardyslips,ridertardyslips,carmaker,isLuxury,rating,consistency,timeliness,frontphoto,backphoto,leftphoto,rightphoto,userphoto FROM userprofile WHERE UPPER(fbid) = UPPER(:query) and deleted <>'Y'";
    try {
        $hash=getHashKey();
		
		$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("query", $query);
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


function findPublicDataForMatchedUsers($fbid)
{
  authorize($fbid);
  setHeader();
	$sql = "SELECT id,fbid,fname,lname,city,state,workcity,workstate,createdon,origindesc,destdesc,co2,profileblob,cartype,seats,ridesoffered,ridestaken,co2balance,milesoffered,milestaken,drivertardyslips,ridertardyslips,carmaker,isLuxury,rating,consistency,timeliness,frontphoto,backphoto,leftphoto,rightphoto,userphoto FROM userprofile WHERE (homelatlong,worklatlong) in (SELECT u.homelatlong,u.worklatlong from userprofile u WHERE UPPER(u.fbid) = UPPER(:fbid) and u.deleted <>'Y')";
try {
		$db = getConnection();
	    $stmt = $db->prepare($sql);
        $stmt->bindParam("fbid", $fbid);
		$stmt->execute();
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
	
	$userid=null;
	try {
		$sql = "INSERT INTO userprofile (fbid, seckey, fname, lname, add1, add2, city,state,zip,company, workadd1, workadd2, workcity, workstate, workzip, preference, phone,email, homelatlong,worklatlong,origindesc, destdesc, originlatlong,destlatlong, miles, gassavings, co2, schedule, leavetime, hometime, timezone, dlverified, terms, insurance, ipaddress, verificationtime, profileblob, cartype, seats,frontphoto, backphoto, leftphoto, rightphoto, ridesoffered, ridestaken, balance, co2balance, milesoffered, milestaken, drivertardyslips, ridertardyslips, notificationmethod, ridereminders, deleted,carmaker,isLuxury,rating,consistency,timeliness,userphoto,paypalemail,campaign) 
		VALUES (:fbid, :hash, :fname, :lname, :add1, :add2, :city, :state, :zip,:company, :workadd1, :workadd2, :workcity, :workstate, :workzip, :preference, :phone, :email, :homelatlong, :worklatlong, :origindesc, :destdesc, :originlatlong, :destlatlong, :miles, :gassavings, :co2, :schedule, :leavetime,:hometime, :timezone, :dlverified, :terms, :insurance, :ipaddress, :verificationtime, :profileblob,:cartype,:seats, :frontphoto,:backphoto,:leftphoto,:rightphoto,:ridesoffered,:ridestaken,:balance,:co2balance,:milesoffered,:milestaken,:drivertardyslips,:ridertardyslips,:notificationmethod,:ridereminders,'N',:carmaker,:isLuxury,:rating,:consistency,:timeliness,:userphoto,:paypalemail,:campaign)";
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
		$stmt->bindParam("company", $user->company);
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
		$null=NULL;
		if ($user->homelatlong !=NULL)
		{
			//echo $user->homelatlong;
			$originnode = getNearestPNRNode($user->homelatlong,5);
			$stmt->bindParam("originlatlong", $originnode->latlong);
			$stmt->bindParam("origindesc", $originnode->name);
		}
		else 
		{
			
			$stmt->bindParam("originlatlong", $null);
			$stmt->bindParam("origindesc", $null);
		
		}
		if ($user->worklatlong !=NULL)
		{
			$destnode = getNearestNode($user->worklatlong,1);
			$stmt->bindParam("destlatlong",$destnode->latlong);
			$stmt->bindParam("destdesc",$destnode->name);
		}
		else
		{
			$stmt->bindParam("destlatlong",$null);
			$stmt->bindParam("destdesc",$null);
		}
		
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
		$seats = 3;
		$stmt->bindParam("seats", $seats);
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
		$stmt->bindParam("carmaker", $user->carmaker);
		$stmt->bindParam("isLuxury", $user->isLuxury);
		$stmt->bindParam("rating", $user->rating);
		$stmt->bindParam("consistency", $user->consistency);
		$stmt->bindParam("timeliness", $user->timeliness);
		$stmt->bindParam("userphoto", $user->userphoto);
		$stmt->bindParam("paypalemail", $user->paypalemail);
		$stmt->bindParam("campaign", $user->campaign);
		
		//ads user to userprofile table
		$stmt->execute();
        $userid = $db->lastInsertId();
        $db = null;

		//now add user to login table

		$sql = "INSERT INTO login (userprofile_id, user_key, password, fbid, seckey) VALUES (:userprofile_id, :user_key, :loginpassword, :fbid, :hash)";
        $db = getConnection();
        $stmt = $db->prepare($sql);
		$stmt->bindParam("userprofile_id", $userid);
		$stmt->bindParam("user_key", $user->user_key);
		$loginpassword=null;
		if(isset($user->loginpassword)){$loginpassword=sha1($user->loginpassword);}
		$stmt->bindParam("loginpassword", $loginpassword);
		$stmt->bindParam("fbid", $user->fbid);
		$stmt->bindParam("hash", $key);
		$stmt->execute();
        $db = null;
        
        if(isset($user->regtype)==false){
        	$user->regtype=null;
        	}
        	
		//now add the company (if a corp reg)

		if($user->regtype=="newadmin"){
			$sql = "INSERT INTO company (companyname, primaryadmin, employees, emailsyntax) VALUES (:companyname, :primaryadmin, :employees, :emailsyntax)";
			$db = getConnection();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("primaryadmin", $userid);
			$stmt->bindParam("companyname", $user->company);
			$stmt->bindParam("employees", $user->employees);
			$stmt->bindParam("emailsyntax", $user->emailsyntax);
			$stmt->execute();
			$db = null;

			// send a welcome email to the new admin
			$msgtext='$fname='.strval($user->fname).',$companyname='.strval($user->company);
			generateNotification($user->fbid,NULL,'ADMINWELCOME',NULL,$msgtext,'EMAIL',NULL);
			
			}

		 // this generates consumer notifications and referrals (admins + company loads don't get this)			
		if($user->regtype!="newadmin"){
			
			//send welcome email
			generateNotification($user->fbid,NULL,'WELCOME',NULL,NULL,'EMAIL',NULL);
			
			//give user sign-up money
			addSignUpBalance($user->fbid,$userid);
			
			//check if there was a referer; if so give the referer money
			if (isset($user->referer))
				{
				$referer = $user->referer;
				if (!is_null($referer) && ($referer !=''))
					{
						addRefererBalance($referer,$user->fbid);
						//send notification
						$msgtext = '$refered='.strval($user->fname) . ' ' . strval($user->lname);
						generateNotification($referer,NULL,'REFER',NULL,$msgtext,'EMAIL',NULL);
					}
				}
		}
		echo getUser($userid);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
  

 
 function updateUser($id,$fbid){
     
        authorize($fbid);
		setHeader();
        $request = Slim::getInstance()->request();
        $body = $request->getBody();
        $user = json_decode($body,true);
       
               
        // storing the profileblob as received as json
        if(isset($user['profileblob'])){
            $profileTemp = json_encode($user['profileblob']); //will return null if not present
            if(!is_null($profileTemp) && (!empty($profileTemp)))
            {
               $user['profileblob'] = $profileTemp;
            }
        }     
       
        $aElements = array();
        foreach ($user as $sColumn => $sColumnVal){
            $aElements[] = "`$sColumn`= :$sColumn";
        }
       
        $user['id'] = $id;
		$user['fbid'] = $fbid;
        try {
                $db = getConnection();
                $sStatement = "UPDATE userprofile SET " . implode(',', $aElements)." WHERE id=:id and fbid=:fbid";
                $oPDOStatement = $db->prepare($sStatement);
                //$oPDOStatement->bindParam(':id', $id);
				
                if ($oPDOStatement){
                    $oPDOStatement->execute($user);
                }
				$db = null;
				echo getUser($id);
            //echo json_encode($user);
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

  function findNearbyUsers($fbid,$location,$company){
    setHeader();
	
	$colname = "homelatlong";
	if( $location == 'W'){
	 $colname = "worklatlong";
	}
  
    $sql = "SELECT SUBSTRING($colname, 1, LOCATE(',', $colname) - 1) as lat,
       SUBSTRING($colname, LOCATE(',', $colname) + 1) as lon, fbid from userprofile WHERE fbid='".$fbid."'";
    try {
    	$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();
		//print_r($stmt);
        
		$count = $stmt->rowCount();
		if($count > 0){
		    $user = $stmt->fetchObject();
			//print_r($user);
			$nodesql = "SELECT  $colname , ((ACOS(SIN($user->lat * PI() / 180) * SIN(SUBSTRING_INDEX( $colname , ',', 1 ) * PI() / 180)
			+ COS($user->lat * PI() / 180) * COS(SUBSTRING_INDEX( $colname , ',', 1 ) * PI() / 180) * COS(($user->lon - SUBSTRING_INDEX( $colname , ',', -1 )) * PI() / 180))
			* 180 / PI()) * 60 * 1.1515) AS `distance` , `fbid`, `fname`, `lname` FROM `userprofile`  WHERE fbid !='$user->fbid' and company=:company HAVING `distance` <= 2 ORDER BY `distance` ASC";
			
			$ndstmt = $db->prepare($nodesql);
	        $ndstmt->bindParam("company", $company);
			
			//print_r($ndstmt);
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
  
   function generatePin($login)
  {
 	$pin = mt_rand(100000,999999); 
	$sql = "UPDATE login set pin =:pin where user_key =:login";
    try {
    	$db = getConnection();
		$stmt= $db->prepare($sql);
		$stmt->bindParam("login", $login);
		$stmt->bindParam("pin", $pin);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($count > 0){
			echo '{"generatePin":{"text":"success"}}';
			$msgText = '$login='.$login.',$pin='.$pin;
			//function generateNotification($tofbid,$fromfbid,$event,$rideid,$notifydata,$notifytype,$notifytime)
			generateNotification($login,NULL,'PIN',NULL,$msgText,'EMAIL',NULL);

		}
		else
			echo '{"generatePin":{"text":"fail"}}';
		$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
  }
 
  function checkPin($login, $pin)
  {
	$sql = "SELECT user_key,seckey FROM login WHERE user_key=:login and pin=:pin";
    try {
    	$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("login", $login);
		$stmt->bindParam("pin", $pin);
		$stmt->execute();
        $count = $stmt->rowCount();
        $user = $stmt->fetchObject();
		if($count > 0)
			    echo json_encode($user);
		else
			echo '{"msg":{"text":"No Match"}}';
		$db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
  }
 
  function connectfb($newfbid, $user_key)
  {
    try {
		$key= generateKey($newfbid);

		$sql = "UPDATE login set fbid =:newfbid,seckey=:key where user_key =:user_key";
    	$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("key", $key);
        $stmt->bindParam("newfbid", $newfbid);
		$stmt->bindParam("user_key", $user_key);
		$stmt->execute();
		$db = null;
        
		$sql = "UPDATE userprofile set fbid =:newfbid,seckey=:key where fbid =:user_key";
    	$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("key", $key);
        $stmt->bindParam("newfbid", $newfbid);
		$stmt->bindParam("user_key", $user_key);
		$stmt->execute();
		$db = null;
        
        $count = $stmt->rowCount();
		if($count > 0){
			echo '{"facebookconnect":{"text":"success","seckey":"'.$key.'"}}';
		}
		else
			echo '{"facebookconnect":{"text":"fail"}}';
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
	}

  }
  
 ?>
