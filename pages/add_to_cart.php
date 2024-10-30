<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.");
}

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'webbanhang1');
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin từ yêu cầu POST
$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

// Kiểm tra thông tin sản phẩm
if ($product_id <= 0 || $quantity <= 0) {
    die("Thông tin sản phẩm không hợp lệ.");
}

// Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng của người dùng chưa
$sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
    $sql = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
} else {
    // Sản phẩm chưa tồn tại, thêm sản phẩm mới vào giỏ hàng
    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
}

if ($stmt->execute()) {
    echo "Sản phẩm đã được thêm vào giỏ hàng.";
} else {
    echo "Lỗi khi thêm sản phẩm vào giỏ hàng.";
}

$stmt->close();
$conn->close();
?>
