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

// this is the google search for address functionality (only on home page)

		if(page=="Ridezu"){
	
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
	   }

// this function controls the flow of enrollment

		function appstart(){
				
			if(myinfo.fbid!=undefined && myinfo.add1!=undefined && myinfo.seckey!=undefined){	// start the app you've got everything!
				welcome();
				return false;
				}

			if(myinfo.fbid!=undefined && myinfo.add1!=undefined && myinfo.seckey==undefined){	// reg the user already;
				regnewuser();
	   		    return false;
				}

			if(myinfo.fbid!=undefined && myinfo.add1==undefined){	// get the address
				document.getElementById("corpstartcalc").innerHTML="<div style='font-size:18px;padding:10px;'>Next, tell us about your commute.</div><input class=\"arvo\" type=\"text\" value=\"Where I live\" id=\"home\" onfocus=\"if(this.value==this.defaultValue)this.value=\'\';\" onblur=\"if(this.value==\'\')this.value=this.defaultValue;\"><input class=\"arvo\" type=\"text\" value=\"Where I work\" id=\"work\" onfocus=\"if(this.value==this.defaultValue)this.value=\'\';\" onblur=\"if(this.value==\'\')this.value=this.defaultValue;\"><a href=\"#\" onclick=\"getaddr();\" id=\"startbutton\">Next</a>";
				//document.getElementById("overlay").style.display="none";
				initialize();
	   		    return false;
				}

			if(myinfo.fbid==undefined && myinfo.add1!=undefined){	// got the address now get them to enroll in fb
			    document.getElementById("corpstartcalc").innerHTML="<span style='font-size:22px;color:#000;padding-bottom:20px;'>Please login with Facebook.<br><br>We're a green company focused on social good. We'll never spam you, share your private information, or abuse your trust.</span><a href=\"#\" onclick=\"loginUser();\" id=\"startbutton\">Login</a>";     
				return false;
				}				
			}
			
// this function validates the from and to during the enrollment process

		function getaddr(){
            var addr1=document.getElementById("home").value;
		
			geocoder.geocode( { 'address': addr1}, function(results, status) {
				 if (status == google.maps.GeocoderStatus.OK) {
				   homex = results[0].formatted_address;
				   homelatlong = results[0].geometry.location;
				   myinfo.homelatlong=homelatlong.lat()+","+homelatlong.lng();
				   getaddr1();
				 } 
			   });		   
			}

		function getaddr1(){
            var addr2=document.getElementById("work").value;
		
			geocoder.geocode( { 'address': addr2}, function(results, status) {
				 if (status == google.maps.GeocoderStatus.OK) {
				   workx = results[0].formatted_address;
				   worklatlong = results[0].geometry.location;
				   myinfo.worklatlong=worklatlong.lat()+","+worklatlong.lng();
				   getaddr2();
				 } 
			   });
			}

		function getaddr2(){
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
  			
  			if(myinfo.seckey!=undefined){
  				updateuser();
  				}
  				
		    //window.optimizely.push(['trackEvent', 'address']);
			appstart();
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
					appstart();
			    	},
                error: function(data) { alert("Uh oh - I can't see to get my data"+JSON.stringify(data));reporterror(url) },
                beforeSend: setHeader
            });
		}

