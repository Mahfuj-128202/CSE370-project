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
if (isset($_POST["product_id"]) && $_POST["sold"] && $_POST["sell_id"]) {
    $product_id = $_POST['product_id'];
    $sold_date = $_POST["sold"];
    $sell_id = $_POST["sell_id"];

    if ($row1['bank_acc'] != 0) {
        if ((strtotime(date('Y-m-d')) - strtotime($sold_date)) / (60 * 60 * 24) < 60) {
            echo '<script>';
            echo 'var confirmed = confirm("You are eligible to return (less than 60 days). Click OK to continue.");';
            echo 'if (confirmed) {';
            echo 'window.location.href = "premium.php";';
            echo '}';
            echo '</script>';
            mysqli_query($conn, "UPDATE inventory SET quantity = quantity + 1 WHERE product_id = '$product_id';");
            mysqli_query($conn, "DELETE FROM sold WHERE product_id = '$product_id' AND user_id = '{$row1['user_id']}'AND sell_id = $sell_id;");
        

        } else {
            echo '<script>';
            echo 'var confirmed = confirm("60 days window expired. Click OK to continue.");';
            echo 'if (confirmed) {';
            echo 'window.location.href = "premium.php";';
            echo '}';
            echo '</script>';
        }

    } else {
        if ((strtotime(date('Y-m-d')) - strtotime($sold_date)) / (60 * 60 * 24) < 7) {
            echo '<script>';
            echo 'var confirmed = confirm("You are eligible to return (less than 7 days). Click OK to continue.");';
            echo 'if (confirmed) {';
            echo 'window.location.href = "regular.php";';
            echo '}';
            echo '</script>';
            mysqli_query($conn, "UPDATE inventory SET quantity = quantity + 1 WHERE product_id = '$product_id';");
            mysqli_query($conn, "DELETE FROM sold WHERE product_id = '$product_id' AND user_id = '{$row1['user_id']}'AND sell_id = $sell_id;");
        

        } else {
            echo '<script>';
            echo 'var confirmed = confirm("7 days window expired. Click OK to continue.");';
            echo 'if (confirmed) {';
            echo 'window.location.href = "regular.php";';
            echo '}';
            echo '</script>';
        }
    }
}
