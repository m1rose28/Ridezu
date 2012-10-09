// these are all custom functions used by ridezu.  these are here temporarily and should all be moved to ridezu.js (they should also be minified)
  		
//declare initial variables

  		var map;  
	    var geocoder;
	    var myspot;
	    var requestride="";
	    var userdata="";
  		  		
//page titles are the pageid's coupled with what shows up in the header
  		
  		var pageTitles = { 
  			"riderequestp":"Request a Ride" ,
  			"ridepostp":"Post a Ride" ,
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
  			"wherelivep":"Where do you live?",			
  			"loginp":"Login - Test Page"			
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

// function to link from navigation side window (close window) and move on

		function nav1(to){
			closeme();
			if(p!=to){
				nav(p,to);
				}
			}
					
		function nav(from, to){
			$.ajax({
  			url: "pages/"+ to + ".html",
  			cache: false,
  			dataType: "html"
			}).done(function( html ) {
  				document.getElementById(to).innerHTML=html;
				xx=document.getElementById(to);
				$(xx).trigger('create');
  				nav2(from,to);  				
				});
		}
			
		function nav2(from,to){
			headerbar=pageTitles[to]+" ("+localStorage.first_name+" "+localStorage.last_name+")";
			document.getElementById('pTitle').innerHTML=headerbar;
			document.getElementById(p).style.display="none";		
			document.getElementById(p).innerHTML="";		
			scrollTo(0,0);
			document.getElementById(to).style.display="block";
			p=to;

			if(to=="enrollp"){
			  	copy="First, type in or select your home address.<br><br>This address never be shared.";
			  	showpopup(copy);
			  	getLocation();
				}

			if(to=="riderequestp"){
				getlist("driver");
				$('#route').bind('swipeleft', function(){
 					localStorage.date=rlist.date;
 					alert("next day...");
 					role=localStorate.role;
 					getlist(role,rlist.route,rlist.nextdate);					
         			});
				$('#route').bind('swiperight', function(){
 					alert("prior day...");
 					pdate=localStorage.date;
 					role=localStorage.role;
 					getlist(role,rlist.route,pdate);
         			});
				}

			if(to=="ridepostp"){
				getlist("rider");
				$('#route').bind('swipeleft', function(){
 					localStorage.date=rlist.date;
 					alert("next day...");
 					role=localStorage.role;
 					getlist(role,rlist.route,rlist.nextdate);					
         			});
				$('#route').bind('swiperight', function(){
 					alert("prior day...");
 					pdate=localStorage.date;
 					role=localStorage.role;
 					getlist(role,rlist.route,pdate);
         			});
				}

			if(to=="loginp"){
				getuserlist();
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

// this function set (2) creates a new user as part of the enroll flow

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
   
//random function to test if javascript is still working or if there is some other bug

		function a(){
		alert("test it worked");
		}       
		
// reverses the route from home to work or work to home
		function reverseroute(){
			if(rlist.route=="h2w"){route="w2h";}
			if(rlist.route=="w2h"){route="h2w";}
			role=localStorage.role;
			document.getElementById("r2").style.display="none";
			document.getElementById("r3").style.display="none";
			document.getElementById("r1").style.display="block";
			getlist(role,route,rlist.date);
		}
 	
// gets a list of riders/drivers
		
		function getlist(role,route,date){
		  	  localStorage.role=role;
		  	  fbid=localStorage.fbid;
		  	  rlist="";		  
			  if(route!=undefined){
				url="http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/ridezu/api/v/1/rides/search/fbid/"+fbid+"/searchroute/"+route+"/searchdate/"+date+"/"+role;
			  }
				
			  if(route==undefined){
				url="http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/ridezu/api/v/1/rides/search/fbid/"+fbid+"/"+role;
			  }
			
			  $.ajax({
			  url: url,
			  cache: false,
			  dataType: "json"
			  }).done(function(data) {
				rlist=data;
				paintlist();						
				  });
		}
		
// this paints the list of available times & drivers/riders

		function paintlist(preftime){		
		  role=localStorage.role;
		  if(preftime=="1"){document.getElementById('showall').style.display="none";}
		  if(rlist.day!="Today"){
		  		x=" on "+rlist.daydate;
		  		}
		  		else{
		  		x=" today";
		  		}
		  document.getElementById('leavetime').innerHTML=x;
		  route=rlist.route;
		  z=0;

		  if(rlist.route=="h2w"){
		  		document.getElementById('origindesc').innerHTML="Home";
				document.getElementById('destdesc').innerHTML="Work";
				document.getElementById('gotext').innerHTML="go to work";
		  		} 
		  		
		  		else {
		  		document.getElementById('origindesc').innerHTML="Work";
				document.getElementById('destdesc').innerHTML="Home";
				document.getElementById('gotext').innerHTML="go home";
		  		}
  
		  xstartlatlong="http://maps.googleapis.com/maps/api/staticmap?center="+rlist.startlatlong+"&zoom=13&size=100x100&maptype=roadmap&markers=color:green%7C%7C"+rlist.startlatlong+"&sensor=false";
		  document.getElementById('ridedesta').src=xstartlatlong;		  		  
		  document.getElementById('ridedestb').src=xstartlatlong;		  
		  document.getElementById('amount').innerHTML=rlist.amount;
		  document.getElementById('gassavings').innerHTML=rlist.gassavings;
		  document.getElementById('co2').innerHTML=rlist.co2;
		  
		  var ridelist="";
		  var r=0;

		  $.each(rlist.rideList, function(key, value) {
		  	if(rlist.rideList[key][0].timepreference=="Y"){z=r;}
		  	r++;
		  });
		  
		  r=0;

		  $.each(rlist.rideList, function(key, value) { 			
			r++;
			if((r>z && r<(z+5)) || preftime=="1"){

			   if(role=="driver"){ridelist=ridelist+"<li><div class=\"rarrow\" onclick=\"selectdriver('"+key+"');\">";}
			   if(role=="rider"){ridelist=ridelist+"<li><div class=\"rarrow\" onclick=\"selectrider('"+key+"');\">";}

			   ridelist=ridelist+"<span style='padding-left:10px'>"+key+"</span>";  
			   timeslot=value;
			   x1=timeslot.length;
			   x2=value[0].rideid;
			   if(x1>0 && x2!=null){
				 ridelist=ridelist+"<span style='padding-left:30px'>"+x1+" drivers</span>";  
				 };
			   ridelist=ridelist+"</div></li>";
			   }
		  });
			document.getElementById('ridelist1').innerHTML=ridelist;		  
		  }
		  
// once you've selected a time slot, this paints the list of available drivers to ride with (used by riders)
		
		function selectdriver(timeslot){

			eventtime=rlist.rideList[timeslot][0].eventtime;		
			x=rlist.rideList[timeslot][0].fbid;

			if(x!=null){
			var personlist="<ul class='appNav'>";
			var r=0;
			ridegroup=rlist.rideList[timeslot];
			$.each(ridegroup, function(key, value) { 
					personlist=personlist+"<li><div class=\"rarrow\" onclick=\"selectride('"+timeslot+"','"+value.rideid+"','"+value.fbid+"','"+value.name+"','"+x+"');\">";
					personlist=personlist+"<image src='https://graph.facebook.com/"+value.fbid+"/picture'/>"+value.name;
					personlist=personlist+"</div></li>";
			});
			personlist=personlist+"</ul>";
			document.getElementById("personlist1").innerHTML=personlist;
			document.getElementById("r1").style.display="none";
			document.getElementById("r2").style.display="block";
		}
			else {selectride(timeslot,0,0,0,eventtime);}
		}

// this picks the specific ride (used by riders)
		
		function selectride(timeslot,rideid,driverfbid,pname,eventtime){

			document.getElementById("r1").style.display="none";
			document.getElementById("r2").style.display="none";
			fbid=localStorage.fbid;
			
			//if picking an empty slot
			if(rideid==0){

			   	 fbid=localStorage.fbid;
				 
				 url="http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/ridezu/api/v/1/rides/rider";
	 
				 var dataset = {
					 "fbid":	fbid,
					 "eventtime": eventtime,
					 "route": rlist.route
					 }				
	 
				 var jsondataset = JSON.stringify(dataset);
	 
				 var request=$.ajax({
					 url: url,
					 type: "POST",
					 dataType: "json",
					 data: jsondataset,
					 success: function(data) {
						 document.getElementById("ridetimea").innerHTML=timeslot;
						 document.getElementById("ridepickupa").innerHTML=rlist.start;
						 document.getElementById("r3").style.display="block";
						 },
					 error: function(data) {alert("Rats, I wasn't able to make this request: "+JSON.stringify(data)); },
					 beforeSend: setHeader
				 });

			}
			
			//if picking a specific ride
			
			if(rideid>0){
			
			   fbid=localStorage.fbid;
			   
			   var dataset = {
				   "fbid":	fbid,
				   }				
			   
			   var jsondataset = JSON.stringify(dataset);
   
			   url="http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/ridezu/api/v/1/rides/rideid/"+rideid+"/rider";
			   var request=$.ajax({
				   url: url,
				   type: "PUT",
				   dataType: "json",
				   data: jsondataset,
				   success: function(data) {
						document.getElementById("ridetimeb").innerHTML=timeslot;
						document.getElementById("ridepickupb").innerHTML=rlist.start;
						document.getElementById("dnameb").innerHTML=pname;
						document.getElementById("dnameb1").innerHTML=pname;
						document.getElementById("dpicb").innerHTML="<image src='https://graph.facebook.com/"+driverfbid+"/picture'/>";
				   		document.getElementById("r4").style.display="block";
				   		},
				   error: function(data) {alert("boo!"+JSON.stringify(data)); },
				   beforeSend: setHeader
			   });

			}
			
		}
 	
// once you've selected a time slot, this paints the list of available people who want rides (used by drivers)
		
		function selectrider(timeslot){

			eventtime=rlist.rideList[timeslot][0].eventtime;		
			x=rlist.rideList[timeslot][0].fbid;
			
			if(x!=null){
			personlist="<ul class='appNav'>";
			r=0;
			ridegroup=rlist.rideList[timeslot];
			$.each(ridegroup, function(key, value) { 
					personlist=personlist+"<li id=\"l"+value.fbid+"\"><div class=\"rarrow\" onclick=\"selectrider1('"+timeslot+"','"+value.rideid+"','"+value.fbid+"','"+value.name+"','"+eventtime+"');\">";
					personlist=personlist+"<image src='https://graph.facebook.com/"+value.fbid+"/picture'/>"+value.name;
					personlist=personlist+"</div></li>";
			});
			personlist=personlist+"</ul>";
			document.getElementById("rpersonlist1").innerHTML=personlist;
			document.getElementById("r1").style.display="none";
			document.getElementById("r2").style.display="block";
		}
			else {selectrider1(timeslot,0,0,0,eventtime);}
		}

// this picks the specific ride (used by drivers)
		
		function selectrider1(timeslot,ride,fbid1,pname,eventtime){			

			//if picking an empty slot (for drivers)

			if(ride==0){

			   	 fbid=localStorage.fbid;
				 
				 url="http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/ridezu/api/v/1/rides/rider";
	 
				 var dataset = {
					 "fbid":	fbid,
					 "eventtime": eventtime,
					 "route": rlist.route
					 }				
	 
				 var jsondataset = JSON.stringify(dataset);
	 
				 var request=$.ajax({
					 url: "http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/ridezu/api/v/1/rides/driver",
					 type: "POST",
					 dataType: "json",
					 data: jsondataset,
					 success: function(data) {
						 document.getElementById("posttimea").innerHTML=timeslot;
						 document.getElementById("ridepickupa").innerHTML=rlist.start;
						 document.getElementById("r1").style.display="none";
						 document.getElementById("r2").style.display="none";
						 document.getElementById("r3").style.display="block";
					  },
					 error: function(data) {alert("Rats, I wasn't able to make this request: "+JSON.stringify(data)); },
					 beforeSend: setHeader
				 });
 

				}
			
			//if picking a specific rider (for drivers)
			if(ride>0){
			
				 var dataset = {
						 "fbid": fbid,
						 }				
				 var jsondataset = JSON.stringify(dataset);
					 url="http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/ridezu/api/v/1/rides/rideid/"+ride+"/driver";
						 var request=$.ajax({
							 url: url,
							 type: "PUT",
							 dataType: "json",
							 data: jsondataset,
							 success: function(data) {
								x="l"+fbid1;
								newrow="<div class='select1'><image src='https://graph.facebook.com/"+fbid1+"/picture'/>"+pname+"</div>";
								document.getElementById(x).innerHTML=newrow;
								document.getElementById("xbutton").style.display="none";
								document.getElementById("nextbutton").style.display="block";
							 	},
							 error: function(data) {alert("Rats, I wasn't able to make this request: "+JSON.stringify(data));},
							 beforeSend: setHeader
						 });			
						}
		}

// this gives the final confirmation screen for the driver

		function driverconfirm(){			
			document.getElementById("ridepickupb").innerHTML=rlist.start;
			document.getElementById("r2").style.display="none";
			document.getElementById("r4").style.display="block";
		}


//this is part of login functionality (for testing) which pulls up the user list
		
		function getuserlist(){
		  $.ajax({
		  url: "http://ec2-50-18-0-33.us-west-1.compute.amazonaws.com/ridezu/api/users",
		  cache: false,
		  dataType: "json"
		  }).done(function(data) {
			userdata=data;
			paintuserlist();	
			  });
		}

		//this function paints all the users
		function paintuserlist(){
		  
		  var userlist="<ul class='appNav'>";
		  var r=0;
		  
		  $.each(userdata.users, function(key, value) { 
			userlist=userlist+"<li><div class=\"rarrow\" onclick=\"selectuser('"+r+"');\">";
			r++;
			userlist=userlist+"<span style='padding-left:10px'>"+value.fname+" "+value.lname+": "+value.fbid+"</span>";  
			var timeslot=value;
			userlist=userlist+"</div></li>";
		  });
		  
			userlist=userlist+"</ul>";
		  
			document.getElementById('userlist1').innerHTML=userlist;
		  
		  }
		
//once a user is selected this function loads local variables with all the correct data
		
		function selectuser(id){
			localStorage.seckey=userdata.users[id].seckey;
			localStorage.fbid=userdata.users[id].fbid;
			localStorage.first_name=userdata.users[id].fname;
			localStorage.last_name=userdata.users[id].lname;
			localStorage.hadd1=userdata.users[id].add1;
			localStorage.hcity=userdata.users[id].city;
			localStorage.hstate=userdata.users[id].state;	
			localStorage.hzip=userdata.users[id].zip;
			localStorage.wadd1=userdata.users[id].workadd1;
			localStorage.wcity=userdata.users[id].workcity;
			localStorage.wstate=userdata.users[id].workstate;	
			localStorage.wzip=userdata.users[id].workzip;
			localStorage.email=userdata.users[id].email;
			localStorage.originlatlong=userdata.users[id].originlatlong;
			localStorage.destlatlong=userdata.users[id].destlatlong;
			localStorage.homelatlong=userdata.users[id].homelatlong;
			localStorage.worklatlong=userdata.users[id].worklatlong;
			nav('loginp','mainp');
		}