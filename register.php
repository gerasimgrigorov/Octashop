<?php
include 'server/connection.php';

if ( isset( $_POST['submit'] ) ) {

	// записване на данните от полетата в променливи за по-удобно
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = hash("sha256",$_POST['password']);
   $cpassword = hash("sha256",$_POST['cpassword']);
   
   $error = false;

   if ( $password != $cpassword ) {
      echo "Passwords doesn't match! Try again...";
      $error = true;
   }

   if ( !$error ) {
      // INSERT заявка към базата, с която се записват полетата
      $sql = "INSERT INTO register(username, email, password, cpassword) VALUES (?,?,?,?)";
      $connection->prepare($sql)->execute([$username, $email, $password, $cpassword]);

      header('location: login.php');
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/register-login.css">
   <title>Octashop</title>
</head>
  <body>
    <div class="form-container">

      <form action="" method="post">
          <h3>Register now</h3>
          <input type="text" name="username" required placeholder="enter username" class="box">
          <input type="email" name="email" required placeholder="enter email" class="box">
          <input type="password" name="password" required placeholder="enter password" class="box">
          <input type="password" name="cpassword" required placeholder="confirm password" class="box">
          <input type="submit" name="submit" class="btn" value="register now">
          <p>already have an account? <a href="login.php">login now</a></p>
      </form>

    </div>

  </body>
</html>