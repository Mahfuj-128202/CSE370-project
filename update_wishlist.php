<?php
session_start();
require 'dbconnect.php';
$id = $_SESSION['id'];
$u = mysqli_query($conn, "select * from user where user_id='$id'");
$row1 = mysqli_fetch_assoc($u);
if (isset($_GET['product_id']) && $_GET['action']) {
    $product_id = $_GET['product_id'];
    mysqli_query($conn, "DELETE FROM wishlist WHERE product_id = '$product_id' AND user_id = '{$row1['user_id']}';");

    if ($row1['bank_acc'] != 0) {
        header("Location: premium.php");
    } else {
        header("Location: regular.php");
    }
}
