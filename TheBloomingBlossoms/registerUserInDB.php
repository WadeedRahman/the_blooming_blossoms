<?php
// Get the form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password using the password_hash function
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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

// Check if username or email already exists in the database
$stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // Username or email already exists, show error message
  echo "<script>alert('Username or email already exists. Please choose a different one.');  window.location = 'signup.html';</script>";
} else {
  // Username and email are unique, insert the data into the database
  // Prepare and bind the SQL statement
  $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $email, $hashedPassword);

  // Execute the statement
  $stmt->execute();

  // Show success message
  echo "<script>alert('User registered successfully.');  window.location = 'login.html';</script>";

  // Close the statement and the database connection
  $stmt->close();
}
$conn->close();

?>
