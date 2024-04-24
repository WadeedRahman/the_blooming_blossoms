<?php
    session_start();

if (isset($_POST['contactUs']))
{
    // Connect to the database (replace the database credentials with your own)
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
    // Get the form data
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';

    // Prepare and bind the form data to a SQL statement
    $stmt = $conn->prepare("INSERT INTO contact_form (firstname, lastname, email, subject) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $subject);
    $stmt->execute();

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();


    // Redirect the user 
    echo "<script> alert('Thanks for Contatcing us. Your feedback has been received.'); window.location = 'contact.php';</script>";
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
        <div class="contactpage">

                <div class="signup-container"> 
                    <form action="contact.php" method="post">
                        <label for="fname">First Name</label>
                        <input type="text" id="firstname" name="firstname" placeholder="Your name.." required>

                        <label for="lname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" placeholder="Your last name.." required>

                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Your email.." size="30" required>

                        <label for="subject">Subject</label>
                        <textarea id="subject" name="subject" required placeholder="Write something.."
                            style="height:200px"></textarea>

                        <input type="submit" name="contactUs" value="Submit">
                    </form>
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