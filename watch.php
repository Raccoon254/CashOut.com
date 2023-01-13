<?php
require_once 'db_connect.php';
session_start();

if(!isset($_SESSION['email'])) {
    header("Location: index.php"); //redirect to login page if the user is not logged in
}

if(isset($_GET['id'])) {
    $video_id = $_GET['id'];

    // Retrieve the video data from the Videos table
    $query = "SELECT * FROM Videos WHERE id='$video_id'";
    $result = mysqli_query($conn, $query);
    $video = mysqli_fetch_array($result);

    if(!$video) {
        echo "Sorry, the video you are trying to watch does not exist.";
    } else {
        echo "<video id='my-video' width='320' height='240' controls>
                <source src='" . $video['file_path'] . "' type='video/mp4'>
                Your browser does not support the video tag.
              </video>
              <div id='progress-bar'></div>
              <form id='progress-form' action='watch.php' method='post'>
                <input type='hidden' id='progress' name='progress'>
                <input type='hidden' id='video-id' name='video-id' value='$video_id'>
                </form>";
                }
                
                } else if(isset($_POST['progress']) && isset($_POST['video-id'])) {
                $progress = $_POST['progress'];
                $video_id = $_POST['video-id'];
                if($progress >= 100) {
                    $email=$_SESSION['email'];
                    $query = "SELECT * FROM users WHERE email='$email'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
                
                    $user_id = $row['user_id'];
                    $query = "SELECT COUNT(*) as num_watched FROM Video_Views WHERE user_id='$user_id' AND date=CURDATE()";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_array($result);
                
                    if($row['num_watched'] < 2) {
                        // Update the user's balance
                        $query = "UPDATE Users SET balance = balance + 20 WHERE user_id='$user_id'";
                        $result = mysqli_query($conn, $query);
                        // Insert a record into the Video_Views table
                        $query = "INSERT INTO Video_Views (user_id, video_id, date) VALUES ('$user_id', '$video_id', CURDATE())";
                        $result = mysqli_query($conn, $query);
                        echo "you have successfully earned 20$";
                    } else {
                        header("homepage.php");
                    }
                }
            }
                                $email=$_SESSION['email'];
                    $query = "SELECT * FROM users WHERE email='$email'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
            $user_id = $row['user_id'];
            $query = "SELECT COUNT(*) as num_watched FROM Video_Views WHERE user_id='$user_id' AND date=CURDATE()";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
            if($row['num_watched'] < 2) {
                $determine = "SELECT * FROM advertisements";
                $resultDetermine = mysqli_query($conn, $determine);
                while ($rowDetermine = mysqli_fetch_array($resultDetermine)) {
                $category=$rowDetermine['category'];
                if ($category=='Video') {$query = "SELECT * FROM Videos";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                    echo "Name: ".$row['name']."<br>";
                    echo "Description: ".$rowDetermine['description']."<br>";
                    echo "<a href='watch.php?id=".$row['id']."'>Watch</a><br>";
                    echo "------------------------------------------------- <br>";
                    }
                    } else if ($category=='Website') {
                    echo "end of videos";
                    }{
                    }
                    }
            }else{
                echo "you have reached the limit<br>";
                header("Refresh:5; url=homepage.php");
                echo "<a href='homepage.php'> <button>home!</button> </a>";
            }

                
                $conn->close();
                ?>
                
                <script>
                var video = document.getElementById("my-video");
                var progressBar = document.getElementById("progress-bar");
                var progressForm = document.getElementById("progress-form");
                var progressInput = document.getElementById("progress");
                
                video.addEventListener("timeupdate", function() {
                    var percentage = (video.currentTime / video.duration) * 100;
                    progressBar.style.width = percentage + "%";
                    progressInput.value = percentage;
                    if (percentage >= 100) {
                        progressForm.submit();
                    }
                });
                </script>                