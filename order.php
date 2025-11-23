<?php
require('connection.inc.php');
require('functions.inc.php');

// Check if admin is logged in
if (!isset($_SESSION['ADMIN_LOGIN']) || $_SESSION['ADMIN_LOGIN'] == '') {
    header('location:login.php');
    die();
}

// Fetch all orders with order status name
$sql = "SELECT orders.*, order_status.name AS order_status_str 
        FROM orders 
        LEFT JOIN order_status ON orders.order_status = order_status.id 
        ORDER BY orders.id DESC";

$res = mysqli_query($con, $sql);

// If query fails, show error
if (!$res) {
    die("Query Failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Orders</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="mainstyle.css">

  <style>
    body, html {
      margin: 0;
      padding: 0;
    }
    .navbar {
      margin: 0;
      padding: 0;
    }
    .container-fluid {
      margin: 0 !important;
      padding: 0 1rem;
    }
  </style>
</head>
<body>
<section class="body">

<!-- Navbar -->
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <img src="logo.png" height="69px" alt="Satguru Handloom" id="logo">
    <form class="d-flex">
      <a class="add" href="#"><i class="fa-solid fa-user-shield"> H e l l o , A d m i n </i></a>
      <button class="bar" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
        <i class="fa-solid fa-bars"></i>
      </button>
    </form>
  </div>
</nav>

<!-- Sidebar -->
<div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
  <div class="offcanvas-header">
    <h4 class="offcanvas-title" id="staticBackdropLabel">MENU</h4>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul>
      <li><a class="menu" href="categories.php">Categories Master</a></li>
      <li><a class="menu" href="product.php">Product Master</a></li>
      <li><a class="menu" href="order.php">Order Master</a></li>
      <li><a class="menu" href="Banner.php">Banner Master</a></li>
      <li><a class="menu" href="user.php">User Master</a></li>
      <li><a class="menu" href="contactus.php">Contact Us</a></li>
      <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-right-from-bracket"> Logout</i></a></li>
    </ul>
  </div>
</div>
</section>

<!-- Page Heading -->
<div class="container mt-4">
  <h2 class="mb-4">Order List</h2>

  <table class="table table-bordered text-center">
    <thead class="table-light">
      <tr>
        <th>Order ID</th>
        <th>Order Date</th>
        <th>Address</th>
        <th>Payment Type</th>
        <th>Payment Status</th>
        <th>Order Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($res)) { ?>
      <tr>
        <td>
          <a href="order_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
            <?php echo $row['id']; ?>
          </a>
        </td>
        <td><?php echo $row['added_on']; ?></td>
        <td>
          <?php echo $row['address']; ?><br>
          <?php echo $row['city'] . ' / ' . $row['pincode']; ?>
        </td>
        <td><?php echo $row['payment_type']; ?></td>
        <td><?php echo ucfirst($row['payment_status']); ?></td>
        <td><?php echo $row['order_status_str'] ? $row['order_status_str'] : 'Not Assigned'; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
