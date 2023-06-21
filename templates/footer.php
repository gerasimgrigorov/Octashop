<footer>
  <section class="whole-footer">
    <div class="footer">
      <div class="col">
        <h4>Contact</h4>
        <h6><strong>Adrees: </strong>Panayot Hitov 33, Popovo Bulgaria</h6>
        <h6><strong>Phone: </strong>0897 399 131, (+359) 897 399 131</h6>
      </div>

      <div class="col">
        <h4>About</h4>
        <a href="#">Terms & Conditions</a>
        <a href="contact.php">Contact Us</a>
      </div>

      <div class="col">
        <h4>My account</h4>
          <?php
          if(isset($_SESSION['user'])) {
            
          ?>
            <a href="#">Your Profile</a>
            <a href="logout.php">Log Out</a>
          <?php
          } else {
          ?>
            <a href="login.php">Log In</a>
            <a href="register.php">Sign In</a>
          <?php
          }
          ?>
            <a href="cart.php">View Cart</a>
      </div>  
    </div>

    <div class="footer-spacing"></div>

    <div class="copyright">
      <p>&copy; 2023 All rights reserved</p>
    </div>
    
  </section>
</footer>