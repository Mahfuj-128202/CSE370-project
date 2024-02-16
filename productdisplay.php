<?php
session_start();
require 'dbconnect.php';
if (!empty($_SESSION["id"])) {
    $id = $_SESSION['id'];
    $u = mysqli_query($conn, "select * from user where user_id='$id'");
    $row1 = mysqli_fetch_assoc($u);
} else {
    header('Location: homepage.php');
}
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $sql = "SELECT * FROM inventory where product_id = '$product_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title><?php echo $row['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

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
                <li><?php echo "Welcome $row1[name]"; ?></a></li><br><br>
                <li><a href="logout.php">Logout</a></li>

            </ul>
        </div>
        <div class="header-logo">
            <a href="<?php
                        if ($row1['bank_acc'] != 0) {
                            echo 'premium.php';
                        } else {
                            echo 'regular.php';
                        }
                        ?>" class="logo">
               
            <img src="./img/logo.png" alt="">
            </a>
        </div>
    </div>
    
        <div class="product-box">
            <img src="<?php echo $row['image']; ?>" alt=" ">
            <?php
            if ($row['quantity'] > 0) {
                
                if ($row1['bank_acc'] != 0) {
                    $discounted_price = $row['price'] * 0.8;
                    echo "<p>Regula Price: <del>" . $row['price'] . "</del></p>";
                    echo "<p>Premium price: " . $discounted_price . "</p>";

                } else {
                    $discounted_price = $row['price'] * 0.95;
                    echo "<p>Regula Price: <del>" . $row['price'] . "</del></p>";
                    echo "<p>Discount price: " . $discounted_price . "</p>";
                }

                echo'<h2>'. $row['name'] .'</h2>';
                echo '<button onClick="window.location.href=\'cartadd.php?id=' . $row['product_id'] . '&action=add_to_cart\';">Add to Cart</button>';
            
            } else {
                echo "<p>Out of Stock</p>";
            }

            echo '<button onClick="window.location.href=\'wishadd.php?id=' . $row['product_id'] . '&wishlist=add_to_wish\';">Add to Wishlist</button>';
            ?>
        </div>
</body>
</html>