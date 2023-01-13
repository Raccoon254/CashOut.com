<?php
require_once 'db_connect.php';
session_start();

if(!isset($_SESSION['email'])) {
    header("Location: index.php"); //redirect to login page if the user is not logged in
}

$email=$_SESSION['email'];
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$user_id = $row['user_id'];

$query = "SELECT COUNT(*) as num_spins FROM Spin WHERE user_id='$user_id' and date=CURDATE()";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$num_spins = $row['num_spins'];

if(isset($_POST['extra_spin'])){
    
    $email=$_SESSION['email'];
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
    if($row['balance']<10){
        echo "You don't have sufficient balance";
    }else{
        $query = "UPDATE Users SET balance = balance - 10 WHERE user_id='$user_id'";
        $result = mysqli_query($conn, $query);
        $prizes = array("10", "20", "30", "40", "50", "Try Again");
        $random_index = array_rand($prizes);
        $prize = $prizes[$random_index];
        if($prize!="Try Again"){
            $query = "UPDATE Users SET balance = balance + $prize WHERE user_id='$user_id'";
            $result = mysqli_query($conn, $query);
        }
        $query = "INSERT INTO Spin (user_id, prize, date) VALUES ('$user_id', '$prize', CURDATE())";
        $result = mysqli_query($conn, $query);
        echo "You won $prize";
        header("Refresh:5; url=homepage.php");
    }
}else if($num_spins > 0) {
    echo "Sorry, you have already spun for the day. You can pay for an extra spin for $10 <br>";
    echo "<form method='post' action='spin.php'>
            <input type='submit' name='extra_spin' value='Pay for extra spin'>
          </form>";
}else{
    $prizes = array("10", "20", "30", "40", "50", "Try Again");
    $random_index = array_rand($prizes);
    $prize = $prizes[$random_index];
    if($prize!="Try Again"){
        $query = "UPDATE Users SET balance = balance + $prize WHERE user_id='$user_id'";
        $result = mysqli_query($conn, $query);
    }
    $query = "INSERT INTO Spin (user_id, prize, date) VALUES ('$user_id', '$prize', CURDATE())";
    $result = mysqli_query($conn, $query);
   
    echo "You won $prize";
    header("Refresh:5; url=homepage.php");
  }
  
  $conn->close();
  ?>