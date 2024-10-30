<?php
include '../includes/db.php';
$products = getAllProducts();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        /* Thêm một số CSS để hiển thị sản phẩm gọn gàng */
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .product-item {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            width: 200px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .product-item img {
            max-width: 100%;
            height: auto;
            object-fit: cover;
        }

        .product-item h3 {
            font-size: 18px;
            margin: 10px 0;
        }

        .product-item p {
            color: #f00;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Sản phẩm</h2>
<div class="product-list">
    <?php foreach ($products as $product): ?>
        <div class="product-item">
            <img src="../img/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <h3><?php echo $product['name']; ?></h3>
            <p><?php echo number_format($product['price'], 2); ?> VND</p>
            <a href="product_details.php?id=<?php echo $product['id']; ?>" class="btn">Xem chi tiết</a>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
