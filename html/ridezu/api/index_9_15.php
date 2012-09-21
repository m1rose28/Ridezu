<?php
$defaultHash=md5('xyxxyx');

//Using Slim
require 'Slim/Slim.php';
$app = new Slim();

//Declare Rest calls
$app->get('/', 'getAPIList');
$app->get('/users', 'getUsers' );
$app->get('/users/:id',	'getUser');
$app->get('/users/search/fname/:query', 'findByName');
$app->get('/users/search/fbid/:query', 'findByFB');
$app->post('/users', 'addUser');
$app->put('/users/:id', 'updateUser');
$app->delete('/users/:id',	'deleteUser'); 

$app->run();





function getAPIList() {
global $defaultHash;

  $hash=getHashKey();
  if ($defaultHash <> $hash)
	return;

echo 'Get All users - GET - /users';
	echo '<p>';
	echo 'Get User Details - GET - /users/$id'; 
	echo '<p>';
	echo 'Search User by Name - GET - /users/search/fname/$query';
	echo '<p>';
	echo 'Search User by Facebook ID - GET - /users/search/fbid/$query';
	echo '<p>';
	echo 'Add user - POST - /users';
	echo '<p>';
	echo 'Update user - PUT -/users/$id';
	echo '<p>';
	echo 'Soft delete user - DELETE - /users/$id';
}

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
    $sql = "INSERT INTO userprofile (fbid, seckey, fname, lname, add1, add2, city,state,zip) VALUES (:fbid, :hash, :fname, :lname, :add1, :add2, :city, :state, :zip)";
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
		$stmt->execute();
        $user->id = $db->lastInsertId();
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
    $sql = "UPDATE userprofile SET fname=:fname, lname=:lname, add1=:add1, add2=:add2, city=:city, state=:state, zip=:zip WHERE id=:id and seckey=:hash";
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
        $stmt->bindParam("id", $id);
		$stmt->bindParam("hash", $hash);
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

 function getConnection() {
	$dbhost="localhost";
	$dbuser="ridezu";
	$dbpass="ridezu123";
	$dbname="ridezu";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
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
	$app = Slim::getInstance();
	$req= $app->request();
	$hashkey=$req->headers('X-Signature');
	return $hashkey;
}
 
 function generateKey($id)
 {
	$key = md5( "xyx".$id."xyx");
	return $key;
 }

?>
