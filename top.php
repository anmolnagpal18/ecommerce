<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');
// session_start();
$obj=new add_to_cart();
$totalProduct=$obj->totalProduct();
// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

$cat_res = mysqli_query($con, "SELECT * FROM categories WHERE status='1' order by categories asc");
$cat_arr = array();
while ($row = mysqli_fetch_assoc($cat_res)) {
    $cat_arr[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Satguru Handloom</title>
  <link rel="stylesheet" href="shop.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .cart-icon {
  position: relative;
  display: inline-block;
}

.cart-count {
  position: absolute;
  top: -8px;
  right: -10px;
  background-color: red;
  color: white;
  font-size: 12px;
  font-weight: bold;
  padding: 2px 6px;
  border-radius: 50%;
  line-height: 1;
  min-width: 18px;
  text-align: center;
}

  </style>
</head>
<body>

<!-- Wishlist Sidebar -->
<div class="wishlist-sidebar" id="wishlistSidebar">
  <div class="wishlist-header">
    <h3>Wishlist</h3>
    <span class="close-btn" onclick="closeWishlist()">&times;</span>
  </div>
  <div class="wishlist-content">
    <p>Your wishlist is empty.</p>
  </div>
</div>

<!-- Search Overlay -->
<div class="search-overlay" id="searchOverlay">
  <div class="search-box">
    <form id="searchForm" action="search.php" method="get" onsubmit="return handleSearchSubmit()">
      <input type="text" name="str" id="searchInput" placeholder="Search products..." required />
      <button type="submit" style="height: 0; width: 0; border: none; padding: 0; overflow: hidden; position: absolute;"></button>
    </form>
    <button class="close-search" onclick="closeSearch()">X</button>
  </div>
</div>

<!-- Header -->
<header>
  <!-- Logo -->
  <div class="logo">
    <img src="logo.png" alt="Logo">
  </div>

  <!-- Navigation Links -->
  <nav id="nav-links" class="nav-links">
    <a href="index.php">Home</a>
    <a href="my_order.php">Orders</a>
    <!-- <a href="#">Shop</a> -->
    <a href="aboutus.php">About</a>
    <a href="contact_us.php">Contact</a>

    <div class="relative inline-block group">
      <a href="#">Category</a>
      <div class="hidden absolute top-[100%] group-hover:flex flex-col gap-1 bg-white shadow-lg rounded-lg px-10 py-3"> 
        <?php foreach ($cat_arr as $list) { ?>
          <a href="cat.php?id=<?php echo $list['id'] ?>"><?php echo $list['categories'] ?></a>
        <?php } ?>
      </div>
    </div>
  </nav>

  <!-- Icons Section -->
  <div class="icons">
    <i class="fas fa-search" onclick="openSearch()"></i>
    <a href="wishlist.php" class="far fa-heart">
    <!-- <i class="far fa-heart" onclick="openWishlist()"></i> -->
    <!-- wishlist_manage.php -->

    
    <?php if (isset($_SESSION['USER_ID'])): ?>
  <a href="cart.php" class="cart-icon">
    <i class="fas fa-shopping-cart"></i>
    <span class="cart-count" id="cart_count"><?php echo $totalProduct; ?></span>
  </a>
<?php else: ?>
  <a href="javascript:void(0);" class="cart-icon" onclick="alert('Please login to access your cart');">
    <i class="fas fa-shopping-cart"></i>
    <span class="cart-count" id="cart_count">0</span>
  </a>
<?php endif; ?>




    <!-- <a href="cart.php"><i class="fas fa-shopping-cart"></i></a> -->

    <!-- User Dropdown -->
    <div class="user-dropdown" id="userDropdown">
      <i class="fas fa-user"></i>
      <div class="user-dropdown-content">
        <?php if (isset($_SESSION['USER_ID'])): ?>
          <a href="?logout=true">Logout</a>
        <?php else: ?>
          <a href="log.php">Login</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Hamburger Icon -->
    <div class="hamburger" onclick="toggleMenu()">
      <i class="fas fa-bars"></i>
    </div>
  </div>
</header>

<script>
document.addEventListener("DOMContentLoaded", function () {
  window.toggleMenu = function () {
    const navLinks = document.getElementById("nav-links");
    navLinks.classList.toggle("hidden");
  };

  window.openSearch = function () {
    document.getElementById("searchOverlay").style.display = "flex";
  };

  window.closeSearch = function () {
    document.getElementById("searchOverlay").style.display = "none";
  };

  window.handleSearchSubmit = function () {
    closeSearch(); // Close overlay after submitting
    return true;   // Allow form submission
  };
});


</script>


</body>
</html>
