<?php

echo "stage cron job";

$lines = file('https://stage.ridezu.com/ridezu/api/v/1/rides/eventstate/COMPLETE');

$lines1 = file('https://stage.ridezu.com/ridezu/api/notification/NotificationHandler.php');

$lines2 = file('https://stage.ridezu.com/ridezu/api/v/1/reminder');

$lines3 = file('https://stage.ridezu.com/ridezu/api/v/1/balance/virtual/fixBalance');

$lines4 = file('https://stage.ridezu.com/ridezu/api/model/geomaker.php');

echo "<pre>";
print_r($lines);
print_r($lines1);
print_r($lines2);
print_r($lines3);
print_r($lines4);

echo "done";

?>
