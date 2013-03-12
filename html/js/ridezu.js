// these are all custom functions used by ridezu.  these are here temporarily and should all be moved to ridezu.js (they should also be minified)

// this function loads the current user in a js object, this function is used for all the profile functions 

		function loadmyinfo(){
		    fbid=localStorage.fbid;
		    url="/ridezu/api/v/1/users/search/fbid/"+fbid;
		    var request=$.ajax({
                url: url,
                type: "GET",
			    cache: false,
                dataType: "json",
                success: function(data) {
					myinfo=data;
					nav("firstp",startpage);
					if(tm=="1"){showdetail();}
				    $(document).ready(function() {
		  				document.body.style.display="block";
						});
			    	},
                error: function(data) {
                	alert("Uh oh - is this a valid id?"+JSON.stringify(data)); 
					reporterror(url);
					nav("firstp",startpage);
				    $(document).ready(function() {
		  				document.body.style.display="block";
						});                	
                	},
                beforeSend: setHeader
            });
		}
  				
// this function loads all user data in a js object, this function is used when looking at another user 

		function loaduser(fbid){
		    loading();
		    url="/ridezu/api/v/1/users/searchpublic/fbid/"+fbid;
		    var request=$.ajax({
                url: url,
                type: "GET",
			    cache: false,
                dataType: "json",
                success: function(data) {
					userinfo=data;
					paintuserprofile();
				    doneloading();
			    	},
                error: function(data) { 
                	doneloading();
                	alert("Uh oh - does this user exist?"+JSON.stringify(data));reporterror(url); },
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
			    cache: false,
                dataType: "json",
                data: jsondataset,
                success: function(data) {},
                error: function() {
 					alert('uh oh, I could not save this data');reporterror(url) },
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
				message="<p>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<br><br>Ridezu can help.<br><br>By using ridezu you'll collect an estimated <b>$"+ftotrev+"</b> to help offset your gas costs.<br><br>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</p>";
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
					message="<p>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<br><br>Ridezu can help.<br><br>By using ridezu you'll still pay <b>$"+ftotrev+"</b> to get to work, but you'll save <b>$"+fsavings+ "</b> in gas, save the miles from your car, and you'll be so green.<br><br>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</p>";
				}
	
				if(savings<=0){
					message="<p>This year you're going to drive <b>"+ftmiles+"</b> miles. In terms of just gas money this will cost you <b>$"+fcost+"</b>, assuming gas prices don't increase.<br><br>By using ridezu you'll pay <b>$"+ftotrev+"</b> to get to work.  This might be a little more than gas, but you'll save the miles from your car, and you'll be so green.<br><br>ps. You'll also free the Earth of <b>"+ftotcarbon+"</b> pounds of CO2 - whew!</p>";
				}
			}
			openconfirm(); 
		}

// this is a function to determine if the current .js is current (and reload the page if otherwise).  This is used only on iOS and android where the js stays resident.

		function versiontest(){
			var ts1 = Math.round(new Date().getTime() / 1000); 
			var te=ts1-ts;
			
			if(te>86400){ // this checks if the app is older than one day

					url="/getversion.php";
					var request=$.ajax({
						url: url,
						type: "GET",
						dataType: "json",
						success: function(data) {
							//alert(v+":"+data.version+":"+env);
							if(data.version!=v && env!="stage"){
								location.reload(true);
								}
							
							if(data.version==v){
								ts=Math.round(new Date().getTime() / 1000); 
								}
							},
						error: function(data) {
							doneloading();
							alert("Oops.  Something is wrong here:"+JSON.stringify(data));reporterror(url); },
					});			   										  
				
				}
		
			}	
		
// anything with a "nav" is the navigation system. which shows (to) and hides (from) pages as well as invokes specific
// javascript for individual pages to load.   

