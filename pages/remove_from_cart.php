<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để xóa sản phẩm khỏi giỏ hàng.");
}

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'webbanhang1');
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin từ yêu cầu GET
$user_id = $_SESSION['user_id'];
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

// Kiểm tra thông tin sản phẩm
if ($product_id <= 0) {
    die("Thông tin sản phẩm không hợp lệ.");
}

// Xóa sản phẩm khỏi giỏ hàng
$sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);

if ($stmt->execute()) {
    echo "Sản phẩm đã được xóa khỏi giỏ hàng.";
} else {
    echo "Lỗi khi xóa sản phẩm khỏi giỏ hàng.";
}

$stmt->close();
$conn->close();
?>
