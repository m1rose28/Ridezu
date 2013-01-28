<?php 

$title="Sign-up";
	
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
						<h2>Sign-up</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">
				
					 <div class="charttitle">Sign-up for a corporate account</div>
					 <div id="loginbox">
					 <div>First name:</div>
					 <input type="text" id="fname" value=""/>
					 <div>Last name:</div>
					 <input type="text" id="lname" value=""/>
					 <div>Company:</div>
					 <input type="text" id="company" value=""/>
					 <div>Email:</div>
					 <input type="text" id="email" value=""/>
					 <div>Password:</div>
					 <input type="password" id="password" value=""/>
					 <br><div id="startbutton" href="#" onclick="passwordreset();">Sign-up</div> 
					 <a href="login.php">I already have an account</a>
					 </div>
					 					 <br> 
				</div>
			</div>
		</section>



<?php 
include 'footer.php';
?>

</html>
