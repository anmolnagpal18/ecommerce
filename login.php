<?php
//  Connects to the database
require('connection.inc.php');
// Connects to the faction file
require('functions.inc.php');

//  A variable to store error messages if login fails.
$msg='';
if(isset($_POST['submit'])){

//   <!-- give value safely from user to database-->
	$email=get_safe_value($con,$_POST['email']);
	$password=get_safe_value($con,$_POST['password']);

// Looks for a user in the admin_user table with the entered email and password.
	$sql="select * from admin_user where email='$email' and password='$password'";
 
// Runs the query on the database.
	$res=mysqli_query($con,$sql);

//Counts how many users matched (should be 1 if correct).
	$count=mysqli_num_rows($res);

	if($count>0){
      // Indicates that the admin is logged in.
		$_SESSION['ADMIN_LOGIN']='yes';
      // Saves the admin's email in the session to identify them on other pages.
		$_SESSION['ADMIN_EMAIL']=$email; 

      // if correct it send to this
		header('location:categories.php');
      
      // end task
		die();
	}else{
		$msg="Please enter correct login details";	
	}
	
}
?>
<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Login Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="mainstyle.css">
     
   </head>
   <div class="wrap">
   <body class="bg-dark" >
      <div class="sufee-login d-flex align-content-center flex-wrap">
         <div class="container">
            <div class="login-content">
               <div class="login-form mt-150">
                  <form method="post">
                     <div class="form-group">
                        <label>EMAIL ADDRESS</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                     </div>
                     <br>
                     <div class="form-group">
                        <label>PASSWORD</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                     </div>
                     <br>
                     <button type="submit" name="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
					</form>
					<div class="field_error"><?php echo $msg?></div>
               </div>
            </div>
         </div>
      </div>
      </div>
      
   </body>
</html>