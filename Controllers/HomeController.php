<?php
class HomeController {
    // Hàm này sẽ hiển thị trang chủ
    public function index() {
        require_once __DIR__ . '/../views/home/home.php'; // Nạp view trang chủ
    }
}