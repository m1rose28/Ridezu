<?php
//Using Slim
require 'Slim/Slim.php';
$app = new Slim();

//Declare Rest calls
$app->get('/', 'getAPIList');
$app->get('/users', 'getUsers' );
$app->get('/users/:id',	'getUser');
$app->get('/users/search/:query', 'findByName');
$app->post('/users', 'addUser');
$app->put('/users/:id', 'updateUser');
$app->delete('/users/:id',	'deleteUser'); 

$app->run();





function getAPIList() {
	echo 'Get All users - GET - /users';
	echo '<p>';
	echo 'Get User Details - GET - /users/$id'; 
	echo '<p>';
	echo 'Search User by Name - GET - /users/search/$query';
	echo '<p>';
	echo 'Add user - POST - /users';
	echo '<p>';
	echo 'Update user - PUT -/users/$id';
	echo '<p>';
	echo 'Delete user - DELETE - /users/$id';
}

function getUsers()
{ echo 'all users';
}

function getUser($id) {
	echo $id;
}

//Shows how to return json data
function findByName($query) 
{
 $data=array("user",$query);
 $app = Slim::getInstance();
 $app->response()->header("Content-Type", "application/json");
 echo json_encode($data);


}
//shows how to access request and body
function addUser()
{
  $request = Slim::getInstance()->request();
  $body = $request->getBody();
  
  echo $body;
  echo '<p>';
  echo 'adding users';
 }
 
 function updateUser($id)
 {
 echo 'updated user';
 }
 function deleteUser($id)
 {
 echo 'delete user';
 }
?>
