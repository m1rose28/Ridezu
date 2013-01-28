<?php
function getRides()
{
    //global $defaultHash;
    
    //  $hash=getHashKey();
    //  if ($defaultHash <> $hash)
    //	return;
    
    setHeader();
    $sql = "select * FROM transhistory ORDER by createdon desc";
    try {
        $db    = getConnection();
        $stmt  = $db->query($sql);
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db    = null;
        echo '{"rides": ' . json_encode($rides) . '}';
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getRideByKeyAsObj($id)
{
    $sql = "SELECT * FROM transhistory WHERE rideid=:id";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $ride = $stmt->fetchObject();
        $db   = null;
        return $ride;
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getRide($rideid)
{
    echo json_encode(getRideAsObj($rideid));
}

function getRideAsObj($rideid)
{
    setHeader();
    $sql = "SELECT * FROM transhistory WHERE rideid=:rideid and eventtype='0'";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("rideid", $rideid);
        $stmt->execute();
        $ride = $stmt->fetchObject();
        $db   = null;
        return $ride;
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getRideRequestAsObj($rideid)
{
    setHeader();
    $sql = "SELECT * FROM transhistory WHERE rideid=:rideid and eventtype='1'";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("rideid", $rideid);
        $stmt->execute();
        $ride = $stmt->fetchObject();
        $db   = null;
        return $ride;
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}



function findByDriverFB($fbid)
{
    $user  = queryByFB($fbid);
    $userTimeZone = $user->timezone;
    
    //get today's date and time
    $todaydatetime = new DateTime; // current time = server time
	$todaydatetime->modify('-30 minutes');
	$otherTZ       = new DateTimeZone($userTimeZone);
    $todaydatetime->setTimezone($otherTZ); // calculates with new TZ now
    $mysqltodaydatetime = $todaydatetime->format('Y-m-d H:i:s');
	
	setHeader();
    $sql = "SELECT * FROM transhistory t WHERE t.fbid=:fbid and t.eventtype='0' and eventtime >= :currentdatetime";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fbid", $fbid);
		$stmt->bindParam("currentdatetime", $mysqltodaydatetime);
        //$hash=getHashKey();
        //$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db    = null;
        echo json_encode($rides);
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
function findByRiderFB($fbid)
{
    $user  = queryByFB($fbid);
    $userTimeZone = $user->timezone;
    
    //get today's date and time
    $todaydatetime = new DateTime; // current time = server time
    $todaydatetime->modify('-30 minutes');
	$otherTZ       = new DateTimeZone($userTimeZone);
    $todaydatetime->setTimezone($otherTZ); // calculates with new TZ now
    $mysqltodaydatetime = $todaydatetime->format('Y-m-d H:i:s');
	
	setHeader();
    $sql = "SELECT * FROM transhistory WHERE fbid=:fbid and eventtype='1' and eventtime >= :currentdatetime";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fbid", $fbid);
		$stmt->bindParam("currentdatetime", $mysqltodaydatetime);
        //$hash=getHashKey();
        //$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db    = null;
        echo json_encode($rides);
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function findRideByFB($fbid)
{
	authorize($fbid);
	$user  = queryByFB($fbid);
    $userTimeZone = $user->timezone;
    
    //get today's date and time
    $todaydatetime = new DateTime; // current time = server time
    $todaydatetime->modify('-30 minutes');
	$otherTZ       = new DateTimeZone($userTimeZone);
    $todaydatetime->setTimezone($otherTZ); // calculates with new TZ now
    $mysqltodaydatetime = $todaydatetime->format('Y-m-d H:i:s');
	
	setHeader();
    $sql = "SELECT * FROM transhistory WHERE fbid=:fbid and eventtype in ('0','1')and eventstate not in ('CANCEL','NOSHOW') and eventtime >= :currentdatetime order by eventtype, eventstate, eventtime";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fbid", $fbid);
		$stmt->bindParam("currentdatetime", $mysqltodaydatetime);
        $stmt->execute();
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
		//print_r($rides);
        $db    = null;
        //format the rides data
		$oldType='0';
		$counter=0;
		$ridedetails = array();
		foreach ($rides as $obj) {
			if ($oldType!=$obj->eventtype)
			{
				$counter=0;
			}
			if ($obj->eventtype=='0')
				$objTypeText="Driver";
			else 
				$objTypeText="Rider";
			
			$eventdatetime = $obj->eventtime;
			//print_r($eventdatetime);
			$eventDtTime = new DateTime($eventdatetime,new DateTimeZone($userTimeZone));
			if ($eventDtTime->format('Y-m-d') == $todaydatetime->format('Y-m-d')) {
				$day = 'Today';
			} else {
				$day= $eventDtTime->format('D m\/j');
			}
			
			$daydate = $eventDtTime->format('D m\/j');
			
			$debitwithfee = $obj->debit + getFeeByRole($obj->fbid,$obj->eventtype);
			
			$ridedetails[$objTypeText][$counter]=array("rideid" => $obj->rideid, "refrideid"=>$obj->refrideid, "fbid"=>$obj->fbid,"eventstate"=>$obj->eventstate,"route"=>$obj->route,"description"=>$obj->description,
			"start"=>$obj->origindesc,"end"=>$obj->destdesc,"startlatlong"=>$obj->originlatlong,
			"endlatlong"=>$obj->destlatlong,"miles"=>$obj->miles,"gassavings"=>$obj->gassavings,
			"co2"=>$obj->co2,"riders"=>$obj->riders,"emptyseats"=>$obj->emptyseats,
			"amount"=>$obj->amount,"nextamount"=>$obj->nextamount,"credit"=>$obj->credit,"debit"=>$debitwithfee,"reffbid"=>$obj->reffbid, "eventtime"=>$obj->eventtime, "day"=>$day, "daydate"=>$daydate);
			//print_r($objTypeText);
			
			
			$oldType=$obj->eventtype;
			$counter++;
		}
		echo json_encode($ridedetails);
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

}

function findRidesByTime($query)
{
    setHeader();
    $sql = "SELECT * FROM transhistory WHERE eventtime >=:query and eventtype in ('0','1') ";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("query", $query);
        //$hash=getHashKey();
        //$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db    = null;
        echo ($rides);
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
function findDriversByTime($query)
{
    setHeader();
    
    $sql = "SELECT * FROM transhistory WHERE timestampdiff(MINUTE,eventtime,:query) BETWEEN -30 AND  30 and eventtype ='0' ";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("query", $query);
        //$hash=getHashKey();
        //$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db    = null;
        echo json_encode($rides);
        //echo $query;
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
function findRidersByTime($query)
{
    setHeader();
    $sql = "SELECT * FROM transhistory WHERE timestampdiff(MINUTE,eventtime,:query) BETWEEN -30 AND 30 and eventtype ='1'";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("query", $query);
        //$hash=getHashKey();
        //$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db    = null;
        echo json_encode($rides);
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}


function findRoute($fbid)
{
    $sql = "SELECT origindesc,originlatlong,destdesc,destlatlong,miles,gassavings,co2 FROM userprofile WHERE UPPER(fbid) = UPPER(:query) and deleted <>'Y'";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("query", $fbid);
        $stmt->execute();
        $route = $stmt->fetchObject();
        $db    = null;
        return $route;
        
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}


function findRideTimes($userPrefTime, $currentStartTime)
{
    //echo date("d/m/y : H:i:s", time()) ; 
    //$currTime = date("H:i",time());
    //$starTime = $userPrefTime - 2;
    //$_SERVER['REQUEST_TIME'];
    //$sql = "select AddTime(:userPrefTime,'02:00:00')";
    //$sql = "SELECT DATE_FORMAT(preftime,'%k:%i') as time from ridetimes where preftime between AddTime(:userPrefTime, '-02:00:00') AND AddTime(:userPrefTime, '02:00:00') order by preftime asc";
    $sql = "SELECT DATE_FORMAT(preftime,'%k:%i') as time, (case preftime when :userPrefTime then 'Y' else 'N' end) as preference from ridetimes where prefTime >:currentStartTime order by preftime asc";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userPrefTime", $userPrefTime);
        $stmt->bindParam("currentStartTime", $currentStartTime);
        $stmt->execute();
        $rideTimes = $stmt->fetchAll(PDO::FETCH_OBJ);
        //print_r($rideTimes);
        $db        = null;
        return $rideTimes;
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}


function postRide()
{
    setHeader();
    $request = Slim::getInstance()->request();
    $ride    = json_decode($request->getBody());
    
    $fbid = $ride->fbid;
    
    $driver = queryByFB($fbid);
    
    $name         = strval($driver->fname) . ' ' . strval($driver->lname);
    $emptyseats   = intval($driver->seats) - 1;
    $route        = $ride->route;
    $startdesc    = $driver->origindesc;
    $enddesc      = $driver->destdesc;
    $startlatlong = $driver->originlatlong;
    $endlatlong   = $driver->destlatlong;
    if ($route == 'w2h') {
        $startdesc    = $driver->destdesc;
        $enddesc      = $driver->origindesc;
        $startlatlong = $driver->destlatlong;
        $endlatlong   = $driver->originlatlong;
        
    }
    
	//if same route on same day exists for the user then do not allow.
	$ridetime=$ride->eventtime;
	$rideExist = recordExist($fbid,$route,$ridetime);
	if ($rideExist)
	{
		echo '{"warn":{"text": "ride entry exists"}}';
		return;
	}
	 
    $sql = "INSERT INTO transhistory (fbid, name, eventtype, eventstate, route, description, origindesc, destdesc,originlatlong,destlatlong,miles, gassavings, co2, riders, emptyseats, amount, nextamount, eventtime,eventgmttime) 
	VALUES (:fbid, :name, '0','EMPTY',:route,:description,:origindesc,:destdesc,:originlatlong, :destlatlong,:miles, :gassavings,:co2,1,:emptyseats,:amount,:nextamount,:eventtime,:eventgmttime)";
    
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fbid", $fbid);
        $stmt->bindParam("name", $name);
		$stmt->bindParam("route", $route);
        $stmt->bindParam("description", $ride->description);
        $stmt->bindParam("origindesc", $startdesc);
        $stmt->bindParam("destdesc", $enddesc);
        $stmt->bindParam("originlatlong", $startlatlong);
        $stmt->bindParam("destlatlong", $endlatlong);
        $stmt->bindParam("miles", $driver->miles);
        $stmt->bindParam("gassavings", $driver->gassavings);
        $stmt->bindParam("co2", $driver->co2);
        $stmt->bindParam("emptyseats", $emptyseats);
		//amount new rider expects to pay
		$amount = getBaseTripAmount($driver->miles,$fbid);
		//echo $amount;
        $stmt->bindParam("amount", $amount);
	    $stmt->bindParam("nextamount", $amount);
		
        $stmt->bindParam("eventtime", $ride->eventtime);
		//get user's timezone and convert eventtime to GMT
		$eventtimeasstring=(string)$ride->eventtime;
		$usertimezone = (string)$driver->timezone;
		$gmttime= new DateTime($eventtimeasstring,new DateTimeZone($usertimezone));
		$gmttime->setTimezone(new DateTimeZone('GMT'));
		$gmttime =$gmttime->format('Y-m-d H:i:s');
		$stmt->bindParam("eventgmttime",$gmttime);
        
        //print_r ($stmt);
        $stmt->execute();
        $id = $db->lastInsertId();
        $db = null;
        //try and link riders to this drive
        
        //send notification
		//function generateNotification($tofbid,$fromfbid,$event,$rideid,$notifydata,$notifytype,$notifytime)
		generateNotification($ride->fbid,NULL,'POST',$id,NULL,NULL,NULL);
		
        echo json_encode(getRideByKeyAsObj($id));
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}


function requestRide()
{
    /*
    Validations needed:
    1)if ride request exist for a particular date/time then do not allow user to request for same date/time
    2) if a driver has empty seat for a particular time then do not allow user to request for same date/time
    */
    
    $request = Slim::getInstance()->request();
    $ride    = json_decode($request->getBody());
    
    $fbid  = $ride->fbid;
    $rider = queryByFB($fbid);
	$route        = $ride->route;
    $startdesc    = $rider->origindesc;
    $enddesc      = $rider->destdesc;
    $startlatlong = $rider->originlatlong;
    $endlatlong   = $rider->destlatlong;
    if ($route == 'w2h') {
        $startdesc    = $rider->destdesc;
        $enddesc      = $rider->origindesc;
        $startlatlong = $rider->destlatlong;
        $endlatlong   = $rider->originlatlong;
        
    }
    
    $name = strval($rider->fname) . ' ' . strval($rider->lname);
    $ridetime=$ride->eventtime;
	$rideExist = recordExist($fbid,$route,$ridetime);
	if ($rideExist)
	{
		echo '{"warn":{"text": "ride entry exists"}}';
		return;
	}
    
    $sql = "INSERT INTO transhistory (fbid, name, eventtype, eventstate, route, description, origindesc, destdesc,originlatlong,destlatlong,miles, gassavings, co2,  amount, nextamount, eventtime,eventgmttime) 
	VALUES ( :fbid, :name, '1','REQUEST',:route, :description,:origindesc,:destdesc,:originlatlong, :destlatlong,:miles, :gassavings,:co2,:amount,:nextamount,:eventtime,:eventgmttime)";
    
    
    
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fbid", $fbid);
        $stmt->bindParam("name", $name);
		$stmt->bindParam("route",$route);
        $stmt->bindParam("description", $ride->description);
        $stmt->bindParam("origindesc", $startdesc);
        $stmt->bindParam("destdesc", $enddesc);
        $stmt->bindParam("originlatlong", $startlatlong);
        $stmt->bindParam("destlatlong", $endlatlong);
        $stmt->bindParam("miles", $rider->miles);
        $stmt->bindParam("gassavings", $rider->gassavings);
        $stmt->bindParam("co2", $rider->co2);
        //amount new rider expects to pay
		$amount = getBaseTripAmount($rider->miles,$fbid);
		$stmt->bindParam("amount", $amount);
		$stmt->bindParam("nextamount", $amount);
        $stmt->bindParam("eventtime", $ride->eventtime);
		$eventtimeasstring=(string)$ride->eventtime;
		$usertimezone = (string)$rider->timezone;
		$gmttime= new DateTime($eventtimeasstring,new DateTimeZone($usertimezone));
		$gmttime->setTimezone(new DateTimeZone('GMT'));
		$gmttime =$gmttime->format('Y-m-d H:i:s');
		$stmt->bindParam("eventgmttime",$gmttime);
        
        //print_r ($stmt);
        $stmt->execute();
        $id = $db->lastInsertId();
        $db = null;
		//function generateNotification($tofbid,$fromfbid,$event,$rideid,$notifydata,$notifytype,$notifytime)
		generateNotification($ride->fbid,NULL,'REQUEST',$id,NULL,NULL,NULL);
         echo json_encode(getRideByKeyAsObj($id));
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
    
}



function updateRide($id)
{
}

function deleteRide($id)
{
}

function findDefaultMatchingDrivers($query)
{
    findMatchingDrivers($query, '', '2012-1-1');
}

function findDefaultMatchingRiders($query)
{
    findMatchingRiders($query, '', '2012-1-1');
}




function findMatchingDrivers($query, $searchroute, $searchdate)
{
    /*1)find current date/time for user
    2)find next working date/time - if > noon then show timings to go from office to home
    
    */
    //echo $query. ' ' . $searchroute . ' '. $searchdate; 
   
    setHeader();
	authorize($query);
    $route        = 'h2w'; //default
    //Find leave time preference and timezone for the user passed
    $user         = queryByFB($query);
    //print_r($user);
    $userTimeZone = $user->timezone;
    
    //get today's date and time
    $todaydatetime = new DateTime; // current time = server time
    $otherTZ       = new DateTimeZone($userTimeZone);
    $todaydatetime->setTimezone($otherTZ); // calculates with new TZ now
    $startdatetime = clone $todaydatetime;
    
    
	$searchdatetime = new DateTime($searchdate,new DateTimeZone($userTimeZone));
	
	//print_r($searchdate);
    //print_r($searchdatetime);
	//print_r($todaydatetime);
	if ($searchdatetime > $todaydatetime) {
        $startdatetime = $searchdatetime;
    }
    
    $hour               = $startdatetime->format('H');
    //getting day of the week (ISO) 1 for Monday and 7 for Sunday
    $dw                 = $startdatetime->format("N");
    $userLeaveTimeLimit = $user->leavetime + 2;
    $userHomeTimeLimit  = $user->hometime + 2;
    //echo($user->leavetime. ' ' .$hour . ' ' . $userLeaveTimeLimit . ' ' . $userHomeTimeLimit);
    //Logic to show morning or evening time depending on the current time
    if ($dw == 6) {
        //Saturday
        $userTimePref = $user->leavetime;
        $startdatetime->add(new DateInterval('P2D'));
        $startdatetime->modify('midnight');
    } else if (($dw == 5) && $hour >= $userHomeTimeLimit) {
        //Friday night
        $userTimePref = $user->leavetime;
        $startdatetime->add(new DateInterval('P3D'));
        $startdatetime->modify('midnight');
    } else if (($dw == 7) || $hour >= $userHomeTimeLimit) {
        //Sunday or (M,T,W,T night)
        $userTimePref = $user->leavetime;
        $startdatetime->add(new DateInterval('P1D'));
        $startdatetime->modify('midnight');
    } else if ($hour > $userLeaveTimeLimit && $hour < $userHomeTimeLimit) {
        //working day in the afternoon
        $userTimePref = $user->hometime;
        $route        = 'w2h'; //work to home
        //echo ('setting route to w2h');
    } else {
        $userTimePref = $user->leavetime;
    }
    
    //add 1 day to enddatetime but till midnight
    $enddatetime = clone $startdatetime;
    $enddatetime->add(new DateInterval('P1D'));
    $enddatetime->modify('midnight');
    
    
    //over-ride route logic only if the value is passed
    if ($searchroute == 'h2w')
	{
        $route = 'h2w';
		$userTimePref = $user->leavetime;
    }
	else if ($searchroute == 'w2h')
	{
        $route = 'w2h';
		$userTimePref = $user->hometime;
    }
    
    //Create header data
    $rides = array();
    //$rides["origindesc"]=$user->origindesc;
    //$rides["destdesc"]=$user->destdesc;
    //$rides["originlatlong"]=$user->originlatlong;
    //$rides["destlatlong"]=$user->destlatlong;
    if ($route == 'w2h') {
        $rides["start"]        = $user->destdesc;
        $rides["end"]          = $user->origindesc;
        $rides["startlatlong"] = $user->destlatlong;
        $rides["endlatlong"]   = $user->originlatlong;
        $userStartLatLong      = $user->destlatlong;
        $userEndLatLong        = $user->originlatlong;
    } else {
        $rides["start"]        = $user->origindesc;
        $rides["end"]          = $user->destdesc;
        $rides["startlatlong"] = $user->originlatlong;
        $rides["endlatlong"]   = $user->destlatlong;
        $userStartLatLong      = $user->originlatlong;
        $userEndLatLong        = $user->destlatlong;
    }
    $rides["gassavings"] = $user->gassavings;
    $rides["co2"]        = $user->co2;
    $rides["amount"]     = getBaseTripAmount($user->miles,$user->fbid) + getFee($user->fbid);
    if ($startdatetime == $todaydatetime) {
        $rides["day"] = 'Today';
    } else {
        $rides["day"] = $startdatetime->format('D m\/j');
    }
    $rides["route"]   = $route;
    $rides["daydate"] = $startdatetime->format('D m\/j');
    $rides["date"]    = $startdatetime->format('Y-m-d');
    
    $ndw                 = $enddatetime->format("N");
    $nextworkingdatetime = clone $enddatetime;
    if ($ndw == 6) {
        $nextworkingdatetime->add(new DateInterval('P2D'));
    } else if ($ndw == 7) {
        $nextworkingdatetime->add(new DateInterval('P1D'));
        
    }
    $nextworkingdatetime->modify('midnight');
    $rides["nextday"]     = $nextworkingdatetime->format('l');
    $rides["nextdaydate"] = $nextworkingdatetime->format('D m\/j');
    $rides["nextdate"]    = $nextworkingdatetime->format('Y-m-d');
    
    $rides["startdatetime for debug"]       = $startdatetime->format('l jS \of F Y H:i:s');
    $rides["enddatetime for debug"]         = $enddatetime->format('l jS \of F Y H:i:s');
    $rides["nextworkingdatetime for debug"] = $nextworkingdatetime->format('l jS \of F Y H:i:s');
    
    $mysqlstartdatetime = $startdatetime->format('Y-m-d H:i:s');
    $mysqlstarttime     = $startdatetime->format('H:i:s');
    $mysqlenddatetime   = $enddatetime->format('Y-m-d H:i:s');
    
    //print_r($rides);
    
    
    
    //Get all ride times but mark the ones that match 2 hours before and after preference time
    $rideTimes = findRideTimes($userTimePref, $mysqlstarttime);
    //print_r($rideTimes);
    //find user's node and find all rides starting at that node.
    //$sql=  "select t.rideid, t.fbid, u.fname, u.lname, t.amount, t.riders,t.eventtime from transhistory t, userprofile u where u.fbid=:query and u.originlatlong=t.originlatlong and u.destlatlong=t.destlatlong and t.eventtype='0' and t.eventstate in  ('OPEN','ACTIVE') ORDER BY t.eventtime asc";
    $sql       = "select rideid, fbid, name, amount, riders,eventtime, DATE_FORMAT(eventtime, '%k:%i') as time from transhistory where originlatlong =:startLatLong and destlatlong=:endLatLong and eventtype='0' and eventstate in  ('EMPTY','ACTIVE') and eventtime >= :startdatetime and eventtime <= :enddatetime ORDER BY eventtime asc";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("startLatLong", $userStartLatLong);
        $stmt->bindParam("endLatLong", $userEndLatLong);
        $stmt->bindParam("startdatetime", $mysqlstartdatetime);
        $stmt->bindParam("enddatetime", $mysqlenddatetime);
        $stmt->execute();
        $results     = $stmt->fetchAll(PDO::FETCH_OBJ);
        //print_r($results);
        $rideDetails = array();
       
        foreach ($rideTimes as $rideTime) {
            $timeKey = date('g:ia', strtotime($rideTime->time));
            $counter = 0;
            foreach ($results as $obj) {
                if ($obj->time == $rideTime->time) {
                    $rideDetails[$timeKey][$counter] = array(
                        "rideid" => $obj->rideid,
                        "fbid" => $obj->fbid,
                        "name" => $obj->name,
                        "timepreference" => $rideTime->preference,
                        "riders" => $obj->riders,
                        "eventtime" => $obj->eventtime
                    );
                    $counter++;
                }
            }
            if ($counter == 0) {
                $sendDateTime = $startdatetime->format('Y-m-d') . ' ' . $rideTime->time;
                //echo $sendDateTime;
                $rideDetails[$timeKey][$counter] = array(
                    "rideid" => null,
                    "fbid" => null,
                    "name" => null,
                    "timepreference" => $rideTime->preference,
                    "riders" => null,
                    "eventtime" => $sendDateTime
                );
            }
            
        }
        //print_r($rideDetails);
        
        $rides["rideList"] = $rideDetails;
        
        //print_r($rides);
        $db = null;
        echo json_encode($rides);
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
    
}


function findMatchingRiders($query, $searchroute, $searchdate)
{
    /*1)find current date/time for user
    2)find next working date/time - if > noon then show timings to go from office to home
    
    */
    //echo $query. ' ' . $searchroute . ' '. $searchdate; 
   
    setHeader();
	authorize($query);
    $route        = 'h2w'; //default
    //Find leave time preference and timezone for the user passed
    $user         = queryByFB($query);
    //print_r($user);
    $userTimeZone = $user->timezone;
    
    //get today's date and time
    $todaydatetime = new DateTime; // current time = server time
    $otherTZ       = new DateTimeZone($userTimeZone);
    $todaydatetime->setTimezone($otherTZ); // calculates with new TZ now
    $startdatetime = clone $todaydatetime;
    
    
	$searchdatetime = new DateTime($searchdate,new DateTimeZone($userTimeZone));
	
	//print_r($searchdate);
    //print_r($searchdatetime);
	//print_r($todaydatetime);
	if ($searchdatetime > $todaydatetime) {
        $startdatetime = $searchdatetime;
    }
    
    $hour               = $startdatetime->format('H');
    //getting day of the week (ISO) 1 for Monday and 7 for Sunday
    $dw                 = $startdatetime->format("N");
    $userLeaveTimeLimit = $user->leavetime + 2;
    $userHomeTimeLimit  = $user->hometime + 2;
    //echo($user->leavetime. ' ' .$hour . ' ' . $userLeaveTimeLimit . ' ' . $userHomeTimeLimit);
    //Logic to show morning or evening time depending on the current time
    if ($dw == 6) {
        //Saturday
        $userTimePref = $user->leavetime;
        $startdatetime->add(new DateInterval('P2D'));
        $startdatetime->modify('midnight');
    } else if (($dw == 5) && $hour >= $userHomeTimeLimit) {
        //Friday night
        $userTimePref = $user->leavetime;
        $startdatetime->add(new DateInterval('P3D'));
        $startdatetime->modify('midnight');
    } else if (($dw == 7) || $hour >= $userHomeTimeLimit) {
        //Sunday or (M,T,W,T night)
        $userTimePref = $user->leavetime;
        $startdatetime->add(new DateInterval('P1D'));
        $startdatetime->modify('midnight');
    } else if ($hour > $userLeaveTimeLimit && $hour < $userHomeTimeLimit) {
        //working day in the afternoon
        $userTimePref = $user->hometime;
        $route        = 'w2h'; //work to home
        //echo ('setting route to w2h');
    } else {
        $userTimePref = $user->leavetime;
    }
    
    //add 1 day to enddatetime but till midnight
    $enddatetime = clone $startdatetime;
    $enddatetime->add(new DateInterval('P1D'));
    $enddatetime->modify('midnight');
    
    
    //over-ride route logic only if the value is passed
    if ($searchroute == 'h2w')
	{
        $route = 'h2w';
		$userTimePref = $user->leavetime;
    }
	else if ($searchroute == 'w2h')
	{
        $route = 'w2h';
		$userTimePref = $user->hometime;
    }
    
    //Create header data
    $rides = array();
    //$rides["origindesc"]=$user->origindesc;
    //$rides["destdesc"]=$user->destdesc;
    //$rides["originlatlong"]=$user->originlatlong;
    //$rides["destlatlong"]=$user->destlatlong;
    if ($route == 'w2h') {
        $rides["start"]        = $user->destdesc;
        $rides["end"]          = $user->origindesc;
        $rides["startlatlong"] = $user->destlatlong;
        $rides["endlatlong"]   = $user->originlatlong;
        $userStartLatLong      = $user->destlatlong;
        $userEndLatLong        = $user->originlatlong;
    } else {
        $rides["start"]        = $user->origindesc;
        $rides["end"]          = $user->destdesc;
        $rides["startlatlong"] = $user->originlatlong;
        $rides["endlatlong"]   = $user->destlatlong;
        $userStartLatLong      = $user->originlatlong;
        $userEndLatLong        = $user->destlatlong;
    }
    $rides["gassavings"] = $user->gassavings;
    $rides["co2"]        = $user->co2;
    $rides["amount"]     = getBaseTripAmount($user->miles,$user->fbid);
    if ($startdatetime == $todaydatetime) {
        $rides["day"] = 'Today';
    } else {
        $rides["day"] = $startdatetime->format('D m\/j');
    }
    $rides["route"]   = $route;
    $rides["daydate"] = $startdatetime->format('D m\/j');
    $rides["date"]    = $startdatetime->format('Y-m-d');
    
    $ndw                 = $enddatetime->format("N");
    $nextworkingdatetime = clone $enddatetime;
    if ($ndw == 6) {
        $nextworkingdatetime->add(new DateInterval('P2D'));
    } else if ($ndw == 7) {
        $nextworkingdatetime->add(new DateInterval('P1D'));
        
    }
    $nextworkingdatetime->modify('midnight');
    $rides["nextday"]     = $nextworkingdatetime->format('l');
    $rides["nextdaydate"] = $nextworkingdatetime->format('D m\/j');
    $rides["nextdate"]    = $nextworkingdatetime->format('Y-m-d');
    
    $rides["startdatetime for debug"]       = $startdatetime->format('l jS \of F Y H:i:s');
    $rides["enddatetime for debug"]         = $enddatetime->format('l jS \of F Y H:i:s');
    $rides["nextworkingdatetime for debug"] = $nextworkingdatetime->format('l jS \of F Y H:i:s');
    
    $mysqlstartdatetime = $startdatetime->format('Y-m-d H:i:s');
    $mysqlstarttime     = $startdatetime->format('H:i:s');
    $mysqlenddatetime   = $enddatetime->format('Y-m-d H:i:s');
    
    //print_r($rides);
    
    
    
    //Get all ride times but mark the ones that match 2 hours before and after preference time
    $rideTimes = findRideTimes($userTimePref, $mysqlstarttime);
    //print_r($rideTimes);
    //find user's node and find all rides starting at that node.
    //$sql=  "select t.rideid, t.fbid, u.fname, u.lname, t.amount, t.riders,t.eventtime from transhistory t, userprofile u where u.fbid=:query and u.originlatlong=t.originlatlong and u.destlatlong=t.destlatlong and t.eventtype='0' and t.eventstate in  ('OPEN','ACTIVE') ORDER BY t.eventtime asc";
    $sql       = "select rideid, fbid, name, amount, riders,eventtime, DATE_FORMAT(eventtime, '%k:%i') as time from transhistory where originlatlong =:startLatLong and destlatlong=:endLatLong and eventtype='1' and eventstate in  ('REQUEST') and eventtime >= :startdatetime and eventtime <= :enddatetime ORDER BY eventtime asc";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("startLatLong", $userStartLatLong);
        $stmt->bindParam("endLatLong", $userEndLatLong);
        $stmt->bindParam("startdatetime", $mysqlstartdatetime);
        $stmt->bindParam("enddatetime", $mysqlenddatetime);
        $stmt->execute();
        $results     = $stmt->fetchAll(PDO::FETCH_OBJ);
        //print_r($results);
        $rideDetails = array();
       
        foreach ($rideTimes as $rideTime) {
            $timeKey = date('g:ia', strtotime($rideTime->time));
            $counter = 0;
            foreach ($results as $obj) {
                if ($obj->time == $rideTime->time) {
                    $rideDetails[$timeKey][$counter] = array(
                        "rideid" => $obj->rideid,
                        "fbid" => $obj->fbid,
                        "name" => $obj->name,
                        "timepreference" => $rideTime->preference,
                        "riders" => $obj->riders,
                        "eventtime" => $obj->eventtime
                    );
                    $counter++;
                }
            }
            if ($counter == 0) {
                $sendDateTime = $startdatetime->format('Y-m-d') . ' ' . $rideTime->time;
                //echo $sendDateTime;
                $rideDetails[$timeKey][$counter] = array(
                    "rideid" => null,
                    "fbid" => null,
                    "name" => null,
                    "timepreference" => $rideTime->preference,
                    "riders" => null,
                    "eventtime" => $sendDateTime
                );
            }
            
        }
        //print_r($rideDetails);
        
        $rides["rideList"] = $rideDetails;
        
        //print_r($rides);
        $db = null;
        echo json_encode($rides);
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
    
}


//match rider to driver
function fillRide($driverrideid)
{
    setHeader();
    $request = Slim::getInstance()->request();
    $body    = json_decode($request->getBody());
    
    //get rider's id
    $fbid = $body->fbid;
    //echo $fbid;
    $rider = queryByFB($fbid);
    //print_r($rider);
    $name  = strval($rider->fname) . ' ' . strval($rider->lname);
    
    //get driver ride details
    $ride = getRideAsObj($driverrideid);
	//find route for the rider
	if ($ride->originlatlong== $rider->originlatlong)
		$route='h2w';
	else 
		$route='w2h';
    
	//if same route on same day exists for the user then do not allow.
	$ridetime=$ride->eventtime;
	$rideExist = recordExist($fbid,$route,$ridetime);
	if ($rideExist)
	{
		echo '{"warn":{"text": "ride entry exists"}}';
		return;
	}
	
	
	//rider record
    $sql1 = "INSERT INTO transhistory (refrideid, fbid, name, eventtype, eventstate, route, description, origindesc, destdesc,originlatlong,destlatlong,miles, gassavings, co2,  amount, debit, reffbid, eventtime,eventgmttime) 
	VALUES (:driverrideid, :fbid, :name, '1','ACTIVE',:route, :description,:origindesc,:destdesc,:originlatlong,:destlatlong,:miles, :gassavings,:co2,:amount,:debit,:reffbidNName, :eventtime,:eventgmttime)";
    
	//driver record
    $sql = "UPDATE transhistory SET refrideid=CONCAT_WS('#',refrideid,:riderrideid),  reffbid=CONCAT_WS('#',reffbid,:riderfbidNName) , riders=riders+1, emptyseats=emptyseats-1, credit=credit+nextamount, eventstate=(CASE WHEN emptyseats=0 THEN 'FULL' ELSE 'ACTIVE' END) where rideid=:driverrideid and eventtype='0'";

    //reduce all riders price
    $sql2="UPDATE transhistory set debit=:nextamount where refrideid=:driverrideid and eventtype='1' and eventstate='ACTIVE'";

	//set new price-point
	$sql3 ="UPDATE transhistory SET nextamount=((1-(riders-1)*0.1 ) * amount) where rideid=:driverrideid and eventtype='0'";
	
	
	
    try {
        $db = getConnection();
        
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        
        
        $db->beginTransaction();
        
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("driverrideid", $driverrideid);
		$stmt1->bindParam("fbid", $fbid);
        $stmt1->bindParam("name", $name);
		$stmt1->bindParam("route", $route);
        $stmt1->bindParam("description", $ride->description);
        $stmt1->bindParam("origindesc", $ride->origindesc);
        $stmt1->bindParam("destdesc", $ride->destdesc);
        $stmt1->bindParam("originlatlong", $ride->originlatlong);
        $stmt1->bindParam("destlatlong", $ride->destlatlong);
        $stmt1->bindParam("miles", $ride->miles);
        $stmt1->bindParam("gassavings", $ride->gassavings);
        $stmt1->bindParam("co2", $ride->co2);
        $stmt1->bindParam("amount", $ride->amount);
		$stmt1->bindParam("debit", $ride->nextamount);
		$driverfbidNName=$ride->fbid.'|'.$ride->name;
		$stmt1->bindParam("reffbidNName",$driverfbidNName);
        $stmt1->bindParam("eventtime", $ride->eventtime);
		$stmt1->bindParam("eventgmttime", $ride->eventgmttime);
        $stmt1->execute();
		$riderrideid = $db->lastInsertId();
		//get last inserted id
		
        
        $stmt = $db->prepare($sql);
		$riderfbidNName=$fbid.'|'.$name;
        $stmt->bindParam("riderfbidNName", $riderfbidNName);
        $stmt->bindParam("riderrideid", $riderrideid);
		$stmt->bindParam("driverrideid", $driverrideid);
        $stmt->execute();

		
		$stmt2 =$db->prepare($sql2);
		$stmt2->bindParam("driverrideid",$driverrideid);
		$stmt2->bindParam("nextamount",$ride->nextamount);
		$stmt2->execute();
		
		$stmt3 = $db->prepare($sql3);
		$stmt3->bindParam("driverrideid",$driverrideid);
		$stmt3->execute();
		
        
        $db->commit();
        $db = null;
		
		//send notification to driver
		//echo 'generate notification';
		//function generateNotification($tofbid,$fromfbid,$event,$rideid,$notifydata,$notifytype,$notifytime)
		generateNotification($ride->fbid,NULL,'MATCH',$ride->rideid,NULL,NULL,NULL);
		echo getRide($ride->rideid);
        //echo json_encode(array("status" => "success"));
    }
    catch (PDOException $e) {
        $db->rollBack();
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
    
}

function fillRideRequest($riderrideid)
{
    
	//just fill the ride request of the rideid passed with this new drivers post. Only 1 can be added at 1 time.
    //update riderequests to ACTIVE and reduce empty seats for the driver. Create driver record if one does not exist.
    setHeader();
    $request = Slim::getInstance()->request();
    $body    = json_decode($request->getBody());
    
    //get driver's fbid
    $fbid = $body->fbid;
    
    $driver = queryByFB($fbid);
	//print_r($driver);    
    //get rider's ride details
    $riderride = getRideRequestAsObj($riderrideid);
	//print_r($riderride);

	if ($driver->originlatlong== $riderride->originlatlong)
		$route='h2w';
	else 
		$route='w2h';
		
	//if same route on same day exists for the user then do not allow.
	$ridetime=$riderride->eventtime;
	$rideExist = recordExist($fbid,$route,$ridetime);
	if ($rideExist)
	{
		echo '{"warn":{"text": "ride entry exists"}}';
		return;
	}
    
    //Check if driver's entry exist for this ride time & route. If so just update it or if not insert a new record.
	$sql0 = "SELECT * from transhistory where fbid=:driverfbid and eventtype='0' and eventstate='ACTIVE' and eventtime=:eventtime and originlatlong=:originlatlong and destlatlong=:destlatlong";
	
	$sql1 = "INSERT INTO transhistory (fbid, name, eventtype, eventstate, route, description, origindesc, destdesc,originlatlong,destlatlong,miles, gassavings, co2, riders, emptyseats, amount, nextamount, eventtime,eventgmttime) 
		VALUES (:fbid, :name, '0','EMPTY',:route, :description,:origindesc,:destdesc,:originlatlong, :destlatlong,:miles, :gassavings,:co2,1,:emptyseats,:amount,:nextamount,:eventtime,:eventgmttime)";
	
	$sql2 = "UPDATE transhistory SET refrideid=CONCAT_WS('#',refrideid,:riderrideid),reffbid=CONCAT_WS('#',reffbid,:riderfbidNName) , riders=riders+1, credit=credit+nextamount, emptyseats=emptyseats-1, eventstate=(CASE WHEN emptyseats=0 THEN 'FULL' ELSE 'ACTIVE' END) where rideid=:driverrideid and eventtype='0'";

	$sql3 = "UPDATE transhistory SET refrideid=:driverrideid, reffbid=:driverfbidNName, eventstate='ACTIVE',debit=:amttocharge where rideid =:riderrideid and eventtype='1' and eventstate='REQUEST'";
    
	//change price for all riders
	$sql4="UPDATE transhistory set debit=:amttocharge where refrideid=:driverrideid and eventtype='1' and eventstate='ACTIVE'";

	//set new price-point
	$sql5 ="UPDATE transhistory SET nextamount=((1-(riders-1)*0.1 ) * amount) where rideid=:driverrideid and eventtype='0' ";

	
    try {
        $db = getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
       
        $stmt0 = $db->prepare($sql0);
		$stmt0->bindParam("driverfbid",$fbid);
		//echo ' fb id ' . $fbid;
        $stmt0->bindParam("eventtime", $riderride->eventtime);
        //echo ' eventime ' . $riderride->eventtime;
        $stmt0->bindParam("originlatlong", $riderride->originlatlong);
        //echo ' originlatlong ' . $riderride->originlatlong;
        $stmt0->bindParam("destlatlong", $riderride->destlatlong);
        //echo ' destlatlong ' . $riderride->destlatlong;
        $stmt0->execute();
        
        $driverridedata = $stmt0->fetchObject();
		$rowcount = $stmt0->rowCount();
	
		
		//if no record found then create new driver record
		
		if ($rowcount<1)
		{
			$name         = strval($driver->fname) . ' ' . strval($driver->lname);
			$emptyseats   = intval($driver->seats) - 1;
			$startdesc    = $riderride->origindesc;
			$enddesc      = $riderride->destdesc;
			$startlatlong = $riderride->originlatlong;
			$endlatlong   = $riderride->destlatlong;
		
			$stmt1 = $db->prepare($sql1);
			$stmt1->bindParam("fbid", $fbid);
			$stmt1->bindParam("name", $name);
			$stmt1->bindParam("route",$route);
			$stmt1->bindParam("description", $riderride->description);
			$stmt1->bindParam("origindesc", $startdesc);
			$stmt1->bindParam("destdesc", $enddesc);
			$stmt1->bindParam("originlatlong", $startlatlong);
			$stmt1->bindParam("destlatlong", $endlatlong);
			$stmt1->bindParam("miles", $driver->miles);
			$stmt1->bindParam("gassavings", $driver->gassavings);
			$stmt1->bindParam("co2", $driver->co2);
			$stmt1->bindParam("emptyseats", $emptyseats);
			//amount new rider expects to pay
			$amttocharge = getBaseTripAmount($driver->miles,$fbid);
			//echo $amount;
			$stmt1->bindParam("amount", $amttocharge);
			$stmt1->bindParam("nextamount", $amttocharge);
			$stmt1->bindParam("eventtime", $riderride->eventtime);
			$stmt1->bindParam("eventgmttime", $riderride->eventgmttime);
			
			
			//print_r ($stmt1);
			$stmt1->execute();
			$id = $db->lastInsertId();
			//echo ' driver row inserted \n';
			//print_r ($id);
			$driverridedata = getRideByKeyAsObj($id);
		}
		
		$amttocharge=$driverridedata->nextamount;
		// "$amttocharge:" .$amttocharge;
		$db=null;
		
		//update driver record only if empty seats is not 0
		//update rider record - change rideid to match the driver record
		//echo ' driverdata :';
		//print_r($driverridedata);
		
		$db = getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->beginTransaction();
		
		$stmt2 = $db->prepare($sql2);
		$riderfbidNName=$riderride->fbid.'|'.$riderride->name;
		$stmt2->bindParam("riderrideid",$riderride->rideid);
		$stmt2->bindParam("riderfbidNName", $riderfbidNName);
		$stmt2->bindParam("driverrideid", $driverridedata->rideid);
		$stmt2->execute();
		$row =$stmt2->rowCount();
		if ($row==0)
			$db->rollback();

		$stmt3=$db->prepare($sql3);
		$stmt3->bindParam("driverrideid", $driverridedata->rideid);
		$driverfbidNName =$driverridedata->fbid.'|'.$driverridedata->name;
		$stmt3->bindParam("driverfbidNName",$driverfbidNName);
		$stmt3->bindParam("amttocharge",$amttocharge);
		$stmt3->bindParam("riderrideid",$riderride->rideid);
		$stmt3->execute();
		
		$stmt4=$db->prepare($sql4);
		$stmt4->bindParam("driverrideid", $driverridedata->rideid);
		$stmt4->bindParam("amttocharge",$amttocharge);
		$stmt4->execute();
		
		$stmt5=$db->prepare($sql5);
		$stmt5->bindParam("driverrideid", $driverridedata->rideid);
		$stmt5->execute();
		
		$db->commit();
        $db = null;
		generateNotification($riderride->fbid,NULL,'MATCH',$riderride->rideid,NULL,NULL,NULL);
		return getRide($driverridedata->rideid);
    }
    catch (PDOException $e) {
		$db->rollback();
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
	
}


function cancelRide($rideid,$fbid)
{
	setHeader();
	   
    $user         = queryByFB($fbid);
    //print_r($user);
    $userTimeZone = $user->timezone;
    
    //get today's date and time
    $todaydatetime = new DateTime; // current time = server time
    $otherTZ       = new DateTimeZone($userTimeZone);
    $todaydatetime->setTimezone($otherTZ); // calculates with new TZ now
    $mysqltodaydatetime = $todaydatetime->format('Y-m-d H:i:s');
	
	//print_r($todaydatetime);
	
	//if a ride post exist for this user then set it to Cancelled status. For rider requests set it to Request again and remove reffbid reference
	//if this rideId is for request then remove reference from posting if reffid exists, increase available seats and set thsi status to Cancelled.

	try
	{
	$db = getConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->beginTransaction();
		
	$sql0 = "SELECT * from transhistory where rideid=:rideid and fbid=:fbid and (eventstate in ('REQUEST','EMPTY','ACTIVE','FULL')) and eventtime > :currentdatetime ";
	
	$stmt0 = $db->prepare($sql0);
	$stmt0->bindParam("rideid",$rideid);
	$stmt0->bindParam("fbid",$fbid);
	$stmt0->bindParam("currentdatetime", $mysqltodaydatetime);
	//echo $rideid .'-'.$fbid.'-'.$mysqltodaydatetime;
	$stmt0->execute();	
	$ridedata = $stmt0->fetchObject();
	//print_r($ridedata);
	$rowcount = $stmt0->rowCount();
	//echo 'count = ' .$rowcount;
	if ($rowcount==0)
	{
		echo '{"warning":{"text":"No records found"}}'; 
		$db->rollback();
		$db=null;
		return;
	}
	//proceed further only if you find a match
	
	if ($ridedata->eventtype=='0') //driver
	{
		//echo 'driver';
		$sql1 = "update transhistory set eventstate='CANCEL' where rideid=:rideid and fbid=:driverfbid and eventtype='0' and eventtime > :currentdatetime";
		$stmt1 = $db->prepare($sql1);
		$stmt1->bindParam("rideid",$rideid);
		$stmt1->bindParam("driverfbid",$fbid);
		$stmt1->bindParam("currentdatetime", $mysqltodaydatetime);
	    $stmt1->execute();
    
		

		if (($ridedata->refrideid != null) && ($ridedata->refrideid !=''))
		{
			$refrideidArr= explode('#',$ridedata->refrideid);
			$refriderfbidArr = explode('#',$ridedata->reffbid);
			//$refrideidlist = implode(',',$refrideidArr);
			//print_r($refrideidlist);
			$sql2= "update transhistory set eventstate='REQUEST',refrideid=null,debit=0 where rideid in (:riderrideid) and eventtype='1' and eventtime > :currentdatetime";
			$stmt2=$db->prepare($sql2);
			foreach($refrideidArr as $refrideid)
			{
				$stmt2->bindParam("riderrideid",$refrideid);
				$stmt2->bindParam("currentdatetime", $mysqltodaydatetime);
				//echo $mysqltodaydatetime;
				$stmt2->execute();
				//echo 'update request data';
			}
			
		}
	}
	else if ($ridedata->eventtype=='1') //rider
	{
		//echo 'rider';
		if (($ridedata->refrideid != null)&& ($ridedata->refrideid !=''))
		{
		 //get driver data	
		 $sql3="select * from transhistory where rideid=:driverrideid and eventtype='0'and eventtime > :currentdatetime";
		 $stmt3 = $db->prepare($sql3);
		 $stmt3->bindParam("driverrideid",$ridedata->refrideid);
		 $stmt3->bindParam("currentdatetime", $mysqltodaydatetime);
		 $stmt3->execute();
		 $driverridedata = $stmt3->fetchObject();
		
		
		  //update driver data	
		  $sql4="update transhistory set refrideid=:refrideidList, reffbid=:refRiderFBList, riders=riders-1, emptyseats=emptyseats+1, eventstate=(CASE WHEN riders=1 THEN 'EMPTY' ELSE 'ACTIVE' END) where rideid=:driverrideid and eventtype='0'and eventtime > :currentdatetime";
	
		  $refrideidArr= explode('#',$driverridedata->refrideid);
		  //print_r '1: ' .$refrideidArr;
		  //take out the refid for rider
		  $refrideidArr = array_diff($refrideidArr, array($rideid));
		  //print_r '2: ' .$refrideidArr;
		  $refrideidList = implode('#',$refrideidArr);
		  //$refrideidList ="'".$refrideidList."'";
		  //echo 'rideidlist #'.	$refrideidList;
		  $refFBidArr = explode('#',$driverridedata->reffbid);
		  $matchFB = $ridedata->fbid.'|'.$ridedata->name;
		  //echo $matchFB;
		  $refFBidArr = array_diff($refFBidArr,array($matchFB));
		  $refRiderFBList = implode('#',$refFBidArr);
		  $stmt4 = $db->prepare($sql4);
		   
		   $stmt4->bindParam("refrideidList",$refrideidList);
			
			$stmt4->bindParam("refRiderFBList",$refRiderFBList);
			$stmt4->bindParam("driverrideid",$driverridedata->rideid);
			$stmt4->bindParam("currentdatetime", $mysqltodaydatetime);
		
		  
		//print_r( $stmt4);
			//echo 'param1#'.$refrideidList.'#param2#'.$refRiderFBList.'#param3#'.$driverridedata->rideid.'#param4#'.$mysqltodaydatetime;
			$stmt4->execute();
		  
			
		//set new price-point for driver
		$sql6 ="UPDATE transhistory SET nextamount=((1-(riders-1)*0.1 ) * amount),credit=credit-nextamount where rideid=:driverrideid and eventtype='0' ";
		$stmt6 = $db->prepare($sql6);
		$stmt6->bindParam("driverrideid",$driverridedata->rideid);
		$stmt6->execute();
	
		$sql7="SELECT refrideid, riders,nextamount from transhistory where rideid=:driverrideid";
		$stmt7 = $db->prepare($sql7);
		$stmt7->bindParam("driverrideid",$driverridedata->rideid);
		$stmt7->execute();
		$driverdata = $stmt7->fetchObject();
	
		$finalriders = $driverdata->riders;
		if ($finalriders >1)
		{
		//apply new price-point to remaining riders
		//print_r ($refrideidArr);
		$rideridlist=implode(',',$refrideidArr);
		$sql8="UPDATE transhistory set debit=:drivernextamt where rideid IN(".$rideridlist.')';
		print_r($sql8);
		$stmt8 = $db->prepare($sql8);
		$stmt8->bindParam("drivernextamt",$driverdata->nextamount);
		$stmt8->execute();
		}
		}
		//echo 'rider';
		//cancel rider ride
		$sql5 = "update transhistory set eventstate='CANCEL' where rideid=:rideid and fbid=:riderfbid and eventtype='1' and eventtime > :currentdatetime";
		$stmt5 = $db->prepare($sql5);
		$stmt5->bindParam("rideid",$rideid);
		$stmt5->bindParam("riderfbid",$fbid);
		$stmt5->bindParam("currentdatetime", $mysqltodaydatetime);
	    $stmt5->execute();

	}
	
	$db->commit();
	$db=null;
	//generate notification
	//driver cancelling - notify all riders
	generateNotification($fbid,NULL,'CANCEL',$rideid,NULL,NULL,NULL);//notify person cancelling
	
	if (($ridedata->eventtype=='1') && ($ridedata->refrideid != null)&& ($ridedata->refrideid !='')) //rider cancelling - notify driver
	{
		$driverrideid =$ridedata->refrideid;
		$driverfbid = $ridedata->reffbid;
		$driverfbid = substr($driverfbid, 0, (strlen ($driverfbid)) - (strlen (strrchr($driverfbid,'|'))));
		generateNotification($driverfbid,NULL,'CANCEL',$driverrideid,NULL,NULL,NULL);//notify person cancelling
	}
	else if ($ridedata->eventtype=='0') //driver cancelling - notify all riders
	{
		if (($ridedata->refrideid != null)&& ($ridedata->refrideid !=''))
		{
			$i=0;
			foreach($refrideidArr as $refrideid) 
			{
				$rider = $refriderfbidArr[$i];
				$riderfbid = substr($rider, 0, (strlen ($rider)) - (strlen (strrchr($rider,'|'))));
				//echo $rider;
				//echo  $riderfbid;
				generateNotification($riderfbid,NULL,'CANCEL',$refrideid,NULL,NULL,NULL);//notiy all riders
				$i++;
			}	
		}
	}
	
	echo json_encode(getRideByKeyAsObj($rideid));
	}
	catch (PDOException $e) {
		$db->rollback();
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}



function completeRide()
{
	$currenttime = date('Y-m-d H:i:s');
	//echo $currenttime;
	
	//find all rides that are ACTIVE OR FULL and event system time is more than 2 hours passed
	$sql0 = "SELECT fbid, rideid,credit,debit,eventtype FROM transhistory where eventstate in  ('ACTIVE','FULL') and eventgmttime < AddTime(:currentTime, '-02:00:00')";
	
	$sql1 = "UPDATE transhistory SET debit=debit+0.25 where eventstate='ACTIVE' and eventtype='1' and rideid=:rideid";
	$sql2 = "UPDATE transhistory SET eventstate='COMPLETE' where eventstate in ('ACTIVE','FULL') and rideid=:rideid";

	
	try {
        $db   = getConnection();
		$stmt0 = $db->prepare($sql0);
		$stmt0->bindParam(":currentTime",$currenttime);
		$stmt0->execute();
		$ridedata = $stmt0->fetchAll(PDO::FETCH_OBJ);
		//print_r ($ridedata);
		$stmt1 = $db->prepare($sql1);
		$stmt2 = $db->prepare($sql2);
		foreach ($ridedata as $obj) {
			//print_r($obj);
			$tofbid= $obj->fbid;
			$rideid= $obj->rideid;
			$stmt1->bindParam("rideid",$rideid);	
			$stmt1->execute();
			$stmt2->bindParam("rideid",$rideid);	
			$stmt2->execute();
			//update balance
			if ($obj->eventtype=='1') //rider
			{
				$amount=$obj->debit;
				postRideBalance($tofbid,$amount,$rideid);
			}	
			else 
			{
				$amount=$obj->credit;
				postDriveBalance($tofbid,$amount,$rideid);
			}
			generateNotification($tofbid,NULL,'COMPLETE',$rideid,NULL,NULL,NULL);
		}
		$rowcount = $stmt0->rowCount();
		echo '{"count":'.$rowcount.'}';
		$db=null;
	}
	catch (PDOException $e) {
	        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
    
}

function rideReminder()
{

	$currenttime = date('Y-m-d H:i:s');
	//echo $currenttime;
	//find rides that are ACTIVE or FULL and eventgmttime and current time is < 15 mins and reminder='Y'and then reminder='N'
	$sql0 = "SELECT fbid, rideid FROM transhistory where eventstate in  ('ACTIVE','FULL') and :currentTime > AddTime(eventgmttime, '-00:16:00') and reminder='Y' ";
	$sql = "UPDATE transhistory set reminder='N' where rideid = :rideid";
	try {
        $db   = getConnection();
		$stmt0 = $db->prepare($sql0);
		$stmt0->bindParam(":currentTime",$currenttime);
		$stmt0->execute();
		$ridedata = $stmt0->fetchAll(PDO::FETCH_OBJ);
		$rideidArr = array();
		$i=0;
		//print_r ($ridedata);
		$stmt = $db->prepare($sql);
		foreach ($ridedata as $obj) {
			$tofbid= $obj->fbid;
			$rideid= $obj->rideid;
			$stmt->bindParam(":rideid",$rideid);
			$stmt->execute();
			//function generateNotification($tofbid,$fromfbid,$event,$rideid,$notifydata,$notifytype,$notifytime)
			generateNotification($tofbid,NULL,'REMINDER',$rideid,NULL,NULL,NULL);
			$i++;
		}
		echo '{"count":'.$i.'}';
		$db=null;
	}
	catch (PDOException $e) {
	        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

}

function recordExist($fbid,$route,$eventdatetime)
{

	$sql = "SELECT rideid from transhistory where fbid=:fbid and route=:route and eventstate in ('REQUEST','ACTIVE','EMPTY','FULL') and DATE(eventtime)=DATE(:eventdatetime)";
	try {
        $db   = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("fbid",$fbid);
		$stmt->bindParam("route",$route);
		$stmt->bindParam("eventdatetime",$eventdatetime);
		//print_r($sql);
		//echo $fbid.'==='.$route.'==='.$eventdatetime;
		$stmt->execute();
		$rowcount = $stmt->rowCount();
		//print_r($rowcount);
		if ($rowcount == 0)
			return false;
		else
		return true;
		$db=null;
		}
	catch (PDOException $e) {
	        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

	return true;
}	
	



?>