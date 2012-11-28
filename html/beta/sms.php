<?php 

function s($text) {
    $text=str_replace("<", "`", $text);
    $text=str_replace(">", "`", $text);
    $text=str_replace("'", "`", $text);
    return $text;
    }

$user=s($_GET['user']);
$smsmessage=s($_GET['message']);
$usernumber=s($_GET['usernumber']);

require('../twillio/Services/Twilio.php');

$sid = "AC0dc0980c8bc815a96f175998e59cdb27"; // Your Account SID from www.twilio.com/user/account
$token = "3c3bc87c2cf19e874b56ab3561ea9aa6"; // Your Auth Token from www.twilio.com/user/account

$client = new Services_Twilio($sid, $token);
$message = $client->account->sms_messages->create(
  '4083859616', // From a valid Twilio number
  $usernumber, // Text this number
  $smsmessage
);

$callback=$message->sid;

echo $callback;


?>
