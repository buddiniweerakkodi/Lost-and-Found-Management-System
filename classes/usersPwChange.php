<?php
require_once 'pwChangeInterface.php';
require_once '../config/database.php';

class UsersPwChange implements PasswordChangerInterface {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

public function verifyCurrentPassword($userId, $currentPassword) {
    $stmt = $this->conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && isset($user['password'])) {
        return password_verify($currentPassword, $user['password']);
    }

    return false;
}

    public function updatePassword($userId, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashed, $userId]);
    }
}
?>
