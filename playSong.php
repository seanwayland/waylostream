
<?php include 'pageHeader.php';?>

<?php
    // this file updates the streams table in the database
    // the user and song_id are passed in with say streamsong.php?id=1&user=13
    // it checks to see if the user has already played the song if so it increments the counter
    // if the user has never played the song it creates a new row in the DB linking the song to the user
    // connection settings
    //require '../login-system/db.php';
    //session_start();
    // do these need to be global  ?
    /*
     
     
     */
    /* Database connection settings */
    $host = 'localhost';
    $user = 'seanwayland';
/* pass hidden */ 
    $pass = ##########
    $db = 'sean';
    $dbport = 3306;
    $mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);
    
    // get song id from page call
    $id = $_GET['id'];
    $user = $_GET['user'];
    
    $id = $mysqli->escape_string($id);
    $user_id = $mysqli->escape_string($user);
    
    $song_id = $mysqli->escape_string($id);
    $result1 = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
    $song = $result->fetch_assoc();
    $purchase_cost = $song['stream_cost'];
    $buy_cost = $song['purchase_cost'];
    
    
    
    $filename = $song['URL'];
    
    
    //////////           UPDATE STREAMS AND CREDITS FROM DATABASE
    
    
    
    $exists = $mysqli->query("SELECT stream_id FROM streams WHERE user_id='$user_id' AND song_id ='$id' AND purchase_cost = '$purchase_cost'") or die($mysqli->error);
    
    $exists2 = $exists->fetch_assoc();
    $streamid = $exists2['stream_id'];
    
    if ($exists2 !== null)
    {
        // if song has been played before by user do nothing for now
        //echo "stream exists";
        // increment streams counter , take credits off user
        // get streams counter
        $counter = $mysqli->query("SELECT number_plays FROM streams WHERE user_id='$user_id' AND song_id ='$id'") or die($mysqli->error);
        $counter = $counter->fetch_assoc();
        $counter = $counter['number_plays'];
        $counter = $counter + 1;
        $counter = $mysqli->escape_string($counter);
        
        $unpaid = $counter['unpaid_plays'];
        $unpaid = $unpaid + 1;
        $unpaid = $mysqli->escape_string($unpaid);
        //echo " number plays is ";
        //echo $counter;
        // echo " ";
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
        
        $song_id = $mysqli->escape_string($id);
        $result = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
        $song = $result->fetch_assoc();
        $purchase_cost = $song['stream_cost'];
        
        $credits = $credits - $purchase_cost;
        $sql = "UPDATE users SET credits= '$credits' WHERE id ='$user_id'";
        $mysqli->query($sql) or die($mysqli->error);
        
        if($credits<0){
            header("Location: https://www.waylostreams.com/login-system/profile.php");
        }
        
        //echo $date;
        //echo " ";
        //echo $counter;
        //echo " ";
        //echo $id;
        //echo " ";
        
        //echo $counter;
        
    }
    else {
        //echo "stream doesn't exist";
        // create stream in table+
        
        $result = $mysqli->query("SELECT * FROM users WHERE id='$user_id'");
        $user = $result->fetch_assoc();
        $credits = $user['credits'];
        
        $song_id = $mysqli->escape_string($id);
        $result = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
        $song = $result->fetch_assoc();
        $purchase_cost = $song['stream_cost'];
        
        $credits = $credits - $purchase_cost;
        $sql = "UPDATE users SET credits= '$credits' WHERE id ='$user_id'";
        $mysqli->query($sql) or die($mysqli->error);
        
        $stream_id = $mysqli->escape_string('1');
        
        
        $purchase_cost = $mysqli->escape_string($purchase_cost);
        $number_plays = 1;
        $number_plays = $mysqli->escape_string($number_plays);
        $unpaid = 1;
        $unpaid = $mysqli->escape_string($unpaid);
        
        // insert new stream into streams table fisrt time a song is played by a user
        $sql = "INSERT INTO streams ( user_id, song_id, purchase_cost, number_plays, unpaid_plays, first_access_time, last_access_time) "
        . "VALUES ('$user_id','$id','$purchase_cost', '$number_plays', '$unpaid', now(), now())";
        
        $mysqli->query($sql) or die($mysqli->error);
        //echo $counter;
        
    }
    
    //echo $counter;
    //echo "<br>";
    
    
    
    
    
    /* Displays user information and some useful messages */
    require 'db.php';
    //session_start();
    // Check if user is logged in using the session variable
    if ( $_SESSION['logged_in'] != 1 ) {
        $_SESSION['message'] = "You must log in before viewing your profile page!";
        header("location: error.php");
    }
    else {
        // Makes it easier to read
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $email = $_SESSION['email'];
        $active = $_SESSION['active'];
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
        $user = $result->fetch_assoc();
        $credits = $user['credits'];
    }
    
    
    
    ?>
