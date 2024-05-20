<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->selectDatabase('mydatabase');
$usersCollection = $database->users;
?>
