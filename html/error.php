<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$m="There was some type of error";

$s=$_SERVER['HTTP_HOST'];

if(file_get_contents("php://input")){

   $m=file_get_contents("php://input");
      
   }

   // to
   $to  = "m1rose28@gmail.com";
   
   // subject
   $subject = "There was an api error on Ridezu.com";
   
   // message
   $message = "
   <html>
   <body>
	 ".$m."
   </body>
   </html>
   ";
   
   // To send HTML mail, the Content-type header must be set
   $headers  = 'MIME-Version: 1.0' . "\r\n";
   $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
   
   // Additional headers
   $headers .= "From: Team Ridezu <support@ridezu.com>" . "\r\n";
   
if($s!="stage.ridezu.com"){
   // Mail it
   mail($to, $subject, $message, $headers);
	}

?>