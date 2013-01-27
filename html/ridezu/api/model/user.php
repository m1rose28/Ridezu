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
        $db = null;
        if ($user == FALSE) {
          echo '{"loginresult":{"text":' . "invalid credentials" .'}}';
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
		echo '{"updatepasswordresult":{"text":' . "invalid credentials" .'}}';
	  } else {
		$sql = "UPDATE login set password = sha1(:newpwd) where user_key = :login";
        $stmt= $db->prepare($sql);

		$stmt->bindParam("login", $login);
		$stmt->bindParam("newpwd", $newpwd);
		$stmt->execute();
		echo '{"updatepasswordresult":{"text":' . "success" .'}}';
	  }
	  $db = null;
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
    $sql = "INSERT INTO userprofile (fbid, seckey, fname, lname, add1, add2, city,state,zip,company, workadd1, workadd2, workcity, workstate, workzip, preference, phone,email, homelatlong,worklatlong,origindesc, destdesc, originlatlong,destlatlong, miles, gassavings, co2, schedule, leavetime, hometime, timezone, dlverified, terms, insurance, ipaddress, verificationtime, profileblob, cartype, seats,frontphoto, backphoto, leftphoto, rightphoto, ridesoffered, ridestaken, balance, co2balance, milesoffered, milestaken, drivertardyslips, ridertardyslips, notificationmethod, ridereminders, deleted,carmaker,isLuxury,rating,consistency,timeliness,userphoto,paypalemail) 
	VALUES (:fbid, :hash, :fname, :lname, :add1, :add2, :city, :state, :zip,:company, :workadd1, :workadd2, :workcity, :workstate, :workzip, :preference, :phone, :email, :homelatlong, :worklatlong, :origindesc, :destdesc, :originlatlong, :destlatlong, :miles, :gassavings, :co2, :schedule, :leavetime,:hometime, :timezone, :dlverified, :terms, :insurance, :ipaddress, :verificationtime, :profileblob,:cartype,:seats, :frontphoto,:backphoto,:leftphoto,:rightphoto,:ridesoffered,:ridestaken,:balance,:co2balance,:milesoffered,:milestaken,:drivertardyslips,:ridertardyslips,:notificationmethod,:ridereminders,'N',:carmaker,:isLuxury,:rating,:consistency,:timeliness,:userphoto,:paypalemail)";
	
	$userid=null;
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
		
		//print_r ($stmt);
		$stmt->execute();
        $userid = $db->lastInsertId();
        $db = null;
		//send welcome email
		generateNotification($user->fbid,NULL,'WELCOME',NULL,NULL,'EMAIL',NULL);
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

 
 ?>