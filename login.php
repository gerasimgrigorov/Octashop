<?php 
session_start();

include 'server/connection.php';

if ( isset( $_POST['submit'] ) ) {

	// записване на данните от полетата в променливи за по-удобно
	$username = $_POST['username'];
	$password = hash("sha256", $_POST['password']);
	
	// зареждане от базата на потребител с въведените от формата име и парола
	$stmt = $connection->prepare("SELECT * FROM site_schema.register WHERE username = ? AND password = ?"); 
	$stmt->execute([ $username, $password ]); 
	$user = $stmt->fetch();
	
	if ( $user ) {
		// ако са въведени правилни име и парола се задава масива user в сесията
		$_SESSION['user'] = $user;
		
		header("location: index.php");
		exit;
	} else {
		echo "<b>Невалидни потребителски данни!</b><br><br>";
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
          <h3>login now</h3>
          <input type="text" name="username" required placeholder="enter username" class="box">
          <input type="password" name="password" required placeholder="enter password" class="box">
          <input type="submit" name="submit" class="btn" value="login now">
          <p>don't have an account? <a href="register.php">register now</a></p>
        </form>
    </div>
  </body>
</html>