<?php
require_once '../classes/LostItem.php';
require_once '../classes/ItemCategory.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lost = new LostItem();
    $userId = $_SESSION['user']['id'];
    $msg = $lost->submitLostItem($userId, $_POST['date'], '', $_POST['itemName'], $_POST['description'], $_POST['location'], $_POST['categoryId']) 
        ? "Lost item submitted!" 
        : "Failed!";
}

$cat = new ItemCategory();
$categories = $cat->getAllCategories();
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
    <h3 class="text-2xl mb-5  text-center">Submit Lost Item</h3>
    <input type="text" name="itemName" placeholder="Item Name" required><br>
    <textarea name="description" placeholder="Description" required></textarea><br>
    <input type="text" name="location" placeholder="Where you lost it?" required><br>
    <input type="date" name="date" required><br>

    <select name="categoryId" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['categoryId'] ?>"><?= $cat['categoryName'] ?></option>
        <?php endforeach; ?>
    </select><br>

    <button type="submit" class="btn edit-btn">Submit</button>
    <p><?= $msg ?></p>
</form>

    </div>

    <?php include '../UI/footer.php'; ?>

  </div>
</body>
</html>


