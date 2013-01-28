<?php 

$title="Change Password";
	
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
	
include 'header.php';



?>



		<section id="homepageintro">
			<div class="portalwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="../images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>Change Password</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">
				
					 <div class="charttitle">Change Password</div>
					 <div id="loginbox">
					 <div>Please enter your current password:</div>
					 <input type="password" id="oldpassword" value=""/>
					 <div>Please enter your new password:</div>
					 <input type="password" id="newpassword" value=""/>
					 <div>Please re-type your new password:</div>
					 <input type="password" id="newpassword1" value=""/>
					 <br><div id="startbutton" href="#" onclick="changepassword();">Change Password</div> 
					 </div>
					 
				</div>
			</div>
		</section>


<?php 
include 'footer.php';
?>

</html>
