<?php
$title="Ridezu";
include "header.php";
?>
<script>
localStorage.fbid="500011910";
</script>

	 <section id="homepageintro" class="homepage">
		 <div class="corpwrapper">
			 <div id="corpmain" class="homepage">
				 <div id="slider">
					 <img class="slide" src="images/sanfran.jpg" alt="San Francisco" />
				 </div>
				 
				 <div id="corptitle" class="index80 homepage">
					 <h2>Revolutionizing the</h2>
					 <h3>way we get to work</h3>
					 <h4>convenient &#8226; economical &#8226; green</h4>
				 </div>
				 
				 <div id="corpstart" class="index80" style="display:none;">
				 
					 <input class="arvo" type="text" value="Where I live" id="home" onfocus="if(this.value==this.defaultValue)this.value='';" 
					 onblur="if(this.value=='')this.value=this.defaultValue;"
					 >
					 
					 <input class="arvo" type="text" value="Where I work" id="work" onfocus="if(this.value==this.defaultValue)this.value='';" 
					 onblur="if(this.value=='')this.value=this.defaultValue;"
					 >
					 
					<a href="#" onclick="start();" id="startbutton">Start</a>

				 </div>

				 <div id="navmenu" class="desktop" style="display:none;">	
						 <ul>
							 <li class="first"><a href="#" class="navlink" onclick="document.getElementById('ridezuiframe').contentWindow.nav1('myridesp');">My Rides</a></li>
							 <li><a href="#" class="navlink" onclick="document.getElementById('ridezuiframe').contentWindow.nav1('riderequestp');">Request a Ride</a></li>
							 <li><a href="#" class="navlink" onclick="document.getElementById('ridezuiframe').contentWindow.nav1('ridepostp');">Post a Ride</a></li>
							 <li><a href="#" class="navlink" onclick="document.getElementById('ridezuiframe').contentWindow.nav1('accountp');">My Account</a></li>
							 <li><a href="#" class="navlink" onclick="document.getElementById('ridezuiframe').contentWindow.nav1('profilep');">My Profile</a></li>
							 <li class="last"><a href="#" class="navlink" onclick="document.getElementById('ridezuiframe').contentWindow.nav1('calcp');">Ridezunomics</a></li>
						 </ul>
				 </div>
				 
				 <div id="webappwrapper" class="index80" style="display:none;">
					 
					 <div id="toolbarnav"> 
						 <a href="#" id="menu-btn"><img id="menub" src="images/menu.png" alt="Menu Button" /></a>
					 
						 <h1 id="title">Title Goes Here</h1>
					 </div>
					 
					 <iframe id="ridezuiframe" src="" height="575" width="340"></iframe>
					 
				 </div>
				 
			 </div>
		 </div>
	 </section>
	 
	 <section id="quotes" style="display:none;">
		 <div class="corpwrapper">
			 <aside id="corpapplinks" class="left">
				 <h3>access ridezu on any mobile device</h3>
				 
				 <a href="#"><img src="images/appstorelink.png" alt="link to Ridezu's app on the iOS app store" /></a>
				 
				 <a href="#"><img src="images/html5.png" alt="link to the web app" /></a>
			 </aside>
			 
			 <div id="maincontent" class="right">
				 <div id="testimonial" class="active">
					 <div id="border">
						 <img class="displaypicture" src="images/dp1.jpg" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />I drove today and collected $7.95 to offset my gas.<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">San Jose</p><img src="images/placesep.png" alt="Place Seperator" /><p class="place">Foster City</p>
					 </div>
				 </div>
				 
				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/dp2.jpg" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />I drove yesterday and met some awesome people!<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">Blockhouse Bay</p><img src="images/placesep.png" alt="Place Seperator" /><p class="place">Devonport</p>
					 </div>
				 </div>
				 
				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/dp3.jpg" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />I've driven for 3 weeks and saved $46.75 total.<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">Green Bay</p><img src="images/placesep.png" alt="Place Seperator" /><p class="place">Manukau</p>
					 </div>
				 </div>
			 </div>
		 </div>
	 </section>
	
	<section id ="noquotes" style="display:none;">
		<div class="corpwrapper">
			<div id="space">
			</div>
		</div>
	</section>
		
<?php
include "footer.php";
?>