<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ridezu</title>
	  	<link rel="stylesheet" href="themes/ridezu.min.css" />
  		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile.structure-1.1.1.min.css" /> 
  		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script> 
  		<script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script> 
	
  		<script>
  		
  		var p="mainp"; // declares main page
  		
  		var pageTitles = { 
  			"mainp":"Ridezu" ,
			"calcp":"Ridezunomics",
			"accountp":"My Account",
			"transactionp":"Transaction History",	 
  			"ridesp":"My Rides" ,
  			"profilep":"My Profile" ,
  			"howitworksp":"How it Works",
  			"termsp":"Terms of Service",
  			"faqp":"FAQ's",
  			"rider1p":"Step 1",
  			"rider2p":"Step 2",
  			"rider3p":"Step 3",
  			"ride1p":"Step 1",
  			"ride2p":"Step 2",
  			"ride3p":"Step 3",			
			};
											
		function addCommas(str){
 		   var arr,int,dec;
		   str += '';

		   arr = str.split('.');
		   int = arr[0] + '';
		   dec = arr.length>1?'.'+arr[1]:'';

 		   return int.replace(/(\d)(?=(\d{3})+$)/g,"$1,") + dec;
		}
		 	
		function calcv(){

		miles=document.getElementById('slider1').value;
		utype=document.getElementById('flip-min').value;
		gas=document.getElementById('slider2').value;
		mpg=document.getElementById('slider3').value;
				
		if(utype=='driver'){
			tmiles=miles*240*2;
			ftmiles=addCommas(Math.round(tmiles));
			cost=tmiles/mpg*gas;
			fcost=addCommas(Math.round(cost));
			pickup=.25;
			revpermile=.10;
			totrev=240*2*(pickup+(revpermile*miles));
			ftotrev=addCommas(Math.round(totrev));
			totcarbon=tmiles/mpg*20;
			ftotcarbon=addCommas(Math.round(totcarbon));
			copy="<div style='padding:10px;'>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<p>Ridezu can help.<p>By using ridezu you'll collect an estimated <b>$"+ftotrev+"</b> to help offset your gas costs.<p>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</div>";
			}
		
		if(utype=='rider'){

			tmiles=miles*240*2;
			ftmiles=addCommas(tmiles);
			cost=Math.round(tmiles/mpg*gas);
			fcost=addCommas(Math.round(cost));
			pickup=.25;
			ridezufee=.25;
			revpermile=.10;
			totrev=240*2*(ridezufee+pickup+(revpermile*miles));
			ftotrev=addCommas(Math.round(totrev));
			savings=Math.round(cost-totrev);
			fsavings=addCommas(Math.round(savings));
			totcarbon=tmiles/mpg*20;
			ftotcarbon=addCommas(Math.round(totcarbon));


			if(savings>0){
			copy="<div style='padding:10px;'>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<p>Ridezu can help.<p>By using ridezu you'll still pay <b>$"+ftotrev+"</b> to get to work, but you'll save <b>$"+fsavings+ "</b> in gas, save the miles from your car, and you'll be so green.<p>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</div>";
			}

			if(savings<=0){
			copy="<div style='padding:10px;'>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<p>By using ridezu you'll pay <b>$"+ftotrev+"</b> to get to work.  This might be a little more than gas, but you'll save the miles from your car, and you'll be so green.<p>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</div>";
			}
	
			}
			document.getElementById('result').innerHTML=copy;
			document.getElementById('result').style.display="block";

		}
		
		function nav(from,to){		
			document.getElementById('pTitle').innerHTML=pageTitles[to];
			document.getElementById("footer").style.display="none";
			document.getElementById(p).style.display="none";		
			scrollTo(0,0);
			document.getElementById(to).style.display="block";
			p=to;
			
			if(to=="termsp"){
				loadterms();
				}

			if(to=="mapp"){
				loadMap();
				}

          	if(to=="mainp"){
				document.getElementById("footer").style.display="block";
				}
				
			if(to=="transactionp"){
				$("tr:odd").css("background-color", "#ffffff");
				}
		}
		
		function rempopup(){
		document.getElementById("result").style.display="none";
		}
		
		function loadterms(){
			$.ajax({
  			url: "terms.html",
  			cache: true
			}).done(function( html ) {
  				document.getElementById('termsp').innerHTML=html;
				});
		}
		
		</script>
		
		<style>
		 .popup{
		 position: absolute; 
		 top:25%; 
		 left:10%; 
		 width:80%; 
		 z-index: 100; 
		 background-color: #FAFA93;
		 border:1px solid #FA820A;
		 -moz-border-radius: 15px;
		 border-radius: 15px;
		 }
		 .footerlink{
		 padding:10px;
		 font-size:12px;
		 color:white;
		 text-decoration:none;
		 display:inline;
		 }
		 .footerbar{
		 padding:10px;
		 font-size:12px;
		 color:white;
		 width:100%;
		 text-align:center;
		 }
		 table {
   		 background:#cccccc;
   		 width:100%;
		 border-spacing:0;
  		 border-collapse:collapse;
  		 }
  		 td {
  		 padding:5px;
  		 }
  		 .pageTitle{
  		 font-weight:bold;
  		 color:#fffff;
  		 width:100%;
  		 padding:10px;
  		 text-align:center;
  		 }
		 </style>	

	</head>
