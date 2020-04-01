<?php



/**
 * album_title
 * album_artist
release_date
image_url
credits
artist_email
 */


require('db.php');


session_start();
$email = $_SESSION['email'];

/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/* pass hidden */ 
$pass = #########
$db = 'sean';
$dbport = 3306;
$mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);



$id=$_REQUEST['id'];

$result = $mysqli->prepare("SELECT * FROM albums WHERE album_title='$id'");
$result->bind_param('is', $id, $email);
$result->execute();

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


        $album_artist =$_REQUEST['album_artist'];

        $result = $mysqli->prepare("select * from artists where artist_name = '$album_artist'");
        $result->bind_param('s', $album_artist);
        $result->execute();
        

        $row1 = mysqli_fetch_assoc($result);
        $album_artist = $row1['id'];
        $album_artist = intval($album_artist);


        $credits =$_REQUEST['credits'];
        $album_title = $_REQUEST['album_title'];

        $update= $mysqli->prepare("update albums set album_title= '$album_title' , credits= '$credits'  where album_title = '$id'");
        $update->bind_param('sii', $album_title, $id);
        $update->execute();
        $status = "Record Updated Successfully. </br></br>
<a href='viewAlbumData.php'>View Updated Records</a>";
        echo '<p style="color:#FF0000;">'.$status.'</p>';

    }else {
    ?>
    <div>
        <form name="form" method="post" action="">
            <input type="hidden" name="new" value="1" />
            <input name="id" type="hidden" value="<?php echo $row['album_title'];?>" />
            Change album artist
            <br>
            <p><input type="text" name="album_title" placeholder="Enter new album name"
                      required value="<?php echo $row['album_title'];?>" /></p>
            Change credits
            <br>
            <p><input type="text" name="credits" placeholder="Enter new credits"
                      required value="<?php echo $row['credits'];?>" /></p>
            <p><input name="submit" type="submit" value="Update" /></p>
        </form>
        <?php } ?>
    </div>
</div>
</body>
</html>
