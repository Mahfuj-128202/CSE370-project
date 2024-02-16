<?php
session_start();
require 'dbconnect.php';
if (!empty($_SESSION["id"])) {
}

if (isset($_POST["submit"])) {
  $user_id = $_POST["user_id"];
  $pass = $_POST["pass"];

  $result = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
  $row = mysqli_fetch_assoc($result);
  $result2 = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id = '$user_id'");
  $row2 = mysqli_fetch_assoc($result2);

  if (mysqli_num_rows($result) > 0) {

    if ($pass == $row["pass"]) {
      $_SESSION["login"] = true;
      $_SESSION["id"] = $row["user_id"];

      if ($row["bank_acc"] == 0) {
        header("Location: regular.php");

      } elseif ($row["bank_acc"] != 0) {
        header("Location: premium.php");
      }

    } else {
      echo "<script> alert('Wrong Password'); </script>";
    }

  } elseif (mysqli_num_rows($result2) > 0) {
    if ($pass == $row2["pass"]) {
      $_SESSION["login"] = true;
      $_SESSION["id"] = $row2["admin_id"];
      header("Location: adminpage.php");
    }
    
  } else {
    echo "<script> alert('User Not Registered'); </script>";
  }
}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link href="login.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="css/login.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <title>Login</title>
</head>

<body>
  <div class='top_header'>
    <div class="header-logo">
      <a href="homepage.php" class="logo">
      <img src="img/logo.png" alt="">
      </a>
    </div>
  </div>

  <h1 class='middel'>Login</h1>
  <form class="" action="" method="post" autocomplete="off">
    <label for="user_id">Username</label><br>
    <input type="text" name="user_id" id="user_id" required value=""> <br>
    <label for="pass">Password</label><br>
    <input type="password" name="pass" id="pass" required value=""> <br>
    <button type="submit" name="submit">Login</button>
  </form>
  <br>
  <label>Not a User? <a href="signupForm.php" class="signup-btn">Signup Here</a></label>

</body>

</html>