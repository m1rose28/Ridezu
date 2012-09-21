<?php
function getRides()
{ 
global $defaultHash;

  $hash=getHashKey();
  if ($defaultHash <> $hash)
	return;

 setHeader();
 $sql = "select * FROM transhistory ORDER by createdon desc";
try {
$db = getConnection();
$stmt = $db->query($sql);  
$rides = $stmt->fetchAll(PDO::FETCH_OBJ);
$db = null;
echo '{"rides": ' . json_encode($rides) . '}';
} catch(PDOException $e) {
echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}
}

function getRide($id) {
setHeader();
$sql = "SELECT * FROM transhistory WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
//$hash=getHashKey();
//$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $ride = $stmt->fetchObject();
        $db = null;
        echo json_encode($ride);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
function findByDriverFB($query) 
{
setHeader();
$sql = "SELECT * FROM transhistory t WHERE t.fbid=:query and t.eventtype='0' ";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("query", $query);
//$hash=getHashKey();
//$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($rides);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
function findByRiderFB($query) 
{
setHeader();
$sql = "SELECT * FROM transhistory WHERE fbid=:query and eventtype='1' ";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("query", $query);
//$hash=getHashKey();
//$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($rides);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
function findByTime($query) 
{
setHeader();
$sql = "SELECT * FROM transhistory WHERE eventtime >=:query and eventtype in ('0','1') ";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("query", $query);
//$hash=getHashKey();
//$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($rides);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
function findDriversByTime($query) 
{
setHeader();

$sql = "SELECT * FROM transhistory WHERE timestampdiff(MINUTE,eventtime,:query) BETWEEN -30 AND  30 and eventtype ='0' ";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("query", $query);
//$hash=getHashKey();
//$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($rides);
		//echo $query;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
function findRidersByTime($query) 
{
setHeader();
$sql = "SELECT * FROM transhistory WHERE timestampdiff(MINUTE,eventtime,:query) BETWEEN -30 AND 30 and eventtype ='1'";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("query", $query);
//$hash=getHashKey();
//$stmt->bindParam("hash", $hash);
        $stmt->execute();
        $rides = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($rides);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function addRide()
{
  
}
  
 
 function updateRide($id)
 {

 }
 
  function deleteRide($id)
 {

 }

 ?>