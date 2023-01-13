<?php
require_once 'db_connect.php';
$user_id = $_POST['user_id'];
$query = "UPDATE Users SET balance = balance + 20 WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
?>
