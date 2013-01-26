<?php 

$title="Admin";
	
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
						<h2>Login</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">
				
					 <div class="charttitle">Company Info</div>
					 <div id="loginbox">
						 <div>Company Name:</div>
						 <input type="text" id="company" value=""/>
						 <div>email domain (yourcompany.com):</div>
						 <input type="text" id="emailpattern" value=""/>
						 <div>Company logo</div>
						 <input type="file" id="companylogo" value=""/>
	
						 <br><br><div id="startbutton" href="#" onclick="updateinfo();">Update</div> 
					 </div>
					 <div class="charttitle">My Info</div>
					 <div id="loginbox">
					 	<a href="#" onclick="passwordreset();">Change Password</s> 
					 </div>
				</div>
			</div>
		</section>



<?php 
include 'footer.php';
?>

</html>
