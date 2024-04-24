<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

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

// Get the action and product_id from the request
$action = $_GET['action'];
$product_id = $_GET['product_id'];

// Check if the product_id is valid
$result = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id");
if (mysqli_num_rows($result) == 0) {
  die("Invalid product ID");
}

// Retrieve user_id from users table
$result = mysqli_query($conn, "SELECT user_id FROM users WHERE username='$username'");
$row = mysqli_fetch_assoc($result);
$user_id = $row['user_id'];

// Get the current quantity of the product in the cart
$result = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id");
if (mysqli_num_rows($result) == 0) {
  die("Product is not in cart");
}
$row = mysqli_fetch_assoc($result);
$current_quantity = $row['quantity'];

// Update the quantity based on the action
if ($action == "remove") {
  $new_quantity = max(0, $current_quantity - 1);
} elseif ($action == "add") {
  $new_quantity = $current_quantity + 1;
} else {
  die("Invalid action");
}

// Update the quantity in the cart table
if ($new_quantity == 0) {
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id");
    } else {
      mysqli_query($conn, "UPDATE cart SET quantity = $new_quantity WHERE user_id = $user_id AND product_id = $product_id");
    }

mysqli_close($conn);

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>
