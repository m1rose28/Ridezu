  		// these are all custom functions used by ridezu.  these are here temporarily and should all be moved to ridezu.js (they should also be minified)
  		
  		//declare initial variables
  		var p="mainp"; 
  		var map;  
	    var geocoder;
	    var myspot;

  		  		
  		//page titles are the pageid's coupled with what shows up in the header
  		
  		var pageTitles = { 
  			"riderequestp":"Request a Ride" ,
  			"selectdriverp":"Request a Ride" ,
   			"noroutep":"Stay tuned!" ,
   			"rideconfirmp":"Ride confirmed!",
  			"startp":"Welcome to Ridezu" ,
  			"enrollp":"Where do you live?" ,
  			"fbp":"Login with Facebook" ,
			"congratp":"Congratulations!",
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
  			"whereworkp":"Where do you work?",			
  			"wherelivep":"Where do you live?"			
			};
		
		//this function adds commas to long numbers (used in ridezunomics)
											
		function addCommas(str){
 		   var arr,int,dec;
		   str += '';

		   arr = str.split('.');
		   int = arr[0] + '';
		   dec = arr.length>1?'.'+arr[1]:'';

 		   return int.replace(/(\d)(?=(\d{3})+$)/g,"$1,") + dec;
		}
		 	
		//this is the calculator function for ridezunomics

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
			copy="This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<p>Ridezu can help.<p>By using ridezu you'll collect an estimated <b>$"+ftotrev+"</b> to help offset your gas costs.<p>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!";
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
			copy="This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<p>Ridezu can help.<p>By using ridezu you'll still pay <b>$"+ftotrev+"</b> to get to work, but you'll save <b>$"+fsavings+ "</b> in gas, save the miles from your car, and you'll be so green.<p>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!";
			}

			if(savings<=0){
			copy="This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<p>By using ridezu you'll pay <b>$"+ftotrev+"</b> to get to work.  This might be a little more than gas, but you'll save the miles from your car, and you'll be so green.<p>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!";
			}
			}
			showpopup(copy);
		}
		
		//this is the navigation system. which shows (to) and hides (from) pages as well as invokes specific
		//javascript for individual pages to load 
					
		function nav(from, to){
			$.ajax({
  			url: "pages/"+ to + ".html",
  			cache: true
			}).done(function( html ) {
  				document.getElementById(to).innerHTML=html;
  				nav2(from,to);
				});
		}
			
		function nav2(from,to){
			document.getElementById('pTitle').innerHTML=pageTitles[to];
			document.getElementById(p).style.display="none";		
			scrollTo(0,0);
			document.getElementById(to).style.display="block";
			p=to;

			if(to=="enrollp"){
			  	copy="First, type in or select your home address.<br><br>This address never be shared.";
			  	showpopup(copy);
			  	getLocation();
				}

			if(from=="nav"){
				closeme();
				}
				
			if(to=="transactionp"){
				$("tr:odd").css("background-color", "#ffffff");
				}

			if(to=="fbp"){
				facebook();
				}
		}

		//this removes the popup when you click on it.   

		function showpopup(content){
			document.getElementById("darkpage").style.display="block";
			document.getElementById('rpopup').innerHTML=content;
			document.getElementById('rpopup').style.display="block";
			}

		function rempopup(){
			document.getElementById("darkpage").style.display="none";
			document.getElementById("rpopup").style.display="none";
			}
		
		//this is a function to load html via ajax (need to generalize for all pages loaded via ajax)
		
		function loadpage(page){
			$.ajax({
  			url: "pages/"+ page + ".html",
  			cache: true
			}).done(function( html ) {
  				document.getElementById(page).innerHTML=html;
				});
		}
		
		//this is the main map function (method is type of function, e.g. enroll, myspot is lat/long, and zoom level is obvious :-)

  		function loadMap(method,myspot,zoomlevel){
  	        
        	geocoder = new google.maps.Geocoder();
        
        	var mapOptions = {
            	center: myspot,
            	zoom: zoomlevel,
            	mapTypeId: google.maps.MapTypeId.ROADMAP,
            	panControl: false,
    	    	zoomControl: false,
    			mapTypeControl: false,
  		  		scaleControl: false,
  		  		streetViewControl: false,
  		  		overviewMapControl: false
          		};
  
	        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
  
	        var targetDiv = document.createElement('div');
          
     	    targetDiv.innerHTML = '<img style="margin-top:-30px;" src="images/circle.png"/>';
  			targetDiv.style.postion = 'absolute';
  			targetDiv.style.left = '50%';
  			targetDiv.style.top = '50%';
  			targetDiv.style.height = '50px';
	        targetDiv.index = 1;
	        map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(targetDiv);

	        google.maps.event.addListener(map, 'center_changed', function() {
    			window.setTimeout(function() { 
        		a=map.getCenter();
            	codeLatLng();
           		marker1.setPosition(a);
           		}, 500);
  			});
                                               
	      	var image = 'images/marker.png';   
      	
	      	var marker1 = new google.maps.Marker({
    			position: myspot,
    			icon:image,
				});

			// adds the initial marker to the page
			marker1.setMap(map);
			codeLatLng();
      	
      	// this function turns lat/long into a real address  
  	  	function codeLatLng() {
		    var ctr = map.getCenter();
  			var lat = ctr.lat();
  			var lng = ctr.lng();
      		var latlng = new google.maps.LatLng(lat, lng);
      		geocoder.geocode({'latLng': latlng}, function(results, status) {
        		if (status == google.maps.GeocoderStatus.OK) {
          			if (results[1]) {
      	      			locationselect(results[0].formatted_address,lat,lng);
          				}
        			} else {
          			alert("Geocoder failed due to: " + status);
        			}
      			});
    		}             
  		}
  
		//this function set(2) gets your actual location (used only at enroll, the balance of the time we'll have your address)	
		function getLocation(){
  			if (navigator.geolocation){
    			navigator.geolocation.getCurrentPosition(showPosition);
    			}
  				else{alert("Yikes - geolocation is not supported by this browser. Go fish.");}
  				}

		function showPosition(position){
			var myspot = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			loadMap("enroll",myspot,18);
  			}
  		
		// this is a map function which places the value of the user location in the text field of location
		function locationselect(location,lat,lng){
  			document.getElementById('location').value=location;
  			document.getElementById('lat').value=lat;
  			document.getElementById('lng').value=lng;
		}

		// this function parses/stores the home address and then moves to the work address
		function enrollhome(){
			eloc=document.getElementById('location').value;
			var str1 = eloc.split(',');
			var str2 = str1[2].split(" ");
			localStorage.hadd1=str1[0];
			localStorage.hstate=str2[1];
			localStorage.hcity=str1[1];
			localStorage.hzip=str2[2];
			localStorage.hcountry=str1[3];
			localStorage.hlat=document.getElementById('lat').value;
			localStorage.hlng=document.getElementById('lng').value;
			document.getElementById("mapselecthome").style.display="none";
			document.getElementById("mapselectwork").style.display="block";
			document.getElementById('pTitle').innerHTML="Where do you work?";
		  	copy="Well done!<br><br>Next, please tell us where you work.";
		  	showpopup(copy);
			}

		// this function parses/stores the home address and then moves to the work address
		function enrollwork(){
			eloc=document.getElementById('location').value;
			var str1 = eloc.split(',');
			var str2 = str1[2].split(" ");
			localStorage.wadd1=str1[0];
			localStorage.wstate=str2[1];
			localStorage.wcity=str1[1];
			localStorage.wzip=str2[2];
			localStorage.wcountry=str1[3];
			localStorage.wlat=document.getElementById('lat').value;
			localStorage.wlng=document.getElementById('lng').value;
			//need to store here
			nav('enroll','fbp');
			}

		// below are the facebook functions.  they are optimized purely for the enrollment flow to get data from the user.
		// they are loaded from calling facebook();
		function facebook(){
		  document.getElementById('login').style.display="block";
		  document.getElementById('logout').style.display="block";
		  window.fbAsyncInit = function() {
			FB.init({
			  appId      : '443508415694320', // App ID
			  channelUrl : 'ec2-50-18-0-33.us-west-1.compute.amazonaws.com/channel.html', // Channel File
			  status     : true, // check login status
			  cookie     : true, // enable cookies to allow the server to access the session
			  xfbml      : true  // parse XFBML
			});
		
			FB.Event.subscribe('auth.statusChange', handleStatusChange);
		  };
		
		  // Load the SDK Asynchronously
		  (function(d){
			 var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			 if (d.getElementById(id)) {return;}
			 js = d.createElement('script'); js.id = id; js.async = true;
			 js.src = "//connect.facebook.net/en_US/all.js";
			 ref.parentNode.insertBefore(js, ref);
		   }(document));
		
		  function handleStatusChange(response) {
			  document.body.className = response.authResponse ? 'connected' : 'not_connected';
			  if (response.authResponse) {
				console.log(response);
		
				updateUserInfo(response);
			  }
			}
		  function updateUserInfo(response) {
			 FB.api('/me', function(response) {
			   document.getElementById('user-info').innerHTML = '<br/<br/>ps.  I got all your data. <br/<br/><img src="https://graph.facebook.com/' + response.id + '/picture">' + response.name;
			   localStorage.first_name=response.first_name;
			   localStorage.last_name=response.last_name;
			   localStorage.image="https://graph.facebook.com/" + response.id + "/picture";
			   localStorage.fbid=response.id;
			   localStorage.email=response.email;
			   document.getElementById('fname').innerHTML=response.first_name
			   // now register the new user
			   regnewuser();
			   //and go to the congratulations page
			   nav("fbp","congratp");
			 });
		   }
		}
		
		function loginUser() {    
			 FB.login(function(response) { }, {scope:'email'});     
			 }
		
		function logoutUser() {    
			 FB.logout();
			 alert("Logged-out");
			 document.getElementById('user-info').innerHTML="";
			 }

