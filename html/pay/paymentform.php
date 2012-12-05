<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

require_once 'braintree-php-2.17.0/lib/Braintree.php';
$update="";$errormessage="";$error="";$result="";$fbid=rand(1,100);$fname="test";$lname="tester";$email="testing@gmail.com";$method="addcard";$secret="xyz";


//sandbox connection

if($_SESSION['mode']=="dev"){

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('sx2dr573mwbmp9zv');
Braintree_Configuration::publicKey('krjsmf6ndkctyrd5');
Braintree_Configuration::privateKey('3a9ae3edc666a484049fd5596880fdba');

}

//production connection

if($_SESSION['mode']=="prod"){

Braintree_Configuration::environment('production');
Braintree_Configuration::merchantId('sg3kwmrsz48rqxvt');
Braintree_Configuration::publicKey('g6n2ygpxvjpw4np2');
Braintree_Configuration::privateKey('73c7689673357068c321a2d84ad66ce8');

}

//this gets the params from the parent iframe (if sent, otherwise use defaults)

if(isset($_GET["method"])){$method=$_GET["method"];$_SESSION['method']=$method;}
if(isset($_GET["oldtoken"])){$oldtoken=$_GET["oldtoken"];$_SESSION['oldtoken']=$oldtoken;}
if(isset($_GET["seckey"])){$seckey=$_GET["seckey"];$_SESSION['seckey']=$seckey;}
if(isset($_GET["fbid"])){$fbid=$_GET["fbid"];$_SESSION['fbid']=$fbid;}
if(isset($_GET["fname"])){$fname=$_GET["fname"];$_SESSION['fname']=$fname;}
if(isset($_GET["lname"])){$lname=$_GET["lname"];$_SESSION['lname']=$lname;}
if(isset($_GET["email"])){$email=$_GET["email"];$_SESSION['email']=$email;}

//this gets the tr value from braintree

if(isset($_GET["http_status"])) {$http_status=$_GET["http_status"];
	
	$update="1";
	
	if(isset($_GET["id"])){$id=$_GET["id"];}
	if(isset($_GET["kind"])){$kind=$_GET["kind"];}
	if(isset($_GET["hash"])){$hash=$_GET["hash"];}
	
	$_SERVER['QUERY_STRING'];
	$result = Braintree_TransparentRedirect::confirm($_SERVER['QUERY_STRING']);
		
	$fbid=$result->customer->id;
	$token=$result->customer->creditCards[0]->token;
	$expirationdate=$result->customer->creditCards[0]->expirationDate;
	$cardtype=$result->customer->creditCards[0]->cardType;
	$last4=$result->customer->creditCards[0]->last4;

	if($result->message){
		$errormessage=$result->message;
		$errormessage = ereg_replace("[^A-Za-z0-9 .]", "", $errormessage );
		}
}

if($_SESSION['method']=="newcard"){
	$trData = Braintree_TransparentRedirect::createCustomerData(
	  array(
		'redirectUrl' => 'https://www.ridezu.com/pay/paymentform.php',
		'customer' => array(
		  'id' => $_SESSION['fbid']
		)
	  )
	);
}

if($_SESSION['method']=="addnewcard"){

	  $trData = Braintree_TransparentRedirect::updateCustomerData(
		array(
		  'redirectUrl' => 'https://www.ridezu.com/pay/paymentform.php',
		  'customerId' => $_SESSION['fbid'],
		  'customer' => array(
			'creditCard' => array(
			  'options' => array(
				'updateExistingToken' => $_SESSION['oldtoken']
			  )
			)
		  )
		)
	  );

}

?>



<html>
  <head>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link type="text/css" rel="stylesheet" href="../css/style.css">		  
 	 <style>
   		#w #pagebody {
	   padding-top:0px;
   		}
	</style>
    <?php echo "<!--Result:".$result."|".$error."|".$update."|".$_SESSION['fbid']."|".$_SESSION['fname']."|".$_SESSION['lname']."|".$_SESSION['email']."-->"; ?>
  </head>
 
  <body>
  
  
  <script>
	<?php if($_SESSION['mode']=="dev"){echo "alert(\"Reminder: I am in dev mode\");";} ?>

	<?php if($update=="1"){ ?>
  	  var x1;
		 <?php if($cardtype<>""){ ?>
			  x1="{\"cardtype\":\"<?php echo $cardtype;?>\",\"last4\":\"<?php echo $last4;?>\",\"token\":\"<?php echo $token;?>\",\"expirationdate\":\"<?php echo $expirationdate;?>\"}";
		 <?php } ?>

		 <?php if($errormessage<>""){ ?>
			  x1="{\"error\":\"<?php echo $errormessage;?>\"}";
		 <?php } ?>
	  parent.ccupdate(x1);
	<?php } ?>	

		function createexp(){
		   var a = document.getElementById("expmonth");
		   expmonthval=a.options[a.selectedIndex].value;

		   var b = document.getElementById("expyear");
		   expyearval=b.options[b.selectedIndex].value;
		
		   document.getElementById("braintree_credit_card_exp").value=expmonthval+"/"+expyearval;
		}
  </script>

  
	<div id="w">	
	   <div id="pagebody" style="left: 0px;">
		   <div id="contactinfod">
			   <section id="precontent">
				   <h3>Payment Info</h3>
			   </section>				
			   <form id='payment-form' autocomplete="off" action='<?php echo Braintree_TransparentRedirect::url() ?>' method='POST'>
			   <section id="content"> 
				   <h2>Please enter your credit card below. This is a secure form.</h2>
				   <input type='hidden' name='tr_data' value='<?php echo htmlentities($trData) ?>' />
					   <div> 
						  <ul>
							  <li>
								  <h3>Card#</h3>
								  <input type='text' name='customer[credit_card][number]' id='braintree_credit_card_number' value=''></input>
							  </li>
							  <li>
								  <h3>CVV</h3>
								  <input type='text' name='customer[credit_card][cvv]' id='braintree_credit_card_cvv' value=''></input>
							  </li>
							  <li>
								 <h3>Month</h3>
								  <select class="rselect" onchange="createexp();" id="expmonth" data-role="none">
									  <option value="01">January</option>
									  <option value="02">February</option>
									  <option value="03">March</option>
									  <option value="04">April</option>
									  <option value="05">May</option>
									  <option value="06">June</option>
									  <option value="07">July</option>
									  <option value="08">August</option>
									  <option value="09">September</option>
									  <option value="10">October</option>
									  <option value="11">November</option>
									  <option value="12">December</option>
									</select>
							  </li>
							  <li>
								  <h3>Year</h3>			
									  <select class="rselect" onchange="createexp();" id="expyear" name="expyear" data-role="none">
										  <option value="2012">2012</option>
										  <option value="2013">2013</option>
										  <option value="2014">2014</option>
										  <option value="2015">2015</option>
										  <option value="2016">2016</option>
									  </select>
								  </li>
							  </ul>

						  		<input type='text' class="rtext" style="display:none;" name='customer[credit_card][expiration_date]' id='braintree_credit_card_exp' value=''></input>
						</div>
			   </section>
			   <section id="precontent">
					<input class='primarybutton' type='submit' />
			   </section>
			</form>
		   </div>
	   </div>
	</div>

  </body>
</html>

