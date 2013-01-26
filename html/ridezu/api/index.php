<?php
$defaultHash=md5('xyxxyx');

require 'model/user.php';
require 'model/ride.php';
require 'model/account.php';
require 'model/node.php';
require 'model/notification.php';
require 'model/payment.php';
require 'util.php';
//require_once 'braintree-php-2.17.0/lib/Braintree.php';
//require_once __DIR__ . '/vendor/autoload.php';
 
//Using Slim
require 'Slim/Slim.php';
$app = new Slim(array(
    'debug' => true));
$app->hook('slim.before', 'authenticate');


/*** USER APIs ***/
$app->get('/v/1/users', 'getUsers' );
$app->get('/v/1/users/:id',	'getUser');
$app->get('/v/1/users/search/fname/:query', 'findByName');
$app->get('/v/1/users/search/fbid/:query', 'findByFB'); //authorization enabled
$app->get('/v/1/users/search/login/:userid/pwd/:pwd', 'findByLogin');
$app->get('/v/1/users/searchpublic/fbid/:query', 'findPublicDataByFB');
$app->post('/v/1/users', 'addUser');
$app->put('/v/1/users/:id/fbid/:fbid', 'updateUser'); //authorization enabled
//$app->delete('/v/1/users/:id',	'deleteUser'); 
$app->get('/v/1/users/search/fbid/:fbid/location/:location','getNodes');  //authorization enabled

/*** RIDE APIS ***/
$app->get('/v/1/rides','getRides'); //get all rides - helper method - will be removed later
$app->get('/v/1/rides/:id','getRide'); //get particular ride
$app->get('/v/1/rides/:id/driver','getDriverRide'); //get driver data for particular ride
$app->get('/v/1/rides/:id/rider','getRiderRide'); //get rider data for particular ride

$app->get('/v/1/rides/search/driver/fbid/:fbid','findByDriverFB'); //search rides by a particular driver
$app->get('/v/1/rides/search/rider/fbid/:fbid','findByRiderFB'); //search rides by particular passenger
$app->get('/v/1/rides/search/fbid/:fbid','findRideByFB'); //search rides/requests by FB id

$app->get('/v/1//rides/search/eventtime/:query','findRidesByTime'); //search ride based on particular date/time (origin and dest are implicit)

$app->get('/rides/search/eventtime/:query/driver','findDriversByTime');
$app->get('/rides/search/eventtime/:query/rider','findRidersByTime');
			
//search for driver list
$app->get('/v/1/rides/search/fbid/:query/searchroute/:searchroute/searchdate/:searchdate/driver','findMatchingDrivers');
$app->get('/v/1/rides/search/fbid/:query/driver','findDefaultMatchingDrivers');
//search for rider list
$app->get('/v/1/rides/search/fbid/:query/searchroute/:searchroute/searchdate/:searchdate/rider','findMatchingRiders');
$app->get('/v/1/rides/search/fbid/:query/rider','findDefaultMatchingRiders');

$app->put('/v/1/rides/rideid/:rideid/rider','fillRide'); //add rider to the rides
$app->put('/v/1/rides/rideid/:rideid/driver','fillRideRequest'); //add driver to the ride request

$app->post('/v/1/rides/driver','postRide');  //post a ride
$app->post('/v/1/rides/rider','requestRide'); 
$app->put('/rides/:id'.'updateRide');
$app->delete('/v/1/rides/rideid/:rideid/fbid/:fbid','cancelRide');
$app->get('/v/1/rides/eventstate/COMPLETE','completeRide');

$app->get('/v/1/reminder','rideReminder');


/*** USER ACCOUNT APIS ***/
$app->get('/v/1/account/summary/fbid/:query/timeperiod/:timeperiod','getAccountSummary'); //authorization enabled
$app->get('/v/1/account/detail/fbid/:query/timeperiod/:timeperiod','getAccountDetail'); //authorizaiton enabled

/*** NOTIFICATION APIS ***/
$app->post('/v/1/notification/message/fbid/:fbid/fromfbid/:fromfbid','sendMessage');

//payment APIs - FOR TEST ONLY
//$app->get('/v/1/payment','makePayment');

$app->run();

?>
