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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/user_profile.css">
    <title>User profile</title>
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
            <a href="<?php if ($row1['bank_acc'] != 0) {
                            echo "premium.php";
                        } else {
                            echo "regular.php";
                        } ?>" class="logo">
               
            <img src="./img/logo.png" alt="">
            </a>
        </div>
    </div>

    <?php
    $user_id = $row1['user_id'];
    $puls = mysqli_query($conn, "select * from sold where user_id='$user_id'");;
    echo "<table>";
    echo "<thead><tr> <th>Product</th>  <th>Quantity</th> <th>Purchase date</th><th></th></tr></thead>";
    while ($result = mysqli_fetch_assoc($puls)) {
        $product_id = $result['product_id'];
        $quantity = $result['quantity'];
        $sold_date = $result['sold_date'];

        $product_result = mysqli_query($conn, "SELECT name, image FROM inventory WHERE product_id = '$product_id'");
        $product_row = mysqli_fetch_assoc($product_result);

        echo "<tr>";
        echo "<td>" . $product_row['name'] . "</td>";
        echo "<td>$quantity </td>";
        echo "<td>$sold_date</td>";
        echo '<td><form action="return_user.php" method="post">

            <input type="hidden" name="product_id" value="' . $result['product_id'] . '">
            <input type="hidden" name="sold" value="' . $result['sold_date'] . '">
            <input type="hidden" name="sell_id" value="' . $result['sell_id'] . '">

            <button type="submit">Return</button>
        </form></td>';
        
        echo "</tr>";
    }
    echo "</table>";
    ?>

</body>

</html>