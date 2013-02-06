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
				<?php include "sidebar.php";?>
				
				<div id="maincontent" class="left">
				<?php include "pages/benefitsp.php";?>

				</div>
			</div>
		</section>
		

		
<?php
include "footer.php";
?>