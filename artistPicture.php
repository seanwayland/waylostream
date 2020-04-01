<?php



require 'db.php';
session_start();

/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/*pass hidden*/
$pass = ###########
$db = 'sean';
$dbport = 3306;
$mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);




$artistName = $_GET['name'];
$target_dir = "albumCovers/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

        // add image url to album data
        $url = "https://waylostreams.com/login-system/albumCovers/";
        $url2 = $_FILES["fileToUpload"]["name"];
        $url3 = $url.$url2 ;
        //$url3 = "hello";



        $sql = "UPDATE artists SET image_url = '$url3' WHERE artist_name = '$artistName'";
        $mysqli->query($sql) or die($mysqli->error);

        ?>

        <br />
        <a href="https://www.waylostreams.com/login-system/createArtist.php">Add another artist </a>
        <br />


        <br />
        <a href="https://www.waylostreams.com/login-system/profile.php">Go back to profile page </a>
        <br />


        <?php


    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


?>