// this function updates user data with any relevant updates

		function updateuser(){
				updateuserflag=false;
            	var jsondataset = JSON.stringify(myinfo);
 				url="/ridezu/api/v/1/users/"+myinfo.id+"/fbid/"+myinfo.fbid;
 				       
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
			if(myinfo.company!=null && myinfo.company!=""){
				document.getElementById("cobrand").src="images/cobrand/"+myinfo.company+".png";
				document.getElementById("cobrand").style.display="inline";
				}
		    document.getElementById("lout").style.display="inline";
		    document.getElementById("lin").style.display="none";
		    if(page=="Ridezu"){
		       document.getElementById("navmenu").style.display="block";  
		       document.getElementById("webappwrapper").style.display="block";  
		       document.getElementById("corptitle").setAttribute("class", "index80");
		       document.getElementById("homepageintro").setAttribute("class", "webapppage");
		       document.getElementById("noquotes").style.display="block";  
			   document.getElementById("corpstartcalc").style.display="none";
		       document.getElementById("quotes").style.display="none";  
		       document.getElementById("corptitle").innerHTML="<h2>Welcome "+myinfo.fname+"</h2>";     
		       document.getElementById("ridezuiframe").src="/index1.php?fbid="+myinfo.fbid+"&seckey="+myinfo.seckey+"&client=widget";
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
				updateUserInfo(response);
			  }
			}
		  function updateUserInfo(response) {
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
					  info.accessToken=FB.getAuthResponse()['accessToken'];
					  //console.log(info.accessToken);
					  //window.optimizely.push(['trackEvent', 'fblogin']);

					  if(info.accessToken){
	   
							  // check the ridezu server if this user exists or not...
							  
							  fbid=localStorage.fbid;
							  url="/fbauth2.php?accesstoken="+info.accessToken;
							  var request=$.ajax({
								  url: url,
								  type: "GET",
								  dataType: "json",
								  success: function(data) {
									  if(data.seckey!="na"){
										  localStorage.fbid=data.fbid;
										  localStorage.seckey=data.seckey;
										  myinfo.fbid=data.fbid;;
										  myinfo.seckey=data.seckey;
										  loadmyinfo();
										  appstart();
										  }
									   else {
										   appstart();
										   }
									  },
								  error: function(data) { alert("Uh oh - I can't see to get my data"+JSON.stringify(data));reporterror(url) },
								  beforeSend: setHeader
							  });			   										  
						   
						   }		
		
				  });
	   		 }
		   	   },{scope: 'email'});
	 		 }

		function logoutUser() {    
			 localStorage.removeItem("fbid");
			 localStorage.removeItem("seckey");
			 location.reload();
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
					"company": myinfo.company,
					"timezone": "PDT",
					"preference": "EMAIL",
					"leavetime": "09:00:00",
					"hometime": "17:00:00",
					"notificationmethod": "EMAIL",
					"ridereminders": "1",
					"referer":referrer
					}
					
			var jsondataset = JSON.stringify(dataset);
			url = "/ridezu/api/v/1/users";
		    var request=$.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: jsondataset,
                success: function() {
                	},
                error: function() {
                	reporterror(url);
                	alert("It looks like you are already registered. Please Login.");
                	localStorage.removeItem('fbid');
                	localStorage.removeItem('seckey');
                	document.location.reload(true);
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
			    //window.optimizely.push(['trackEvent', 'reguser']);
				appstart();
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

// this function adds commas to long numbers (used in Ridezunomics)
											
		function addCommas(str){
 		   if(str==null){str=0;}
 		   var arr,int,dec;
		   str += '';

		   arr = str.split('.');
		   int = arr[0] + '';
		   dec = arr.length>1?'.'+arr[1]:'';

 		   return int.replace(/(\d)(?=(\d{3})+$)/g,"$1,") + dec;
		}
		
// this function set initiates the calculator and slider function function (fiverr)

		function calcinit(){

			function MobileSlider(container, options) {
				this.init(container, options);
			}
			
			MobileSlider.prototype.init = function init(container, options) {
				if(typeof container === "string") {
					this.container_element = document.getElementById(container);
				} else {
					this.container_element = container;
				}
				
				this.events = {
					start: ['touchstart', 'mousedown'],
					move: ['touchmove', 'mousemove'],
					end: ['touchend', 'touchcancel', 'mouseup']
				};
				
				this.options = options;
				
				this.allowDecimals = this.options.decimals;
				this.decimalPlaces = this.options.decimal_places;
				
				if(this.options.toggle) {
					this.options.start = 0;
					this.options.min = 0;
					this.options.max = 1;
					this.allowDecimals = true;
					this.decimalPlaces = 2;
					
					var option1 = document.createElement('span');
					option1.innerHTML = this.options.toggle_values[1];
					option1.setAttribute("id", "option1");
					option1.setAttribute("class", "togglespan");
					this.container_element.appendChild(option1);
					
					var option0 = document.createElement('span');
					option0.innerHTML = this.options.toggle_values[0];
					option0.setAttribute("id", "option0");
					option0.setAttribute("class", "togglespan");
					this.container_element.appendChild(option0);
					
					var selected_value_element = document.createElement("span");
					selected_value_element.setAttribute("id", "selectedvalue");
					this.container_element.appendChild(selected_value_element);
					this.selected_value_element = document.getElementById("selectedvalue");
					
					option1.style.left = option1.offsetWidth +"px";
					
				}
			
				this.supportsWebkit3dTransform = (
				  'WebKitCSSMatrix' in window && 
				  'm11' in new WebKitCSSMatrix()
				);
				
				this.circle = this.container_element.getElementsByClassName('circle')[0];
				this.bar = this.container_element.getElementsByClassName('bar')[0];

				this.start = this.start.bind(this);
				this.move = this.move.bind(this);
				this.end = this.end.bind(this);
				
				this.addEvents("start");
				this.setValue(this.options.start);

			};
			
			MobileSlider.prototype.addEvents = function addEvents(name) {
				var list = this.events[name];
				var handler = this[name];
				
				for (var next in list){
				  this.container_element.addEventListener(list[next], handler, false);
				}
			};
			
			MobileSlider.prototype.removeEvents = function removeEvents(name){ 
				var list = this.events[name];
				var handler = this[name];
				  
				for (var next in list){
				  this.container_element.removeEventListener(list[next], handler, false);
				}
			};
			
			MobileSlider.prototype.start = function start(event) {	
				this.addEvents("move");
				this.addEvents("end");
				this.handle(event);
				var baroffset = $(this.bar).offset();
   	 			var circleWidth = this.circle.offsetWidth;
 				var leftoffset = baroffset.left+(circleWidth/2);
 				circleleft="-"+leftoffset+"px";
 				this.circle.style.left = circleleft;
			};
			
			MobileSlider.prototype.move = function move(event) {
				this.handle(event);
			};
			
			MobileSlider.prototype.end = function end(event) {
				this.removeEvents("move");
				this.removeEvents("end");
			};
			
			MobileSlider.prototype.setValue = function setValue(value) {
				if (value === undefined){ value = this.options.min; }
				
				value = Math.min(value, this.options.max);
				value = Math.max(value, this.options.min);
						
   	 			var circleWidth = this.circle.offsetWidth;
    			var barWidth = this.bar.offsetWidth;
    			var range = this.options.max - this.options.min;
    			var width = barWidth;
				var baroffset = $(this.bar).offset();
 				var leftoffset = baroffset.left;
 				var rightoffset = leftoffset+width;
 				
				var position = Math.round(leftoffset+(width*((value-this.options.min)/(this.options.max-this.options.min))));

    			this.setCirclePosition(position);
    			this.value = value;
    			this.callback(value);
			};
			
			MobileSlider.prototype.setCirclePosition = function setCirclePosition(x_position) {
				
				if (this.supportsWebkit3dTransform) {
					this.circle.style.webkitTransform = 'translate3d(' + x_position + 'px, 0, 0)';
					if(this.options.toggle) {
						var option0 = document.getElementById("option0");
						var option1 = document.getElementById("option1");
						
						option0.style.webkitTransform = 'translate3d(' + ((option0.offsetLeft)-x_position) + 'px, 0, 0)';
						option1.style.webkitTransform = 'translate3d(' + ((option0.offsetLeft0)-x_position) + 'px, 0, 0)';
						
						this.setToggleValue();
					}
				} else {
					this.circle.style.webkitTransform = 
					this.circle.style.MozTransform = 
					this.circle.style.msTransform = 
					this.circle.style.OTransform = 
					this.circle.style.transform = 'translateX(' + x_position + 'px)';
				  
					if(this.options.toggle) {
						var option0 = document.getElementById("option0");
						var option1 = document.getElementById("option1");
						
						option0.style.webkitTransform = 
						option0.style.MozTransform = 
						option0.style.msTransform = 
						option0.style.OTransform = 
						option0.style.transform = 'translateX(' + ((option0.offsetLeft)-x_position) + 'px)';
						
						option1.style.webkitTransform = 
						option1.style.MozTransform = 
						option1.style.msTransform = 
						option1.style.OTransform = 
						option1.style.transform = 'translateX(' + ((option0.offsetLeft)-x_position) + 'px)';
						
						this.setToggleValue();
					}
				}
			};			
						
			MobileSlider.prototype.handle = function handle(event) {
				event.preventDefault();
				if (event.targetTouches){ event = event.targetTouches[0]; }
			  
				var position = event.pageX;
				var element;
				var circleWidth = this.circle.offsetWidth;
				var barWidth = this.bar.offsetWidth;
				var width = barWidth;
				var range = (this.options.max - this.options.min);
				var value;
				var baroffset = $(this.bar).offset();
 				var leftoffset = baroffset.left;
 				var rightoffset = leftoffset+width;
				  
				position = Math.max(position, leftoffset);
				position = Math.min(position, rightoffset);
							  
				this.setCirclePosition(position);
					value = (this.options.min+((position-leftoffset)/width)*(this.options.max-this.options.min)).toFixed(this.decimalPlaces);
				if(this.allowDecimals) {
					
				} else {
					value = this.options.min + Math.round(((position-leftoffset)/width)*(this.options.max-this.options.min));
				}
				this.setValue(value);
			};
			
			MobileSlider.prototype.callback = function callback(value) { 
				if (this.options.update){
					this.options.update(value);
				}
			};

			info.gasprice=4.25;
			info.miles=20;
			info.mpg=20;
			
			if(localStorage.gasprice){info.gasprice=localStorage.gasprice};
			if(localStorage.miles){info.miles=localStorage.miles};
			if(myinfo.miles){info.miles=myinfo.miles};
			if(localStorage.mpg){info.mpg=localStorage.mpg};

			var slider1 = new MobileSlider("slider1", {
			    start: info.miles,
			    min: 2,
			    max: 80,
			    update: function(value) {
			        document.getElementById("slidervaluea").innerHTML = value;
			        localStorage.miles=value;
			    }

			});
			
			var slider2 = new MobileSlider("slider2", {
				decimals: true,
				decimal_places: 2,
			    start: info.gasprice,
			    min: 3.49,
			    max: 5.99,
			    update: function(value) {
			        document.getElementById("slidervalueb").innerHTML = value;
			        localStorage.gasprice=value;
			    }
			});
			
			var slider3 = new MobileSlider("slider3", {
			    start: info.mpg,
			    min: 10,
			    max: 50,
			    update: function(value) {
			        document.getElementById("slidervaluec").innerHTML = value;
			        localStorage.mpg=value;
			    }
			});

		}

// this is the calculator function for ridezunomics

		function calcv(){
		
			miles=document.getElementById('slidervaluea').innerHTML;
			if(document.getElementById("driver").checked==true){utype="driver";} else {utype="rider";}
			gas=document.getElementById('slidervalueb').innerHTML;
			mpg=document.getElementById('slidervaluec').innerHTML;
								
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
				message="<p>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.</p><p>By using Ridezu you'll collect an estimated <b>$"+ftotrev+"</b> to help offset your gas costs.</p><p>PS. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</p>";
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
					message="<p>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.</p><p>By using Ridezu you'll still pay <b>$"+ftotrev+"</b> to get to work, but you'll save <b>$"+fsavings+ "</b> in gas, save the miles from your car, and you'll be so green.</p><p>PS. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</p>";
				}
	
				if(savings<=0){
					message="<p>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.</p><p>By using Ridezu you'll pay <b>$"+ftotrev+"</b> to get to work.  This might be a little more than gas, but you'll save the miles from your car, and you'll be so green.</p><p>PS. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</p>";
				}
			}
			
		//check if homepage or howitworks
			if($("#corpstartcalc").length > 0){
  				document.getElementById('calcmessage').innerHTML=message;
  				document.getElementById('wizard1').style.display="none";
  				document.getElementById('wizard2').style.display="block";
			}
			else {
				openconfirm(); 
			}
		}
		
