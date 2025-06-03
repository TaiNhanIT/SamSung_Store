<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm - Samsung</title>
    <link rel="stylesheet" href="/SamSung/css/products.css?v=<?=time()?>">
</head>
<body>
    <div class="container">
        <h1>Chỉnh sửa sản phẩm</h1>
        <a href="?controller=product&action=manage" class="btn-back">← Quay lại danh sách</a>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="?controller=product&action=update&id=<?= htmlspecialchars($product['id']) ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Tên sản phẩm:</label>
                <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Giá (VNĐ):</label>
                <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description" placeholder="Nhập mô tả sản phẩm..."><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="stock_quantity">Số lượng:</label>
                <input type="number" id="stock_quantity" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" required min="0">
            </div>

            <div class="form-group">
                <label for="category_ids">Danh mục (có thể chọn nhiều):</label>
                <select id="category_ids" name="category_ids[]" multiple required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['id']) ?>"
                            <?php 
                                $selected = false;
                                foreach ($productCategories as $pc) {
                                    if ($pc['category_id'] == $cat['id']) {
                                        $selected = true;
                                        break;
                                    }
                                }
                                echo $selected ? 'selected' : '';
                            ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small style="color: #666;">Giữ Ctrl (hoặc Cmd) để chọn nhiều danh mục</small>
            </div>

            <div class="form-group">
                <label>Ảnh hiện tại:</label>
                <?php if (!empty($product['image']) && file_exists('images/' . $product['image'])): ?>
                    <img src="/SamSung/images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" width="100">
                <?php else: ?>
                    <span>Không có ảnh</span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="image">Thay đổi ảnh sản phẩm:</label>
                <input type="file" id="image" name="image" accept="image/*">
                <small style="color: #666;">Để trống nếu không muốn thay đổi ảnh</small>
            </div>

            <button type="submit" class="btn-submit">Cập nhật sản phẩm</button>
        </form>
    </div>
</body>
</html>