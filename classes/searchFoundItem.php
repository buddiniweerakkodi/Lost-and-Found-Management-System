<?php
require_once 'ItemInterface.php';
require_once '../config/database.php';

class searchFoundItem implements ItemInterface {
    protected $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function searchByName($name) {
        $stmt = $this->conn->prepare("SELECT * FROM found_items WHERE itemName LIKE ?");
        $stmt->execute(['%' . $name . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllItems() {
        $stmt = $this->conn->query("SELECT * FROM found_items");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>
