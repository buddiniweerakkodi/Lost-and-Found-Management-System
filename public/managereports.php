<?php
require_once '../classes/LostItem.php';
require_once '../classes/FoundItem.php';
 
include '../UI/tailwind-cdn.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user']['id'];

$lostItemObj = new LostItem();
$foundItemObj = new FoundItem();

$lostItems = $lostItemObj->getItemsByUserId($userId);
$foundItems = $foundItemObj->getItemsByUserId($userId);
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
        <h1 class="text-2xl mb-5  text-center font-bold">Manage Your Lost and Found Reports</h1>

        <!-- Lost Items -->
        <h2 class="text-2xl mb-5  text-center font-bold">Lost Items</h2>
        <?php if (count($lostItems) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Date Lost</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lostItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['itemName']) ?></td>
                            <td><?= htmlspecialchars($item['description']) ?></td>
                            <td><?= htmlspecialchars($item['locationLost']) ?></td>
                            <td><?= htmlspecialchars($item['dateLost']) ?></td>
                            <td><?= htmlspecialchars($item['status']) ?></td>
                            <td>
                                <?php if ($item['status'] !== 'Approved'): ?>
                                    <a class="btn edit-btn" href="edit_lost.php?id=<?= $item['lostItemId'] ?>">Edit</a>
                                    <a class="btn delete-btn" href="delete_lost.php?id=<?= $item['lostItemId'] ?>" onclick="return confirm('Are you sure you want to delete this lost item report?');">Delete</a>
                                <?php else: ?>
                                    <span style="color: gray;">No actions</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">You have no lost item reports.</p>
        <?php endif; ?>

        <!-- Found Items -->
        <h2 class="text-2xl mb-5  text-center font-bold">Found Items</h2>
        <?php if (count($foundItems) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Date Found</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($foundItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['itemName']) ?></td>
                            <td><?= htmlspecialchars($item['description']) ?></td>
                            <td><?= htmlspecialchars($item['locationFound']) ?></td>
                            <td><?= htmlspecialchars($item['dateFound']) ?></td>
                            <td><?= htmlspecialchars($item['status']) ?></td>
                            <td>
                                <?php if ($item['status'] !== 'Approved'): ?>
                                    <a class="btn edit-btn" href="edit_found.php?id=<?= $item['foundItemId'] ?>">Edit</a>
                                    <a class="btn delete-btn" href="delete_found.php?id=<?= $item['foundItemId'] ?>" onclick="return confirm('Are you sure you want to delete this found item report?');">Delete</a>
                                <?php else: ?>
                                    <span style="color: gray;">No actions</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">You have no found item reports.</p>
        <?php endif; ?>
    </div>

    <?php include '../UI/footer.php'; ?>
</div>
</body>
</html>
