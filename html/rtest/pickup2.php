<?php 
	
$m="";

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
	
include 'header.php';
require '../ridezu/api/util.php';

function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return $miles; 
	}

$query = "SELECT fbid,fname,lname,add1,city,state,zip,homelatlong,workadd1,workcity,workstate,workzip,worklatlong,origindesc,originlatlong,destdesc,destlatlong,createdon,campus,email from userprofile";

$carpoolmaxdistance=2;

$company="";

// first let's see if there are any pending jobs (this is in notifications)

$db = getConnection();
$sth = $db->prepare($query);
$sth->execute();
$data = $sth->fetchAll();

//echo "<pre>";	
//print_r($data);
//echo "</pre>";	

foreach($data as $key=>$row){

	$image="../images/start1.png";	
	$image2="../images/basecbmarker.png";
    $home=explode(",",$row[7]);
    $work=explode(",",$row[12]);
    $commute=round(getDistanceBetweenPointsNew($home[0], $home[1], $work[0], $work[1]));
	
	$c=0;
	
	foreach($data as $key1=>$row1){
		$home1=explode(",",$row1[7]);
		$y=getDistanceBetweenPointsNew($home[0], $home[1], $home1[0], $home1[1]);
		if($y<$carpoolmaxdistance and $row1['fbid']!=$row['fbid']){
			$c++;
			}
		}
			
	$m=$m."newmarker(new google.maps.LatLng($row[7]),'$image','{\"c\":\"$c\",\"commute\":\"$commute\",\"fbid\":\"$row[0]\",\"name\":\"$row[1] $row[2]\",\"homeadd1\":\"$row[3]\",\"homecity\":\"$row[4]\",\"homestate\":\"$row[5]\",\"homezip\":\"$row[6]\",\"homelatlong\":\"$row[7]\",\"workadd1\":\"$row[8]\",\"workcity\":\"$row[9]\",\"workstate\":\"$row[10]\",\"workzip\":\"$row[11]\",\"worklatlong\":\"$row[12]\",\"origindesc\":\"$row[13]\",\"originlatlong\":\"$row[14]\",\"destdesc\":\"$row[15]\",\"destlatlong\":\"$row[16]\",\"createdon\":\"$row[17]\",\"type\":\"person\",\"campus\":\"$row[18]\",\"email\":\"$row[19]\"}','$row[0]h')\n";
	$m=$m."newmarker(new google.maps.LatLng($row[12]),'$image2','{\"c\":\"$c\",\"commute\":\"$commute\",\"fbid\":\"$row[0]\",\"name\":\"$row[1] $row[2]\",\"homeadd1\":\"$row[3]\",\"homecity\":\"$row[4]\",\"homestate\":\"$row[5]\",\"homezip\":\"$row[6]\",\"homelatlong\":\"$row[7]\",\"workadd1\":\"$row[8]\",\"workcity\":\"$row[9]\",\"workstate\":\"$row[10]\",\"workzip\":\"$row[11]\",\"worklatlong\":\"$row[12]\",\"origindesc\":\"$row[13]\",\"originlatlong\":\"$row[14]\",\"destdesc\":\"$row[15]\",\"destlatlong\":\"$row[16]\",\"createdon\":\"$row[17]\",\"type\":\"person\",\"campus\":\"$row[18]\",\"email\":\"$row[19]\"}','$row[0]w')\n";

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

	function loadMap(){
      
        geocoder = new google.maps.Geocoder();
        var mapOptions = {
          center: myhouse,
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          panControl: false,
  		  zoomControl: true,
  		  mapTypeControl: true,
		  scaleControl: true,
		  streetViewControl: false,
		  overviewMapControl: false
        };

        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
            
	}
	
	function showbox(){
		document.getElementById("databox").style.display="block";
		}

	function hidebox(){
		document.getElementById("databox").style.display="none";
		}
		
    function newmarker(center,image,description,id){
          m[id] = new google.maps.Marker({
                  position: center,
                  map: map,
                  icon:image
                  });
        
        google.maps.event.addListener(m[id], 'click', function() {
	            d[id]=description;        
      		    x=JSON.parse(d[id]);  
      		    if(x.type=="person"){ 
					if(x.fbid.indexOf("@") == -1){
						document.getElementById("picbox").innerHTML="<image src='https://graph.facebook.com/"+x.fbid+"/picture'/>";
						}
					if(x.fbid.indexOf("@") !== -1){
						document.getElementById("picbox").innerHTML="<image src='../images/nopic.jpg'>";
						}						
					document.getElementById("username").innerHTML=x.name;
					document.getElementById("email").innerHTML="<a href='mailto:"+x.email+"' target='newemail'>"+x.email+"</a>";
					document.getElementById("homeadd1").innerHTML=x.homeadd1;
					document.getElementById("homecity").innerHTML=x.homecity;
					document.getElementById("homestate").innerHTML=x.homestate;
					document.getElementById("homezip").innerHTML=x.homezip;
					document.getElementById("campus").innerHTML=x.campus;
					document.getElementById("commute").innerHTML="Commute: "+x.commute+" miles";
					document.getElementById("carpoolpartners").innerHTML="Potential carpoolers: "+x.c;
					showbox();
					}

				});
        
        }

	loadMap();


<?php echo $m;?>

</script>

<style>
#databox{
position:absolute;
top:185px;
left:100px;
padding:10px;
border-radius:10px;
background-color:#ffffff;
width:300px;
opacity:.9;
display:none;
}

#picbox{
float:left;
width:75px;
}

#picbox img{
width:65px;
}

#person{
float:left;
}

#username{
font-size:20px;
color:#4c4c4c;
}

#campus{
font-size:12px;
color:#4c4c4c;
}

</style>




<div id="databox" onclick="hidebox();">
	 <div id="person">
		 <div>
			<div id="picbox"></div>
			<div id="person">
			   <span id="username"></span>
			   <br>
			   <span id="campus"></span>
			   <br>
			   <span id="email"></span>
			   <br>
			   <span id="homeadd1"></span>
			   <br>
			   <span id="homecity"></span>, <span id="homestate"></span> <span id="homezip"></span>
			   <br><br>
			   <span id="commute"></span>
			   <br>
			   <span id="carpoolpartners"></span>
			</div>
	</div>	 
</div>

</div>

  </body>
</html>