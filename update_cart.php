<?php
session_start();
require 'dbconnect.php'; 
$id = $_SESSION['id'];
$u = mysqli_query($conn, "select * from user where user_id='$id'");
$row1 = mysqli_fetch_assoc($u);
if (isset($_GET['product_id']) && $_GET['action']) {
    $product_id = $_GET['product_id'];
    try {
        if ($_GET['action'] == 'increase') {
            mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE product_id = '$product_id' AND user_id = '{$row1['user_id']}';");
        } elseif ($_GET['action'] == 'decrease') {
            mysqli_query($conn, "UPDATE cart SET quantity = quantity - 1 WHERE product_id = '$product_id' AND user_id = '{$row1['user_id']}';");
        } elseif ($_GET['action'] == 'remove') {
            mysqli_query($conn, "DELETE FROM cart WHERE product_id = '$product_id' AND user_id = '{$row1['user_id']}';");
        }
    } 
    catch (Exception $e) {
        mysqli_query($conn, "DELETE FROM cart WHERE product_id = '$product_id' AND user_id = '{$row1['user_id']}';");
    }

    header("Location: cartview.php");
}
