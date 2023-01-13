<?php
require_once 'db_connect.php';

if(isset($_POST['submit'])) {
    // retrieve form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // check if the email address exists in the database
    $query = "SELECT * FROM Users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        // update the user's password
        $query = "UPDATE Users SET password='$password' WHERE email='$email'";
        mysqli_query($conn, $query);
        
        echo "Your password has been reset. Please log in.";
        header("Refresh:2; url=index.php");
    } else {
        echo "Sorry, that email address does not exist in our database.";
    }
}

//create the form
echo "<form action='password_reset.php' method='post'>";
echo "Email: <input type='email' name='email' required/><br>";
echo "New Password: <input type='password' name='password' required/><br>";
echo "<input type='submit' name='submit' value='Reset Password'/>";
echo "</form>";

$conn->close();
?>