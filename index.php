<?php
// Include tệp kết nối cơ sở dữ liệu
include 'includes/db.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: pages/home.php"); // Nếu đã đăng nhập, chuyển hướng đến trang home
    exit();
}

// Xử lý đăng ký
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Mã hóa mật khẩu

    // Sửa dòng này từ $pdo thành $conn
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);

    if ($stmt) {
        header("Location: index.php?login=1"); // Chuyển hướng về trang đăng nhập sau khi đăng ký thành công
        exit();
    } else {
        $error = "Lỗi: Không thể đăng ký người dùng.";
    }
}

// Xử lý đăng nhập
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sửa dòng này từ $pdo thành $conn
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt && $stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password'])) {
            // Tạo session và chuyển hướng về trang home
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: pages/home.php");
            exit();
        } else {
            $error = "Sai mật khẩu!";
        }
    } else {
        $error = "Email không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đăng nhập & Đăng ký</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Kết nối file CSS -->
</head>
<body>
    <div class="container">
        <h1>Chào mừng đến với Web Bán Hàng</h1>
        
        <?php if (isset($_GET['login'])): ?>
            <!-- Form Đăng nhập -->
            <h2>Đăng nhập</h2>
            <form method="POST" action="index.php">
                <label>Email:</label>
                <input type="email" name="email" required>
                <label>Mật khẩu:</label>
                <input type="password" name="password" required>
                <button type="submit" name="login">Đăng nhập</button>
                <p>Bạn chưa có tài khoản? <a href="index.php">Đăng ký ngay</a></p>
            </form>
        <?php else: ?>
            <!-- Form Đăng ký -->
            <h2>Đăng ký</h2>
            <form method="POST" action="index.php">
                <label>Tên người dùng:</label>
                <input type="text" name="username" required>
                <label>Email:</label>
                <input type="email" name="email" required>
                <label>Mật khẩu:</label>
                <input type="password" name="password" required>
                <button type="submit" name="register">Đăng ký</button>
                <p>Bạn đã có tài khoản? <a href="index.php?login=1">Đăng nhập</a></p>
            </form>
        <?php endif; ?>

        <!-- Hiển thị lỗi (nếu có) -->
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
