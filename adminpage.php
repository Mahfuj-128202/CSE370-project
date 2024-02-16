<?php
session_start();
require 'dbconnect.php';
if (!empty($_SESSION["id"])) {
	$id = $_SESSION['id'];
	$u = mysqli_query($conn, "select * from admin where admin_id='$id'");
	$row1 = mysqli_fetch_assoc($u);
	if (mysqli_num_rows($u)==0){
		$user = mysqli_query($conn, "select * from user where user_id='$id'");
		$row2=mysqli_fetch_assoc($user);
		if ($row['bank_acc']==0){
			header('Location: regular.php');
		}else{
			header('Location: premiun.php');
		}
	}
	
} else {
	header('Location: homepage.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin</title>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<style>
		.bal {
			display: flex;
			align-items: center;
			justify-content: center;
			height: 10vh;
			margin: 0;
			font-size: 48px;
		}
	</style>


</head>

<body>
	<div class="header">
		<ul class="header-links pull-right">
			<h3><?php echo "Welcome $row1[admin_id]"; ?></h3><br>
			<h3><a href="logout.php">Logout</a></h3>

		</ul>
	</div>
	<div class="bal">
		<p>Inventory Status</p>
	</div>


	<?php
	$product_result = mysqli_query($conn, "SELECT * FROM inventory ;");
	echo "<table>";
	echo "<thead><tr> <th><h2>Product</h2></th> <th><h2>Price<h2></th><th><h2>Quantity<h2></th></tr></thead>";
	
	while ($cart_row = mysqli_fetch_assoc($product_result)) {
		echo "<tr>";
		echo "<td><img src='" . $cart_row['image'] . "' alt=' '>" . $cart_row['name'] . "</td>";
		echo "<td>$cart_row[price]</td>";
		echo "<td>$cart_row[quantity] </td>";
		echo "</tr>";
	}
	echo "</table>";
	$sold_result = mysqli_query($conn, "SELECT * FROM sold ");
	$total_price = 0;
	while ($cart_row = mysqli_fetch_assoc($sold_result)) {
		$inventory = mysqli_query($conn, "SELECT * FROM inventory where product_id='" . $cart_row['product_id'] . "' ");
		$res = mysqli_fetch_assoc($inventory);
		$total_price = $total_price + ($cart_row['quantity'] * $res['price']);
	}

	?>
	<div class="bal">
		<p>Sell Status</p>
	</div>
	<?php
	$product_result = mysqli_query($conn, "SELECT * FROM sold ");
	echo "<table>";
	echo "<thead><tr> <th><h2>Product</h2></th> <th><h2>price<h2></th><th><h2>Quantity<h2></th></tr></thead>";
	while ($cart_row = mysqli_fetch_assoc($product_result)) {
		$product_id = $cart_row['product_id'];

		$inventory = mysqli_query($conn, "SELECT * FROM inventory where product_id='" . $cart_row['product_id'] . "' ");
		$res = mysqli_fetch_assoc($inventory);

		// Display the product name, image, quantity, price, and buttons to remove or update the quantity
		echo "<tr>";
		echo "<td><img src='" . $res['image'] . "' alt=' '>" . $res['name'] . "</td>";
		echo "<td>$res[price]</td>";
		echo "<td>$cart_row[quantity] </td>";
		echo "</tr>";
	}
	echo "</table>";
	?>

	<h3>Total sold</h3>
	<h2><?php echo $total_price; ?></h2><br>
	<h3>Total Profit</h3>
	<h2><?php echo $total_price * .2; ?></h2>


</body>

</html>