<body>
 
 <!-- Start of app + header -->

 		<div data-role="page" id="home1" data-theme="a">
		
			<div data-role="header" data-position="inline" style="display:block;">
				<a href="#" onclick="nav('','mainp');" data-icon="home" data-iconpos="notext">Home</a>
				<div class="pageTitle" id="pTitle">Ridezu</div>
			</div>
			<div data-role="content" data-theme="a" style="padding:0px;margin:0px;">
 <!-- Start of main page: #mainp -->

			<div id="mainp" style="display:block;padding:10px;">
			
			<ul data-role="listview">
			<li>
				<a href="" onclick="nav('mainp','ridesp');">
					<h3>My Rides</h3>
					<p>Let's get carpooling</p>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('mainp','profilep');">
					<h3>My Profile</h3>
					<p>Set your schedule, tell us about you</p>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('mainp','accountp');">
					<h3>My Account</h3>
					<p>View your monthly activity and balance</p>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('mainp','howitworksp');">
					<h3>How it Works</h3>
					<p>See how easy it is + FAQ</p>
				</a>
			</li>
			<li>
				<a href="#" onclick="nav('mainp','calcp');">
					<h3>Ridezunomics</h3>
					<p>Why Ridezu makes so much sense</p>
				</a>
			</li>
			
			</ul>	
		  	<br><b>caution:</b> work in progress.<br>watch out for pixels on side of road.
		
			</div>
<!-- end of main page: #mainp -->

			
<!-- Start of calcp div  -->
			<div id="calcp" style="display:none;padding:10px;"">
						
			<ul data-role="listview">
			<li>
				<style>
					.containing-element .ui-slider-switch { width: 9em } 
				</style>
				<div class="containing-element">
					<label for="flip-min">Are you a rider or a driver?</label>
					<select name="flip-min" id="flip-min" data-role="slider">
					<option value="driver">Driver</option>
					<option value="rider">Rider</option>
					</select>
				</div>
			</li>	
			<li>
				<label for="slider1">How many miles do you drive to work?</label>
				<input type="range" name="slider1" id="slider1" value="25" min="2" max="100" data-theme="a" />
			</li>	
			<li>	
				<label for="slider2">How much do you pay for gas?</label>
				<input type="range" name="slider2" id="slider2" step=".01" value="3.85" min="3" max="6" data-theme="a" />
			</li>	
			<li>	
				<label for="slider3">What's your car's gas mileage?</label>
				<input type="range" name="slider3" id="slider3" step="1" value="25" min="10" max="60" data-theme="a" />
			</li>	
			</ul>	
 			
			<br><br><div id="calcv1" onclick="calcv();" data-role="button" data-icon="grid">Calculate</div>
	
			<div id="result" style="display:none;" onclick="rempopup();" class="popup"></div>
		
			</div>
