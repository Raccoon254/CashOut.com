<?php
require_once 'db_connect.php';
$user_id = $_POST['user_id'];
$video_id = $_POST['video_id'];
$query = "INSERT INTO Video_Views (user_id, video_id, date) VALUES ('$user_id', '$video_id', CURDATE())";
$result = mysqli_query($conn, $query);
?>
