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
						<h2>Admin</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">
				<div style="float:left;">
					 <div class="charttitle">Company Info</div>
						 <div style="padding-left:30px;width:400px;">
							<div class="label1">Company Name:</div>
							<div id="company"></div>
							<div class="label1">email domain (yourcompany.com):</div>
							<div id="companyemail"></div>
							<div class="label1">Company logo</div>
							<img id="companylogo" src="" style="width:150px;">	
						</div> 
				</div>
				<div style="float:left;">
					 <div class="charttitle">My Info</div>
						 <div style="padding-left:30px;width:200px;">
							 <div class="label1">Name:</div>
							 <div id="name"></div>
							 <div class="label1">email</div>
							 <div id="email"></div>
							 <div class="label1">Phone</div>
							 <div id="phone"></div>
							<a id="startbutton" href="changepassword.php">Update Password</a> 
						  </div>
					 </div>
				</div>
				</div>
			</div>
		</section>



<?php 
include 'footer.php';
?>

</html>
