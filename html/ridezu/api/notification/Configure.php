	<?php
  define('ABSPATH' , dirname(__FILE__).'/');
  
  //# Define database connection
  define('DB_SERVER', 'localhost');
  define('DB_SERVER_USERNAME', 'root');
  define('DB_SERVER_PASSWORD', '');
  define('DB_DATABASE', 'ridezu');
  
  //#Notification Constants
  $notificationKeyConst = array('$fbid','$fname','$lname', '$rideid','$credit', '$fromlocation', '$tolocation', '$eventdatetime');  
  
  //#Twilio Test Credential Details
  //define('TWILIO_ACCSID', 'ACb9feead7899c99481e61428be46f033a');
  //define('TWILIO_AUTHTOKEN', '084ce70f6fe8ecd38c9e40245748273d');
  //define('TWILIO_FROM', '+15005550006');
  
  //#Twilio Details
  define('TWILIO_ACCSID', 'AC0dc0980c8bc815a96f175998e59cdb27');
  define('TWILIO_AUTHTOKEN', '3c3bc87c2cf19e874b56ab3561ea9aa6');  
  define('TWILIO_FROM', '+14083859616');

  
?>