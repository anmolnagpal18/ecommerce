<?php
// Connects to the database
require('connection.inc.php');
// Connects to the functions file
require('functions.inc.php');

$categories = '';
$image = '';
$msg = '';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM categories WHERE id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $categories = $row['categories'];
        $image = $row['image']; // Assuming image column in categories table
    } else {
        header('location:categories.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $categories = get_safe_value($con, $_POST['categories']);
    $res = mysqli_query($con, "SELECT * FROM categories WHERE categories='$categories'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
                // No error
            } else {
                $msg = "Category already exists";
            }
        } else {
            $msg = "Category already exists";
        }
    }

    if ($msg == '') {
        // Image upload logic
        if ($_FILES['image']['name'] != '') {
            $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], 'media/product/' . $image);
        }

        if (isset($_GET['id']) && $_GET['id'] != '') {
            // Update mode
            $update_query = "UPDATE categories SET categories='$categories' ";
            if ($image != '') {
                $update_query .= ", image='$image' ";
            }
            $update_query .= "WHERE id='$id'";
            mysqli_query($con, $update_query);
        } else {
            // Insert mode
            mysqli_query($con, "INSERT INTO categories(categories, status, image) VALUES('$categories', '1', '$image')");
        }
        header('location:categories.php');
        die();
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

 <div class="sufee-login d-flex align-content-center flex-wrap">
     <div class="container">
         <div class="login-content">
             <div class="login-form mt-150">
                 <div class="form-group">
                    <div class="head"><h3><strong>Categories</strong><small>Form</small><h3></div>
                    <br>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="categories" class="form-label">Categories</label>
                            <input type="text" name="categories" class="form-control" id="categories" placeholder="Enter Category Name" required value ="<?php echo $categories ?>">
                        </div>

                        <!-- Image Upload Field -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Category Image</label>
                            <input type="file" name="image" class="form-control" id="image">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    const offcanvasElementList = document.querySelectorAll('.offcanvas')
    const offcanvasList = [...offcanvasElementList].map(offcanvasEl => new bootstrap.Offcanvas(offcanvasEl))
</script>
</body>
</html>
