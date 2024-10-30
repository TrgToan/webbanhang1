<?php
// Kết nối đến cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'webbanhang1');
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý tải file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['product_image'])) {
    $target_dir = "../img/products/";  // Thư mục nơi bạn muốn lưu file
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);  // Đường dẫn file đích
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra xem có phải là ảnh hay không
    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File không phải là hình ảnh.";
        $uploadOk = 0;
    }

    // Kiểm tra xem file đã tồn tại hay chưa
    if (file_exists($target_file)) {
        echo "Xin lỗi, file đã tồn tại.";
        $uploadOk = 0;
    }

    // Chỉ cho phép định dạng file nhất định
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Xin lỗi, chỉ cho phép định dạng JPG, JPEG, PNG & GIF.";
        $uploadOk = 0;
    }

    // Kiểm tra nếu $uploadOk = 0 thì không tải lên file
    if ($uploadOk == 0) {
        echo "Xin lỗi, file của bạn không được tải lên.";
    } else {
        // Nếu mọi thứ ổn, hãy tải file lên
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            echo "File " . htmlspecialchars(basename($_FILES["product_image"]["name"])) . " đã được tải lên.";

            // Lưu tên file vào cơ sở dữ liệu
            $file_name = basename($_FILES["product_image"]["name"]);  // Lấy tên file
            // Thay đổi câu lệnh SQL phù hợp với bảng của bạn
            $sql = "INSERT INTO products (name, price, image) VALUES ('Tên sản phẩm', 100000, '$file_name')";
            
            // Thực thi câu lệnh SQL
            if ($conn->query($sql) === TRUE) {
                echo "Tên file " . htmlspecialchars($file_name) . " đã được lưu vào cơ sở dữ liệu.";
            } else {
                echo "Lỗi: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Xin lỗi, đã có lỗi xảy ra khi tải lên file của bạn.";
        }
    }
}

$conn->close();
?>
