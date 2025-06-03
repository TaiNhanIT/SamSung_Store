<?php
?>
<!-- filepath: d:\xampp\htdocs\SamSung\views\loginAndRegister\resetPassword.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
</head>
<body>
    <form method="post">
        <h2>Đặt lại mật khẩu</h2>
        <input type="password" name="password" placeholder="Mật khẩu mới" required>
        <input type="password" name="repassword" placeholder="Nhập lại mật khẩu mới" required>
        <button type="submit">Đổi mật khẩu</button>
        <div style="color:red"><?= $error ?? '' ?></div>
        <div style="color:green"><?= $success ?? '' ?></div>
    </form>
</body>
</html>