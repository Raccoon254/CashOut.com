<?php
require_once 'db_connect.php';

// check if the form has been submitted
if(isset($_POST['submit'])) {
    //retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $refer_code=generateReferralCode($conn);
    $referral_code = mysqli_real_escape_string($conn, $_POST['referral_code']);
    $balance = 0;
    // check if referral code is valid
    if($referral_code) {
        $query = "SELECT * FROM Users WHERE referral_code='$referral_code'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) == 0) {
            $referral_code = NULL; //if the referral code is invalid, set it to NULL
        }
    }
    // check if the email already exists
    $query = "SELECT * FROM Users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        echo "Sorry, that email already exists. Please try again.";
       } else {
        // insert the new user into the Users table
        $query = "INSERT INTO Users (name, email, password, referral_code, balance)
                  VALUES ('$name', '$email', '$password', '$refer_code', '$balance')";
        $result = mysqli_query($conn, $query);
        if($result) {
            echo "Success! Your account has been created. Please log in.";
            if($referral_code){
            $query_upd = "UPDATE Users SET balance = balance + 50 where referral_code = '$referral_code'";
            $result = mysqli_query($conn, $query_upd);
            }
            // redirect the user to the login page
            header("Location: index.php");
        } else {
            echo "Sorry, there was an error. Please try again.";
        }
    }
}
function generateReferralCode($conn) {
    // Generate a random string of 6 characters
    $code = strtoupper(substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789", 6)), 0, 6));
    
    // Check if the code is already in use
    $check_query = "SELECT * FROM users WHERE referral_code='$code'";
    $result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($result) > 0) {
    // If the code is already in use, generate a new one
    generateReferralCode($conn);
    } else {
    // If the code is unique, return it
    return $code;
    }
    }
//create the form
echo "<form action='register.php' method='post'>";
echo "Name: <input type='text' name='name' required/><br>";
echo "Email: <input type='email' name='email' required/><br>";
echo "Password: <input type='password' name='password' required/><br>";
echo "Have you been referred? <input type='text' name='referral_code' /><br>";
echo "<input type='submit' name='submit' value='Register'/>";
echo "</form>";

$conn->close();
?>
