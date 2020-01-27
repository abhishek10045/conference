<?php

    require_once 'shared.php';

    header('Content-Type: application/json');

    echo json_encode(['publishableKey' => $config['stripe_publishable_key']]);

?>