<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // User is logged in
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

    if (isset($_POST['add_to_cart'])) {
      // The user accessed the cart.php page via the "Add to Cart" button on index.php
      $product_id = $_POST['id'];
      // Check if there's an existing row with the same user ID and product ID
      $result = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id");
      if (mysqli_num_rows($result) > 0) {
        // if the row already exists, update the quantity column by 1
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id");
      } else {
        // if the row does not exist, insert a new row with quantity as 1
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)");
      }
    }
    else {
      // The user accessed the cart.php page directly
      // Handle the error or redirect the user to index.php
    }

    // Check if user_id exists in checkout_details table
  $result = mysqli_query($conn, "SELECT * FROM checkout_details WHERE user_id='$user_id'");
  if (mysqli_num_rows($result) > 0) {
    // Retrieve data from checkout_details table
    $userExists= true;
    $row = mysqli_fetch_assoc($result);
    $full_name = $row['full_name'];
    $email = $row['email'];
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
    $zip = $row['zip'];
    $card_name = $row['card_name'];
    $card_number = $row['card_number'];
    $exp_month = $row['exp_month'];
    $exp_year = $row['exp_year'];
    $cvv = $row['cvv'];
    $same_address = $row['same_address'];
    $button_text = 'Continue to checkout';
  } else {
    // Use default placeholder values
    $userExists= false;
    $full_name = '';
    $email = '';
    $address = '';
    $city = '';
    $state = '';
    $zip = '';
    $card_name = '';
    $card_number = '';
    $exp_month = '';
    $exp_year = '';
    $cvv = '';
    $same_address = '';
    $button_text = 'Save Details';
  } 

} else {
    // User is not logged in
    // Check if the current page requires authentication
    $auth_pages = array('cart.php');
    if (in_array(basename($_SERVER['PHP_SELF']), $auth_pages)) {
        // Redirect to the login page
        header("Location: login.html");
        exit();
    }
}
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
        <div class="leftcolumn" style="margin-left:-16px ;">
           
<div class="row">
  <div class="col-75">
    <div class="container">
      <form id="checkout-Form" action="<?php echo ($userExists) ? 'processOrder.php' : 'putCheckoutDetailsInDB.php'; ?>" method="post">
      
        <div class="row">
          <div class="col-50">
            <h3>Billing Address</h3>
            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
            <input type="text" id="fname" name="firstname" placeholder="John M. Doe" value="<?php echo $full_name; ?>" required>
            <label for="email"><i class="fa fa-envelope"></i> Email</label>
            <input type="text" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="john@example.com" value="<?php echo $email; ?>" required>
            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
            <input type="text" id="adr" name="address" placeholder="542 W. 15th Street" value="<?php echo $address; ?>" required>
            <label for="city"><i class="fa fa-institution"></i> City</label>
            <input type="text" id="city" name="city" placeholder="New York" value="<?php echo $city; ?>" required>

            <div class="row">
              <div class="col-50">
                <label for="state">State</label>
                <input type="text" id="state" name="state" placeholder="NY" value="<?php echo $state; ?>" required>
              </div>
              <div class="col-50">
                <label for="zip">Zip</label>
                <input type="text" id="zip" name="zip" pattern=".{5}" placeholder="10001" value="<?php echo $zip; ?>" required>
              </div>
            </div>
          </div>

          <div class="col-50">
            <h3>Payment</h3>
            <label for="fname">Accepted Cards</label>
            <div class="icon-container">
              <i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
              <i class="fa fa-cc-discover" style="color:orange;"></i>
            </div>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="John More Doe"  value="<?php echo $card_name; ?>" required>
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="cardnumber" maxlength="19" pattern="\d{4}-\d{4}-\d{4}-\d{4}" placeholder="1111-2222-3333-4444"  value="<?php echo $card_number; ?>" required>
            <label for="expmonth">Exp Month</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="September or 09"  value="<?php echo $exp_month; ?>" required>
            <div class="row">
              <div class="col-50">
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" pattern=".{4}" placeholder="2025"  value="<?php echo $exp_year; ?>" required>
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" pattern=".{3}"  name="cvv" placeholder="352"  value="<?php echo $cvv; ?>" required>
              </div>
            </div>
          </div>
          
        </div>
        <label>
          <input type="checkbox"  name="sameadr" <?php if ($same_address) { echo "checked"; } ?>> Shipping address same as billing
        </label>
        <!-- hidden form fields here to send cart values to orderProcess.php. Values will be set by javasript(present at end of file)-->
        <input type="hidden" name="cart_items" id="cart_items" value="">
        <input type="hidden" name="cart_total_items" id="cart_total_items" value="">
        <input type="hidden" name="cart_total_price" id="cart_total_price" value="">
        <input type="submit" value="<?php echo $button_text; ?>" class="btn">
      </form>
    </div>
</div>

