<?php
//  Connect to the database
require('connection.inc.php');
// Connects to the function file
require('functions.inc.php');

$id=1;
if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){
    // Admin is logged in
} else {
    header('location:login.php');
    die();
}

if(isset($_GET['type']) && $_GET['type']!=''){
    $type = get_safe_value($con, $_GET['type']);
    if($type == 'delete'){
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM banner WHERE id='$id'";
        mysqli_query($con, $delete_sql);
    }
    if($type == 'status'){
        $id = get_safe_value($con, $_GET['id']);
        // Toggle the status of the banner
        $status_sql = "SELECT status FROM banner WHERE id='$id'";
        $result = mysqli_query($con, $status_sql);
        $row = mysqli_fetch_assoc($result);
        $new_status = ($row['status'] == 1) ? 0 : 1;
        $update_status_sql = "UPDATE banner SET status='$new_status' WHERE id='$id'";
        mysqli_query($con, $update_status_sql);
    }
}

$sql = "SELECT * FROM banner ORDER BY id DESC";
$res = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banner Master</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="mainstyle.css">
    <style>
        .badge-status {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .badge-delete {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .badge-status:hover, .badge-delete:hover {
            opacity: 0.8;
        }
    </style>
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

    <div class="space"> 
        <h3 class="box-title">Banner Images</h3>
        <h6 class="box-link"><a href="manage_banner.php"><i class="fa-solid fa-file-circle-plus"> Add Banner</i></a></h6>
        
        <table class="table">
            <thead>
                <tr>
                    <th class="serial">#</th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Banner Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 1;
                    while($row = mysqli_fetch_assoc($res)) { ?>
                    <tr>
                        <td class="serial"><?php echo $i ?></td>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['title'] ?></td>
                        <td><?php echo $row['description'] ?></td>
                        <td><img height="120" width="150" src="media/product/<?php echo $row['image']; ?>" alt="Banner Image"/></td>
                        <td>
                            <span class="badge badge-status">
                                <a href="?type=status&id=<?php echo $row['id']; ?>">
                                    <?php echo ($row['status'] == 1) ? 'Active' : 'Inactive'; ?>
                                </a>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-delete"><a href="?type=delete&id=<?php echo $row['id']; ?>">Delete</a></span>
                        </td>
                    </tr>
                    <?php $i++; } ?> 
            </tbody>
        </table>
    </div>
    
    <div class="foot">
        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        Copyright &copy; <?php echo date('Y')?> Anmol Nagpal
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        const offcanvasElementList = document.querySelectorAll('.offcanvas')
        const offcanvasList = [...offcanvasElementList].map(offcanvasEl => new bootstrap.Offcanvas(offcanvasEl))
    </script>
</body>
</html>
