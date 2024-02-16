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
    $pro_id = $_GET['id'];


    $id = $_SESSION['id'];

    $u = mysqli_query($conn, "select * from user where user_id='$id'");
    $row1 = mysqli_fetch_assoc($u);

    $p = mysqli_query($conn, "select * from inventory where Product_id='$pro_id'");
    $row2 = mysqli_fetch_assoc($p);

    mysqli_query($conn, "INSERT INTO wishlist (user_id, product_id) VALUES ('$row1[user_id]', '$row2[product_id]')");
}