<!DOCTYPE html>
<html >

<style>

img {
width: 30%;
height: 30%;
    
}

body {
background: #D3D3D3D3; 
    font-family: 'Titillium Web', sans-serif;
}
/*


input[type=text] {
    background-color: white;
color: black;
}


a:link {
color: #1ab188;
}


a:visited {
color: blue;
}


a:hover {
color: green;
}


a:active {
color: greenyellow;
}


button {
    background-color: #1ab188;
border: none;
color: black;
padding: 15px 32px;
    text-align: center;
    text-decoration: none;
display: inline-block;
    font-size: 16px;
}



*/
</style>
<head>
<?php // include 'css/css.html'; ?>


<body>


<a href="https://www.waylostreams.com/login-system/buycredits.php">BUY CREDITS</a>
<br />
<br />
<br />

<?php
    echo "You have: ";
    echo $credits;
    echo " credits";
    echo "<br>";
    $id = $_GET['id'];
    $user = $_GET['user'];
    //echo "ID is ";
    //echo $id;
    //echo "  user is ";
    //echo $user;
    //echo " ";
    $id = $mysqli->escape_string($id);
    $user_id = $mysqli->escape_string($user);
    $song_id = $id;
    
    // fetch the logged in users email
    $email = $mysqli->escape_string($_SESSION['email']);
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
    
    // grab the song purchase cost from the songs table
    
    $song_id = $mysqli->escape_string($song_id);
    $result = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
    $song = $result->fetch_assoc();
    $purchase_cost = $song['stream_cost'];
    
    // this code below a sticks up an html audio player and calls the source file
    // from the database. It selects the URL of the source and then
    // streams the file secretly
    ?>


<?php
    
    
    $song_id = $mysqli->escape_string($id);
    $result = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
    $song = $result->fetch_assoc();
    $songTitle = $song['title'];
    $albumTitle = $song['album'];
    $artistTitle = $song['artist'];
    $songCost = $song['stream_cost'];
    $buyCost = $song['purchase_cost'];
    $filename = $song['URL'];
    
    
    
    
    
    echo "Song is: ";
    echo $songTitle;
    echo "<br />";
    
    
    // get album title
    $r1 = $mysqli->query("SELECT * FROM albums WHERE album_id='$albumTitle'");
    $song = $r1->fetch_assoc();
    $albumTitle = $song['album_title'];
    $coverURL = $song['image_url'];
    $albumCredits = $song['credits'];
    
    echo "Album is: ";
    echo $albumTitle;
    echo "<br />";
    ?>
<br />
<img src="<?php echo $coverURL; ?>" />
<?php
    
    echo "<br />";
    echo "This song is: ";
    echo "$songTitle";
    echo "<br />";
    
    
    $r2 = $mysqli->query("SELECT * FROM artists WHERE id='$artistTitle'");
    $song = $r2->fetch_assoc();
    $artistTitle = $song['artist_name'];
    
    echo "Artist is: ";
    echo $artistTitle;
    echo "<br />";
    
    
    
    
    
    
    ?>


