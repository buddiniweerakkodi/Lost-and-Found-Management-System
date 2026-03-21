<?php
session_start();
require_once '../classes/usersPwChange.php';
require_once '../classes/adminPwChange.php';

$passwordMsg = "";

$isUser = isset($_SESSION['user']);
$isAdmin = isset($_SESSION['admin']);

if (!$isUser && !$isAdmin) {
    header("Location: login.php");
    exit;
}

if ($isUser) {
    $userId = $_SESSION['user']['id']; 
    $changer = new UsersPwChange();
} else {
    $userId = $_SESSION['admin']['adminId']; 
    $changer = new AdminPwChange();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        $passwordMsg = "❌ New passwords do not match.";
    } elseif (strlen($new) < 6) {
        $passwordMsg = "❌ Password must be at least 6 characters.";
    } else {
        if (!$changer->verifyCurrentPassword($userId, $current)) {
            $passwordMsg = "❌ Current password is incorrect.";
        } elseif ($changer->updatePassword($userId, $new)) {
            $passwordMsg = "✅ Password changed successfully.";
        } else {
            $passwordMsg = "❌ Failed to change password.";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
  <link rel="stylesheet" href="../UI/styles.css">
</head>
<body>
  <div class="page-wrapper">
    <?php include '../UI/header.php'; ?>

    <div class="main-content">
      <h2 class="text-2xl mb-5 font-bold text-center"> Change Password</h2>
      <form method="POST">
        <label>Current Password:</label>
        <input type="password" name="current_password" required>

        <label>New Password:</label>
        <input type="password" name="new_password" required>

        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required >

        <button type="submit" class="btn edit-btn btn-dash">Change Password</button>
        <div class="message"><?= $passwordMsg ?></div>
      </form>

      <br><a href="dashboard.php" class="btn edit-btn btn-dash">← Back to Dashboard</a>
    </div>

    <?php include '../UI/footer.php'; ?>
  </div>
</body>
</html>
