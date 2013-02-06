<?php
$title="FAQ";
$desc="Simple answers to all your questions about Ridezu.";
include "header.php";
?>
		
		<section id="homepageintro">
			<div class="corpwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>frequently asked questions</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="corpwrapper">
				<?php include "sidebar.php";?>
				
				<div id="maincontent" class="left">

				<?php include "pages/faqp.php";?>

				</div>
			</div>
		</section>
		
<?php
include "footer.php";
?>