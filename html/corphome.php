<?php
$title="Ridezu";
$desc="Ridezu is a community for carpooling to and from the office. It's convenient, economical and green.  Join today!";
include "header.php";
?>

	 <section id="homepageintro" class="homepage">
		 <div class="corpwrapper">
			 <div id="corpmain" class="homepage">
				 <div id="slider">
					 <img class="slide" src="images/sanfran.jpg" alt="San Francisco" />
				 </div>
				 
				 <div id="corptitle" class="index80 homepage">
					 <h2>How much money</h2>
					 <h3>can you save?</h3>
					 <h4>convenient &#8226; economical &#8226; green</h4>
				 </div>
				 
				 <div id="corpstartcalc" class="index80">
				 
				 	<div id="referafriend" style="display:none;">
				 	  <div id="welcomer">Welcome! As a special referral from<br>
				 	  		<span id="referror"></span>
				 	  </div>
				 	  <img id="referpic" src=""/>
				 	  <div id="bonus">Sign up today and get $10 in FREE Rides
					
					  <input type="submit" id="startbutton" onclick="loginUser();" value="Try Ridezu!" style="bottom:15px;left:130px;"/>
					  </div>
				 </div>
				 			 					 	
				 	<div id="ridezunomics" style="display:none;">
				 		<div id="wizard1">
						<ul id="calclist" style="list-style-type: none;padding-left:20px;margin-top:10px;"> 
							<li>
								<div class="question" style="padding-bottom:15px;">
									<label style="padding-bottom:4px;">Are you a rider or a driver?</label>
									<input type="radio" name="utype1" id="rider" value="Rider">Rider
									<input type="radio" name="utype1" id="driver" value="Driver" checked>Driver
								</div>				
							</li>
							
							<li>
								<div class="question" style="padding-bottom:15px;">
									<label>How far is your commute?</label>
									<div class="slidercontainer">
										<div id="slider1" class="slider">
											<div class="circle"></div>
											<div class="bar"></div>
										</div>
									</div>
									
									<div class="slidervalue">
										<span id="slidervaluea">25</span>m
									</div>
								</div>
							</li>
							
							<li>
								<div class="question" style="padding-bottom:15px;">
									<label>How much do you pay for gas?</label>
									<div class="slidercontainer">
										<div id="slider2" class="slider">
											<div class="circle"></div>
											<div class="bar"></div>
										</div>
									</div>
							
									<div class="slidervalue">
										$<span id="slidervalueb">3.85</span>
									</div>
								</div>
							</li>
							
							<li>
								<div class="question" style="padding-bottom:15px;">
									<label>What's your car's gas mileage?</label>
									<div class="slidercontainer">
										<div id="slider3" class="slider">
											<div class="circle"></div>
											<div class="bar"></div>
										</div>
									</div>
						
									<div class="slidervalue">
										<span id="slidervaluec">25</span>
									</div>
								</div>
							</li>
						</ul>
		
						<input type="submit" id="startbutton" onclick="calcv();" value="Go" style="margin: -10px 0 0 20px;"/>
						</div>
						
						<div id="wizard2" style="display: none;">
							<p id="calcmessage"></p>
						
							<input type="submit" id="startbutton" onclick="loginUser()" value="Try Ridezu!"/>
							<input type="submit" id="backbutton" onclick="calcback()" value="Back"/>
						</div>
						
						<div id="wizard3" style="display: none;">
							<p>Hello</p>
						</div>
					</div>

				 </div>

				
				 
			 </div>
		 </div>
	 </section>
	 
	 <section id="webapp">
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
					 
					 <iframe id="ridezuiframe" src="" width="340" height="475" frameborder="0"></iframe>
					 
				 </div>
	 </section>
	 
	 <section id="quotes" style="display:none">
		 <div class="corpwrapper">
			 <aside id="corpapplinks" class="left">
				 <h3>access ridezu on any mobile device</h3>
				 
				 <a href="https://itunes.apple.com/app/ridezu/id594682080?mt=8" target="apple" ><img src="images/appstore.png" alt="link to Ridezu's app on the iOS app store" /></a>
				 
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
	

	
	<section id="noquotes" style="display:none;">
	   <div class="corpwrapper">
		<div id="promo">
			<div id="promotext">
				<div id="promotext1">Share the word, share the wealth
				</div>
				<div id="promotext2">Share Ridezu on your your social networks and we'll give each of your friends $10 for joining.  Plus, for each friend that joins we'll give you $10 too.  Sweet!  &nbsp;<a id="rules" onclick="showrules();">See details ></a>  
				</div>
			</div>
			<ul id="referbuttons">
				<li><a id="facebookbutton" onclick="fbpopup();">share</a></li>
				<li><a id="twitterbutton" onclick="twitterpopup();">share</a></li>
				<li><a id="emailbutton" onclick="emailpopup();">share</a></li>
			</ul>
		</div>
	   </div>
	</section>
	
	<script>
	function showrules(){
		message="<h2>Refer-a-Friend</h2>";
		message+="<p>For Ridezu to be useful, we need lots and lots of people to join, and we need your help. ";
		message+="<p>To help kickstart Ridezu, we're offering $10 in free rides for new members and $10 to members who refer those members.";
		message+="<p>For example.  Tom joins Ridezu, he gets $10.  Tom refers Sally.  Sally gets $10, plus Tom gets *another* $10 for referring Sally. Pretty cool deal.";
		message+="<p>So what is $10 good for?";
		message+="<p>Let's say you commute from San Jose to Palo Alto.  This costs about $3.50.  By earning Ridezu promotional dollars you'll find yourself getting to and from work - completely FREE!";
		message+="<p>What if I am a driver and someone pays using promotional dollars?  Even if someone pays with promotional dollars, because you're driving and offering a service you get real dollars.";
		message+="<p>What if I am a driver and I have promotional dollars from my sign-up and referrals? While you can't cash out promotional dollars, you can use these promotional dollars the next time you have to take a ride.  We find people are both riders and drivers.";
		message+="<p>Can I cash out my free rides?  Nope. Sorry.";
		message+="<p>Is there a limit to how many people I can refer?  No.  We need lots and lots of people to join.";
		message+="<p>PS. Don't try to game the system, that's just not cool.  Also see our Terms and Conditions.";
		openconfirm();
		}
	function emailpopup(){
		message="<h2>Share via email</h2>";
		message+="<p>Simply copy and paste the link below and send to your friends.  It's as easy as that!";
		message+="<div id='emaillink'>https://www.ridezu.com?r="+myinfo.fbid+"</div>";
		openconfirm();
		}
	</script>
<?php
include "footer.php";
?>