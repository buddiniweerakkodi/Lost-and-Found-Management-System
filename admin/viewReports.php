<?php
require_once '../classes/LostItem.php';
require_once '../classes/FoundItem.php';
require_once '../classes/Admin.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$type = $_GET['type'] ?? 'lost';

if ($type === 'lost') {
    $item = new LostItem();
    $items = $item->getAllLostItems();
} else {
    $item = new FoundItem();
    $items = $item->getAllFoundItems();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>View Reports</title>
  <link rel="stylesheet" href="../UI/styles.css">
</head>
<body> 
     <div class="page-wrapper">
         <?php include '../UI/header.php'; ?>
         <div class="main-content">  
<h2><?= ucfirst($type) ?> Item Reports</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Location</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php foreach ($items as $i): ?>
    <tr>
        <td><?= $i[$type . 'ItemId'] ?></td>
        <td><?= htmlspecialchars($i['itemName']) ?></td>
        <td><?= $type === 'lost' ? $i['locationLost'] : $i['locationFound'] ?></td>
        <td><?= $i['status'] ?></td>
        <td>
            <?php if ($i['status'] !== 'Approved'): ?>
                <a href="viewItem.php?id=<?= $i[$type . 'ItemId'] ?>&type=<?= $type ?>" class="btn edit-btn">View & Approve</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="dashboard.php" class="btn edit-btn">← Back to Dashboard</a>
</div>
    <?php include '../UI/footer.php'; ?>
</div>
</body>
</html>