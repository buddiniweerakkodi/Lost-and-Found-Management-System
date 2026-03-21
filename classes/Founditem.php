<?php
require_once 'Item.php';

class FoundItem extends Item {

    public function submitFoundItem($userId, $dateFound, $photo, $itemName, $description, $location, $categoryId) {
        $sql = "INSERT INTO found_items (userId, dateFound, photo, status, itemName, description, locationFound, categoryId)
                VALUES (?, ?, ?, 'Pending', ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$userId, $dateFound, $photo, $itemName, $description, $location, $categoryId]);
    }

    public function getAllFoundItems() {
        $sql = "SELECT * FROM found_items";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItemById($id) {
        $sql = "SELECT * FROM found_items WHERE foundItemId = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getItemsByUserId($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM found_items WHERE userId = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateItem($id, $data) {
        $sql = "UPDATE found_items SET itemName = ?, description = ?, locationFound = ?, dateFound = ?, categoryId = ? WHERE foundItemId = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['itemName'],
            $data['description'],
            $data['locationFound'],
            $data['dateFound'],
            $data['categoryId'],
            $id
        ]);
    }

    public function deleteItem($id) {
        $stmt = $this->conn->prepare("DELETE FROM found_items WHERE foundItemId = ?");
        return $stmt->execute([$id]);
    }
}
