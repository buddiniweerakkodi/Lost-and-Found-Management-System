<?php
require_once 'pwChangeInterface.php';
require_once '../config/database.php';

class AdminPwChange implements PasswordChangerInterface {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect(); 
    }

public function verifyCurrentPassword($adminId, $currentPassword) {
    $stmt = $this->conn->prepare("SELECT password FROM admins WHERE adminId = ?");
    $stmt->execute([$adminId]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) return false;

    $storedPassword = $admin['password'];

    // Check if it's a hashed password (starts with $2y$)
    if (strpos($storedPassword, '$2y$') !== 0) {
        // Not hashed - convert it
        if ($storedPassword === $currentPassword) {
            // Password matches, now hash it and save
            $hashed = password_hash($currentPassword, PASSWORD_DEFAULT);
            $update = $this->conn->prepare("UPDATE admins SET password = ? WHERE adminId = ?");
            $update->execute([$hashed, $adminId]);
            return true;
        } else {
            return false; // Wrong password
        }
    }

    // Normal case — already hashed
    return password_verify($currentPassword, $storedPassword);
}

    public function updatePassword($adminId, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE admins SET password = ? WHERE adminId = ?");
        return $stmt->execute([$hashed, $adminId]);
    }
}
?>
