<?php
$conn = new mysqli('localhost', 'root', '');

if ($conn->connect_error) {
    die('çonnection failed: ' . $conn->connect_error);
} else {
    mysqli_select_db($conn, 'website');
}
