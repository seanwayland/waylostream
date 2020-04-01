<?php

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
$result = $mysqli->query("SELECT * FROM songs WHERE title='$id'") or die($mysqli->error);

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

        $purchase_cost =$_REQUEST['purchase_cost'];
        //$purchase_cost = mysqli_escape_string($purchase_cost);
        $pCost = intval($purchase_cost);
        //
        //echo $purchase_cost;
        $stream_cost =$_REQUEST['stream_cost'];
        //$stream_cost = mysqli_escape_string($stream_cost);
        $sCost = intval($stream_cost);
        //
        //echo $stream_cost;

        // $update="update songs set purchase_cost= 2 , stream_cost = 3 where title='$id'";
        $update="update songs set purchase_cost= $pCost , stream_cost= $sCost  where title = '$id'";
        $mysqli->query($update) or die($mysqli->error);
        $status = "Record Updated Successfully. </br></br>
<a href='viewSongData.php'>View Updated Records</a>";
        echo '<p style="color:#FF0000;">'.$status.'</p>';

    }else {
    ?>
    <div>
        <form name="form" method="post" action="">
            <input type="hidden" name="new" value="1" />
            <input name="id" type="hidden" value="<?php echo $row['title'];?>" />
            Change purchase cost
            <br>
            <p><input type="text" name="purchase_cost" placeholder="Enter Purchase Cost"
                      required value="<?php echo $row['purchase_cost'];?>" /></p>
            Change stream cost
            <br>
            <p><input type="text" name="stream_cost" placeholder="Enter Stream Cost"
                      required value="<?php echo $row['stream_cost'];?>" /></p>
            <p><input name="submit" type="submit" value="Update" /></p>
        </form>
        <?php } ?>
    </div>
</div>
</body>
</html>
