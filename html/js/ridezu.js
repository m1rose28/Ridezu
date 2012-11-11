// these are all custom functions used by ridezu.  these are here temporarily and should all be moved to ridezu.js (they should also be minified)

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
			    	},
                error: function(data) { alert("Uh oh - I can't see to get my data"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
		}
  				
// this function loads all user data in a js object, this function is used when looking at another user 

		function loaduser(fbid){
		    url="/ridezu/api/v/1/users/search/fbid/"+fbid;
		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {
					userinfo=data;
					paintuserprofile();
			    	},
                error: function(data) { alert("Uh oh - does this user exist?"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
		}

// this function updates user data with any relevant updates

		function updateuser(){
				fbid=localStorage.fbid;
				id=myinfo.id;
				alert(id);
				updateuserflag=false;
            	var jsondataset = JSON.stringify(myinfo);
 				url="/ridezu/api/v/1/users/"+id;
 				       
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
		
// this function turns strings into currency values

		function curr(amount){
		var num;
		num=Number(amount);
		x = num.toFixed(2);
		if(x<0){
			x=x*-1;
			x="-$"+x;
			}
		else {
			x = "$"+x;
			}
		return x;
		}

// this function adds commas to long numbers (used in ridezunomics)
											
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
				var width = barWidth - circleWidth;
				var position = Math.round((value - this.options.min) * width / range);
			
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
						option1.style.webkitTransform = 'translate3d(' + ((option0.offsetLeft - 20)-x_position) + 'px, 0, 0)';
						
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
						option1.style.transform = 'translateX(' + ((option0.offsetLeft - 20)-x_position) + 'px)';
						
						this.setToggleValue();
					}
				}
			};
			
			MobileSlider.prototype.setToggleValue = function setToggleValue() {
				if(this.circle.style.transform === "translateX(0px)") {
					this.selected_value_element.innerHTML = this.options.toggle_values[0];
				} else {
					this.selected_value_element.innerHTML = this.options.toggle_values[1];
				}
			};
			
			MobileSlider.prototype.handle = function handle(event) {
				event.preventDefault();
				if (event.targetTouches){ event = event.targetTouches[0]; }
			  
				var position = event.pageX; 
				var element;
				var circleWidth = this.circle.offsetWidth;
				var barWidth = this.bar.offsetWidth;
				var width = barWidth - circleWidth;
				var range = (this.options.max - this.options.min);
				var value;
				  
				for (element = this.element; element; element = element.offsetParent) {
				  position -= element.offsetLeft;
				}
				
				position += circleWidth / 2;
				position = Math.min(position, barWidth);
				position = Math.max(position - circleWidth, 0);
			  
				this.setCirclePosition(position);
					value = (this.options.min + (position * range / width)).toFixed(this.decimalPlaces);
				if(this.allowDecimals) {
					
				} else {
					value = this.options.min + Math.round(position * range / width);
				}
				this.setValue(value);
			};
			
			MobileSlider.prototype.callback = function callback(value) { 
				if (this.options.update){
					this.options.update(value);
				}
			};

			var slider1 = new MobileSlider("slider1", {
			    start: 25,
			    min: 1,
			    max: 100,
			    update: function(value) {
			        document.getElementById("slidervalue1").value = value;
			    }
			});
			
			var slider2 = new MobileSlider("slider2", {
				decimals: true,
				decimal_places: 2,
			    start: 3.85,
			    min: 3.00,
			    max: 6.00,
			    update: function(value) {
			        document.getElementById("slidervalue2").value = value;
			    }
			});
			
			var slider3 = new MobileSlider("slider3", {
			    start: 25,
			    min: 10,
			    max: 60,
			    update: function(value) {
			        document.getElementById("slidervalue3").value = value;
			    }
			});
			
			var textslider1 = new MobileSlider("textslider1", {
			    toggle: true,
			    toggle_values: ['driver', 'rider']
			});
			
			document.getElementById("calculateBtn").addEventListener("click", function() {
				calcv();
			}, false);
		
		}

// this is the calculator function for ridezunomics

		function calcv(){

			miles=document.getElementById('slidervalue1').value;
			utype=document.getElementById('selectedvalue').innerHTML;
			gas=document.getElementById('slidervalue2').value;
			mpg=document.getElementById('slidervalue3').value;
					
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
				message="<p>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<p>Ridezu can help.<p>By using ridezu you'll collect an estimated <b>$"+ftotrev+"</b> to help offset your gas costs.<p>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</p>";
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
					message="<p>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<p>Ridezu can help.<p>By using ridezu you'll still pay <b>$"+ftotrev+"</b> to get to work, but you'll save <b>$"+fsavings+ "</b> in gas, save the miles from your car, and you'll be so green.<p>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</p>";
				}
	
				if(savings<=0){
					message="<p>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<p>By using ridezu you'll pay <b>$"+ftotrev+"</b> to get to work.  This might be a little more than gas, but you'll save the miles from your car, and you'll be so green.<p>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</p>";
				}
			}
			openconfirm(); 
		}
		
// anything with a "nav" is the navigation system. which shows (to) and hides (from) pages as well as invokes specific
// javascript for individual pages to load.   

