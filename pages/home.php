<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Đường dẫn CSS -->
</head>
<body>

    <!-- Thanh điều hướng -->
    <nav class="nav-bar">
        <ul class="nav-items">
            <li><a href="#">Điện tử</a></li>
            <li><a href="#">Thời trang</a></li>
            <li><a href="#">Mỹ phẩm</a></li>
            <li><a href="cart.php">Giỏ hàng</a></li> <!-- Liên kết đến giỏ hàng -->
            <li>
                <?php
                session_start(); // Bắt đầu phiên làm việc
                if (isset($_SESSION['username'])) {
                    echo '<a href="logout.php">Đăng xuất</a>';
                } else {
                    echo '<a href="login.php">Đăng nhập</a>';
                }
                ?>
            </li>
        </ul>
    </nav>

    <!-- Banner Khuyến mãi -->
    <section id="promotions">
        <h2>Khuyến mãi</h2>
        <div class="promotion-banner">
            <img src="../img/products/product1.jpg" alt="Khuyến mãi lớn" style="width:100%; max-height:200px; object-fit:cover;">
        </div>
        
        <h3>Sản phẩm khuyến mãi</h3>
        <div class="product-list">
            <?php
            // Kết nối đến cơ sở dữ liệu
            $conn = new mysqli('localhost', 'root', '', 'webbanhang1');
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            // Lấy 3 sản phẩm khuyến mãi
            $sql = "SELECT * FROM products LIMIT 3";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="product-item">';
                    echo '<img class="product-image" src="../img/products/' . $row['image'] . '" alt="' . $row['name'] . '">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p class="product-price">Giá: ' . number_format($row['price'], 2) . ' VNĐ</p>';
                    echo '<a href="add_to_cart.php?id=' . $row['id'] . '" class="btn btn-add">Thêm vào giỏ</a>'; // Cập nhật liên kết thêm vào giỏ
                    echo '</div>';
                }
            } else {
                echo "<p>Không có sản phẩm nào.</p>";
            }

            $conn->close();
            ?>
        </div>
    </section>

    <!-- Sản phẩm nổi bật -->
    <section id="featured-products">
        <h2>Sản phẩm nổi bật</h2>
        <div class="product-list">
            <?php
            // Kết nối lại cơ sở dữ liệu
            $conn = new mysqli('localhost', 'root', '', 'webbanhang1');
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            // Lấy tất cả các sản phẩm
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="product-item">';
                    // Đảm bảo đường dẫn đến ảnh đúng
                    echo '<img class="product-image" src="../img/products/' . $row['image'] . '" alt="' . $row['name'] . '">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p class="product-price">Giá: ' . number_format($row['price'], 2) . ' VNĐ</p>';
                    echo '<a href="add_to_cart.php?id=' . $row['id'] . '" class="btn btn-add">Thêm vào giỏ</a>'; // Cập nhật liên kết thêm vào giỏ
                    echo '</div>';
                }
            } else {
                echo "<p>Không có sản phẩm nào.</p>";
            }

            $conn->close();
            ?>
        </div>
    </section>

    <!-- Danh mục sản phẩm -->
    <section id="categories">
        <h2>Danh mục sản phẩm</h2>
        <div class="category-list">
            <div class="category-item">
                <h3>Điện tử</h3>
                <p><a href="#">Xem thêm</a></p>
            </div>
            <div class="category-item">
                <h3>Thời trang</h3>
                <p><a href="#">Xem thêm</a></p>
            </div>
            <div class="category-item">
                <h3>Mỹ phẩm</h3>
                <p><a href="#">Xem thêm</a></p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>Thông tin liên hệ</p>
    </footer>

</body>
</html>
