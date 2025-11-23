<?php
require('top.php');

$user_id = $_SESSION['USER_ID'];

// Fetch orders of the logged-in user
$res = mysqli_query($con, "SELECT * FROM orders WHERE user_id='$user_id' ORDER BY id DESC");

$id=1;
// if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){

// }
// else{
//   header('location:log.php');

//   die();
//   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <style>
    .order-container {
      max-width: 1000px;
      margin: auto;
      padding: 30px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      text-align: left;
      padding: 12px;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #333;
      color: white;
    }

    tr:hover {
      background-color: #f2f2f2;
    }

    a.view-link {
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
    }

    a.view-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      thead {
        display: none;
      }

      tr {
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 10px;
      }

      td {
        display: flex;
        justify-content: space-between;
        padding: 8px 10px;
        border: none;
        border-bottom: 1px solid #eee;
      }

      td::before {
        content: attr(data-label);
        font-weight: bold;
        flex-basis: 50%;
      }
    }
  </style>
</head>
<body>

<div class="order-container">
  <h2 class="section-heading">My Orders</h2>
  <table>
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Order Date & Time</th>
        <th>Address</th>
        <th>Payment Type</th>
        <th>Payment Status</th>
        <th>Order Status</th>
        <th>View</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($row = mysqli_fetch_assoc($res)) {
        $order_id = $row['id'];
        $order_date = date('d M Y, h:i A', strtotime($row['added_on']));
        $address = $row['address'] . ", " . $row['city'] . " - " . $row['pincode'];
        $payment_type = $row['payment_type'];
        $payment_status = ucfirst($row['payment_status']);

        // Fetch order status name from order_status table
        $order_status_id = $row['order_status'];
        $status_display = 'Unknown';

        $status_res = mysqli_query($con, "SELECT name FROM order_status WHERE id='$order_status_id' LIMIT 1");
        if ($status_row = mysqli_fetch_assoc($status_res)) {
          $status_display = $status_row['name'];
        }
        ?>
        <tr>
          <td data-label="Order ID"><?php echo $order_id; ?></td>
          <td data-label="Order Date & Time"><?php echo $order_date; ?></td>
          <td data-label="Address"><?php echo $address; ?></td>
          <td data-label="Payment Type"><?php echo $payment_type; ?></td>
          <td data-label="Payment Status"><?php echo $payment_status; ?></td>
          <td data-label="Order Status"><?php echo $status_display; ?></td>
          <td data-label="View">
            <a class="view-link" href="my_order_details.php?id=<?php echo $order_id; ?>">View</a>
          </td>
        </tr>
        <?php
      }

      if (mysqli_num_rows($res) == 0) {
        echo '<tr><td colspan="7" style="text-align:center;">No orders found.</td></tr>';
      }
      ?>
    </tbody>
  </table>
</div>

<?php require('footer.php'); ?>
</body>
</html>
