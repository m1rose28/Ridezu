<?php
function getConnection()
{
    $dbhost = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "ridezu";
    $dbh    = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
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
    $app     = Slim::getInstance();
    $req     = $app->request();
    $hashkey = $req->headers('X-Signature');
    return $hashkey;
}

function generateKey($id)
{
    $key = md5("xyx" . $id . "xyx");
    return $key;
}

function authenticate()
{
    $app     = Slim::getInstance();
    $req     = $app->request();
    $reqURL  = $req->getResourceUri();
    $reqPOST = $req->isPost();
    
    //skip check in below 3 cases
    if ((strpos($reqURL, 'v/1/users') !== false) && ($reqPOST)) {
        return;
    }
    if (strpos($reqURL, 'rides/eventstate/COMPLETE') !== false) {
        return;
    }
    if (strpos($reqURL, 'api/v/1/reminder') !== false) {
        return;
    }
    if ($reqURL=='/v/1/users') {
		return;
	}
		
    $hashkey = $req->headers('X-Signature');
    //echo $hashkey. '----';
    $fbid    = $req->headers('X-Id');
    //echo $fbid.'----';
    $sql     = "SELECT * FROM userprofile WHERE UPPER(fbid) = UPPER(:fbid) and seckey=:hash and deleted <>'Y'";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fbid", $fbid);
        $stmt->bindParam("hash", $hashkey);
        $stmt->execute();
        $rowcount = $stmt->rowCount();
        if ($rowcount == 0)
            $app->halt(401, json_encode(array(
                "status" => false,
                "message" => "USER_NOT_AUTHENTICATED"
            )));
        
        $db = null;
        
    }
    catch (PDOException $e) {
        $app->halt(401, json_encode(array(
            "status" => false,
            "message" => "ERROR_AUTHENTICATING"
        )));
        
    }
}

function authorize($fbid)
{
   $app     = Slim::getInstance();
    $req     = $app->request();
	$headerfbid = $req->headers('X-Id');
	if ($fbid != $headerfbid)
		$app->halt(401, json_encode(array(
            "status" => false,
            "message" => "USER_NOT_AUTHORIZED"
        )));
}

function authenticateAdmin($fbid)
{
	$app     = Slim::getInstance();
    $req     = $app->request();
    $hashkey = $req->headers('X-Signature');
	$headerfbid = $req->headers('X-Id');
    $sql     = "SELECT * FROM userprofile WHERE UPPER(fbid) = UPPER(:fbid) and seckey=:hash and deleted <>'Y' and admin='Y'";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fbid", $fbid);
        $stmt->bindParam("hash", $hashkey);
        $stmt->execute();
        $rowcount = $stmt->rowCount();
        if ($rowcount == 0)
            $app->halt(401, json_encode(array(
                "status" => false,
                "message" => "USER_NOT_AUTHENTICATED"
            )));
        
        $db = null;
        
    }
    catch (PDOException $e) {
        $app->halt(401, json_encode(array(
            "status" => false,
            "message" => "ERROR_AUTHENTICATING"
        )));
        
    }
}


function array_pluck($key, $input)
{
    if (is_array($key) || !is_array($input))
        return array();
    $array = array();
    foreach ($input as $v) {
        $v = (array) $v;
        if (array_key_exists($key, $v))
            $array[] = $v[$key];
    }
    return $array;
}
/**
 * is_json
 *
 * determines whether or not a string contains valid json encoding.
 *
 * @param string $data string to test
 * @return bool true if valid, false if not
 */

function is_json($data)
{
    $obj = json_decode($data);
    if ($obj === NULL)
        $isjson = false;
    else
        $isjson = true;
    return $isjson;
}


function getTotalDays($startDate, $endDate)
{
    $endDate   = strtotime($endDate);
    $startDate = strtotime($startDate);
    
    
    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;
    return $days;
}

function getWorkingDays($startDate, $endDate, $holidays)
{
    // do strtotime calculations just once
    $endDate   = strtotime($endDate);
    $startDate = strtotime($startDate);
    
    
    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;
    
    $no_full_weeks     = floor($days / 7);
    $no_remaining_days = fmod($days, 7);
    
    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week  = date("N", $endDate);
    
    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week)
            $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week)
            $no_remaining_days--;
    } else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)
        
        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;
            
            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        } else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }
    
    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
    //---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
    $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0) {
        $workingDays += $no_remaining_days;
    }
    
    //We subtract the holidays
    foreach ($holidays as $holiday) {
        $time_stamp = strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7)
            $workingDays--;
    }
    
    return $workingDays;
}

function getGasPrice($fbid)
{
    return 3.70;
}

function getMilesPerGallon($fbid)
{
    return 20;
}

function getBaseTripAmount($miles, $fbid)
{
    $amount = $miles / getMilesPerGallon($fbid) * getGasPrice($fbid) * 0.75;
    $amount = round($amount, 2);
    return $amount;
}

function getFee($fbid)
{
    return 0.25;
}

function getFeeByRole($fbid, $eventtype)
{
    if ($eventtype == '0') //driver
        return 0;
    else
        return getFee($fbid); //rider
}
?>