<?php 
	
$m="";
	
include 'header.php';

$query = "SELECT id,name,city,state,latlong,type,custommarker from ridenode";
$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){

	if($row['type']=="Company"){$image="../images/start3.png";}
	if($row['type']=="Park and Ride"){$image="../images/start.png";}
	if($row['custommarker']<>""){$image="../images/".$row['custommarker'].".png";}			
	$m=$m."newmarker(new google.maps.LatLng($row[4]),'$image','{\"name\":\"$row[1]\",\"city\":\"$row[2]\",\"state\":\"$row[3]\",\"latlong\":\"$row[4]\",\"type\":\"$row[5]\"}','$row[0]')\n";

	}

$query = "SELECT fbid,fname,lname,add1,city,state,zip,homelatlong,workadd1,workcity,workstate,workzip,worklatlong,origindesc,originlatlong,destdesc,destlatlong,createdon from userprofile";
$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){

	$image="../images/start2.png";
	
	if($row['origindesc']=="" or $row['destdesc']==""){
		$image="../images/start1.png";
		}	
		
	$m=$m."newmarker(new google.maps.LatLng($row[7]),'$image','{\"name\":\"$row[1] $row[2]\",\"homeadd1\":\"$row[3]\",\"homecity\":\"$row[4]\",\"homestate\":\"$row[5]\",\"homezip\":\"$row[6]\",\"homelatlong\":\"$row[7]\",\"workadd1\":\"$row[8]\",\"workcity\":\"$row[9]\",\"workstate\":\"$row[10]\",\"workzip\":\"$row[11]\",\"worklatlong\":\"$row[12]\",\"origindesc\":\"$row[13]\",\"originlatlong\":\"$row[14]\",\"destdesc\":\"$row[15]\",\"destlatlong\":\"$row[16]\",\"createdon\":\"$row[17]\",\"type\":\"person\"}','$row[0]h')\n";
	$m=$m."newmarker(new google.maps.LatLng($row[12]),'$image','{\"name\":\"$row[1] $row[2]\",\"homeadd1\":\"$row[3]\",\"homecity\":\"$row[4]\",\"homestate\":\"$row[5]\",\"homezip\":\"$row[6]\",\"homelatlong\":\"$row[7]\",\"workadd1\":\"$row[8]\",\"workcity\":\"$row[9]\",\"workstate\":\"$row[10]\",\"workzip\":\"$row[11]\",\"worklatlong\":\"$row[12]\",\"origindesc\":\"$row[13]\",\"originlatlong\":\"$row[14]\",\"destdesc\":\"$row[15]\",\"destlatlong\":\"$row[16]\",\"createdon\":\"$row[17]\",\"type\":\"person\"}','$row[0]w')\n";

	}

?>
 
<div id="map_canvas" style="width:100%; height:700px;position:relative;top:-20px;"></div>
 
