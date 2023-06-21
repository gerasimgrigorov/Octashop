<?php
session_start();

include 'server/connection.php';

if ( !$_SESSION['user'] ) {
	// ако няма логнат потребител се прави пренасочване към login.php
	header("location: login.php");
	exit;
}

include 'templates/navbar.php';
?>

    <section id="product1" class="section-p1">
      <br>
      <h2 class="featured-list">All products</h2>
      <div class="pro-container">

<?php  
  $result = $connection->query("SELECT * FROM products ORDER BY product_id");

  if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
?>
      <div class="pro" onclick="window.location.href='product-page.php?id=<?php echo $row['product_id']?>'">
        <img src="images/products/<?php echo $row['product_image1'];?>" alt=""> 
        <div class="des">
          <span><?php echo $row['product_brand']; ?></span>
          <h5><?php echo $row['product_model']; ?></h5>
          <!-- <a href="product-page.php?id=<?php echo $row['product_id']?>">open</a> -->
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h4>$<?php echo $row['product_price']; ?></h4>
        </div>
      </div>
      <?php }
      } 
      ?>
      
    </section>
      
    <div class="spacing-above-footer"></div>
    <?php include 'templates/footer.php'?>
    
  </body>
</html>