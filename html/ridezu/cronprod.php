<?php

echo "Prod cron job";

$lines = file('https://www.ridezu.com/ridezu/api/v/1/rides/eventstate/COMPLETE');

$lines1 = file('https://www.ridezu.com/ridezu/api/notification/NotificationHandler.php');

$lines1 = file('https://www.ridezu.com/ridezu/api/v/1/reminder');

$lines1 = file('https://www.ridezu.com/ridezu/api/v/1/balance/virtual/fixBalance');
?>