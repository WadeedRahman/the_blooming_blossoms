<?php
session_start();

  //Receiving and Storing vslues of hidden fields 
  $order_date = date("Y-m-d H:i:s");
  $cart_items = json_decode($_POST['cart_items'], true);
  $order_total_items = $_POST['cart_total_items'];
  $order_total_price = $_POST['cart_total_price'];

  //if total_price is zero then cart is empty, alert user and redirect back to cart.php
  if($order_total_price==0)
  {
    echo "<script>alert('Cart is Empty!');  window.location = 'cart.php';</script>";
  }

  $username = $_SESSION['username'];
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

  // Retrieve user_id from users table
  $result = mysqli_query($conn, "SELECT user_id FROM users WHERE username='$username'");
  $row = mysqli_fetch_assoc($result);
  $user_id = $row['user_id'];

  // Insert a new row into the orders table
  $insert_order_query = "INSERT INTO orders (user_id, order_date, total_items, total_price) VALUES ('$user_id', '$order_date', '$order_total_items', '$order_total_price')";
  mysqli_query($conn, $insert_order_query);
  $order_id = mysqli_insert_id($conn);

  // Insert a new row into the order_items table for each item in the cart
  foreach ($cart_items as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $price = $item['price'];

    $insert_order_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$product_id', '$quantity', '$price')";
    mysqli_query($conn, $insert_order_item_query);

  }

  // Clear the cart
  $clear_cart_query = "DELETE FROM cart WHERE user_id = $user_id";
  mysqli_query($conn, $clear_cart_query);

  mysqli_close($conn);

  //tell user that order has been placed and then redirect to cart.php
  echo "<script>alert('Your Order has been Placed.');  window.location = 'cart.php';</script>";
  exit();
?>
