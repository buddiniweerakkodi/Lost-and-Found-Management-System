<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title >Manage Your Reports</title>
  <link rel="stylesheet" href="../UI/styles.css">
</head>
<body>

  <div class="page-wrapper">
    
    <?php include '../UI/header.php'; ?>

    <div class="main-content">
        <h2 class="text-2xl mb-5 font-bold text-center">Admin Panel</h2>
<p class="text-2xl mb-5  text-center">Welcome, <?= htmlspecialchars($_SESSION['admin']['username']) ?></p>

<ul>
    <li><a href="viewReports.php?type=lost" class="btn edit-btn btn-dash">View Lost Items</a></li>
    <li><a href="viewReports.php?type=found" class="btn edit-btn btn-dash">View Found Items</a></li>
    <li><a href="../public/passwordChange.php" class="btn edit-btn btn-dash">Change Admin Password</a></li>
    <li><a href="../classes/searchItem.php" class="btn edit-btn btn-dash">Search Found or Lost Items</a></li>
    <li><a href="logout.php" class="btn red-btn">Logout</a></li>
</ul>
    </div>

    <?php include '../UI/footer.php'; ?>

  </div>
</body>
</html>



