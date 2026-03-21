<?php
require_once '../classes/LostItem.php';

$lost = new LostItem();
$item = null;

if (isset($_GET['id'])) {
    $item = $lost->getItemById($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lost->updateItem($_POST['id'], [
        'itemName' => $_POST['itemName'],
        'description' => $_POST['description'],
        'locationLost' => $_POST['location'],
        'dateLost' => $_POST['date'],
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
  <title>Edit Lost</title>
  <link rel="stylesheet" href="../UI/styles.css">
</head>
<body>

  <div class="page-wrapper">
    
    <?php include '../UI/header.php'; ?>

    <div class="main-content">
        <form method="POST">
    <input type="hidden" name="id" value="<?= $item['lostItemId'] ?>">
    Name: <input type="text" name="itemName" value="<?= $item['itemName'] ?>"><br>
    Description: <textarea name="description"><?= $item['description'] ?></textarea><br>
    Location: <input type="text" name="location" value="<?= $item['locationLost'] ?>"><br>
    Date Lost: <input name="date" type="date" value="<?= $item['dateLost'] ?>"><br>
    <button type="submit" class="btn edit-btn btn-dash">Update</button>
</form>
    </div>

    <?php include '../UI/footer.php'; ?>

  </div>
</body>
</html>




