<?php
require_once 'db_connect.php';
session_start();

if(!isset($_SESSION['email'])) {
    header("Location: index.php"); //redirect to login page if the user is not logged in
}

// check if the form has been submitted
if(isset($_POST['submit'])) {
    // retrieve form data
    $email = $_SESSION['email'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $status = "pending";
    $price = 0;
    if($category == "Video") {
        $price = 20;
    } else if ($category == "Website") {
        $price = 10;
    }
    // check if the user has enough balance
    $query = "SELECT balance FROM Users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $balance = $row['balance'];
    if($balance < $price) {
        echo "Sorry, you do not have enough balance to advertise in this category. Please deposit more money.";
    } else {


        if($category == "Video") {
                    // check if a file has been uploaded
        if(isset($_FILES['video'])) {
            // retrieve file data
            $file = $_FILES['video'];
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_size = $file['size'];
            $file_error = $file['error'];
            // check if there are any errors
            if($file_error === 0) {
                // generate a unique file name
                $file_name_new = uniqid('', true) . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
                // set the destination folder for the uploaded file
                $file_destination = 'uploads/' . $file_name_new;
                // move the uploaded file to the destination folder
                if(move_uploaded_file($file_tmp, $file_destination)) {
                    // insert the new advertisement into the Advertisements table
                    $query = "SELECT * FROM Advertisements WHERE name='$name'";
                    $result = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result) > 0) {
                           echo "Sorry, that name already exists. Please try again.";
                    } else {
                    $query = "INSERT INTO Advertisements (email, name, description, category, price, status)
                              VALUES ('$email', '$name', '$description', '$category', '$price', '$status')";
                    $result = mysqli_query($conn, $query);
                    

                    //
                    if($result) {
                        // update user's balance
                        $query = "UPDATE Users SET balance = balance - $price WHERE email='$email'";
                        $result = mysqli_query($conn, $query);
                        // insert the video details into the Videos table
                        $query = "INSERT INTO Videos (name, file_name, file_size, file_path)
                                  VALUES ('$name', '$file_name_new', '$file_size', '$file_destination')";
                        $result = mysqli_query($conn, $query);
                        echo "Success! Your advertisement has been submitted and it is pending for approval.";
                    } else {
                        echo "Sorry, there was an error. Please try again.";
                    }

                    //
                }
                }
            }
        }
        } else if ($category == "Website") {
            if(isset($_FILES['cover'])) {
                // retrieve file data
                $file = $_FILES['cover'];
                $file_name = $file['name'];
                $file_tmp = $file['tmp_name'];
                $file_size = $file['size'];
                $file_error = $file['error'];
                // check if there are any errors
                if($file_error === 0) {
                    // generate a unique file name
                    $file_name_new = uniqid('', true) . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
                    // set the destination folder for the uploaded file
                    $file_destination = 'uploads/' . $file_name_new;
                    // move the uploaded file to the destination folder
                    if(move_uploaded_file($file_tmp, $file_destination)) {
                        // insert the new advertisement into the Advertisements table
                        $query = "SELECT * FROM Advertisements WHERE name='$name'";
                        $result = mysqli_query($conn, $query);
                        if(mysqli_num_rows($result) > 0) {
                               echo "Sorry, that name already exists. Please try again.";
                        } else {   
                                     $query = "INSERT INTO Advertisements (email, name, description, category, price, status)
                            VALUES ('$email', '$name', '$description', '$category', '$price', '$status')";
                  $result = mysqli_query($conn, $query);
                        
    
                        //
                        if($result) {
                            // update user's balance
                            if($result) {
                                // update user's balance
                                $query = "UPDATE Users SET balance = balance - $price WHERE email='$email'";
                                $result = mysqli_query($conn, $query);
                                // insert the cover details into the links table
                                $query = "INSERT INTO Links (name, link, file_name, file_size, file_path)
                                  VALUES ('$name', '$link' , '$file_name_new' , '$file_size' , '$file_destination')";
                        $result = mysqli_query($conn, $query);
                                echo "Success! Your advertisement has been submitted and it is pending for approval.";
                            } else {
                                echo "Sorry, there was an error. Please try again.";
                            }
    
                        //
                    }
                    }
                }
            }
        }
        






        //
    }
}
}

echo "<form action='advertisements.php' method='post' enctype='multipart/form-data'>";
echo "Name: <input type='text' name='name' required/><br>";
echo "Description: <textarea name='description' required></textarea><br>";
echo "Category: <select name='category' required> <option value='Video'>Video</option> <option value='Website'>Website</option></select><br>";
echo "Video: <input type='file' name='video' accept='video/*'/> <br>";
echo "Web ScreenShot: <input type='file' name='cover' accept='image/png, image/jpeg' /> <br>";
echo "Link: <input type='text' name='link' /><br>";
echo "<input type='submit' name='submit' value='Submit'/>";
echo "</form>";

echo "<br> <br>";

echo "List of Advertisements: <br>";

// Retrieve the advertisements from the Advertisements table
$query = "SELECT * FROM Advertisements";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($result)) {
    echo "Name: ".$row['name']."<br>";
    echo "Description: ".$row['description']."<br>";
    if ($row['category'] == "Video") {
        // Retrieve the videos from the Videos table
$queryVid = "SELECT * FROM Videos";
$resultVid = mysqli_query($conn, $queryVid);

while ($rowVid = mysqli_fetch_array($resultVid)) {
    echo '<video width="320" height="240" controls>
            <source src="'.$rowVid['file_path'].'" type="video/mp4">
            Your browser does not support the video tag.
         </video>';
    echo "------------------------------------------------- <br>";
}
    } else {
        $queryLink = "SELECT * FROM Links";
        $resultLink = mysqli_query($conn, $queryLink);
        
        while ($rowLink = mysqli_fetch_array($resultLink)) {
            $displayedLink = $rowLink['link'] ;
            $cover = $rowLink['file_path'];
            echo "<a href='https://$displayedLink' target='_blank'><img src='$cover' alt='' width='320' height='240'></a>  
            <br> Name of the link: <a href='https://".$rowLink['link']."'>".$rowLink['link']."</a><br>";
            echo "------------------------------------------------- <br>";
        }
    }
    echo "Price: $".$row['price']."<br>";
    echo "Status: ".$row['status']."<br>";
    echo "------------------------------------------------- <br>";
}




echo "<a href='homepage.php'><button>home</button></a>";




$conn->close();
?>

