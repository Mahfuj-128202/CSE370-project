<?php
session_start();
require 'dbconnect.php';
if (!empty($_SESSION["id"])) {
	$id = $_SESSION['id'];
	$u = mysqli_query($conn, "select * from user where user_id='$id'");
	$row1 = mysqli_fetch_assoc($u);
	if ($row1['bank_acc']==0){
		header('Location: regular.php');
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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="custom-script.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<title>Electro</title>
</head>

<body>

	<div class='top_header'>
		<div class="container">
			<ul class="header-links pull-left">
				<li><i class="fa fa-phone"></i> add phone hear</li><br>
				<li><i class="fa fa-envelope-o"></i> add email here</li><br>
				<li><i class="fa fa-map-marker"></i> add location here</li><br>


			</ul>
			<ul class="header-links pull-right">
				<li><a href="user_profile.php"><?php echo "Welcome $row1[name]"; ?></a></li><br><br>
				<li><a href="logout.php">Logout</a></li>

			</ul>
		</div>
		<div class="header-logo">
			<a href="<?php if ($row1['bank_acc'] != 0) {
							echo "premium.php";
						} else {
							echo "regular.php";
						} ?>" class="logo">
				
			<img src="./img/logo.png" alt="">
			</a>
		</div>
		<div class="search_bar">
			<input type="text" id="search" placeholder="Search...">
			<div id="suggestions"></div>
		</div>

	</div>

	<div class="left_of_searchbar">
		<ul class='cart'>
			<li><a href="cartview.php"> Go To Cart</a></li>
		</ul>
	</div>

	<!-- wishlist dropdown -->
	<div class="dropdown">
		<button class="btn btn-primary dropdown-toggle" type="button" id="wishlistDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Wishlist
		</button>
		<div class="dropdown-menu" aria-labelledby="wishlistDropdown">
			<?php
			$user_id = $row1['user_id'];

			$wishlist_query = "SELECT * FROM wishlist WHERE user_id = '$user_id'";
			$wishlist_result = mysqli_query($conn, $wishlist_query);

			while ($wishlist_row = mysqli_fetch_assoc($wishlist_result)) {
				$product_id = $wishlist_row['product_id'];

				$product_query = "SELECT name, image FROM inventory WHERE product_id = '$product_id'";
				$product_result = mysqli_query($conn, $product_query);
				$product_row = mysqli_fetch_assoc($product_result);

				echo '<div class="dropdown-item">';
				echo '<span>' . $product_row['name'] . "<a href='update_wishlist.php?product_id=$product_id&action=remove'>Remove</a>" . '</span>';
				echo '</div>';
			}
			?>
		</div>
	</div>




	<div class="product-slider">
		<?php
		$sql = "SELECT * FROM inventory LIMIT 6";
		$result = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_assoc($result)) {
			$_SESSION["pro_id"] = $row["product_id"];
			echo "<div class='product-box'>";
			echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'><br>";
			echo '<h3><a href="productdisplay.php?id=' . $row['product_id'] . '">' . $row['name'] . '</a></h3>';
			$discounted_price = $row['price'] * 0.8;
			echo "<p>Regula Price: <del>" . $row['price'] . "</del></p>";
			echo "<p>Premium price: " . $discounted_price . "</p>";
			if ($row['quantity'] > 0) {
				
				echo '<button onClick="window.location.href=\'cartadd.php?id=' . $row['product_id'] . '&action=add_to_cart\';">Add to Cart</button>';
			} else {
				echo "<p>Out of Stock</p>";
			}
			echo '<button onClick="window.location.href=\'wishadd.php?id=' . $row['product_id'] . '&action=add_to_wish\';">Add to Wishlist</button>';
			echo "</div>";
		}
		?>
	</div>
	<div class="container">
		<div class="row">
			<?php
			$sql = "SELECT * FROM inventory LIMIT 4 OFFSET 6";
			$result = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_assoc($result)) {
				$_SESSION["pro_id"] = $row["product_id"];

				echo "<div class='product-box'>";
				echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'><br>";
				echo '<h3><a href="productdisplay.php?id=' . $row['product_id'] . '">' . $row['name'] . '</a></h3>';
				$discounted_price = $row['price'] * 0.8;

				echo "<p>Regula Price: <del>" . $row['price'] . "</del></p>";
				echo "<p>Premium price: " . $discounted_price . "</p>";

				if ($row['quantity'] > 0) {
					echo "<p>Quantity: " . $row['quantity'] . "</p>";
					echo '<button onClick="window.location.href=\'cartadd.php?id=' . $row['product_id'] . '&action=add_to_cart\';">Add to Cart</button>';
				} else {
					echo "<p>Out of Stock</p>";
				}
				echo '<button onClick="window.location.href=\'wishadd.php?id=' . $row['product_id'] . '&action=add_to_wish\';">Add to Wishlist</button>';
				echo "</div>";
			}
			?>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#wishlistDropdown .dropdown-toggle').click(function() {
				$('#wishlistDropdown .dropdown-menu').toggleClass('show');
			});
		});
		$(document).ready(function() {
			$('.product-slider').slick({
				infinite: true,
				slidesToShow: 3,
				slidesToScroll: 1,
			});
		});

		function addToCart(productId) {
			$.ajax({
				url: 'add_to_cart.php',
				type: 'post',
				data: {
					productId: productId
				},
				success: function(response) {
					window.location.href = 'cart.php';
				}
			});
		}

		function addToWishlist(productId) {
			$.ajax({
				url: 'add_to_wishlist.php',
				type: 'post',
				data: {
					productId: productId
				},
				success: function(response) {
					window.location.href = 'wishlist.php';
				}
			});
		}
	</script>
</body>

</html>