<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới - Samsung</title>
    <link rel="stylesheet" href="/SamSung/css/products.css">
</head>

<body>
    <div class="add-product-container">
        <a href="?controller=home&action=index" class="btn-back">← Quay lại trang chủ</a>
        <h2>Thêm sản phẩm mới</h2>
        <form action="?controller=product&action=store" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tên sản phẩm:</label>
                <input type="text" name="product_name" required>
            </div>

            <div class="form-group">
                <label>Giá (VNĐ):</label>
                <input type="number" name="price" step="0.01" required>
            </div>

            <div class="form-group">
                <label>Mô tả:</label>
                <textarea name="description" placeholder="Nhập mô tả sản phẩm..."></textarea>
            </div>

            <div class="form-group">
                <label>Số lượng:</label>
                <input type="number" name="stock_quantity" required min="0">
            </div>

            <div class="form-group">
                <label>Danh mục (có thể chọn nhiều):</label>
                <select name="category_ids[]" multiple required>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Không có danh mục</option>
                    <?php endif; ?>
                </select>
                <small style="color: #666;">Giữ Ctrl (hoặc Cmd) để chọn nhiều danh mục</small>
            </div>

            <div class="form-group">
                <label>Ảnh sản phẩm:</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <button type="submit" class="btn-submit">Thêm sản phẩm</button>
        </form>
    </div>
</body>

</html>