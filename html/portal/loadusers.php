<?php

$title="Load Users";
	
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require '../ridezu/api/util.php';
	
include 'header.php';

$c=0;
$e=0;
$content="";
$error="";
		
if (!empty($_FILES))
{
    $d=file_get_contents($_FILES['file']['tmp_name']);
    
	// this gets the campus data and puts it into an array to validate against
	$campusarray=array();
	$campuslocation=array();
	$sql = "select campusname,latlong from campus where companyname=:companyname and isDeleted is NULL";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("companyname", $companyname);
	$stmt->execute();
	$campuses = $stmt->fetchAll(PDO::FETCH_ASSOC); 
	$db=null;

	foreach($campuses as $key=>$value){
		array_push($campusarray,$value['campusname']);
		$campuslocation[$value['campusname']]=$value['latlong'];
		}
		
	//print_r($campuslocation);

	//this is a function to validate zip code
	function validateUSAZip($zip_code)
	{
	  if(preg_match("/^([0-9]{5})(-[0-9]{4})?$/i",$zip_code))
		return true;
	  else
		return false;
	}	

	//this is a function validate email
	function validateemail($email) 
	{
		return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email);
		}
		
	//this is a function validate string
	function validatestring($data) {
		if($data!=""){return true;}
		if($data==""){return false;}
		}	
    
	$d1 = explode("\r", $d);

    //print_r($d1);
    $content="";

    
    foreach($d1 as $key=>$value){
    	$l1 = explode(",", $value);
  
    	if($l1[0]!="id"){
    	
    		$error="";
			if(validatestring($l1[0])==false){
				$error.="<div class='errordetail'>Error: missing id</div>";
				}
			if(validatestring($l1[1])==false){
				$error.="<div class='errordetail'>Error: missing first name</div>";
				}
			if(validatestring($l1[2])==false){
				$error.="<div class='errordetail'>Error: missing last name</div>";
				}
			if(validatestring($l1[3])==false){
				$error.="<div class='errordetail'>Error: missing street addresss</div>";
				}		
			if(validatestring($l1[4])==false){
				$error.="<div class='errordetail'>Error: missing city</div>";
				}
			if(validatestring($l1[5])==false){
				$error.="<div class='errordetail'>Error: missing state</div>";
				}			 
			if(validateUSAZip($l1[6])==false){
				$error.="<div class='errordetail'>Error: invalid zip code</div>";
				}
			if(validateemail($l1[7])==false){
				$error.="<div class='errordetail'>Error: invalid email</div>";
				}
			if(validatestring($l1[8])==false){
				$error.="<div class='errordetail'>Error: missing campus</div>";
				}
	
			if(count($l1)<9){
				$error.="<div class='errordetail'>Error: missing field.  hint:  is there a missing field here?</div>";
				}
			if(count($l1)>9){
				$error.="<div class='errordetail'>Error: extra field.  hint:  is there an extra comma here?</div>";
				}
			if(in_array($l1[8], $campusarray)==false){
				$error.="<div class='errordetail'>Error: this is not a valid campus</div>";
				}

			if($error<>"")
					{
					$content.="<br>Line:  ".$d1[$key].$error;
					$e++;
					}
			
			if($error==""){$c++;}
							
			}
	   }
 
 	if($e>0){
 		$content="<div class='error'>Good effort, but we found some errors.  Please correct these errors and try again.<br>".$content."</div>";
		}
    
	if($e==0){

	   $e1=0;
	   $c1=0;
	   
	   foreach($d1 as $key=>$value){  //loop through the items and add to db
		   $l1 = explode(",", $value);
	 
	 	   //add all the records into newemployee staging
	 	   
		   if($l1[0]!="id"){
				try { 
					$sql = "INSERT INTO newemployeestaging (corpid, fname, lname, add1, city,state,zip,email,campus,company,campuslatlong) 
					VALUES (:corpid, :fname, :lname, :add1, :city, :state, :zip, :email, :campus, :company,:campuslatlong)";
					$db = getConnection();
					$stmt = $db->prepare($sql);
					$stmt->bindParam("corpid", $l1[0]);
					$stmt->bindParam("fname", $l1[1]);
					$stmt->bindParam("lname", $l1[2]);
					$stmt->bindParam("add1", $l1[3]);
					$stmt->bindParam("city", $l1[4]);
					$stmt->bindParam("state", $l1[5]);
					$stmt->bindParam("zip", $l1[6]);
					$stmt->bindParam("email", $l1[7]);
					$stmt->bindParam("campus", $l1[8]);
					$stmt->bindParam("company", $companyname);
					$stmt->bindParam("campuslatlong", $campuslocation[$l1[8]]);
					$stmt->execute();
					$c1++;
					$db=null;
					}
			
			//if the user already exists then update the record and set the lat long to zero.  this allows admins to correct for address info and new campus information
				catch (PDOException $e1){
				 	if($e1->getCode()=="23000"){
				 		$sql = "update newemployeestaging set fname=:fname, lname=:lname,add1=:add1,city=:city,state=:state,zip=:zip,campus=:campus,campuslatlong=:campuslatlong,latlong=null,source=null 
				 		where company=:company and email=:email";
						
						$db = getConnection();
						$stmtu = $db->prepare($sql);
						$stmtu->bindParam("fname", $l1[1]);
						$stmtu->bindParam("lname", $l1[2]);
						$stmtu->bindParam("add1", $l1[3]);
						$stmtu->bindParam("city", $l1[4]);
						$stmtu->bindParam("state", $l1[5]);
						$stmtu->bindParam("zip", $l1[6]);
						$stmtu->bindParam("email", $l1[7]);
						$stmtu->bindParam("campus", $l1[8]);
						$stmtu->bindParam("company", $companyname);
						$stmtu->bindParam("campuslatlong", $campuslocation[$l1[8]]);
						$stmtu->execute();
						$c1++;
						$db=null;

				 		}
				 	}
		   		}
		   }	
		
		//add a newjob for processing

		$sql = "INSERT INTO newemployeeload (company,email,status,totalrecords) 
		VALUES (:company, :email, :status, :totalrecords)";
		$db = getConnection();
		$status="PENDING";
		$stmt = $db->prepare($sql);
		$stmt->bindParam("company", $companyname);
		$stmt->bindParam("email", $email);
		$stmt->bindParam("status", $status);
		$stmt->bindParam("totalrecords", $c);
		try { 
			$stmt->execute();
			}
		catch (PDOException $e){
			//echo $e->getMessage();
			}
	
		$content="<div class='success'>Terrific, your data looks good! <br><br>We've imported $c employees and we're are getting to work.  Typically this takes about an hour.  As soon as your footprint analysis is done, we'll send you an email.   </div>";
		}
    
    //echo "</pre>";
}
?>

		<section id="homepageintro">
			<div class="portalwrapper">
				<div id="corpmain">
					<div id="slider">
						<img class="slide" src="../images/bannerimage.jpg" alt="San Francisco" />
					</div>
					
					<div id="corptitle" class="index80">
						<h2>Campus Locations and Users</h2>
					</div>
					
				</div>
			</div>
		</section>
		
		<section>
			<div class="portalwrapper">

				<div id="portalcontent" class="left contact">				

						<div class="charttitle">Campus Details</div>
						<div class="charttext">Add your company locations here (please use exact street addresses).  Each employee will need to be designated to a campus.
						<br>
						<div id="highlightbox">
							<div id="campus_list"></div>
						</div>
						<div id="addcampus" style="display:none;">
							<input class="arvo1" type="text" value="Enter a campus name" id="campusname" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">
							<input class="arvo1" type="text" value="Enter a location" id="campusaddress" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">
						</div>
						<div class="greenbutton" onclick="addcampus();"/>Add Campus</div>
						</div>

						<br>
						<br>
						<div class="charttitle">Users</div>
					<?php echo $content;if($c==0 || $e>0){?>
						<div class="charttext">Upload your employees via a simple .csv file.  Please use our <a class="plink" href="../images/testfile.csv" target="new">test file template</a>.   View <a class="plink" onclick="showformat();">field descriptions</a>.
						<br>
						<form action="loadusers.php" id="myForm" method="POST" name="myForm" enctype="multipart/form-data">

							<!-- filename to display to the user -->
							<p id="file-name"></p>
						
							<!-- Hide this from the users view with css display:none; -->
							<input style="display:none;" id="file-type" type="file" size="4" name="file"/>
						
							<!-- Style this button with type image or css whatever you wish -->
							<div id="browse-click" style="display:block;" class="greybutton" type="button"/>Browse</div>
						
							<!-- submit button -->
							<input id="startbutton" style="display:none;" type="submit" value="Load Users"/>

						</form>						
						<br>Your employee data is 100% secure and private.</br>
						</div>
					<?php } ?>
				</div>
			</div>
		</section>

