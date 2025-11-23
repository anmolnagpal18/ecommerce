
<?php 
require('top.php');
if(isset($_GET['id'])){
	$product_id=mysqli_real_escape_string($con,$_GET['id']);
	if($product_id>0){
		$get_product=get_product($con,'','',$product_id);
    // prx($get_product);
	}else{
		?>
		<script>
		window.location.href='index.php';
		</script>
		<?php
	}
}else{
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Classic White Oversized Shirt</title>
  <style>
    /* * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fff;
      color: #333;
      padding: 20px;
    } */

    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      max-width: 1200px;
      margin: auto;
      margin-top:0; 
    }

    .product-gallery {
      flex: 1;
      min-width: 300px;
      position: relative;
    }

    .slider {
      position: relative;
      border-radius: 12px;
      overflow: hidden;
      max-width: 500px;
    }

    .slide {
  display: none;
  width: 100%;
  height: auto;
}

.slide.active {
  display: block;
}


    .nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background-color: rgba(0, 0, 0, 0.6);
      color: #fff;
      border: none;
      padding: 8px 12px;
      cursor: pointer;
      font-size: 18px;
      border-radius: 50%;
      z-index: 2;
    }

    .prev {
      left: 10px;
    }

    .next {
      right: 10px;
    }

    .dots {
      text-align: center;
      margin-top: 10px;
    }

    .dot {
      height: 10px;
      width: 10px;
      background-color: #ccc;
      border-radius: 50%;
      display: inline-block;
      margin: 0 4px;
      cursor: pointer;
    }

    .dot.active {
      background-color: #333;
    }

    .product-details {
      flex: 1;
      min-width: 300px;
    }

    .price {
      font-size: 24px;
      color: #555;
      margin: 10px 0;
    }

    .description {
      margin-bottom: 20px;
      color: #666;
      padding: 40px 20px;
      font-size: 20px;
      line-height: 1.5;
    }

    .sizes button {
      margin: 5px;
      padding: 10px 14px;
      border: 1px solid #ccc;
      background-color: #fff;
      cursor: pointer;
      border-radius: 8px;
      font-weight: bold;
    }

    .sizes button:hover {
      background-color: #f0f0f0;
    }

    .colors {
      margin: 10px 0 20px;
    }

    .color-sample {
      width: 30px;
      height: 30px;
      border: 2px solid #ccc;
      border-radius: 50%;
      display: inline-block;
      margin-right: 10px;
    }

    .white {
      background-color: #fff;
    }

    .add-to-cart {
      width: 100%;
      padding: 15px;
      background-color: #7f838c;
      color: white;
      border: none;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 15px;
    }

    .add-to-cart:hover {
      background-color: #5f626a;
    }

    .extra-options {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 20px;
    }

    .quantity-selector input {
      width: 60px;
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      text-align: center;
    }

    .wishlist-btn {
      background: none;
      border: none;
      font-size: 22px;
      cursor: pointer;
      color: #d22;
    }

    .wishlist-btn:hover {
      color: #a00;
    }


    /* Make sure slides are not hidden by default */
.slide {
  display: none;
  width: 100%;
  height: auto;
}

.slide.active {
  display: block;
}

/* Optional: styling for the dots */
.dot {
  height: 10px;
  width: 10px;
  background-color: #ccc;
  border-radius: 50%;
  display: inline-block;
  margin: 0 4px;
  cursor: pointer;
}

.image-gallery {
            text-align: center;
            margin-top: 20px;
            object-fit: cover;
        }

.image-gallery img {
            width: 500px;
            height: 500px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }
    
        .main-image {
            width: 80%;
            height: 60%;
            border-radius: 10px;
            transition: opacity 0.5s ease-in-out;
            /* border: 2px solid #ccc; */
        }
        .thumbnails {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            /* border: 1px solid #ccc; */
        }
    
        .thumbnails img {
            width: 60px;
            height: 40px;
            margin: 5px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: transform 0.3s ease;
            object-fit: cover;
        }
    
        .thumbnails img:hover {
            transform: scale(1.1);
            border-color: #4CAF50;
        }

.dot.active {
  background-color: #333;
}




  </style>
</head>
<body>
  <br>
  <br>
  <br>
  <div class="box m-4">
  <div class="container">
    <!-- Image Slider -->
    <div class="product-gallery">
    <div class="slider">
    <div class="image-gallery">
        <img src="<?php echo 'media/product/'.$get_product['0']['image'] ?>" alt="image" id="mainImage" class="main-image">
    
        <div class="thumbnails">
            <img src="<?php echo 'media/product/'.$get_product['0']['image1'] ?>" alt="image" class="thumbnail" onclick="changeImage(this)">
            <img src="<?php echo 'media/product/'.$get_product['0']['image2'] ?>" alt="image" class="thumbnail" onclick="changeImage(this)">
            <img src="<?php echo 'media/product/'.$get_product['0']['image'] ?>" onclick="changeImage(this)">
        </div>
    </div>
</div>


    </div>

    <!-- Product Details -->
    <div class="product-details">
      <h1 class="font-bold text-black text-3xl"><?php echo $get_product['0']['name'] ?></h1>
      <p class="price"><del><?php echo $get_product['0']['mrp'] ?></del>  <?php echo $get_product['0']['price'] ?></p>
      <p class="description">
        <?php echo $get_product['0']['short_desc'] ?>
      </p>

      <!-- <h3>Select Size</h3>
      <div class="sizes">
        <button class="size">XS</button>
        <button class="size">S</button>
        <button class="size">M</button>
        <button class="size">L</button>
        <button class="size">XL</button>
      </div> -->

      <!-- <h3>Select Color</h3>
      <div class="colors">
        <span class="color-sample white"></span>
      </div> -->

      <div class="extra-options">
        <div class="quantity-selector">
          <label for="quantity" id="qty">Qty:</label>
          <input type="number" id="quantity" value="1" min="1" />
        </div>
        <!-- <button class="wishlist-btn" title="Add to Wishlist">❤️</button> -->
        
            <a href="wishlist_manage.php?type=add&product_id=<?php echo $list['id']; ?>">
              <i class="fa-regular fa-heart"></i>
            </a>
          
      </div>
      <button class="add-to-cart" onclick="manage_cart('<?php echo $get_product[0]['id'] ?>', 'add')">
    🛒 Add to Cart
</button>

      
      
    </div>
    
  </div>
  <br>
  <br>


  <p class="description text-base md:text-lg lg:text-xl xl:text-2xl leading-relaxed px-4 md:px-8 overflow-hidden text-ellipsis whitespace-wrap break-words">
    <?php echo $get_product['0']['description'] ?>
</p>


    
  <br>
  <br>
  <br>
  </div>
  <!-- JavaScript -->
   
  <script>
    function changeImage(img) {
            const mainImage = document.getElementById("mainImage");
            mainImage.src = img.src;
        }


  </script>
  <?php
require('footer.php');
?>
</body>
</html>