<!-- end of calcp div  -->
			
			
<!-- Start of mapp div  -->
		<div id="mapp" style="display:none;">

        <fieldset style="text-align:center;padding:0px;margin:0px;">
				<div id="map_canvas" style="width:100%; height:500px;"></div>
            </fieldset>

						<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA4touwfWlpbCpS0SKYvqfUOVddPnd0OBA&sensor=true"></script>
 
  <script>
        var map;
        var geocoder;
        var infowindow = new google.maps.InfoWindow();
        var myhouse = new google.maps.LatLng(37.238167, -121.921297);
  
        function HomeControl(controlDiv, map) {
  
          // Set CSS styles for the DIV containing the control
          // Setting padding to 5 px will offset the control
          // from the edge of the map
          controlDiv.style.padding = '5px';
  
          // Set CSS for the control border
          var controlUI = document.createElement('div');
          controlUI.style.backgroundColor = 'white';
          controlUI.style.borderStyle = 'solid';
          controlUI.style.borderWidth = '2px';
          controlUI.style.cursor = 'pointer';
          controlUI.style.textAlign = 'center';
          controlUI.title = 'Click to set the map to Home';
          controlDiv.appendChild(controlUI);
  
          // Set CSS for the control interior
          var controlText = document.createElement('div');
          controlText.style.fontFamily = 'Arial,sans-serif';
          controlText.style.fontSize = '12px';
          controlText.style.paddingLeft = '4px';
          controlText.style.paddingRight = '4px';
          controlText.innerHTML = '<b>Home</b>';
          controlUI.appendChild(controlText);
  
          // Setup the click event listeners: simply set the map to
          // myhouse
          google.maps.event.addDomListener(controlUI, 'click', function() {
            map.setCenter(myhouse)
          });
  
        }
  
  	  function Target(targetDiv,map){
  		var controlText = document.createElement('div');
          controlText.innerHTML = '<b>Home</b>';
          controlUI.appendChild(controlText);
  	  }
  
  
  	function loadMap(){
  
            
          geocoder = new google.maps.Geocoder();
          var mapOptions = {
            center: myhouse,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
    		  zoomControl: false,
    		  mapTypeControl: false,
  		  scaleControl: false,
  		  streetViewControl: false,
  		  overviewMapControl: false
          };
  
          var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
  
          // Create the DIV to hold the control and
          // call the HomeControl() constructor passing
          // in this DIV.
          var homeControlDiv = document.createElement('div');
          var targetDiv = document.createElement('div');
          
                  targetDiv.innerHTML = '<img style="margin-top:-30px;" src="images/circle.png"/>';
  				targetDiv.style.postion = 'absolute';
  				targetDiv.style.left = '50%';
  				targetDiv.style.top = '50%';
  				targetDiv.style.height = '50px';
  
          google.maps.event.addDomListener(targetDiv, 'click', function() {
            a=map.getCenter();
            codeLatLng();
            marker = new google.maps.Marker({
                    position: a,
                    map: map,
                    icon:image
                    });
            });
     
          
          var homeControl = new HomeControl(homeControlDiv, map);
  
          homeControlDiv.index = 1;
          targetDiv.index = 1;
          
          map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);
          map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(targetDiv);
       
      	var image = 'images/marker.png';
      	
      	// this function turns late long into a real address
  
  	  	function codeLatLng() {
              var ctr = map.getCenter();
  			var lat = ctr.lat();
  			var lng = ctr.lng();
      		var latlng = new google.maps.LatLng(lat, lng);
      		geocoder.geocode({'latLng': latlng}, function(results, status) {
        		if (status == google.maps.GeocoderStatus.OK) {
          		if (results[1]) {
      	      	infowindow.setContent(results[0].formatted_address);
          	  	infowindow.open(map, marker);
          		}
        		} else {
          		alert("Geocoder failed due to: " + status);
        		}
      		});
    		}
              
  	}
  
      // This function calls jquery to load the map page
		//	alert("h");
  	//$('#map_result').live('pageshow',function(event){
  	//loadMap();
  	//});	
  
  </script>
</div>

<!-- end of map div  -->

<!-- Start of terms div  -->
<div id="termsp" style="display:none;padding:10px;">
</div>

<!-- end of terms div  -->

<!-- Start of howitworksp div  -->

		<div id="howitworksp" style="display:none;padding:10px;">
			<center>
				 <img src="images/whatareyou.png">
				 <div id="hiwdrive" style="position:absolute;top:50px;left:160px;width:120px;height:70px;z-index:100;" onclick="nav('howitworksp','drive1p');"></div> 
				 <div id="hiwride" style="position:absolute;top:50px;left:30px;width:120px;height:70px;z-index:100;" onclick="nav('howitworksp','ride1p');"></div> 
				 <div id="hiwfaq" style="position:absolute;top:320px;left:90px;width:120px;height:70px;z-index:100;"onclick="nav('howitworksp','faqp');"></div> 
			</center>				
		</div>
			
