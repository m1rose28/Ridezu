// this is the main .js file for all corp site functions on Ridezu.  this is different then the mobile site js although some functions will be similar.

// Avoid `console` errors in browsers that lack a console.
if (!(window.console && console.log)) {
    (function() {
        var noop = function() {};
        var methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error', 'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'markTimeline', 'profile', 'profileEnd', 'markTimeline', 'table', 'time', 'timeEnd', 'timeStamp', 'trace', 'warn'];
        var length = methods.length;
        var console = window.console = {};
        while (length--) {
            console[methods[length]] = noop;
        }
    }());
}

// Place any jQuery/helper plugins in here.
function slideSwitch() {
    var $active = $('#maincontent #testimonial.active');

    if ( $active.length == 0 ) $active = $('#maincontent #testimonial:last');

    var $next =  $active.next().length ? $active.next()
        : $('#maincontent #testimonial:first');

    $active.addClass('last-active');
        
    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    setInterval( "slideSwitch()", 4000 );
});


//FAQ ACCORDION -----------------------------------------------------------------------------------

$(document).ready(function()
{
	//Add Inactive Class To All faq Headers
	$('.faq-header').toggleClass('inactive-header');
	
	//Set The faq Content Width
	var contentwidth = $('.faq-header').width();
	$('.faq-content').css({'width' : contentwidth });
	
	// The Accordion Effect
	$('.faq-header').click(function () {
		if($(this).is('.inactive-header')) {
			$('.active-header').toggleClass('active-header').toggleClass('inactive-header').next().slideToggle().toggleClass('open-content');
			$(this).toggleClass('active-header').toggleClass('inactive-header');
			$(this).next().slideToggle().toggleClass('open-content');
		}
		
		else {
			$(this).toggleClass('active-header').toggleClass('inactive-header');
			$(this).next().slideToggle().toggleClass('open-content');
		}
	});
	
	return false;
});

//SLIDEOUT NAVIGATION -----------------------------------------------------------------------------------

$(document).ready(function(){
	var themenu  = $("#navmenu");
	var viewport = {
    	width  : $(window).width(),
    	height : $(window).height()
	};
	// retrieve variables as 
	// viewport.width / viewport.height
	
	function openme() { 
		$(function () {
			themenu.animate({
		       left: "46px"
		    }, { duration: 180, queue: false });
				$('#navmenu').fadeTo('180', 1, function() {
				// Animation complete.
				});
		});
	}
	
	function closeme() {
		var closeme = $(function() {
			themenu.animate({
		       left: "280px"
		    }, { duration: 180, queue: false });
				$('#navmenu').fadeTo('180', 0, function() {
				// Animation complete.
				});
		});
	}

	// checking whether to open or close nav menu
	$("#menu-btn").live("click", function(e){
		e.preventDefault();
		var leftval = themenu.css('left');
		
		if(leftval == "280px") {
			openme();
		}
		else { 
			closeme(); 
		}
	});
	
});


	function closeme() {
	var themenu  = $("#navmenu");
	var viewport = {
    	width  : $(window).width(),
    	height : $(window).height()
	};
	// retrieve variables as 
	// viewport.width / viewport.height

		var closeme = $(function() {
			themenu.animate({
		       left: "280px"
		    }, { duration: 190, queue: false });
				$('#navmenu').fadeTo('180', 0, function() {
				// Animation complete.
				});
		});
	}

// this is the google search for address functionality

      function initialize() {

        geocoder = new google.maps.Geocoder();

        var home1 = document.getElementById('home');
        var autocomplete1 = new google.maps.places.Autocomplete(home1);
		
        var work1 = document.getElementById('work');
        var autocomplete2 = new google.maps.places.Autocomplete(work1);
 
 	    google.maps.event.addListener(autocomplete1, 'place_changed', function() {
          var place1 = autocomplete1.getPlace();
          var place2 = autocomplete2.getPlace();

          
          if (!place1.geometry) {
            // Inform the user that the place was not found and return.
            return;
          }       
          });
 
         
        function setupClickListener(id, types) {
          google.maps.event.addDomListener(radioButton, 'click', function() {
          autocomplete1.setTypes(types);
          autocomplete2.setTypes(types);
          });
        }
      }

	  google.maps.event.addDomListener(window, 'load', initialize);

