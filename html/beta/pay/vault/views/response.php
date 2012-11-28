<?php
$queryString = $_SERVER['QUERY_STRING'];
$result = Braintree_TransparentRedirect::confirm($queryString);
if ($result->success) {
      $message = "Customer Created with ID: ".$result->customer->email;
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
