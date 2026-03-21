<?php
require_once '../classes/Admin.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_POST['id'] ?? '';
$type = $_POST['type'] ?? '';


if ($id && ($type === 'lost' || $type === 'found')) {
    $admin = new Admin();
    $admin->approveReport($id, $type);
}

header("Location: viewReports.php?type=$type");
exit;