<!-- end of howitworksp div  -->

<!-- Start of drive1p div  -->
		<div id="drive1p" style="display:none;padding:10px;">
			<center>
				 <div id="drive1" onclick="nav('drive1p','drive2p');">
				 <img src="images/drive1.png">
				 </div> 
			</center>				
		</div>

<!-- end of drive1p div  -->

<!-- Start of drive2p div  -->
		<div id="drive2p" style="display:none;padding:10px;">
			<center>
				 <div id="drive2" onclick="nav('drive2p','drive3p');">
				 <img src="images/drive2.png">
				 </div> 
			</center>				
		</div>

<!-- end of drive2p div  -->

<!-- Start of drive3p div  -->
		<div id="drive3p" style="display:none;padding:10px;">
			<center>
				 <div id="drive3" onclick="nav('drive3p','howitworksp');">
				 <img src="images/drive3.png">
				 </div> 
			</center>				
		</div>

<!-- end of drive3p div  -->

<!-- Start of ride1p div  -->
		<div id="ride1p" style="display:none;padding:10px;">
			<center>
				 <div id="ride1" onclick="nav('ride1p','ride2p');">
				 <img src="images/ride1.png">
				 </div> 
			</center>				
		</div>

<!-- end of ride1p div  -->

<!-- Start of drive2p div  -->
		<div id="ride2p" style="display:none;padding:10px;">
			<center>
				 <div id="ride2" onclick="nav('ride2p','ride3p');">
				 <img src="images/ride2.png">
				 </div> 
			</center>				
		</div>

<!-- end of ride2p div  -->

<!-- Start of ride3p div  -->
		<div id="ride3p" style="display:none;padding:10px;">
			<center>
				 <div id="ride3" onclick="nav('ride3p','howitworksp');">
				 <img src="images/ride3.png">
				 </div> 
			</center>				
		</div>

<!-- end of drive3p div  -->

<!-- Start of faqp div  -->
		<div id="faqp" style="display:none;padding:10px;" onclick="nav('faqp','howitworksp');">

<style>

#slide1_container {
	width:1800px;
	height:281px;
	overflow:hidden;
	position:relative;
}
#slide1_images {
	position:absolute;
	left:0px;
	width:1800px;
	-webkit-transition:all 1.0s ease-in-out;
	-moz-transition:all 1.0s ease-in-out;
	-o-transition:all 1.0s ease-in-out;
	transition:all 1.0s ease-in-out;
}
#slide1_images img {
	padding:0;
	margin:0;
	float:left;
}

#t {
	padding:0;
	margin:0;
	float:left;
}
</style>

<div id="slide1_container">
	<div id="slide1_images">
		<div id="slide1-1" class="t"><img src="http://css3.bradshawenterprises.com/images/Cirques.jpg" /></div>
		<div id="slide1-2" class="t"><img src="http://css3.bradshawenterprises.com/images/Clown%20Fish.jpg" /></div>
		<div id="slide1-3" class="t"><img src="http://css3.bradshawenterprises.com/images/Stones.jpg" /></div>
		<div id="slide1-4" class="t"><img src="http://css3.bradshawenterprises.com/images/Summit.jpg" /></div>
	</div>
</div>

<script>
$(document).ready(function() {
	$("#slide1-1").swipeleft(function() {
		$("#slide1_images").css("left","-450px");
	});
	$("#slide1-2").swipeleft(function() {
		$("#slide1_images").css("left","-900px");
	});
	$("#slide1-2").swiperight(function() {
		$("#slide1_images").css("right","450px");
	});
	$("#slide1-3").swipeleft(function() {
		$("#slide1_images").css("left","-1350px");
	});
	$("#slide1-3").swiperight(function() {
		$("#slide1_images").css("right","-900px");
	});
	$("#slide1-4").swipeleft(function() {
		$("#slide1_images").css("left","0px");
	});
});
</script>

		</div>

