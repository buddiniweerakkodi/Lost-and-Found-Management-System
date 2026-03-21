<?php
require_once '../classes/LostItem.php';

if (isset($_GET['id'])) {
    $lost = new LostItem();
    $lost->deleteItem($_GET['id']);
}

header("Location: managereports.php");
exit;
