<?php
require_once 'db_connect.php';

if(isset($_POST['submit'])) {
    // retrieve form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // check if the email and password match a user in the database
    $query = "SELECT * FROM Users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        // start a session and store the user's email address
        session_start();
        $_SESSION['email'] = $email;
        
        //redirect to the profile page
        header("Location: homepage.php");
    } else {
        echo "Sorry, the email or password is incorrect. Please try again.";
    }
}

//create the form
echo "<form action='index.php' method='post'>";
echo "Email: <input type='email' name='email' required/><br>";
echo "Password: <input type='password' name='password' required/><br>";
echo "<input type='submit' name='submit' value='Log In'/>";
echo "</form>";
echo "<a href='register.php'> <button>Register</button> </a><br>";

//add the link to the password reset page
echo "<a href='password_reset.php'>Forgot your password?</a> ";

$conn->close();
?>