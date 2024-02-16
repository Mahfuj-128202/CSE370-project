<?php
session_start();
require 'dbconnect.php';
if (!empty($_SESSION["id"])) {
    $id = $_SESSION['id'];
    $u = mysqli_query($conn, "select * from user where user_id='$id'");
    $row1 = mysqli_fetch_assoc($u);
} else {
    header('Location: homepage.php');
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/cart.css"> -->

    <title>Return</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: gray;
        }
    </style>
</head>

<body>
<div class="top_header">
        <div class="align_right">

            <h4>Name : <?php echo $row1['name']; ?></h4>

            <h4>Email : <?php echo $row1['email']; ?></h4>
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



    <?php
    if (isset($_POST["user_id"])) {
        $user_id = $_POST['user_id'];
        $cart_result = mysqli_query($conn, "SELECT * FROM sold WHERE user_id = '$user_id'");

        if (mysqli_num_rows($cart_result) == 0) {
            echo "<p>You haven't purchased anything.</p>";
        } else {
            echo "<table style='border: 1px solid black;'>";
            echo "<thead><tr> <th>Product</th> <th>Purchase Date</th><th></th></tr></thead>";
            while ($cart_row = mysqli_fetch_assoc($cart_result)) {
                $product_id = $cart_row['product_id'];

                $product_result = mysqli_query($conn, "SELECT name, image FROM inventory WHERE product_id = '$product_id'");
                $product_row = mysqli_fetch_assoc($product_result);

                
                echo "<tr>";
                echo "<td><img src='" . $product_row['image'] . "' alt=' '>" . $product_row['name'] . "</td><td>" . $cart_row["sold_date"] . '</td>';

                echo '<td><form action="return_verify.php" method="post">
            <input type="hidden" name="product_id" value="' . $product_id . '">

            <input type="hidden" name="sell_id" value="' . $cart_row['sell_id'] . '">
            <input type="hidden" name="sold" value="' . $cart_row['sold_date'] . '">
            <button type="submit">Return</button>
        </form></td>';
                echo "</tr>";
            }
            echo "</table>";
        }
    } ?>

</body>

</html>