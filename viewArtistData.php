<?php
require('db.php');


/**
sex
 * birth_country
 * location_city
 * artist_bio
 */


session_start();
$email = $_SESSION['email'];
$email = $mysqli->real_escape_string($email);

/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/* pass hidden */
$pass = ##########
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

    <h2>Your Artists</h2>
    <table width="100%" border="1" style="border-collapse:collapse;">
        <thead>
        <tr>
            <th><strong>Artist #</strong></th>
            <th><strong>Artist Name</strong></th>
            <th><strong>Artist Sex</strong></th>
            <th><strong>Birth Country</strong></th>
            <th><strong>Location City</strong></th>
            <th><strong>Artist Bio</strong></th>
            <th><strong>Edit</strong></th>
            <th><strong>Delete</strong></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $email = $_SESSION['email'];
        $email = $mysqli->real_escape_string($email);
        $count=1;

        $result = $mysqli->query("SELECT * FROM artists WHERE email='$email'") or die($mysqli->error);
        //$row = mysqli_fetch_assoc($result);




        while($row = mysqli_fetch_assoc($result)) {



            ?>
            <tr><td align="center"><?php echo $count; ?></td>
                <td align="center"><?php echo $row["artist_name"]; ?></td>
                <td align="center"><?php echo $row["sex"]; ?></td>
                <td align="center"><?php echo $row["birth_country"]; ?></td>
                <td align="center"><?php echo $row["location_city"]; ?></td>
                <td align="center"><?php echo $row["artist_bio"]; ?></td>
                <td align="center">
                    <a href="editArtist.php?id=<?php echo $row["id"]; ?>">Edit</a>
                </td>
                <td align="center">
                    <a href="deleteArtist.php?id=<?php echo $row["id"]; ?>">Delete</a>
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
