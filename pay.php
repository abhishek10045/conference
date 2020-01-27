<?php

    session_start();

    require_once 'shared.php';

    $name = $email = $address = $stripeToken = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $address = $_SESSION['address'];
        $stripeToken = $_POST['stripeToken'];

        $customer = \Stripe\Customer::create([
            'name' => $name,
            'email' => $email,
            'source' => $stripeToken
        ]);
        
        $charge = \Stripe\Charge::create([
            'amount' => 10000,
            'currency' => 'inr',
            'customer' => $customer->id
        ]);

        // $db = new SQLite3('transactions.db', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        // $db->query('CREATE TABLE IF NOT EXISTS "transactions" (
        //     "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
        //     "email" VARCHAR,
        //     "name" VARCHAR,
        // )');
        // $db->query('INSERT INTO "transactions" ("email", "name") VALUES (' . $email . ', ' . $name . ')');
        // // $statement = $db->prepare('INSERT INTO "transactions" ("email", "name") VALUES (:em, :nm)');
        // // $statement->bindValue(':em', $email);
        // // $statement->bindValue(':nm', $name);
        // // $statement->execute();
        // $db->close();

        // $db->exec("CREATE TABLE IF NOT EXISTS transactions (
            // id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, Breed TEXT, Name TEXT, Age INTEGER)");    
            
        if ($charge->status == 'succeeded') {
            $db = new PDO('sqlite:'. __DIR__ .'/transactions.db');
            $db->exec("CREATE TABLE IF NOT EXISTS transactions (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                email VARCHAR NOT NULL,
                full_name VARCHAR NOT NULL
            )");
            $stmt = $db->prepare("INSERT INTO transactions (email, full_name) VALUES (:em, :fn)");
            $stmt->bindValue(':em', $email);
            $stmt->bindValue(':fn', $name);
            $stmt->execute();
            $db = null;
        }

        session_unset();
        session_destroy();

        // redirect to home page
        // header('Location: ' . $_SERVER['HTTP_HOST']);
    }
?>
