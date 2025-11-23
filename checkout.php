<?php
require('top.php'); // contains DB connection + session_start()

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
  echo "<script>window.location.href='index.php';</script>";
  die();
}

// Calculate cart total
$cartTotal = 0;
foreach ($_SESSION['cart'] as $key => $val) {
  $productArr = get_product($con, '', '', $key);
  $price = $productArr[0]['price'];
  $qty = $val['qty'];
  $cartTotal += $price * $qty;
}

// Handle form submission
if (isset($_POST['submit'])) {
  $address = mysqli_real_escape_string($con, $_POST['address']);
  $city = mysqli_real_escape_string($con, $_POST['city']);
  $pincode = mysqli_real_escape_string($con, $_POST['pincode']);
  $payment_type = mysqli_real_escape_string($con, $_POST['payment']);

  $user_id = $_SESSION['USER_ID'];
  $total_price = $cartTotal;
  $payment_status = 'pending';
  $order_status = '1';
  $added_on = date('Y-m-d hh:ii:ss');

  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  try {
    // Insert into orders table
    mysqli_query($con, "INSERT INTO orders(user_id, address, city, pincode, payment_type, total_price, payment_status, order_status, added_on) 
      VALUES ('$user_id', '$address', '$city', '$pincode', '$payment_type', '$total_price', '$payment_status', '$order_status', '$added_on')");

    $order_id = mysqli_insert_id($con);

    // Insert order items
    foreach ($_SESSION['cart'] as $key => $val) {
      $productArr = get_product($con, '', '', $key);
      $price = $productArr[0]['price']; // per-unit price
      $qty = $val['qty'];
      $added_on = date('Y-m-d H:i:s');

      mysqli_query($con, "INSERT INTO order_detail(order_id, product_id, qty, price, added_on) 
        VALUES ('$order_id', '$key', '$qty', '$price', '$added_on')");
    }

    // Clear cart
    unset($_SESSION['cart']);
    $_SESSION['last_order_success'] = true;
    echo "<script>window.location.href='thankyou.php';</script>";
    
    die();
  } catch (Exception $e) {
    echo "Error placing order: " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Checkout</title>
  <style>
    .checkout-container {
      max-width: 600px;
      background: #fff;
      padding: 30px;
      margin: auto;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 24px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 16px;
    }

    .radio-group {
      display: flex;
      flex-direction: column;
      margin-top: 5px;
    }

    .radio-option {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .radio-option input {
      margin-right: 10px;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background-color: #333;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #555;
    }

    .error {
      color: red;
      font-size: 14px;
      display: none;
    }
  </style>
</head>
<body>
  <br><br>
  <h2>Checkout</h2>
  <div class="checkout-container">
    <form id="checkoutForm" method="post">
      <div class="form-group">
        <label for="address">Street Address</label>
        <textarea name="address" id="address" required></textarea>
      </div>

      <div class="form-group">
        <label for="city">City</label>
        <input name="city" type="text" id="city" required />
      </div>

      <div class="form-group">
        <label for="zip">Zip / Postal Code</label>
        <input name="pincode" type="text" id="zip" required />
      </div>

      <div class="form-group">
        <label>Payment Method</label>
        <div class="radio-group">
          <label class="radio-option">
            <input type="radio" name="payment" value="COD" required>
            Cash on Delivery
          </label>
          <label class="radio-option">
            <input type="radio" name="payment" value="Online" required>
            Online Payment
          </label>
        </div>
      </div>

      <input type="submit" name="submit" class="btn" value="Place Order">
    </form>
  </div>
  <br><br>
</body>
</html>

<?php require('footer.php'); ?>
