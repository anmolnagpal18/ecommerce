<?php require('top.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us</title>
  <style>
    /* * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background-color: #f3f3f3;
      display: flex;
      align-items: center;
      justify-content: center;
    } */

    .container {
      width: 100%;
      max-width: 900px;
      padding: 20px;
    }

    .card {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 32px;
      color: #333;
    }

    h2 {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #333;
    }

    form {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .form-group {
      flex: 1 1 100%;
    }

    .form-row {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      width: 100%;
    }

    .form-row .form-group {
      flex: 1;
      min-width: 220px;
    }

    input,
    textarea {
      width: 100%;
      padding: 14px;
      border: none;
      background-color: #f5f5f5;
      font-size: 14px;
      color: #333;
      border-radius: 4px;
    }

    textarea {
      resize: vertical;
      min-height: 150px;
    }

    button {
      background-color: #c0395a;
      color: white;
      padding: 12px 24px;
      font-size: 14px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #a0304a;
    }

    @media (max-width: 768px) {
      .form-row {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
<center>
  <div class="container">
    <div class="card">
      <h1>Contact Us</h1>
      <h2>SEND A MAIL</h2>
      <form action="#" method="POST">
        <div class="form-row">
          <div class="form-group">
            <input type="text" name="name" placeholder="Your Name*" required>
          </div>
          <div class="form-group">
            <input type="email" name="email" placeholder="Mail*" required>
          </div>
        </div>

        <div class="form-group">
          <input type="number" name="number" placeholder="phone no." required>
        </div>

        <div class="form-group">
          <textarea name="message" placeholder="Your Message" required></textarea>
        </div>

        <button type="submit">SEND MESSAGE</button>
      </form>
    </div>
  </div>
  </center>
  <?php
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "shopwebsite");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Set the time zone to India Standard Time (IST)
  date_default_timezone_set('Asia/Kolkata');

  // Get and sanitize form data
  $name = mysqli_real_escape_string($con, $_POST['name']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $mobile = mysqli_real_escape_string($con, $_POST['number']);
  $comment = mysqli_real_escape_string($con, $_POST['message']);
  $addedon = date('Y-m-d h:i:s A'); // Get current date and time in IST

  // Insert into the 'contactus' table with time
  $query = "INSERT INTO contactus (name, email, mobile, comment, addedon) 
            VALUES ('$name', '$email', '$mobile', '$comment', '$addedon')";

  if (mysqli_query($con, $query)) {
      echo "<script>alert('Message sent successfully!');</script>";
  } else {
      echo "<script>alert('Error sending message. Please try again.');</script>";
  }
}

?>

  <?php require('footer.php')?>

</body>
</html>
