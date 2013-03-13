<?php 

$title="Login";
	
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

$_SESSION['companyname']="";
$_SESSION['corpuserid']="";
$_SESSION['corpseckey']="";
$_SESSION['email']="";
	
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
					<form>
					 <h3 class="charttitle">Login</h3>
					 <div id="loginbox">
					 <input type="text" id="login" value="" placeholder="login (email)">
					 <input type="password" id="password" value="" placeholder="password">
					 <br>
					 <div class="greenbutton" onclick="loginuser();">Login</div> 
					 <br>Don't have a login? <a class="plink" href="register.php">Register for a corporate account ></a>

					 <!--<a href="#" onclick="passwordreset();">Forgot password?</a>-->
					 </div>
					</form>
				</div>
			</div>
		</section>

<iframe id="loginiframe" src="" style="width:0px;height:0px;"></iframe> 


<?php 
include 'footer.php';
?>
