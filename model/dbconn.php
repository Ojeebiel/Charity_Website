<?php 

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "charity_website";

    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // else{
    //     echo "Database Connection Successful";
    // }

?>