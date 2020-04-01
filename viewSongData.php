<?php
require('db.php');


session_start();
$email = $_SESSION['email'];

/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/* pass hidden */
$pass = ######
$db = 'sean';
$dbport = 3306;
$mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>View Records</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">

    <h2>Your Songs</h2>
    <table width="100%" border="1" style="border-collapse:collapse;">
        <thead>
        <tr>
            <th><strong>Song #</strong></th>
            <th><strong>Title </strong></th>
            <th><strong>Stream Cost</strong></th>
            <th><strong>Purchase Cost </strong></th>
            <th><strong>Edit</strong></th>
            <th><strong>Delete</strong></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count=1;

        $result = $mysqli->query("SELECT * FROM songs WHERE artist_email='$email'") or die($mysqli->error);




        while($row = mysqli_fetch_assoc($result)) { ?>
            <tr><td align="center"><?php echo $count; ?></td>
                <td align="center"><?php echo $row["title"]; ?></td>
                <td align="center"><?php echo $row["stream_cost"]; ?></td>
                <td align="center"><?php echo $row["purchase_cost"]; ?></td>
                <td align="center">
                    <a href="editSong.php?id=<?php echo $row["title"]; ?>">Edit</a>
                </td>
                <td align="center">
                    <a href="deleteSong.php?id=<?php echo $row["title"]; ?>">Delete</a>
                </td>
            </tr>
            <?php $count++; } ?>
        </tbody>
    </table>
</div>

<br />
<a href="https://www.waylostreams.com/login-system/profile.php">Go back to profile page </a>
<br />



<a href="https://www.waylostreams.com/login-system/artistArea.php">artists area / upload music </a>
<br />
</body>
</html>
