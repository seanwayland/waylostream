
<?php include 'pageHeader.php';?>

<?php
// this file updates the streams table in the database
// the user and song_id are passed in with say streamsong.php?id=1&user=13
// it checks to see if the user has already played the song if so it increments the counter
// if the user has never played the song it creates a new row in the DB linking the song to the user
// connection settings
//require '../login-system/db.php';
//session_start();
// do these need to be global  ?
/*
global $id;
global $sql;
global $mysqli;
global $result;
global $row;
global $filename;

 */
/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/* pass hidden */ 
$pass = #########
$db = 'sean';
$dbport = 3306;
$mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);

// get song id from page call
$id = $_GET['id'];
$user = $_GET['user'];
//echo "ID is ";
//echo $id;
//echo "  user is ";
//echo $user;
//echo " ";
$id = $mysqli->escape_string($id);
$user_id = $mysqli->escape_string($user);

$song_id = $mysqli->escape_string($id);
$result1 = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
$song = $result->fetch_assoc();
$purchase_cost = $song['purchase_cost'];


//////////           UPDATE STREAMS AND CREDITS FROM DATABASE

// sean's user ID !!!
//$user_id = 13;
// get user ID
// fake purchase cost

$exists = $mysqli->query("SELECT stream_id FROM streams WHERE user_id='$user_id' AND song_id ='$id' AND purchase_cost = '$purchase_cost'") or die($mysqli->error);

$exists2 = $exists->fetch_assoc();
$streamid = $exists2['stream_id'];
//echo " stream id is ";
//echo $streamid;
//echo " ";
if ($exists2 !== null)
{
    // if song has been played before by user do nothing for now
    //echo "stream exists";
    // increment streams counter , take credits off user
    // get streams counter
    $counter = $mysqli->query("SELECT number_plays FROM streams WHERE user_id='$user_id' AND song_id ='$id'") or die($mysqli->error);
    $counter = $counter->fetch_assoc();
    $counter = $counter['number_plays'];
    $counter = $counter + 1;
    $counter = $mysqli->escape_string($counter);

    $unpaid = $counter['unpaid_plays'];
    $unpaid = $unpaid + 1;
    $unpaid = $mysqli->escape_string($unpaid);
    //echo " number plays is ";
    //echo $counter;
    // echo " ";
    $date = date('Y-m-d');
    $date = $mysqli->escape_string($date);
    $sql = "UPDATE streams SET number_plays='$counter' WHERE user_id ='$user_id' AND song_id ='$id'";

    $mysqli->query($sql) or die($mysqli->error);

    $sql = "UPDATE streams SET unpaid_plays='$unpaid' WHERE user_id ='$user_id' AND song_id ='$id'";

    $mysqli->query($sql) or die($mysqli->error);

    $sql = "UPDATE streams SET last_access_time= '$date' WHERE user_id ='$user_id' AND song_id ='$id'";
    $mysqli->query($sql) or die($mysqli->error);

    $result = $mysqli->query("SELECT * FROM users WHERE id='$user_id'");
    $user = $result->fetch_assoc();
    $credits = $user['credits'];

    $song_id = $mysqli->escape_string($id);
    $result = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
    $song = $result->fetch_assoc();
    $purchase_cost = $song['purchase_cost'];

    $credits = $credits - $purchase_cost;
    $sql = "UPDATE users SET credits= '$credits' WHERE id ='$user_id'";
    $mysqli->query($sql) or die($mysqli->error);

    if($credits<0){
        header("Location: http://www.waylostreams.com/login-system/profile.php");
    }

    //echo $date;
    //echo " ";
    //echo $counter;
    //echo " ";
    //echo $id;
    //echo " ";

    //echo $counter;

}
else {
    //echo "stream doesn't exist";
    // create stream in table+

    $result = $mysqli->query("SELECT * FROM users WHERE id='$user_id'");
    $user = $result->fetch_assoc();
    $credits = $user['credits'];

    $song_id = $mysqli->escape_string($id);
    $result = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
    $song = $result->fetch_assoc();
    $purchase_cost = $song['purchase_cost'];

    $credits = $credits - $purchase_cost;
    $sql = "UPDATE users SET credits= '$credits' WHERE id ='$user_id'";
    $mysqli->query($sql) or die($mysqli->error);

    $stream_id = $mysqli->escape_string('1');


    $purchase_cost = $mysqli->escape_string($purchase_cost);
    $number_plays = 1;
    $number_plays = $mysqli->escape_string($number_plays);
    $unpaid = 1;
    $unpaid = $mysqli->escape_string($unpaid);

    // insert new stream into streams table fisrt time a song is played by a user
    $sql = "INSERT INTO streams ( user_id, song_id, purchase_cost, number_plays, unpaid_plays, first_access_time, last_access_time) "
        . "VALUES ('$user_id','$id','$purchase_cost', '$number_plays', '$unpaid', now(), now())";

    $mysqli->query($sql) or die($mysqli->error);
    //echo $counter;

}

