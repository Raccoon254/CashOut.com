<?php
require_once 'db_connect.php';
session_start();

// check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); //redirect to login page if the user is not logged in
}

$email = $_SESSION['email'];

// check if the user is an admin
$query = "SELECT * FROM Users WHERE email = '$email' and role='admin'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 0) {
    header("Location: index.php"); //redirect to login page if the user is not an admin
}

// get the recent users
$query = "SELECT * FROM Users ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($conn, $query);

echo "<h2>Recent Users</h2>";
echo "<table>";
echo "<tr><th>Name</th><th>Email</th><th>Referral Code</th><th>Balance</th><th>Created At</th></tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['referral_code'] . "</td>";
    echo "<td>" . $row['balance'] . "</td>";
    echo "<td>" . $row['created_at'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// get the recent transactions
$query = "SELECT * FROM Transactions ORDER BY date DESC LIMIT 5";
$result = mysqli_query($conn, $query);

echo "<h2>Recent Transactions</h2>";
echo "<table>";
echo "<tr><th>Email</th><th>Amount</th><th>Type</th><th>Date</th><th>status</th></tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['amount'] . "</td>";
    echo "<td>" . $row['type'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
