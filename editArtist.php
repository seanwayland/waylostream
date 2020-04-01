<?php


/**
sex
 * birth_country
 * location_city
 * artist_bio
 */


require('db.php');


session_start();
$email = $_SESSION['email'];

/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/*pass hidden*/
$pass = ###########
$db = 'sean';
$dbport = 3306;
$mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);

$id=$_REQUEST['id'];
$result = $mysqli->query("SELECT * FROM artists WHERE id='$id'") or die($mysqli->error);

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
    <p><a href="profile.php">Home page</a>

    <h1>Update Record</h1>
    <?php
    $status = "";
    if(isset($_POST['new']) && $_POST['new']==1)
    {
        $id=$_REQUEST['id'];

        $artist_name =$_REQUEST['artistName'];
        $sex =$_REQUEST['sex'];
        $birth_country =$_REQUEST['birthCountry'];
        $artist_bio =$_REQUEST['artistBio'];
        $location_city =$_REQUEST['locationCity'];





        // $update="update songs set purchase_cost= 2 , stream_cost = 3 where title='$id'";
        $update="update artists set artist_name = '$artist_name ', sex= '$sex' , birth_country= '$birth_country' , location_city = '$location_city', artist_bio = '$artist_bio' where id = '$id'";
        $mysqli->query($update) or die($mysqli->error);
        $status = "Record Updated Successfully. </br></br>
<a href='viewArtistData.php'>View Updated Records</a>";
        echo '<p style="color:#FF0000;">'.$status.'</p>';

    }else {
    ?>
    <div>
        <form name="form" method="post" action="">
            <input type="hidden" name="new" value="1" />
            <input name="id" type="hidden" value="<?php echo $row['id'];?>" />
            Change Artist Name
            <br>
            <p><input type="text" name="artistName" placeholder="Enter Artist name"
                      required value="<?php echo $row['artist_name'];?>" /></p>
            Change Artist Sex
            <br>
            <p><input type="text" name="sex" placeholder="Enter Artist sex"
                      required value="<?php echo $row['sex'];?>" /></p>
            Change Birth Country
            <br>
            <p><input type="text" name="birthCountry" placeholder="Enter birth country"
                      required value="<?php echo $row['birth_country'];?>" /></p>
            Change Location City
            <br>
            <p><input type="text" name="locationCity" placeholder="Enter location city"
                      required value="<?php echo $row['location_city'];?>" /></p>
            Change Bio
            <br>
            <p><input type="text" name="artistBio" placeholder="Enter artist bio"
                      required value="<?php echo $row['artist_bio'];?>" /></p>


            <p><input name="submit" type="submit" value="Update" /></p>
        </form>
        <?php } ?>
    </div>
</div>
</body>
</html>
