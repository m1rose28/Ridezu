<?php
function addSignUpBalance($fbid,$refid)
{
        try {
                $db = getConnection();
                $sStatement = "insert into balance (fbid, realbalance,virtualbalance,transaction,refid) values (:fbid,0,10,'SIGNUP',:refid)";
                $oPDOStatement = $db->prepare($sStatement);
                $oPDOStatement->bindParam(':fbid', $fbid);
				$oPDOStatement->bindParam(':refid', $refid);
				
                if ($oPDOStatement){
                    $oPDOStatement->execute();
                }
				$db = null;
        } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
        }       

}
//manage balance after the rides are completed.
function postRideBalance($fbid,$amount,$refid)
{

//find all completed rides calculate balance. for rides balance already calculated the state should change to COMPLETE
	$sql0 = "INSERT INTO balance(fbid, virtualbalance, realbalance, refid,transaction) SELECT fbid,virtualbalance - :amount,realbalance, :refid,'RIDE' FROM balance WHERE fbid=:fbid ORDER BY id DESC LIMIT 1";
	try {
        $db   = getConnection();
		$stmt0 = $db->prepare($sql0);
		$stmt0->bindParam(':fbid', $fbid);
		$stmt0->bindParam(':amount', $amount);
		$stmt0->bindParam(':refid', $refid);
		$stmt0->execute();
		$db=null;
	}
	catch (PDOException $e) {
	        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function postDriveBalance($fbid,$amount,$refid)
{

//find all completed rides calculate balance. for rides balance already calculated the state should change to COMPLETE
	//for rides subtract from virtual balance ; for drives add 
	$sql0 = "INSERT INTO balance(fbid, virtualbalance,realbalance,refid,transaction) SELECT fbid,virtualbalance, realbalance + :amount,:refid,'DRIVE' FROM balance WHERE fbid=:fbid ORDER BY id DESC LIMIT 1";
	try {
        $db   = getConnection();
		$stmt0 = $db->prepare($sql0);
		$stmt0->bindParam(':fbid', $fbid);
		$stmt0->bindParam(':amount', $amount);
		$stmt0->bindParam(':refid', $refid);
		$stmt0->execute();
		$db=null;
	}
	catch (PDOException $e) {
	        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getBalance($fbid)
{
	 setHeader();
	$sql = "SELECT fbid,realbalance,virtualbalance FROM balance WHERE fbid=:fbid ORDER BY id DESC LIMIT 1";
    try {
        //$hash=getHashKey();
		
		$db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fbid", $fbid);
		$stmt->execute();
        $balance = $stmt->fetchObject();
		$db = null;
		return $balance;
        //echo json_encode($balance);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function fixVirtualBalance()
{
	
	//ride balance aways subtracts from virtual. Once virtual becomes -ve it is moved to real balance.
	$sql0 = "UPDATE balance SET realbalance=virtualbalance+realbalance, virtualbalance=0 where virtualbalance < 0"; 
	
	try {
        $db   = getConnection();
		$stmt0 = $db->prepare($sql0);
		$stmt0->execute();
		$db=null;
	}
	catch (PDOException $e) {
	        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}	

function addRefererBalance($referfbid,$newfbid)
{
	$sql0 = "INSERT INTO balance(fbid, virtualbalance,realbalance,refid,transaction) SELECT fbid,virtualbalance + 10, realbalance,:newfbid,'REFER' FROM balance WHERE fbid=:referfbid ORDER BY id DESC LIMIT 1";
	try {
		$db   = getConnection();
		$stmt0 = $db->prepare($sql0);
		$stmt0->bindParam(':referfbid', $referfbid);
		$stmt0->bindParam(':newfbid', $newfbid);
		$stmt0->execute();
		$db=null;
	}
	catch (PDOException $e) {
	        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
	getBalance($referfbid);
}

 ?>