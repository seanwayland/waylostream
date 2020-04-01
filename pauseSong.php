

<?php
// when a song is paused by a user the song id is saved in the users database as being paused
/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/** pass hidden **/
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

$sql = "UPDATE users SET isPaused='$id' WHERE id ='$user_id'";
$mysqli->query($sql) or die($mysqli->error);


?>

