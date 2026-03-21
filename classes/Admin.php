<?php
require_once __DIR__ . '/../config/database.php';

class Admin {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function loginAsAdmin($username, $password) {
        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $hashed = $admin['password'];

            // Try hashed password
            if (password_verify($password, $hashed)) {
                session_start();
                $_SESSION['admin'] = $admin;
                return true;
            }

            // Fallback to plain-text (temporary support)
            if ($password === $hashed) {
                session_start();
                $_SESSION['admin'] = $admin;
                return true;
            }
        }

        return false;
    }

    public function approveReport($itemId, $type) {
        $table = $type === 'lost' ? 'lost_items' : 'found_items';
        $sql = "UPDATE $table SET status = 'Approved' WHERE {$type}ItemId = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$itemId]);
    }
}
?>
