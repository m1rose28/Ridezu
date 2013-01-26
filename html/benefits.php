<?php
$title="Benefits";
$desc="Discover all the benefits of Ridezu.";

include "header.php";
?>
		
		<section id="homepageintro">
			<div class="corpwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>benefits</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="corpwrapper">
				<aside id="corpapplinks" class="right">
					<h3>access ridezu on any mobile device</h3>
					
				 <a href="https://itunes.apple.com/app/ridezu/id594682080?mt=8" target="apple" ><img src="images/appstore.png" alt="link to Ridezu's app on the iOS app store" /></a>
					
					<a href="#"><img src="images/html5.png" alt="link to the web app" /></a>
				</aside>
				
				<div id="maincontent" class="left">

				<?php include "pages/benefitsp.php";?>

				</div>
			</div>
		</section>
		
<?php
include "footer.php";
?>