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

// this function set is for uploading the corp logo to aws (same as in ridezu.js)

		function addphoto(){
			document.getElementById('loadbutton').style.display="block";
			}		

		function startUpload(){
			  document.getElementById('loadbutton').style.display = 'none';
			  document.getElementById('uploadprocess').style.display = 'block';
			  return true;
		}
		
		function stopUpload(success){
			  if(success){
				 obj = JSON.parse(success);
				 x=obj.type;
				 if(x=="logo"){
				 	logoimage=obj.image;
					document.getElementById("companylogo").src = "https://ridezu.s3.amazonaws.com/"+logoimage;
					document.getElementById('companylogo').style.display="block";
					document.getElementById('loadbutton').style.display="none";
					localStorage.companylogo=logoimage;
					url="/ridezu/api/v/1/corp/put/addcorplogo/"+logoimage+"/company/"+mycorpinfo.company+"/upload";	       
	            	var request=$.ajax({
		               url: url,
		               type: "GET",
					   cache: false,
		               dataType: "json",
		               success: function(data) {},
		               error: function() { alert('That does not seem right.  Can you try one more time, with feeling?'); },
					   beforeSend: setHeader
	                });                                     

					}
				 }
			  document.getElementById('uploadprocess').style.display = 'none';
			  return true;   
		}

// this function loads the current user in a js object, this function is used for all the profile functions 

		function loadmycorpinfo(){
		    corpuserid=localStorage.corpuserid;
		    url="/ridezu/api/v/1/users/search/fbid/"+corpuserid;
		    var request=$.ajax({
                url: url,
                type: "GET",
                cache: false,
                dataType: "json",
                success: function(data) {
					mycorpinfo=data;
					portalstart();
			    	},
                error: function(data) { alert("Uh oh - I can't see to get my data"+JSON.stringify(data));reporterror(url) },
                beforeSend: setHeader
            });
		}

// this function is to register an admin user

		function registeradminuser(){
			fname=document.getElementById('fname').value;
			if(fname==""){
				message="Please enter a first name.";
				openconfirm();
				return false;			
				}	
			lname=document.getElementById('lname').value;	
			if(lname==""){
				message="Please enter a last name.";
				openconfirm();
				return false;			
				}
			password1=document.getElementById('password1').value;	
			password2=document.getElementById('password2').value;	
			company=document.getElementById('company').value;
			if(company==""){
				message="Please enter a company name.";
				openconfirm();
				return false;			
				}
	
			email=document.getElementById('email').value;	
			if(email==""){
				message="Please enter an email address.";
				openconfirm();
				return false;			
				}
			phone=document.getElementById('phone').value;	
			phone = document.getElementById('phone').value;
			phone = phone.replace( /\D/g, '' );
			if(phone.length!=0 && phone.length!=10){
				message="Please enter a 10-digit phone number xxx-xxx-xxxx";
				openconfirm();
				phone="";
				return false;
				}
			if(password1!=password2){
				message="Your new passwords need to match. Please try again.";
				openconfirm();
				return false;
				}
			if(password1.length<6){
				message="Your password should be at least six digits.";
				openconfirm();
				return false;
				}
			fbid="a_"+email;	
			user_key="a_"+email;	

			if(password1==password2){
		 
					 var dataset = {
						 "fbid":	fbid,
						 "fname": fname,
						 "lname": lname,
						 "email": email,
						 "phone": phone,
						 "company": company,
						 "user_key": user_key,
						 "loginpassword": password1,
						 "regtype": "newadmin",
						 }
						 
					 var jsondataset = JSON.stringify(dataset);
				 
					 url="/ridezu/api/v/1/users";
					 type="POST";
					 
					 var request=$.ajax({
						 url: url,
						 type: "POST",
						 dataType: "json",
						 data: jsondataset,
						 error: function(data) { 
						 	message="Rat's there was an error.  Could you try again?";
						 	openconfirm();
						 	return false;
						 	},
						 beforeSend: setHeader
					 });
					 
					 request.done(function(data) {
	  						myinfo=data;
	  						x="loginiframe.php?corpuserid="+data.fbid+"&corpseckey="+data.seckey+"&company="+data.company+"&email="+data.email+"&reg=1";
							mycorpinfo.corpseckey=data.seckey;
							mycorpinfo.corpuserid=data.fbid;	  						
							localStorage.corpuserid=mycorpinfo.corpuserid;
							localStorage.corpseckey=mycorpinfo.corpseckey;
							document.getElementById('loginiframe').src=x;
						 });      	
				
				}
			}

// this function updates user data with any relevant updates

		function updateuser(){
				updateuserflag=false;
            	var jsondataset = JSON.stringify(mycorpinfo);
 				url="/ridezu/api/v/1/users/"+mycorpinfo.id+"/fbid/"+mycorpinfo.corpuserid;
 				       
            	var request=$.ajax({
                url: url,
                type: "PUT",
                dataType: "json",
                data: jsondataset,
                success: function(data) {},
                error: function() { alert('That does not seem right.  Can you try one more time, with feeling?'); },
                beforeSend: setHeader
                });                                     
		}

