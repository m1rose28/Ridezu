<?php
$p="";

if($_POST){
  $name=$_POST["n"];
  $email=$_POST["email"];
  $message1=$_POST["message"];
  $p=1;

    // 1. send email confirmation to user who sent email

   // to
   $to  = $name." <".$email.">";
   
   // subject
   $subject = "Thanks for your note!";
   
   // message
   $message = "
   <html>
   <body>
	 <p>Thanks for your note.  We will get back to you right away!</p>
	 <p>Team Ridezu</p>
   </body>
   </html>
   ";
   
   // To send HTML mail, the Content-type header must be set
   $headers  = 'MIME-Version: 1.0' . "\r\n";
   $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
   
   // Additional headers
   $headers .= "From: Team Ridezu <support@ridezu.com>" . "\r\n";
   
   
   // Mail it
   mail($to, $subject, $message, $headers);
   
    // 2. send actual message to mark
 
   // to
   $to  = 'm1rose28@gmail.com';
   
   // subject
   $subject = "inquiry on Ridezu.com (".$name.")";
   
   // message
   $message = "
   <html>
   <body>
	 <p>from: ".$email."</p>
	 <p>message:</p>
	 <p>".$message1."
   </body>
   </html>
   ";
   
   // To send HTML mail, the Content-type header must be set
   $headers  = 'MIME-Version: 1.0' . "\r\n";
   $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
   
   // Additional headers
   $headers .= "To: Mark Rose <m1rose28@gmail.com>" . "\r\n";
   $headers .= "From: ".$name." <".$email.">" . "\r\n";
   
   // Mail it
   mail($to, $subject, $message, $headers);   
}

$title="Contact Us";
$desc="It's easy to contact us and we'll get back to you right away.";
include "header.php";
?>
		
		<section id="homepageintro">
			<div class="corpwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>contact us</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="corpwrapper">

<?php
include "sidebar.php";
?>
		
<?php
if($p==""){ ?>				
				<div id="maincontent" class="left contact">
					<h2>Contact Us</h2> 			
					<p>Got a question?  Got a suggestion?  Let us know and we'll get back to you right away!</p>  
					<form method="post" action="contact.php">
					<p>Name</p>
					<input type="text" name="n"/>
					<p>email</p>
					<input type="text" name="email"/>
					<p>Message</p>
					<textarea rows="4" cols="60" name="message"/></textarea> <br>
					<input type="submit" value="Submit" id="startbutton">
				</div>
			</div>
		</section>
		
<?php } ?>

<?php
if($p=="1"){ ?>				
				<div id="maincontent" class="left">
					<h2>Thanks!</h2> 			
					<p>We'll get back to you right away!</p>
				</div>
			</div>
		</section>
		
<?php } ?>

<?php
include "footer.php";
?>