<?php
  $result = mysqli_query($conn, "SELECT SUM(quantity) AS total_items FROM cart WHERE user_id = $user_id");
  $row = mysqli_fetch_assoc($result);
  $cart_total_items = $row['total_items'];

  // Retrieve the cart items details from the cart and products tables
  $cart_items = array();
  $result = mysqli_query($conn, "SELECT cart.quantity,products.product_id, products.name, products.price FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = $user_id");
  while ($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
  }

  // Calculate the total price of all items in the cart
  $cart_total_price = 0;
  foreach ($cart_items as $item) {
    $cart_total_price += $item['price'] * $item['quantity'];
  }
?>

<!-- Display the cart items and total -->
<div class="col-25">
  <div class="container">
    <h4>Cart <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b><?php echo $cart_total_items; ?></b></span></h4>
    <?php foreach ($cart_items as $item): ?>
    <p>
      <?php echo $item['name']; ?>
      <span class="price">£<?php echo $item['price']; ?></span>
      <span>
        <?php
        echo "x".$item['quantity']." ";
        echo "<a href=\"update_cart.php?action=remove&product_id={$item['product_id']}\" style=\"text-decoration:none; color:red; font-weight:bold;\">-</a>";
        echo "/";
        echo "<a href=\"update_cart.php?action=add&product_id={$item['product_id']}\" style=\"text-decoration:none; color:green; font-weight:bold;\">+</a>";
        ?>
      </span>
    </p>
    <?php endforeach; ?>
    <hr>
    <p>Total <span class="price" style="color:black"><b>£<?php echo $cart_total_price; ?></b></span></p>
  </div>
</div>

    </div></div>

    <?php
  // Retrieve the order history details from the orders and order_items tables
  $order_history = array();
  $result = mysqli_query($conn, "SELECT orders.order_id, orders.order_date, SUM(order_items.quantity) AS total_items, SUM(order_items.quantity * order_items.price) AS total_price FROM orders INNER JOIN order_items ON orders.order_id = order_items.order_id WHERE orders.user_id = $user_id GROUP BY orders.order_id");
  while ($row = mysqli_fetch_assoc($result)) {
    $order_history[] = $row;
  }
?>

<!-- Display the order history details -->
<div class="col-25">
  <div class="container">
    <h4>Order History</h4>
    <?php 
    $orderNumber=1;
    foreach ($order_history as $order): ?>
      <div>
        <h5>Order Number: <?php echo $orderNumber;
        $orderNumber++; ?></h5>
        <p>Order Date: <?php echo $order['order_date']; ?></p>
        <ul>
          <?php 
            $result = mysqli_query($conn, "SELECT order_items.quantity, products.name, order_items.price FROM order_items INNER JOIN products ON order_items.product_id = products.product_id WHERE order_items.order_id = {$order['order_id']}");
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<li>" . $row['name'] . " x " . $row['quantity'] . " = £" . $row['price'] * $row['quantity'] . "</li>";
            }
          ?>
        </ul>
        <p>Total Items: <?php echo $order['total_items']; ?></p>
        <p>Total Price: £<?php echo $order['total_price']; ?></p>
      </div>
      <hr>
    <?php endforeach; ?>
  </div>
</div>

</div>
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

    
<script>
  // Using javascript to detect any changes in Checkout form fields and if any then changing target php file
  
  // Get the form element
  const formChanged = document.getElementById('checkout-Form');

  // Get the submit button element
  const submitButton = formChanged.querySelector('input[type="submit"]');

  // Get the current form action
  let currentAction = formChanged.action;

  // Add event listeners to the form inputs
  formChanged.querySelectorAll('input:not([type="hidden"]), select').forEach(input => {
    input.addEventListener('change', () => {
      // Check if user exists and the form action is not already set to updateCheckoutDetails.php
      if (<?php echo ($userExists ? 'true' : 'false'); ?> && currentAction !== 'updateCheckoutDetails.php') {
        // Update the form action and submit button value
        formChanged.action = 'updateCheckoutDetails.php';
        submitButton.value = 'Update Details';

        // Update the current form action
        currentAction = formChanged.action;
      }
    });
  });
</script>
</script>
  
  <script>
  // Using JavaScript to set the hidden field values in the Checkout Form
  // Get the hidden fields
  var cartItemsInput = document.getElementById('cart_items');
  var cartTotalItemsInput = document.getElementById('cart_total_items');
  var cartTotalPriceInput = document.getElementById('cart_total_price');

  // Get the cart items from PHP array and convert it to JSON string
  var cartItems = <?php echo json_encode($cart_items); ?>;

  // Set the values of the hidden fields
  cartItemsInput.value = JSON.stringify(cartItems);
  cartTotalItemsInput.value = '<?php echo $cart_total_items; ?>';
  cartTotalPriceInput.value = '<?php echo $cart_total_price; ?>';

  // Submit the form
  document.getElementById('checkout-form').submit();
</script>

</body>

</html>