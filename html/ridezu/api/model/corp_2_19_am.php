<?php

require_once 'util.php';

function corpRegister($companyname) {
  $sql = "insert company (companyname) values (:companyname)";
  $companyid=null;
  try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("companyname", $companyname);
	$stmt->execute();
  } catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
  
  //echo "<ul><li>CompanyName: $companyname</li></ul>";
}

function corpCampus($campusname, $companyid, $addr1, $addr2, $city, $state, $zip, $latlong, $seckey) {
  $sql = "insert campus (campusname,companyid,addr1,addr2,city,state,zip,latlong) values (:campusname, :companyid, :addr1, :addr2, :city, :state, :zip, :latlong)";

  try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("campusname", $campusname);
	$stmt->bindParam("companyid", $companyid);
	$stmt->bindParam("addr1", $addr1);
	$stmt->bindParam("addr2", $addr2);
	$stmt->bindParam("city", $city);
	$stmt->bindParam("state", $state);
	$stmt->bindParam("zip", $zip);
	$stmt->bindParam("latlong", $latlong);
	$stmt->execute();
	echo json_encode(array('campusname' => $campusname));
  } catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
  }

}
	
function corpRegAdminUser($fname, $lname, $email, $companyid, $pwd) {
  $sql = "insert campusadmin (fname,lname,email,companyid,password) values (:fname, :lname, :email, :companyid, :pwd)";

  try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("fname", $fname);
	$stmt->bindParam("lname", $lname);
	$stmt->bindParam("email", $email);
	$stmt->bindParam("companyid", $companyid);
	$sha1 = sha1($pwd);
	$stmt->bindParam("pwd", $sha1);
	$stmt->execute();
	//    TODO: fix generation  it needs to use email not fbid when sending..
	//generateNotification($user->fbid,NULL,'WELCOME',NULL,NULL,'EMAIL',NULL);

	echo json_encode(array('email' => $email,
						   'seckey' => $seckey, // TODO: seckey ? where from?
						   ));

  } catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
  }

}

function corpGetData($companyid) {
  $sql = "select * from campus where companyid=:companyid";

  try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("companyid", $companyid);
	$stmt->execute();
	$campuses = $stmt->fetchAll(PDO::FETCH_OBJ); // campi? no campuses :)
	echo json_encode($campuses);
  } catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
  
}

?>
