<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Samsung Store 2</title>
    <link rel="stylesheet" href="/SamSung/css/style.css?v=<?=time()?>">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
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
                <li style="margin-left:10px;">
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

    <!-- Product Slider (Tất cả sản phẩm) -->
<section class="product-slider">
    <h2>Tất cả sản phẩm</h2>
    <div class="owl-carousel owl-theme all-products-slider">
        <?php
        $allProducts = [];
        foreach ($productsByCategory as $products) {
            $allProducts = array_merge($allProducts, $products);
        }
        if (!empty($allProducts)) {
            foreach ($allProducts as $product) {
                ?>
                <div class="item">
                    <?php if (!empty($product['image']) && file_exists('images/' . $product['image'])): ?>
                        <img src="/SamSung/images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" class="product-image">
                    <?php else: ?>
                        <div class="no-image-placeholder">
                            <span>📷</span>
                            <p>Không có ảnh</p>
                        </div>
                    <?php endif; ?>
                    <div class="product-title"><?= htmlspecialchars($product['product_name']) ?></div>
                    <div class="product-price"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</div>
                    <a href="product.html?id=<?= $product['id'] ?>" class="btn-view">Xem chi tiết</a>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="item">
                <p>Chưa có sản phẩm nào.</p>
            </div>
            <?php
        }
        ?>
    </div>
</section>

<!-- Product Sliders by Category -->
<?php if (!empty($categories)): ?>
    <?php foreach ($categories as $cat): ?>
        <section class="product-slider">
            <h2><?= htmlspecialchars($cat['name']) ?></h2>
            <div class="owl-carousel owl-theme category-slider-<?= $cat['id'] ?>">
                <?php 
                    $products = $productsByCategory[$cat['id']] ?? [];
                    if (!empty($products)):
                ?>
                    <?php foreach ($products as $product): ?>
                        <div class="item">
                            <?php if (!empty($product['image']) && file_exists('images/' . $product['image'])): ?>
                                <img src="/SamSung/images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" class="product-image">
                            <?php else: ?>
                                <div class="no-image-placeholder">
                                    <span>📷</span>
                                    <p>Không có ảnh</p>
                                </div>
                            <?php endif; ?>
                            <div class="product-title"><?= htmlspecialchars($product['product_name']) ?></div>
                            <div class="product-price"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</div>
                            <a href="product.html?id=<?= $product['id'] ?>" class="btn-view">Xem chi tiết</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="item">
                        <p>Chưa có sản phẩm nào trong danh mục này.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
<?php else: ?>
    <section class="product-slider">
        <h2>Chưa có danh mục nào</h2>
    </section>
<?php endif; ?>

    <!-- Footer -->
<footer>
    <ul>
        <li><a href="cart.html">Giỏ hàng</a></li>
        <li><a href="category.html">Danh mục sản phẩm</a></li>
        <li><a href="checkout.html">Thanh toán</a></li>
        <li><a href="product.html">Chi tiết sản phẩm</a></li>
        <li><a href="?controller=customer&action=index">Xem danh sách khách hàng</a></li>
        <li><a href="?controller=product&action=manage">Quản lý sản phẩm</a></li> 
    </ul>
    <p>© 2025 Sibi | Tất cả quyền được bảo lưu</p>
</footer>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        function confirmLogout(event) {
            if (confirm('Bạn có chắc muốn đăng xuất?')) {
                return true;
            } else {
                event.preventDefault();
                return false;
            }
        }

        // Khởi tạo slider chính (Tất cả sản phẩm)
        $('.all-products-slider').owlCarousel({
            items: 4,
            loop: <?= count($allProducts ?? []) > 4 ? 'true' : 'false' ?>,
            margin: 30,
            autoplay: true,
            autoplayTimeout: 2500,
            autoplayHoverPause: true,
            responsive: {
                0: { items: 1 },
                768: { items: 2 },
                1024: { items: 4 }
            }
        });

        // Khởi tạo slider cho từng danh mục
        <?php foreach ($categories as $cat): ?>
            $('.category-slider-<?= $cat['id'] ?>').owlCarousel({
                items: 4,
                loop: <?= count($productsByCategory[$cat['id']] ?? []) > 4 ? 'true' : 'false' ?>,
                margin: 30,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    1024: { items: 4 }
                }
            });
        <?php endforeach; ?>
    </script>
</body>

</html>