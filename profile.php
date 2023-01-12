<?php
require_once 'db_connect.php';
session_start();

if(!isset($_SESSION['email'])) {
    header("Location: index.php"); //redirect to login page if the user is not logged in
}

// Retrieve the user's name, balance, and referral code from the database
$email = $_SESSION['email'];
$query = "SELECT name, balance, referral_code FROM Users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$name = $row['name'];
$balance = $row['balance'];
$referral_code = $row['referral_code'];

echo "Welcome, $name!<br>";
echo "Your balance is: $ $balance <br><br>";

// display the user's referral code
echo "Your referral code: $referral_code <br><br>";

// display a table of the user's referrals
echo "<table>";
echo "<tr> <th>Name</th> <th>Email</th> </tr>";
$query = "SELECT name, email FROM Users WHERE referred_by='$referral_code'";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)) {
    echo "<tr> <td>".$row['name']."</td> <td>".$row['email']."</td> </tr>";
}
echo "</table> <br>";

// create a form for the user to withdraw and deposit cash
echo "<form action='withdraw_deposit.php' method='post'>";
echo "Withdraw: $ <input type='number' name='withdraw' min='1' step='0.01'/>";
echo "<input type='submit' name='withdraw_submit' value='Withdraw'/> <br>";
echo "Deposit: $ <input type='number' name='deposit' min='1' step='0.01'/>";
echo "<input type='submit' name='deposit_submit' value='Deposit'/>";
echo "</form> <br>";

// display the user's earning history
echo "Earning history: <br>";
$query = "SELECT * FROM Earnings WHERE email='$email'";
$result = mysqli_query($conn, $query);
echo "<table>";
echo "<tr> <th>Date</th> <th>Amount</th> <th>Description</th> </tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr> <td>".$row['date']."</td> <td>$".$row['amount']."</td> <td>".$row['description']."</td> </tr>";
}
echo "</table> <br>";

// display the user's transaction history
echo "Transaction history: <br>";
$query = "SELECT * FROM Transactions WHERE email='$email'";
$result = mysqli_query($conn, $query);
echo "<table>";
echo "<tr> <th>Date</th> <th>Amount</th> <th>Type</th> <th>Status</th> </tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr> <td>".$row['date']."</td> <td>$".$row['amount']."</td> <td>".$row['type']."</td> <td>".$row['status']."</td> </tr>";
}
echo "</table>";

$conn->close();
?>

