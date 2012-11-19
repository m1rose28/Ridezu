<?php
$queryString = $_SERVER['QUERY_STRING'];
$result = Braintree_TransparentRedirect::confirm($queryString);
if ($result->success) {
  $message = "Transaction Successful: ".$result->transaction->status.".<br />";
  $message .= "Amount: ".(string)$result->transaction->amount;
}
else {
  $message = print_r($result->errors->deepAll(), True);
}
?>

<html>
  <body>
    <h1>Transaction Response</h1>
    <ul>
      <li>Status - <?php echo $message ?></li>
    </ul>
  </body>
</html>
