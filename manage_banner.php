<?php
// Connect to the database
require('connection.inc.php');
// Connect to the functions file
require('functions.inc.php');

$msg = '';
$image = '';
$title = '';
$description = '';

if (isset($_POST['submit'])) {
    // Get title and description
    $title = get_safe_value($con, $_POST['title']);
    $description = get_safe_value($con, $_POST['description']);

    // Image upload logic
    if ($_FILES['image']['name'] != '') {
        $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
        $upload_path = 'media/product/' . $image;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            // Insert image, title, and description into the banner table
            $insert_query = "INSERT INTO banner (image, title, description, status) VALUES ('$image', '$title', '$description', '1')";
            if (mysqli_query($con, $insert_query)) {
                $msg = "Banner image uploaded successfully.";
            } else {
                $msg = "Failed to insert the banner image into the database.";
            }
        } else {
            $msg = "Image upload failed.";
        }
    } else {
        $msg = "Please select an image to upload.";
    }
}

// Handling delete functionality
if (isset($_GET['type']) && $_GET['type'] == 'delete') {
    $id = get_safe_value($con, $_GET['id']);
    // Fetch image to delete it from the folder
    $result = mysqli_query($con, "SELECT image FROM banner WHERE id='$id'");
    $row = mysqli_fetch_assoc($result);
    $image_to_delete = $row['image'];

    // Delete banner from database
    mysqli_query($con, "DELETE FROM banner WHERE id='$id'");

    // Delete the actual image file from the folder
    unlink('media/product/' . $image_to_delete);

    header('Location: manage_banner.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Banners</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <a class="add" href=""><i class="fa-solid fa-user-shield"> Hello, Admin </i></a>
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

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-form mt-150">
                    <div class="head"><h3><strong>Manage Banners</strong></h3></div>
                    <br>
                    <!-- Form to upload a new banner -->
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter Banner Title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Enter Banner Description" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Banner Image</label>
                            <input type="file" name="image" class="form-control" id="image" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <br>
                    <div class="msg"><?php echo $msg ?></div>
                </div>
            </div>
        </div>
    </div>

  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        const offcanvasElementList = document.querySelectorAll('.offcanvas');
        const offcanvasList = [...offcanvasElementList].map(offcanvasEl => new bootstrap.Offcanvas(offcanvasEl));
    </script>
</body>
</html>
