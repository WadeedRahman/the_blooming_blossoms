<?php
session_start();

// Check if the login form was submitted
if (isset($_POST['login'])) {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Connect to the database (replace with your own database details)
    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'the_blooming_blossoms';
    
    // Create a database connection
    $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare and bind the SQL statement to retrieve the hashed password for the given username
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    
    // Execute the statement and get the result
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the user exists and retrieve the hashed password
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $hashedPassword = $row['password'];
    
      // Verify the entered password with the hashed password
      if (password_verify($password, $hashedPassword)) {
        echo "Login successful!";
        // set session variable to store cureent user's username
        $_SESSION['username'] = $username;
        // Redirect the user to the dashboard or the homepage
        header("Location: index.php");
      } else {
        // Display an error message or redirect the user to the login page
        echo "<script>alert('Incorrect password.');  window.location = 'login.html';</script>";
      }
    } else {
      // Display an error message or redirect the user to the login page
      echo "<script>alert('User not found.');  window.location = 'login.html';</script>";
    }
    
    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
    
}
?>