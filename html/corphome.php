<?php
$title="Ridezu";
include "header.php";
?>

<style>
.ifrm{
backgroundColor:transparent;
border:none;
allowTransparency:true;
height:1000px;
width:340px;
}
.widget{
position:relative;
top:-570px;
left:650px;
z-index:5000;
}
</style>
	
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
					
						<input class="arvo" type="text" value="Where I live" id="home" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">
						
						<input class="arvo" type="text" value="Where I work" id="work" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">
						
						<a href="#" onclick="start();" id="startbutton">Start</a>

					</div>
				</div>
			</div>
		</section>
		
		<section>
			<div class="corpwrapper">
				<aside id="corpapplinks" class="left">
					<h3>access ridezu on any mobile device</h3>
					
					<a href="#"><img src="images/appstore.png" /></a>
					
					<a href="#"><img src="images/html5c.png" width="75"/></a>
				</aside>
				
				<div id="maincontent" class="right" style="display:none;">
					<div id="testimonial" class="active" >
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
		
					<div id="webapp" class="widget" style="display:none;">			
						<div style="float:left;width:100px;">
						<a href="#" onclick="document.getElementById('ridezuiframe').contentWindow.nav1('riderequestp');">Request a ride</a><br/>
						<a href="#" onclick="document.getElementById('ridezuiframe').contentWindow.nav1('ridepostp');">Post a ride</a><br/>
						<a href="#" onclick="document.getElementById('ridezuiframe').contentWindow.nav1('myridesp');">My Rides</a><br/>
						<a href="#" onclick="document.getElementById('ridezuiframe').contentWindow.nav1('accountp');">My Account</a><br/>
						<a href="#" onclick="document.getElementById('ridezuiframe').contentWindow.nav1('profilep');">My Profile</a><br/>
						</div>
						<div>
						<iframe class="ifrm" id="ridezuiframe" src=""></iframe>					
						</div>
					</div>
		
<?php
include "footer.php";
?>