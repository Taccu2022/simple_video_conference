<?php
session_start();
if (empty($_SESSION['User'])) {
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management System</title>
    <link rel="icon" href='./images/logo.png' type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
      body {
        background-image: url('images/login.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
      }

      .login-form {
        width: 330px;
        border-radius: 10px;
        padding: 40px 30px;
        margin-top: 50px;
        box-shadow: -3px -3px 9px #aaa9a9a2,
                    3px 3px 7px rgba(147, 149, 151, 0.5); /* Decrease the alpha value to make it less transparent */
        background-color: #ffffffdd;
      }
    </style>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">
        <img src="images/logo1.png" alt="LOGO" height="40">
      </a>
      <span class="navbar-text mx-auto text-white" style="font-size: 24px;">Project Management System</span>
    </nav>
    
    <div class="container mt-10">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="login-form">
            <h2 class="text-center mb-4">Login</h2>
            <form name="login" action="chk.php" method="post">
              <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" class="form-control" name="id" required>
              </div>
              <div class="form-group">
                <label for="pass">Password:</label>
                <input type="password" class="form-control" name="pass" required>
              </div>
              <div class="form-group">
                <label for="role">Login As:</label>
                <select class="form-control" name="role">
                  <option value="user">User</option>
                </select>
              </div>
              <?php
                if (isset($_GET['status'])) {
                    $status = htmlspecialchars($_GET['status']);
                    echo '<p class="form-group" style="color: red;">' . $status . '</p>';
                }
              ?>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>

  </html>

  <?php
} else {
  header("location:home.php");
}
?>
