<?php
include '../UI/tailwind-cdn.php';
require_once '../config/database.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "User ID not provided.";
    exit;
}

$userId = $_GET['id'];

try {
    $conn = (new Database())->connect();

    // Get User Info
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit;
    }

    // Get enrollment/staff ID
    $extraId = '';
    if ($user['type'] === 'student') {
        $stmt = $conn->prepare("SELECT enrollmentNo FROM students WHERE id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $extraId = $result ? $result['enrollmentNo'] : 'N/A';
    } elseif ($user['type'] === 'staff') {
        $stmt = $conn->prepare("SELECT staffID FROM staff WHERE id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $extraId = $result ? $result['staffID'] : 'N/A';
    }

    // Get Lost Items
    $stmt = $conn->prepare("SELECT * FROM lost_items WHERE userId = ?");
    $stmt->execute([$userId]);
    $lostItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get Found Items
    $stmt = $conn->prepare("SELECT * FROM found_items WHERE userId = ?");
    $stmt->execute([$userId]);
    $foundItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "DB Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View User</title>
    <link rel="stylesheet" href="../UI/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #f2f2f2; }
        h3 { margin-top: 40px; }
    </style>
</head>
<body>
      <div class="page-wrapper">
        <?php include '../UI/header.php'; ?>

        <div class="main-content">
        <h2 class="text-2xl mb-5  text-center font-bold">👤 User Details</h2>

        <table>
            <tr><th>Name</th><td><?= htmlspecialchars($user['name']) ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
            <tr><th>Type</th><td><?= htmlspecialchars($user['type']) ?></td></tr>
            <?php if ($user['type'] === 'student'): ?>
                <tr><th>Enrollment No</th><td><?= htmlspecialchars($extraId) ?></td></tr>
            <?php elseif ($user['type'] === 'staff'): ?>
                <tr><th>Staff ID</th><td><?= htmlspecialchars($extraId) ?></td></tr>
            <?php endif; ?>
        </table>

        <!-- Lost Items Section -->
        <h3 class="text-2xl mb-5  text-center font-bold">Lost Items Reported</h3>
        <?php if (count($lostItems) > 0): ?>
        <table>
            <tr>
                <th>Item Name</th>
                <th>Description</th>
                <th>Location</th>
                <th>Date Lost</th>
                <th>Status</th>
            </tr>
            <?php foreach ($lostItems as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['itemName']) ?></td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td><?= htmlspecialchars($item['locationLost']) ?></td>
                    <td><?= htmlspecialchars($item['dateLost']) ?></td>
                    <td><?= htmlspecialchars($item['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p>No lost items reported.</p>
        <?php endif; ?>


        <!-- Found Items Section -->
        <h3 class="text-2xl mb-5  text-center font-bold">Found Items Reported</h3>
        <?php if (count($foundItems) > 0): ?>
        <table>
            <tr>
                <th>Item Name</th>
                <th>Description</th>
                <th>Location</th>
                <th>Date Found</th>
                <th>Status</th>
            </tr>
            <?php foreach ($foundItems as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['itemName']) ?></td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td><?= htmlspecialchars($item['locationFound']) ?></td>
                    <td><?= htmlspecialchars($item['dateFound']) ?></td>
                    <td><?= htmlspecialchars($item['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p>No found items reported.</p>
        <?php endif; ?>
    </div>
    <?php include '../UI/footer.php';?> 
</div>
</body>
</html>
