<?php

//get username from GET array
$username = $_GET['username'] ?? null;

//include the library file
require 'includes/library.php';
// create the database connection
$pdo = connectDB();

//query for record matching provided username

$statement = $pdo->prepare("SELECT * FROM `users` WHERE username = ?");
$statement->execute([$username]);

//remember fetch returns false when there were no records
if ($statement->fetch()) {
    echo 'true'; //username found
} else {
    echo 'false'; //username not found
}