// function set to link from navigation side window (close window) or from primary windows to eachother

		function nav1(to){
			closeme();
			if(p!=to){
				nav(p,to);
				}
			}
					
		function nav(from, to){
			testdata="Logged in as: " + localStorage.first_name+" "+localStorage.last_name+" : "+localStorage.fbid;
			testlink="<a class='tlink' href='/test/servicetest.php?uid="+localStorage.fbid+"' target='ridezutest'>"+testdata+"</a>";
			document.getElementById('pTitle').innerHTML=pageTitles[to];
			document.getElementById('testbar').innerHTML=testlink;
			document.getElementById(p).style.display="none";		
			document.getElementById(p).innerHTML="";		
			document.getElementById(to).style.display="none";
			scrollTo(0,0);						
			url="pages/"+ to + ".html";
			$.ajax({
  			url: url,
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
			p=to;
			navinit(to);
		}

// function set to move from primary pages to secondary pages (the arrow button).  
// here the original primary page dom is kept in place.  when you navigate "back" the 
// tp dom is erased.  also whenever you use the cor nav function the tp div is erased.
	
		function navt1(){
			tp="";
  			document.getElementById("temp").innerHTML="";
  			document.getElementById('pTitle').innerHTML=pageTitles[p];
			document.getElementById(p).style.display="block";
			document.getElementById("menub").src="../images/menu.png";
			}

		function navt(from, to){
			testdata="Logged in as: " + localStorage.first_name+" "+localStorage.last_name+" : "+localStorage.fbid;
			testlink="<a class='tlink' href='/test/servicetest.php?uid="+localStorage.fbid+"' target='ridezutest'>"+testdata+"</a>";
			document.getElementById('pTitle').innerHTML=pageTitles[to];
			document.getElementById('testbar').innerHTML=testlink;
			document.getElementById(from).style.display="none";		
			scrollTo(0,0);
			url="pages/"+ to + ".html";
			tp=to;
			document.getElementById("menub").src="../images/back.png";
			$.ajax({
  			url: url,
  			cache: false,
  			dataType: "html"
			}).done(function( html ) {
  				document.getElementById("temp").innerHTML=html;
				xx=document.getElementById("temp");
				$(xx).trigger('create');
  				navinit(to);  				
				});
		}
		
// this function initiates a page (runs initial js function so the page can operate)

		function navinit(to){
		
			if(to=="accountp"){
				account();
				}

			if(to=="calcp"){
				calcinit();
				}
				
			if(to=="contactinfop"){
				contactinfoinit();
				}

			if(to=="driverp"){
				dverifyinit();
				}

			if(to=="enrollp"){
				document.getElementById("topbar").style.display="block";		
			  	message="<p>First, type in or select your home address.<br><br>Your home address will never be shared.</p>";
			  	openconfirm();
			  	getLocation();
				}

			if(to=="fbp"){
				facebook();
				}
				
			if(to=="homeprofilep"){
				homeprofileinit();
				}
	
			if(to=="loginp"){
				getuserlist();
				}

			if(to=="myridesp"){
				myrides();
				}

			if(to=="notifyp"){
				notifyinit();
				}

			if(to=="payoutp"){
				payoutinfoinit();
				}
											
			if(to=="ridedetailsp"){
				ridedetails();
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

			if(to=="startp" || p=="startp"){
				document.getElementById("topbar").style.display="none";		
				document.getElementById(p).style.display="block";	    
				}

			if(to=="transactionp"){
				$("tr:odd").css("background-color", "#ffffff");
				}

			if(to=="userprofilep"){
				fbid=localStorage.fbid;
				if(userfbid==""){fbid=localStorage.fbid;}
				loaduser(fbid);
				}
			
			if(to=="workprofilep"){
				workprofileinit();
				}

			if(to=="pricingp" || to=="mainp" || to=="profilep" || to=="howitworksp" || to=="termsp" || to=="faqp" || to=="calcp" || to=="fbp" || to=="enrollp" || to=="congratp"){
				document.getElementById(p).style.display="block";	    
				}

			if(updateuserflag==true){alert("I'm updating");updateuser();}
		}		

// this function turns on a loading indicator.  only use when making a non-cached server call.

		function pleasehold(){
			document.getElementById("loading").style.display="block";
		}

// this function paints a page after it's full loaded and turns off the loading indicator

		function loading(p){
			document.getElementById(p).style.display="block";
			document.getElementById("loading").style.display="none";
		}
	
// these two functions show the alert dialog (and process functions, if required)

		function openconfirm(){
			document.getElementById('confirm-message').innerHTML=message;
			document.getElementById('cancel-button').innerHTML=cancelmessage;
			document.getElementById('ok-button').innerHTML=okmessage;
			if(showcancel==true){document.getElementById('cancel-button').style.display="block";}
			$('#confirm-background').fadeIn({ duration: 100 });		
			}
			
		function closeconfirm(action){
			if(action=="ok" && confirmfunction!=""){window[confirmfunction]();}
			document.getElementById('cancel-button').style.display="none";	
			showcancel=false;
			confirmfunction="";
			okmessage="OK";
			cancelmessage="Cancel";
			message="";
			$('#confirm-background').fadeOut({ duration: 100 });
			}		
		
// this function takes a physical address and turns into lat long

		function getaddr(){
			var addr1=document.getElementById('location').value;
			geocoder.geocode( { 'address': addr1}, function(results, status) {
				 if (status == google.maps.GeocoderStatus.OK) {
				   map.setCenter(results[0].geometry.location);
				 } else {
				   alert('Geocode was not successful for the following reason: ' + status);
				 }
			   });
			}

// this is the main map function (method is type of function, e.g. enroll, myspot is lat/long, and zoom level is obvious :-)

  		function loadMap(method,myspot,zoomlevel,marker){
  	        
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
  
	        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
  
	        if(method=="pick"){
	        
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
						 marker1.setPosition(a);
							 },1000);
					 window.setTimeout(function() {
						 codeLatLng();	
							 },1000);
	 
				 });
				 	 
				 if(marker=="home"){var image = 'images/basehmarker.png';}  
				 if(marker=="work"){var image = 'images/basecmarker.png';}  
													
				 var marker1 = new google.maps.Marker({
					 position: myspot,
					 icon:image,
					 });
	 
				 // adds the initial marker to the page
				 marker1.setMap(map);
				 codeLatLng();
				 
				}

			if(method=="pickselect"){

				 var targetDiv = document.createElement('div');
				 
				 if(marker=="home"){var image = 'images/basehmarker.png';nodetype="H";}  
				 if(marker=="work"){var image = 'images/basecmarker.png';nodetype="W";}  
				 
				 var marker1 = new google.maps.Marker({
					 position: myspot,
					 icon:image,
					 });
	 
				 // adds the initial marker to the page
				 marker1.setMap(map);
			   
				 targetDiv.innerHTML = '<img style="margin-top:-30px;" src="images/circle.png"/>';
				 targetDiv.style.postion = 'absolute';
				 targetDiv.style.left = '50%';
				 targetDiv.style.top = '50%';
				 targetDiv.style.height = '50px';
				 targetDiv.index = 1;
				 map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(targetDiv);

				 google.maps.event.addListener(map, 'center_changed', function() {
					 window.setTimeout(function() {
						 codeLatLng();	
							 },1000);
	 
				 });
			
				function getnodes(nodetype){
  			      	fbid=localStorage.fbid;
				    url="/ridezu/api/v/1/users/search/fbid/"+fbid+"/location/"+nodetype;
					var request=$.ajax({
						url: url,
						type: "GET",
						dataType: "json",
						success: function(data) {
							nodelist=data;
							paintnodes(data); },
						error: function(data) { alert("boo!"+JSON.stringify(data)); },
						beforeSend: setHeaderUser
					});
				}
				
				function paintnodes(nodelist){
				
					$.each(nodelist, function(key, value) {
			  		if(value.type=="Park and Ride"){
			  			icn="../images/basepmarker.png";
			  			}
			  		
			  		if(value.type=="Company"){
			  			icn="../images/basecmarker.png";
			  			}

			  		if(value.custommarker!=""){
			  			icn="../images/"+value.custommarker+".png";
			  			}
	
					x=value.latlong;
					y=x.split(",");
					c=new google.maps.LatLng(y[0],y[1]);
					m[key]=new google.maps.Marker({
						position:c,
						map: map,
						icon: icn
						});
					
					google.maps.event.addListener(m[key], 'click', function() {
						a=nodelist[key].latlong;
						b=a.split(",");
						localStorage.lat=b[0];
						localStorage.lng=b[1];
						desc=nodelist[key].name;
						if(nodelist[key].campus!=""){
							desc=desc+" ("+nodelist[key].campus+")";
							}
						localStorage.desc=desc;
						document.getElementById("location").value=desc;
						});
			  		});
				}
				getnodes(nodetype);		
			}

		// this function turns lat/long into a real address 

  	  	
  	  	function codeLatLng() {
		    var ctr = map.getCenter();
  			var lat = ctr.lat();
  			var lng = ctr.lng();
      		var latlng = new google.maps.LatLng(lat, lng);
  
            window.setTimeout(function() {

      		geocoder.geocode({'latLng': latlng}, function(results, status) {
        		if (status == google.maps.GeocoderStatus.OK) {
          			if (results[1]) {
      	      			locationselect(results[0].formatted_address,lat,lng);
          				}
        			} 
      			});
            },1000);
 		
    		}              
  		}
  
