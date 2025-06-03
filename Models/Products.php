<?php
require_once __DIR__ . '/../core/Database.php';

class Product extends Database
{
    public function addProduct($data, $files)
    {
        $db = $this->connect();
        $stmt = $db->prepare("INSERT INTO products (product_name, price, description, stock_quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['product_name'],
            $data['price'],
            $data['description'],
            $data['stock_quantity']
        ]);
        $product_id = $db->lastInsertId();

        if (!empty($files['image']['name'])) {
            $imgName = uniqid() . '_' . basename($files['image']['name']);
            move_uploaded_file($files['image']['tmp_name'], 'images/' . $imgName);
            $db->prepare("UPDATE products SET image = ? WHERE id = ?")->execute([$imgName, $product_id]);
        }
        return $product_id;
    }

    public function addProductCategory($product_id, $category_id)
    {
        $db = $this->connect();
        $stmt = $db->prepare("INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)");
        $stmt->execute([$product_id, $category_id]);
    }

    public function getByCategory($category_id)
    {
        $db = $this->connect();
        $stmt = $db->prepare("
            SELECT p.* FROM products p
            JOIN product_categories pc ON p.id = pc.product_id
            WHERE pc.category_id = ?
            ORDER BY p.id DESC
        ");
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $db = $this->connect();
        $stmt = $db->query("SELECT * FROM products ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $db = $this->connect();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh mục của sản phẩm
    public function getProductCategories($product_id)
    {
        $db = $this->connect();
        $stmt = $db->prepare("SELECT category_id FROM product_categories WHERE product_id = ?");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $data, $files)
    {
        $db = $this->connect();
        $stmt = $db->prepare("UPDATE products SET product_name = ?, price = ?, description = ?, stock_quantity = ? WHERE id = ?");
        $stmt->execute([
            $data['product_name'],
            $data['price'],
            $data['description'],
            $data['stock_quantity'],
            $id
        ]);

        if (!empty($files['image']['name'])) {
            $imgName = uniqid() . '_' . basename($files['image']['name']);
            move_uploaded_file($files['image']['tmp_name'], 'images/' . $imgName);
            $db->prepare("UPDATE products SET image = ? WHERE id = ?")->execute([$imgName, $id]);
        }

        // Xóa danh mục cũ
        $db->prepare("DELETE FROM product_categories WHERE product_id = ?")->execute([$id]);

        // Thêm danh mục mới
        if (!empty($data['category_ids'])) {
            foreach ($data['category_ids'] as $category_id) {
                $this->addProductCategory($id, $category_id);
            }
        }
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $db = $this->connect();
        // Xóa quan hệ danh mục
        $db->prepare("DELETE FROM product_categories WHERE product_id = ?")->execute([$id]);
        // Xóa sản phẩm
        $db->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
    }
}