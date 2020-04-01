
<?php include 'pageHeader.php';?>

<?php

require('db.php');


session_start();
$email = $_SESSION['email'];
$host = 'localhost';
$user = 'seanwayland';
/* pass hidden */
$pass = #########
$db = 'sean';
$dbport = 3306;
$conn = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);

echo $email;
$result = $mysqli->query("SELECT * FROM songs WHERE artist_email='$email'") or die($mysqli->error);


foreach($result as $key) {

    $name = $key["id"];
    $streams = $mysqli->query("SELECT * FROM streams WHERE song_id='$name'") or die($mysqli->error);

        while($row = mysqli_fetch_array($streams)) {

echo "stream_id :" . $row["stream_id"];
echo "<br>";
echo " user_id  :" . $row["user_id"];
echo "<br>";
echo " song_id : " . $row["song_id"];
echo "<br>";
echo " purchase_cost : " . $row["purchase_cost"];
echo "<br>";
echo " number_plays : " . $row["number_plays"];
echo "<br>";
echo " unpaid_plays : " . $row["unpaid_plays"];
echo "<br>";
echo " last_payment_date :" . $row["last_payment_date"];
echo "<br>";
echo " last_access_time : ". $row["last_access_time"];
echo "<br>";
echo " first_access_time : ". $row["first_access_time"];
echo "<br>";
echo "<br>";
echo "<br>";


        }


}




