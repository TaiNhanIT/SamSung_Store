<?php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa khách hàng</title>
    <link rel="stylesheet" href="/SamSung/css/edit.css">
</head>
<body>
<div class="edit-container">
    <h2>Sửa khách hàng</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Họ:
            <input type="text" name="first_name" value="<?= htmlspecialchars($customer['first_name']) ?>" required>
        </label>
        <label>Tên:
            <input type="text" name="last_name" value="<?= htmlspecialchars($customer['last_name']) ?>" required>
        </label>
        <label>Số điện thoại:
            <input type="text" name="phone_number" value="<?= htmlspecialchars($customer['phone_number']) ?>" required>
        </label>
        <label>Email:
            <input type="email" value="<?= htmlspecialchars($customer['email']) ?>" disabled>
        </label>
        <label>Mật khẩu mới:
            <input type="password" name="password" placeholder="Đổi mật khẩu nếu muốn!">
        </label>

        <div class="address-group">
            <label>Địa chỉ:</label>
            <?php if (!empty($addresses) && is_array($addresses)): ?>
                <?php foreach ($addresses as $i => $address): ?>
                    <div class="address-row">
                        <input type="text" name="addresses[<?= $i ?>][street]" value="<?= htmlspecialchars($address['street']) ?>" placeholder="Street" required>
                        <input type="text" name="addresses[<?= $i ?>][city]" value="<?= htmlspecialchars($address['city']) ?>" placeholder="City" required>
                        <input type="text" name="addresses[<?= $i ?>][country_code]" value="<?= htmlspecialchars($address['country_code']) ?>" placeholder="Country" required>
                        <button name="delete_address" value="<?= $i ?>" type="submit">Xóa</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <span style="color:#888;">Chưa có địa chỉ</span>
            <?php endif; ?>
        </div>
        <div class="add-address-row">
            <input type="text" name="new_street" placeholder="Street">
            <input type="text" name="new_city" placeholder="City">
            <input type="text" name="new_country_code" placeholder="Country">
            <button name="add_address" type="submit">Thêm</button>
        </div>
        <div class="btn-group">
            <button type="submit" class="btn-save">Lưu</button>
            <a href="?controller=customer&action=index"><button type="button" class="btn-cancel">Hủy</button></a>
        </div>
    </form>
</div>
</body>
</html>