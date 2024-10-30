<?php
include '../includes/db.php';
$product_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h2><?php echo $product['name']; ?></h2>
<img src="../img/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
<p><?php echo $product['description']; ?></p>
<p>Giá: <?php echo $product['price']; ?> VND</p>

<form method="post" action="cart.php">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    Số lượng: <input type="number" name="quantity" value="1" min="1">
    <button type="submit">Thêm vào giỏ hàng</button>
</form>
