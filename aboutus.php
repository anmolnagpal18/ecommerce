<?php require('top.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <style>
    /* * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      background-color: #f9f9f9;
      padding: 40px 20px;
    } */

    .container {
      max-width: 1100px;
      margin: auto;
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      align-items: flex-start;
      justify-content: center;
    }

    .map-container {
      flex: 1 1 450px;
      min-height: 350px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    iframe {
      width: 100%;
      height: 100%;
      border: none;
    }

    .contact-info {
      flex: 1 1 350px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .info-box {
      display: flex;
      align-items: center;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .info-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .info-icon {
      background-color: #c2185b;
      color: white;
      font-size: 20px;
      padding: 15px;
      border-radius: 50%;
      margin-right: 20px;
    }

    .info-text h4 {
      font-size: 16px;
      color: #333;
      margin-bottom: 5px;
    }

    .info-text p {
      font-size: 14px;
      color: #666;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #222;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <br>
  

  <h2 class="section-heading">About Us</h2>
  <div class="container">
    <!-- Google Map -->
    <!-- <div class="map-container"> -->
      <!-- Replace with your API key or embed code -->
      <!-- <iframe  -->
        <!-- src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.887498045143!2d90.38814571445773!3d23.750876384589778!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b89955555555%3A0x1234567890abcdef!2sDhaka%20City!5e0!3m2!1sen!2sbd!4v1713368000000" -->
        <!-- allowfullscreen="" -->
        <!-- loading="lazy" -->
        <!-- referrerpolicy="no-referrer-when-downgrade"> -->
      <!-- </iframe> -->
    <!-- </div> -->


    <div class="contact-info">
    <h3 class="section-heading">branch 1</h3>
      <div class="info-box">
        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
        <div class="info-text">
          <h4>OUR ADDRESS</h4>
          <p>666 5th Ave, New York, NY, United States</p>
        </div>
      </div>

      <div class="info-box">
        <div class="info-icon"><i class="fas fa-envelope"></i></div>
        <div class="info-text">
          <h4>OPENING HOURS</h4>
          <p>Mon - Fri: 9:00 AM - 6:00 PM</p>
        </div>
      </div>

      <div class="info-box">
        <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
        <div class="info-text">
          <h4>PHONE NUMBER</h4>
          <p>+1 123-456-7890</p>
        </div>
      </div>
    </div>
    <!-- Contact Info -->
    <div class="contact-info">
    <h3 class="section-heading">branch 2</h3>
      <div class="info-box">
        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
        <div class="info-text">
          <h4>OUR ADDRESS</h4>
          <p>666 5th Ave, New York, NY, United States</p>
        </div>
      </div>

      <div class="info-box">
        <div class="info-icon"><i class="fas fa-envelope"></i></div>
        <div class="info-text">
          <h4>OPENING HOURS</h4>
          <p>Mon - Fri: 9:00 AM - 6:00 PM</p>
        </div>
      </div>

      <div class="info-box">
        <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
        <div class="info-text">
          <h4>PHONE NUMBER</h4>
          <p>+1 123-456-7890</p>
        </div>
      </div>
    </div>
  </div>
  <br>
  <br>
  <br>

  <?php require('footer.php')?>
</body>
</html>
