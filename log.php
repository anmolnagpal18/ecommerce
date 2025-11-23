<?php
require('top.php');
// require('functions.inc.php');
// session_start();

$msg = '';

// Redirect if already logged in
if (isset($_SESSION['USER_ID'])) {
    header("Location: index.php");
    exit;
}

// Registration logic
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $addedon = date('Y-m-d H:i:s');

    $check_user = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check_user) > 0) {
        $msg = "Email already registered";
    } else {
        $query = "INSERT INTO users(name, email, mobile, password, addedon) VALUES('$name', '$email', '$mobile', '$hashed_password', '$addedon')";
        if (mysqli_query($con, $query)) {
            $user_id = mysqli_insert_id($con);
            $_SESSION['USER_ID'] = $user_id;
            $_SESSION['USER_NAME'] = $name;
            header("Location: index.php");
            exit;
        } else {
            $msg = "Error: " . mysqli_error($con);
        }
    }
}

// Login logic
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    $res = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        if (password_verify($password, $row['password'])) {
            $_SESSION['USER_ID'] = $row['id'];
            $_SESSION['USER_NAME'] = $row['name'];
            header("Location: index.php");
            exit;
        } else {
            $msg = "Incorrect password";
        }
    } else {
        $msg = "User not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login / Registration</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #f8f8f8;
    }

    .wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      width: 100%;
      max-width: 1000px;
      background: white;
      display: flex;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      flex-wrap: wrap;
    }

    .image-side {
      flex: 1;
      background: url('logo.png') center/contain no-repeat;
      min-height: 400px;
      
    }

    .form-side {
      flex: 1;
      padding: 40px;
      min-width: 300px;
    }

    .form-side h2 {
      text-align: center;
      font-size: 30px;
      margin-bottom: 10px;
      font-weight: 700;
      color: #0b0b0b;
    }

    .form-side p {
      text-align: center;
      margin-bottom: 20px;
      color: #555;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 15px;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 7px;
      outline: none;
    }

    .options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    .btn {
      width: 100%;
      background: black;
      color: white;
      padding: 12px;
      border: none;
      font-size: 16px;
      border-radius: 7px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .btn:hover {
      background: #222;
    }

    .bottom-text {
      text-align: center;
      margin-top: 20px;
    }

    .bottom-text a {
      color: #000;
      font-weight: bold;
      text-decoration: none;
    }

    .bottom-text a:hover {
      text-decoration: underline;
    }

    .message {
      text-align: center;
      margin-bottom: 15px;
      color: red;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .image-side {
        width: 100%;
        height: 250px;
        min-height: 250px;
      }

      .form-side {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
<div class="wrapper">
  <div class="container" id="form-container">
    <div class="image-side"></div>

    <!-- Login Form -->
    <div class="form-side" id="login-form" style="<?php if (isset($_POST['register'])) echo 'display:none;'; ?>">
      <h2>Satguru Handloom</h2>
      <p>Welcome back</p>
      <?php if ($msg && isset($_POST['login'])) echo "<div class='message'>$msg</div>"; ?>
      <form method="POST">
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" placeholder="Enter your email" required />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required />
        </div>
        <!-- <div class="options">
          <label><input type="checkbox" /> Remember me</label>
          <a href="#">Forgot password?</a>
        </div> -->
        <button class="btn" type="submit" name="login">Sign In</button>
      </form>
      <div class="bottom-text">
        Don't have an account? <a href="#" onclick="toggleForm()" class="hover:text-blue-500">Sign Up</a>
      </div>

      <div class="bottom-text ">
        Log in to your admin account <a href="login.php" class="hover:text-blue-500">Admin</a>
      </div>
    </div>

    <!-- Registration Form -->
    <div class="form-side" id="register-form" style="<?php if (!isset($_POST['register'])) echo 'display:none;'; ?>">
      <h2>Satguru Handloom</h2>
      <p>Create your account</p>
      <?php if ($msg && isset($_POST['register'])) echo "<div class='message'>$msg</div>"; ?>
      <form method="POST">
        <div class="form-group">
          <label>Username</label>
          <input type="text" pattern="[A-Za-z\s]+" name="username" placeholder="Enter username" required />
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" placeholder="Enter your email" required />
        </div>
        <div class="form-group">
          <label>Phone Number</label>
          <input type="tel" name="mobile" placeholder="Enter phone number" required />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter password" required />
        </div>
        <button class="btn" type="submit" name="register">Register</button>
      </form>
      <div class="bottom-text">
        Already have an account? <a href="#" onclick="toggleForm()">Sign In</a>
      </div>

      <div class="bottom-text ">
        Log in to your admin account <a href="login.php" class="hover:text-blue-500">Admin</a>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleForm() {
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");

    if (loginForm.style.display === "none") {
      loginForm.style.display = "block";
      registerForm.style.display = "none";
    } else {
      loginForm.style.display = "none";
      registerForm.style.display = "block";
    }
  }
</script>
<?php require('footer.php'); ?>
</body>
</html>