// these two functions show the alert dialog (and process functions, if required)

		function openconfirm(){
			document.getElementById('confirm-message').innerHTML=message;
			document.getElementById('cancel-button').innerHTML=cancelmessage;
			document.getElementById('ok-button').innerHTML=okmessage;
			if(showcancel==true){document.getElementById('cancel-button').style.display="block";document.getElementById('ok-button').style.float="left"}
			if(showcancel==false){document.getElementById('ok-button').style.float="center";}
			$('#confirm-background').fadeIn({ duration: 100 });		
			}
			
		function closeconfirm(action){
			if(action=="ok" && confirmfunction!=""){window[confirmfunction]();}
			document.getElementById('cancel-button').style.display="none";	
			showcancel=false;
			confirmfunction="";
			okmessage="OK";
			cancelmessage="Cancel";
			$('#confirm-background').fadeOut({ duration: 100 });
			}		
			
// this function controls the sign up wizard

		function calcback() {
			document.getElementById('wizard1').style.display="block";
  			document.getElementById('wizard2').style.display="none";
		}
		
		function nextstep() {
			document.getElementById('wizard3').style.display="block";
  			document.getElementById('wizard2').style.display="none";
		}
			
// this function set is for sharing on fb/twitter/linkedin

	 	  function fbpopup(){
		  	  url="https://www.facebook.com/dialog/feed?app_id=443508415694320&"+
		  	  "link=https://www.ridezu.com%3Fr%3D"+myinfo.fbid+"&"+
		  	  "picture=http://www.ridezu.com/images/getyour10.png&"+
		  	  "name=Get%20$10%20from%20Ridezu&"+
		  	  "caption=Sign-up%20Today&"+
		  	  "display=popup&"+
		  	  "description=Use this special referral from "+myinfo.fname+" "+myinfo.lname+" and get an instant $10 on the newest and coolest ride-sharing network&"+
		  	  "redirect_uri=https://www.ridezu.com/r/closeme.php";
	          psize="height=300,width=550";
	          popitup(url,psize)	   
	 	   }
		  
		  function twitterpopup(){
		  	  vurl="?r="+myinfo.fbid;
		  	  vurl1="https://www.ridezu.com"+vurl;
		      url="https://twitter.com/share?text=Checkout Ridezu - a cool, new ridesharing service.  Signup today and get instant $10.&url="+vurl1+"&counturl=https://www.ridezu.com";
	          psize="height=300,width=550,top=25%,left=30%;";
		      popitup(url,psize);
		  }

		  function linkedinpopup(){
		  	  vurl="https://www.ridezu.com/r/newsfeed.php?n=l&amp;fbid=<?php echo $fbid;?>&amp;name=<?php echo $name;?>";
		  	  vurl1="https://www.ridezu.com/r/newsfeed.php?n=l&amp;fbid=<?php echo $fbid;?>&amp;name=<?php echo $name;?>";

		  	  url="https://www.linkedin.com/cws/share?url="+vurl+"&original_referer="+vurl1;
		  	  //+"&original_referer="+vurl1;
	          psize="height=375,width=625,top=100,left=250";
		      popitup(url,psize);		  	  
		  }
		  
		  function popitup(url) {
		  	  newwindow=window.open(url,'name',psize);
		  	  newwindow.moveTo(400,250);
			  if (window.focus) {newwindow.focus()}
			  return false;
		  }

