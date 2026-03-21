<?php

require_once 'ItemInterface.php';
require_once '../config/database.php';

class searchLostItem implements ItemInterface {
    protected $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function searchByName($name) {
        $stmt = $this->conn->prepare("SELECT * FROM lost_items WHERE itemName LIKE ?");
        $stmt->execute(['%' . $name . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllItems() {
        $stmt = $this->conn->query("SELECT * FROM lost_items");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>