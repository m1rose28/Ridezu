<?php 

$title="Register";
	
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
						<h2>Register</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">
				
					 <div class="charttitle">Corporate Account Registration</div>
					 <div id="loginbox">
					 <input type="text" id="fname" value="" placeholder="first name"/>
					 <input type="text" id="lname" value="" placeholder="last name"/>
					 <input type="text" id="company" value="" placeholder="company"/>
					 <input type="text" id="email" value="" placeholder="corporate email"/>
					 <input type="text" id="phone" value="" placeholder="phone"/>
					 <input type="password" id="password1" value="" placeholder="password"/>
					 <input type="password" id="password2" value="" placeholder="re-type password"/>
					 <br>
					 <div class="greenbutton" onclick="registeradminuser();"/>Register</div> 
					 <br>Already have an account?<a class="plink" href="login.php">Login ></a>
					 </div>
					 					 <br> 
				</div>
			</div>
		</section>

<iframe id="loginiframe" src="" style="width:0px;height:0px;"/> 


<?php 
include 'footer.php';
?>

</html>
