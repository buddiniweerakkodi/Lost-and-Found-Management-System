<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../UI/styles.css">
</head>
<body>

  <div class="page-wrapper">
    
    <?php include '../UI/header.php'; ?>

    <div class="main-content">
        <h1 class="text-2xl font-bold text-center">Welcome, <?= htmlspecialchars($user['name']) ?></h1>
<p class="text-2xl mb-5  text-center"> You are logged in as a <?= $user['type'] ?>.</p>

<ul>
    <li><a href="submitLost.php" class="btn edit-btn btn-dash">Submit Lost Item</a></li>
    <li><a href="submitFound.php" class="btn edit-btn btn-dash">Submit Found Item</a></li>
    <li><a href="passwordChange.php" class="btn edit-btn btn-dash">Change User Password</a></li>
    <li><a href="managereports.php" class="btn edit-btn btn-dash">Manage Your Reports</a></li>

    <li><a href="logout.php" class="btn red-btn">Logout</a></li>
</ul>

    </div>

    <?php include '../UI/footer.php'; ?>

  </div>
</body>
</html>


