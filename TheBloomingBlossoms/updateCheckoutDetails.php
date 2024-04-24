<?php
// Retrieve username from session
session_start();
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
$sql = "SELECT user_id FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$user_id = $row['user_id'];

// Retrieve form data
$full_name = $_POST['firstname'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$card_name = $_POST['cardname'];
$card_number = $_POST['cardnumber'];
$exp_month = $_POST['expmonth'];
$exp_year = $_POST['expyear'];
$cvv = $_POST['cvv'];
$same_address = isset($_POST['sameadr']) ? 1 : 0;

// Insert data into checkout_details table
$sql = "UPDATE checkout_details SET 
            full_name = '$full_name', 
            email = '$email', 
            address = '$address', 
            city = '$city', 
            state = '$state', 
            zip = '$zip', 
            card_name = '$card_name', 
            card_number = '$card_number', 
            exp_month = '$exp_month', 
            exp_year = '$exp_year', 
            cvv = '$cvv', 
            same_address = '$same_address' 
        WHERE user_id = '$user_id'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Checkout Details Updated.');  window.location = 'cart.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
mysqli_close($conn);
?>
