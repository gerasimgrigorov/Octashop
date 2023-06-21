<?php
session_start();

include 'server/connection.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Retrieve the file paths of the images associated with the product
    $sql = "SELECT product_image1, product_image2, product_image3 FROM products WHERE product_id = :product_id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Delete the images from the folder
    $folderPath = "images/products/";
    $imagePaths = [
      $row['product_image1'],
      $row['product_image2'],
      $row['product_image3']
    ];
    foreach ($imagePaths as $imagePath) {
      if (!empty($imagePath)) {
        $filePath = $folderPath . $imagePath;
        if (file_exists($filePath)) {
          unlink($filePath);
        }
      }
    }
    
    // Delete the product from the database
    $sql = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();

    // Update the image paths to empty strings
    $sql = "UPDATE products SET product_image1 = '', product_image2 = '', product_image3 = '' WHERE product_id = :product_id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
  }

header('location: admin-panel.php');
?>


