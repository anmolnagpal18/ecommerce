<?php

require('top.php');
// require('connection.inc.php');
// require('functions.inc.php');

if (!isset($_SESSION['USER_ID'])) {
    header('location:log.php');
    die();
}

$user_id = $_SESSION['USER_ID'];
$res = mysqli_query($con, "SELECT wishlist.id as wid, product.* FROM wishlist, product WHERE wishlist.product_id=product.id AND wishlist.user_id='$user_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Wishlist</title>

    <style>
    /* body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 20px;
    background-color: #f4f4f4;
    color: #333;
} */
 /* Add these styles to your existing CSS */

/* Ensures that the body takes the full height */
html, body {
    height: 100%;
    margin: 0;
}

/* Flexbox for the body to take up full height and push footer to bottom */
body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Main content area (wishlist container) takes all available space */
.wishlist-container {
    flex-grow: 1; /* This makes the wishlist container grow and take up remaining space */
}

/* Footer remains at the bottom */
.site-footer {
    margin-top: auto; /* Pushes the footer to the bottom */
}


h1 {
    text-align: center;
    color: #333;
    margin-bottom: 40px;
}

.wishlist-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.wishlist-item {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 280px;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.wishlist-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.wishlist-item img {
    max-width: 100%;
    height: 200px;
    object-fit: contain;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.wishlist-item img:hover {
    transform: scale(1.1);
}

.wishlist-item h3 {
    font-size: 20px;
    margin: 15px 0;
    font-weight: bold;
}

.wishlist-item p {
    font-size: 14px;
    margin: 8px 0;
}

.wishlist-item .price {
    font-size: 16px;
    color: #4caf50;
    font-weight: bold;
}

.wishlist-item .mrp {
    font-size: 14px;
    color: #999;
    text-decoration: line-through;
}

.remove-btn {
    background-color: #ff4d4d;
    color: white;
    padding: 8px 12px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.remove-btn:hover {
    background-color: #e63946;
}

.no-items {
    font-size: 18px;
    color: #666;
    text-align: center;
    width: 100%;
}
.footer-container {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  padding: 20px 0;
}

/* Footer box styling */
.footer-box {
  flex: 1 1 200px;
  margin: 10px;
}

/* Footer bottom section */
.footer-bottom {
  background-color: #222;
  padding: 10px;
  text-align: center;
  color: #bbb;
}

/* Styling for social icons */
.social-icons a {
  color: #fff;
  margin-right: 10px;
  font-size: 20px;
}

.social-icons a:hover {
  color: #e03e7c;
}

.footer-bottom p {
  margin: 0;
  font-size: 14px;
}
.no-products {

    text-align: center;
    margin-top: 50px; 
    font-size: 24px;
    color: red;
    font-weight: bold;
    padding: 20px;
    margin-right: 20px;
    margin-left: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    margin-bottom: 70px;
}

.wishlist-item img {
    width: 100%; /* Make the image take the full width of its container */
    height: 200px; /* Maintain a fixed height */
    object-fit: cover; /* Ensure the image covers the container without distortion */
    border-radius: 8px;
    transition: transform 0.3s ease;
}

</style>
</head>
<body>
<h1 class="section-heading">My Wishlist</h1>
    <div class="wishlist-container">
        <?php
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
        ?>
            <div class="wishlist-item">
                <img  src="media/product/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
              <h3><?php echo $row['name']; ?></h3>
                <p class="price">₹<?php echo $row['price']; ?></p>
                <p class="mrp"><del>₹<?php echo $row['mrp']; ?></del></p>
                <a class="remove-btn" href="wishlist_manage.php?type=remove&id=<?php echo $row['wid']; ?>">Remove</a>
            </div>
        <?php
            }
        } else {
            echo "<p class='no-items'>No items in your wishlist.</p>";
        }
        ?>
    </div>
    <br>
    <br>
    <br>
    <footer class="site-footer">
  <div class="footer-container">
    <div class="footer-box about-us">
      <h4>About Us</h4>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      <div class="social-icons">
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-google"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>

    <div class="footer-box">
      <h4>Information</h4>
      <ul>
        <li><a href="#">About us</a></li>
        <li><a href="#">Delivery Information</a></li>
        <li><a href="#">Privacy & Policy</a></li>
        <li><a href="#">Terms & Condition</a></li>
        <li><a href="#">Manufactures</a></li>
      </ul>
    </div>

    <div class="footer-box">
      <h4>My Account</h4>
      <ul>
        <li><a href="#">My Account</a></li>
        <li><a href="#">My Cart</a></li>
        <li><a href="login.html">Login</a></li>
        <li><a href="contactus.html">contact us</a></li>
        <li><a href="#">Checkout</a></li>
      </ul>
    </div>

    <div class="footer-box">
      <h4>Our Service</h4>
      <ul>
        <li><a href="#">My Account</a></li>
        <li><a href="#">My Cart</a></li>
        <li><a href="#">Login</a></li>
        <li><a href="#">Wishlist</a></li>
        <li><a href="#">Checkout</a></li>
      </ul>
    </div>

    <!-- <div class="footer-box newsletter">
      <h4>Newsletter</h4>
      <input type="email" placeholder="Your Mail*" />
      <button type="submit">Send Mail</button>
    </div> -->
  </div>

  <div class="footer-bottom">
    <p>Copyright© <span style="color: #e03e7c;">Anmol Nagpal</span> 2025. All Right Reserved.</p>
    <!-- <div class="payment-icons">
      <img src="img/paypal.png" alt="Paypal">
      <img src="img/visa.png" alt="Visa">
      <img src="img/discover.png" alt="Discover">
      <img src="img/mastercard.png" alt="MasterCard">
      <img src="img/cirrus.png" alt="Cirrus">
      <img src="img/maestro.png" alt="Maestro">
    </div> -->
  </div>
</footer>

</body>
</html>
