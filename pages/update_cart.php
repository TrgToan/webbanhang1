<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'webbanhang1');

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_SESSION['user_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Cập nhật giỏ hàng thành công.";
    } else {
        echo "Có lỗi xảy ra khi cập nhật giỏ hàng.";
    }

    $stmt->close();
}

$conn->close();
header("Location: cart.php"); // Chuyển hướng về trang giỏ hàng
exit;
?>