// this function set(2) gets your actual location (used only at enroll, the balance of the time we'll have your address)	

		function getLocation(){
  			if (navigator.geolocation){
    			navigator.geolocation.getCurrentPosition(showPosition);
    			}
  				else{alert("Yikes - geolocation is not supported by this browser. Go fish.");}
  				}

		function showPosition(position){
			myspot = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			loadMap("pick",myspot,18,"home");
  			}
  		
// this is a map function which places the value of the user location in the text field of location

		function locationselect(location,lat,lng){
			str1 = location.split(',');
			str2 = str1[2].split(" ");
			localStorage.add1=str1[0];
			localStorage.state=str2[1];
			localStorage.city=str1[1];
			localStorage.zip=str2[2];
			localStorage.hcountry=str1[3];
  			document.getElementById('location').value=str1[0]+", "+str1[1];
  			document.getElementById('lat').value=lat;
  			document.getElementById('lng').value=lng;
  			localStorage.lat=lat;
  			localStorage.lng=lng;
		}

// this function parses/stores the home address and then moves to the work address

		function enrollhome(){
			document.getElementById("enrollp").style.display="block";	    
			loadMap("pick",myspot,9,"work");
			localStorage.hadd1=localStorage.add1;
			localStorage.hstate=localStorage.state;
			localStorage.hcity=localStorage.city;
			localStorage.hzip=localStorage.zip;
			localStorage.hcountry=localStorage.country;
			localStorage.hlat=document.getElementById('lat').value;
			localStorage.hlng=document.getElementById('lng').value;
			document.getElementById("mapselecthome").style.display="none";
			document.getElementById("mapselectwork").style.display="block";
			document.getElementById('pTitle').innerHTML="Where do you work?";
		  	message="<p>Well done!<br><br>Next, please tell us where you work.</p>";
		  	document.getElementById('location').value="Company name, city";
		  	openconfirm();
			}

// this function parses/stores the home address and then moves to the work address

		function enrollwork(){
			localStorage.wadd1=localStorage.add1;
			localStorage.wstate=localStorage.state;
			localStorage.wcity=localStorage.city;
			localStorage.wzip=localStorage.zip;
			localStorage.wcountry=localStorage.country;
			localStorage.wlat=document.getElementById('lat').value;
			localStorage.wlng=document.getElementById('lng').value;
			nav('enroll','fbp');
			}
			
// below are the facebook functions.  they are optimized purely for the enrollment flow to get data from the user.
// they are loaded from calling facebook();

		function facebook(){
		  document.getElementById('login').style.display="block";
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
			   localStorage.response=JSON.stringify(response);
			   localStorage.first_name=response.first_name;
			   localStorage.last_name=response.last_name;
			   localStorage.image="https://graph.facebook.com/" + response.id + "/picture";
			   localStorage.fbid=response.id;
			   localStorage.email=response.email;
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
				"profileblob": localStorage.response,
				}
				
			var jsondataset = JSON.stringify(dataset);
		
		    var request=$.ajax({
                url: "/ridezu/api/v/1/users",
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

        function setHeaderUser(xhr) {
            xhr.setRequestHeader("X-Signature", "f8435e6f1d1d15f617c6412620362c21");
            xhr.setRequestHeader("Content-Type", "application/json");
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
				url="/ridezu/api/v/1/rides/search/fbid/"+fbid+"/searchroute/"+route+"/searchdate/"+date+"/"+role;
			  }
				
			  if(route==undefined){
				url="/ridezu/api/v/1/rides/search/fbid/"+fbid+"/"+role;
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
		  mw=$(this).innerWidth()-20;
		  mw=480;

		  xstartlatlong="http://maps.googleapis.com/maps/api/staticmap?center="+rlist.startlatlong+"&zoom=13&size="+mw+"x100&maptype=roadmap&markers=color:green%7C%7C"+rlist.startlatlong+"&sensor=false";
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

			   if(role=="driver"){ridelist=ridelist+"<a href=\"#\" onclick=\"selectdriver('"+key+"');\"><li>";icon="car";}
			   if(role=="rider"){ridelist=ridelist+"<a href=\"#\" onclick=\"selectrider('"+key+"');\"><li>";icon="person";}

			   ridelist=ridelist+"<span>"+key+"</span>";  
			   timeslot=value;
			   x1=timeslot.length;
			   x2=value[0].rideid;
			   if(x1>0 && x2!=null){
				 ridelist=ridelist+"<div id=\""+icon+"\">"+x1+"</div>";  
				 };
			   ridelist=ridelist+"</div></li></a>";
			   }
		  });
			document.getElementById('ridelist1').innerHTML=ridelist;
			loading(p);	  
		  }
		  
