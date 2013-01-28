<?php

function getAccountSummary($fbid, $timeperiod)
{
    setHeader();
    //find user's timezone and current date/time
    $user         = queryByFB($fbid);
    $userTimeZone = $user->timezone;
    
    //get today's date and time
    $todaydatetime = new DateTime;
    
    switch ($timeperiod) {
        case 'M':
            print 'month';
            break;
        case 'W':
            print 'week';
            break;
        case 'Y':
            //find the current year
            $year      = $todaydatetime->format('Y');
            $startdate = $year . '-1-1 0:0:0';
            $enddate   = $year . '-12-31 23:59:59';
            break;
        default:
            print 'unknown';
            break;
            
    }
    
    
    $sql = "select sum(credit) totalcredit, sum(debit) totaldebit, count(1) totaltrips, sum(miles) totalmiles, count(1) totalgassavingspercent, sum(co2) totalco2, (sum(riders) - count(1)) totalpassengers
from transhistory
where fbid =:fbid and eventtype in ('1','0') and eventstate='COMPLETE' and eventtime between :startdate and :enddate order by eventtime desc";
    
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fbid", $fbid);
        $stmt->bindParam("startdate", $startdate);
        $stmt->bindParam("enddate", $enddate);
        //echo "fbid" . $fbid . " | startdate " . $startdate . " | enddate " . $enddate;
        $stmt->execute();
        $account  = $stmt->fetchObject();
        $rowcount = $stmt->rowCount();
        if ($rowcount == 0)
            echo '{"warning":{"text":"No records found"}}';
        else {
            $workingdays                     = getWorkingDays($startdate, $enddate, array());
            //echo "working days " . $workingdays;
            $account->totalgassavingspercent = (string) round($account->totaltrips * 2 / $workingdays * 100, 2);
            echo '{"account":' . json_encode($account) . '}';
        }
        $db = null;
        
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}


function getAccountDetail($fbid, $timeperiod)
{
    setHeader();
    //find user's timezone and current date/time
    $user         = queryByFB($fbid);
    $userTimeZone = $user->timezone;
    
    //get today's date and time
    $todaydatetime = new DateTime;
    
    switch ($timeperiod) {
        case 'M':
            print 'month';
            break;
        case 'W':
            print 'week';
            break;
        case 'Y':
            //find the current year
            $year      = $todaydatetime->format('Y');
            $startdate = $year . '-1-1 0:0:0';
            $enddate   = $year . '-12-31 23:59:59';
            break;
        default:
            print 'unknown';
            break;
            
    }
    
    $sql = "select eventtime, route, origindesc, destdesc, credit, debit
from transhistory
where fbid =:fbid and eventtype in ('1','0') and eventstate='COMPLETE' and eventtime between :startdate and :enddate order by eventtime desc";
    
    try {
        $db   = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fbid", $fbid);
        $stmt->bindParam("startdate", $startdate);
        $stmt->bindParam("enddate", $enddate);
        //echo "fbid" . $fbid . " | startdate " . $startdate . " | enddate " . $enddate;
        $stmt->execute();
        $accountdetail = $stmt->fetchAll(PDO::FETCH_OBJ);
        $rowcount      = $stmt->rowCount();
        $db            = null;
        if ($rowcount == 0)
            echo '{"warning":{"text":"No records found"}}';
        else
            echo '{"accountdetail":' . json_encode($accountdetail) . '}';
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}


?>