// this function set 2 creates a new user
							
		function regnewuser(){
			var dataset = {
				"fbid":	localStorage.fbid,
				"fname": localStorage.first_name,
				"lname": localStorage.last_name,
				"add1": localStorage.hadd1,
				"city": localStorage.hcity,
				"state": localStorage.hstate,	
				"zip": localStorage.hzip,
				"workadd1": localStorage.wadd1,
				"workcity": localStorage.wcity,
				"workstate": localStorage.wstate,	
				"workzip": localStorage.wzip,
				"email": localStorage.email,
				"homelatlong": localStorage.hlat+","+localStorage.hlng,
				"worklatlong": localStorage.wlat+","+localStorage.wlng,
				}
				
			var jsondataset = JSON.stringify(dataset);
		
		    var request=$.ajax({
                url: "http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/ridezu/api/users",
                type: "POST",
                dataType: "json",
                data: jsondataset,
                success: function() {},
                error: function() { alert('already registered?'); },
                beforeSend: setHeader
            	}); 
            	
            request.done(function(msg) {
  				localStorage.seckey=msg.seckey;
				});                	     	
       		}

        function setHeader(xhr) {
            xhr.setRequestHeader("X-Signature", "f8435e6f1d1d15f617c6412620362c21");
            xhr.setRequestHeader("Content-Type", "application/json");
  	      }
        