// once you've selected a time slot, this paints the list of available drivers to ride with (used by riders)
		
		function selectdriver(timeslot){

			eventtime=rlist.rideList[timeslot][0].eventtime;		
			x=rlist.rideList[timeslot][0].fbid;

			if(x!=null){
			var personlist="<ul>";
			var r=0;
			ridegroup=rlist.rideList[timeslot];
			$.each(ridegroup, function(key, value) { 
					personlist=personlist+"<a href=\"#\" onclick=\"authselectride('"+timeslot+"','"+value.rideid+"','"+value.fbid+"','"+value.name+"','"+x+"');\">";
					personlist=personlist+"<li class='driver'><image class='profilephoto' src='https://graph.facebook.com/"+value.fbid+"/picture'/><p>"+value.name;
					personlist=personlist+"</p></li></a>";
			});
			personlist=personlist+"</ul>";
			document.getElementById("personlist1").innerHTML=personlist;
			document.getElementById("r1").style.display="none";
			document.getElementById("r2").style.display="block";
		}
			else {authselectride(timeslot,0,0,0,eventtime);}
		}

// this auths the specific ride (used by riders)

		function authselectride(timeslot,rideid,driverfbid,pname,eventtime){
			localStorage.timeslot=timeslot;
			localStorage.rideid=rideid;
			localStorage.driverfbid=driverfbid;
			localStorage.pname=pname;
			localStorage.eventtime=eventtime;			
			
			message="<h2>New Ride Request</h2><p>Click OK to confirm your ride request.</p>";
			confirmfunction="selectride";
			showcancel=true;	
			openconfirm();			
			}

// this picks the specific ride (used by riders)
		
		function selectride(){
			timeslot=localStorage.timeslot;
			rideid=localStorage.rideid;
			driverfbid=localStorage.driverfbid;
			pname=localStorage.pname;
			eventtime=localStorage.eventtime;
			
			document.getElementById("r1").style.display="none";
			document.getElementById("r2").style.display="none";
			fbid=localStorage.fbid;
			
			//if picking an empty slot
			if(rideid==0){

			   	 fbid=localStorage.fbid;
				 
				 url="/ridezu/api/v/1/rides/rider";
	 
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
   
			   url="/ridezu/api/v/1/rides/rideid/"+rideid+"/rider";
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
			personlist="<ul>";
			r=0;
			ridegroup=rlist.rideList[timeslot];
			$.each(ridegroup, function(key, value) { 
					personlist=personlist+"<a href=\"#\" onclick=\"authselectrider('"+timeslot+"','"+value.rideid+"','"+value.fbid+"','"+value.name+"','"+eventtime+"');\">";
					personlist=personlist+"<li class='driver' id=\"l"+value.fbid+"\"><image src='https://graph.facebook.com/"+value.fbid+"/picture'/><p>"+value.name;
					personlist=personlist+"</p></li></a>";
			});
			personlist=personlist+"</ul>";
			document.getElementById("rpersonlist1").innerHTML=personlist;
			document.getElementById("r1").style.display="none";
			document.getElementById("r2").style.display="block";
		}
			else {authselectrider(timeslot,0,0,0,eventtime);}
		}

// this auths the specific ride (used by drivers)

		function authselectrider(timeslot,ride,fbid1,pname,eventtime){
			localStorage.timeslot=timeslot;
			localStorage.ride=ride;
			localStorage.fbid1=fbid1;
			localStorage.pname=pname;
			localStorage.eventtime=eventtime;			
			
			message="<h2>New Ride</h2><p>Click OK to confirm your ride.</p>";
			confirmfunction="selectrider1";
			showcancel=true;	
			openconfirm();
			}

