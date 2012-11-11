<?php
function makePayment()
{ 

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('sx2dr573mwbmp9zv');
Braintree_Configuration::publicKey('krjsmf6ndkctyrd5');
Braintree_Configuration::privateKey('3a9ae3edc666a484049fd5596880fdba');


$result = Braintree_Transaction::sale(array(
    'amount' => '555.00',
    'creditCard' => array(
        'number' => '5105105105105100',
        'expirationDate' => '05/12'
    )
));

if ($result->success) {
    print_r("success!: " . $result->transaction->id);
} else if ($result->transaction) {
    print_r("Error processing transaction:");
    print_r("\n  message: " . $result->message);
    print_r("\n  code: " . $result->transaction->processorResponseCode);
    print_r("\n  text: " . $result->transaction->processorResponseText);
} else {
    print_r("Message: " . $result->message);
    print_r("\nValidation errors: \n");
    print_r($result->errors->deepAll());
}
	
}
 
?>