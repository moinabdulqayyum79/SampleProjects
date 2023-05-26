<?php

//get email from GET array
$email = $_GET['email'] ?? null;

//make sure it's a valid email
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'error';
    exit();
}

//include the library file
require 'includes/library.php';
// create the database connection
$pdo = connectDB();

//query for record matching provided email
$statement = $pdo->prepare("SELECT * FROM `users` WHERE email = ?");
$statement->execute([$email]);

//remember fetch returns false when there were no records
if ($statement->fetch()) {
    echo 'true'; //email found
} else {
    echo 'false'; //email not found
}
