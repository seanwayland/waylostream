<?php
require 'db.php';
session_start();

/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/* pass hidden */
$pass = ########
$db = 'sean';
$dbport = 3306;
$mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);


$email = $_SESSION['email'];

// Escape user inputs for security


$album_name =$_POST['album_name'];
$album_name = $mysqli->escape_string($album_name);
$artist_name =$_POST['artist_name'];
$artist_name = $mysqli->escape_string($artist_name);
$title =$_POST['title'];
$title = $mysqli->escape_string($title);

$purchase_cost =$_POST['purchase_cost'];
$purchase_cost = $mysqli->escape_string($purchase_cost);
$stream_cost =$_POST['stream_cost'];
$stream_cost = $mysqli->escape_string($stream_cost);



// search for artist name index

/*
$exists = $mysqli->query("SELECT id FROM artists WHERE artist_name LIKE'%$artist_name%'") or die($mysqli->error);
$name =$exists["id"];
echo $name;
*/

// get artist ID from name

$result = $mysqli->query("SELECT * FROM artists WHERE artist_name='$artist_name'");
$art = $result->fetch_assoc();
$name = $art['id'];

$result = $mysqli->query("SELECT * FROM albums WHERE album_title='$album_name'");
$art = $result->fetch_assoc();
$album = $art['album_id'];

// check to see if album name exists for that artist

$exists = $mysqli->query("SELECT * FROM songs WHERE title LIKE '$title' AND album like '$album_name'") or die($mysqli->error);



$exists2 = $exists->fetch_assoc();
$exists2 = $exists2['album_title'];


if ($exists2 !== null){ echo "Album Exists already for that artist";
    ?>
    <br />
    <a href="http://www.waylostreams.com/login-system/createAlbum.php">Add another album </a>
    <br />


    <br />
    <a href="http://www.waylostreams.com/login-system/profile.php">Go back to profile page </a>
    <br />
    <?php
}
else {


// Attempt insert query execution
    $sql = "INSERT INTO songs (album, artist, title, URL, purchase_cost, stream_cost, artist_email)" . " VALUES ('$album', '$name', '$title', 'http://waylostreams.com/mp3/cem.mp3' , '$purchase_cost', '$stream_cost' , '$email')";

    /*
    if(mysqli_query($link, $sql)){
        echo "Records added successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }


    $sql = "INSERT INTO streams ( user_id, song_id, purchase_cost, number_plays, first_access_time, last_access_time) "
        . "VALUES ('$user_id','$id','$purchase_cost', $number_plays, now(), now())";
    */

    $mysqli->query($sql) or die($mysqli->error);

    echo "Song Added";

// Close connection
    mysqli_close($link);

}

if ($exists2 !== null){}

else {
    ?>

    <form action="songMp3Upload.php?title=<?php echo $title ;?>&album=<?php echo $album ;?>" method="post" enctype="multipart/form-data">
        Now select file(mp3/wav) to upload for song:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="upload" name="submit">
    </form>

    <?php
}

