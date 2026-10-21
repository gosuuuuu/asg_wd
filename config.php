<?php

$host = "127.0.0.1"; // using own localhost - MySql from xampp
$port = 3307; // Change to 3306 for default port number
$dbname = "utb_sport_facilities"; // my datase
$username = "root"; //mysql username
$password = "";

try { //try catch if database work if no catch error below
    $pdo = new PDO( // we use to communicate PHP and MySql
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) { // if database error
    die("Database connection failed: " . $e->getMessage());
}
?>