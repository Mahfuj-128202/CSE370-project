<?php
session_start();
require 'dbconnect.php';
if (isset($_GET['user_id']) && ($_GET['action'])) {
    $user_id = $_GET['user_id'];
    $bill = $_GET['action'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="css/checkout.css">
    <title>Checkout</title>
</head>

<body>
    <h1>Checkout</h1>
    <form action="checkout_process.php" method="POST">
        <div class="form-group">
            <label for="method_of_payment">Method of Payment:</label><br>
            <select class="form-control" id="method_of_payment" name="method_of_payment">
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="Bkash">Bkash</option>
                <option value="Nagad">Nagad</option>

            </select>
        </div>
        <div class="form-group">
            <label for="method_of_delivery">Method of Delivery:</label><br>
            <select class="form-control" id="method_of_delivery" name="method_of_delivery">
                <option value="Pathao">Pathao</option>
                <option value="RedEx">RedEx</option>
                <option value="Courier">Courier</option>
                <option value="delivery">On spot delivery</option>

            </select>
        </div>
        <div class="form-group">
            <label for="delivery_date">Delivery Date:</label><br>
            <input type="date" class="form-control" id="delivery_date" name="delivery_date" min="<?php echo date('Y-m-d', strtotime('+3 days')); ?>" value="<?php echo date('Y-m-d', strtotime('+3 days')); ?>">
        </div>
        <button type="submit" class="btn btn-primary" onclick="confirmOrder()">Place Order</button>
    </form>

</body>
<script>
function confirmOrder() {
  if (confirm("Your order has been placed. Except order to arrive within 4 workring days")) {
   
  }
}
</script>

</html>