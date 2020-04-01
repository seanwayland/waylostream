<?php
    /* Database connection settings */
    $host = 'localhost';
    $user = 'seanwayland';
/* pass hidden */
    $pass = ############
    $db = 'sean';
    $dbport = 3306;
    $mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);
?>
<!DOCTYPE html>
<html>
<head>
</head>
//<body>
<body oncontextmenu="return false;">
<?php
$sql = ('SELECT URL FROM songs WHERE id=1');
// get the result object.
$result = $mysqli->query($sql);
// Associative array
$row=mysqli_fetch_assoc($result);

?>

<audio controls controlsList="nodownload noremoteplayback">
<source src="mp3.php?id=1" type="audio/mpeg">
//<source src="<?php echo $row["URL"]; ?>" type="audio/mpeg">
</audio>
</body>
</html>

