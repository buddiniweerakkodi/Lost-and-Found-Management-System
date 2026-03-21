<?php
require_once '../classes/LostItem.php';
require_once '../classes/FoundItem.php';
require_once '../classes/User.php';
require_once '../classes/Admin.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? '';
$type = $_GET['type'] ?? '';

if (!$id || ($type !== 'lost' && $type !== 'found')) {
    echo "Invalid access.";
    exit;
}

// 1. Get item
$itemObj = $type === 'lost' ? new LostItem() : new FoundItem();
$itemData = $itemObj->getItemById($id);

if (!$itemData) {
    echo "Item not found.";
    exit;
}

// 2. Get user
$user = new User();
$userData = $user->getUserById($itemData['userId']);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Item View</title>
  <link rel="stylesheet" href="../UI/styles.css">
</head>
<body>
    <div class="page-wrapper">
        <?php include '../UI/header.php'; ?>
        <div class="main-content">

<h2 class="text-2xl mb-5  text-center font-bold"><?= ucfirst($type) ?> Item Review</h2>


<!-- Item Details -->
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Item Name</th><td><?= htmlspecialchars($itemData['itemName']) ?></td></tr>
    <tr><th>Description</th><td><?= htmlspecialchars($itemData['description']) ?></td></tr>
    <tr><th>Location</th><td><?= $type === 'lost' ? $itemData['locationLost'] : $itemData['locationFound'] ?></td></tr>
    <tr><th>Date</th><td><?= $type === 'lost' ? $itemData['dateLost'] : $itemData['dateFound'] ?></td></tr>
    <tr><th>Status</th><td><?= htmlspecialchars($itemData['status']) ?></td></tr>
</table>

<!-- User Info -->
<h3 class="text-2xl mb-5  text-center font-bold">Uploaded By</h3>
<?php if ($userData): ?>
    <p class="text-md mb-5  text-center"><strong>Name:</strong> <?= htmlspecialchars($userData['name']) ?></p>
    <p class="text-md mb-5  text-center"><strong>Email:</strong> <?= htmlspecialchars($userData['email']) ?></p>
    <p class="text-md mb-5  text-center"><strong>Type:</strong> <?= htmlspecialchars($userData['type']) ?></p>
<?php else: ?>
    <p style="color:red">User info not found.</p>
<?php endif; ?>

<!-- Approve Form -->
<form method="POST" action="approve.php" onsubmit="return confirm('Are you sure you want to approve this report?');">
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="hidden" name="type" value="<?= $type ?>">
    <button type="submit" class="btn edit-btn " style="margin-left:200px;">Confirm Approve</button>
</form>

<!-- View User Button -->
<form method="GET" action="viewUser.php">
    <input type="hidden" name="id" value="<?= $userData['id'] ?>">
    <button type="submit" class="btn edit-btn" style="margin-left:190px;">👤 View User Details</button>
</form>

<br>
</div>
<?php include '../UI/footer.php'; ?>
</div>
</body>
</html>