// this picks the specific ride (used by drivers)
		
		function selectrider1(){			
			timeslot=localStorage.timeslot;
			ride=localStorage.ride;
			fbid1=localStorage.fbid1;
			pname=localStorage.pname;
			eventtime=localStorage.eventtime;
			
			//if picking an empty slot (for drivers)

			if(ride==0){

			   	 fbid=localStorage.fbid;
				 
				 url="/ridezu/api/v/1/rides/rider";
	 
				 var dataset = {
					 "fbid":	fbid,
					 "eventtime": eventtime,
					 "route": rlist.route
					 }				
	 
				 var jsondataset = JSON.stringify(dataset);
	 
				 var request=$.ajax({
					 url: "/ridezu/api/v/1/rides/driver",
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
					 url="/ridezu/api/v/1/rides/rideid/"+ride+"/driver";
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

// reuest a new ride (from an existing ride request)

		function newride(){
			document.getElementById("r2").style.display="none";
			document.getElementById("r3").style.display="none";
			document.getElementById("r4").style.display="none";
			document.getElementById("r1").style.display="block";
			}
		
//  this is part of login functionality (for testing) which pulls up the user list
		
		function getuserlist(){
		  $.ajax({
		  url: "/ridezu/api/v/1/users",
		  cache: false,
		  dataType: "json"
		  }).done(function(data) {
			userdata=data;
			paintuserlist();	
			  });
		}

// this function paints all the users

		function paintuserlist(){
		  
		  var userlist="<ul>";
		  var r=0;
		  
		  $.each(userdata, function(key, value) {
			userlist=userlist+"<li><div class=\"rarrow\" onclick=\"selectuser('"+r+"');\">";
			r++;
			userlist=userlist+"<span style='padding-left:10px'>"+value.fname+" "+value.lname+": "+value.fbid+"</span>";  
			var timeslot=value;
			userlist=userlist+"</div></li>";
		  });
		  
			userlist=userlist+"</ul>";
		  
			document.getElementById('userlist1').innerHTML=userlist;
			loading(p);	    
		  }
		
//once a user is selected this function loads local variables with all the correct data
		
		function selectuser(id){
			localStorage.seckey=userdata[id].seckey;
			localStorage.fbid=userdata[id].fbid;
			localStorage.first_name=userdata[id].fname;
			localStorage.last_name=userdata[id].lname;
			localStorage.hadd1=userdata[id].add1;
			localStorage.hcity=userdata[id].city;
			localStorage.hstate=userdata[id].state;	
			localStorage.hzip=userdata[id].zip;
			localStorage.wadd1=userdata[id].workadd1;
			localStorage.wcity=userdata[id].workcity;
			localStorage.wstate=userdata[id].workstate;	
			localStorage.wzip=userdata[id].workzip;
			localStorage.email=userdata[id].email;
			localStorage.originlatlong=userdata[id].originlatlong;
			localStorage.destlatlong=userdata[id].destlatlong;
			localStorage.homelatlong=userdata[id].homelatlong;
			localStorage.worklatlong=userdata[id].worklatlong;
			nav('loginp','mainp');
		}
		
// this function parses an eventtime into smaller parts

		function evtime(etime1){
			t = etime1.split(" ");
			h = t[1].split(":");
			h1= h[0];
			if(h1>12){
				h1=h1-12;h3="pm";
				}
			else 
				{
				h3="am";
				}
			etime = h1+":"+h[1]+h3;
			return etime;
		} 

// this is the my rides page, myridesp.  lots of use cases here

// gets a list of myrides
		
		function myrides(){
		  	  fbid=localStorage.fbid;
		  	  mrlist="";		  
			  url="/ridezu/api/v/1/rides/search/fbid/"+fbid;
			
			  $.ajax({
			  url: url,
			  cache: false,
			  dataType: "json"
			  }).done(function(data) {
				mrlist=data;
				paintmyrides();						
				  });
		}

// paint a specific myride (option input = rideid).  this is fairly complex functionality which loops throough
// all rides and decides to 1) paint a selected ride (if sent in to function) 2) paint the first ride 
// or 3) if no rides available then show call to action for post a ride or request a ride.  

		function paintmyrides(rideid){		
		  fbid=localStorage.fbid;
		  z=0;

		  if(mrlist["Driver"]){z=z+mrlist["Driver"].length;}
		  if(mrlist["Rider"]){z=z+mrlist["Rider"].length;}
		  		  
		  $.each(mrlist, function(key, value) {
		  		  
		  		x0=key;
		  
		  		$.each(mrlist[key], function(key1, value1) {
			  		x1=key1;
 				  	value1=mrlist[x0][x1];
			  		
			  		if(value1.rideid==rideid){return false;}
			  		if(rideid===undefined){return false;}

			  	});			
			  	
	    	});

			if(z>0){

 			  	value1=mrlist[x0][x1];
				
				if(z>1){
					  sm="<a href='#' onclick='showallrides();'>Show all rides.</div>";
					  document.getElementById('showmore').innerHTML=sm;
					  }
			  		   				
				if(value1.day!="Today"){
					  x=" on ";
					  }
					  else{
					  x=" today";
					  }
				document.getElementById('godate').innerHTML=x;
				document.getElementById('leavetime').innerHTML=evtime(value1.eventtime);
				rideid=value1.rideid;
								
				x="";
	   
				if(value1.route=="h2w"){
					  document.getElementById('origindesc').innerHTML="Home";
					  document.getElementById('destdesc').innerHTML="Work";
					  } 
					  
					  else {
					  document.getElementById('origindesc').innerHTML="Work";
					  document.getElementById('destdesc').innerHTML="Home";
					  }
		        mw=$(this).innerWidth()-20;
		        mw=480;

				xoriginlatlong="http://maps.googleapis.com/maps/api/staticmap?center="+value1.startlatlong+"&zoom=13&size="+mw+"x100&maptype=roadmap&markers=color:green%7C%7C"+value1.startlatlong+"&sensor=false";
				document.getElementById('ridedesta').src=xoriginlatlong;		  		  
				document.getElementById('amount').innerHTML=value1.amount;
				document.getElementById('gassavings').innerHTML=value1.gassavings;
				document.getElementById('co2').innerHTML=value1.co2;
								
				if(value1.eventstate=="EMPTY" || value1.eventstate=="REQUEST"){
					x="<li>We haven't found a match yet.<li>";
				}

				if(value1.eventstate=="ACTIVE" || value1.eventstate=="FULL"){
					x="";
					n=value1.reffbid.split("#");
					
					$.each(n, function(key2, value2) {
							m=value2.split("|");
							x=x+"<li class='driver'><image class='profilephoto' src='https://graph.facebook.com/"+m[0]+"/picture'/><p>"+m[1];
							x=x+"</p></li>";
					});
				}
				
			   document.getElementById('ridelist1').innerHTML=x;		  	
			   document.getElementById('allrides').style.display="none";
			   document.getElementById('r0').style.display="block";
			   document.getElementById('r1').style.display="block";	  	
			   b="<input type=\"submit\" onclick=\"runninglate('"+rideid+"');\" class=\"primarybutton\" value=\"I'm running late!\"/>";
			   b=b+"<input type=\"submit\" onclick=\"cancelride('"+rideid+"');\" class=\"primarybutton\" value=\"Cancel Ride\"/></div>";
			   document.getElementById('myrideaction').innerHTML=b;
		  	
		  	}
		  	
		  	if(z==0){
			   document.getElementById('noride').style.display="block";
		  	}
		document.getElementById(p).style.display="block";	    
	}

// this function shows all rides that a user has

		function showallrides(){		
		  fbid=localStorage.fbid;
		  riders=0;
		  drivers=0;
		  if(mrlist["Driver"]){drivers=mrlist["Driver"].length;}
		  if(mrlist["Rider"]){riders=mrlist["Rider"].length;}
		  imdrivinglist="";
		  imridinglist="";

		  if(drivers>0){
		  
		    	document.getElementById('imdriving').style.display="block";	 
		  		$.each(mrlist["Driver"], function(key3, value3) {
					value3=mrlist["Driver"][key3];
					if(value3.route=="h2w"){rte="<img style='width:12px;' src='../images/end.png' /> Work";}
					if(value3.route=="w2h"){rte="<img style='width:12px;' src='../images/start.png' /> Home";}
					etime=evtime(value3.eventtime);
					imdrivinglist=imdrivinglist+"<a href=\"#\" onclick=\"paintmyrides('"+value3.rideid+"')   \"><li><span class='date'>"+value3.day+"</span><span class='time'> "+etime+" <span class='dest'>"+rte+"</span></li></a>";				
			  	});
	  		  
		  	 }
		  	 
		  if(riders>0){
		    	document.getElementById('imriding').style.display="block";	 		  		  
		  		$.each(mrlist["Rider"], function(key4, value4) {
					value3=mrlist["Rider"][key4];
					if(value4.route=="h2w"){rte="<img style='width:12px;' src='../images/end.png' /> Work";}
					if(value4.route=="w2h"){rte="<img style='width:12px;' src='../images/start.png' /> Home";}
					etime=evtime(value4.eventtime);
					imridinglist=imridinglist+"<a href=\"#\" onclick=\"paintmyrides('"+value4.rideid+"')   \"><li><span class='date'>"+value4.day+ "</span><span class='time'> "+etime+" </span><span class='dest'>"+rte+"</span></li></a>";				
			  	});


		  	 }

		  document.getElementById('r0').style.display="none";	 
		  document.getElementById('r1').style.display="none";	 
		  document.getElementById('imdrivingrides').innerHTML=imdrivinglist;	 
		  document.getElementById('imridingrides').innerHTML=imridinglist;	 
		  document.getElementById('allrides').style.display="block";	 
		  	 
		  }	  
		  
// this function set(2) cancels a ride for a user

		function cancelride(rideid){	
			message="<h2>Cancel Ride</h2><p>Are you sure you want to cancel this ride?<br><br>This cannot be undone.</p>";
			localStorage.rideid=rideid;
			confirmfunction="cancelconfirm";
			okmessage="Cancel Ride";	
			cancelmessage="< Back";	
			showcancel=true;	
			openconfirm();
		}	

		function cancelconfirm(rideid){	
			fbid=localStorage.fbid;
			rideid=localStorage.rideid;
		    url="/ridezu/api/v/1/rides/rideid/"+rideid+"/fbid/"+fbid;
		    var request=$.ajax({
                url: url,
                type: "DELETE",
                dataType: "json",
                success: function(data) {
                	p="mainp";
                	nav(p,'myridesp');},
                error: function(data) { alert("Rats - I could not cancel this. "+JSON.stringify(data)); },
                beforeSend: setHeaderUser
            });
		}	

// this function set relates to being late

		function notlate(){
			   document.getElementById('r0').style.display="block";
			   document.getElementById('r1').style.display="block";			
			   document.getElementById('rlate').style.display="none";			
		}

		function runninglate(id){
			   document.getElementById('r0').style.display="none";
			   document.getElementById('r1').style.display="none";			
			   document.getElementById('rlate').style.display="block";			
		}

// this function set populates the page for the profile page
// step1 get the user 

		function profile(fbid){
			userfbid=fbid;
			navt('',userprofilep);
			}

// this function paints the user profile page

		function paintuserprofile(){
			if(userinfo.consistency==null){userinfo.consistency="Not yet rated"};
			if(userinfo.timeliness==null){userinfo.timeliness="Not yet rated"};
			if(userinfo.carmaker==null){userinfo.carmaker="N/A"};
			document.getElementById('profilephoto').src="https://graph.facebook.com/"+userinfo.fbid+"/picture";	
			document.getElementById('workcity').innerHTML=userinfo.workcity;	
			document.getElementById('quote').innerHTML=userinfo.profileblob.quotes;
			document.getElementById('city').innerHTML=userinfo.city;	
			document.getElementById('cartype').innerHTML=userinfo.carmaker;	
			document.getElementById('username').innerHTML=userinfo.fname+" "+userinfo.lname;	
			document.getElementById('co2').innerHTML=userinfo.co2balance;	
			document.getElementById('trips').innerHTML=parseInt(userinfo.ridesoffered)+parseInt(userinfo.ridestaken);
			document.getElementById('consistency').innerHTML=userinfo.consistency;
			document.getElementById('timeliness').innerHTML=userinfo.timeliness;

			if(userinfo.frontphoto){
				document.getElementById('frontphoto').src="http://ridezu.s3.amazonaws.com/"+myinfo.frontphoto;
				document.getElementById('mywheels').style.display="block";			
				}
							
			if(userinfo.profileblob.bio){
				document.getElementById('aboutmetext').innerHTML=userinfo.profileblob.bio;
				document.getElementById('aboutme1').style.display="block";
				}	

			if(userinfo.profileblob.work){
				worklist="";
				$.each(userinfo.profileblob.work, function(key, value) {

				  if(value.employer){employer=value.employer.name;}
				  		else{employer="";}

				  if(value.position){position=", "+value.position.name;}
				  		else{position="";}

				  worklist=worklist+"<div><p><strong>"+employer+"</strong>"+position+"</p></div>";				  
				});			
				document.getElementById('wlist').innerHTML=worklist;				
				document.getElementById('work').style.display="block";
				}

			if(userinfo.profileblob.education){
				edulist="";
				x=userinfo.profileblob.education;
				y=x.reverse();

				$.each(y, function(key, value) {
				  edulist=edulist+"<li>";

				  if(value.school){
				  		edulist=edulist+"<strong class='educationsub'>"+value.school.name+"</strong>";
				  		}

				  if(value.year){
				  		edulist=edulist+"<p class='educationdescription'>Class of "+value.year.name;
				  		}

				  if(value.degree || value.concentration){edulist=edulist+" &#8226; ";} 

				  if(value.degree){
				  		edulist=edulist+value.degree.name;
				  		}				  

				  if(value.degree){edulist=edulist+" &#8226; ";} 

				  if(value.concentration){edulist=edulist+value.concentration[0].name;
				  		}
				  edulist=edulist+"</li>";
				  		  		
				});		
				document.getElementById('education').style.display="block";
				document.getElementById('elist').innerHTML=edulist;				
				}
			loading("temp");	    
			}

// this function paints the images on ride details

		function ridedetails(){
			fbid=localStorage.fbid;
			
			if(myinfo.frontphoto!=null){
				front="http://ridezu.s3.amazonaws.com/"+myinfo.frontphoto;}
				else {
				front="../images/upload.png";
				}
				
			document.getElementById('frontview').src=front;
			document.getElementById('fbid').value=fbid;
			
			if(myinfo.isLuxury=="Y"){document.getElementById('luxurycar').checked="checked";}
			
			setSelectedIndex(document.getElementById('cartype'),myinfo.cartype);
			setSelectedIndex(document.getElementById('carmaker'),myinfo.carmaker);
			setSelectedIndex(document.getElementById('seats'),myinfo.seats);

			loading("temp");	    
			}
		
		function newridedetails(){
			myinfo.cartype=document.getElementById('cartype').value;
			myinfo.carmaker=document.getElementById('carmaker').value;
			myinfo.isLuxury=document.getElementById('luxurycar').value;
			myinfo.seats=document.getElementById('seats').value
			updateuserflag=true;
			}

// this function sets a selected index on a dropdown

		function setSelectedIndex(s, v) {
			for ( var i = 0; i < s.options.length; i++ ) {
				if ( s.options[i].text == v ) {
				   s.options[i].selected = true;
				   return;				   
				}
			}
		}

// this function set set is for image uploads (car and photo)

		function startUpload(){
			  document.getElementById('loadbutton').style.display = 'none';
			  document.getElementById('uploadprocess').style.display = 'block';
			  return true;
		}
		
		function stopUpload(success){
			  if(success){
				 obj = JSON.parse(success);
				 x=obj.type;
				 if(x=="front"){
				 	myinfo.frontphoto=obj.image;
					document.getElementById("frontview").src = "http://ridezu.s3.amazonaws.com/"+myinfo.frontphoto;
					}
				 if(x=="back"){
				 	myinfo.backphoto=obj.image;
					document.getElementById("backview").src = "http://ridezu.s3.amazonaws.com/"+myinfo.backphoto;
					}
				 if(x=="right"){
				 	myinfo.rightphoto=obj.image;
					document.getElementById("rightview").src = "http://ridezu.s3.amazonaws.com/"+myinfo.rightphoto;
					}
				 if(x=="left"){
				 	myinfo.leftphoto=obj.image;
					document.getElementById("leftview").src = "http://ridezu.s3.amazonaws.com/"+myinfo.leftphoto;
					}
				 if(x=="user"){
				 	myinfo.userphoto=obj.image;
					document.getElementById("userphoto").src = "http://ridezu.s3.amazonaws.com/"+myinfo.userphoto;
					}
				 updateuserflag=true;
				 }
			  document.getElementById('uploadprocess').style.display = 'none';
			  document.getElementById('loadbutton').style.display = 'block';      
			  return true;   
		}

// this function set is for the home profile page (first half = update home / second half = pick a place close to you)

		function homeprofileinit(){
			document.getElementById('r1').style.display="block";
			document.getElementById('add1').innerHTML=myinfo.add1;
			document.getElementById('city').innerHTML=myinfo.city;
		  	xstartlatlong="http://maps.googleapis.com/maps/api/staticmap?center="+myinfo.homelatlong+"&zoom=13&size="+300+"x100&maptype=roadmap&markers=icon:/images/basehmarker.png%7C"+myinfo.homelatlong+"&sensor=false";
			document.getElementById('mapa').src=xstartlatlong;
		  	x1startlatlong="http://maps.googleapis.com/maps/api/staticmap?center="+myinfo.originlong+"&zoom=13&size="+300+"x100&maptype=roadmap&markers=icon:/images/basepmarker.png%7C"+myinfo.originlatlong+"&sensor=false";
			document.getElementById('mapb').src=x1startlatlong;
			document.getElementById('pickupname').innerHTML=myinfo.origindesc;
			loading("temp");	    
			}

		function pickhome(){ 
			document.getElementById('r1').style.display="none";
			document.getElementById('r2').style.display="block";			
			x = myinfo.homelatlong;
			y = x.split(",");
			myspot = new google.maps.LatLng(y[0],y[1]);
			localStorage.pick="home";
			loadMap("pick",myspot,18,"home");
			}
			
		function pickpickup(){
			document.getElementById('r1').style.display="none";
			document.getElementById('r2').style.display="block";			
			x = myinfo.homelatlong;
			y = x.split(",");
			myspot = new google.maps.LatLng(y[0],y[1]);
			localStorage.pick="pickup";
			loadMap("pickselect",myspot,12,"home");
			}

		function updatehome(){
		
			if(localStorage.pick=="home"){
				 myinfo.add1=localStorage.add1;
				 myinfo.state=localStorage.state;
				 myinfo.city=localStorage.city;
				 myinfo.zip=localStorage.zip;
				 myinfo.country=localStorage.country;
				 myinfo.homelatlong=localStorage.lat+","+localStorage.lng;
				 }
			
			if(localStorage.pick=="pickup"){
				 myinfo.originlatlong=localStorage.lat+","+localStorage.lng;
				 myinfo.origindesc=localStorage.desc;
				 }
					 
			updateuserflag=true;
			document.getElementById('r2').style.display="none";	
			homeprofileinit();
			}

// this function set is for the work profile page

		function workprofileinit(){
			document.getElementById('r1').style.display="block";
			document.getElementById('workname').innerHTML=myinfo.destdesc;
			document.getElementById('workadd1').innerHTML=myinfo.workadd1;
			document.getElementById('workcity').innerHTML=myinfo.workcity;
		  	xstartlatlong="http://maps.googleapis.com/maps/api/staticmap?center="+myinfo.destlatlong+"&zoom=13&size="+300+"x100&maptype=roadmap&markers=icon:/images/basecmarker.png%7C"+myinfo.destlatlong+"&sensor=false";
			document.getElementById('mapa').src=xstartlatlong;
			loading("temp");	    
			}
			
		function pickwork() {
			document.getElementById('r1').style.display="none";
			document.getElementById('r2').style.display="block";			
			x = myinfo.destlatlong;
			y = x.split(",");
			myspot = new google.maps.LatLng(y[0],y[1]);
			localStorage.pick="work";
			loadMap("pickselect",myspot,18,"work");		
			}
			
		function updatework(){
			myinfo.worklatlong=localStorage.lat+","+localStorage.lng;			
			myinfo.destlatlong=localStorage.lat+","+localStorage.lng;
			myinfo.destdesc=localStorage.desc;
			updateuserflag=true;
			document.getElementById('r2').style.display="none";	
			workprofileinit();
			}			

// this function is for driver verification

// note: see http://www.daftlogic.com/information-programmatically-preselect-dropdown-using-javascript.htm for a clean example on how to select a checkbox.

		function dverifyinit(){
			if(myinfo.dlverified=="yes"){
				document.getElementById('c1').checked=true;
				document.getElementById('c2').checked=true;
				document.getElementById('c3').checked=true;
				document.getElementById('c4').checked=true;
				}
			loading("temp");	    
		}

		function dverify(){
			cb1=$('#c1:checked').val();
			cb2=$('#c2:checked').val();
			cb3=$('#c3:checked').val();
			cb4=$('#c4:checked').val();
			if(cb1=="on" && cb2=="on" && cb3=="on" && cb4=="on"){
				updateuserflag=true;
				myinfo.dlverified="yes";
				message="<p>Thanks! You're all set</p>";
				openconfirm();
				updateuserflag=true;
				}
				else
				{
				message="<p>Please agree to all terms.  Thanks!</p>";
				openconfirm();
				}
			}

// this function is for contact info

		function contactinfoinit(){
			document.getElementById('email').value=myinfo.email;
			document.getElementById('phone').value=myinfo.phone;
			document.getElementById('name').value=myinfo.fname+" "+myinfo.lname;			
			loading("temp");	    
			}

		function contactinfo(){
			myinfo.email=document.getElementById('email').value;
			myinfo.phone=document.getElementById('phone').value;
			name=getElementById('name').value;
			fn=name.split(" ");
			myinfo.fname=fn[0];
			myinfo.lname=fn[1];
			updateuserflag=true;
			}
			
// this function set are the account management functions

		function account(){
        	fbid=localStorage.fbid;
        	timeperiod="Y";
		    url="/ridezu/api/v/1/account/summary/fbid/"+fbid+"/timeperiod/"+timeperiod;
		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {
                	paintaccount(data); },
                error: function(data) { alert("Yikes, I am not getting any account data."+JSON.stringify(data)); },
                beforeSend: setHeaderUser
            });
        }

		function paintaccount(data){
			document.getElementById('credits').innerHTML=curr(data.account.totalcredit);
			document.getElementById('charges').innerHTML=curr(data.account.totaldebit);
			balance1=+data.account.totalcredit - +data.account.totaldebit;

			if(balance1>0){legend="driver"} else {legend="rider"}

			balance=curr(balance1);

			if(legend=="driver"){legendtext="Balance:  "+balance;} else {legendtext="Savings: 25%";}

			document.getElementById('balance').innerHTML=legendtext;
			document.getElementById('total').innerHTML=balance;				
			document.getElementById('trips').innerHTML=addCommas(data.account.totaltrips);
			document.getElementById('co2').innerHTML=addCommas(data.account.totalco2);
			document.getElementById('miles').innerHTML=addCommas(data.account.totalmiles);
			document.getElementById('savings').innerHTML=curr(data.account.totalgassavingspercent);
			document.getElementById('passengers').innerHTML=addCommas(data.account.totalpassengers);
			loading(p);	    		
		}

		function accountdetail(){
        	fbid=localStorage.fbid;
        	timeperiod="Y";
		    url="/ridezu/api/v/1/account/detail/fbid/"+fbid+"/timeperiod/"+timeperiod;
		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {
                	paintaccountdetail(data); },
                error: function(data) { alert("Yikes, I am not getting any account data."+JSON.stringify(data)); },
                beforeSend: setHeaderUser
            });
        }

		function paintaccountdetail(data){

			if(balance1>0){legend="driver"} else {legend="rider"}
			balance=curr(balance1);
			if(legend=="driver"){legendtext="Balance:  "+balance;} else {legendtext="Savings: 25%";}
			document.getElementById('balance').innerHTML=legendtext;

			

		}



