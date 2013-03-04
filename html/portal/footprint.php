<?php 
	
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
$title="Footprint";
include 'header.php';
require '../ridezu/api/util.php';


$m="";
$q="";
$campus="";
$zoom="11";
$maplocation="37.39489870,-122.14929410";

// this gets the campus data and paints the drop down menu

	$campusd="<select id=\"campus\" onchange=\"selectcampus();\"><option value=\"Select a campus\">Select a campus</option><option value=\"All\">All</option>";
	if(isset($_GET["campus"])){$campus=addslashes($_GET["campus"]);}
	$sql = "select campusname,latlong from campus where companyname=:companyname and isDeleted is NULL";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("companyname", $companyname);
	$stmt->execute();
	$campuses = $stmt->fetchAll(PDO::FETCH_ASSOC); 
	$db=null;

	foreach($campuses as $key=>$value){
		$c1=$value['campusname'];
		$c2=$value['latlong'];
		$campusd=$campusd."<option value=\"".$c1."\">".$c1."</option>";
		}
	$campusd=$campusd."</select>";

if($campus!="" and $campus !="All"){
	$q=" and campus='$campus'";
	}
	
function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return $miles; 
	}

$query = "SELECT fbid,fname,lname,add1,city,state,zip,homelatlong,workadd1,workcity,workstate,workzip,worklatlong,origindesc,originlatlong,destdesc,destlatlong,createdon,campus,email from userprofile where company='$companyname'".$q;

$carpoolmaxdistance=2;

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
	$cx="";
	
	foreach($data as $key1=>$row1){
		$home1=explode(",",$row1[7]);
		$y=getDistanceBetweenPointsNew($home[0], $home[1], $home1[0], $home1[1]);
		if($y<$carpoolmaxdistance and $row1['fbid']!=$row['fbid']){
			$c++;
			}
		}
	
	$m=$m."newmarker(new google.maps.LatLng($row[7]),'$image','{\"c\":\"$c\",\"commute\":\"$commute\",\"fbid\":\"$row[0]\",\"name\":\"$row[1] $row[2]\",\"homeadd1\":\"$row[3]\",\"homecity\":\"$row[4]\",\"homestate\":\"$row[5]\",\"homezip\":\"$row[6]\",\"homelatlong\":\"$row[7]\",\"workadd1\":\"$row[8]\",\"workcity\":\"$row[9]\",\"workstate\":\"$row[10]\",\"workzip\":\"$row[11]\",\"worklatlong\":\"$row[12]\",\"origindesc\":\"$row[13]\",\"originlatlong\":\"$row[14]\",\"destdesc\":\"$row[15]\",\"destlatlong\":\"$row[16]\",\"createdon\":\"$row[17]\",\"type\":\"person\",\"campus\":\"$row[18]\",\"email\":\"$row[19]\"}','$row[0]h')\n";
	
	if($cx!=$row[18]){	
		$m=$m."newmarker(new google.maps.LatLng($row[12]),'$image2','{\"c\":\"$c\",\"commute\":\"$commute\",\"fbid\":\"$row[0]\",\"name\":\"$row[1] $row[2]\",\"homeadd1\":\"$row[3]\",\"homecity\":\"$row[4]\",\"homestate\":\"$row[5]\",\"homezip\":\"$row[6]\",\"homelatlong\":\"$row[7]\",\"workadd1\":\"$row[8]\",\"workcity\":\"$row[9]\",\"workstate\":\"$row[10]\",\"workzip\":\"$row[11]\",\"worklatlong\":\"$row[12]\",\"origindesc\":\"$row[13]\",\"originlatlong\":\"$row[14]\",\"destdesc\":\"$row[15]\",\"destlatlong\":\"$row[16]\",\"createdon\":\"$row[17]\",\"type\":\"campus\",\"campus\":\"$row[18]\",\"email\":\"$row[19]\"}','$row[0]h')\n";
		$cx=$row[18];
		}
	
	}

if(count($campuses)>0){

$query = "SELECT campus,worklatlong,count(id) from userprofile where worklatlong is not null and company='$company' group by campus order by count(id) DESC";

$db = getConnection();
$sth = $db->prepare($query);
$sth->execute();
$data = $sth->fetchAll();

//echo $company;
//print_r($data);
//exit;

foreach($data as $key=>$row){

	$image="../images/basecbmarker.png";
	$latlong=$row[1];
	$campusname=$row[0];
	$desc=urlencode($row[0]);

	if(strlen($latlong)>6){		
		$m=$m."newmarker(new google.maps.LatLng($latlong),'$image','{\"type\":\"campus\",\"campusname\":\"$campusname\"}','$desc')\n";
		$campusd=$campusd."<option value=\"$row[0]\">$row[0]</option>";
		if($campus==$row[0]){
			$maplocation=$row[1];
			}
		}
	}

$campusd=$campusd."</select>";

?>
 
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

				<div id="control" style="position:relative;top:0px;left:80px;z-index:3000;"><?php echo $campusd;?></div> 

				<div id="map_canvas" style="width:100%; height:700px;position:relative;top:-35px;left:-10px;"></div>
				 
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
					
					function showbox(id){
						document.getElementById("databox").style.display="block";
						if(id=="user"){
							document.getElementById("userbox").style.display="block";
							document.getElementById("campusnamebox").style.display="none";
							}
						if(id=="campus"){
							document.getElementById("campusnamebox").style.display="block";
							document.getElementById("userbox").style.display="none";
							}
						}
				
					function hidebox(){
						document.getElementById("databox").style.display="none";
						document.getElementById("userbox").style.display="none";
						document.getElementById("campusnamebox").style.display="none";

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
									document.getElementById("mycampus").innerHTML=x.campus;
									document.getElementById("commute").innerHTML="Commute: "+x.commute+" miles";
									document.getElementById("carpoolpartners").innerHTML="Potential carpoolers: "+x.c;
									showbox("user");
									}
								if(x.type=="campus"){ 
									document.getElementById("campusname").innerHTML=x.campus;
									showbox("campus");
									}
				
								});
						
						}
				
					loadMap();
				
				
				<?php echo $m;?>
				
				</script>
				
				<style>
				
				#databox{
				position:absolute;
				top:50px;
				left:90px;
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
				
				#mycampus{
				font-size:16px;
				color:#4c4c4c;
				}
				
				#person a {
				color:#0066cc;
				}
				</style>
							
				<div id="databox" onclick="hidebox();">
					 <div id="userbox" style="display:none;">
							<div id="picbox"></div>
							<div id="person">
							   <span id="username"></span>
							   <br>
							   <span id="mycampus"></span>
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
					 <div id="campusnamebox" style="display:none;">
							<div id="campusname"></div>
					</div>


						 
				</div>
				
				</div>


<?php 
}

if(count($campuses)<1){ ?>

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



<?php } ?>

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


<?php
include "footer.php";
?>
