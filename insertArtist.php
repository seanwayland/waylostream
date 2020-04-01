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


$artist_name =$_POST['artist_name'];
$artist_name = $mysqli->escape_string($artist_name);

$artist_sex =$_POST['artist_sex'];
$artist_sex = $mysqli->escape_string($artist_sex);
$artist_country =$_POST['artist_country'];
$artist_country = $mysqli->escape_string($artist_country);
$artist_bio =$_POST['artist_bio'];
$artist_bio = $mysqli->escape_string($artist_bio);

$artist_location =$_POST['artist_location'];
$artist_location = $mysqli->escape_string($artist_location);
$artist_birthday = $_POST['artist_birthday'];
$artist_birthday = $mysqli->escape_string($artist_birthday);


// search for artist name index

/*
$exists = $mysqli->query("SELECT id FROM artists WHERE artist_name LIKE'%$artist_name%'") or die($mysqli->error);
$name =$exists["id"];
echo $name;
*/

// get artist ID from name

/*
$result = $mysqli->query("SELECT * FROM artists WHERE artist_name='$artist_name'");
$art = $result->fetch_assoc();
$name = $art['id'];

*/

// check to see if album name exists for that artist

$exists = $mysqli->query("SELECT * FROM artists WHERE artist_name='$artist_name'")or die($mysqli->error);



$exists2 = $exists->fetch_assoc();
$exists2 = $exists2['artist_name'];


if ($exists2 !== null){ echo "Artists Exists already for that artist";
    ?>
    <br />
    <a href="http://www.waylostreams.com/login-system/createArtist.php">Add another artist </a>
    <br />


    <br />
    <a href="http://www.waylostreams.com/login-system/profile.php">Go back to profile page </a>
    <br />
    <?php
}
else {


// Attempt insert query execution
    $sql = "INSERT INTO artists (artist_name, birthdate, email, sex, birth_country, location_city, image_url, artist_bio)" . " VALUES ('$artist_name', STR_TO_DATE('$artist_birthday','%m-%d-%y'), '$email', '$artist_sex', '$artist_country', '$artist_location', 'http://waylostreams.com/album-covers/step0001.jpg' , '$artist_bio')";

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

    echo "Artist Added";

// Close connection
    mysqli_close($link);

}

if ($exists2 !== null){}

else {
    ?>

    <form action="artistImageUpload.php?name=<?php echo $artist_name ;?>" method="post" enctype="multipart/form-data">
        Now select image to upload for artist:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="upload" name="submit">
    </form>

    <?php
}

