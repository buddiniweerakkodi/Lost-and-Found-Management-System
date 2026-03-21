<?php
require_once __DIR__ . '/../config/database.php';

class Student extends User {
    protected $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function addStudent($userId, $enrollmentNo) {
        $sql = "INSERT INTO students (id, enrollmentNo) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$userId, $enrollmentNo]);
    }
}
