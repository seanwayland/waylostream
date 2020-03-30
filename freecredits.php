<?php
    /* User login process, checks if user exists and password is correct */
    require 'db.php';
    session_start();
    // Escape email to protect against SQL injections
    $email = $mysqli->escape_string($_SESSION['email']);
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();
    $credits = $user['credits'];

    $freeCredits = $user['freeCreditBool'];
 
        if ($freeCredits < 1) {
            $credits = $credits + 10;
            $sql = "UPDATE users SET credits='$credits' WHERE email='$email'";
            $mysqli->query($sql);
            $sql = "UPDATE users SET freeCreditBool= 1 WHERE email='$email'";
            $mysqli->query($sql);
            header("location: profile.php");
        } else {
            header("location: profile.php");
        }
    
    

