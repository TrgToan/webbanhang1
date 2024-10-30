<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Giả định bạn có các thông tin đăng nhập cứng
    $username = 'admin';
    $password = 'password';

    // Nhận thông tin từ biểu mẫu
    $inputUsername = $_POST['username'] ?? '';
    $inputPassword = $_POST['password'] ?? '';

    // Kiểm tra thông tin đăng nhập
    if ($inputUsername === $username && $inputPassword === $password) {
        $_SESSION['username'] = $inputUsername; // Lưu thông tin phiên
        header("Location: home.php"); // Chuyển hướng về trang chính
        exit();
    } else {
        $error = "Sai tên đăng nhập hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng Nhập</h2>
    <form method="POST" action="">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Đăng nhập</button>
    </form>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
