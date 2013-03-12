<?php 

$title="How it works";
	
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
	
include 'header.php';




?>
<style>
.video{
padding-left:100px;
padding-top:30px;
padding-bottom:40px;
}
.number {
font-size:50px;
color:#53b72c;
text-shadow: 2px 2px #474747;
}
.numbertext {
font-size:30px;
color:#53b72c;
}
</style>
		<section id="homepageintro">
			<div class="portalwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="../images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>How it works</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">				
					<div class="charttitle">We wanted to make it as simple as possible for you...</div>
					<div class="charttext">
						<div style="background-image:url('../images/123background.png');background-repeat:no-repeat;width:960px;height:580px;">
							<span class="number" style="position:absolute;left:63px;top:57px;">1</span>
							<span class="number" style="position:absolute;left:110px;top:210px;">2</span>
							<span class="number" style="position:absolute;left:75px;top:414px;">3</span>
							<span class="numbertext" style="position:absolute;left:95px;top:70px;">sign-up</span>
							<span class="numbertext" style="position:absolute;left:162px;top:223px;">add locations and people</span>
							<span class="numbertext" style="position:absolute;left:127px;top:427px;">get the word out</span>
							<span style="position:absolute;left:320px;top:110px;width:300px;">
								Registration is simple.  Just tell us a little about your company, upload a logo, and you're ready to go.
							</span>
							<span style="position:absolute;left:345px;top:295px;width:550px;">
								You may have one location or you may have many.  We've designed a simple wizard to make adding company locations a breeze.  Next, upload your employee locations via a simple .csv file, and we'll show you where all your employees live and how they could carpool together.
						    	<a href="#load" class="plink">Watch the video ></a>
						    </span>
							<span style="position:absolute;left:115px;top:500px;width:550px;">
								Last but not least, you'll want to let your employees know about the program.  We've created a simple tool where we can send an intro email to your employees or a you can do this directly via a special link that we'll give you. 
								<a href="#message" class="plink">Watch the video ></a>   
							</span>
							
						</div>
					</div>
					<div class="charttitle">Quick Start Videos</div>
					<a id="load"></a>
					<div class="video">
						<iframe width="640" height="480" src="http://www.youtube.com/embed/igj1reXKdng" frameborder="0" allowfullscreen></iframe>
					</div>
					<div class="video">
						<iframe width="640" height="480" src="http://www.youtube.com/embed/3MeXUB6mMq8" frameborder="0" allowfullscreen></iframe>
					</div>
					<div class="video">
						<iframe width="640" height="480" src="http://www.youtube.com/embed/VhLdpyu9U3o" frameborder="0" allowfullscreen></iframe>
					</div>
					<a id="message"></a>
					<div class="video">
						<iframe width="640" height="480" src="http://www.youtube.com/embed/6Z1fiAc0KQQ" frameborder="0" allowfullscreen></iframe>
					</div>
					<div class="video">
						<iframe width="640" height="480" src="http://www.youtube.com/embed/EwjdOhQPbAs" frameborder="0" allowfullscreen></iframe>	
					</div>
				
				</div>
			</div>
		</section>



<?php 

include 'footer.php';
?>

</html>