//echo $counter;
//echo "<br>";





/* Displays user information and some useful messages */
require 'db.php';
//session_start();
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();
    $credits = $user['credits'];
}



?>
<!DOCTYPE html>
<html >

<style>
    body {
        background: #D3D3D3D3; /* #c1bdba */
        font-family: 'Titillium Web', sans-serif;
    }

    input[type=text] {
        background-color: white;
        color: black;
    }

    /* unvisited link */
    a:link {
        color: #1ab188;
    }

    /* visited link */
    a:visited {
        color: blue;
    }

    /* mouse over link */
    a:hover {
        color: green;
    }

    /* selected link */
    a:active {
        color: greenyellow;
    }


    button {
        background-color: #1ab188; /* Green */
        border: none;
        color: black;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }

    img {
        width: 30%;
        height: 30%;

    }

</style>
<head>
    <?php // include 'css/css.html'; ?>


<body>



<?php

$id = $_GET['id'];
$user = $_GET['user'];
//echo "ID is ";
//echo $id;
//echo "  user is ";
//echo $user;
//echo " ";
$id = $mysqli->escape_string($id);
$user_id = $mysqli->escape_string($user);
$song_id = $id;

// fetch the logged in users email
$email = $mysqli->escape_string($_SESSION['email']);
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
$user = $result->fetch_assoc();
$user_id = $user['id'];

// grab the song purchase cost from the songs table

$song_id = $mysqli->escape_string($song_id);
$result = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
$song = $result->fetch_assoc();
$purchase_cost = $song['purchase_cost'];

// this code below a sticks up an html audio player and calls the source file
// from the database. It selects the URL of the source and then
// streams the file secretly
?>


<?php


$song_id = $mysqli->escape_string($id);
$result = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
$song = $result->fetch_assoc();
$songTitle = $song['title'];
$albumTitle = $song['album'];
$artistTitle = $song['artist'];
$songCost = $song['purchase_cost'];
$url = $song['URL'];
//$url = '"'.$url.'"';







// get album title
$r1 = $mysqli->query("SELECT * FROM albums WHERE album_id='$albumTitle'");
$song = $r1->fetch_assoc();
$albumTitle = $song['album_title'];
$coverURL = $song['image_url'];
$albumCredits = $song['credits'];



?>


<?php





$r2 = $mysqli->query("SELECT * FROM artists WHERE id='$artistTitle'");
$song = $r2->fetch_assoc();
$artistTitle = $song['artist_name'];


echo "<br />";






?>


THANKS FOR YOUR GOOD TASTE IN MUSIC! <br />
THIS LINK IS A DIRECT LINK TO THE SONG <br />
RIGHT CLICK AND SAVE AS <br />
OR CLICK TO OPEN FILE IN YOUR BROWSER <br />

<a href=<?php echo $url; ?> download>
<?php echo $url;?>


</a>




<?php
$song_id = $mysqli->escape_string($id);
$result = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
$song = $result->fetch_assoc();
$albumTitle = $song['album'];
$artistTitle = $song['artist'];




echo "<br />";

$query = "SELECT song_id, SUM(number_plays) AS value_sum FROM streams WHERE song_id = '$song_id' GROUP BY song_id";

$result = $mysqli->query($query) or die($mysqli->error);



/// links back to artist . album and profile page



print "<br>";
echo "<a href='https://www.waylostreams.com/login-system/searchByAlbum.php?id=$albumTitle&user=$user_id'>more songs from this album </a>";
print "<br>";
echo "<a href='https://www.waylostreams.com/login-system/searchByArtist.php?id=$artistTitle&user=$user_id'>more songs from this artist </a>";
print "<br>";

?>
<a href="https://www.waylostreams.com/login-system/profile.php">Go back to profile page </a>
<br />




<br />
</body>
