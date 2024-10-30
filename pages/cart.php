<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Đường dẫn CSS -->
</head>
<body>

    <!-- Thanh điều hướng -->
    <nav class="nav-bar">
        <ul class="nav-items">
            <li><a href="../index.php">Điện tử</a></li>
            <li><a href="../index.php">Thời trang</a></li>
            <li><a href="../index.php">Mỹ phẩm</a></li>
            <li><a href="cart.php">Giỏ hàng</a></li> <!-- Đường dẫn đến cart.php -->
            <li>
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<a href="logout.php">Đăng xuất (' . htmlspecialchars($_SESSION['username']) . ')</a>';
                } else {
                    echo '<a href="login.php">Đăng nhập</a>';
                }
                ?>
            </li>
        </ul>
    </nav>

    <h2>Giỏ hàng của bạn</h2>
    <div class="cart-items">
        <?php
        // Kết nối đến cơ sở dữ liệu
        $conn = new mysqli('localhost', 'root', '', 'webbanhang1');
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Kiểm tra nếu người dùng đã đăng nhập
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            // Lấy sản phẩm trong giỏ hàng
            $sql = "SELECT c.quantity, p.id, p.name, p.price, p.image 
                    FROM cart c 
                    JOIN products p ON c.product_id = p.id 
                    WHERE c.user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $total_price = 0; // Biến tổng giá
                while ($row = $result->fetch_assoc()) {
                    $total_price += $row['price'] * $row['quantity']; // Tính tổng giá
                    echo '<div class="cart-item">';
                    echo '<img class="cart-product-image" src="../img/products/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p class="cart-product-price">Giá: ' . number_format($row['price'], 0, ',', '.') . ' VNĐ</p>';
                    echo '<form action="update_cart.php" method="POST">';
                    echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($row['id']) . '">';
                    echo '<input type="number" name="quantity" value="' . htmlspecialchars($row['quantity']) . '" min="1">';
                    echo '<input type="submit" value="Cập nhật" class="btn btn-update">';
                    echo '</form>';
                    echo '<a href="remove_from_cart.php?product_id=' . htmlspecialchars($row['id']) . '" class="btn btn-remove">Xóa</a>'; // Liên kết để xóa sản phẩm
                    echo '</div>';
                }
                echo '<h3>Tổng tiền: ' . number_format($total_price, 0, ',', '.') . ' VNĐ</h3>'; // Hiển thị tổng tiền
            } else {
                echo "<p>Giỏ hàng của bạn trống.</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Bạn cần đăng nhập để xem giỏ hàng.</p>";
        }

        $conn->close();
        ?>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="checkout.php" class="btn btn-checkout">Tiến hành thanh toán</a> <!-- Nút thanh toán -->
    <?php endif; ?>

    <!-- Footer -->
    <footer>
        <p>Thông tin liên hệ</p>
    </footer>

</body>
</html>
