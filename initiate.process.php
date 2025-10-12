<?php
require 'dbconn.php';


// if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['upload'])) {

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $date = $_POST['date'];
    $amount_goal = mysqli_real_escape_string($conn, $_POST['amount']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = "Not Set";



    // folder for uploads
    $image_name = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image_name);


    // create folder if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // move the file to the uploads folder
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
         $sql = "INSERT INTO fundraisers (name, date, amount_goal, description, location, image) VALUES ('$name', '$date', '$amount_goal', '$description', '$location', '$target_file')";
        if (mysqli_query($conn, $sql)) {
            // Redirect to avoid resubmission on reload
            header("Location: initiate.php?success=1");
            exit();
        } else {
            header("Location: initiate.php?error=db");
            exit();
        }

    } else {
        header("Location: initiate.php?error=upload");
        exit();
    }
}
?>
