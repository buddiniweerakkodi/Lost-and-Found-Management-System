<?php
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lost & Found Management System</title>
    <link rel="stylesheet" href="../UI/styles.css">

</head>
<body>
    <div class="page-wrapper">
    <?php include '../UI/header.php'; ?>
    <div class="main-content">

    <h1 class="text-2xl mb-5  text-center font-bold">Welcome to Lost & Found Management System</h1>

    <p class="text-2xl mb-5  text-center font-bold">If you are a user:</p>
    <a href="register.php" class="btn edit-btn btn-dash">Register</a>
    <a href="login.php" class="btn edit-btn btn-dash">Login</a>


    <p class="text-2xl mb-5  text-center font-bold">If you are an admin:</p>
    <a href="../admin/login.php" class="btn edit-btn btn-dash">Admin Login</a>
    </div>
    <?php include '../UI/footer.php'; ?>

  </div>

</body>
</html>