// this function is to logoff the user 

		function logoffuser(){
			localStorage.removeItem("corplogin");
			localStorage.removeItem("corpuserid");
			localStorage.removeItem("corpseckey");
  			x="loginiframe.php?action=logoff";
			document.getElementById('loginiframe').src=x;
			}

// this function is to login the user 

		function loginuser(){
			password=document.getElementById('password').value;	
			login="a_"+document.getElementById('login').value;	
			localStorage.corplogin="a_"+document.getElementById('login').value;	

		    	url="/ridezu/api/v/1/users/search/login/"+login+"/pwd/"+password;
            	var request=$.ajax({
	                 url: url,
	                 type: "GET",
	                 dataType: "json",
	  				 cache: false,
	                 success: function(data) {
	  					if(data.seckey){
	  						x="loginiframe.php?corpuserid="+data.fbid+"&corpseckey="+data.seckey+"&company="+data.company+"&email="+data.email;
							mycorpinfo.corpseckey=data.seckey;
							mycorpinfo.corpuserid=data.fbid;	  						
							localStorage.corpuserid=mycorpinfo.corpuserid;
							localStorage.corpseckey=mycorpinfo.corpseckey;
							document.getElementById('loginiframe').src=x;
							}	  						
	  					},
	                 error: function() { alert('That does not seem right.  Can you try one more time, with feeling?'); },
					 beforeSend: setHeader
	                 });                                     
			}
		
// this function is to change passwords

		function changepassword(){
			corplogin=localStorage.corplogin;	
			voldpassword=document.getElementById('oldpassword').value;	
			vnewpassword=document.getElementById('newpassword').value;	
			vnewpassword1=document.getElementById('newpassword1').value;	
			if(vnewpassword!=vnewpassword1){
				alert("Your new passwords need to match. Please try again.");
				return false;
				}
			if(vnewpassword.length<6){
				alert("Your passwords should be at least 6 digits.");
				return false;
				}
			if(vnewpassword==vnewpassword1){

 				url="/ridezu/api/v/1/users/search/login/"+corplogin+"/pwd/"+voldpassword+"/newpwd/"+vnewpassword;				       
            	var request=$.ajax({
	                 url: url,
	                 type: "GET",
	                 dataType: "json",
	                 success: function(data) {
	  					if(data.updatepasswordresult.text=="success"){
	  						alert("Your password has been changed.")
	  						window.location="admin.php";
	  						};
	  					if(data.updatepasswordresult.text!="success"){;
	  						alert("Somethings not quite right.  Could you try once again, with feeling?");
	  						}
	  					},
	                 error: function() { alert('uh oh, could you try again?'); },
					 beforeSend: setHeader
	                 });                                     
				}
			}

// this function is to get campus info

		function getcampus(){

			$.ajax({
			type: "GET",
			url: "/ridezu/api/v/1/corp/get/campuslist/"+mycorpinfo.company,
			cache: false,
			dataType: "json",
			beforeSend: setHeader

			}).done(function(campusdata) {
			  paintcampuslist(campusdata);	
				});
		  }
		
		function deletecampus(campusid){

			$.ajax({
			type: "DELETE",
			url: "/ridezu/api/v/1/corp/delete/campus/"+mycorpinfo.company+"/"+campusid,
			cache: false,
			dataType: "json",
			beforeSend: setHeader

			}).done(function(campusdata) {
			  getcampus();	
				});
		  }

// this function paints all the users

		function paintcampuslist(campusdata){
		  
			 c=0;
			 var campuslist="";
					 
			 $.each(campusdata, function(key, value) {						
				  campuslist=campuslist+"<div style='width:200px;float:left;'>"+value.campusname+"</div><img src=\"../images/trashcan.png\" style=\"width:16px;\" onclick=\"deletecampus('"+value.id+"');\" title=\"remove campus\"/><br>";  
				  c++;
				  });
					   			 
			if(c==0){campuslist="No company locations have yet been entered";}
			
			document.getElementById('campus_list').innerHTML=campuslist;
		  }
		
// this function is to add a campus 

		function addcampus(){
			document.getElementById('addcampus').style.display="block";						
			campusname=document.getElementById('campusname').value;	
			campusaddress=document.getElementById('campusaddress').value;	
			if(campusname!="Enter a campus name" && campusaddress!="Enter a location"){
				addnewcampus();
				}
			}

