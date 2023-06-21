<?php

session_start();

include 'server/connection.php';

include 'templates/navbar.php';
?>

    <section id="hero">
      <h4>Trade-in-offer</h4>
      <h2>Super value deals</h2>
      <h1>On all products</h1>
      <p>Save up to 70% off!</p>
    </section>

    <section id="product1" class="section-p1">
      <br>
      <h2 class="featured-list">Featured products</h2>
      <div class="pro-container">

      <?php  
        $result = $connection->query("SELECT * FROM products ORDER BY RAND() LIMIT 8");

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