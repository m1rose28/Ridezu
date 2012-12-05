<?php
$title="Ridezu";
include "header.php";
?>

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
					 
						 <h1 id="title"></h1>
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

				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/1.png"/>
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />I drove today and collected $7.95 to offset my gas.  This year that's about $1,700.<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">San Jose</p><img src="images/placesep.png" /><p class="place">Foster City</p>
					 </div>
				 </div>
				 
				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/2.png" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />Now I can check my email on the way into the office - total productivity boost!<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">Mountain View</p><img src="images/placesep.png"/><p class="place">San Francisco</p>
					 </div>
				 </div>
				 
				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/3.png" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />I've driven way too many miles alone. I should save over $1,000 this year.<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">Los Gatos</p><img src="images/placesep.png" /><p class="place">Santa Clara</p>
					 </div>
				</div>
			
				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/4.png" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />The park and ride is a mile from my home so Ridezu is really convenient for me.<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">Los Gatos</p><img src="images/placesep.png" /><p class="place">Santa Clara</p>
					 </div>
				</div>
	
				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/5.png" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />A group of us at the office use Ridezu now.  It actually brings the office closer together.<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">Morgan Hill</p><img src="images/placesep.png" /><p class="place">Palo Alto</p>
					 </div>			
				 </div>

				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/6.png" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />Ridezunomics (love that name) is awesome! I had no idea how much Co2 my car was contributing.<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">San Jose</p><img src="images/placesep.png" /><p class="place">San Mateo</p>
					 </div>
				</div>
	
				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/7.png" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />The app is super easy to use and sign up only took a minute. Highly recommend trying it out.<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">Sunnyvale</p><img src="images/placesep.png" /><p class="place">San Francisco</p>
					 </div>			
				 </div>

				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/8.png" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />Ridezu really helps offset my gas costs. It is amazing how much I can save!.<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">Los Gatos</p><img src="images/placesep.png" /><p class="place">Foster City</p>
					 </div>
				</div>
	
				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/9.png" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />I love how the app shows me reducing my carbon footprint. Such a simple idea.  Such a big impact.<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">San Jose</p><img src="images/placesep.png" /><p class="place">Palo Alto</p>
					 </div>			
				 </div>

				 <div id="testimonial">
					 <div id="border">
						 <img class="displaypicture" src="images/10.png" alt="Display Picture" />
					 </div>
					 
					 <blockquote class="right">
					 <p class="arvo"><img src="images/quoteup.png" alt="Quote" />Ridezu is going to bring my stress levels way down. Not driving in traffic is awesome!<img src="images/quotedown.png" alt="Quote" /></p>
					 </blockquote>
					 
					 <div id="placestravelled">
						 <p class="place">Campbell</p><img src="images/placesep.png" /><p class="place">Menlo Park</p>
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