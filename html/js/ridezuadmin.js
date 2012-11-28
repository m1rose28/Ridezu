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
			myinfo.seckey=userdata[id].seckey;
			myinfo.fbid=userdata[id].fbid;
			myinfo.first_name=userdata[id].fname;
			myinfo.last_name=userdata[id].lname;
			myinfo.add1=userdata[id].add1;
			myinfo.city=userdata[id].city;
			myinfo.state=userdata[id].state;	
			myinfo.zip=userdata[id].zip;
			myinfo.workadd1=userdata[id].workadd1;
			myinfo.workcity=userdata[id].workcity;
			myinfo.workstate=userdata[id].workstate;	
			myinfo.workzip=userdata[id].workzip;
			myinfo.email=userdata[id].email;
			myinfo.originlatlong=userdata[id].originlatlong;
			myinfo.destlatlong=userdata[id].destlatlong;
			myinfo.homelatlong=userdata[id].homelatlong;
			myinfo.worklatlong=userdata[id].worklatlong;

			testdata="Logged in as: "+myinfo.fname+" "+myinfo.lname+" : "+myinfo.fbid;
			testlink="<a class='tlink' href='/test/servicetest.php?uid="+myinfo.fbid+"' target='ridezutest'>"+testdata+"</a>";
			document.getElementById('testbar').innerHTML=testlink;

			loadmyinfo();
		}
		
