<?php
require 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>Electro</title>
</head>

<body>
  <div class='top_header'>
    <div class="container">
      <ul class="header-links pull-left">
        <li><a href="#"><i class="fa fa-phone"></i> add phone hear</a></li><br>
        <li><a href="#"><i class="fa fa-envelope-o"></i> add email here</a></li><br>
        <li><a href="#"><i class="fa fa-map-marker"></i> add location here</a></li><br>
      </ul>
      <ul class="header-links pull-right">
        <li><a href="login.php"><i class="fa fa-user-o"></i>login</a></li>
      </ul>
    </div>

    <div class="header-logo">
      <a href="homepage.php" class="logo">
      <img src="./img/logo.png" alt="">
      </a>
    </div>
  </div>
  <div class="product-slider">
    <?php
    
    $sql = "SELECT * FROM inventory LIMIT 6";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
      
      echo "<div class='product-box'>";
      echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'><br>";
      echo "<h3>" . $row['name'] . "</h3>";
      echo "<p>Price: $"  . $row['price'] . "</p>";

      if ($row['quantity'] > 0) {
        echo "<p>Quantity: " . $row['quantity'] . "</p>";
        echo '<button onClick="window.location.href=\'login.php\';';
        echo '">Add to Cart</button>';

      } else {
        echo "<p>Out of Stock</p>";
      }

      echo '<button onClick="window.location.href=\'login.php\';';
      echo '">Add to Wishlist</button>';
      echo "</div>";
    }
    ?>
  </div>
  <div class="container">
    <div class="row">
      <?php
      
      $sql = "SELECT * FROM inventory LIMIT 4 OFFSET 6";
      $result = mysqli_query($conn, $sql);
      
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='product-box'>";
        echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'><br>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>Price: $" . $row['price'] . "</p>";

        if ($row['quantity'] > 0) {
          echo "<p>Quantity: " . $row['quantity'] . "</p>";
          echo '<button onClick="window.location.href=\'login.php\';';
          echo '">Add to Cart</button>';

        } else {
          echo "<p>Out of Stock</p>";

        }

        echo '<button onClick="window.location.href=\'login.php\';';
        echo '">Add to Wishlist</button>';
        echo "</div>";
      }?>

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.product-slider').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
      });
    });
  </script>
</body>

</html>