// function set to link from navigation side window (close window) or from primary windows to eachother

		function nav1(to){
			
			if(client=="mweb"){
				closeme();
			    
			    if(p!=to){
				   nav(p,to);
				   }
			   }
			
			else {
				nav(p,to);
				versiontest();
				}
			}
					
		function nav(from, to){
						
			var online = navigator.onLine;
			
			if(online==false){
			  message="<h2>You're offline.</h2><p>I'm not detecting that you've got internet access.  Please check your access and try again.</p>";
			  openconfirm();
			  return false;			
			}
			
			updateTitle(to);
			document.getElementById('temp').innerHTML="";
			document.getElementById(p).innerHTML="";		
			scrollToTop();					
			url="pages/"+ to + ".php?v="+v;
			$.ajax({
  			url: url,
  			cache: true,
  			dataType: "html"
			}).done(function( html ) {
  				document.getElementById(to).innerHTML=html;
  				document.getElementById(to).style.display="block";	
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
	
		function back(){
			if(tp!==""){
			   tp="";
			   document.getElementById("temp").innerHTML="";
			   updateTitle(p);
			   document.getElementById(p).style.display="block";	    
			   document.getElementById("menub").src="../images/menu.png";
			   return false;
			   }			
			}

		function navt(from, to){
			updateTitle(to);
			document.getElementById(from).style.display="none";		
			showBackButton();
			url="pages/"+ to + ".php?v="+v;
			tp=to;
			$.ajax({
  			url: url,
  			cache: true,
  			dataType: "html"
			}).done(function( html ) {
  				document.getElementById("temp").innerHTML=html;
  				navinit(to);  				
				});
		}
		
// this function initiates a page (runs initial js function so the page can operate)

		function navinit(to){
		
		// this function pushes the page to google analytics
		_gaq.push(['_trackPageview', pageTitles[to]]);
		
			if(to=="aboutp"){
				aboutinit();
				}
				
			if(to=="accountp"){
				account();
				}

			if(to=="calcp"){
				calcinit();
				}
				
			if(to=="contactinfop"){
				contactinfoinit();
				}

			if(to=="congratp"){
				congratinit();
				}

			if(to=="driverp"){
				dverifyinit();
				}

			if(to=="enrollp"){
			  	getLocation();
				}

			if(to=="fbp"){
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

			if(to=="nearbyp"){
				nearbyrides();
				}

			if(to=="notifyp"){
				notifyinit();
				}

			if(to=="payoutp"){
				payoutinfoinit();
				}

			if(to=="paymentp"){
				paymentinfoinit();
				}	
														
			if(to=="ridedetailsp"){
				ridedetails();
				}

			if(to=="ridepostp"){								
				if(myinfo.destdesc==undefined || myinfo.origindesc==undefined){
					nav(to,"myridesp");
					return false;
					}
				getlist("rider");

				$('#timeframe').touchwipe({
					wipeLeft: function(){
						info[rlist.nextdate]=rlist.date;						
						role=info.role;
						getlist(role,rlist.route,rlist.nextdate);					                	 
						 },
					wipeRight: function(){
						if(info[rlist.date]){
							pdate=info[rlist.date];
							role=info.role;
							getlist(role,rlist.route,pdate);
							}                	
						},
			   })
			 }


			if(to=="riderequestp"){
				if(myinfo.destdesc==undefined || myinfo.origindesc==undefined){
					nav(to,"myridesp");
					return false;
					}			
				
				getlist("driver");

				 $('#timeframe').touchwipe({
					wipeLeft: function(){
						info[rlist.nextdate]=rlist.date;						
						role=info.role;
						getlist(role,rlist.route,rlist.nextdate);					                	 
						 },
					wipeRight: function(){
						if(info[rlist.date]){
							pdate=info[rlist.date];
							role=info.role;
							getlist(role,rlist.route,pdate);
							}                	
						},
				})

				}

			if(to=="startp" || p=="startp"){
				//window['optimizely'].push(["activate", 160930926]);
				document.getElementById("topbar").style.display="none";		
				facebook();	    
				}

			if(to=="transactionp"){
				accountdetail();
				}
				
			if(to=="corploginp" || to=="checkpinp"){
				showcompanylogo();
				}

			if(to=="fbconnectp"){
				facebook();
				}

			if(to=="userprofilep"){
				fbid=myinfo.fbid;
				if(userfbid!=""){fbid=userfbid;}
				loaduser(fbid);
				}
			
			if(to=="workprofilep"){
				workprofileinit();
				}

			if(to=="commutep"){
				commuteinit();
				}
				
			if(to=="profilep"){
				profileinit();
				}
				
			if(updateuserflag==true){updateuser();updateuserflag==false;}

		}		

// this function set is for iOS and android for scrolling to top, showing the backbutton, and updating the title in the title bar

		function updateTitle(title){
			if(client=="mweb"){
				document.getElementById('pTitle').innerHTML=pageTitles[title];			
				}
			if(client=="widget"){
				parent.updateTitle(pageTitles[title]);
				}
			if(client=="iOS"){
				a="ridezu://title/update/"+pageTitles[title];
				if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
					window.location.href = a;
					}				
				}
			if(client=="android"){
					window.android.updatetitle(pageTitles[title]);			
				}
			}
			
		function showBackButton(){
			if(client=="mweb"){
				scrollTo(0,0);
				document.getElementById("menub").src="../images/back.png";
				}						
			if(client=="iOS"){
				a="ridezu://backbutton/visible/true";
				if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
					window.location.href = a;
					}
				}						
			if(client=="android"){
					window.android.backbuttonvisible('true');		
				}
			}
			
		function scrollToTop(){
			if(client=="mweb"){scrollTo(0,0);}						
			if(client=="iOS"){
				a="ridezu://window/scrolltotop";
				if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
					window.location.href = a;
					}
				}						
			//no need to scroll to top on android
			}	 

// this function set shows/hides the spinner on ajax calls (or pages that take a while)

		function loading(){
			if(client!="widget"){
				$('#loadingindicator').fadeIn({ duration: 500 });
				}		
			}

		function doneloading(){
			if(client!="widget"){
				$('#loadingindicator').fadeOut({ duration: 500 });		
				}		
			}

// this function set controls the flow of page views where a flow is needed, like enrollment or first rides
		
		function startflow(f){
		
			if(f){flow=f;}
			
			   if(flow=="enroll"){
					
				if(myinfo.fbid==undefined){
					document.getElementById("topbar").style.display="block";
					hidegrabber();						
					nav(p,'fbp');
					return false;
					}

				if(myinfo.workadd1==undefined || myinfo.add1==undefined){
					document.getElementById("topbar").style.display="block";
					hidegrabber();						
					nav(p,'enrollp');
					return false;
					}
					
				if(myinfo.seckey==undefined){
					regnewuser();
					return false;
					}
				 }	
													
			if(flow=="riderequest"){
				//if(myinfo.cardtype==null){
					//message="<p>Before your first ride we're going to need a credit card on file.</p><p>We only bill you for the rides you take.</p><p>Billing is done monthly.  </p>";
					//openconfirm();
					//navt('riderequestp','paymentp');
					//flow="";
					//return false;
					//}
			}
			
			if(flow=="ridepost"){
				
				if(tp!=""){back();}
								
				if(myinfo.cartype==null){
					message="<p>Before you post your first ride, we'd like to know a little about your car, and you'll need to agree to our terms of service.</p>";
					openconfirm();
					navt('ridepostp','ridedetailsp');
					return false;
				}
				
				if(myinfo.dlverified!="Y"){
					navt('ridepostp','driverp');
					flow="";
					return false;
					}
								
			}			
		}
		
// this function derives the correct photo for the user

		function getphoto(id){
					
			if(length.id=="8" || id.indexOf('@') !== -1){
				photo="/images/nopic.jpg";
				}
			
			else {
				photo="https://graph.facebook.com/"+id+"/picture";
				}
			return photo;
			
		}

// this functions set shows/hides the grabber so you can't see it or interact with it

		function hidegrabber(){
			document.getElementById("menu-btn").style.display="none";
			}

		function showgrabber(){
			document.getElementById("menu-btn").style.display="block";
			}		
	
// these two functions show the alert dialog (and process functions, if required)

		function openconfirm(){
			document.getElementById('confirm-message').innerHTML=message;
			document.getElementById('cancel-button').innerHTML=cancelmessage;
			document.getElementById('ok-button').innerHTML=okmessage;
			if(showcancel==true){document.getElementById('cancel-button').style.display="block";document.getElementById('ok-button').style.float="left"}
			if(showcancel==false){document.getElementById('ok-button').style.float="center";}
			$('#confirm-background').fadeIn({ duration: 100 });		
			scrollToTop();
			}
			
		function closeconfirm(action){
			if(action=="ok" && confirmfunction!=""){window[confirmfunction]();}
			document.getElementById('cancel-button').style.display="none";	
			showcancel=false;
			confirmfunction="";
			okmessage="OK";
			cancelmessage="Cancel";
			$('#confirm-background').fadeOut({ duration: 100 });
			scrollToTop();
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
				 info.pickspot=false;

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
  			      	loading();
  			      	fbid=myinfo.fbid;
				    url="/ridezu/api/v/1/users/search/fbid/"+fbid+"/location/"+nodetype;
					var request=$.ajax({
						url: url,
						type: "GET",
						dataType: "json",
					    cache: false,
						success: function(data) {
							nodelist=data;
							doneloading();
							paintnodes(data); },
						error: function(data) { 
							doneloading();
							alert("boo!"+JSON.stringify(data));reporterror(url); },
						beforeSend: setHeader
					});
				}
				
				function paintnodes(nodelist){
				
					$.each(nodelist, function(key, value) {
			  		if(value.type=="Park and Ride"){
			  			icn="../images/basepmarker.png";
			  			}
			  		
			  		if(value.type=="Company"){
			  			icn="../images/basecbmarker.png";
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
						info.lat=b[0];
						info.lng=b[1];
						desc=nodelist[key].name;
						if(nodelist[key].campus!=""){
							desc=desc+" ("+nodelist[key].campus+")";
							}
						info.desc=desc;
						map.setCenter(new google.maps.LatLng(b[0],b[1]));
						document.getElementById("location").value=desc;
						document.getElementById("mapselect").value="Select "+desc;
						info.pickspot=true;
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
    			navigator.geolocation.getCurrentPosition(showPosition, noposition);
    			}
  				else {noposition();}
  				}

		function showPosition(position){
				myspot = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
				loadMap("pick",myspot,9,"work");
				}
  	
		function noposition(){
				myspot = new google.maps.LatLng(37.41412126979139,-122.04459278399656);
				loadMap("pick",myspot,9,"work");	
				}
  		
// this is a map function which places the value of the user location in the text field of location

		function locationselect(location,lat,lng){
			str1 = location.split(',');
			str2 = str1[2].split(" ");
			info.add1=str1[0];
			info.state=str2[1];
			info.city=str1[1];
			info.zip=str2[2];
			info.hcountry=str1[3];
  			document.getElementById('location').value=str1[0]+", "+str1[1];
  			document.getElementById('lat').value=lat;
  			document.getElementById('lng').value=lng;
  			info.lat=lat;
  			info.lng=lng;
		}

// this function parses/stores the home address and then moves to the work address

		function enrollhome(){
			myinfo.add1=info.add1;
			myinfo.state=info.state;
			myinfo.city=info.city;
			myinfo.zip=info.zip;
			myinfo.homelatlong=document.getElementById('lat').value+","+document.getElementById('lng').value;
		  	document.getElementById('location').value="Company name, city";
		  	startflow("enroll");
 			_gaq.push(['_trackPageview', "Enroll - Home Selected"]);
			//window.optimizely.push(['trackEvent', 'address']);
			}

// this function parses/stores the home address and then moves to the work address

		function enrollwork(){
			myinfo.workadd1=info.add1;
			myinfo.workstate=info.state;
			myinfo.workcity=info.city;
			myinfo.workzip=info.zip;
			myinfo.worklatlong=document.getElementById('lat').value+","+document.getElementById('lng').value;
			document.getElementById("mapselecthome").style.display="block";
			document.getElementById("mapselectwork").style.display="none";
			updateTitle("Where do you live?");
 			_gaq.push(['_trackPageview', "Enroll - Work Selected"]);
			loadMap("pick",myspot,9,"home");
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
				
// below is the facebook and authentication set. ;

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
			  }
			}
		  function updateUserInfo(response) {
		   }
		}

		function loginUser2() {    
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
									   document.getElementById("topbar").style.display="block";
									   showgrabber();
									   }
									else {
										startflow("enroll");
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
			 FB.logout();
			 alert("Logged-out");
			 document.getElementById('user-info').innerHTML="";
			 }

		function connectwithfb(){
			 FB.login(function(response) {
			   if (response.authResponse) {

				  FB.api('/me', function(response) {
				  myinfo.profileblob=JSON.stringify(response);

				 if(response.id){
						alert("ok");		   
						   url="/ridezu/api/v/1/users/connectfb/newfbid/"+response.id+"/user_key/"+myinfo.fbid;
						   var request=$.ajax({
							   url: url,
							   type: "GET",
							   cache:false,
							   dataType: "json",
							   success: function(data) {
								   if(data.facebookconnect.text=="success"){
									   localStorage.fbid=response.id;
									   localStorage.seckey=data.facebookconnect.seckey;
									   myinfo.fbid=response.id;
									   myinfo.seckey=data.facebookconnect.seckey;
									   seckey=data.facebookconnect.seckey;
									   fbid=response.id;
									   updateuser();
									   message="Congratulations, you are now connected with Facebook.  From now on, if you need to login, login with Facebook".
									   openconfirm();
									   back();
									   }
								   },
							   error: function(data) { alert("Uh oh - something went wrong."+JSON.stringify(data));reporterror(url) },
							   beforeSend: setHeader
						   });			   										  
						
						}		

			 });


		   		 }
		   	   },{scope: 'email'});
	 		 }
			
// this registers a new user

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
				"campaign": info.camp,
				}
				
			var jsondataset = JSON.stringify(dataset);

		    var request=$.ajax({
                url: "/ridezu/api/v/1/users",
                type: "POST",
                dataType: "json",
			    cache: false,
                data: jsondataset,
                success: function() {},
                error: function() { 
                	reporterror(url);
                	alert("It looks like you are already registered. Please Login.");
                	localStorage.removeItem('fbid');
                	localStorage.removeItem('seckey');
                	document.location.reload(true);      	
                	},
                beforeSend: setHeader
            	}); 
            	
            request.done(function(data) {
				myinfo=data;
				
				//update miles & co2 if possible
				if(myinfo.destlatlong && myinfo.originlatlong){
					calculateDistance();
					}
				
  				localStorage.seckey=myinfo.seckey;
  				localStorage.fbid=myinfo.fbid;
  				flow="";
 				_gaq.push(['_trackPageview', "New User Registration"]);
  				nav(p,'congratp');
  				//window.optimizely.push(['trackEvent', 'reguser']);
				});          				            	     	
       		}
       		
