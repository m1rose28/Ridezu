<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require_once 'braintree-php-2.17.0/lib/Braintree.php';
$update="";$error="";$result="";$fbid=rand(1,100);$fname="test";$lname="tester";$email="testing@gmail.com";$method="addcard";$secret="xyz";

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('sx2dr573mwbmp9zv');
Braintree_Configuration::publicKey('krjsmf6ndkctyrd5');
Braintree_Configuration::privateKey('3a9ae3edc666a484049fd5596880fdba');

//this gets the params from the parent iframe (if sent, otherwise use defaults)

if(isset($_GET["method"])){$method=$_GET["method"];}
if(isset($_GET["oldtoken"])){$oldtoken=$_GET["oldtoken"];}
if(isset($_GET["secret"])){$secret=$_GET["secret"];}
if(isset($_GET["fbid"])){$fbid=$_GET["fbid"];}
if(isset($_GET["fname"])){$fname=$_GET["fname"];}
if(isset($_GET["lname"])){$lname=$_GET["lname"];}
if(isset($_GET["email"])){$email=$_GET["email"];}

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

	if($result->errors){
		$errormessege=$result->message;
		}
}

if($method=="addcard"){
	$trData = Braintree_TransparentRedirect::createCustomerData(
	  array(
		'redirectUrl' => 'https://www.ridezu.com/testpayment/paymentform.php',
		'customer' => array(
		  'id' => $fbid
		)
	  )
	);
}

if($method=="addnewcard"){

	  $trData = Braintree_TransparentRedirect::updateCustomerData(
		array(
		  'redirectUrl' => 'https://www.ridezu.com/testpayment/paymentform.php',
		  'customerId' => $fbid,
		  'customer' => array(
			'creditCard' => array(
			  'options' => array(
				'updateExistingToken' => $oldtoken
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
    <?php echo "<!--Result:".$result."|".$error."|".$update."|".$fbid."|".$fname."|".$lname."|".$email."-->"; ?>
  </head>
 
  <body>
  
  
  <script>
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
			   <form id='payment-form' action='<?php echo Braintree_TransparentRedirect::url() ?>' method='POST'>
			   <section id="content"> 
				   <h2>Please enter your credit card below. This is a secure form.</h2>
				   <input type='hidden' name='tr_data' value='<?php echo htmlentities($trData) ?>' />
					   <div> 
						  <ul>
							  <li>
								  <h3>Card#</h3>
								  <input type='text' class="rtext" name='customer[credit_card][number]' id='braintree_credit_card_number' value=''></input>
							  </li>
							  <li>
								  <h3>CVV</h3>
								  <input type='text' class="rtext" name='customer[credit_card][cvv]' id='braintree_credit_card_cvv' value=''></input>
							  </li>
							  <li>
								 <h3>Month</h3>
								  <select class="rselect" onchange="createexp();" id="expmonth" data-role="none">
									  <option value="01">Janaury</option>
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

