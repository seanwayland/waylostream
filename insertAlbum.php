<?php
require 'db.php';
session_start();

/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/** pass hidden **/ 
$pass = #########
$db = 'sean';
$dbport = 3306;
$mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);


$email = $_SESSION['email'];

// Escape user inputs for security


$album_name =$_POST['album_name'];
$album_name = $mysqli->escape_string($album_name);
$artist_name =$_POST['artist_name'];
$artist_name = $mysqli->escape_string($artist_name);
$credits =$_POST['credits'];
$credits = $mysqli->escape_string($credits);


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


// check to see if album name exists for that artist

$exists = $mysqli->query("SELECT * FROM albums WHERE album_artist='$name' AND album_title like '$album_name'") or die($mysqli->error);



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
    $sql = "INSERT INTO albums (album_title, album_artist, release_date, image_url, credits, artist_email)" . " VALUES ('$album_name', '$name', now(), 'http://waylostreams.com/album-covers/step0001.jpg' , '$credits', '$email')";

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

    echo "Album Added";

// Close connection
    mysqli_close($link);

}

if ($exists2 !== null){}

else {
?>

    <form action="albumImageUpload.php?name=<?php echo $album_name ;?>" method="post" enctype="multipart/form-data">
        Now select image to upload for album:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="upload" name="submit">
    </form>

<?php
}

