<?php 

error_reporting(E_ALL); 
ini_set( 'display_errors','1');

$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("ridezu");

if(isset($_GET['m'])){
	$m=$_GET['m'];
	if($m=="p"){$p="pickup";}
	if($m=="c"){$p="company";}
	}
	
if(isset($_GET['m'])){
	$m=$_GET['m'];
	if($m=="p"){$p="pickup";}
	if($m=="c"){$p="company";}
	}
	
include 'header.php';

$m="";
$query = "SELECT id,name,city,state,latlong,spaces,lighting,bikeracks from ridenode";
$result = mysql_query($query) or die(mysql_error());

$c="<table class='table table-striped'>";
$c=$c."<tr><td>id</td><td>name</td><td>city</td><td>state</td><td>lat / long</td><td>spaces</td><td>lighting</td><td>bikeracks</td><td></td></tr>";

$c=$c."<tr><td></td>
	  <td><input id='name' type='text' value='' style='width:200px;'></td>
	  <td><input id='city' type='text' value='' style='width:100px;'></td>
	  <td><input id='state' type='text' value='' style='width:30px;'></td>
	  <td><input id='latlng' type='text' value='' style='width:280px;'></td>
	  <td><input id='spaces' type='text' value='' style='width:30px;'></td>
	  <td><input id='lighting' type='text' value='' style='width:30px;'></td>
	  <td><input id='bikeracks' type='text' value='' style='width:30px;'></td>
	  <td><a class=\"btn btn-primary\" onclick=\"addlocation()\">add</a></td>
	  </tr>";

while($row = mysql_fetch_array($result)){
	$c=$c."<tr><td>$row[0]</td><td><a href=\"#\" onclick=\"centermap(new google.maps.LatLng($row[4]));\">$row[1]</a></td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td><td>$row[7]</td>
	<td></tr>";
	$m=$m."newmarker(new google.maps.LatLng($row[4]));";

	}

$c=$c."</table>";	

?>


<div id="map_canvas" style="width:100%; height:350px;position:relative;top:-20px;"></div>
            </fieldset>

 
<script>
      var map;
      var geocoder;
      var infowindow = new google.maps.InfoWindow();
      var myhouse = new google.maps.LatLng(37.238167, -121.921297);
      var image = '../images/marker.png';

 
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

      function putcenter(ctr){
      	    x=ctr.lat()+","+ctr.lng();
      		document.getElementById('latlng').value=x;	 
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

	   function newlatlng(){
		var x=String(document.getElementById('address').value);
		alert(x);
		centermap(new google.maps.LatLng(x));	    
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
          marker = new google.maps.Marker({
                  position: a,
                  map: map,
                  icon:image
                  });
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
				  putcenter(ctr);
				  }
			  } else {
				  alert("Geocoder failed due to: " + status);
			  }
			  });
		  }
            
	}

    // This function calls jquery to load the map page
	loadMap();

    function newmarker(center){
          marker = new google.maps.Marker({
                  position: center,
                  map: map,
                  icon:image
                  });   
        }

    function centermap(center){
          map.setCenter(center)
        }


<?php echo $m;?>

</script>




<div style="padding-left:10px;">

<br>
<?php echo $c; ?>
</div>

<div class="input-append" style="position:absolute;top:115px;left:40px;">
<input style="width:300px;" id="address" type="text" value="">
<a class="btn btn-primary" onclick="codeAddress()">Search for address</a>

</div>

  </body>
</html>