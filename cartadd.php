<?php
session_start();
require 'dbconnect.php';
if (isset($_GET['id'])) {
    if (!empty($_SESSION["id"])) {
        $id = $_SESSION['id'];
        $u = mysqli_query($conn, "select * from user where user_id='$id'");
        $row1 = mysqli_fetch_assoc($u);
    } else {
        header('Location: homepage.php');
    }
    if ($row1['bank_acc'] != 0) {

        header("Location: premium.php");
    } else {
        header("Location: regular.php");
    }
    $pro_id = $_GET['id'];
    $id = $_SESSION['id'];

    $u = mysqli_query($conn, "select * from user where user_id='$id'");
    $row1 = mysqli_fetch_assoc($u);

    $p = mysqli_query($conn, "select * from inventory where product_id='$pro_id'");
    $row2 = mysqli_fetch_assoc($p);

    $w = mysqli_query($conn, "select * from cart where product_id='$pro_id' and user_id='$row1[user_id]'");
    $row3 =  mysqli_fetch_assoc($w);
    
    if (mysqli_num_rows($w)>0){
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE product_id = '$pro_id' AND user_id='{$row1['user_id']}' AND cart_id = '{$row3['cart_id']}';");
    }else{
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity, unit_price) VALUES ('$row1[user_id]', '$row2[product_id]', 1, '$row2[price]')");
    }
}
