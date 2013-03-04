<?php 

$title="Messaging";
	
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
						<h2>Ride Schedule</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">				
					<div class="charttitle">Messaging</div>
					<div class="charttext">The Ridezu Messaging Platform allows users to message each other and get notifications via email or SMS.  Shuttle running late?  Carpool making an extra stop?  No problem.</div>
					<div id="portalbox">
						<h3>Send a message to...</h3>
						
						<div id="choosevehicle">
							<div id="vehiclephoto" class="left"><img src="../images/demo-martysmissile.png"></div>
							<p id="vehiclename" class="left">Marty's Missile</p>
							<a href="#" class="left">choose</a>
						</div>
						
						<h3>Message:</h3>
						<textarea rows="5" cols="50" class="left"></textarea>
						<input type="submit" id="startbutton" value="Send Message" class="left">
					</div>
				</div>
			</div>
		</section>


<?php 

include 'footer.php';
?>

</html>
