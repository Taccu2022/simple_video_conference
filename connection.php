<?php
$host = "localhost";
$user = "root";
$password = "";
$dbase = "vcweb";
$conn = null;

try {
    // Create a new PDO instance
    $string = "mysql:host=$host;dbname=$dbase";
    $conn = new PDO($string, $user, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    header('location: index.php?status='.urlencode($e->getMessage()));
    exit();
}
?>
