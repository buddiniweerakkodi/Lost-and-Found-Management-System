<?php
require_once '../classes/FoundItem.php';

if (isset($_GET['id'])) {
    $found = new FoundItem();
    $found->deleteItem($_GET['id']);
}

header("Location: managereports.php");
exit;
