<?php
require_once __DIR__ . '/../config/database.php';

class User {
    protected $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function register($name, $email, $password, $type) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $email, $hashedPassword, $type]);
    }

    public function getLastInsertId() {
        return $this->conn->lastInsertId();
    }

public function login($email, $password) {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'type' => $user['type']
        ];
        return true;
    }

    return false;
}

    public function logout() {
        session_start();
        session_destroy();
    }
    
    public function emailExists($email) {
    $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
}

public function getUserById($id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getEnrollmentByUserId($userId) {
    // First, get user info
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) return null;

    // Now check type and fetch enrollment from respective table
    if ($user['type'] === 'student') {
        $stmt = $this->conn->prepare("SELECT enrollment FROM students WHERE user_id = ?");
    } elseif ($user['type'] === 'staff') {
        $stmt = $this->conn->prepare("SELECT staff_id AS enrollment FROM staff WHERE user_id = ?");
    } else {
        return null;
    }

    $stmt->execute([$userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $row ? $row['enrollment'] : null;
}

public function updateProfile($id, $name, $email) {
    $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    return $stmt->execute([$name, $email, $id]);
}

public function changePassword($id, $newPassword) {
    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    return $stmt->execute([$hashed, $id]);
}


}