<br />

<br />



CLICK PLAY TO PLAY SONG  <br />


<!-- play audio file but stop it from being downloadable -->
<audio oncontextmenu="return false;" controls autobuffer onplay="log_stream1()" controls controlsList="nodownload noremoteplayback">
<!-- get the source as a file from -->
<!--   <source src="https://www.waylostreams.com/phptest/mp323.php?id=<?php echo $song_id;?>" type="audio/mp3"> -->
<source src="<?php echo $filename;?>" type="audio/mp3">
</audio>

<!--
<script>
var isPaused = function () {
    $.ajax({
           url: "http://www.waylostreams.com/phptest/pauseSong.php?id=1&user=<?php echo $user_id;?>",
           method: "GET"
           }).done(function() {
                   var update_text = "you have paused this ";
                   $('#response2').empty().append(update_text);
                   });
};
</script>

-->

<span id="response2"></span>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>

<script>

var log_stream1 = function () {
    $.ajax({
           url: "https://www.waylostreams.com/phptest/streamsong.php?id=<?php echo $song_id;?>&user=<?php echo $user_id;?>",
           method: "GET"
           }).done(function(response) {
                   var update_text = "you have played this " + response + " times";
                   $('#response3').empty().append(update_text);
                   });
};
</script>


<span id="response3"></span>
<br />
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>

<?php
    $counter = $mysqli->query("SELECT number_plays FROM streams WHERE user_id='$user_id' AND song_id ='$id'") or die($mysqli->error);
    $counter = $counter->fetch_assoc();
    $counter = $counter['number_plays'];
    $counter = $counter + 1;
    $counter = $mysqli->escape_string($counter);
    echo "You have played this song: ";
    echo $counter;
    echo " times";
    
    ?>


<?php
    $song_id = $mysqli->escape_string($id);
    $result = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
    $song = $result->fetch_assoc();
    $albumTitle = $song['album'];
    $artistTitle = $song['artist'];
    
    
    
    
    echo "<br />";
    
    $query = "SELECT song_id, SUM(number_plays) AS value_sum FROM streams WHERE song_id = '$song_id' GROUP BY song_id";
    
    $result = $mysqli->query($query) or die($mysqli->error);
    
    // Print out result
    while($row = mysqli_fetch_array($result)){
        echo "Total plays for this song to date: ". $row['value_sum'];
        echo " plays";
        echo "<br />";
    }
    
    /*
     $id = $mysqli->escape_string($id);
     $user_id = $mysqli->escape_string($user);
     
     $song_id = $mysqli->escape_string($id);
     $result1 = $mysqli->query("SELECT * FROM songs WHERE id='$song_id'");
     $song = $result->fetch_assoc();
     $purchase_cost = $song['stream_cost'];
     $buy_cost = $song['purchase_cost'];
     */
    
    /// links back to artist . album and profile page
    ?>
<br />
<a href='http://www.waylostreams.com/login-system/purchaseSong.php?id=<?php echo $song_id;?>&user=<?php echo $user_id;?>'> Click here to purchase this song </a>
<br />
purchase cost: <?php echo $buyCost; ?>
credits
<br/>
<?php
    print "<br>";
    echo "<a href='https://www.waylostreams.com/login-system/searchByAlbum.php?id=$albumTitle&user=$user_id'>more songs from this album </a>";
    print "<br>";
    echo "<a href='https://www.waylostreams.com/login-system/searchByArtist.php?id=$artistTitle&user=$user_id'>more songs from this artist </a>";
    print "<br>";
    
    ?>
<a href="http://www.waylostreams.com/login-system/profile.php">Go back to profile page </a>
<br />

<?php
    
    echo "<br>";
    echo "ALBUM CREDITS:";
    echo "<b>";
    echo "<b>";
    
    
    
    ?>

<br />

<?php echo $albumCredits; ?>

<br />
</body>
