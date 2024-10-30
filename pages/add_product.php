<?php
// Kết nối đến cơ sở dữ liệu
$host = 'localhost'; // Địa chỉ máy chủ
$db = 'webbanhang1'; // Tên cơ sở dữ liệu
$user = 'root'; // Tên người dùng
$pass = ''; // Mật khẩu

// Tạo kết nối
$conn = new mysqli($host, $user, $pass, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra nếu có dữ liệu POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name']; // Lấy tên hình ảnh từ input file

    // Di chuyển hình ảnh đến thư mục images
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Lưu thông tin sản phẩm vào cơ sở dữ liệu
    $sql = "INSERT INTO products (name, price, image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sds", $name, $price, $image);

    if ($stmt->execute()) {
        echo "Sản phẩm đã được thêm thành công!";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    // Đóng kết nối
    $stmt->close();
}

$conn->close();
?>
