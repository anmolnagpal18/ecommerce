<?php
require('connection.inc.php');
require('functions.inc.php');

$categories_id = '';
$name = '';
$mrp = '';
$price = '';
$qty = '';
$image = '';
$image1 = '';
$image2 = '';
$short_desc = '';
$description = '';
$meta_title = '';
$meta_desc = '';
$meta_keyword = '';
$best_seller = '';

$msg = '';
$image_required = 'required';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM product WHERE id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $categories_id = $row['categories_id'];
        $name = $row['name'];
        $mrp = $row['mrp'];
        $price = $row['price'];
        $qty = $row['qty'];
        $short_desc = $row['short_desc'];
        $description = $row['description'];
        $meta_title = $row['meta_title'];
        $meta_desc = $row['meta_desc'];
        $meta_keyword = $row['meta_keyword'];
        $best_seller =$row['best_seller'];
    } else {
        header('location:product.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $categories_id = get_safe_value($con, $_POST['categories_id']);
    $name = get_safe_value($con, $_POST['name']);
    $mrp = get_safe_value($con, $_POST['mrp']);
    $price = get_safe_value($con, $_POST['price']);
    $qty = get_safe_value($con, $_POST['qty']);
    $short_desc = get_safe_value($con, $_POST['short_desc']);
    $description = get_safe_value($con, $_POST['description']);
    $meta_title = get_safe_value($con, $_POST['meta_title']);
    $meta_desc = get_safe_value($con, $_POST['meta_desc']);
    $meta_keyword = get_safe_value($con, $_POST['meta_keyword']);
    $best_seller = get_safe_value($con, $_POST['best_seller']);

    $res = mysqli_query($con, "SELECT * FROM product WHERE name='$name'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $getData = mysqli_fetch_assoc($res);
        if (!isset($_GET['id']) || $getData['id'] != $id) {
            $msg = "Product already exists";
        }
    }

    if ($msg == '') {
        $type_valid = true;

        // Check image type if files are uploaded
        foreach (['image', 'image1', 'image2'] as $imgKey) {
            if ($_FILES[$imgKey]['name'] != '') {
                $type = $_FILES[$imgKey]['type'];
                if (!in_array($type, ['image/png', 'image/jpg', 'image/jpeg'])) {
                    $msg = "Please select only png, jpg, or jpeg format for $imgKey.";
                    $type_valid = false;
                }
            }
        }

        if ($type_valid) {
            if (isset($_GET['id']) && $_GET['id'] != '') {
                // Update mode
                $update_fields = "categories_id='$categories_id', name='$name', mrp='$mrp', price='$price', qty='$qty', short_desc='$short_desc', description='$description', meta_title='$meta_title', meta_desc='$meta_desc',best_seller='$best_seller', meta_keyword='$meta_keyword'";

                foreach (['image', 'image1', 'image2'] as $imgKey) {
                    if ($_FILES[$imgKey]['name'] != '') {
                        $imgName = rand(111111111, 999999999) . '_' . $_FILES[$imgKey]['name'];
                        move_uploaded_file($_FILES[$imgKey]['tmp_name'], 'media/product/' . $imgName);
                        $update_fields .= ", $imgKey='$imgName'";
                    }
                }

                mysqli_query($con, "UPDATE product SET $update_fields WHERE id='$id'");
            } else {
                // Insert mode
                $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                $image1 = rand(111111111, 999999999) . '_' . $_FILES['image1']['name'];
                $image2 = rand(111111111, 999999999) . '_' . $_FILES['image2']['name'];

                move_uploaded_file($_FILES['image']['tmp_name'], 'media/product/' . $image);
                move_uploaded_file($_FILES['image1']['tmp_name'], 'media/product/' . $image1);
                move_uploaded_file($_FILES['image2']['tmp_name'], 'media/product/' . $image2);

                mysqli_query($con, "INSERT INTO product(categories_id, name, mrp, price, qty, short_desc, description, meta_title, meta_desc, meta_keyword, status, image, image1, image2,best_seller) VALUES('$categories_id', '$name', '$mrp', '$price', '$qty', '$short_desc', '$description', '$meta_title', '$meta_desc', '$meta_keyword', 1, '$image', '$image1', '$image2','$best_seller')");
            }
            header('location:product.php');
            die();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="mainstyle.css">
</head>
<body>
  <div class="wrap">
<section class="body">
 
 <nav class="navbar bg-body-tertiary">
   <div class="container-fluid">
   <img src="logo.png" height="69px" alt="Satguru Handloom" id="logo">
     <form class="d-flex" role="search">
       
       <a class="add" href=""><i class="fa-solid fa-user-shield"> H e l l o , A d m i n  </i></a>
       <button class="bar" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
             <i class="fa-solid fa-bars"></i>
           </button>
     </form>
   </div>
 </nav>
     
 
       <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
         <div class="offcanvas-header">
           <h4 class="offcanvas-title" id="staticBackdropLabel">MENU</h4>
           <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
         </div>
         
         <div class="offcanvas-body">
           <div>
           </button>
             <ul >
               <li><a class="menu" href="categories.php">Categories Master</a></li>
               <li><a class="menu" href="product.php">Product Master</a></li>
               <li><a class="menu" href="order.php">Order Master</a></li>
               <li><a class="menu" href="Banner.php">Banner Master</a></li>
               <li><a class="menu" href="user.php">User Master</a></li>
               <li><a class="menu" href="contactus.php">Contact Us</a></li>
               <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-right-from-bracket"> L o g o u t</i></a></li>
             </ul>
           </div>
         </div>
 </section>
 <div class="down">
 <div class="sufee-login d-flex align-content-center flex-wrap">
         <div class="container">
            <div class="login-content">
               <div class="login-form mt-150">
                     <div class="form-group">
  
<div class="head"><h3><strong>Product</strong><small>Form</small><h3></div>
<br>

<form method="post" enctype="multipart/form-data">

  <div class="mb-3">
    <label for="categories" class="form-label">Categories</label>
    <select class="form-control" name="categories_id" id="">
      <option>select categories</option>
      <?php
      $res=mysqli_query($con,"select id,categories from categories order by categories asc");
      while($row=mysqli_fetch_assoc($res)){
        if($row['id']==$categories_id){
          echo "<option selected value=".$row['id'].">".$row['categories']."</option>";
        }else{
          echo "<option value=".$row['id'].">".$row['categories']."</option>";
        }
      }
			?>

    </select>
  </div>

  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Product Name" required value="<?php echo $name ?>">
  </div>

  <div class="mb-3">
    <label for="categories" class="form-label">Best Seller</label>
    <select class="form-control" name="best_seller" required >
      <option value=''>select</option>
      <?php
      if($best_seller == 1){
        echo '<option selected value="1">Yes</option>
              <option value="0">No</option>';
      }elseif($best_seller == 0){
        echo '<option value="1">Yes</option>
              <option selected value="0">No</option>';
      }else{
        echo '<option value="1">Yes</option>
              <option value="0">No</option>';
      }
        ?>
        
      
      
			

    </select>
  </div>

  

  <div class="mb-3">
    <label for="mrp" class="form-label">Mrp</label>
    <input type="number" name="mrp" class="form-control" id="mrp" placeholder="Enter Mrp" required value="<?php echo $mrp ?>">
  </div>

  <div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input type="number" name="price" class="form-control" id="price" placeholder="Enter Price" required value="<?php echo $price ?>">
  </div>

  <div class="mb-3">
    <label for="qty" class="form-label">Qty</label>
    <input type="number" name="qty" class="form-control" id="qty" placeholder="Enter qty" required value="<?php echo $qty ?>">
  </div>

  <div class="mb-3">
    <label for="image" class="form-label">Image</label>
    <input type="file" name="image" class="form-control" id="image" placeholder="Enter Product Image" <?php echo $image_required ?>>
  </div>

  <div class="mb-3">
    <label for="image1" class="form-label">Image1</label>
    <input type="file" name="image1" class="form-control" id="image1" placeholder="Enter Product Image" <?php echo $image_required ?>>
  </div>

  <div class="mb-3">
    <label for="image2" class="form-label">Image2</label>
    <input type="file" name="image2" class="form-control" id="image2" placeholder="Enter Product Image" <?php echo $image_required ?>>
  </div>

  <div class="mb-3">
    <label for="short_desc" class="form-label">Short Description</label>
    <textarea name="short_desc" class="form-control" id="short_desc" placeholder="Enter Short Description" required><?php echo $short_desc ?></textarea>
  </div>

  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" class="form-control" id="description" placeholder="Enter Description" required><?php echo $description ?></textarea>
  </div>

  <div class="mb-3">
    <label for="meta_title" class="form-label">Meta Title</label>
    <textarea name="meta_title" class="form-control" id="meta_title" placeholder="Enter Meta Title"><?php echo $meta_title ?></textarea>
  </div>

  <div class="mb-3">
    <label for="meta_desc" class="form-label">Meta Description</label>
    <textarea name="meta_desc" class="form-control" id="meta_desc" placeholder="Enter Meta Description" ><?php echo $meta_desc ?></textarea>
  </div>

  <div class="mb-3">
    <label for="meta_keyword" class="form-label">Meta Keyword</label>
    <textarea name="meta_keyword" class="form-control" id="meta_keyword" placeholder="Enter Meta Keyword" ><?php echo $meta_keyword ?></textarea>
  </div>

  <button type="submit" value="submit" name="submit" class="btn btn-primary">Submit</button>

  <br>
  <div class="msg"><?php echo $msg ?></div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        const offcanvasElementList = document.querySelectorAll('.offcanvas')
        const offcanvasList = [...offcanvasElementList].map(offcanvasEl => new bootstrap.Offcanvas(offcanvasEl))
    </script>
</body>
</html>