<script>

	$(window).load(function () {
		var intervalFunc = function () {
			$('#file-name').html($('#file-type').val().split('\\').pop());
			if(document.getElementById('file-name').innerHTML!=""){
				document.getElementById('startbutton').style.display="block";
				}
		};
		$('#browse-click').live('click', function () {
			$('#file-type').click();
			setInterval(intervalFunc, 1);
			return false;
		});
	});

	function showformat(){
		message="<h2>Load User File Format</h2>";
		message+="<p>Please send a valid .csv (comma delimited) file.  We find it's easiest to make this in Excel and then save as .csv file format.";
		message+="<p>id.  This is an id that is unique to the employee.  This can be an email, or a number, or a text string.";
		message+="<p>First name.  This is the employee's first name.";
		message+="<p>Last name.  This is the employee's last name.";
		message+="<p>Street address.  This is the street address like 123 N. First Street.  Note: it's not critical to get an apartment number, and PO Box's don't work.";
		message+="<p>City.  This is the employee's city.";
		message+="<p>State.  This is the employee's state.  Please use two digit state descriptions, e.g. CA.";
		message+="<p>Zip.  This is the employee's zip code.  Please use either a 5-digit (xxxxx) or a 9-digit (xxxxx-xxxx) format.";
		message+="<p>email.  This is the employee's corporate email they will use to register on Ridezu, as employees opt-in. ";
		message+="<p>Campus.  This is the employee primary work campus, e.g Headquarters.";
		openconfirm();
		}
</script>

<?php 

include 'footer.php';
?>

</html>

