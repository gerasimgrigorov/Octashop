<?php
session_start();

if (!$_SESSION['user']) {
    // ако няма логнат потребител се прави пренасочване към login.php
    header("location: login.php");
    exit;
}

// Check if the user came from the product page and add the product to the cart
if (isset($_POST['add-to-cart'])) {
    $product_id = $_POST['product_id'];
    $product_image = $_POST['product_image'];
    $product_brand = $_POST['product_brand'];
    $product_model = $_POST['product_model'];
    $product_size = $_POST['product_size'];
    $product_price = $_POST['product_price'];

    $product_array = array(
        'product_id' => $product_id,
        'product_image' => $product_image,
        'product_brand' => $product_brand,
        'product_model' => $product_model,
        'product_size' => $product_size,
        'product_price' => $product_price
    );

    // Check if the product is already added to the cart
    if (isset($_SESSION['cart'])) {
        $product_index = false;
        foreach ($_SESSION['cart'] as $index => $cart_product) {
            if ($cart_product['product_id'] == $product_id && $cart_product['product_size'] == $product_size) {
                $product_index = $index;
                break;
            }
        }
        if ($product_index !== false) {
            $_SESSION['cart'][$product_index]['product_quantity'] += 1; // Increase the quantity by 1
            $_SESSION['cart'][$product_index]['product_id'] = $product_id;
            $_SESSION['cart'][$product_index]['product_image'] = $product_image;
            $_SESSION['cart'][$product_index]['product_brand'] = $product_brand;
            $_SESSION['cart'][$product_index]['product_model'] = $product_model;
            $_SESSION['cart'][$product_index]['product_size'] = $product_size;
            $_SESSION['cart'][$product_index]['product_price'] = $product_price;
        } else {
            $product_array['product_id'] = $product_id;
            $product_array['product_image'] = $product_image;
            $product_array['product_brand'] = $product_brand;
            $product_array['product_model'] = $product_model;
            $product_array['product_size'] = $product_size;
            $product_array['product_price'] = $product_price;
            $product_array['product_quantity'] = 1;
            $_SESSION['cart'][] = $product_array; // Append the product to the cart
        }
        
    } else {
        $product_array['product_id'] = $product_id;
        $product_array['product_image'] = $product_image;
        $product_array['product_brand'] = $product_brand;
        $product_array['product_model'] = $product_model;
        $product_array['product_size'] = $product_size;
        $product_array['product_price'] = $product_price;
        $product_array['product_quantity'] = 1;
        $_SESSION['cart'][] = $product_array; // Append the product to the cart
    }
}

// Remove item from the cart
if (isset($_POST['remove-from-cart'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $index => $product) {
            if ($product['product_id'] == $product_id) {
                unset($_SESSION['cart'][$index]);
                break;
            }
        }
    }
}

$total_price = 0;

include 'templates/navbar.php';
?>

    <section id="cart" class="section-m1 content-section">
      <h2 class="section-header featured-list">CART</h2>
      <div class="responsive-slide">
        <div class="cart-row">
          <span class="cart-item cart-header cart-column table-item">ITEM</span>
          <span class="cart-price cart-header cart-column table-price">PRICE</span>
          <span class="cart-quantity cart-header cart-column table-quantity">QUANTITY</span>
          <span class="cart-total-column cart-total-one cart-header cart-column table-total">TOTAL</span>
        </div>

        <div class="cart-items">
          <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
              
              $_SESSION['item-total'] = array();
              
              foreach ($_SESSION['cart'] as $product) {
                $product_id = $product['product_id'];
                $product_image = $product['product_image'];
                $brand = $product['product_brand'];
                $product_model = $product['product_model'];
                $product_price = $product['product_price'];
                $product_quantity = isset($_POST['quantity-' . $product_id]) ? $_POST['quantity-' . $product_id] : $product['product_quantity'];
                $product_size = $product['product_size'];

                $item_total = $product_price * $product_quantity;
                $_SESSION['item-total'][$product_id] = $item_total; // Set the item total in the session with the product_id as the key
                $total_price += $item_total;
                $product_link = "product-page.php?id=$product_id";
          ?>

          <div class="cart-row">
            <div class="cart-item cart-column" >
              <img class="cart-item-image" src="images/products/<?php echo $product_image; ?>" width="100" height="100">
              <span class="cart-item-title"><?php echo $brand . ' ' . $product_model . ' <u>' . $product_size . '</u>'; ?></span>
            </div>

            <span class="cart-price cart-column">$<?php echo $product_price; ?></span>

            <div class="cart-quantity cart-column">
              <form class="update-form" method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <input class="cart-quantity-input" type="number" name="quantity-<?php echo $product_id; ?>" value="<?php echo $product_quantity; ?>" min="1" >
              </form>

              <form method="POST" action="cart.php">
                  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                  <button class="btn btn-danger" type="submit" name="remove-from-cart">REMOVE</button>
              </form>
            </div>

            <span class="cart-total-one cart-column">$<?php echo $item_total; ?>.00</span>

          </div>
          <?php
              }
            } else {
                echo '<p>Your cart is empty.</p>';
            }
          ?>
        </div>
      </div>

      <?php if($total_price != 0) {
        $_SESSION['order-price'] = $total_price + 4.99;
      ?>

      <div class="cart-total">
        <div>
          <strong class="cart-total-title">Products:</strong><span class="cart-total-price">$<?php echo $total_price; ?></span><br>
          <strong class="cart-total-title">Shipping:</strong><span class="cart-total-price">$4.99</span><br>
          <strong class="cart-total-title">Total:</strong><span class="cart-total-price">$<?php echo $_SESSION['order-price']; ?></span><br>
        </div>
      </div>
      
      <form method="POST" action="checkout.php">
        <div class="button-final">
          <input type="hidden" name="product_id" value="<?php echo $_SESSION['order-price']; ?>">
          <button class="btn btn-primary btn-purchase" type="submit" name="order-now">ORDER NOW</button>
        </div>
      </form>

      <?php } else { ?>
        <br><br>
        <div class="spacing-above-footer"></div>
      <?php } ?>
        
    </section>

    <div class="spacing-above-footer"></div>
    <?php include 'templates/footer.php'; ?>

  </body>
</html>
