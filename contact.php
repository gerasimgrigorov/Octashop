<?php
session_start();

if ( !$_SESSION['user'] ) {
	// ако няма логнат потребител се прави пренасочване към login.php
	header("location: login.php");
	exit;
}

include 'server/connection.php';

if ( isset( $_POST['submit'] ) ) {
	// записване на данните от полетата в променливи за по-удобно
	$name = $_POST['name'];
	$email = $_POST['email'];
	$subject = $_POST['subject'];
  $message = $_POST['message'];

	// INSERT заявка към базата, с която се записват полетата
	$sql = "INSERT INTO feedback(user_id, name, email, subject, message) VALUES (?,?,?,?,?)";
	$connection->prepare($sql)->execute([$_SESSION['user']['id'], $name, $email, $subject, $message]);
}

include 'templates/navbar.php';
?>

    <section id="form-details">
      <form action="" method="post">
        <h2 class="featured-list">Share your feedback</h2>
        <input type="text" placeholder="Your Name" name="name">
        <input type="text" placeholder="E-mail" name="email">
        <input type="text" placeholder="Subject" name="subject">
        <textarea name="message" id="" cols="30" rows="10" placeholder="Your message"></textarea>
        <button class="normal" name="submit">Submit</button>
      </form>
    </section>
    <div class="spacing-above-footer"></div>
    
    <?php include 'templates/footer.php'?>
 
  </body>
</html>