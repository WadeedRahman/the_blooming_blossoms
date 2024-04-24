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
        <?php
    // Replace with your database credentials
    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'the_blooming_blossoms';

    // Create a database connection
    $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

    // Check for connection errors
    if (mysqli_connect_errno()) {
        die('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    // Query the products table
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);

    // Loop through the results and display each item
    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        // Display the item in a card
        echo '<div class="card">';
        echo '<img src="' . $row['image_path'] . '" alt="' . $row['name'] . '" style="width:100%; height:200px;">';
        echo '<h1 style="white-space: nowrap;">' . $row['name'] . '</h1>';
        echo '<p class="price">£' . $row['price'] . '</p>';
        echo '<p>' . $row['description'] . '</p>';
        
        if (isset($_SESSION['username'])) {
            // User is logged in
            echo '<form action="cart.php" method="post">
            <input type="hidden" name="id" value="' . $row['product_id'] . '">
            <input type="submit" name="add_to_cart" value="Add to Cart">
            </form>';
        } else {
            // User is not logged in
            echo '<button class="addtocart-button">';
            echo '<p>Log-in to Add to Cart</p>';
            echo '</button>';
        }
        
        echo '</div>';
    }

    // Close the database connection
    mysqli_close($conn);
?>

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
