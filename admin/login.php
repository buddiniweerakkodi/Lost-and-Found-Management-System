<?php
require_once '../classes/Admin.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $admin = new Admin();
    if ($admin->loginAsAdmin($_POST['username'], $_POST['password'])) {
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid login.";
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
    <h2 class="text-2xl mb-5  text-center">Admin Login</h2>
    <input type="text" name="username" placeholder="Username" required class="btn edit-btn"><br>
    <input type="password" name="password" placeholder="Password" required class="btn edit-btn"><br>
    <button type="submit" class="btn edit-btn">Login</button>
    <p><?= $message ?></p>
</form>
    </div>

    <?php include '../UI/footer.php'; ?>

  </div>
</body>
</html>


