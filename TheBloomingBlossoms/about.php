<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

<body>
<div class="logo">
            <img src="assets/img/logo.png" style="height: 400px; width:auto;">
            <div class="header">
                <h1>The Blooming Blossoms</h1>
            </div>
        </div>
        <div class="topnav">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact Us</a>
            <a href="cart.php"><i class="fa fa-shopping-cart"></i></a>
            <div class="rightnav">
            <?php
                if (isset($_SESSION['username'])) {
                    // User is logged in
                    $username = $_SESSION['username'];
                    echo "<p class='login-button'>Welcome, $username!  </p>";
                    echo "<a href='logout.php' class='signup-button'>Logout</a>";
                    
                } else {
                    echo "<a href='login.html' class='login-button'>Login</a>";
                    echo "<a href='signup.html' class='signup-button'>Signup</a>";
                }
            ?>
            </div>
          </div>

    <div class="row">
        <div class="leftcolumn">
            <div style="margin: 20px;">

                <h1 style="padding-right: 20px ;">Who we are?</h1>
                <p style="text-align: justify;">
                Welcome to The Blooming Blossoms - an online ordering and door-to-door flowers delivery service that brings beauty and happiness to your doorstep.

At The Blooming Blossoms, we believe that flowers have the power to brighten up your day and express your deepest emotions. That's why we offer a wide selection of high-quality flowers that are perfect for any occasion. Whether you want to surprise your loved ones, celebrate a special event, or simply brighten up your living space, we have got you covered.

Our easy-to-use website allows you to create an account and log in to order one or more products from our extensive collection of fresh flowers. From classic roses to exotic orchids, our inventory is updated regularly to ensure that you always get the best and most vibrant flowers available.

To make your experience as seamless as possible, we offer door-to-door delivery service straight to your doorstep. With our reliable delivery system, you can rest assured that your flowers will arrive fresh and in pristine condition. Plus, you can conveniently pay for your order online through our secure payment system.

Our team at The Blooming Blossoms is dedicated to providing our customers with exceptional service and the highest quality flowers available. Whether you need a last-minute gift or a regular flower delivery, we are here to help you make your loved ones feel special and appreciated.

Thank you for choosing The Blooming Blossoms for your flower needs. We look forward to serving you!
                </p>
            </div>

        </div>
    </div>

    <div class="footer">
        <div>
            <p>

                The Blooming Blossoms LLC.
                10 Colinton Rd
                Edinburgh
                Eh10 5DT
                Phone Toll Free: 800-222-8188
            </p>
            <p>
                Hours of Operation
                Mon-Fri 9:00am-5:30pm
                Saturday 9:00am-5:00pm
            </p>
        </div>
        <div>
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact Us</a>

        </div>

    </div>
</body>

</html>