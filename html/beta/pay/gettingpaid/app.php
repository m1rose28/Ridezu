<?php

require_once 'braintree-php-2.14.0/lib/Braintree.php';
require_once __DIR__ . '/vendor/autoload.php';

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('your_merchant_id');
Braintree_Configuration::publicKey('your_public_key');
Braintree_Configuration::privateKey('your_private_key');

$app = new Silex\Application();

$app->get('/', function () {
    include 'views/form.php';
});

$app->get("/braintree", function () {
    include 'views/response.php';
});

$app->run();

?>
