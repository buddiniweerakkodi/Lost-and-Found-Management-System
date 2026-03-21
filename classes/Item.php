<?php
require_once __DIR__ . '/../config/database.php';

abstract class Item {
    protected $conn;

    public function __construct() { 
        $db = new Database();
        $this->conn = $db->connect();
    }

    abstract public function getItemById($id);
    abstract public function getItemsByUserId($userId);
    abstract public function updateItem($id, $data);
    abstract public function deleteItem($id);
}
