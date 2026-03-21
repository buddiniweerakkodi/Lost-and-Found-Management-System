<?php
require_once '../classes/searchLostItem.php';
require_once '../classes/searchFoundItem.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$results = [];
$type = $_GET['type'] ?? 'lost';
$query = $_GET['q'] ?? '';

if ($query) {
    if ($type === 'lost') {
        $item = new searchLostItem();
    } else {
        $item = new searchFoundItem();
    }
    $results = $item->searchByName($query);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Search Items</title>
  <link rel="stylesheet" href="../UI/styles.css">
</head>
<body>
    <div class="page-wrapper">
        <?php include '../UI/header.php'; ?>
             <div class="main-content">

<h2>Search <?= ucfirst($type) ?> Items</h2>

<form method="GET">
    <input type="text" name="q" placeholder="Search item name" required value="<?= htmlspecialchars($query) ?>">
    <select name="type">
        <option value="lost" <?= $type === 'lost' ? 'selected' : '' ?>>Lost</option>
        <option value="found" <?= $type === 'found' ? 'selected' : '' ?>>Found</option>
    </select>
    <button type="submit" class="btn edit-btn">Search</button>
</form>

<?php if ($results): ?>
    <h3>Search Results (<?= ucfirst($type) ?> Items)</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Description</th>
            <th>Location</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($results as $item): ?>
            <tr>
                <td><?= $item[$type . 'ItemId'] ?></td>
                <td><?= htmlspecialchars($item['itemName']) ?></td>
                <td><?= htmlspecialchars($item['description']) ?></td>
                <td><?= $type === 'lost' ? $item['locationLost'] : $item['locationFound'] ?></td>
                <td><?= $type === 'lost' ? $item['dateLost'] : $item['dateFound'] ?></td>
                <td><?= htmlspecialchars($item['status']) ?></td>
                <td>
                    <a href="../admin/viewItem.php?id=<?= $item[$type . 'ItemId'] ?>&type=<?= $type ?>" class="btn edit-btn">View & Approve</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php elseif ($query): ?>
    <p>No items found.</p>
<?php endif; ?>
</div>
  <?php include '../UI/footer.php'; ?>
</div>
</body>
</html>
