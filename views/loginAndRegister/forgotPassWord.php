<?php
?>
<!-- filepath: d:\xampp\htdocs\SamSung\views\loginAndRegister\forgotPassword.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
</head>
<body>
    <form method="post">
        <h2>Quên mật khẩu</h2>
        <input type="email" name="email" placeholder="Nhập email của bạn" required>
        <button type="submit">Gửi yêu cầu</button>
        <div style="color:red"><?= $error ?? '' ?></div>
        <div style="color:green"><?= $success ?? '' ?></div>
    </form>
</body>
</html>