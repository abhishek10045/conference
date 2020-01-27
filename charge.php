<?php
    session_start();
?>

<!DOCTYPE html>

<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_SESSION['name'] = test_input($_POST['first_name']) . ' ' . test_input($_POST['last_name']);
        $_SESSION['email'] = test_input($_POST['email']);
        $_SESSION['address'] = test_input($_POST['address']);
    } else {
        die();
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
  <title>Donation App</title>
</head>

<body class="bg-gray-900">
  <!-- <nav class="bg-purple-900 h-20 flex justify-center">
    <h1 class="text-white text-5xl">Donation App</h1>
  </nav> -->

  <div class="flex justify-center mt-32">
    <form action="pay.php" method="post" class="flex flex-col w-1/3" id="pay-form">
      <!-- <input class="bg-transparent text-white p-2 h-10 mb-4" type="text" name="name" placeholder="Name">
      <input type="email" class="bg-transparent text-white p-2 h-10 mb-4" name="email" placeholder="Email">
      <input class="bg-transparent text-white p-2 h-10 mb-4" type="text" name="amount" placeholder="Amount"> -->

      <div id="card-element" class="bg-transparent text-white p-2 h-10 mb-4"></div>
      <div id="card-errors" role="alert"></div>
      <button class="text-white bg-purple-900 p-4 rounded">Pay amount</button>
    </form>
  </div>
</body>

<script src="https://js.stripe.com/v3/"></script>
<script src="js/card.js"></script>

</html>