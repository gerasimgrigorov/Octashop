<?php 
session_start();

include 'server/connection.php';

$id = $_GET['order_id'];

$stmt = $connection->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$id]); 
$order = $stmt->fetch();

// записване на данните от полетата в променливи за по-удобно
foreach ($_SESSION['cart'] as $product) {
  $product_id = $product['product_id'];
  $brand = $product['product_brand'];
  $product_model = $product['product_model'];
  $product_size = $product['product_size'];
  $product_quantity = isset($_POST['quantity-' . $product_id]) ? $_POST['quantity-' . $product_id] : $product['product_quantity'];
  $total_price = $_SESSION['item-total'][$product_id];
  
  $sql = "INSERT INTO order_items(order_id, product_id, product_brand, product_model, product_size, product_quantity, total_price) VALUES (?,?,?,?,?,?,?)";
	$result = $connection->prepare($sql)->execute([$id, $product_id, $brand, $product_model, $product_size, $product_quantity, $total_price]);
}

unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/confirmation-style.css">
<title>Octashop</title>
</head>

  <body>
    <div class="confirmation-container">
      <img src="images/confirmation-check.png" id="confirmation-gif" alt="Order Confirmation GIF" loop="false"/>
      <h2>THANK YOU!</h2>
      <div class="success-lrg">
        <p>
          Hey, <?php echo $order['name']; ?>! We are excited to inform you that your order has been successfully placed and is being processed. We appreciate your trust in our services and hope you enjoy your purchase. If you have any questions or need further assistance, contact our customer support team.
        </p>
      </div>
        <hr class="divider">
      <div class="checkout-success">
        <p class="p-mssg">Your order id is: <span>#<?php echo $order['id']; ?></span></p>
        <div class="actions-toolbar">
          <div class="primary">
            <a class="btn-shop action" href="index.php">Continue Shopping</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>