<?php



$host = 'localhost';
$user = 'seanwayland';
/* pass hidden */
$pass = ########
$db = 'sean';
$dbport = 3306;



require 'db.php';
session_start();

$email = $_SESSION['email'];

$mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);


$sql = "UPDATE songs SET purchase_cost = 25 WHERE artist_email = '$email' ";
$mysqli->query($sql) or die($mysqli->error);

$sql = "UPDATE songs SET stream_cost = 1 WHERE artist_email = '$email' ";
$mysqli->query($sql) or die($mysqli->error);

$sql = "UPDATE songs SET artist_email = '$email' ";
$mysqli->query($sql) or die($mysqli->error);