<script>
	  var m=new Array(); 
	  var d=new Array();
      var map;
      var geocoder;
      var infowindow = new google.maps.InfoWindow();
      var myhouse = new google.maps.LatLng(37.37215338177725,-121.97491978845215);
      var pimage = '../images/basepmarker.png';
      var cimage = '../images/basepmarker.png';

 
	  function addlocation(){
			name1=document.getElementById('name').value;
			city1=document.getElementById('city').value;
			state1=document.getElementById('state').value;
			latlng1=document.getElementById('latlng').value;
			lighting1=document.getElementById('lighting').value;
			bikeracks1=document.getElementById('bikeracks').value;
			spaces1=document.getElementById('spaces').value;

		    var request=$.ajax({
				type: "POST",
				url: "ajax.php",
				data: { function:"add", name: name1, city: city1, state: state1, latlng: latlng1, lighting: lighting1, spaces: spaces1, bikeracks:bikeracks1},
                success: function(data) {if(data=="ride node added"){alert("Thanks! "+name1+" was added to the database.")}},
                error: function(data) { alert("rats, I got an eror Mark:"+JSON.stringify(data)); },
            });
	  }

	  function deletelocation(id){

		    var request=$.ajax({
				type: "POST",
				url: "ajax.php",
				data: { function:"delete", id: id},
                success: function(data) {alert("Thanks! This item was removed from the database.")},
                error: function(data) { alert("boo!"+JSON.stringify(data)); },
            });
	  }


      function HomeControl(controlDiv, map) {

        // Set CSS styles for the DIV containing the control
        // Setting padding to 5 px will offset the control
        // from the edge of the map
        controlDiv.style.padding = '5px';

        // Set CSS for the control border
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = 'white';
        controlUI.style.borderStyle = 'solid';
        controlUI.style.borderWidth = '2px';
        controlUI.style.cursor = 'pointer';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Click to set the map to Home';
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior
        var controlText = document.createElement('div');
        controlText.style.fontFamily = 'Arial,sans-serif';
        controlText.style.fontSize = '12px';
        controlText.style.paddingLeft = '4px';
        controlText.style.paddingRight = '4px';
        controlText.innerHTML = '<b>Home</b>';
        controlUI.appendChild(controlText);

        // Setup the click event listeners: simply set the map to
        // myhouse
        google.maps.event.addDomListener(controlUI, 'click', function() {
          map.setCenter(myhouse)
        });

      }

	  function Target(targetDiv,map){
		var controlText = document.createElement('div');
        controlText.innerHTML = '<b>Home</b>';
        controlUI.appendChild(controlText);
	  }

	   
		function codeAddress() {
		  var address = document.getElementById('address').value;
		  geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
			  map.setCenter(results[0].geometry.location);

			} else {
			  alert('Geocode was not successful for the following reason: ' + status);
			}
		  });
		}

	function loadMap(){
      
        geocoder = new google.maps.Geocoder();
        var mapOptions = {
          center: myhouse,
          zoom: 14,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          panControl: false,
  		  zoomControl: true,
  		  mapTypeControl: true,
		  scaleControl: true,
		  streetViewControl: false,
		  overviewMapControl: false
        };

        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

        // Create the DIV to hold the control and
        // call the HomeControl() constructor passing
        // in this DIV.
        var homeControlDiv = document.createElement('div');
        var targetDiv = document.createElement('div');
        
                targetDiv.innerHTML = '<img style="margin-top:-30px;" src="../images/circle.png"/>';
				targetDiv.style.postion = 'absolute';
				targetDiv.style.left = '50%';
				targetDiv.style.top = '50%';
				targetDiv.style.height = '50px';

        google.maps.event.addDomListener(targetDiv, 'click', function() {
          a=map.getCenter();
          codeLatLng();
          });
   
        
        var homeControl = new HomeControl(homeControlDiv, map);

        homeControlDiv.index = 1;
        targetDiv.index = 1;
        
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);
        map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(targetDiv);
         	
    	// this function turns late long into a real address



		
		function codeLatLng() {
			  var ctr = map.getCenter();
			  var lat = ctr.lat();
			  var lng = ctr.lng();
			  var latlng = new google.maps.LatLng(lat, lng);
			  geocoder.geocode({'latLng': latlng}, function(results, status) {
			  if (status == google.maps.GeocoderStatus.OK) {
				  if (results[1]) {
						document.getElementById('addr0').innerHTML=results[0].formatted_address;	 
   				   	    x=ctr.lat()+",<br>"+ctr.lng();
      					document.getElementById('latlong0').innerHTML=x;
      					document.getElementById("type").innerHTML="Custom Location";
      					showbox("empty");
   	 				  }
			  } else {
				  alert("Geocoder failed due to: " + status);
			  }
			  });
		  }
            
	}
	
	function showbox(box){
		document.getElementById("person").style.display="none";
		document.getElementById("location").style.display="none";
		document.getElementById("empty").style.display="none";
		document.getElementById(box).style.display="block";
		}
		
    // This function calls jquery to load the map page
	loadMap();

    function newmarker(center,image,description,id){
          m[id] = new google.maps.Marker({
                  position: center,
                  map: map,
                  icon:image
                  });
        
        google.maps.event.addListener(m[id], 'click', function() {
	            d[id]=description;        
      		    x=JSON.parse(d[id]);  
      		    if(x.type=="Park and Ride" || x.type=="Company" || x.type=="City Center"){ 
					document.getElementById("type").innerHTML=x.type;
					document.getElementById("name1").innerHTML=x.name;
					document.getElementById("city").innerHTML=x.city;
					document.getElementById("state").innerHTML=x.state;
					y=x.latlong.split(",");
					document.getElementById("latlong").innerHTML=y[0]+","+y[1];
					map.setCenter(new google.maps.LatLng(y[0],y[1]));
					showbox("location");
					}
      		    if(x.type=="person"){ 
					document.getElementById("type").innerHTML=x.type;
					document.getElementById("username").innerHTML=x.name;
					document.getElementById("homeadd1").innerHTML=x.homeadd1;
					document.getElementById("homecity").innerHTML=x.homecity;
					document.getElementById("homestate").innerHTML=x.homestate;
					document.getElementById("homezip").innerHTML=x.homezip;
					y=x.homelatlong.split(",");
					document.getElementById("homelatlong").innerHTML="<a href='#' onclick='map.setCenter(new google.maps.LatLng(y[0],y[1]))'>"+y[0]+","+y[1]+"</a>";
					document.getElementById("workadd1").innerHTML=x.workadd1;
					document.getElementById("workcity").innerHTML=x.workcity;
					document.getElementById("workstate").innerHTML=x.workstate;
					y=x.worklatlong.split(",");
					document.getElementById("worklatlong").innerHTML="<a href='#' onclick='map.setCenter(new google.maps.LatLng(y[0],y[1]))'>"+y[0]+","+y[1]+"</a>";
					document.getElementById("origindesc").innerHTML=x.origindesc;
					y=x.originlatlong.split(",");
					document.getElementById("originlatlong").innerHTML="<a href='#' onclick='map.setCenter(new google.maps.LatLng(y[0],y[1]))'>"+y[0]+","+y[1]+"</a>";
					document.getElementById("destdesc").innerHTML=x.destdesc;
					y=x.destlatlong.split(",");
					document.getElementById("destlatlong").innerHTML="<a href='#' onclick='map.setCenter(new google.maps.LatLng(y[0],y[1]))'>"+y[0]+","+y[1]+"</a>";
					document.getElementById("createdon").innerHTML=x.createdon;
					showbox("person");
					}

				});
        
        }

    function centermap(center){
          map.setCenter(center);
          codeLatLng();
        }


