<?php
session_start();
require 'dbconnect.php';
if (!empty($_SESSION["id"])) {
    $id = $_SESSION['id'];
    $u = mysqli_query($conn, "select * from user where user_id='$id'");
    $row1 = mysqli_fetch_assoc($u);
    $q = mysqli_query($conn, "select * from user_phone where user_id='$id'");
   
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

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/cart.css">

    <title>Your Cart</title>
</head>

<body>
    <div class="top_header">
        <div class="align_right">
            <h4>Name : <?php echo $row1['name']; ?></h4>
            <h4>Email : <?php echo $row1['email']; ?></h4>
            <h4>Phone : 
            <?php
            while($phone= mysqli_fetch_assoc($q)) {
                echo  $phone['phone_number']. " , ";
            }
            ?></h4>
            <h4>Address : <?php echo $row1['address']; ?></h4>
    </div>
        <div class="align_left">
            <div class="logo">
                <a href="<?php if ($row1['bank_acc'] != 0) {
                                echo "premium.php";
                            } else {
                                echo "regular.php";
                            } ?>" class="logo">
                    
                <img src="img/logo.png" alt="">
                </a>
            </div>
        </div>
    </div>

    <!-- Table of Cart -->
    <?php
    $user_id = $row1['user_id'];
    $cart_result = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");

    if (mysqli_num_rows($cart_result) == 0) {
        echo "<p>Your cart is empty.</p>";
    } else {
        echo "<table>";
        echo "<thead><tr> <th>Product</th> <th>Quantity</th> <th>Price</th> <th></th><th></th></tr></thead>";
        while ($cart_row = mysqli_fetch_assoc($cart_result)) {
            $product_id = $cart_row['product_id'];
            $quantity = $cart_row['quantity'];
            $unit_price = $cart_row['unit_price'];

            $product_result = mysqli_query($conn, "SELECT name, image FROM inventory WHERE product_id = '$product_id'");
            $product_row = mysqli_fetch_assoc($product_result);

            echo "<tr>";
            echo "<td>" . $product_row['name'] . "</td>";
            echo "<td> <a href='update_cart.php?product_id=$product_id&action=increase'>+</a>$quantity<a href='update_cart.php?product_id=$product_id&action=decrease'>-</a></td>";

            echo "<td>$unit_price</td>";
            echo "<td><a href='update_cart.php? product_id=$product_id &action=remove'>Remove</a></td>";
            echo "</tr>"; 
        }
        echo "</table>";
    }
    $total_price = 0;
    $cart_result = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
    while ($cart_row = mysqli_fetch_assoc($cart_result)) {
        $total_price = $total_price + ($cart_row['quantity'] * $cart_row['unit_price']);
    }
    $shipping_cost = 50;
    
    if ($row1['bank_acc']==0){
        echo '<br><br>Actual Price : ' . $total_price . "$<br><br>";
        echo 'Discounted Price : ' . $total_price*.95 . "$<br>";
        echo 'Shipping cost : ' . $shipping_cost . "$<br>";
        echo "_______________________<br>";
        echo "Sub total : " . $total_price*.95 + $shipping_cost . "$";

    }else{
        echo '<br><br>Actual Price : ' . $total_price . "$<br><br>";
        echo 'Discounted Price : ' . $total_price*.8 . "$<br>";
        echo 'Shipping cost : ' . $shipping_cost . "$<br>";
        echo "_______________________<br>";
        echo "Sub total : " . $total_price*.8 + $shipping_cost . "$";
    }
    
    if ($total_price != 0) {
        echo '<div class="check_out">';
        echo '<button><a href="checkout.php?user_id=. $row1[user_id]. ?>&action= . $sub_total. ?>">Checkkout</a></button>';
        echo '</div>';
    } else {
        echo '<div class="check_out">';
        echo '<button>Checkkout</button>';
        echo '</div>';
    }
    ?>

    <div class="return">
        <form method="post" action="return.php">
            <input type="hidden" name="user_id" value="<?php echo $row1['user_id']; ?>">
            <button type="submit">Return</button>
        </form>

    </div>
</body>

</html>