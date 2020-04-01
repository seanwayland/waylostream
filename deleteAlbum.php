<?php

require('db.php');


session_start();
$email = $_SESSION['email'];

/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/* pass hidden */
$pass = ##########
$db = 'sean';
$dbport = 3306;
$mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);

$id=$_REQUEST['id'];
$query = $mysqli->prepare("DELETE FROM albums WHERE album_title= '$id' and artist_email='$email'");
$query->bind_param('is', $id, $email);
$query->execute();

header("Location: viewAlbumData.php");
?>
