<?php

$title="Send Welcome email";
	
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require '../ridezu/api/util.php';
require '../ridezu/api/model/user.php';
require '../ridezu/api/model/notification.php';
	
include 'header.php';

$f="";		
if(isset($_GET["f"])){
	$f=$_GET["f"];

	if($f=="test"){	
		$sql = "select fbid,fname from userprofile where company=:companyname and email=:email and deleted<>'Y' limit 0,1";
		}

	if($f=="all"){
		$sql = "select fbid,fname from userprofile where company=:companyname and email<>:email and deleted<>'Y'";
		}


	if($f=="all" or $f=="test"){
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("companyname", $companyname);
		$stmt->bindParam("email", $email);
		$stmt->execute();
		$emaillist = $stmt->fetchAll(PDO::FETCH_ASSOC); 
		$db=null;
				
		foreach($emaillist as $key=>$value){
			$c='$companyname='.$companyname.',$fname='.$value['fname'];
			generateNotification($value['fbid'],NULL,'CORPWELCOME',NULL,$c,'EMAIL',NULL);
			}
		}
	}
?>

		<section id="homepageintro">
			<div class="portalwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="../images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>Send Welcome Email</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">				

						<?php if($f<>""){ ?>

						<div class='success'>
							Congratulations!  Your email has been sent.  Please check for it in your inbox in the next few moments.
						</div>

						<?php } ?>

						<div class="charttitle">Send Welcome Email</div>
						<div class="charttext">Now that your employees are loaded, they will need to be introduced to Ridezu.  
						<br>
						<br>
							<div class="greenbutton" onclick="window.location='welcomemessage.php?f=test';">Test email (to you)</div>
							<br>
							<div class="greenbutton" onclick="window.location='welcomemessage.php?f=all';">Send intro email</div>
							<br>
						</div>
						<br>
						<div class="charttitle">What if I want to send my own email?</div>
						<div class="charttext">You can also communicate with your employees directly.  Please be sure to include the following link as this link is specially coded for <?php echo $companyname;?>.
						<br>
						<br><span style="background-color:#f7f7f7;padding:10px;"><?php echo "https://www.ridezu.com?c=$companyname&msg=Welcome";?>  
							</span></div>
						<br>
						<br>
						<div class="charttitle">What about security and privacy?</div>
						<div class="charttext">The welcome email sends a simple email to your employees introducing Ridezu with a link to register.  Employees will register with the email address you have provided.  Private employee data such as email and home address is never shared, even with other employees.  
						<br>
						<br>
						<br>
						</div>
				</div>
			</div>
		</section>



<?php 

include 'footer.php';
?>

</html>

