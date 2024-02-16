<?php
session_start();
require 'dbconnect.php';
if (!empty($_SESSION["id"])) {
    $id = $_SESSION['id'];
    $u = mysqli_query($conn, "select * from user where user_id='$id'");
    $row1 = mysqli_fetch_assoc($u);

    $cart_result = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$id'");
    while ($cart_row = mysqli_fetch_assoc($cart_result)) {
        mysqli_query($conn, "INSERT INTO sold (user_id,product_id,quantity, sold_date)VALUES ('$id', '$cart_row[product_id]', '$cart_row[quantity]',NOW());");
        mysqli_query($conn, "UPDATE inventory SET quantity = quantity - $cart_row[quantity] WHERE product_id = '$cart_row[product_id]';");
    }

    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '{$row1['user_id']}'");
    if ($row1['bank_acc'] != 0) {
        header('Location: premium.php');
    } else {
        header('Location: regular.php');
    }
} else {
    header('Location: homepage.php');
}
