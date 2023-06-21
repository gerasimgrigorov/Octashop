<?php 
session_start();

include 'server/connection.php';

date_default_timezone_set('Europe/Sofia');

if ( isset( $_POST['submit'] ) ) {
	// записване на данните от полетата в променливи за по-удобно
  $order_cost = $_SESSION['order-price'];
  $order_status = "on_hold";
	$name = $_POST['fullname'];
	$email = $_POST['email'];
	$phone_number = $_POST['phone-number'];
  $city = $_POST['city'];
  $zip = $_POST['zip'];
  $address = $_POST['address'];
  $order_date = date('Y-m-d H:i:s');

	// INSERT заявка към базата, с която се записват полетата
	$sql = "INSERT INTO orders(order_cost, order_status, user_id, name, email, phone_number, city, zip, address, order_date) VALUES (?,?,?,?,?,?,?,?,?,?)";
	$result = $connection->prepare($sql)->execute([$order_cost, $order_status, $_SESSION['user']['id'], $name, $email, $phone_number, $city, $zip, $address, $order_date]);

  if ( $result ) {
    $order_id = $connection->lastInsertId();
    header("location: order-confirmation.php?order_id=".$order_id);
  }
}

include 'templates/navbar.php';
?>

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body {
      font-size: 17px;
    }

    * {
      box-sizing: border-box;
    }

    .row {
      display: -ms-flexbox; /* IE10 */
      display: flex;
      -ms-flex-wrap: wrap; /* IE10 */
      flex-wrap: wrap;
      margin: 0 -16px;
    }

    .col-25 {
      -ms-flex: 25%; /* IE10 */
      flex: 25%;
    }

    .col-50 {
      -ms-flex: 50%; /* IE10 */
      flex: 50%;
    }

    .col-75 {
      -ms-flex: 75%; /* IE10 */
      flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
      padding: 0 16px;
    }

    .container {
      background-color: #f2f2f2;
      padding: 15px 20px 15px 20px;
      border: 1px solid lightgrey;
      border-radius: 3px;
      margin-top: 4%;
    }

    input[type=text] {
      width: 100%;
      margin-bottom: 20px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    label {
      margin-bottom: 10px;
      display: block;
    }

    .icon-container {
      margin-bottom: 20px;
      padding: 7px 0;
      font-size: 24px;
    }

    .btn {
      background-color: #3a89ff;
      color: white;
      padding: 12px;
      margin: 10px 0;
      border: none;
      width: 100%;
      border-radius: 3px;
      cursor: pointer;
      font-size: 17px;
    }

    .btn:hover {
      background-color: #0d6efd;
      color: white;
    }

    a {
      color: #2196F3;
    }

    hr {
      border: 1px solid lightgrey;
    }

    span.price {
      float: right;
      color: grey;
    }

    @media (max-width: 800px) {
      .row {
        flex-direction: column-reverse;
      }
      .col-25 {
        margin-bottom: 20px;
      }
    }
  </style>
</head>

    <div class="container">
      <form method="POST" action="">
        <div class="row">
          <div class="col-50">
            <h3>Billing Address</h3>
            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
            <input type="text" name="fullname" placeholder="Peter Ivanov">
            <label for="email"><i class="fa fa-envelope"></i> Email</label>
            <input type="text" name="email" placeholder="peter@example.com">
            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
            <input type="text" id="adr" name="address" placeholder="14 Petur Beron Str.">
            <label for="city"><i class="fa fa-institution"></i> City</label>
            <input type="text" id="city" name="city" placeholder="Popovo">
            
            <div class="row">
              <div class="col-50">
                <label for="state">Phone Number</label>
                <input type="text" id="phone" name="phone-number" placeholder="0845698903">
              </div>
              <div class="col-50">
                <label for="zip">Zip</label>
                <input type="text" id="zip" name="zip" placeholder="7800">
              </div>
            </div>
          </div>

          <div class="col-50">
            <h3>Payment</h3>
            <label for="fname">Accepted Cards</label>
            <div class="icon-container">
              <i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
            </div>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="Peter Ivanov">
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
            <label for="expmonth">Exp Month</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="September">
            <div class="row">
              <div class="col-50">
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" placeholder="2025">
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="352">
              </div>
            </div>
          </div>
          
        </div>
        <div class="cart-total">
            <strong class="cart-total-title">Total: $<?php echo $_SESSION['order-price']; ?></strong></span>
        </div>
        <button class="btn" name="submit">Checkout</button>
      </form>
    </div>

  <div class="spacing-above-footer"></div>

  </body>
</html>