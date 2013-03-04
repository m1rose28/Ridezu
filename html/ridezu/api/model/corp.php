<?php

//require_once 'util.php';

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

function corpCampus() {

  try {
    $corp = json_decode(Slim::getInstance()->request()->getBody());
	$sql = "insert campus (campusname,companyname, addr1,addr2,city,state,zip,latlong) values (:campusname, :companyname,:addr1, :addr2, :city, :state, :zip, :latlong)";

	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("campusname", $corp->campusname);
	$stmt->bindParam("companyname", $corp->companyname);
	$stmt->bindParam("addr1", $corp->addr1);
	$stmt->bindParam("addr2", $corp->addr2);
	$stmt->bindParam("city", $corp->city);
	$stmt->bindParam("state", $corp->state);
	$stmt->bindParam("zip", $corp->zip);
	$stmt->bindParam("latlong", $corp->latlong);
	$stmt->execute();
	echo json_encode(array('campusname' => $corp->campusname));
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

function corpGetData($companyname) {

  try {
    $sql = "select * from company where companyname=:companyname";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("companyname", $companyname);
	$stmt->execute();
	$mycompany = $stmt->fetchObject(); 
	$db=null;
		
	echo json_encode($mycompany);
  } catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
  
}

function campusGetData($companyname) {

  try {
		$sql = "select * from campus where companyname=:companyname and isDeleted is NULL";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("companyname", $companyname);
		$stmt->execute();
		$campuses = $stmt->fetchAll(PDO::FETCH_OBJ); 
		$db=null;
		echo json_encode($campuses);
		
  } catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
  }

function deleteCampus($companyname,$campusid) {

  try {
		$sql = "update campus set isDeleted='Y',campusname=:timestamp where companyname=:companyname and id=:campusid";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$t=time();
		$stmt->bindParam("timestamp", $t);
		$stmt->bindParam("campusid", $campusid);
		$stmt->bindParam("companyname", $companyname);
		$stmt->execute();
		$db=null;
		echo '{"deletecampusresult":{"text":"success"}}';		
  } catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
  }

function corpAddLogo($companylogo,$companyname) {

  try {
		$sql = "update company set logo=:companylogo where companyname=:companyname";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$t=time();
		$stmt->bindParam("companylogo", $companylogo);
		$stmt->bindParam("companyname", $companyname);
		$stmt->execute();
		$db=null;
		echo '{"logoadded":{"text":"success"}}';		
  } catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
  }

function corpGetLogo($companyname) {

  try {
		$sql = "select logo from company where companyname=:companyname";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("companyname", $companyname);
		$stmt->execute();
		$logo = $stmt->fetchObject(); 
		$db=null;
		echo json_encode($logo);
		
  } catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
  }

  }


?>
