<?php 
$p="api";
$d=date("Y-m-d");
$time="9:30";
$uid="500023557";
$seckey="396c0d2c3a08e5b75a256830ac87a2a8";

if(isset($_GET['uid'])){
	$uid=$_GET['uid'];
	$seckey=$_GET['seckey'];

	}
	
include 'header.php';

?>

	
<script>

		var retval="";
		localStorage.fbid="<?php echo $uid;?>";
		localStorage.seckey="<?php echo $seckey;?>";

// this function set 2 creates a new user
		
		function regnewuser(){

        fbid=document.getElementById("regfbid").value;
        fname=document.getElementById("regfname").value;
        lname=document.getElementById("reglname").value;
        email=document.getElementById("regemail").value;
        hadd1=document.getElementById("reghadd1").value;
        hcity=document.getElementById("reghcity").value;
        hstate=document.getElementById("reghstate").value;
        hzip=document.getElementById("reghzip").value;
    	wadd1=document.getElementById("regwadd1").value;
        wcity=document.getElementById("regwcity").value;
        wstate=document.getElementById("regwstate").value;
        wzip=document.getElementById("regwzip").value;       
        hlat=document.getElementById("reghlat").value;
        hlng=document.getElementById("reghlng").value;
        wlat=document.getElementById("regwlat").value;
        wlng=document.getElementById("regwlng").value;
        refer=document.getElementById("referfbid").value;
        camp="test1";

		//		"homelatlong": hlat+","+hlng,
		//		"worklatlong": wlat+","+wlng,

			var dataset = {
				"fbid":	fbid,
				"fname": fname,
				"lname": lname,
				"add1": hadd1,
				"city": hcity,
				"state": hstate,	
				"zip": hzip,
				"workadd1": wadd1,
				"workcity": wcity,
				"workstate": wstate,	
				"workzip": wzip,
				"email": email,
				"referer":refer,
				"campaign":camp
				}
				
			var jsondataset = JSON.stringify(dataset);
		
			url="/ridezu/api/v/1/users";
			type="POST";
			instr="URL: "+url+"<br/>type: "+type+"<br/>data:"+jsondataset+"</br>";			
			
		    var request=$.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: jsondataset,
                success: function(data) {show(instr,data);},
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
            
            request.done(function(msg) {
  				localStorage.seckey=msg.seckey;
				});      	
       	}

// this function set creates a new admin user
		
		function regnewadminuser(){

			 fbid=document.getElementById("adminfbid").value;
			 fname=document.getElementById("adminfname").value;
			 lname=document.getElementById("adminlname").value;
			 email=document.getElementById("adminemail").value;
			 company=document.getElementById("admincompany").value;
			 emailsyntax=document.getElementById("adminemailsyntax").value;
			 employees=document.getElementById("adminemployees").value;
			 user_key=document.getElementById("adminuser_key").value;
			 loginpassword=document.getElementById("adminloginpassword").value;
	 
				 var dataset = {
					 "fbid":	fbid,
					 "fname": fname,
					 "lname": lname,
					 "email": email,
					 "company": company,
					 "emailsyntax": emailsyntax,
					 "employees": employees,
					 "user_key": user_key,
					 "loginpassword": loginpassword,
					 "regtype": "newadmin",
					 }
					 
				 var jsondataset = JSON.stringify(dataset);
			 
				 url="/ridezu/api/v/1/users";
				 type="POST";
				 instr="URL: "+url+"<br/>type: "+type+"<br/>data:"+jsondataset+"</br>";			
				 
				 var request=$.ajax({
					 url: url,
					 type: "POST",
					 dataType: "json",
					 data: jsondataset,
					 success: function(data) {show(instr,data);},
					 error: function(data) { alert("boo!"+JSON.stringify(data)); },
					 beforeSend: setHeader
				 });
				 
				 request.done(function(msg) {
					 localStorage.seckey=msg.seckey;
					 });      	
		}


