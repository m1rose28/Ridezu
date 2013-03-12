<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

echo "Prod cron job";

$lines = file('https://www.ridezu.com/ridezu/api/v/1/rides/eventstate/COMPLETE');

$lines1 = file('https://www.ridezu.com/ridezu/api/notification/NotificationHandler.php');

$lines2 = file('https://www.ridezu.com/ridezu/api/v/1/reminder');

$lines3 = file('https://www.ridezu.com/ridezu/api/v/1/balance/virtual/fixBalance');

$lines4 = file('https://www.ridezu.com/ridezu/api/model/geomaker.php');

echo "<pre>";
print_r($lines);
print_r($lines1);
print_r($lines2);
print_r($lines3);
print_r($lines4);

echo "done";

?>