<!-- end of faqp div  -->

 <!-- Start of profile page: #profilep -->

			<div id="profilep" style="display:none;padding:10px;">
			
			<ul data-role="listview">
			<li>
				<a href="" onclick="nav('profilep','');">
					<h3>Home</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('profilep','');">
					<h3>Work</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('profilep','');">
					<h3>About Me</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('profilep','');">
					<h3>Contact Info</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('profilep','');">
					<h3>Driver Verification</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('profilep','');">
					<h3>Ride Details</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('profilep','');">
					<h3>Payment Info</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('profilep','');">
					<h3>Payout Info</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('profilep','');">
					<h3>Notification Preferences</h3>
				</a>
			</li>			
			</ul>	
		
			</div>
			
<!-- end of profile page: #profilep  -->

 <!-- Start of profile page: #ridesp -->

			<div id="ridesp" style="display:none;padding:10px;">
			
			<ul data-role="listview">
			<li>
				<a href="" onclick="nav('ridesp','');">
					<h3>My Rides</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('ridesp','');">
					<h3>Post a Ride</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('ridesp','');">
					<h3>Request a Ride</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('ridesp','');">
					<h3>Schedule</h3>
				</a>
			</li>
			<li>
				<a href="" onclick="nav('ridesp','');">
					<h3>Auto Pilot</h3>
				</a>
			</li>
			</ul>	
		
			</div>
			
<!-- end of profile page: #ridesp  -->


 <!-- Start of account page: #accountp -->

			<div id="accountp" style="display:none;padding:10px;">

			<div id="mybalance" style="font-size:36px;text-align:right;color:#006900;">$64.39</div>
			
			<div data-role="navbar">
				<ul>
					<li><a href="">Week</a></li>
					<li><a href="" class="ui-btn-active ui-state-persist">Month</a></li>
					<li><a href="">Year</a></li>
				</ul>
			</div>

			<div style="font-size:14px;color:#bbbbbb;text-align:center;">day 27 of 31</div>

			<div class="ui-grid-a">
				<div class="ui-block-a">
					Credits
					<br>Charges
					<br><b>Total</b>
					<br>
					<br>Trips
					<br>Miles Carpooled
					<br>CO2 Saved
					<br>Gas Savings
					<br>Days Carpooled
					<br>Passengers
				</div>
				<div class="ui-block-b" style="text-align:right;">
					$67.39
					<br>$3.00
					<br><b>$64.39</b>
					<br>
					<br>8
					<br>174
					<br>437
					<br>$64.39
					<br>40%
					<br>1.2
				</div>
			</div>
			<br>
			<div onclick="nav('accountp','transactionp');" data-role="button" data-icon="grid">Transaction History</div>

			</div>
 <!-- end of account page: #accountp -->

 <!-- Start of transactionp page: #transactionp -->

			<div id="transactionp" style="display:none;padding:10px;">

			<div id="mybalance" style="font-size:36px;text-align:right;color:#006900;">$64.39</div>
			
			<table>
    			<tr><td>9/5</td><td>San Jose > Foster City</td><td style="text-align:right;">$4.23</td></tr>
    			<tr><td>9/5</td><td>Foster City > San Jose</td><td style="text-align:right;">$4.23</td></tr>
    			<tr><td>9/4</td><td>San Jose > Foster City</td><td style="text-align:right;">$4.23</td></tr>
    			<tr><td>9/4</td><td>Foster City > San Jose</td><td style="text-align:right;">$4.23</td></tr>
    			<tr><td>9/3</td><td>San Jose > Foster City</td><td style="text-align:right;">$4.23</td></tr>
    			<tr><td>9/3</td><td>Foster City > San Jose</td><td style="text-align:right;">$4.23</td></tr>
    			<tr><td>9/3</td><td>Late Fee - Oops!</td><td style="text-align:right;">-$3.23</td></tr>
   			</table>

			<div onclick="nav('accountp','transactionp');" data-role="button" data-icon="grid">Show More Transactions</div>

			</div>
 <!-- end of transaction page: #transactionp -->
			
</div>

	<div id="footer" data-role="footer">
		<div class="footerbar"> 
		<div class="footerlink" href="" onclick="nav('mainp','termsp');">Terms</div> | 
		<div class="footerlink" href="" onclick="nav('mainp','termsp');">Privacy</div>
		&copy; 2012
		</div>
	</div>
			 			 						
</div>


</body>
</html>