//get all rides
		function getusers(){

			url="/ridezu/api/v/1/users";
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"</br>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data);},
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

//get all rides
		function getallrides(){

			url="/ridezu/api/v/1/rides";
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

//get user data
		function getuserdetails(){
        	fbid=document.getElementById("userdetails").value;
			url="/ridezu/api/v/1/users/search/fbid/"+fbid;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    url=url;
		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }


//get driver by time
		function getdriverbytime(){
        	time=document.getElementById("getdrivertime").value;
            url: "/ridezu/api/v/1/rides/search/eventtime/"+time+"/driver";
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

//get rider by time
		function getriderbytime(){
        	time=document.getElementById("getridertime").value;
            url="/ridezu/api/v/1/rides/search/eventtime/"+time+"/rider";
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data);},
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }


//get ride by id
		function getridebyid(){
        	rideid=document.getElementById("rideid").value;
		    url= "/ridezu/api/v/1/rides/"+rideid;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }


//get rider avail rides by fbid
		function getridebyfbid(){
        	fbid=document.getElementById("rider1").value;
		    url="/ridezu/api/v/1/rides/search/fbid/"+fbid+"/driver";
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

//get rider avail rides by fbid,route,date
		function getridebyfbidRtDt(){
        	fbid=document.getElementById("rider2").value;
			route=document.getElementById("rider2route").value;
			date=document.getElementById("rider2date").value;
		    url="/ridezu/api/v/1/rides/search/fbid/"+fbid+"/searchroute/"+route+"/searchdate/"+date+"/driver";
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

//get driver avail rides by fbid
		function getdriverbyfbid(){
        	fbid=document.getElementById("drivebyfbid").value;
		    url="/ridezu/api/v/1/rides/search/fbid/"+fbid+"/rider";
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

//get driver avail rides by fbid,route,date
		function getdriverbyfbidRtDt(){
        	fbid=document.getElementById("drivebyfbid").value;
			route=document.getElementById("ridebyroute").value;
			date=document.getElementById("ridebydate").value;
		    url="/ridezu/api/v/1/rides/search/fbid/"+fbid+"/searchroute/"+route+"/searchdate/"+date+"/rider";
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }


//this is for a rider requesting a ride in an empty spot
		function requestnewride(){
        	fbid=document.getElementById("reqridefbid").value;
        	time=document.getElementById("reqridetime").value;
        	route=document.getElementById("reqrideroute").value;
        	
            url="/ridezu/api/v/1/rides/rider";

			var dataset = {
				"fbid":	fbid,
				"eventtime": time,
				"route": route
				}				

			var jsondataset = JSON.stringify(dataset);

			type="POST";
			instr="URL: "+url+"<br/>type: "+type+"<br/>data:"+jsondataset+"</br>";			

		    var request=$.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: jsondataset,
                success: function(data) {show(instr,data); },
                error: function(data) {alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

//this is for a driver posting a new ride 

		function postnewride(){
        	fbid=document.getElementById("postridefbid").value;
        	time=document.getElementById("postridetime").value;
			route=document.getElementById("route").value;
			var dataset = {
				"fbid":	fbid,
				"eventtime": time,
				"route": route,
				}				

			var jsondataset = JSON.stringify(dataset);

			url="/ridezu/api/v/1/rides/driver";
			type="POST";
			instr="URL: "+url+"<br/>type: "+type+"<br/>data:"+jsondataset+"</br>";			

		    var request=$.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: jsondataset,
                success: function(data) {show(instr,data); },
                error: function(data) {alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

		 function postnewridewithrider(){
			 fbid=document.getElementById("driverfbid").value;
			 rideid=document.getElementById("reqrideid").value;
			 var dataset = {"fbid":fbid,}				
			 var jsondataset = JSON.stringify(dataset);
			 url="/ridezu/api/v/1/rides/rideid/"+rideid+"/driver";
			 type="PUT";
			 instr="URL: "+url+"<br/>type: "+type+"<br/>data:"+jsondataset+"</br>";			

					 var request=$.ajax({
						 url: url,
						 type: "PUT",
						 dataType: "json",
						 data: jsondataset,
						 success: function(data) {show(instr,data); },
						 error: function(data) {alert("boo!"+JSON.stringify(data)); },
						 beforeSend: setHeader
					 });

		
}


//this is for a rider selecting a ride with a driver (rideid is the match) 

		 function selectridebyrider(){
			 fbid=document.getElementById("selectridefbid").value;
			 rideid=document.getElementById("selectrideid").value;
			 var dataset = {"fbid":	fbid,}				
			 var jsondataset = JSON.stringify(dataset);
			 url="/ridezu/api/v/1/rides/rideid/"+rideid+"/rider";
			 type="PUT";
			 instr="URL: "+url+"<br/>type: "+type+"<br/>data:"+jsondataset+"</br>";			

		    var request=$.ajax({
                url: url,
                type: "PUT",
                dataType: "json",
                data: jsondataset,
                success: function(data) {show(instr,data); },
                error: function(data) {alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

//get my ride details 
		function getriderride(){
        	fbid=document.getElementById("myriderfbid").value;
		    url="/ridezu/api/v/1/rides/search/fbid/"+fbid;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

//cancel ride function 
		function cancelride(){
        	fbid=document.getElementById("cancelfbid").value;
        	rideid=document.getElementById("cancelrideid").value;
		    url="/ridezu/api/v/1/rides/rideid/"+rideid+"/fbid/"+fbid;
			type="DELETE";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "DELETE",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

//show account

		function account(){
        	fbid=document.getElementById("accountfbid").value;
        	timeperiod=document.getElementById("timeperiod").value;
		    url="/ridezu/api/v/1/account/summary/fbid/"+fbid+"/timeperiod/"+timeperiod;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

//show account detail

		function accountdetail(){
        	fbid=document.getElementById("accountdetailfbid").value;
        	timeperiod=document.getElementById("detailtimeperiod").value;
		    url="/ridezu/api/v/1/account/detail/fbid/"+fbid+"/timeperiod/"+timeperiod;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }


//get nodes

		function nodes(){
        	fbid=document.getElementById("nodefbid").value;
        	nodetype=document.getElementById("nodetype").value;
		    url="/ridezu/api/v/1/users/search/fbid/"+fbid+"/location/"+nodetype;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    var request=$.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

// this is to see others on your route

		function seeothers(){
        	fbid=document.getElementById("locfbid").value;
		    url="/ridezu/api/v/1/users/searchpublicbymatch/fbid/"+fbid;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    url=url;
		    var request=$.ajax({
                url: url,
                type: type,
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }


//  this is to see users nearby

		function seenearby(){
			mylocation=document.getElementById("nearbyloc").value;
        	fbid=document.getElementById("nearbyfbid").value;
		    url="/ridezu/api/v/1/users/search/nearby/fbid/"+fbid+"/location/"+mylocation;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    url=url;
		    var request=$.ajax({
                url: url,
                type: type,
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }


  
// this is to try a login

		function loginuser(){
        	login=document.getElementById("login").value;
        	password=document.getElementById("password").value;
		    url="/ridezu/api/v/1/users/search/login/"+login+"/pwd/"+password;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    url=url;
		    var request=$.ajax({
                url: url,
                type: type,
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }


// this is to change password

		function changepassword(){
        	clogin=document.getElementById("clogin").value;
        	cpassword=document.getElementById("cpassword").value;
        	cpassword1=document.getElementById("cpassword1").value;
		    
		    url="/ridezu/api/v/1/users/search/login/"+clogin+"/pwd/"+cpassword+"/newpwd/"+cpassword1;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    url=url;
		    var request=$.ajax({
                url: url,
                type: type,
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

// this is to get corp data

		function getcorpdata(){
        	fbid=document.getElementById("companyfbid").value;
        	companyname=document.getElementById("companyname").value;
		    
		    url="/ridezu/api/v/1/corp/get/corpdata/"+companyname;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    url=url;
		    var request=$.ajax({
                url: url,
                type: type,
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }

// this is to get campus data

		function getcampusdata(){
        	fbid=document.getElementById("campusfbid").value;
        	companyname=document.getElementById("companyid").value;
		    
		    url="/ridezu/api/v/1/corp/get/campuslist/"+companyname;
			type="GET";
			instr="URL: "+url+"<br/>type: "+type+"<br/>";			

		    url=url;
		    var request=$.ajax({
                url: url,
                type: type,
                cache: false,
                dataType: "json",
                success: function(data) {show(instr,data); },
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }



//this is to send a message

		 function sendmessage(){
			 tofbid=document.getElementById("tofbid").value;
			 fromfbid=document.getElementById("fromfbid").value;
			 txtmessage=document.getElementById("txtmessage").value;
			 var dataset = {"message":	txtmessage,}				
			 var jsondataset = JSON.stringify(dataset);
			 url="http://www.ridezu.com/ridezu/api/v/1/notification/message/fbid/"+tofbid+"/fromfbid/"+fromfbid;
			 type="POST";
			 instr="URL: "+url+"<br/>type: "+type+"<br/>data:"+jsondataset+"</br>";			

		    var request=$.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: jsondataset,
                success: function(data) {show(instr,data); },
                error: function(data) {alert("boo!"+JSON.stringify(data)); },
                beforeSend: setHeader
            });
        }


//this is for setting headers / authentication.  temporarily turned off.  

        function setHeader(xhr) {
            xhr.setRequestHeader("X-Id", localStorage.fbid);
            xhr.setRequestHeader("X-Signature", localStorage.seckey);
            xhr.setRequestHeader("Content-Type", "application/json");
        }
        
//this shows the actual json result

        function show(instr,data){
        	x=JSON.stringify(data, undefined, 2);
        	document.getElementById("jsonresult").innerHTML=instr+"<br/><pre>"+x+"</pre>";
			document.getElementById("myModal").style.diplay="block";
			$('#myModal').modal(show)
			}
        
        function shownewuser(){
        	document.getElementById("makenewuser").style.display="block";
			}
			
		function hide(){
		    document.getElementById("popup").style.display="none";
			}

        function hidenewuser(){
        	document.getElementById("makenewuser").style.display="none";
			}        
</script>


<div style="padding-left:20px;">
<form class="form-horizontal">
	<p><div class="input-append"><a class="btn btn-primary" onclick="shownewuser();">Make a new user</a>
	<div id="makenewuser" style="display:none;background-color:#eee;padding:10px;"/>	 
		 <p><label>fbid</label><div class="input-append">fbid: <input id="regfbid" value="<?php echo "test".rand(1000,9000);?>" type="text"/></div></p>
		 <p><div class="input-append">first name: <input id="regfname" value="Mark" type="text"/></div></p>
		 <p><div class="input-append">last name:  <input id="reglname" value="Rose" type="text"/></div></p>
		 <p><div class="input-append">email:  <input id="regemail" value="m1rose28@gmail.com" type="text"/></div></p>
		 <p><div class="input-append">home address 1:  <input id="reghadd1" value="5475 Tesoro Court" type="text"/></div></p>
		 <p><div class="input-append">home city:  <input id="reghcity" value="San Jose" type="text"/></div></p>
		 <p><div class="input-append">home state:  <input id="reghstate" value="CA" type="text"/></div></p>
		 <p><div class="input-append">home zip:  <input id="reghzip" value="95124" type="text"/></div></p>
		 <p><div class="input-append">work address 1:  <input id="regwadd1" value="500 Unviversity" type="text"/></div></p>
		 <p><div class="input-append">work city:  <input id="regwcity" value="Los Gatos" type="text"/></div></p>
		 <p><div class="input-append">work state:  <input id="regwstate" value="CA" type="text"/></div></p>
		 <p><div class="input-append">work zip:  <input id="regwzip" value="95132" type="text"/></div></p>
		 <p><div class="input-append">home lat:  <input id="reghlat" value="37.2388541" type="text"/></div></p>
		 <p><div class="input-append">home lng:  <input id="reghlng" value="-121.9214275" type="text"/></div></p>
		 <p><div class="input-append">work lat:  <input id="regwlat" value="-121.9214275" type="text"/></div></p>
		 <p><div class="input-append">work lng:  <input id="regwlng" value="-121.9214275" type="text"/></div></p>
		 <p><div class="input-append">referfbid:  <input id="referfbid" value="504711218" type="text"/></div></p>
		 <p><div class="input-append"><a class="btn btn-primary" onclick="regnewuser();">Create New Standard User</a>
		 
		 <p><label>fbid</label><div class="input-append">fbid: <input id="adminfbid" value="<?php echo "test".rand(1000,9000);?>" type="text"/></div></p>
		 <p><div class="input-append">first name: <input id="adminfname" value="Mark" type="text"/></div></p>
		 <p><div class="input-append">last name:  <input id="adminlname" value="Rose" type="text"/></div></p>
		 <p><div class="input-append">email:  <input id="adminemail" value="m1rose28@gmail.com" type="text"/></div></p>
		 <p><div class="input-append">company:  <input id="admincompany" value="Spacely Sprockets" type="text"/></div></p>
		 <p><div class="input-append">email syntax  <input id="adminemailsyntax" value="ss.com" type="text"/></div></p>
		 <p><div class="input-append">employees  <input id="adminemployees" value="300" type="text"/></div></p>
		 <p><div class="input-append">username  <input id="adminuser_key" value="m1rose@gmail.com" type="text"/></div></p>
		 <p><div class="input-append">password<input id="adminloginpassword" value="ridezu" type="text"/></div></p>
		 <p><div class="input-append"><a class="btn btn-primary" onclick="regnewadminuser();">Create an Admin user</a>
		 		 
		 <br><a class="btn" onclick="hidenewuser();">hide</a></div></p>
	 </div> 
	 </div></p>
	 
	 <p><div class="input-append"><a class="btn btn-primary" onclick="getusers();">Get all users</a></div></p>
	 <p><div class="input-append"><a class="btn btn-primary" onclick="getallrides();">Get all rides</a></div></p>
	 <p><div class="input-append"><input id="rideid" value="66" type="text"/><a class="btn btn-primary" onclick="getridebyid();">Get a ride by id</a></div></p>
	 <p><div class="input-append"><input id="userdetails" value="<?php echo $uid;?>" type="text"/><a class="btn btn-primary" onclick="getuserdetails();">Get user details</a></div></p>
	 <p><div class="input-append"><input id="rider1" value="<?php echo $uid;?>" type="text"/><a class="btn btn-primary" onclick="getridebyfbid();">Get list of rides for rider (Pass fbid of rider making the API call)</a></div></p>
	 <p><div class="input-append"><input id="rider2" value="<?php echo $uid;?>" type="text"/><input id="rider2route" value="h2w" type="text"/><input id="rider2date" value="<?php echo $d;?>" type="text"/><a class="btn btn-primary" onclick="getridebyfbidRtDt();">Get list of rides for rider 2 (Pass fbid of rider making the API call,route, eventtime)</a></div></p>
	 <p><div class="input-append"><input id="drivebyfbid" value="<?php echo $uid;?>" type="text"/><a class="btn btn-primary" onclick="getdriverbyfbid();">Get list of rides for driver (Pass fbid of driver making the API call)</a></div></p>
	 <p><div class="input-append"><input id="drivebyfbid" value="<?php echo $uid;?>" type="text"/><input id="ridebyroute" value="h2w" type="text"/><input id="ridebydate" value="<?php echo $d;?>" type="text"/><a class="btn btn-primary" onclick="getdriverbyfbidRtDt();">Get list of rides for driver 2 (Pass fbid of driver making the API call,route, eventtime)</a></div></p>
	 <p><div class="input-append"><input id="reqridefbid" value="<?php echo $uid;?>" type="text"/><input id="reqrideroute" value="h2w" type="text"/><input id="reqridetime" value="<?php echo $d." ".$time;?>" type="text"/><a class="btn btn-primary" onclick="requestnewride();">Request a ride (empty)</a></div></p>
	 <p><div class="input-append"><input id="selectridefbid" value="<?php echo $uid;?>" type="text"/><input id="selectrideid" value="rideid or driver" type="text"/><a class="btn btn-primary" onclick="selectridebyrider();">Request a ride (w/specific driver)</a></div></p>
	 <p><div class="input-append"><input id="postridefbid" value="<?php echo $uid;?>" type="text"/><input id="route" value="h2w" type="text"/><input id="postridetime" value="<?php echo $d." ".$time;?>" type="text"/><a class="btn btn-primary" onclick="postnewride();">Post a Ride (empty)</a></div></p>
	 <p><div class="input-append"><input id="driverfbid" value="<?php echo $uid;?>" type="text"/><input id="reqrideid" value="rideid of requestor" type="text"/><a class="btn btn-primary" onclick="postnewridewithrider();">Post a Ride (match with existing request)</a></div></p>
	 <p><div class="input-append"><input id="myriderfbid" value="<?php echo $uid;?>" type="text"/><a class="btn btn-primary" onclick="getriderride();">Get my ride details (use it to get your ride details)</a></div></p>
	 <p><div class="input-append"><input id="cancelfbid" value="<?php echo $uid;?>" type="text"/><input id="cancelrideid" value="3" type="text"/><a class="btn btn-primary" onclick="cancelride();">Cancel ride</a></div></p>
	 <p><div class="input-append"><input id="accountfbid" value="<?php echo $uid;?>" type="text"/><input id="timeperiod" value="Y" type="text"/><a class="btn btn-primary" onclick="account();">Account Summary</a></div></p>
	 <p><div class="input-append"><input id="accountdetailfbid" value="<?php echo $uid;?>" type="text"/><input id="detailtimeperiod" value="Y" type="text"/><a class="btn btn-primary" onclick="accountdetail();">Account Detail</a></div></p>
	 <p><div class="input-append"><input id="nodefbid" value="<?php echo $uid;?>" type="text"/><input id="nodetype" value="H" type="text"/><a class="btn btn-primary" onclick="nodes();">Get Nodes</a></div></p>
	 <p><div class="input-append"><input id="locfbid" value="<?php echo $uid;?>" type="text"/><a class="btn btn-primary" onclick="seeothers();">See others on my route</a></div></p>
	 <p><div class="input-append"><input id="login" value="login" type="text"/><input id="password" value="password" type="text"/><a class="btn btn-primary" onclick="loginuser();">Login</a></div></p>
	 <p><div class="input-append"><input id="clogin" value="login" type="text"/><input id="cpassword" value="old password" type="text"/><input id="cpassword1" value="new password" type="text"/><a class="btn btn-primary" onclick="changepassword();">Change Password</a></div></p>
	 <p><div class="input-append"><input id="nearbyfbid" value="<?php echo $uid;?>" type="text"/><input id="nearbyloc" value="H" type="text"/><a class="btn btn-primary" onclick="seenearby();">See users nearby</a></div></p>
	 <p><div class="input-append"><input id="companyfbid" value="<?php echo $uid;?>" type="text"/><input id="companyname" value="companyname" type="text"/><a class="btn btn-primary" onclick="getcorpdata();">Get corp data</a></div></p>
	 <p><div class="input-append"><input id="campusfbid" value="<?php echo $uid;?>" type="text"/><input id="companyid" value="3" type="text"/><a class="btn btn-primary" onclick="getcampusdata();">Get campus list</a></div></p>
		 
		 
	 <div class="modal" style="display:none;" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	   <div class="modal-header">
		 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		 <h3 id="myModalLabel">JSON Results</h3>
	   </div>
	   <div class="modal-body">
		 <p><div id="jsonresult"></div></p>
	   </div>
	 </div>
</form>
</div>

  </body>
</html>