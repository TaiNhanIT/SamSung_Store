<?php
require_once __DIR__ . '/../models/Products.php';
require_once __DIR__ . '/../models/Category.php';

class HomeController
{
    private $categoryModel;
    private $productModel;

    public function __construct()
    {
        // Khởi tạo các model với kết nối cơ sở dữ liệu
        $db = new Database(); // Giả sử Database.php đã được import trong Category.php hoặc Product.php
        $this->categoryModel = new Category($db);
        $this->productModel = new Product($db);
    }

    public function index()
    {
        try {
            // Lấy danh sách tất cả danh mục
            $categories = $this->categoryModel->getAll();

            // Khởi tạo mảng để lưu sản phẩm theo danh mục
            $productsByCategory = [];

            // Lấy sản phẩm cho mỗi danh mục
            foreach ($categories as $cat) {
                $categoryId = $cat['id'];
                $productsByCategory[$categoryId] = $this->productModel->getByCategory($categoryId) ?: [];
            }

            // Truyền dữ liệu vào view
            require 'views/home/home.php';
        } catch (Exception $e) {
            // Xử lý lỗi (có thể ghi log hoặc hiển thị thông báo)
            die('Lỗi khi tải trang chủ: ' . $e->getMessage());
        }
    }
}