// this function validates the from and to 

		function start(){
            var addr1=document.getElementById("home").value;
		
			geocoder.geocode( { 'address': addr1}, function(results, status) {
				 if (status == google.maps.GeocoderStatus.OK) {
				   homex = results[0].formatted_address;
				   homelatlong = results[0].geometry.location;
				   myinfo.homelatlong=homelatlong.lat()+","+homelatlong.lng();
				   start1();
				 } 
			   });		   
			}

		function start1(){
            var addr2=document.getElementById("work").value;
		
			geocoder.geocode( { 'address': addr2}, function(results, status) {
				 if (status == google.maps.GeocoderStatus.OK) {
				   workx = results[0].formatted_address;
				   worklatlong = results[0].geometry.location;
				   myinfo.worklatlong=worklatlong.lat()+","+worklatlong.lng();
				   start2();
				 } 
			   });
			}

		function start2(){
			h=homex.split(",");
			w=workx.split(",");				
			if(homex.indexOf("USA")==-1 || h[3]!=" USA"){
				alert("Please enter a valid home address (in the US)");
				return false;
				}
			if(workx.indexOf("USA")==-1 || w[3]!=" USA"){
				alert("Please enter a valid work address (in the US)");
				return false;		
				}

			//break up the home info
			str1 = homex.split(',');
			str2 = str1[2].split(" ");
			myinfo.add1=str1[0];
			myinfo.state=str2[1];
			myinfo.city=str1[1];
			myinfo.zip=str2[2];

			//break up the work info
			str1 = workx.split(',');
			str2 = str1[2].split(" ");  			
			myinfo.workadd1=str1[0];
			myinfo.workstate=str2[1];
			myinfo.workcity=str1[1];
			myinfo.workzip=str2[2];
  			
			start3();
			}
			
		function start3(){
		    document.getElementById("corpstart").innerHTML="<span style='font-size:22px;color:#000;padding-bottom:20px;'>Please login with Facebook.<br><br>We're a green company focused on social good. We'll never spam you, share your private information, or abuse your trust.</span><a href=\"#\" onclick=\"loginUser();\" id=\"startbutton\">Login</a>";     

			}

// this function loads the current user in a js object, this function is used for all the profile functions 

		function loadmyinfo(){
		    fbid=localStorage.fbid;
		    url="/ridezu/api/v/1/users/search/fbid/"+fbid;
		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {
					myinfo=data;
					welcome();
			    	},
                error: function(data) { alert("Uh oh - I can't see to get my data"+JSON.stringify(data));reporterror(url) },
                beforeSend: setHeader
            });
		}

// this function updates user data with any relevant updates

		function updateuser(){
				updateuserflag=false;
            	var jsondataset = JSON.stringify(myinfo);
 				url="/ridezu/api/v/1/users/"+myinfo.id="/fbid/"+myinfo.fbid;
 				       
            	var request=$.ajax({
                url: url,
                type: "PUT",
                dataType: "json",
                data: jsondataset,
                success: function(data) {},
                error: function() { alert('uh oh, I could not save this data'); },
                beforeSend: setHeader
                });                                     
		}
		
// this function sets the logged in-state of the user...

		function welcome(){
		    document.getElementById("lout").style.display="inline";
		    document.getElementById("lin").style.display="none";
		    if(page=="Ridezu"){
		       document.getElementById("navmenu").style.display="block";  
		       document.getElementById("webappwrapper").style.display="block";  
		       document.getElementById("corptitle").setAttribute("class", "index80");
		       document.getElementById("homepageintro").setAttribute("class", "webapppage");
		       document.getElementById("noquotes").style.display="block";  
		       document.getElementById("corpstart").style.display="none";  
		       document.getElementById("quotes").style.display="none";  
		       document.getElementById("corptitle").innerHTML="<h2>Welcome "+myinfo.fname+"</h2>";     
		       document.getElementById("ridezuiframe").src="/index2.php?fbid="+myinfo.fbid+"&seckey="+myinfo.seckey+"&client=widget";
		     }
		  }

//  this is the facebook functionality

		function facebook(){
		  window.fbAsyncInit = function() {
			FB.init({
			  appId      : '443508415694320', // App ID
			  channelUrl : 'ridezu.com/channel.html', // Channel File
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
			   myinfo.profileblob=JSON.stringify(response);
			   myinfo.fname=response.first_name;
			   myinfo.lname=response.last_name;
			   myinfo.fbid=response.id;
			   localStorage.fbid=response.id;
			   myinfo.email=response.email;
			 });
		   }
		}

		function loginUser() {    
			 FB.login(function(response) {
			   if (response.authResponse) {
				  FB.api('/me', function(response) {
					  myinfo.profileblob=JSON.stringify(response);
					  myinfo.fname=response.first_name;
					  myinfo.lname=response.last_name;
					  myinfo.fbid=response.id;
					  localStorage.fbid=response.id;
					  myinfo.email=response.email;
					  if(myinfo.add1 && myinfo.workadd1){
						  regnewuser();
						  return false;
						  }
				  });
		   		  document.getElementById("fbauth").src="fbauth.php";
		   		 }
		   	   },{scope: 'email'});
	 		 }

		function logoutUser() {    
			 localStorage.removeItem("fbid");
			 localStorage.removeItem("seckey");
			 location.reload();
			 }

		function authuser(data){
			x=JSON.parse(data);
			
			if(x.seckey){
			   localStorage.fbid=x.fbid;
			   localStorage.seckey=x.seckey;
			   loadmyinfo();
			   }

			if(x.nouser){
				}
			}

