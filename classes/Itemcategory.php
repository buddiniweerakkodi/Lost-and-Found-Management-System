<?php
require_once __DIR__ . '/../config/database.php';

class ItemCategory {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM item_categories";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
