<?php
require 'dbconnect.php';

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT product_id,quantity,name,price FROM inventory WHERE name LIKE '%$search%'";
    $result = mysqli_query($conn, $query);

    $data = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
}