// this function set (2) creates a new user as part of the enroll flow

		function regnewuser(){
			var dataset = {
				"fbid":	myinfo.fbid,
				"fname": myinfo.fname,
				"lname": myinfo.lname,
				"add1": myinfo.add1,
				"city": myinfo.city,
				"state": myinfo.state,	
				"zip": myinfo.zip,
				"workadd1": myinfo.workadd1,
				"workcity": myinfo.workcity,
				"workstate": myinfo.workstate,	
				"workzip": myinfo.workzip,
				"email": myinfo.email,
				"homelatlong": myinfo.homelatlong,
				"worklatlong": myinfo.worklatlong,
				"profileblob": myinfo.profileblob,
				"timezone": "PDT",
				"preference": "EMAIL",
				"leavetime": "09:00:00",
				"hometime": "17:00:00",
				"notificationmethod": "EMAIL",
				"ridereminders": "1",
				}
				
			var jsondataset = JSON.stringify(dataset);
		
		    var request=$.ajax({
                url: "/ridezu/api/v/1/users",
                type: "POST",
                dataType: "json",
                data: jsondataset,
                success: function() {},
                error: function() { //alert('already registered?');
  					localStorage.fbid=myinfo.fbid;
  					loadmyinfo();
  					reporterror(url);
                	},
                beforeSend: setHeader
            	}); 
            	
            request.done(function(msg) {
  				localStorage.seckey=msg.seckey;
  				localStorage.fbid=msg.fbid;

				myinfo=msg;
				
				//update miles & co2 if possible
				if(myinfo.destlatlong && myinfo.originlatlong){
					calculateDistance();
					}
				});                	     	
       		}

// this function set calculates distances between two points (in miles) and updates miles, % and co2 savings
  
		function calculateDistance() {
		  x = myinfo.originlatlong;
		  y = x.split(",");
		  var origin = new google.maps.LatLng(y[0],y[1]);		  

		  x = myinfo.destlatlong;
		  y = x.split(",");
		  var destination = new google.maps.LatLng(y[0],y[1]);		  
		  		  
		  var service = new google.maps.DistanceMatrixService();
		  service.getDistanceMatrix(
			{
			  origins: [origin],
			  destinations: [destination],
			  unitSystem: google.maps.UnitSystem.IMPERIAL,
			  travelMode: google.maps.TravelMode.DRIVING,
			  avoidHighways: false,
			  avoidTolls: false
			}, distcallback);
		}
  
		function distcallback(response, status) {
		  if (status != google.maps.DistanceMatrixStatus.OK) {
			alert('oops, I could not calculate a distance here: ' + status);
		  } else {
			myinfo.miles=Math.round(response.rows[0].elements[0].distance.value/1690.34); // response in meters, 1690.34 is meters/mile 
			myinfo.gassavings=25;
			myinfo.co2=Math.round(myinfo.miles/20*19.59);  // 20 mpg w/19.59 (8,887 grams) pounds per gallon of gas
			updateuser();
		  }
		}

// this used to auhtenticate the request

        function setHeader(xhr) {
            xhr.setRequestHeader("X-Id", localStorage.fbid);
            xhr.setRequestHeader("X-Signature", localStorage.seckey);
            xhr.setRequestHeader("Content-Type", "application/json");
        }
       
// this function setupdate the title bar on the widget

		function updateTitle(to){
		    document.getElementById("title").innerHTML=to;     
		}	

		function showarrow(){
			document.getElementById("menub").src="../images/back.png";
			tp=to;
		}	

		function showgrabber(){
			document.getElementById("menub").src="../images/back.png";
			tp="";
		}	

// this function is to report errors or anomalies that users see

		function reporterror(url){
			var dataset = {
				"fbid":	myinfo.fbid,
				"fname": myinfo.fname,
				"lname": myinfo.lname,
				"email": myinfo.email,
				"api":url,
				"page":p,
				}
				
			var jsondataset = JSON.stringify(dataset);

		    var request=$.ajax({
                url: "error.php",
                type: "POST",
                dataType: "html",
                data: jsondataset,
                success: function() {},
                error: function() {},
                beforeSend: setHeader
            	}); 
			}				

		
// declare initial variables

	    var geocoder;
	    var homex;
	    var workx;
		var homelatlng;
		var worklatlng;
	    var myinfo={};
	    var fbid;
	    var tp;


// this starts the docs and loads the page, off we go!

	$(document).ready(function()
	{
		
		myinfo.fbid=localStorage.fbid;
		myinfo.seckey=localStorage.seckey;

		if(myinfo.fbid!=undefined && myinfo.seckey!=undefined){
		   loadmyinfo();	 
		}

		else

		{
		   document.getElementById("lin").style.display="inline";
		   if($('#quotes').length>0){
				document.getElementById("corptitle").style.display="block";
				document.getElementById("corpstart").style.display="block";
				document.getElementById("quotes").style.display="block";
			}
			facebook();
		}			
	
		return false;
	});