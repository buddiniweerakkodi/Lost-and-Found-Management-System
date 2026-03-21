<?php
require_once '../classes/FoundItem.php';

$found = new FoundItem();
$item = null;

if (isset($_GET['id'])) {
    $item = $found->getItemById($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $found->updateItem($_POST['id'], [
        'itemName' => $_POST['itemName'],
        'description' => $_POST['description'],
        'locationFound' => $_POST['location'],
        'dateFound' => $_POST['date'],
        'categoryId' => $_POST['categoryId']
    ]);
    header("Location: managereports.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Found Reports</title>
  <link rel="stylesheet" href="../UI/styles.css">
</head>
<body>

  <div class="page-wrapper">
    
    <?php include '../UI/header.php'; ?>

    <div class="main-content">
        <form method="POST">
    <input type="hidden" type="text" name="id" value="<?= $item['foundItemId'] ?>">
    Name: <input type="text" name="itemName" value="<?= $item['itemName'] ?>"><br>
    Description: <textarea name="description"><?= $item['description'] ?></textarea><br>
    Location: <input type="text" name="location" value="<?= $item['locationFound'] ?>"><br>
    Date Found: <input name="date" type="date" value="<?= $item['dateFound'] ?>"><br>
    <button type="submit" class="btn edit-btn btn-dash">Update</button>
</form>
    </div>

    <?php include '../UI/footer.php'; ?>

  </div>
</body>
</html>


