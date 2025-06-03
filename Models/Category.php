<?php
require_once __DIR__ . '/../core/Database.php';

class Category extends Database
{
    // Lấy tất cả danh mục
    public function getAll()
    {
        $db = $this->connect();
        $stmt = $db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh mục theo id 
    public function getById($id)
    {
        $db = $this->connect();
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}