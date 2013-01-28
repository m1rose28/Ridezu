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

// this function loads the current user in a js object, this function is used for all the profile functions 

		function loadmycorpinfo(){
		    corpuserid=localStorage.corpuserid;
		    url="/ridezu/api/v/1/users/search/fbid/"+corpuserid;
		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {
					mycorpinfo=data;
					portalstart();
			    	},
                error: function(data) { alert("Uh oh - I can't see to get my data"+JSON.stringify(data));reporterror(url) },
                beforeSend: setHeader
            });
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
			login=document.getElementById('login').value;	
			localStorage.corplogin=document.getElementById('login').value;	

		    	url="/ridezu/api/v/1/users/search/login/"+login+"/pwd/"+password;
            	var request=$.ajax({
	                 url: url,
	                 type: "GET",
	                 dataType: "json",
	  				 cache: false,
	                 success: function(data) {
	  					if(data.seckey){
	  						x="loginiframe.php?corpuserid="+data.fbid+"&corpseckey="+data.seckey+"&company="+data.company;
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


// this starts page specific javascripts,as if needed

		function portalstart(){
			
			if(page=="Admin"){
				document.getElementById('company').innerHTML=mycorpinfo.company;						
					x=mycorpinfo.company;
					x1=x.replace(/\s+/g, '');
					x2=x1.toLowerCase();
				document.getElementById('companyemail').innerHTML="@"+x2+".com";						
				document.getElementById('companylogo').src="../images/cobrand/"+x+".png";						
				document.getElementById('name').innerHTML=mycorpinfo.fname+" "+mycorpinfo.lname;				
				document.getElementById('email').innerHTML=mycorpinfo.email;				
				parts = [mycorpinfo.phone.slice(0,3),mycorpinfo.phone.slice(3,6),mycorpinfo.phone.slice(6,10)];
				document.getElementById('phone').innerHTML = "("+parts[0]+") "+parts[1]+"-"+parts[2];	
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
		//this tells you which experiment is running (so you can turn one off)
				
		if(mycorpinfo.corpuserid!="" && mycorpinfo.corpseckey!=""){
		   loadmycorpinfo();
		   }
		   	
	});
	

		