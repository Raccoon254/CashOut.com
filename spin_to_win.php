<div id="spin-to-win-wheel">
  <div id="pin"></div>
  <ul>
    <li data-prize="Sorry, try again." data-chance="20"></li>
    <li data-prize="You won a small prize!" data-chance="30"></li>
    <li data-prize="Congratulations, you won a big prize!" data-chance="50"></li>
  </ul>
</div>

<style>
#spin-to-win-wheel {
  width: 500px;
  height: 500px;
  border-radius: 50%;
  position: relative;
  animation: spin 2s linear;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>

<?php
require_once 'db_connect.php';
session_start();

if(!isset($_SESSION['email'])) {
    header("Location: index.php"); //redirect to login page if the user is not logged in
}

// Validate input
if(isset($_POST['spin'])) {
    $prize = "";
    $prize_amount = 0;
    //get the prize pool 
    $query = "SELECT * from prize_pool";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $prizes[] = $row;
        }
    }
    //spin logic
    $spin_result = mt_rand(0,100);
    $total_chance = 0;
    foreach($prizes as $data){
        $total_chance +=$data['chance'];
        if($spin_result<=$total_chance){
            $prize = $data['prize'];
            $prize_amount = $data['prize_amount'];
            break;
        }
    }
    // check that the prize amount is numeric

    if (!is_numeric($prize_amount)) {
        echo "Invalid prize amount.";
    } else {
        // update the user's balance in the database
        $email = $_SESSION['email'];
        $query = "UPDATE Users SET balance=balance+'$prize_amount' WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo $prize;
            echo '<br>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    echo "<script>document.getElementById('spin-to-win-wheel').style.animation = 'spin 2s linear';</script>";
}

echo '<form action="spin_to_win.php" method="post">';
echo '<input type="submit" name="spin" value="Spin">';
echo '</form>';
$conn->close();
?>
