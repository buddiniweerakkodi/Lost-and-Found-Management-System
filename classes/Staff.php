<?php
require_once __DIR__ . '/../config/database.php';

class Staff extends User {
    protected $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function addStaff($userId, $staffID) {
        $sql = "INSERT INTO staff (id, staffID) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$userId, $staffID]);
    }
}
