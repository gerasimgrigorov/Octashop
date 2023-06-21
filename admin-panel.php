<?php
session_start();

include 'server/connection.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['acc_type'] == 'customer') {
	header("location: index.php");
	exit;
}

if (isset($_SESSION['success_message'])) {
	echo "<center style='color:green;'>" . $_SESSION['success_message'] . "</center>";
	unset($_SESSION['success_message']);
}

if (isset($_POST['submit'])) {

	// записване на данните от полетата в променливи за по-удобно
	$brand = $_POST['brand'];
	$model = $_POST['model'];
	$price = $_POST['price'];
	$type = isset($_POST['type']) ? $_POST['type'] : '';

	$folderMap = [
		'hoodie' => 'hoodies',
		'tshirt' => 'tshirts',
		'shoes' => 'kicks',
		'tracks' => 'tracks',
	];
	
	$file_name1 = '';
	$file_name2 = '';
	$file_name3 = '';
	
	$file_path1 = '';
	$file_path2 = '';
	$file_path3 = '';
	
	$error = false;

	// изписване на грешка ако не е попълнено
	if (empty($type)) {
		echo "<center style='color:red;'>Изберете тип</center>";
		$error = true;
	} else{
		// проверка за качване на снимки
		if (!empty($_FILES['image1']['name'])) {
			$file1 = $_FILES['image1'];
			$file_name1 = $_FILES['image1']['name'];
			$file_temp1 = $_FILES['image1']['tmp_name'];
			$file_type1 = $_FILES['image1']['type'];
		
			// Check the file type
			if ($file_type1 != "image/jpeg" && $file_type1 != "image/png") {
				echo "<center style='color:red;'>Upload a JPEG or PNG image for Image 1</center>";
				$error = true;
			} else {
				$file_path1 = "{$folderMap[$type]}/" . $file_name1;
			}
		}
		
		if (!empty($_FILES['image2']['name'])) {
			$file2 = $_FILES['image2'];
			$file_name2 = $_FILES['image2']['name'];
			$file_temp2 = $_FILES['image2']['tmp_name'];
			$file_type2 = $_FILES['image2']['type'];
		
			// Check the file type
			if ($file_type2 != "image/jpeg" && $file_type2 != "image/png") {
				echo "<center style='color:red;'>Upload a JPEG or PNG image for Image 2</center>";
				$error = true;
			} else {
				$file_path2 = "{$folderMap[$type]}/" . $file_name2;
			}
		}
		
		if (!empty($_FILES['image3']['name'])) {
			$file3 = $_FILES['image3'];
			$file_name3 = $_FILES['image3']['name'];
			$file_temp3 = $_FILES['image3']['tmp_name'];
			$file_type3 = $_FILES['image3']['type'];
		
			// Check the file type
			if ($file_type3 != "image/jpeg" && $file_type3 != "image/png") {
				echo "<center style='color:red;'>Upload a JPEG or PNG image for Image 3</center>";
				$error = true;
			} else {
				$file_path3 = "{$folderMap[$type]}/" . $file_name3;
			}
		}
	}
	// Move the uploaded files to the target directory if no errors
	if (!$error) {
		if (!empty($_FILES['image1']['name'])) {
			move_uploaded_file($file_temp1, "images/products/{$file_path1}");
		}
	
		if (!empty($_FILES['image2']['name'])) {
			move_uploaded_file($file_temp2, "images/products/{$file_path2}");
		}
	
		if (!empty($_FILES['image3']['name'])) {
			move_uploaded_file($file_temp3, "images/products/{$file_path3}");
		}
	}

	// Proceed with inserting the product only if no error occurred
	if (!$error) {
		// INSERT query to add the product
		$sql = "INSERT INTO products (product_brand, product_model, product_price, product_image1, product_image2, product_image3, type) VALUES (?,?,?,?,?,?,?)";
		$result = $connection->prepare($sql)->execute([$brand, $model, $price, $file_path1, $file_path2, $file_path3, $type]);

		if ($result) {
			$_SESSION['success_message'] = "Product added successfully";
			header("Location: admin-panel.php");
        	exit;
		}
	}

	// htmlspecialchars служи да предотвратяване на грешки при въведени "специални" символи в базата.
	// Просто запомнете, че вашите полета трябва да бъдат така направени преди да се отпечатат в сайта, за да няма проблеми с данните
	$brand = htmlspecialchars($brand, ENT_QUOTES);
	$model = htmlspecialchars($model, ENT_QUOTES);
	$price = htmlspecialchars($price, ENT_QUOTES);
	$type = htmlspecialchars($type, ENT_QUOTES);
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
	<link href="../../fontawesome/css/fontawesome.css" rel="stylesheet">
	<link href="../../fontawesome/css/brands.css" rel="stylesheet">
	<link href="../../fontawesome/css/solid.css" rel="stylesheet">

	<title>Admin Panel</title>
	
	<style>
		.prod-table{
			text-align: center;
			font-size: 20px;
		}
		.table-header{
			padding: 0px 50px;
		}
		.rmv-btn{
		color: white;
		font-size: 16px;
		padding: 6px 10px;
		background-color: #EB5757;
		border: none;
		border-radius: .3em;
		font-weight: 400;
		}
		.container-products{
			margin-top: 4%;
			display: flex;
			justify-content: center;
			align-items: center;
			overflow-x: auto;
		}

		.redirection-container{
			margin-top: 2%;
			margin-bottom: 3%;
			text-align: center;
		}
		.redirection-bttn{
			padding: 8px 28px;
			color: white;
			background-color: rgb(49, 106, 212);
			border:none;
			border-radius: 5px;
			font-size: 20px;
			font-weight: 600;
			transition: 0.4s ease;
		}
		.redirection-bttn:hover{
			background-color: rgb(29, 92, 210);
		}
	</style>
</head>

  <body>
    <div class="container">
      <div class="row">
        <div class="col-3"></div>
        <div class="col-md-6 col-12">

          <form method="post" enctype="multipart/form-data">
            <br>
            <label class="form-label">Brand:</label>
            <input type="text" name="brand" class="form-control" value="" required>
            <br>

            <br>
            <label class="form-label">Model:</label>
            <input type="text" name="model" class="form-control" value="" required>
            <br>

            <br>
            <label class="form-label">Price:</label>
            <input type="text" name="price" class="form-control" value="" required>
            <br>

            <br>
            <div>
              <label class="form-label">Type: </label>
              <select name="type" id="type">
                <option value="*" selected disabled> - </option>
                <option value="hoodie">Hoodie</option>
                <option value="tshirt">T-shirt</option>
                <option value="tracks">Pants</option>
                <option value="shoes">Shoes</option>
              </select>
            </div>
            
            <br>
            <label class="form-label">Image 1:</label>
            <input type="file" name="image1" class="form-control" required>
            <br>

            <br>
            <label class="form-label">Image 2:</label>
            <input type="file" name="image2" class="form-control">
            <br>

            <br>
            <label class="form-label">Image 3:</label>
            <input type="file" name="image3" class="form-control">
            <br>

            <button name="submit" class="btn btn-primary w-100" type="submit" value="submit">Submit</button>
          </form>

        </div>
      </div>
    </div>



    <div class="container-products">
      <?php
        $sql = "SELECT * FROM products";
        $result = $connection->query($sql);
        
        if ($result->rowCount() > 0) {
          echo '<table class="prod-table">';
          echo '<thead>';
          echo '<tr>';
          echo '<th class="table-header">Product ID</th>';
          echo '<th class="table-header">Brand</th>';
          echo '<th class="table-header">Model</th>';
          echo '<th class="table-header">Price</th>';
          echo '<th class="table-header">Image</th>';
          echo '<th class="table-header"></th>';
          echo '</tr>';
          echo '</thead>';
          echo '<tbody>';

          // Iterate over the retrieved data and populate the table
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . $row['product_id'] . '</td>';
            echo '<td>' . $row['product_brand'] . '</td>';
            echo '<td>' . $row['product_model'] . '</td>';
            echo '<td>$' . $row['product_price'] . '</td>';
            echo '<td> <img class="cart-item-image" src="images/products/' . $row['product_image1']. '" width="100" height="100"> </td>';

            echo '<td>';
              echo '<form method="POST" action="admin-delete-product.php">';
              echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
              echo '<button type="submit" class="remove-product rmv-btn">Remove</button>';
              echo '</form>';
              echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
      } else {
        echo 'No products found.';
      }
      ?>
      
    </div>

    <div class="redirection-container">
      <a href="index.php"><button class="redirection-bttn">To Home Page</button></a>
    </div>

  </body>
</html>