// this is the congratulations page

		function congratinit(){
			document.getElementById("topbar").style.display="block";
			showgrabber();
			if(myinfo.destdesc==undefined || myinfo.origindesc==undefined){
				document.getElementById('strt1').innerHTML="We're putting together routes in your area and will let you know when you can start.<br/><br/>Until then, why don't you take the tour on how it works and complete your profile.";
				}
			if(myinfo.destdesc!=undefined && myinfo.origindesc!=undefined){
				if(myinfo.miles==null){
					calculateDistance();
					}
				document.getElementById('strt1').innerHTML="Good news!  There is a pickup spot near your home that goes right to your office.  Let's get started!";
				document.getElementById('myr').style.display="block";
				}
        	}

// this used to auhtenticate the request

        function setHeader(xhr) {
            xhr.setRequestHeader("X-Id",localStorage.fbid);
            xhr.setRequestHeader("X-Signature",localStorage.seckey);
            xhr.setRequestHeader("Content-Type","application/json");
        }
		
// reverses the route from home to work or work to home

		function reverseroute(){
			if(rlist.route=="h2w"){route="w2h";}
			if(rlist.route=="w2h"){route="h2w";}
			role=info.role;
			document.getElementById("r2").style.display="none";
			document.getElementById("r3").style.display="none";
			document.getElementById("r1").style.display="block";
			getlist(role,route,rlist.date);
			_gaq.push(['_trackPageview', "Reverse Route"]);
		}
 	
// gets a list of riders/drivers
		
		function getlist(role,route,date){
		  	  loading();
		  	  info.role=role;
		  	  fbid=myinfo.fbid;
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
			  dataType: "json",
			  beforeSend: setHeader
			  }).done(function(data) {
		  	  	doneloading();
				rlist=data;
				paintlist();						
				  });
		}
		
