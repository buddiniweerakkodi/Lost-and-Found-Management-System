<?php
require_once '../classes/User.php';
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();
    if ($user->login($email, $password)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid credentials.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Manage Your Reports</title>
  <link rel="stylesheet" href="../UI/styles.css">
</head>
<body>

  <div class="page-wrapper">
    
    <?php include '../UI/header.php'; ?>

    <div class="main-content">
        <form method="POST">
    <h2>User Login</h2>
    <input type="email" name="email" placeholder="Email" required class="btn edit-btn"><br>
    <input type="password" name="password" placeholder="Password" required class="btn edit-btn"><br>
    <button type="submit" class="btn edit-btn" class="btn edit-btn btn-dash">Login</button>
    <p><?= $message ?></p>
</form>

    </div>

    <?php include '../UI/footer.php'; ?>

  </div>
</body>
</html>

