
<?php
$host = "127.0.0.1";
$port = 3307;
$dbname = "utb_sport_facilities";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    echo "SUCCESS: Connected to the database!";
} catch (PDOException $e) {
    echo "FAILED: " . $e->getMessage();
}
?>