// this paints the list of available times & drivers/riders

		function paintlist(preftime){		
		  role=info.role;
		  if(preftime=="1"){
		  	document.getElementById('showall').style.display="none";
		  	document.getElementById('showfewer').style.display="block";
		  	}
		  if(preftime!="1"){
		  	document.getElementById('showall').style.display="block";
		  	document.getElementById('showfewer').style.display="none";
		  	}
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
		  		document.getElementById('origindesc').innerHTML="<img src='images/start.png'/>Home";
				document.getElementById('destdesc').innerHTML="<img src='images/start3.png'/>Work";
				document.getElementById('gotext').innerHTML="go to work";
		  		} 
		  		
		  		else {
		  		document.getElementById('origindesc').innerHTML="<img src='images/start3.png'/>Work";
				document.getElementById('destdesc').innerHTML="<img src='images/start.png'/>Home";
				document.getElementById('gotext').innerHTML="go home";
		  		}
		  xstartlatlong="https://maps.googleapis.com/maps/api/staticmap?center="+rlist.startlatlong+"&zoom=13&size="+mw+"x"+mh+"&maptype=roadmap&markers=icon:http://www.ridezu.com/images/basemarker.png%7C"+rlist.startlatlong+"&sensor=false";
		  document.getElementById('ridedesta').src=xstartlatlong;		  		  
		  document.getElementById('ridedestb').src=xstartlatlong;		  
		  document.getElementById('amount').innerHTML=curr(rlist.amount);
		  
		  var ridelist="";
		  var r=0;

		  $.each(rlist.rideList, function(key, value) {
		  	if(rlist.rideList[key][0].timepreference=="Y"){z=r;}
		  	r++;
		  });
		  
		  r=0;

		  $.each(rlist.rideList, function(key, value) { 			
			r++;
			if((r>z && r<(z+slots)) || preftime=="1"){

			   if(role=="driver"){ridelist=ridelist+"<a onclick=\"selectdriver('"+key+"');\"><li>";icon="car";}
			   if(role=="rider"){ridelist=ridelist+"<a onclick=\"selectrider('"+key+"');\"><li>";icon="person";}

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
					photo=getphoto(value.fbid);
					personlist=personlist+"<li class='driver'><a onclick=\"profile('riderequestp',"+value.fbid+");\">";
					personlist=personlist+"<div id='viewprofile'><image class='profilephoto' src='"+photo+"'/>";
					personlist=personlist+"<p>View Profile</p></div></a>";
					personlist=personlist+"<a onclick=\"authselectride('"+timeslot+"','"+value.rideid+"','"+value.fbid+"','"+value.name+"','"+x+"');\">";
					personlist=personlist+"<div id='selectdriver'><p>"+value.name+"</p></div></a></li>";
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
			info.timeslot=timeslot;
			info.rideid=rideid;
			info.driverfbid=driverfbid;
			info.pname=pname;
			info.eventtime=eventtime;			

		   if(info.driverfbid==myinfo.fbid){
			  message="<h2>Really?</h2><p>You can't book yourself.  That would be silly.</p>";
			  openconfirm();
			  return false;
			  }
			
			//if(myinfo.cardtype!=null){
				message="<h2>New Ride Request</h2><p>Click OK to confirm your ride request.</p>";
				confirmfunction="selectride";
				showcancel=true;	
				openconfirm();			
			//	}

			//if(myinfo.cardtype==null){
			//	startflow("riderequest");		
			//	}

			}

// this picks the specific ride (used by riders)
		
		function selectride(){
						
			timeslot=info.timeslot;
			rideid=info.rideid;
			driverfbid=info.driverfbid;
			pname=info.pname;
			eventtime=info.eventtime;
			fbid=myinfo.fbid;
			
			//if picking an empty slot
			if(rideid==0){

			   	 fbid=myinfo.fbid;
			   	 loading();
		 
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
				     cache: false,
					 dataType: "json",
					 data: jsondataset,
					 success: function(data) {
					 	 if(data.warn){
					 	 	message="<h2>Really?</h2><p>I think you might be trying to overbook yourself.</p>";
					 	 	doneloading();
					 	 	openconfirm();
					 	 	return false;
					 	 	};
					  	 doneloading();
						 document.getElementById("r1").style.display="none";
						 document.getElementById("r2").style.display="none";
						 document.getElementById("ridetimea").innerHTML=timeslot;
						 document.getElementById("ridepickupa").innerHTML=rlist.start;
						 document.getElementById("r3").style.display="block";
						 },
					 error: function(data) {
					 	doneloading();
					 	alert("Rats, I wasn't able to make this request: "+JSON.stringify(data));reporterror(url); },
					 beforeSend: setHeader
				 });

			}
			
			//if picking a specific ride
			
			if(rideid>0){
			
			   fbid=myinfo.fbid;
			   loading();
			   
			   var dataset = {
				   "fbid":	fbid,
				   }				
			   
			   var jsondataset = JSON.stringify(dataset);
   
			   url="/ridezu/api/v/1/rides/rideid/"+rideid+"/rider";
			   var request=$.ajax({
				   url: url,
				   type: "PUT",
			       cache: false,
				   dataType: "json",
				   data: jsondataset,
				   success: function(data) {
					 	 if(data.warn){
					 	 	message="<h2>Really?</h2><p>I think you might be trying to overbook yourself.</p>";
					 	 	openconfirm();
					 	 	return false;
					 	 	};
						 doneloading();
						 document.getElementById("ridetimeb").innerHTML=timeslot;
						 document.getElementById("ridepickupb").innerHTML=rlist.start;
						 document.getElementById("dnameb").innerHTML=pname;
						 document.getElementById("dnameb1").innerHTML=pname;
						 photo=getphoto(driverfbid);
						 document.getElementById("dpicb").src=photo;
						 document.getElementById("r4").style.display="block";
						 },
				   error: function(data) {
				   		doneloading();
				   		alert("boo!"+JSON.stringify(data));reporterror(url); },
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

					photo=getphoto(fbid);
					personlist=personlist+"<li class=\"driver\" id=\"l"+value.fbid+"\"><a onclick=\"profile('ridepostp',"+value.fbid+");\">";
					personlist=personlist+"<div id='viewprofile'><image class='profilephoto' src='"+photo+"'/>";
					personlist=personlist+"<p>View Profile</p></div></a>";
					personlist=personlist+"<a onclick=\"authselectrider('"+timeslot+"','"+value.rideid+"','"+value.fbid+"','"+value.name+"','"+eventtime+"');\">";
					personlist=personlist+"<div id='selectdriver'><p>"+value.name+"</p></div></a></li>";

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
			info.timeslot=timeslot;
			info.ride=ride;
			info.fbid1=fbid1;
			info.pname=pname;
			info.eventtime=eventtime;			

		   if(info.fbid1==myinfo.fbid){
			  message="<h2>Really?</h2><p>You can't book yourself.  That would be silly.<p>";
			  openconfirm();
			  return false;
			  }
			
			if(myinfo.dlverified=="Y" && myinfo.cartype!=null){
				message="<h2>New Ride</h2><p>Click OK to confirm.</p>";
				confirmfunction="selectrider1";
				showcancel=true;	
				openconfirm();			
				}

			if(myinfo.dlverified!="Y" || myinfo.cartype==null){
				startflow("ridepost");		
				}
			}

// this picks the specific ride (used by drivers)
		
		function selectrider1(){			
			
			timeslot=info.timeslot;
			ride=info.ride;
			fbid1=info.fbid1;
			pname=info.pname;
			eventtime=info.eventtime;
			
			//if picking an empty slot (for drivers)

			if(ride==0){

			   	 fbid=myinfo.fbid;
				 loading();
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
		 		     cache: false,
					 dataType: "json",
					 data: jsondataset,
					 success: function(data) {
					 	 if(data.warn){
					 	 	message="<h2>Really?</h2><p>I think you might be trying to overbook yourself.</p>";
					 	 	openconfirm();
					 	 	return false;
					 	 	};
						 doneloading();
						 document.getElementById("posttimea").innerHTML=timeslot;
						 document.getElementById("ridepickupa").innerHTML=rlist.start;
						 document.getElementById("r1").style.display="none";
						 document.getElementById("r2").style.display="none";
						 document.getElementById("r3").style.display="block";
					  },
					 error: function(data) {
					 	 doneloading();
					 	 alert("Rats, I wasn't able to make this request: "+JSON.stringify(data)); reporterror(url);},
					 beforeSend: setHeader
				 });
 

				}
			
			//if picking a specific rider (for drivers)
			if(ride>0){
			
				 loading();
				 var dataset = {
						 "fbid": fbid,
						 }				
				 var jsondataset = JSON.stringify(dataset);
					 url="/ridezu/api/v/1/rides/rideid/"+ride+"/driver";
						 var request=$.ajax({
							 url: url,
							 type: "PUT",
				    		 cache: false,
							 dataType: "json",
							 data: jsondataset,
							 success: function(data) {
							   if(data.warn){
								  message="<h2>Really?</h2><p>I think you might be trying to overbook yourself.</p>";
								  openconfirm();
								  return false;
								  };
								doneloading();
								x="l"+fbid1;
								photo=getphoto(fbid1);
								newrow="<div class='select1'><div id='viewprofile'><image class='profilephoto' src='"+photo+"'/>";
								newrow=newrow+"<p>View Profile</p></div>";
								newrow=newrow+"<div id='selectdriver'><p>"+pname+"</p></div></div>";
								document.getElementById(x).style.backgroundColor="#7ddb1d";
								document.getElementById(x).innerHTML=newrow;
								document.getElementById("nextbutton").style.display="block";
							 	},
							 error: function(data) {
							 	doneloading();
							 	alert("Rats, I wasn't able to make this request: "+JSON.stringify(data));reporterror(url);},
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

// this function is for the swipe left/swipe right right function set 

		(function($) { 
				 $.fn.touchwipe = function(settings) {
				   var config = {
						  min_move_x: 20,
						  min_move_y: 20,
						  wipeLeft: function() { },
						  wipeRight: function() { },
						  wipeUp: function() { },
						  wipeDown: function() { },
						  preventDefaultEvents: true
				   };
				   
				   if (settings) $.extend(config, settings);
			   
				   this.each(function() {
					   var startX;
					   var startY;
					   var isMoving = false;
			  
					   function cancelTouch() {
						   this.removeEventListener('touchmove', onTouchMove);
						   startX = null;
						   isMoving = false;
					   }	
					   
					   function onTouchMove(e) {
						   if(config.preventDefaultEvents) {
							   e.preventDefault();
						   }
						   if(isMoving) {
							   var x = e.touches[0].pageX;
							   var y = e.touches[0].pageY;
							   var dx = startX - x;
							   var dy = startY - y;
							   if(Math.abs(dx) >= config.min_move_x) {
								  cancelTouch();
								  if(dx > 0) {
									  config.wipeLeft();
								  }
								  else {
									  config.wipeRight();
								  }
							   }
							   else if(Math.abs(dy) >= config.min_move_y) {
									  cancelTouch();
									  if(dy > 0) {
										  config.wipeDown();
									  }
									  else {
										  config.wipeUp();
									  }
								   }
						   }
					   }
					   
					   function onTouchStart(e)
					   {
						   if (e.touches.length == 1) {
							   startX = e.touches[0].pageX;
							   startY = e.touches[0].pageY;
							   isMoving = true;
							   this.addEventListener('touchmove', onTouchMove, false);
						   }
					   }    	 
					   if ('ontouchstart' in document.documentElement) {
						   this.addEventListener('touchstart', onTouchStart, false);
					   }
				   });
			   
				   return this;
				 };
			   
			   })(jQuery);		

// this is the my rides page, myridesp.  lots of use cases here

// gets a list of myrides
		
		function myrides(){
		  	  loading();
		  	  fbid=myinfo.fbid;
		  	  mrlist="";		  
			  url="/ridezu/api/v/1/rides/search/fbid/"+fbid;
			
			  $.ajax({
			  url: url,
			  cache: false,
			  dataType: "json",
			  beforeSend: setHeader
			  }).done(function(data) {
				doneloading();
				mrlist=data;
				paintmyrides();						
				  });
		}

// paint a specific myride (option input = rideid).  this is fairly complex functionality which loops throough
// all rides and decides to 1) paint a selected ride (if sent in to function) 2) paint the first ride 
// or 3) if no rides available then show call to action for post a ride or request a ride.  

		function paintmyrides(rideid){		
		  fbid=myinfo.fbid;
		  z=0;

		  if(mrlist["Driver"]){z=z+mrlist["Driver"].length;}
		  if(mrlist["Rider"]){z=z+mrlist["Rider"].length;}
		  		  
		  $.each(mrlist, function(key, value) {
		  		  
		  		x0=key;
		  		match=false;
		  
		  		$.each(mrlist[key], function(key1, value1) {
			  		x1=key1;
 				  	value1=mrlist[x0][x1];
			  		
			  		if(value1.rideid==rideid){match=true;return false;}
			  		if(rideid===undefined){return false;}

			  	});			
			  	
			  	if(match==true){return false;}
			  	
	    	});

			if(z>0){

 			  	value1=mrlist[x0][x1];
				
				if(z>1){
					  sm="<a onclick='showallrides();'>Show all rides.</div>";
					  document.getElementById('showmore').innerHTML=sm;
					  }
			  		   				
				if(value1.day!="Today"){
					  x="";
					  }
					  else{
					  x="";
					  }

				if(x0=="Rider"){
					document.getElementById('ridedetails').innerHTML="Ride Request: ";
					document.getElementById('costcollect').innerHTML="Cost";

					}
				if(x0=="Driver"){
					document.getElementById('ridedetails').innerHTML="Ride Post: ";
					document.getElementById('costcollect').innerHTML="Collect";
					}
				
				document.getElementById('godate').innerHTML=x;
				document.getElementById('leavetime').innerHTML=evtime(value1.eventtime);
				rideid=value1.rideid;
								
				x="";
	   
				if(value1.route=="h2w"){
					 document.getElementById('origindesc').innerHTML="<img src='images/start.png'/>Home";
					 document.getElementById('destdesc').innerHTML="<img src='images/start3.png'/>Work";
					  } 
					  
					  else {
					  document.getElementById('origindesc').innerHTML="<img src='images/start3.png'/>Work";
					  document.getElementById('destdesc').innerHTML="<img src='images/start.png'/>Home";
					  }
				xoriginlatlong="https://maps.googleapis.com/maps/api/staticmap?center="+value1.startlatlong+"&zoom=13&size="+mw+"x"+mh+"&maptype=roadmap&markers=icon:http://www.ridezu.com/images/basemarker.png%7C"+value1.startlatlong+"&sensor=false";
				document.getElementById('ridedesta').src=xoriginlatlong;		  		  
				document.getElementById('amount').innerHTML=curr(value1.amount);
								
				if(value1.eventstate=="EMPTY" || value1.eventstate=="REQUEST"){
					document.getElementById('nomatch').innerHTML="We haven't found a match yet.";
				}

				if(value1.eventstate=="ACTIVE" || value1.eventstate=="FULL"){
					x="";
					n=value1.reffbid.split("#");
					info.tofbidlist=value1.reffbid;
					$.each(n, function(key2, value2) {
							m=value2.split("|");

							photo=getphoto(m[0]);
							x=x+"<li class='driver'><a onclick=\"profile('myridesp',"+m[0]+");\">";
							x=x+"<div id='viewprofile'><image class='profilephoto' src='"+photo+"'/>";
							x=x+"<p>View Profile</p></div></a>";
							x=x+"<div id='selectdriver'><p>"+m[1]+"<br/><a class='minibutton' onclick=\"sendmessage('"+myinfo.fbid+"','"+m[0]+"','"+m[1]+"');\">Send message</a>";
							x=x+"</p></div></li>";
							
					});
				}

																				
			   document.getElementById('ridelist1').innerHTML=x;		  	
			   document.getElementById('allrides').style.display="none";
			   document.getElementById('r0').style.display="block";
			   document.getElementById('r1').style.display="block";	  	
			   b="";
			   if(value1.reffbid!=null){
			   		b="<input type=\"submit\" onclick=\"runninglate('"+rideid+"');\" class=\"primarybutton\" value=\"I'm running late!\"/>";
			   		}
			   b=b+"<input type=\"submit\" onclick=\"cancelride('"+rideid+"');\" class=\"primarybutton\" value=\"Cancel Ride\"/></div>";
			   document.getElementById('myrideaction').innerHTML=b;
		  	
		  	}
		  	
		  	if(z==0){
				if(myinfo.destdesc==undefined || myinfo.origindesc==undefined){
					document.getElementById('noridenote').innerHTML="We're putting together routes in your area and will let you know when you can start.<br/><br/>Until then, why don't you take the tour on how it works and complete your profile.";
					document.getElementById('mr3').style.display="block";
					document.getElementById('mr4').style.display="block";
					}
			   
			if(myinfo.destdesc!=undefined && myinfo.origindesc!=undefined){
					document.getElementById('mr1').style.display="block";
					document.getElementById('mr2').style.display="block";
					}
			   
			   document.getElementById('noride').style.display="block";

		  	}
	}

// this function shows all rides that a user has

		function showallrides(){		
		  fbid=myinfo.fbid;
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
					if(value3.route=="h2w"){rte="<img style='width:12px;' src='../images/start3.png' /> Work";}
					if(value3.route=="w2h"){rte="<img style='width:12px;' src='../images/start.png' /> Home";}
					etime=evtime(value3.eventtime);
					imdrivinglist=imdrivinglist+"<a onclick=\"paintmyrides('"+value3.rideid+"')   \"><li><span class='date'>"+value3.day+"</span><span class='time'> "+etime+" <span class='dest'>"+rte+"</span></li></a>";				
			  	});
	  		  
		  	 }
		  	 
		  if(riders>0){
		    	document.getElementById('imriding').style.display="block";	 		  		  
		  		$.each(mrlist["Rider"], function(key4, value4) {
					value3=mrlist["Rider"][key4];
					if(value4.route=="h2w"){rte="<img style='width:12px;' src='../images/start3.png' /> Work";}
					if(value4.route=="w2h"){rte="<img style='width:12px;' src='../images/start.png' /> Home";}
					etime=evtime(value4.eventtime);
					imridinglist=imridinglist+"<a onclick=\"paintmyrides('"+value4.rideid+"')   \"><li><span class='date'>"+value4.day+ "</span><span class='time'> "+etime+" </span><span class='dest'>"+rte+"</span></li></a>";				
			  	});


		  	 }

		  document.getElementById('r0').style.display="none";	 
		  document.getElementById('r1').style.display="none";	 
		  document.getElementById('imdrivingrides').innerHTML=imdrivinglist;	 
		  document.getElementById('imridingrides').innerHTML=imridinglist;	 
		  document.getElementById('allrides').style.display="block";	 
		  	 
		  }	  

// this function shows nearby riders

		function nearbyrides(location){		

			   if(location==null){location="H";}
				 
			   if(myinfo.company==null){company="";}
				 else {company=myinfo.company;}
	 	 
	 	 	   if(location=="W"){
	 	 	   		document.getElementById('homebutton').style.display="block";	 	
	 	 	   		document.getElementById('workbutton').style.display="none";	 	
	 	 	   		document.getElementById('location').innerHTML="office";
	 	 	   		}	 	

	 	 	     else {
	 	 	   		document.getElementById('workbutton').style.display="block";
	 	 	   		document.getElementById('homebutton').style.display="none";
	 	 	   		document.getElementById('location').innerHTML="home";	 	
					}
			   loading();
			   fbid=myinfo.fbid;
			   mrlist="";		  
			   url="/ridezu/api/v/1/users/search/nearby/fbid/"+fbid+"/location/"+location+"/company/"+company+"/go";
			 
			   $.ajax({
			   url: url,
			   cache: false,
			   dataType: "json",
			   beforeSend: setHeader
			   }).done(function(data) {
				 doneloading();
				 mrlist=data;
				 paintnearbyrides(location);						
			 });
				   
			 }
  
		function paintnearbyrides(location){		
		  
			 fbid=myinfo.fbid;
			 count=mrlist.length;
			 document.getElementById('usermatches').innerHTML=count;	 		  		  
			 xstartlatlong="https://maps.googleapis.com/maps/api/staticmap?center="+myinfo.homelatlong+"&zoom=13&size="+mw+"x150&maptype=roadmap&markers=icon:http://www.ridezu.com/images/basehmarker.png%7C"+myinfo.homelatlong+"&sensor=false";
			 document.getElementById('mapa').src=xstartlatlong;
   
			 if(count>0){
				 personlist="<ul>";
				 $.each(mrlist, function(key, value) { 

						 photo=getphoto(value.fbid);
						 personlist=personlist+"<li class=\"driver\" id=\"l"+value.fbid+"\"><a onclick=\"profile('nearbyp',"+value.fbid+");\">";
						 personlist=personlist+"<div id='viewprofile'><image class='profilephoto' src='"+photo+"'/>";
						 personlist=personlist+"<p>View Profile</p></div></a>";
						 personlist=personlist+"<div id='selectdriver'><p>"+value.fname+" "+value.lname+"";
						 personlist=personlist+"<a class='minibutton' onclick=\"sendmessage('"+myinfo.fbid+"','"+value.fbid+"','"+value.fname+"');\">Send message</a></div></li>";
	 
				 });
				 personlist=personlist+"</ul>";
				 document.getElementById("nearbyuserlist").innerHTML=personlist;
				}

		  	}	  

		  
// this function set(2) cancels a ride for a user

		function cancelride(rideid){	
			message="<h2>Cancel Ride</h2><p>Are you sure you want to cancel this ride?<br><br>This cannot be undone.</p>";
			info.rideid=rideid;
			confirmfunction="cancelconfirm";
			okmessage="Cancel Ride";	
			cancelmessage="< Back";	
			showcancel=true;	
			openconfirm();
		}	

		function cancelconfirm(rideid){	
			fbid=myinfo.fbid;
			rideid=info.rideid;
		    loading();
		    url="/ridezu/api/v/1/rides/rideid/"+rideid+"/fbid/"+fbid;
		    var request=$.ajax({
                url: url,
                type: "DELETE",
			    cache: false,
                dataType: "json",
                success: function(data) {
                	doneloading();
                	p="mainp";
                	nav(p,'myridesp');},
                error: function(data) {
                	doneloading();
                	alert("Rats - I could not cancel this. "+JSON.stringify(data));reporterror(url); },
                beforeSend: setHeader
            });
		}	

// this function set relates to being late

		function notlate(){
			   scrollToTop();
			   document.getElementById('r0').style.display="block";
			   document.getElementById('r1').style.display="block";			
			   document.getElementById('rlate').style.display="none";			
		}

		function runninglate(id){
			   scrollToTop();
			   document.getElementById('r0').style.display="none";
			   document.getElementById('r1').style.display="none";			
			   document.getElementById('rlate').style.display="block";			
		}

		function runninglatemessage(time){
			info.fromfbid=myinfo.fbid;
			x=info.tofbidlist;	
			x1=x.split("#");
				$.each(x1, function(key3, value3) {
					x2=value3.split("|");
					x3=x2[1].split(" ");
					m="Hi "+x3[0]+" - I am running about "+time+" late.  Let me know if this is not ok.  Thanks! -"+myinfo.fname;
					info.tofbid=x2[0];
				    document.getElementById('txtmessage').value=m;
	    			info.messagetype="direct";
				    sendmessage1();							
				});

			notlate();
		}

// this function set populates the page for the profile page
// step1 get the user 

		function profile(from,fbid){
			userfbid=fbid;
			navt(from,"userprofilep");
			}

// this function paints the user profile page

		function paintuserprofile(){
			if(userinfo.consistency==null){userinfo.consistency="Not yet rated"};
			if(userinfo.timeliness==null){userinfo.timeliness="Not yet rated"};
			if(info.ranking==undefined){info.ranking="Not yet rated"};
			if(userinfo.cartype==null){userinfo.carmaker="Not available";userinfo.cartype="";};
			if(userinfo.co2balance==null){userinfo.co2balance="0"};
			x=parseInt(userinfo.ridesoffered)+parseInt(userinfo.ridestaken);
			x="0";
			photo=getphoto(userinfo.fbid);
			document.getElementById('profilephoto').src=photo;	
			document.getElementById('workcity').innerHTML=userinfo.workcity;	

			if(myinfo.fbid!=userinfo.fbid){
				document.getElementById('messageuser').innerHTML="<br/><a class='minibutton' onclick=\"sendmessage('"+myinfo.fbid+"','"+userinfo.fbid+"','"+userinfo.fname+"');\">Send message</a>";
				}
							
			document.getElementById('ranking').innerHTML=info.ranking;	
			document.getElementById('city').innerHTML=userinfo.city;	
			document.getElementById('cartype').innerHTML=userinfo.carmaker+" "+userinfo.cartype;	
			document.getElementById('username').innerHTML=userinfo.fname+" "+userinfo.lname;	
			document.getElementById('co2').innerHTML=userinfo.co2balance;	
			document.getElementById('trips').innerHTML=x;
			document.getElementById('consistency').innerHTML=userinfo.consistency;
			document.getElementById('timeliness').innerHTML=userinfo.timeliness;

			if(userinfo.frontphoto){
				document.getElementById('frontphoto').src="https://ridezu.s3.amazonaws.com/"+myinfo.frontphoto;
				document.getElementById('mywheels').style.display="block";			
				}
							
			if(userinfo.profileblob!=null){

				if(userinfo.profileblob.quotes){
					document.getElementById('quote').innerHTML=userinfo.profileblob.quotes;
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
							edulist=edulist+"<strong class='educationsub'>"+value.school.name+"</strong><br>";
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
				}
			userfbid="";	    
			}

// this function paints the images on ride details

		function ridedetails(){
			fbid=myinfo.fbid;
			
			if(myinfo.frontphoto!=null){
				front="https://ridezu.s3.amazonaws.com/"+myinfo.frontphoto;
				document.getElementById('frontview').src=front;
				document.getElementById('frontview').style.display="block";
				}
							
			document.getElementById('fbid').value=fbid;
			
			if(myinfo.isLuxury=="on"){document.getElementById('luxurycar').checked="checked";}
			
			setSelectedIndex(document.getElementById('cartype'),myinfo.cartype);
			setSelectedIndex(document.getElementById('carmaker'),myinfo.carmaker);
			setSelectedIndex(document.getElementById('seats'),myinfo.seats);

			}

		function addphoto(){
			document.getElementById('loadbutton').style.display="block";
			}		

		function newridedetails(){
			myinfo.cartype=document.getElementById('cartype').value;
			myinfo.carmaker=document.getElementById('carmaker').value;
			myinfo.isLuxury=document.getElementById('luxurycar').value;
			myinfo.seats=document.getElementById('seats').value
			updateuserflag=true;

			if(myinfo.cartype!=null && myinfo.carmaker!=null && myinfo.seats!=null && flow=="ridepost"){
				document.getElementById('driverflow').style.display="block";
				updateuser();
				}
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
					document.getElementById("frontview").src = "https://ridezu.s3.amazonaws.com/"+myinfo.frontphoto;
					document.getElementById('frontview').style.display="block";
					document.getElementById('loadbutton').style.display="none";
					}
				 if(x=="back"){
				 	myinfo.backphoto=obj.image;
					document.getElementById("backview").src = "https://ridezu.s3.amazonaws.com/"+myinfo.backphoto;
					}
				 if(x=="right"){
				 	myinfo.rightphoto=obj.image;
					document.getElementById("rightview").src = "https://ridezu.s3.amazonaws.com/"+myinfo.rightphoto;
					}
				 if(x=="left"){
				 	myinfo.leftphoto=obj.image;
					document.getElementById("leftview").src = "https://ridezu.s3.amazonaws.com/"+myinfo.leftphoto;
					}
				 if(x=="user"){
				 	myinfo.userphoto=obj.image;
					document.getElementById("userphoto").src = "https://ridezu.s3.amazonaws.com/"+myinfo.userphoto;
					}
				 updateuserflag=true;
				 }
			  document.getElementById('uploadprocess').style.display = 'none';
			  return true;   
		}

// this function set is for the profilepage

		function profileinit(){
			if(myinfo.miles>0){
				document.getElementById('commute').style.display="block";
				}
			if(myinfo.profileblob==null){
				document.getElementById('addfb').style.display="block";				
				}					
		}

// this function set is for the home profile page (first half = update home / second half = pick a place close to you)

		function homeprofileinit(){
			document.getElementById('r1').style.display="block";
			document.getElementById('r2').style.display="none;";			
			document.getElementById('add1').innerHTML=myinfo.add1;
			document.getElementById('city').innerHTML=myinfo.city;
			document.getElementById('map_canvas').style.height=(screenheight-20)+"px";
		  	xstartlatlong="https://maps.googleapis.com/maps/api/staticmap?center="+myinfo.homelatlong+"&zoom=13&size="+mw+"x150&maptype=roadmap&markers=icon:http://www.ridezu.com/images/basehmarker.png%7C"+myinfo.homelatlong+"&sensor=false";
			document.getElementById('mapa').src=xstartlatlong;
		  	if(myinfo.origindesc){
				 x1startlatlong="https://maps.googleapis.com/maps/api/staticmap?center="+myinfo.originlatlong+"&zoom=13&size="+mw+"x150&maptype=roadmap&markers=icon:http://www.ridezu.com/images/basepmarker.png%7C"+myinfo.originlatlong+"&sensor=false";
				 document.getElementById('mapb').src=x1startlatlong;
				 document.getElementById('pickupname').innerHTML=myinfo.origindesc;
				 }
				else {
				document.getElementById('pickupname').innerHTML="Select a pickup location";
				}
			}

		function pickhome(){ 
			document.getElementById('r1').style.display="none";
			document.getElementById('r2').style.display="block";			
			x = myinfo.homelatlong;
			y = x.split(",");
			myspot = new google.maps.LatLng(y[0],y[1]);
			info.pick="home";
			loadMap("pick",myspot,18,"home");
			}
			
		function pickpickup(){
			document.getElementById("mapselect").value="Select";
			document.getElementById('r1').style.display="none";
			document.getElementById('r2').style.display="block";			
			message="<p>Please select one of the pickup locations by clicking on the marker.<br><br>This is where you will get picked up and dropped off at the end of the day.</p>";  
			openconfirm();
			if(myinfo.originlatlong){x=myinfo.originlatlong;}
				else {x=myinfo.homelatlong;}
			y = x.split(",");
			myspot = new google.maps.LatLng(y[0],y[1]);
			info.pick="pickup";
			loadMap("pickselect",myspot,12,"home");
			}

		function updatehome(){
		
			if(info.pick=="home"){
				 myinfo.add1=info.add1;
				 myinfo.state=info.state;
				 myinfo.city=info.city;
				 myinfo.zip=info.zip;
				 myinfo.homelatlong=info.lat+","+info.lng;
				 }
			
			if(info.pick=="pickup"){
				 myinfo.originlatlong=info.lat+","+info.lng;
				 myinfo.origindesc=info.desc;
				 if(info.pickspot==false){
						message="<p>Please click one of the available locations. Thanks!<p>";
						openconfirm();
						return false;
						}
				 }

			//update miles & co2 if needed
			if(myinfo.destlatlong && myinfo.originlatlong){
				calculateDistance();
				}
					 
			updateuserflag=true;
			document.getElementById('r2').style.display="none";	
			homeprofileinit();
			}

// this function set is for the work profile page

		function workprofileinit(){
			document.getElementById('r1').style.display="block";
			document.getElementById('r2').style.display="none";			
			document.getElementById('add1').innerHTML=myinfo.workadd1;
			document.getElementById('city').innerHTML=myinfo.workcity;
			document.getElementById('map_canvas').style.height=(screenheight-20)+"px";
		  	xstartlatlong="https://maps.googleapis.com/maps/api/staticmap?center="+myinfo.worklatlong+"&zoom=13&size="+mw+"x150&maptype=roadmap&markers=icon:http://www.ridezu.com/images/basecbmarker.png%7C"+myinfo.worklatlong+"&sensor=false";
			document.getElementById('mapa').src=xstartlatlong;
		  	if(myinfo.destdesc){
				x1startlatlong="https://maps.googleapis.com/maps/api/staticmap?center="+myinfo.destlatlong+"&zoom=13&size="+mw+"x150&maptype=roadmap&markers=icon:http://www.ridezu.com/images/basecbmarker.png%7C"+myinfo.destlatlong+"&sensor=false";
				document.getElementById('mapb').src=x1startlatlong;
				document.getElementById('pickupname').innerHTML=myinfo.destdesc;
				}
				else {
				document.getElementById('pickupname').innerHTML="Select a pickup location";
				}

			}

		function pickwork(){ 
			document.getElementById('r1').style.display="none";
			document.getElementById('r2').style.display="block";			
			x = myinfo.worklatlong;
			y = x.split(",");
			myspot = new google.maps.LatLng(y[0],y[1]);
			info.pick="work";
			loadMap("pick",myspot,18,"work");
			}
			
		function pickpickupwork(){
			document.getElementById("mapselect").value="Select";
			document.getElementById('r1').style.display="none";
			document.getElementById('r2').style.display="block";			
			message="<p>Please select one of the pickup locations by clicking on the marker.<br><br>In you work at a corporate campus, please let your driver know which building you work in.</p>";  
			openconfirm();
			if(myinfo.destlatlong){x=myinfo.destlatlong;}
				else {x=myinfo.worklatlong;}
			y = x.split(",");
			myspot = new google.maps.LatLng(y[0],y[1]);
			info.pick="pickup";
			loadMap("pickselect",myspot,12,"work");
			}

		function updatework(){
		
			if(info.pick=="work"){
				 myinfo.workadd1=info.add1;
				 myinfo.workstate=info.state;
				 myinfo.workcity=info.city;
				 myinfo.workzip=info.zip;
				 myinfo.worklatlong=info.lat+","+info.lng;
				 }
			
			if(info.pick=="pickup"){
				 myinfo.destlatlong=info.lat+","+info.lng;
				 myinfo.destdesc=info.desc;
				 if(info.pickspot==false){
				 	message="<p>Please click one of the available locations. Thanks!<p>";
				 	openconfirm();
				 	return false;
				 	}
				 }

			//update miles & co2 if needed
			if(myinfo.destlatlong && myinfo.originlatlong){
				calculateDistance();
				}
					 
			updateuserflag=true;
			document.getElementById('r2').style.display="none";	
			workprofileinit();
			}
			
// this function set is for the commute page

		function commuteinit(){
			if(myinfo.miles.length>0){

				loading();
				mapurl="https://maps.googleapis.com/maps/api/staticmap?size=300x200&maptype=roadmap&markers=icon:http://stage.ridezu.com/images/basehmarker.png%7C"+myinfo.homelatlong+"&markers=icon:http://stage.ridezu.com/images/basecbmarker.png%7C"+myinfo.worklatlong+"&markers=icon:http://stage.ridezu.com/images/basepmarker.png%7C"+myinfo.originlatlong+"&markers=icon:http://stage.ridezu.com/images/basecpmarker.png%7C"+myinfo.destlatlong+"&sensor=false";
				document.getElementById('commutex').style.display="block";		
				document.getElementById('miles').innerHTML=myinfo.miles+" miles";			
				document.getElementById('annmiles').innerHTML=addCommas(myinfo.miles*240*2)+" miles";			
				document.getElementById('co2savings').innerHTML=addCommas((myinfo.co2*240*2)/25*20); //miles / mpg * 20, where avg mpg=25			
				document.getElementById('map').src=mapurl;

				url="/ridezu/api/v/1/rides/search/fbid/"+fbid+"/driver";
				$.ajax({
				url: url,
				cache: false,
				dataType: "json",
				beforeSend: setHeader
				}).done(function(data) {
				  info.collect=data.amount;
				  document.getElementById('collectdaily').innerHTML=addCommas(curr(info.collect));
				  document.getElementById('collectyearly').innerHTML=addCommas(curr(info.collect*240*2));
					});			  
  
				url="/ridezu/api/v/1/rides/search/fbid/"+fbid+"/rider";
				$.ajax({
				url: url,
				cache: false,
				dataType: "json",
				beforeSend: setHeader
				}).done(function(data) {
				  doneloading();
				  info.cost=data.amount;
				  document.getElementById('savedaily').innerHTML=addCommas(curr(info.cost));
				  document.getElementById('saveyearly').innerHTML=addCommas(curr(info.cost*240*2*.25));			
					});			  
		
				}					
			else {
				document.getElementById('nocommute').style.display="block";				
				}
		}

// this function is for driver verification

		function dverifyinit(){
			if(myinfo.dlverified=="Y"){
				document.getElementById('c1').checked=true;
				document.getElementById('c2').checked=true;
				document.getElementById('c3').checked=true;
				document.getElementById('c4').checked=true;
				}
		}

		function dverify(){
			cb1=$('#c1:checked').val();
			cb2=$('#c2:checked').val();
			cb3=$('#c3:checked').val();
			cb4=$('#c4:checked').val();
			if(cb1=="on" && cb2=="on" && cb3=="on" && cb4=="on"){
				myinfo.dlverified="Y";
				message="<p>Thanks! You're all set</p>";
				openconfirm();
				updateuser();
				back();
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
			if(myinfo.phone!=null){
				parts = [myinfo.phone.slice(0,3),myinfo.phone.slice(3,6),myinfo.phone.slice(6,10)];
				document.getElementById('phone').value = parts[0]+"-"+parts[1]+"-"+parts[2];	
				}
			document.getElementById('name').value=myinfo.fname+" "+myinfo.lname;			
			}

		function contactinfo(){
			myinfo.email=document.getElementById('email').value;
			phone = document.getElementById('phone').value;
			phone = phone.replace( /\D/g, '' );
			if(phone.length!=0 && phone.length!=10){
				message="<p>Please enter a 10-digit phone number xxx-xxx-xxxx</p>";
				openconfirm();
				phone="";
				}
			myinfo.phone=phone;
			name=document.getElementById('name').value;
			fn=name.split(" ");
			myinfo.fname=fn[0];
			myinfo.lname=fn[1];
			
			updateuserflag=true;
			}

// this function is for the about page

		function aboutinit(){
			document.getElementById('version').innerHTML=displayversion;
			document.getElementById('device').innerHTML=device;
			}
			
// this function set are the account management functions

		function account(){
        	loading();
        	fbid=myinfo.fbid;
        	timeperiod="Y";
		    url="/ridezu/api/v/1/account/summary/fbid/"+fbid+"/timeperiod/"+timeperiod;
		    var request=$.ajax({
                url: url,
                type: "GET",
 			    cache: false,
                dataType: "json",
                success: function(data) {
                	doneloading();
                	paintaccount(data); },
                error: function(data) {
                	doneloading();
                	alert("Yikes, I am not getting any account data."+JSON.stringify(data));reporterror(url); },
                beforeSend: setHeader
            });
        }

		function paintaccount(data){
			document.getElementById('credits').innerHTML=curr(+data.account.totalcredit+data.account.virtualbalance);
			document.getElementById('charges').innerHTML=curr(data.account.totaldebit);
			balance1=+data.account.totalcredit - +data.account.totaldebit + +data.account.virtualbalance;

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
		}

		function accountdetail(){
        	loading();
        	fbid=myinfo.fbid;
        	timeperiod="Y";
		    url="/ridezu/api/v/1/account/detail/fbid/"+fbid+"/timeperiod/"+timeperiod;
		    var request=$.ajax({
                url: url,
                type: "GET",
 			    cache: false,
                dataType: "json",
                success: function(data) {
                	doneloading();
                	paintaccountdetail(data); },
                error: function(data) {
                	doneloading();
                	alert("Yikes, I am not getting any account data."+JSON.stringify(data));reporterror(url); },
                beforeSend: setHeader
            });
        }

		function paintaccountdetail(data){

	    	if(data.accountdetail){

				txndetail="<table>";
				  
				$.each(data.accountdetail, function(key, value) {
					 d=value.eventtime;
					 d1=d.split(" ");
					 d2=d1[0].split("-");
					 d3=d2[1]+"/"+d2[2];				
					 if(value.credit=="0.00"){amt="-$"+value.debit;}
					 if(value.debit=="0.00"){amt="$"+value.credit;}
					 desc=value.origindesc+" > "+value.destdesc;
					 txndetail=txndetail+"<tr><td>"+d3+"</td><td>"+desc+"</td><td style='text-align:right;'>"+amt+"</td></tr>";
					});
	 
				 txndetail=txndetail+"</table>";
				 document.getElementById('txndata').innerHTML=txndetail;		
				 document.getElementById('trans').style.display="block";		
	 
				 $("tr:odd").css("background-color", "#ffffff");
			}
		
			else {
				 document.getElementById('notrans').style.display="block";				
			}
			
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
			if(myinfo.notificationmethod=="EMAIL"){	document.getElementById("notifyemail").checked="checked";}	    
			if(myinfo.notificationmethod=="SMS"){	document.getElementById("notifysms").checked="checked";	 }   
			if(myinfo.ridereminders=="1"){document.getElementById("ridereminder").checked="checked";}	    
			}

		function notify(){
			if(document.getElementById("notifyemail").checked==true){myinfo.notificationmethod="EMAIL";}	
			if(document.getElementById("notifysms").checked==true){myinfo.notificationmethod="SMS";}	
			if(document.getElementById("ridereminder").checked==true){myinfo.ridereminders="1";}	
			if(document.getElementById("ridereminder").checked==false){myinfo.ridereminders="0";}	
			updateuserflag=true;
			}

// this function set (2) is for sending messages from user to user

		function sendmessage(fromfbid,tofbid,toname){	
			message="<p>Send a private message to <b>"+toname+"</b><br/><br/>";
			message=message+"<textarea id='mymsg' rows='3' cols='30'></textarea>";
			info.fromfbid=fromfbid;
			info.tofbid=tofbid;
			info.messagetype="alertbox";
			confirmfunction="sendmessage1";
			okmessage="Send";	
			cancelmessage="Cancel";	
			showcancel=true;	
			openconfirm();
		}	

		function sendmessage1(msg){	
			 
			  _gaq.push(['_trackPageview', "Sent Message"]);

			 if(info.messagetype=="direct"){
			 	message1=document.getElementById("txtmessage").value;
			 	}
			 	
			 if(info.messagetype=="alertbox"){
			 	message1=document.getElementById("mymsg").value;
			 	}
			 			 
			 var dataset = {"message":	message1,}				
			 var jsondataset = JSON.stringify(dataset);
			 url="/ridezu/api/v/1/notification/message/fbid/"+info.tofbid+"/fromfbid/"+info.fromfbid;

		    var request=$.ajax({
                url: url,
                type: "POST",
			    cache: false,
                dataType: "json",
                data: jsondataset,
                success: function(data) {
                	message="<center><h2>Message sent!</h2></center>";
		  			openconfirm();
                	},
                error: function(data) {alert("boo!"+JSON.stringify(data));reporterror(url);},
                beforeSend: setHeader
            });

		}	

// this function set is for credit card setup and update

		function paymentinfoinit(){
			if(myinfo.last4==null){
				document.getElementById("payblock").style.display="block";
				x="pay/paymentform.php?fbid="+myinfo.fbid+"&fname="+myinfo.fname+"&lname="+myinfo.lname+"&email="+myinfo.email+"&seckey="+myinfo.seckey+"&method=newcard";
				document.getElementById("payifrm").src=x;
				}		
			if(myinfo.last4!=null){
				document.getElementById("payblock").style.display="none";
				document.getElementById("onfile").style.display="block";
				document.getElementById("last4oncard").innerHTML=myinfo.last4;
				document.getElementById("cardname").innerHTML=myinfo.fname+" "+myinfo.lname;
				x="../images/visa.png";
				if(myinfo.cardtype=="Visa"){x="../images/visa.png";}
				if(myinfo.cardtype=="MasterCard"){x="../images/mastercard.png";}
				if(myinfo.cardtype=="Discover"){x="../images/discover.png";}
				if(myinfo.cardtype=="American Express"){x="../images/amex.png";}
				document.getElementById("cardname").innerHTML=myinfo.fname+" "+myinfo.lname;
				document.getElementById("cardlogo").src=x;
				}
			}
		
		function addnewcard(){
			if(myinfo.last4!=null){
				document.getElementById("payblock").style.display="block";
				document.getElementById("onfile").style.display="none";
				x="pay/paymentform.php?fbid="+myinfo.fbid+"&fname="+myinfo.fname+"&lname="+myinfo.lname+"&email="+myinfo.email+"&seckey="+myinfo.seckey+"&method=addnewcard&oldtoken="+myinfo.token;
				document.getElementById("payifrm").src=x;
				}
			}			
		
		function ccupdate(instrux){
			x=JSON.parse(instrux);
			if(x.error){
				message="<p>Looks like there was an error with your credit card.  Could you try again?  Thanks!</p>";
				openconfirm();
				}
			if(x.cardtype){
				myinfo.last4=x.last4;
				myinfo.cardtype=x.cardtype;
				myinfo.token=x.token;
				myinfo.expdate=x.expirationdate;
				message="<h2>Thank you!</h2><p>Your credit card has been entered securely.</p>";
				openconfirm();
				updateuser();
				back();
				}
		}	

// this function set is to show the company logo, send pins as well as check pins for registration

		function showcompanylogo(){
				if(localStorage.companylogo!=undefined){
					document.getElementById("cobrand").src="https://ridezu.s3.amazonaws.com/"+localStorage.companylogo;
					}
				if(localStorage.companylogo==undefined){
					url="/ridezu/api/v/1/corp/get/corplogo/"+myinfo.company;
					var request=$.ajax({
						url: url,
						type: "GET",
						cache:false,
						dataType: "json",
						success: function(data) {
							localStorage.companylogo=data.logo;
							document.getElementById("cobrand").src="https://ridezu.s3.amazonaws.com/"+localStorage.companylogo;
							},
						error: function(data) { alert("Uh oh - I can't see to get my data"+JSON.stringify(data));reporterror(url) },
						beforeSend: setHeader
						});	
					}
			}

		function sendpin(){
			corploginemail=document.getElementById("corpemail").value;
		    if(corploginemail!=""){
	        	myinfo.email=corploginemail;
	        	loading();
				url="/ridezu/api/v/1/users/generatePin/login/"+corploginemail;
				var request=$.ajax({
					url: url,
					type: "GET",
					cache: false,
					dataType: "json",
					success: function(data) {
						doneloading();
						x=data.generatePin.text;
						if(x=="success"){
							nav("corploginp","checkpinp");
							return false;
							}
						if(x=="fail"){
							message="<h2>Snap!</h2><p>We didn't find your email with our corporate user list.  Please try again or contact your corp admin</p>";
							openconfirm();
							}
						},
					error: function(data) {
						doneloading();
						alert("Yikes, I am not getting any account data."+JSON.stringify(data));reporterror(url); },
					beforeSend: setHeader
				});	
			}	
		}
		
		function checkpin(){				
	        	loading();
	    		pin=document.getElementById("pin").value;
				url="/ridezu/api/v/1/users/checkPin/login/"+myinfo.email+"/pin/"+pin;
				var request=$.ajax({
					url: url,
					type: "GET",
					cache: false,
					dataType: "json",
					success: function(data) {
						doneloading();
						if(data.user_key){
							message="Great!  You're registered and ready to go!  Let's see who we can carpool with.";
							openconfirm();
							localStorage.seckey=data.seckey;
							localStorage.fbid=data.user_key;
							fbid=localStorage.fbid;
							seckey=localStorage.seckey;
							loadmyinfo();															
							}
						if(data.msg){
							message="<h2>Snap!</h2><p>That pin is not quite right. Please enter the correct pin.</p>";
							openconfirm();
							}
						},
					error: function(data) {
						doneloading();
						alert("Yikes, I am not getting any account data."+JSON.stringify(data));reporterror(url); },
					beforeSend: setHeader
				});	

		
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
 			    cache: false,
                dataType: "html",
                data: jsondataset,
                success: function() {},
                error: function() {},
                beforeSend: setHeader
            	}); 
			}				

