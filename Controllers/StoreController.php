<?php
require_once __DIR__ . '/../models/Products.php';
class StoreController {
    public function store() {
        $productModel = new Product();
        $product_id = $productModel->addProduct($_POST, $_FILES);

        // Lưu danh mục
        if ($product_id && !empty($_POST['category_ids'])) {
            foreach ($_POST['category_ids'] as $cat_id) {
                $productModel->addProductCategory($product_id, $cat_id);
            }
        }
        header('Location: ?controller=home');
    }
}