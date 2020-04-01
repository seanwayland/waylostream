<?php
require('db.php');


/**
 * album_title
 * album_artist
release_date
image_url
credits
artist_email
 */


session_start();
$email = $_SESSION['email'];

/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/* pass hidden */ 
$pass = #######
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

    <h2>Your Albums</h2>
    <table width="100%" border="1" style="border-collapse:collapse;">
        <thead>
        <tr>
            <th><strong>Album #</strong></th>
            <th><strong>Album Title </strong></th>
            <th><strong>Album Artist</strong></th>
            <th><strong>Release Date </strong></th>
            <th><strong>Credits </strong></th>
            <th><strong>Edit</strong></th>
            <th><strong>Delete</strong></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count=1;

        $result = $mysqli->query("SELECT * FROM albums WHERE artist_email='$email'") or die($mysqli->error);
        //$row = mysqli_fetch_assoc($result);

        //$artist = $row['artist'];









        while($row = mysqli_fetch_assoc($result)) {

            $artist = $row['album_artist'];
            $result2 = $mysqli->query("select * from artists where id = '$artist'") or die($mysqli->error);

            $row2 = mysqli_fetch_assoc($result2);


            ?>
            <tr><td align="center"><?php echo $count; ?></td>
                <td align="center"><?php echo $row["album_title"]; ?></td>
                <td align="center"><?php echo $row2["artist_name"]; ?></td>
                <td align="center"><?php echo $row["release_date"]; ?></td>
                <td align="center"><?php echo $row["credits"]; ?></td>
                <td align="center">
                    <a href="editAlbum.php?id=<?php echo $row["album_title"]; ?>">Edit</a>
                </td>
                <td align="center">
                    <a href="deleteAlbum.php?id=<?php echo $row["album_title"]; ?>">Delete</a>
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
