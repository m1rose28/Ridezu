<?php
// multiple recipients
$to  = 'jhagels@yahoo.com';

// subject
$subject = 'this is a test of the mail server '.rand(1, 1000);

// message
$message = '
<html>
<head>
  <title>Mary had a little Ridezu</title>
</head>
<body>
  <p>Its fleece was green as grass, </p>
<b>and every where Mary went, so did her ass.</b>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: Mark Rose <jhagel@yahoo.com>' . "\r\n";
$headers .= 'From: Ridezu Operations <support@ridezu.com>' . "\r\n";


// Mail it
mail($to, $subject, $message, $headers);

echo "now check your mail to: $to (or quit spamming already and edit the php file yourself)";
?>
