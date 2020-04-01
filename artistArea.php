<?php
require 'db.php';
session_start();

/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/*pass hidden*/
$pass = ########
$db = 'sean';
$dbport = 3306;
$mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);


$email = $_SESSION['email'];

?>
<br />
USE THIS AREA TO UPLOAD YOUR MUSIC
<br />
FIRST CREATE AN ARTIST NAME
<br />
THEN CREATE AN ALBUM
<br />
THEN ADD SONGS TO THE ALBUM
<br />
<a href="https://www.waylostreams.com/login-system/displayStreams.php">View your streaming/payment data</a>
<br />
<br />
<a href="https://www.waylostreams.com/login-system/viewAlbumData.php">View/edit/Delete Your Albums </a>
<br />
<br />

<a href="https://www.waylostreams.com/login-system/viewSongData.php">View/edit/Delete Your Songs </a>
<br />
<br />

<a href="https://www.waylostreams.com/login-system/viewArtistData.php">View/edit/Delete Your Artists </a>
<br />
<br />
<a href="https://www.waylostreams.com/login-system/createArtist.php">Add another artist </a>
<br />

<br />
<a href="https://www.waylostreams.com/login-system/createAlbum.php">Add another album </a>
<br />
<br />
<a href="https://www.waylostreams.com/login-system/addSong.php">Add a song to an album </a>
<br />

<br />
<a href="https://www.waylostreams.com/login-system/profile.php">Go back to profile page </a>
<br />
