<?php
require('top.php');

// Optional: Prevent direct access without recent order
if (!isset($_SESSION['last_order_success'])) {
  echo "<script>window.location.href='index.php';</script>";
  die();
}

// Clear session flag
unset($_SESSION['last_order_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Thank You</title>
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }

    .thankyou-container {
      max-width: 600px;
      margin: 100px auto;
      padding: 40px;
      background-color: #fff;
      text-align: center;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .thankyou-container h1 {
      font-size: 32px;
      color: #28a745;
      margin-bottom: 20px;
    }

    .thankyou-container p {
      font-size: 18px;
      color: #555;
      margin-bottom: 30px;
    }

    .thankyou-container a {
      display: inline-block;
      padding: 12px 24px;
      background-color: #28a745;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 16px;
    }

    .thankyou-container a:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
  <div class="thankyou-container">
    <h1>🎉 Thank You!</h1>
    <p>Your order has been placed successfully. We’ll notify you once it's shipped.</p>
    <a href="my_order.php">View My Orders</a>
  </div>
</body>
</html>

<?php require('footer.php'); ?>
