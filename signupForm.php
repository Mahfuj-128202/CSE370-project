<?php
require 'dbconnect.php';
if (!empty($_SESSION["id"])) {
  header("Location: index.php");
}
if (isset($_POST["submit"])) {
  $username = $_POST["username"];
  $name = $_POST["name"];
  $address = $_POST['address'];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $confirmpassword = $_POST["confirmpassword"];
  $bank_acc = $_POST['bank_acc'];
  $phone_numbers = $_POST["phone"];
  $duplicate = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$username' OR email = '$email'");
  if (mysqli_num_rows($duplicate) > 0) {
    echo "<script> alert('Username or Email Has Already Taken'); </script>";
  } else {
    if ($password == $confirmpassword) {
      $query = "INSERT INTO user VALUES('$username', '$password', '$name', '$address', '$email', '$bank_acc')";
      mysqli_query($conn, $query);
     

      // insert phone numbers into user_phone table
      foreach ($phone_numbers as $phone_number) {
        $phone_query = "INSERT INTO user_phone (phone_id,user_id, phone_number) VALUES ('','$username', '$phone_number')";
        mysqli_query($conn, $phone_query);
      }

      header("Location: login.php");
    } else {
      echo "<script> alert('Password Does Not Match'); </script>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/signup.css">
  <title>Registration</title>
</head>

<body>
  <h2>Registration</h2>
  <form class="" action="" method="post" autocomplete="off">

    <label for="name">Name : </label>
    <input type="text" name="name" id="name" required value=""> <br>

    <label for="phone">Phone Numbers:</label>
    <button type="button" onclick="addPhone()">Add Phone Number</button>
    <input type="tel" name="phone[]" id="phone" required>
    
    <br>
    <div id="phone-container"></div>
    
    <label for="name">Address : </label>
    <input type="text" name="address" id="address"> <br>

    <label for="email">Email : </label>
    <input type="email" name="email" id="email" required value=""> <br>

    <label for="Regular">Regular:</label>
    <input type="radio" name="option" id="Regular" value="Regular" onclick="showFields(this.value)">

    <label for="Premium">Premium:</label>
    <input type="radio" name="option" id="Premium" value="Premium" onclick="showFields(this.value)">

    <div id="fieldsRegular" style="display:none;">
      <br><label for="bank_acc"></label>
    </div>

    <div id="fieldsPremium" style="display:none;">
      <br><label for="bank_acc">Bank Account No.</label>
      <input type="number" name="bank_acc" id="bank_acc" required value="">
    </div>

    <script>
      function showFields(option) {
        var fieldsRegular = document.getElementById("fieldsRegular");
        var fieldsPremium = document.getElementById("fieldsPremium");

        if (option == "Regular") {
          fieldsRegular.style.display = "block";
          fieldsPremium.style.display = "none";
          document.getElementById("bank_acc").value = 0;
        } else if (option == "Premium") {
          fieldsRegular.style.display = "none";
          fieldsPremium.style.display = "block";
        }
      }

      function addPhone() {
        var container = document.getElementById("phone-container");
        var input = document.createElement("input");
        input.type = "tel";
        input.name = "phone[]";
        input.required = true;
        container.appendChild(input);
      }

    </script>

    <br><br><label for="username">Username : </label>
    <input type="text" name="username" id="username" required value=""> <br>

    <br><label for="password">Password : </label>
    <input type="password" name="password" id="password" required value=""> <br>

    <label for="confirmpassword">Confirm Password : </label>
    <input type="password" name="confirmpassword" id="confirmpassword" required value=""> <br>

    <button type="submit" name="submit">Register</button>
  </form>
  <br>
  <a href="login.php">Login</a>
</body>

</html>