<?php echo $m;?>

</script>

<style>
.databox{
position:absolute;
top:165px;
left:35px;
padding:10px;
border-radius:10px;
background-color:#ffffff;
width:300px;
opacity:.9;
}

</style>




<div class="databox">
	 <div id="empty" style="display:none;">
		 <b>Address:</b>
		 <br>
		 <span id="addr0"></span>
		 <br><br>
		 <span id="latlong0"></span>
		 <br><br>	 
	 </div>
	 
	 <div id="location" style="display:none;">
		 <b>Name:</b>
		 <br>
		 <span id="name1"></span> (<span id="type"></span>)
		 <br>
		 <span id="city"></span> <span id="state"></span>
		 <br>
		 <span id="latlong"></span>
		 <br><br>
	</div>
	
	 <div id="person" style="display:none;">
		 <b>Name:</b>
		 <br>
		 <span id="username"></span>
		 <br><br>
		 <b>Home Address:</b>
		 <br>
		 <span id="homeadd1"></span>
		 <br>
		 <span id="homecity"></span>, <span id="homestate"></span> <span id="homezip"></span>
		 <br>
		 <span id="homelatlong"></span>
		 <br><br>
		 <b>Work Address:</b>
		 <br>
		 <span id="workadd1"></span>
		 <br>
		 <span id="workstate"></span>, <span id="workcity"></span> <span id="workzip"></span>
		 <br>
		 <span id="worklatlong"></span>
		 <br><br>
		 <b>Pickup Location:</b>
		 <br>
		 <span id="origindesc"></span>
		 <br>
		 <span id="originlatlong"></span>
		 <br><br>		 
		 <b>Destination Location:</b>
		 <br>
		 <span id="destdesc"></span>
		 <br>
		 <span id="destlatlong"></span>
		 <br><br>
		 Created on: <span id="createdon"></span>

		 <br><br>			 
	</div>	 
</div>

<div class="input-append" style="position:absolute;top:125px;left:40px;">
<input style="width:300px;" id="address" type="text" value="">
<a class="btn btn-primary" onclick="codeAddress()">Search for address</a>

</div>

  </body>
</html>