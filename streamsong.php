

<?php

/* Database connection settings */
$host = 'localhost';
$user = 'seanwayland';
/* pass hidden */
$pass = #######
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



// get purchase cost

$purchase_cost = 1;
$exists = $mysqli->query("SELECT stream_id FROM streams WHERE user_id='$user_id' AND song_id ='$id'") or die($mysqli->error);

$exists2 = $exists->fetch_assoc();
$streamid = $exists2['stream_id'];
//echo " stream id is ";
//echo $streamid;
//echo " ";
if ($exists2 !== null)
{
    // if song has been played before by user do nothing for now
    //echo "stream exists";
    // increment streams counter , take credits off user
    // get streams counter
    $counter = $mysqli->query("SELECT number_plays FROM streams WHERE user_id='$user_id' AND song_id ='$id'") or die($mysqli->error);
    $counter = $counter->fetch_assoc();
    $counter = $counter['number_plays'];
    $unpaid = $counter['unpaid_plays'];

    $counter = $mysqli->escape_string($counter);

    $unpaid = $mysqli->escape_string($unpaid);
    echo " number plays is ";
    echo $counter;
    echo " ";
    $date = date('Y-m-d');
    $date = $mysqli->escape_string($date);
    $sql = "UPDATE streams SET number_plays='$counter' WHERE user_id ='$user_id' AND song_id ='$id'";

    $mysqli->query($sql) or die($mysqli->error);


    $sql = "UPDATE streams SET unpaid_plays='$unpaid' WHERE user_id ='$user_id' AND song_id ='$id'";

    $mysqli->query($sql) or die($mysqli->error);
    $sql = "UPDATE streams SET last_access_time= '$date' WHERE user_id ='$user_id' AND song_id ='$id'";
    $mysqli->query($sql) or die($mysqli->error);

    $result = $mysqli->query("SELECT * FROM users WHERE id='$user_id'");
    $user = $result->fetch_assoc();
    $credits = $user['credits'];

    $sql = "UPDATE users SET credits= '$credits' WHERE id ='$user_id'";
    $mysqli->query($sql) or die($mysqli->error);

    //echo $date;
    //echo " ";
    //echo $counter;
    //echo " ";
    //echo $id;
    //echo " ";

    echo $counter;

}
else {
    //echo "stream doesn't exist";
    // create stream in table+

    $stream_id = $mysqli->escape_string('1');


    $purchase_cost = $mysqli->escape_string($purchase_cost);
    $number_plays = 1;
    $number_plays = $mysqli->escape_string($number_plays);
    $unpaid = 1;
    // insert new stream into streams table fisrt time a song is played by a user
    $sql = "INSERT INTO streams ( user_id, song_id, purchase_cost, number_plays, unpaid_plays, first_access_time, last_access_time) "
        . "VALUES ('$user_id','$id','$purchase_cost', $number_plays, $unpaid, now(), now())";

    $mysqli->query($sql) or die($mysqli->error);
    //echo $counter;

}

//echo $counter;
//echo "<br>";