// this function is to report errors or anomalies that users see

		function reporterror(url){
			var dataset = {
				"fbid":	myinfo.fbid,
				"fname": myinfo.fname,
				"lname": myinfo.lname,
				"email": myinfo.email,
				"api":url,
				"page":"corpsite",
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
	    var fbid;
	    var tp;
		var cancelmessage="Cancel";
		var message;
		var okmessage="OK";
		var confirmfunction="";
		var showcancel=false;

// this starts the docs and loads the page, off we go!

	$(document).ready(function()
	{
		//this tells you which experiment is running (so you can turn one off)
		//x=window['optimizely'].data.state.variationMap;
		
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
				document.getElementById("quotes").style.display="block";
				if(myinfo.company!=null && myinfo.company!=""){
					document.getElementById("cobrand").src="images/cobrand/"+myinfo.company+".png";
					document.getElementById("cobrand").style.display="inline";
					}				
			}
			facebook();
		}			
	
		if(page=="How it Works" || page=="Ridezu"){
			calcinit();
			}

		if(referrer!=""){
			document.getElementById("referror").innerHTML=rname;
			x="https://graph.facebook.com/"+referrer+"/picture";
			document.getElementById("referpic").src=x;
			document.getElementById("referafriend").style.display="block"; 
			}
		
		else {
			document.getElementById("ridezunomics").style.display="block";
			}
		
		return false;	
	
	});
	

		