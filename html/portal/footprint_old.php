<?php 
	
$title="Footprint";
include 'header.php';

//$c="Tesla";
$m="";
$q="";
$campus="";
$campusd="<select id=\"campus\" onchange=\"selectcampus();\"><option value=\"Select a campus\">Select a campus</option><option value=\"All\">All</option>";
if(isset($_GET["campus"])){$campus=addslashes($_GET["campus"]);}
$zoom="11";
$maplocation="37.39489870,-122.14929410";

if($campus!="" and $campus !="All"){
	$q=" and campus='$campus'";
	}
	
$query = "SELECT id,add1,city,state,latlong from footprint where latlong is not null and company='$c'".$q;

$footprintdata = mysql_query($query) or die(mysql_error());

if(mysql_num_rows($footprintdata)>1){

while($row = mysql_fetch_array($footprintdata)){

	$image="../images/start1.png";
	$latlong=$row[4];
	$id=urlencode($row[0]);
	$desc=urlencode($row[0]);

	if(strlen($latlong)>6){		
		$m=$m."newmarker(new google.maps.LatLng($latlong),'$image','$id','$desc')\n";
		}
	}

$query = "SELECT campus,worklatlong,count(id) from footprint where worklatlong is not null and company='$c' group by campus order by count(id) DESC";

$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){

	$image="../images/basecbmarker.png";
	$latlong=$row[1];
	$id=urlencode($row[0]);
	$desc=urlencode($row[0]);

	if(strlen($latlong)>6){		
		$m=$m."newmarker(new google.maps.LatLng($latlong),'$image','$id','$desc')\n";
		$campusd=$campusd."<option value=\"$row[0]\">$row[0]</option>";
		if($campus==$row[0]){
			$maplocation=$row[1];
			}
		}
	}

$campusd=$campusd."</select>";

?>
 

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


<div class="databox" style="display:none;">
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


		<section id="homepageintro">
			<div class="portalwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="../images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>Footprint Map</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">

				<div id="map_canvas" style="width:100%; height:700px;position:relative;top:-10px;left:-10px;"></div>
				
				<div id="control" style="position:relative;top:-700px;left:40px;z-index:3000;"><?php echo $campusd;?></div> 

<script>

// this function used to select the campus and update the page

		function selectcampus(){
			campus=document.getElementById('campus').value;
			url="footprint.php?campus="+campus;
			window.location=url;
			}

// this function sets a selected index on a dropdown

		function setSelectedIndex(s, v) {
			for ( var i = 0; i < s.options.length; i++ ) {
				if ( s.options[i].value == v ) {
				   s.options[i].selected = true;
				   return;				   
				}
			}
		}

	setSelectedIndex(document.getElementById('campus'),"<?php echo $campus;?>");

</script>

<script>
	  var m=new Array(); 
	  var d=new Array();
      var map;
      var geocoder;
      var infowindow = new google.maps.InfoWindow();
      var campus = new google.maps.LatLng(<?php echo $maplocation;?>);
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
          center: campus,
          zoom: <?php echo $zoom;?>,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          panControl: false,
  		  zoomControl: true,
  		  mapTypeControl: true,
		  scaleControl: true,
		  streetViewControl: false,
		  overviewMapControl: false
        };

        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

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
                
        }

    function centermap(center){
          map.setCenter(center);
          codeLatLng();
        }


<?php echo $m;?>

</script>

<?php 
}

if(mysql_num_rows($footprintdata)<1){ ?>


		<section id="homepageintro">
			<div class="portalwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="../images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>Footprint</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">				
					<div class="charttitle">Footprint Map</div>
					<div class="charttext">Have you ever seen a graphical representation of where your employees live, by campus?  The Ridezu Footprint shows you where your employees live and you can easily see where alternative transportation can make a big difference.</div>
					<br><img src="../images/footprint.png" style="margin-left:50px;"/>
				</div>
			</div>
		</section>



<?php }


include "footer.php";
?>
