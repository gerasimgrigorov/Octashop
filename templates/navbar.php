<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/609ca21d4b.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
  <link rel="stylesheet" href="css/navbar.css">
  <title>Octashop</title>
</head>

  <body>
    <header>
      <nav>
        <ul class='nav-bar'>
          <li><div class="logo-box"><a href="index.php"><img src="images/logo.png" class="logo"></a></div></li>
          <input type='checkbox' id='check' />
          <span class="menu">
            <?php if(!isset($_SESSION['user'])) { ?>
              <li><a href="index.php">Home</a></li>
              <li><a href="shop.php">Shop</a></li>
              <li><a href="contact.php">Contact</a></li>
            <?php } elseif($_SESSION['user']['acc_type'] == 'admin') { ?>
              <li><a href="index.php">Home</a></li>
              <li><a href="shop.php">Shop</a></li>
              <li><a href="contact.php">Contact</a></li>
              <li><a href="admin-panel.php">Admin Panel</a></li>
            <?php } else { ?>
              <li><a href="index.php">Home</a></li>
              <li><a href="shop.php">Shop</a></li>
              <li><a href="contact.php">Contact</a></li>
            <?php } ?>
            <li style="padding-right: 15px;"><a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
            <label for="check" class="close-menu"><i class="fas fa-times"></i></label>
          </span>
          <label for="check" class="open-menu"><i class="fas fa-bars"></i></label>
        </ul>
      </nav>
    </header>



    <script>
      // const hamburgerMenu = document.querySelector('.hamburger-menu');
      // const menuItems = document.querySelector('.menu-items');

      // hamburgerMenu.addEventListener('click', function() {
      //   menuItems.classList.toggle('active');
      // });

    </script>
