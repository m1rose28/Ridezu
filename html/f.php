<?php

// please note that this page is a total hack until we have a little time to do this correctly...

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$rid="";$u="";$time1="";$like="";$car="";$again="";
	
if(isset($_GET["r"])){$rid=$_GET["r"];}
if(isset($_GET["u"])){$u=$_GET["u"];}

if($_POST){

	$dbh=mysql_connect ("localhost", "ridezu", "ridezu123") or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db ("ridezu");

	if(isset($_POST["time"])){
		$time1=$_POST["time"];
		$a="Timeliness";
		$aid="1";
		mysql_query("INSERT INTO rankings (rankerfbid, rideid, attributeid, attribute, rank) VALUES ('$u', '$rid', '$aid','$a','$time1')");
		}


	if(isset($_POST["like"])){
		$like=$_POST["like"];
		$a="Likeability";
		$aid="2";
		mysql_query("INSERT INTO rankings (rankerfbid, rideid, attributeid, attribute, rank) VALUES ('$u','$rid', '$aid','$a','$like')");
		}

	if(isset($_POST["car"])){
		$car=$_POST["car"];
		$a="Car Condition";
		$aid="3";
		mysql_query("INSERT INTO rankings (rankerfbid, rideid, attributeid, attribute, rank) VALUES ('$u', '$rid','$aid','$a','$car')");
		}

	if(isset($_POST["car"])){
		$again=$_POST["again"];
		$a="Use Again";
		$aid="4";
		mysql_query("INSERT INTO rankings (rankerfbid, rideid, attributeid, attribute, rank) VALUES ('$u','$rid', '$aid','$a','$again')");
		}	


	}

?>
<!DOCTYPE html>

    <head>
        <meta charset="utf-8">
        <title>Ridezu</title>
 		<meta name="viewport" content="width=device-width, initial-scale=1"> 
    
 	<style>
 	body{
 		font-size:16px;font-family:arial;
 		padding:0px;margin:0px;
 		}
 	.header{
 		font-wight:bold;
 		font-size:18px;
 		padding-left:10px;
 		padding-right:10px;
 		}
 	label{
 		display:block;
 		padding-top:15px;
 		padding-bottom:15px;
 		font-weight:bold;
 		}
 	.question{
 		background-color:#ccc;
 		padding:10px;
 		margin:10px;
 		radius: 5px;
 		display:inline;
 		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;

 
 		}
 	.button{
		color: #9d9d9d;
		text-align: center;
		padding: 10px;
		margin-top:30px;
		width: 140px;
		font-size: 18px;
		display: block;
		background: #ededed; /* Old browsers */
		background: -moz-linear-gradient(top,  #ededed 0%, #cacaca 99%, #b7b7b7 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ededed), color-stop(99%,#cacaca), color-stop(100%,#b7b7b7)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #ededed 0%,#cacaca 99%,#b7b7b7 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #ededed 0%,#cacaca 99%,#b7b7b7 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #ededed 0%,#cacaca 99%,#b7b7b7 100%); /* IE10+ */
		background: linear-gradient(to bottom,  #ededed 0%,#cacaca 99%,#b7b7b7 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ededed', endColorstr='#b7b7b7',GradientType=0 ); /* IE6-9 */
		border: 1px solid #c7c7c7;
		-moz-box-shadow: 0 3px 6px -4px #000;
		-webkit-box-shadow: 0 3px 6px -4px #000;
		box-shadow: 0 3px 6px -4px #000;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		 }
	  .button:hover {
		  background: #d5d5d5;
	  }
 	.mini{
 		display:block;
 		font-size:12px;
 		color:#aaaaaa;
 		padding-left:10px;padding-right:10px;
 		}
 	</style>   
    
    </head>
    <body>
 			<div style="width:320px;margin-top:5px;">
			<center>
	 		<a href="index.php"><img src="images/ridezulogo.png" alt="Ridezu" /></a>


<?php if($_POST==true){ ?> 

			<br><br></center><div class="header">Thanks for your feedback!  We're driving to make a great experience for everyone on Ridezu!</div>
			<center><br><a class="button" href="index.php">to Ridezu!"</a></center>

<?php } ?>

<?php if($_POST==false && $rid<>""){ ?> 

			<div class="header">How was your ride today?</div>
			<div class="mini">(1 = bad, 5 = super awesome)</div>
			<form method="post">
		<label>Timeliness</label>
			<div class="question">
					<input type="radio" name="time" id="t1" value="1">1
					<input type="radio" name="time" id="t2" value="2">2
					<input type="radio" name="time" id="t3" value="3">3
					<input type="radio" name="time" id="t4" value="4">4
					<input type="radio" name="time" id="t5" value="5">5
			</div>				
  
			<label >Like-ability</label>
  			<div class="question">
					<input type="radio" name="like" id="l1" value="1">1
					<input type="radio" name="like" id="l2" value="2">2
					<input type="radio" name="like" id="l3" value="3">3
					<input type="radio" name="like" id="l4" value="4">4
					<input type="radio" name="like" id="l5" value="5">5
			</div>
			  
			<label >Car Condition</label>
  
  			<div class="question">
					<input type="radio" name="car" id="c1" value="1">1
					<input type="radio" name="car" id="c2" value="2">2
					<input type="radio" name="car" id="c3" value="3">3
					<input type="radio" name="car" id="c4" value="4">4
					<input type="radio" name="car" id="c5" value="5">5
			</div>
			
			<label >Carpool again?</label>
  			<div class="question">
					<input type="radio" name="again" id="a1" value="1">1
					<input type="radio" name="again" id="a2" value="2">2
					<input type="radio" name="again" id="a3" value="2">3
					<input type="radio" name="again" id="a4" value="2">4
					<input type="radio" name="again" id="a5" value="2">5
			</div>
			<br/>
			<input type="hidden" name="rid" value="<?php echo $rid;?>"/>
			<input type="hidden" name="u" value="<?php echo $u;?>"/>
			<input type="submit" class="button" value="submit"/>
			</form>


			</center>		
			<br/><div class="mini">This information will be completely confidential and will not be displayed until this person has collected reviews from 3 or more people.
			<br/></div>
<?php } ?> 

			</div>
	</body>
	</html>
	