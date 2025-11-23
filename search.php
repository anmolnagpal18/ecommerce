
<?php
require('top.php');

// Retrieve the search query from the URL parameter and sanitize it
$search_query = isset($_GET['str']) ? mysqli_real_escape_string($con, $_GET['str']) : '';

if (!empty($search_query)) {
    // Fetch products based on the search query
    $get_product = get_product($con, '', '', '', '', $search_query);
} else {
    // Redirect to homepage if no search query is provided
    ?>
    <script>
        window.location.href = 'index.php';
    </script>
    <?php
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    

    <!-- Add FontAwesome link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <!-- <link rel="stylesheet" href="shop.css"> -->

    <style>
        /* Section for product grid */
        
        section{

padding: 0px 0px 40px 0px; ;
}
/* Ensure the body takes the full height of the viewport */
html, body {
height: 100%;
margin: 0;
}

/* Wrapper to stretch content and push footer to the bottom */
body {
display: flex;
flex-direction: column;
}

/* Main content area (everything above the footer) */
main {
flex-grow: 1;
}

footer {
background-color: #333; /* Adjust as needed */
color: #fff;
padding: 20px;
text-align: center;
width: 100%;
position: relative; /* Ensure it's positioned normally */
}

/* Footer container adjustments */
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

        
        

        
    </style>
</head>
<body>

<h2 class="section-heading">Search Results for: <?php echo $search_query; ?></h2>

<?php if(count($get_product) > 0) { ?>
<section class="product-grid-section">
<div class="product-grid">
    <?php
    foreach ($get_product as $list) { ?>
    <!-- Product Item -->
    <div class="product-card slide-up">
        <div class="product-image">
            <a href="pro.php?id=<?php echo $list['id']?>">
                <img src="<?php echo 'media/product/'.$list['image'] ?>" alt="Product">
            </a>
            <ul class="product-icons">
                <li><a href="#"><i class="fa-regular fa-heart"></i></a></li>
                <li>
              <a href="cart.php?action=add&id=<?php echo $list['id']; ?>">
                <i class="fa-solid fa-bag-shopping"></i>
              </a>
            </li>
            </ul>
        </div>
        <div class="product-info">
            <h4><?php echo $list['name'] ?></h4>
            <p><del><?php echo $list['mrp'] ?></del> <span class="price"><?php echo $list['price'] ?></span></p>
        </div>
    </div>
    <?php } ?>
</div>
</section>

<?php } else { ?>
    <div class="no-products">
        <h2>No Products Found</h2>
    </div>
<?php } ?>

<script>
    window.onload = () => {
        const cards = document.querySelectorAll('.product-card');
        cards.forEach(card => {
            card.classList.add('animate');
        });
    };
</script>

<!-- Footer Section (same as the previous code) -->
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
        <li><a href="contactus.html">Contact us</a></li>
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
  </div>
</footer>

</body>
</html>
