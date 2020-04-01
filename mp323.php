<?php
    
    require '../login-system/db.php';
    session_start();
   // do these need to be global  ?
    global $id;
    global $sql;
    global $mysqli;
    global $result;
    global $row;
    global $filename;
    
    /* Database connection settings */
    $host = 'localhost';
    $user = 'seanwayland';
/* pass hidden */ 
    $pass = ######## 
    $db = 'sean';
    $dbport = 3306;
    $mysqli = new mysqli($host,$user,$pass,$db,$dbport) or die($mysqli->error);
    
    // get ID variable passed from dbtest23
    // I think this variable is being set to NULL don't know why
    $id = $_GET['id'];
    //echo $id;

    $sql = ('SELECT URL FROM songs WHERE id='.$id.'');
    // get the result object.
    $result = $mysqli->query($sql);
    // Associative array
    //echo $result;
    $row=mysqli_fetch_assoc($result);
    // get the URL from the array result
    //echo $row;
    $filename = ($row['URL']);
// function to stream file 
    function get_content($URL){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $URL);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;

    }
    
    echo get_content($filename);

    
?>
