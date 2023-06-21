<?php
session_start();

if (!$_SESSION['user']) {
    // ако няма логнат потребител се прави пренасочване към login.php
    header("Location: login.php");
    exit();
}

require 'product-info.php';

include 'templates/navbar.php';
?>

    <section id="prodetails" class="section-p1">
      <div class="single-pro-image">
        <img class="js-cart-image" src="images/products/<?php echo $image1 ?>" width="100%" id="MainImg" alt="">
          <div class="small-img-group">
            <div class="small-img-col">
              <img src="images/products/<?php echo $image1 ?>" width="100%" class="smallimg" alt="">
            </div>
            <?php if (!empty($image2)) { ?>
              <div class="small-img-col">
                <img src="images/products/<?php echo $image2 ?>" width="100%" class="smallimg" alt="">
              </div>
            <?php } ?>
            <?php if (!empty($image3)) { ?>
              <div class="small-img-col">
                <img src="images/products/<?php echo $image3 ?>" width="100%" class="smallimg" alt="">
              </div>
            <?php } ?>
          </div>
      </div>
      <div class="single-pro-details">
        <h4 class="js-brand"><?php echo $brand ?></h4>
        <h5 class="js-model"><?php echo $model ?></h5>
        <h2 class="js-price price">$<?php echo $price ?></h2>

        <?php if($type == 'shoes'){ ?>
          <span class="select-size other">
          <select class="prod-size" onchange="updateSelectedSize()">
            <option value="*" selected disabled> - </option>
            <option value="40">40</option>
            <option value="41">41</option>
            <option value="42">42</option>
            <option value="43">43</option>
            <option value="44">44</option>
            <option value="45">45</option>
            <option value="46">46</option>
          </select>
          </span>
        <?php }else { ?>
          <span class="select-size other">
          <select class="prod-size" onchange="updateSelectedSize()">
            <option value="*" selected disabled> - </option>
            <option value="XS">XS</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
          </select>
          </span>
        <?php } ?>
        
        
        <form method="POST" action="cart.php" onsubmit="return validateSize()">
          <input type="hidden" name="product_id" value="<?php echo $_GET['id']; ?>"/>
          <input type="hidden" name="product_image" value="<?php echo $image1 ?>"/>
          <input type="hidden" name="product_brand" value="<?php echo $brand ?>"/>
          <input type="hidden" name="product_model" value="<?php echo $model ?>"/>
          <input type="hidden" name="product_size" value="" id="selected-size"/>
          <input type="hidden" name="product_price" value="<?php echo $price ?>"/>
          <button class="normal js-add-to-cart" type="submit" name="add-to-cart">Add To Cart</button>
        </form>
        <br>
        <div class="shipping-mssg">*С всяка поръчка получавате право на преглед и тест преди плащане.*</div>
      </div>
    </section>
    <br>

    <div class="spacing-above-footer"></div>

    <?php include 'templates/footer.php'?>

    <script>
      var MainImg = document.getElementById("MainImg");
      var smallimg = document.getElementsByClassName("smallimg");

      smallimg[0].onclick = function () {
          MainImg.src = smallimg[0].src;
      }

      <?php if (!empty($image2)) { ?>
          smallimg[1].onclick = function () {
              MainImg.src = smallimg[1].src;
          }
      <?php } ?>

      <?php if (!empty($image2)) { ?>
          smallimg[2].onclick = function () {
              MainImg.src = smallimg[2].src;
          }
      <?php } ?>

      function updateSelectedSize() {
          var selectedSize = document.getElementById("selected-size");
          var sizeSelect = document.querySelector(".prod-size");
          selectedSize.value = sizeSelect.value;
      }

      function validateSize() {
      var sizeSelect = document.querySelector(".prod-size");
      if (sizeSelect.value === "*") {
          alert("Please select a size.");
          return false; // Prevent form submission
      }
      return true;
      }
    </script>

  </body>
</html>
