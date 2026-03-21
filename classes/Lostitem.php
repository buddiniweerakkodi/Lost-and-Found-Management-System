<?php
require_once 'Item.php';

class LostItem extends Item {

    public function submitLostItem($userId, $dateLost, $photo, $itemName, $description, $location, $categoryId) {
        $sql = "INSERT INTO lost_items (userId, dateLost, photo, status, itemName, description, locationLost, categoryId)
                VALUES (?, ?, ?, 'Pending', ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$userId, $dateLost, $photo, $itemName, $description, $location, $categoryId]);
    }

    public function getAllLostItems() {
        $sql = "SELECT * FROM lost_items";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItemById($id) {
        $sql = "SELECT * FROM lost_items WHERE lostItemId = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getItemsByUserId($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM lost_items WHERE userId = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateItem($id, $data) {
        $sql = "UPDATE lost_items SET itemName = ?, description = ?, locationLost = ?, dateLost = ?, categoryId = ? WHERE lostItemId = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['itemName'],
            $data['description'],
            $data['locationLost'],
            $data['dateLost'],
            $data['categoryId'],
            $id
        ]);
    }

    public function deleteItem($id) {
        $stmt = $this->conn->prepare("DELETE FROM lost_items WHERE lostItemId = ?");
        return $stmt->execute([$id]);
    }
}
