<?php

if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Samsung</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <header>
    <a href="index.html" class="logo">Samsung</a>
    <nav>
        <ul style="display: flex; align-items: center;">
            <li><a href="category.html">Điện thoại</a></li>
            <li><a href="category.html">TV & AV</a></li>
            <li><a href="category.html">Gia Dụng</a></li>
            <li><a href="category.html">Phụ kiện</a></li>
            <li style="margin-left:40px;">
                <a href="?controller=auth&action=login" style="display:inline-block;padding:8px 24px;border-radius:8px;background:linear-gradient(90deg,#d16ba5 0%,#5ffbf1 100%);color:#fff;font-weight:bold;text-decoration:none;text-align:center;width:150px;">Đăng nhập / Đăng ký</a>
            </li>
            <li>
                <a href="?controller=auth&action=logout" style="display:inline-block;padding:8px 24px;border-radius:8px;background:linear-gradient(90deg,#ff5858 0%,#f09819 100%);color:#fff;font-weight:bold;text-decoration:none;text-align:center;width:150px;margin-left:10px;" onclick="return confirmLogout(event);">Đăng xuất</a>
            </li>
        </ul>
    </nav>
</header>
    <!-- Banner -->
    <section class="banner">
        <div class="banner-content">
            <h1>Galaxy S25 Ultra</h1>
            <p>Galaxy AI</p>
            <button class="btn-buy">Mua ngay</button>
        </div>
    </section>

    <!-- Product Slider -->
    <section class="product-slider">
        <h2>Sản phẩm nổi bật</h2>
        <div class="slider">
            <div class="product">
                <img src="images/product1.jpg" alt="Product 1">
                <p>Điện thoại</p>
                <a href="product.html" class="btn-view">Xem chi tiết</a>
            </div>
            <div class="product">
                <img src="images/product2.jpg" alt="Product 2">
                <p>TV</p>
                <a href="product.html" class="btn-view">Xem chi tiết</a>
            </div>
            <div class="product">
                <img src="images/product3.jpg" alt="Product 3">
                <p>Máy giặt</p>
                <a href="product.html" class="btn-view">Xem chi tiết</a>
            </div>
        </div>
    </section>

   <!-- Footer -->
<footer>
    <ul>
        <li><a href="cart.html">Giỏ hàng</a></li>
        <li><a href="category.html">Danh mục sản phẩm</a></li>
        <li><a href="checkout.html">Thanh toán</a></li>
        <li><a href="product.html">Chi tiết sản phẩm</a></li>
        <li><a href="?controller=customer&action=index">Xem danh sách khách hàng</a></li>
    </ul>
    <p>&copy; 2025 Sibi | Tất cả quyền được bảo lưu</p>
</footer>
    <script src="js/main.js"></script>
    <script>
    function confirmLogout(event) {
        if (confirm('Bạn có chắc muốn đăng xuất?')) {
            return true;
        } else {
            event.preventDefault();
            return false;
        }
    }
    </script>
</body>
</html>