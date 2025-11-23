<?php
//  Connects to the database
require('connection.inc.php');
// Connects to the faction file
require('functions.inc.php');
$id=1;
if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){

}
else{
  header('location:login.php');
  die();
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

<?php

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	if($type=='status'){
		$operation=get_safe_value($con,$_GET['operation']);
		$id=get_safe_value($con,$_GET['id']);
		if($operation=='active'){
			$status='1';
		}else{
			$status='0';
		}
		$update_status_sql="update product set status='$status' where id='$id'";
		mysqli_query($con,$update_status_sql);
	}
	
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from product where id='$id'";
		mysqli_query($con,$delete_sql);
	}
}

$sql="select product.*,categories.categories from product,categories where product.categories_id=categories.id order by product.id desc";
$res=mysqli_query($con,$sql);
?>
           <div class="space"> 
				   <h3 class="box-title">Products </h3>
				   <h6 class="box-link"><a href="manage_product.php"><i class="fa-solid fa-file-circle-plus"> Add Product</i></a> </h6>
				
					  <table class="table ">
						 <thead>
							<tr>
							   <th class="serial">#</th>
							   <th>ID</th>
							   <th>Categories</th>
							   <th>Name</th>
                 <th>Image</th>
                 <th>MRP</th>
                 <th>Price</th>
                 <th>QTY</th>
                 <th></th>
							</tr>
						 </thead>
						 <tbody>
						<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){?>
							<tr>
							   <td class="serial"><?php echo $i?></td>
							   <td><?php echo $row['id']?></td>
							   <td><?php echo $row['categories']?></td>
                 <td><?php echo $row['name']?></td>
                 <td><img height="70" width="70" src="media/product/<?php echo $row['image']?>"/></td>
                 <td><?php echo $row['mrp']?></td>
                 <td><?php echo $row['price']?></td>
                 <td><?php echo $row['qty']?></td>
							   <td>
								<?php
								if($row['status']==1){
									echo "<span id='badgea' class='badge badge-complete'><a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a></span>&nbsp;";
								}else{
									echo "<span id='badgede' class='badge badge-pending'><a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a></span>&nbsp;";
								}
								echo "<span id='badgee' class='badge badge-edit'><a href='manage_product.php?id=".$row['id']."'>Edit</a></span>&nbsp;";
								
								echo "<span id='badgede' class='badge badge-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></span>";
								
								?>
							   </td>
							</tr>
							<?php $i++; } ?> 
						 </tbody>
					  </table>
          </div>
          
          
<div class="foot">
<div class="clearfix"></div>
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
</div>
</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        const offcanvasElementList = document.querySelectorAll('.offcanvas')
        const offcanvasList = [...offcanvasElementList].map(offcanvasEl => new bootstrap.Offcanvas(offcanvasEl))
    </script>
</body>
</html>