// this function set updates PayPal payout information

		function payoutinfoinit(){
			document.getElementById('paypalemail').value=myinfo.paypalemail;			
			document.getElementById("temp").style.display="block";	    
			}

		function payoutinfo(){
			myinfo.paypalemail=document.getElementById('paypalemail').value;
			updateuserflag=true;
			}

// this function set is for notification preferences
	
		function notifyinit(){
			if(myinfo.notificationmethod=="0"){	document.getElementById("notifyemail").checked="checked";}	    
			if(myinfo.notificationmethod=="1"){	document.getElementById("notifysms").checked="checked";	 }   
			if(myinfo.notificationmethod=="2"){	document.getElementById("notifyios").checked="checked";	}    
			if(myinfo.ridereminders=="1"){document.getElementById("ridereminder").checked="checked";}	    
			}

		function notify(){
			if(document.getElementById("notifyemail").checked==true){myinfo.notificationmethod="0";}	
			if(document.getElementById("notifysms").checked==true){myinfo.notificationmethod="1";}	
			if(document.getElementById("notifyios").checked==true){myinfo.notificationmethod=2;}	
			if(document.getElementById("ridereminder").checked==true){myinfo.ridereminders="1";}	
			if(document.getElementById("ridereminder").checked==false){myinfo.ridereminders="0";}	
			updateuserflag=true;
			}
					
