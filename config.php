<?php
// Cấu hình cơ sở dữ liệu
$db_host = 'localhost';       // Địa chỉ host của cơ sở dữ liệu (thường là localhost cho máy chủ cục bộ)
$db_name = 'webbanhang1';     // Tên cơ sở dữ liệu
$db_username = 'root';         // Tên người dùng MySQL (mặc định của XAMPP là root)
$db_password = '';             // Mật khẩu MySQL (mặc định là rỗng trên XAMPP)

try {
    // Tạo kết nối PDO với MySQL
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_username, $db_password);
    
    // Thiết lập chế độ lỗi PDO để hiển thị ngoại lệ
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Đảm bảo mọi dữ liệu được lưu trữ dưới dạng UTF-8
    $conn->exec("SET NAMES 'utf8'");

} catch (PDOException $e) {
    // Hiển thị thông báo lỗi nếu kết nối thất bại
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}
?>
