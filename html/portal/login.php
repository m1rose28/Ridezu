<?php 

$title="Login";
	
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
				
					 <div class="charttitle">Login</div>
					 <div id="loginbox">
					 <div>Email:</div>
					 <input type="text" id="login" value=""/>
					 <div>Password:</div>
					 <input type="password" id="password" value=""/>
					 <br><div id="startbutton" href="#" onclick="loginuser();">Login</div> 
					 <!--<a href="#" onclick="passwordreset();">Forgot password?</a>-->
					 </div>
					 					 <br> 
					 <!--Don't have a login? <a href="register.php">Sign-up for a corporate account ></a>-->

				</div>
			</div>
		</section>

<iframe id="loginiframe" src="" style="width:0px;height:0px;"/> 
<script>

</script>
<?php 
include 'footer.php';
?>

</html>