// these are the functions which initialize and start the ridezu web app.  please keep everything after this line at the end of this page, and functions before this.

// declare global variables. 

  		var map; 
  		var m=new Array(); 
	    var geocoder;
	    var myspot;
	    var requestride;
	    var userdata;
	    var mrlist;
	    var nodelist;
	    var userinfo={};
	    var etime;
	    var userfbid="";
		var message;
		var okmessage="OK";
		var cancelmessage="Cancel";
		var confirmfunction="";
		var showcancel=false;
		var screenwidth=$(window).width();
		var screenheight=$(window).height();
		var mw=screenwidth-20;
		var mh=Math.max(100,screenheight-270);
		var slots=Math.max(4,Math.round((screenheight-200)/40));
		var updateuserflag=false;
		var tp="";
		var p="firstp";
		var flow="";
		  		
// page titles are the pageid's coupled with what shows up in the header
  		
  		var pageTitles = { 
  			"aboutp":"About" ,
  			"riderequestp":"Request a Ride" ,
  			"ridepostp":"Post a Ride" ,
   			"noroutep":"Stay tuned!" ,
   			"rideconfirmp":"Ride confirmed!",
  			"startp":"Welcome to Ridezu" ,
  			"enrollp":"Where do you work?" ,
  			"fbp":"Login with Facebook" ,
			"congratp":"Welcome!",
  			"mainp":"Ridezu" ,
			"calcp":"Ridezunomics",
			"accountp":"My Account",
			"transactionp":"Transaction History",	 
  			"ridesp":"My Rides" ,
  			"profilep":"My Profile" ,
  			"howitworksp":"How it Works",
  			"termsp":"Terms of Service",
  			"faqp":"FAQ's",
  			"myridesp":"My Rides",			
  			"loginp":"Login - Test Page",			
  			"homeprofilep":"Home Details",			
  			"workprofilep":"Work Details",			
  			"contactinfop":"Contact Info",			
  			"driverp":"Driver Verification",			
  			"ridedetailsp":"My Wheels",			
  			"paymentp":"Payment Info",			
  			"payoutp":"Payout Info",			
  			"notifyp":"Notifications",			
  			"userprofilep":"Profile",			
  			"pricingp":"Pricing",			
  			"commutep":"My Commute",			
  			"corploginp":"Login",			
  			"checkpinp":"Enter Pin",			
  			"fbconnectp":"Connect with Facebook",			
  			"nearbyp":"Ridezu's Nearby"			
			};

