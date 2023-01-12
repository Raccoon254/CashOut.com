<?php
require_once 'db_connect.php';
session_start();

if(!isset($_SESSION['email'])) {
    header("Location: index.php"); //redirect to login page if the user is not logged in
}

if(isset($_POST['withdraw_submit'])) { //if the withdraw button is clicked

    $email = $_SESSION['email'];
    $amount = $_POST['withdraw'];
    $date = date("Y-m-d");
    $status = 'pending';
    $type='withdraw';

    // check if the user has enough balance
    $query = "SELECT balance FROM Users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $balance = $row['balance'];
    if($amount > $balance) {
        echo "Sorry, you don't have enough balance. Please try again.";
    } else {
        // update the user's balance
        $query = "UPDATE Users SET balance = balance - $amount WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        if($result) {
            echo "Your withdraw has been sent. You will receive cash within 30 minutes";
            // insert the withdraw into the Transactions table
            $query = "INSERT INTO Transactions (email, amount, type, date, status) VALUES ('$email', '$amount', '$type', '$date', '$status')";
            $result = mysqli_query($conn, $query);
        } else {
            echo "Sorry, there was an error. Please try again.";
        }
    }
}
if(isset($_POST['deposit_submit'])) { //if the deposit button is clicked

    $email = $_SESSION['email'];
    $amount = $_POST['deposit'];
    $date = date("Y-m-d");
    $status = 'validating';
    $type='deposit';
    // check if the amount is valid
    if($amount <= 0) {
        echo "Sorry, the amount is not valid. Please try again.";
    } else {
        // insert the deposit into the Transactions table
        $query = "INSERT INTO Transactions (email, amount, type, date, status) VALUES ('$email', '$amount', '$type', '$date', '$status')";
        $result = mysqli_query($conn, $query);
        if($result) {
            echo "Your deposit is under validation, you will receive a notification after 30 minutes";
        } else {
            echo "Sorry, there was an error. Please try again.";
        }
    }
}
$conn->close();
?>
