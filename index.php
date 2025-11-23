<?php 
require('top.php'); // Add the semicolon to properly terminate the statement

// Define the query to select active banners
$query = "SELECT * FROM banner WHERE status = '1' ORDER BY id DESC"; 

// Execute the query (assuming $result is assigned this query result)
$result = mysqli_query($con, $query); 
?>

<!-- Hero section -->
<section class="hero-slider">
  <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <!-- Preload the images for faster loading -->
    <link rel="preload" href="media/product/<?php echo $row['image']; ?>" as="image">

    <div class="slide<?php echo $row['id'] == 1 ? ' active' : ''; ?>" 
         style="background-image: url('media/product/<?php echo $row['image']; ?>');">
      <div class="hero-content">
        <h1><?php echo $row['title']; ?></h1>
        <p><?php echo $row['description']; ?></p>
        <a href="#products" class="cta-btn">Shop Now</a>
      </div>
    </div>
  <?php endwhile; ?>
  
  <div class="slider-controls">
    <span class="prev">&#10094;</span>
    <span class="next">&#10095;</span>
  </div>
</section>


<!-- Categories section -->
<section class="custom-categories">
  <h2 class="section-heading">Categories</h2>
  <?php foreach ($cat_arr as $list) { ?>
    <div class="row row-1">
      <div class="category-box">
        <!-- Dynamically display category image -->
        <img style="height:320px;" src="media/product/<?php echo $list['image']; ?>" alt="Category Image">
        <div class="category-content">
          <h3><?php echo $list['categories']; ?></h3>
          <a href="cat.php?id=<?php echo $list['id']; ?>" class="cta-btn">Shop now</a>
        </div>
      </div>
    </div>
  <?php } ?>
</section>

<!-- New Arrivals Section -->
<h2 class="section-heading">New Arrivals</h2>
<section class="product-grid-section" id="products">
  <div class="product-grid">
    <?php 
    $get_product = get_product($con, 4);
    foreach ($get_product as $list) { ?>
      <div class="product-card slide-up">
        <div class="product-image">
          <a href="pro.php?id=<?php echo $list['id'] ?>">
            <img src="<?php echo 'media/product/' . $list['image'] ?>" alt="Product">
          </a>
        </div>
        <ul class="product-icons">
        <li>
            <a href="wishlist_manage.php?type=add&product_id=<?php echo $list['id']; ?>">
              <i class="fa-regular fa-heart"></i>
            </a>
          </li>
            <a href="cart.php?action=add&id=<?php echo $list['id']; ?>">
              <i class="fa-solid fa-bag-shopping"></i>
            </a>
          </li>
        </ul>
        <div class="product-info">
          <h4><?php echo $list['name'] ?></h4>
          <p><del><?php echo $list['mrp'] ?></del> <span class="price"><?php echo $list['price'] ?></span></p>
        </div>
      </div>
    <?php } ?>
  </div>
</section>


<!-- Best Seller Section -->
<br><br><br>
<h2 class="section-heading">Best Seller</h2>
<section class="product-grid-section" id="products">
  <div class="product-grid">
    <?php 
    $get_product = get_product($con, 4, '', '', '1');
    foreach ($get_product as $list) { ?>
      <div class="product-card slide-up">
        <div class="product-image">
          <a href="pro.php?id=<?php echo $list['id'] ?>">
          <img src="<?php echo 'media/product/' . $list['image'] ?>" alt="Product" style="width: 100%; height: 310px;">
          </a>
        </div>
        <ul class="product-icons">
          <!-- Heart Icon for Adding to Wishlist -->
          <li>
            <a href="wishlist_manage.php?type=add&product_id=<?php echo $list['id']; ?>">
              <i class="fa-regular fa-heart"></i>
            </a>
          </li>
          <li>
            <a href="cart.php?action=add&id=<?php echo $list['id']; ?>">
              <i class="fa-solid fa-bag-shopping"></i>
            </a>
          </li>
        </ul>
        <div class="product-info">
          <h4><?php echo $list['name'] ?></h4>
          <p><del><?php echo $list['mrp'] ?></del> <span class="price"><?php echo $list['price'] ?></span></p>
        </div>
      </div>
    <?php } ?>
  </div>
</section>
<br><br><br>

<?php require('footer.php') ?>