// this function process a new campus

		function addnewcampus(){
			
            var addr1=document.getElementById("campusaddress").value;
		
			geocoder.geocode( { 'address': addr1}, function(results, status) {
				 if (status == google.maps.GeocoderStatus.OK) {
					 campusx = results[0].formatted_address;
					 campuslatlong = results[0].geometry.location;
					 campuslatlongstring=campuslatlong.lat()+","+campuslatlong.lng();

					 str1 = campusx.split(',');
					 str2 = str1[2].split(" ");
					 campusadd1=str1[0];
					 campusstate=str2[1];
					 campuscity=str1[1];
					 campuszip=str2[2];
					 
					 url="/ridezu/api/v/1/corp/put/campus";				       
					 
					 var dataset = {
						 "campusname":	campusname,
						 "companyname": mycorpinfo.company,
						 "addr1": campusadd1,
						 "city": campuscity,
						 "state": campusstate,
						 "zip": campuszip,
						 "latlong": campuslatlongstring
						 }
						 
					 var jsondataset = JSON.stringify(dataset);
				 
					 type="POST";
					 
					 var request=$.ajax({
						 url: url,
						 type: "POST",
						 dataType: "json",
						 data: jsondataset,
						 error: function(data) { 
						 	message="Rat's there was an error.  Could you try again?";
						 	openconfirm();
						 	return false;
						 	},
						 beforeSend: setHeader
					 });
					 
					 request.done(function(data) {
						 document.getElementById('addcampus').style.display="none";						
						 document.getElementById('campusname').value="";	
						 document.getElementById('campusaddress').value="";
						 getcampus();
						 });      

				 } 
			   });	
			
			}

// this is the google search for address functionality (only on admin/load users page)

	 function initialize() {
 
		 geocoder = new google.maps.Geocoder();
 
		 var home1 = document.getElementById('campusaddress');
		 var autocomplete1 = new google.maps.places.Autocomplete(home1);
		   
		 google.maps.event.addListener(autocomplete1, 'place_changed', function() {
		   var place1 = autocomplete1.getPlace();
 		   
		   if (!place1.geometry) {
			 // Inform the user that the place was not found and return.
			 return;
		   }       
		   });
  		
	   }
	   	
	   	google.maps.event.addDomListener(window, 'load', initialize);

// this starts page specific javascripts,as if needed

		function portalstart(){
			
			if(page=="Admin"){
				document.getElementById('company').innerHTML=mycorpinfo.company;						
					x=mycorpinfo.company;
					x1=x.replace(/\s+/g, '');
					x2=x1.toLowerCase();
				document.getElementById('companyemail').innerHTML="@"+x2+".com";						
					c1=mycorpinfo.company.replace(" ","_");
				document.getElementById('fbid').value=c1;
				if (localStorage.companylogo === undefined || localStorage.companylogo==null ) {
				   // these statements execute
					}
				else {
				   // these statements do not execute
					x3="https://ridezu.s3.amazonaws.com/"+localStorage.companylogo;
					document.getElementById('companylogo').style.height="100px";	
					document.getElementById('companylogo').src=x3;		
					}				
				document.getElementById('name').innerHTML=mycorpinfo.fname+" "+mycorpinfo.lname;				
				document.getElementById('email').innerHTML=mycorpinfo.email;				
				parts = [mycorpinfo.phone.slice(0,3),mycorpinfo.phone.slice(3,6),mycorpinfo.phone.slice(6,10)];
				document.getElementById('phone').innerHTML = "("+parts[0]+") "+parts[1]+"-"+parts[2];	
				getcampus();
				}
			if(page=="Load Users"){
				getcampus();
				}		
		}
		
		function openconfirm(){
			document.getElementById('confirm-message').innerHTML=message;
			document.getElementById('cancel-button').innerHTML=cancelmessage;
			document.getElementById('ok-button').innerHTML=okmessage;
			if(showcancel==true){document.getElementById('cancel-button').style.display="block";document.getElementById('ok-button').style.float="left"}
			if(showcancel==false){document.getElementById('ok-button').style.float="center";}
			$('#confirm-background').fadeIn({ duration: 100 });		
			}
	
        function setHeader(xhr) {
            xhr.setRequestHeader("X-Id", localStorage.corpuserid);
            xhr.setRequestHeader("X-Signature", localStorage.corpseckey);
            xhr.setRequestHeader("Content-Type", "application/json");
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
						
// this function is to report errors or anomalies that users see

		function reporterror(url){
			var dataset = {
				"corpuserid":	mycorpinfo.corpuserid,
				"fname": mycorpinfo.fname,
				"lname": mycorpinfo.lname,
				"email": mycorpinfo.email,
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
	    var corpuserid;
	    var tp;
		var cancelmessage="Cancel";
		var message;
		var okmessage="OK";
		var confirmfunction="";
		var showcancel=false;

// this starts the docs and loads the page, off we go!

	$(document).ready(function()
	{

		if(localStorage.company!=undefined){
			if(localStorage.companylogo==undefined){
				url="/ridezu/api/v/1/corp/get/corplogo/"+localStorage.company;
				var request=$.ajax({
					url: url,
					type: "GET",
					cache: false,
					dataType: "json",
					success: function(data) {
						localStorage.companylogo=data.logo;
						},
					error: function(data) { alert("Uh oh - I can't see to get my data"+JSON.stringify(data));reporterror(url) },
					beforeSend: setHeader
					});	
				}
			}				

				
		if(mycorpinfo.corpuserid!="" && mycorpinfo.corpseckey!=""){
		   loadmycorpinfo();
		   }
		   	
	});
	

		