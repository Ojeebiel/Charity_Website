<?php
// Connect to your MySQL database
session_start();
require 'dbconn.php'; 

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['upload'])) {
    $image_name = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image_name);

    // Check if the uploads folder exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Move the uploaded file
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert into DB
        $sql = "INSERT INTO test_images (image_name, image_path) VALUES ('$image_name', '$target_file')";
        if (mysqli_query($conn, $sql)) {
            // Redirect to avoid resubmission on reload
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit();
        } else {
            header("Location: " . $_SERVER['PHP_SELF'] . "?error=db");
            exit();
        }
    } else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=upload");
        exit();
    }
}
?>