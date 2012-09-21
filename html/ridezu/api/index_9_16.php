<?php
$defaultHash=md5('xyxxyx');


require 'model/user.php';
require 'util.php';

//Using Slim
require 'Slim/Slim.php';
$app = new Slim(array(
    'debug' => true));

//Declare Rest calls
$app->get('/', 'getAPIList');
$app->get('/users', 'getUsers' );
$app->get('/users/:id',	'getUser');
$app->get('/users/search/fname/:query', 'findByName');
$app->get('/users/search/fbid/:query', 'findByFB');
$app->post('/users', 'addUser');
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



?>
