<?php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách khách hàng đã đăng nhập</title>
    <link rel="stylesheet" href="/SamSung/css/customers.css">
</head>
<body>
<div class="customer-container">
    <h1 style="text-align:center; color:#ffd600; margin-bottom:24px;">Danh sách khách hàng đã đăng nhập</h1>
    <table class="customer-table">
        <tr>
            <th>ID</th>
            <th>Họ</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Mật khẩu</th>
            <th>Địa chỉ</th>
            <th>Hành động</th>
        </tr>
        <?php if (!empty($customers)): ?>
            <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= $customer['id']; ?></td>
                <td><?= htmlspecialchars($customer['first_name']); ?></td>
                <td><?= htmlspecialchars($customer['last_name']); ?></td>
                <td><?= htmlspecialchars($customer['email']); ?></td>
                <td><?= htmlspecialchars($customer['phone_number']); ?></td>
                <td>******</td>
                <td>
                    <?php
                    if (!empty($customer['address']) && is_array($customer['address'])) {
                        foreach ($customer['address'] as $address) {
                            echo htmlspecialchars($address) . "<br>";
                        }
                    } else {
                        echo "<span style='color:#888;'>Chưa có</span>";
                    }
                    ?>
                </td>
                <td>
                    <div class="action-group">
                        <a href="?controller=customer&action=edit&id=<?= $customer['id']; ?>">
                            <button class="action-btn">Sửa</button>
                        </a>
                        <a href="?controller=customer&action=delete&id=<?= $customer['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');">
                            <button class="delete-btn">Xóa</button>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="color:#fff;">Không có khách hàng nào.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<!-- Đưa phân trang xuống dưới cùng trang -->
<?php if (isset($totalPages) && $totalPages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?controller=customer&action=index&page=<?= $page-1 ?>">&laquo; Trước</a>
        <?php endif; ?>
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <?php if ($p == $page): ?>
                <span class="current"><?= $p ?></span>
            <?php else: ?>
                <a href="?controller=customer&action=index&page=<?= $p ?>"><?= $p ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
            <a href="?controller=customer&action=index&page=<?= $page+1 ?>">Tiếp &raquo;</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
</body>
</html>