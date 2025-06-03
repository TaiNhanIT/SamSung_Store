<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm - Samsung</title>
    <link rel="stylesheet" href="/SamSung/css/products.css?v=<?=time()?>">
</head>
<body>
    <div class="container">
        <h1>Quản lý sản phẩm</h1>
        <a href="?controller=home&action=index" class="btn-back">← Quay lại trang chủ</a>
        <table class="product-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá (VNĐ)</th>
                    <th>Số lượng</th>
                    <th>Ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['id']) ?></td>
                            <td><?= htmlspecialchars($product['product_name']) ?></td>
                            <td><?= number_format($product['price'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($product['stock_quantity']) ?></td>
                            <td>
                                <?php if (!empty($product['image']) && file_exists('images/' . $product['image'])): ?>
                                    <img src="/SamSung/images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" width="50">
                                <?php else: ?>
                                    <span>Không có ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?controller=product&action=edit&id=<?= $product['id'] ?>" class="btn-edit">Sửa</a>
                                <a href="?controller=product&action=delete&id=<?= $product['id'] ?>" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Chưa có sản phẩm nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>