// these are the functions which initialize and start the ridezu web app.  please keep everything after this line at the end of this page, and functions before this.

// declare global variables. There is still some locaStorage, this should be replaced largely w/global vars.

  		var map; 
  		var m={}; 
	    var geocoder;
	    var myspot;
	    var requestride;
	    var userdata;
	    var mrlist;
	    var nodelist;
	    var userinfo={};
	    var myinfo={};
	    var etime;
	    var userfbid;
		var message;
		var okmessage="OK";
		var cancelmessage="Cancel";
		var confirmfunction="";
		var showcancel=false;
		var screenwidth=screen.width;
		var screenheight=screen.height;
		var updateuserflag=false;
		var tp="";
		var p="firstp";
		var balance1;

		  		
// page titles are the pageid's coupled with what shows up in the header
  		
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
  			"myridesp":"My Rides",			
  			"loginp":"Login - Test Page",			
  			"homeprofilep":"Home Details",			
  			"workprofilep":"Work Details",			
  			"constactinfop":"Contact Info",			
  			"driverp":"Driver Verification",			
  			"ridedetailsp":"My Wheels",			
  			"paymentp":"Payment Info",			
  			"payoutp":"Payout Info",			
  			"notifyp":"Notifications",			
  			"userprofilep":"Profile",			
  			"pricingp":"Pricing"			
			};

// this watches for orientation change and makes any site changes, if needed

		window.addEventListener('orientationchange', handleOrientation, false);
		   function handleOrientation() {
			   if (orientation == 0 || orientation == 180) {
							  screenwidth=screen.width;
							  screenheight=screen.height;
							  //var n=str.replace("replace*Microsoft","with*W3Schools");

			   }
			   else if (orientation == 90|| orientation == -90) {
							  screenwidth=screen.height;
							  screenheight=screen.width;
			   }
			   else {
			   }
			   }

// this determines if the user is in the system, or not (by looking at local storage).  if not, send them to enroll...  also see the very top of index1.php for first page logic


$(document).ready(function() {
	fbid=localStorage.fbid;
	if(fbid!=undefined){
	  loadmyinfo();	 
	  nav("firstp",startpage);
	  $(document).ready(function() {
		  document.getElementById("w").style.display="block";
		});
	}
	else
	{
	  nav("firstp","startp");
	  	  $(document).ready(function() {
		  document.getElementById("w").style.display="block";	 
		});
	}
	
 });