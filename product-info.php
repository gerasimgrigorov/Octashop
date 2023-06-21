<?php 
include 'server/connection.php';

$prodID = $_GET["id"];

$sql = "SELECT * FROM products WHERE product_id = ".$prodID.";";

$result = $connection->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$brand = $row['product_brand'];
$model = $row['product_model'];
$price = $row['product_price'];
$image1 = $row['product_image1'];
$image2 = $row['product_image2'];
$image3 = $row['product_image3'];
$type = $row['type'];
?>