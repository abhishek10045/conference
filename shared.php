<?php

    require_once 'vendor/autoload.php';

    $config = parse_ini_file('config.ini');

    if (!$config) {
        http_response_code(500);
        exit;
    }

    \Stripe\Stripe::setApiKey($config['stripe_secret_key']);

?>