// this watches for orientation change and makes any site changes, if needed

		window.addEventListener('orientationchange', handleOrientation, false);
		   function handleOrientation() {
			   if (orientation == 0 || orientation == 180) {
							  screenwidth=screen.width;
							  screenheight=screen.height;
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

	if(msg=="Welcome"){
		localStorage.removeItem("fbid");
		localStorage.removeItem("seckey");
		nav("firstp","corploginp");
		document.getElementById("showbar").style.display="block";
		document.body.style.display="block";
		return false;
		}

	fbid=localStorage.fbid;
	seckey=localStorage.seckey;


	if(fbid!=undefined && seckey!=undefined){
	  loadmyinfo();
	}
	else
	{
	  nav("firstp","startp");
	  	  $(document).ready(function() {
		  document.body.style.display="block";
		});
	}
	if(client=="mweb"){
		 window.addEventListener("load",function() {
		   // Set a timeout...
		   setTimeout(function(){
			 // Hide the address bar!
			 window.scrollTo(0, 1);
		   }, 0);
		document.getElementById("showbar").style.display="block";
		document.body.style.display="block";
		});
	  }
	
	if(client=="widget" || client=="iOS" || client=="android"){
		document.body.style.display="block";
		document.getElementById("showbar").style.display="none";
		}
	
    if(client!="widget"){
    	document.getElementById("w").style.minHeight=(screenheight-10)+"px";
    	}
});