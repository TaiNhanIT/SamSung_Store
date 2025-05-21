<?php if (!empty($register_success)): ?>
    <div class="alert alert-success" style="text-align:center;"><?= htmlspecialchars($register_success) ?></div>
<?php endif; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="/Commercer/css/loginandregister.css">
</head>
<body>
<div class="register-container">
    <h2>Đăng nhập</h2>
    <?php if (!empty($login_error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($login_error) ?></div>
    <?php endif; ?>
    <form method="post" action="?controller=auth&action=login">
        <input type="email" name="email" placeholder="Email" required
               value="<?= htmlspecialchars($email ?? '') ?>">
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng nhập</button>
    </form>
    <a class="switch-link" href="/Commercer/?controller=auth&action=register">Chưa có tài khoản? Đăng ký tại đây</a>
</div>
<!-- Xóa dòng đăng xuất ở trang đăng nhập, không cần thiết -->
</body>
</html>