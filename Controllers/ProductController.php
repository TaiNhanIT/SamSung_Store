<?php
require_once __DIR__ . '/../Models/Products.php';
require_once __DIR__ . '/../Models/Category.php';

class ProductController
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        $db = new Database();
        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
    }

    // Hiển thị form thêm sản phẩm
    public function add()
    {
        $categories = $this->categoryModel->getAll();
        require 'views/products/addProducts.php';
    }

    // Xử lý lưu sản phẩm
    public function store()
    {
        $product_id = $this->productModel->addProduct($_POST, $_FILES);

        if ($product_id && !empty($_POST['category_ids'])) {
            foreach ($_POST['category_ids'] as $cat_id) {
                $this->productModel->addProductCategory($product_id, $cat_id);
            }
        }

        header('Location: ?controller=home&action=index');
        exit();
    }

    // Hiển thị danh sách sản phẩm để quản lý
    public function manage()
    {
        $products = $this->productModel->getAll();
        require 'views/products/manageProducts.php';
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function edit()
    {
        $id = $_GET['id'];
        $product = $this->productModel->getById($id);
        $categories = $this->categoryModel->getAll();
        $productCategories = $this->productModel->getProductCategories($id);

        if (!$product) {
            die('Sản phẩm không tồn tại.');
        }

        require 'views/products/editProducts.php';
    }

    // Cập nhật sản phẩm
    public function update()
    {
        $id = $_GET['id'];
        $this->productModel->updateProduct($id, $_POST, $_FILES);
        header('Location: ?controller=product&action=manage');
        exit();
    }

    // Xóa sản phẩm
    public function delete()
    {
        $id = $_GET['id'];
        $this->productModel->deleteProduct($id);
        header('Location: ?controller=product&action=manage');
        exit();
    }
}