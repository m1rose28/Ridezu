<?php

require_once 'braintree-php-2.17.0/lib/Braintree.php';

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('sx2dr573mwbmp9zv');
Braintree_Configuration::publicKey('krjsmf6ndkctyrd5');
Braintree_Configuration::privateKey('3a9ae3edc666a484049fd5596880fdba');

$trData = Braintree_TransparentRedirect::transactionData(
  array(
	'transaction' => array(
  	'type' => Braintree_Transaction::SALE,
  	'amount' => '1000.00',
  	'options' => array('submitForSettlement' => true)
	),
	'redirectUrl' => 'http://localhost:8080/braintree'
  )
);
?>
<html>
  <head>
    <style type='text/css'>label {display: block;} input {margin-bottom: 10px;}</style>
  </head>
  <body>
    <h1>Braintree Credit Card Transaction Form</h1>
    <form id='payment-form' action='<?php echo Braintree_TransparentRedirect::url() ?>' method='POST'>
      <input type='hidden' name='tr_data' value='<?php echo htmlentities($trData) ?>' />
      <div>
        <h2>Credit Card</h2>
        <label for='braintree_credit_card_number'>Credit Card Number</label>
        <input type='text' name='transaction[credit_card][number]' id='braintree_credit_card_number' value='4111111111111111'></input>
        <label for='braintree_credit_card_exp'>Credit Card Expiry (mm/yyyy)</label>
        <input type='text' name='transaction[credit_card][expiration_date]' id='braintree_credit_card_exp' value='12/2015'></input>
      </div>
      <input class='submit-button' type='submit' />
    </form>
  </body>
</html>

