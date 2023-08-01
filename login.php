<?php
$sessionExpiration = 900; // 15 minutes in seconds
session_start();

if (!empty($_SESSION['User'])) {
  header("location: home.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_POST['id'];
  $pass = $_POST['pass'];
  $role = $_POST['role'];

  // Database credentials
  // $host = "localhost";
  // $user = "root";
  // $password = "";
  // $dbase = "pmas";
  include 'connection.php';

  try {
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = :id AND password = :pass";
    $pd = $conn->prepare($sql);
    $pd->bindParam(':id', $id, PDO::PARAM_STR);
    $pd->bindParam(':pass', $pass, PDO::PARAM_STR);
    $pd->execute();

    $row = $pd->fetch(PDO::FETCH_ASSOC);

    // Check if the login is successful
    if ($row) {
      $user = isset($row['name']) ? $row['name'] : $id;
      $_SESSION['User'] = $user;
      $_SESSION['Role'] = $role;

      // Set the last activity timestamp in the session
      $_SESSION['last_activity'] = time();

      // Redirect to the appropriate dashboard page (Admin, Faculty, Student)
      header("location: home.php");
      exit();
    } else {
      $status = "Username or password is incorrect";
      header("location: index.php?status=" . urlencode($status));
      exit();
    }
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
}
?>
