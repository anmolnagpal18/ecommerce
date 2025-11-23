<?php
require('connection.inc.php');
require('functions.inc.php');

// Check if admin is logged in
if (!isset($_SESSION['ADMIN_LOGIN']) || $_SESSION['ADMIN_LOGIN'] == '') {
    header('location:login.php');
    die();
}

// Get order ID from URL
if (isset($_GET['id']) && $_GET['id'] != '') {
    $order_id = get_safe_value($con, $_GET['id']);

    // Fetch order info
    $order_sql = "SELECT orders.*, order_status.name AS order_status_str 
                  FROM orders 
                  JOIN order_status ON orders.order_status = order_status.id 
                  WHERE orders.id = '$order_id'";
    $order_res = mysqli_fetch_assoc(mysqli_query($con, $order_sql));

    // Fetch order products (corrected table name to `order_detail`)
    $details_sql = "SELECT order_detail.*, product.name, product.image 
                    FROM order_detail 
                    JOIN product ON product.id = order_detail.product_id 
                    WHERE order_detail.order_id = '$order_id'";
    $details_res = mysqli_query($con, $details_sql);

    if (!$details_res) {
        die("Error fetching order details: " . mysqli_error($con));
    }
} else {
    echo "Order ID missing.";
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h2>Order Detail</h2>

<table class="table table-bordered text-center">
  <thead class="table-light">
    <tr>
      <th>PRODUCT NAME</th>
      <th>PRODUCT IMAGE</th>
      <th>QTY</th>
      <th>PRICE</th>
      <th>TOTAL PRICE</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_price = 0;
    while ($row = mysqli_fetch_assoc($details_res)) {
      $subtotal = $row['qty'] * $row['price'];
      $total_price += $subtotal;
    ?>
    <tr>
      <td><?php echo $row['name']; ?></td>
      <td><img src="media/product/<?php echo $row['image']; ?>" width="100px"></td>
      <td><?php echo $row['qty']; ?></td>
      <td><?php echo $row['price']; ?></td>
      <td><?php echo $subtotal; ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="4" class="text-end"><strong>Total Price</strong></td>
      <td><strong><?php echo $total_price; ?></strong></td>
    </tr>
  </tbody>
</table>

<p><strong>Address:</strong> <?php echo $order_res['address'] . ', ' . $order_res['city'] . '/' . $order_res['pincode']; ?></p>
<p><strong>Order Status:</strong> <?php echo $order_res['order_status_str']; ?></p>

<!-- Order status dropdown -->
<form method="post" class="mt-3">
  <label for="status"><strong>Change Status:</strong></label>
  <select name="order_status" class="form-select" style="width: 300px;">
    <option value="">Select Status</option>
    <?php
    $status_res = mysqli_query($con, "SELECT * FROM order_status");
    while ($row = mysqli_fetch_assoc($status_res)) {
      $selected = ($order_res['order_status'] == $row['id']) ? 'selected' : '';
      echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
    }
    ?>
  </select>
  <br>
  <button type="submit" name="update_status" class="btn btn-primary">Submit</button>
</form>

<?php
if (isset($_POST['update_status'])) {
    $new_status = get_safe_value($con, $_POST['order_status']);
    mysqli_query($con, "UPDATE orders SET order_status='$new_status' WHERE id='$order_id'");
    echo "<script>window.location.href='order_detail.php?id=$order_id';</script>";
}
?>

</body>
</html>
