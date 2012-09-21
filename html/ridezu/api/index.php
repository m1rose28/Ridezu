<?php
$defaultHash=md5('xyxxyx');


require 'model/user.php';
require 'model/ride.php';
require 'util.php';
 
//Using Slim
require 'Slim/Slim.php';
$app = new Slim(array(
    'debug' => true));
//$app->hook('slim.before', 'authorize');

//Declare Rest calls
$app->get('/', 'getAPIList');
$app->get('/users', 'getUsers' );
$app->get('/users/:id',	'getUser');
$app->get('/users/search/fname/:query', 'findByName');
$app->get('/users/search/fbid/:query', 'findByFB');
$app->post('/users', 'addUser');
$app->put('/users/:id', 'updateUser');
$app->delete('/users/:id',	'deleteUser'); 



$app->get('/rides','getRides'); //get all rides - helper method - will be removed later
$app->get('/rides/:id','getRide'); //get particular ride
$app->get('/rides/search/driver/:query','findByDriverFB'); //search rides by a particular driver
$app->get('/rides/search/rider/:query','findByRiderFB'); //search rides by particular passenger
$app->get('/rides/search/eventtime/:query','findByTime'); //search ride based on particular date/time (origin and dest are implicit)
$app->get('/rides/search/eventtime/:query/driver','findDriversByTime');
$app->get('/rides/search/eventtime/:query/rider','findRidersByTime');
$app->post('/rides','addRide'); 
$app->put('/rides/:id'.'updateRide');
$app->delete('/rides/:id','deleteRide');


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
