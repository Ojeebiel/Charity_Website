<?php
require '../model/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $account_id = mysqli_real_escape_string($conn, $_POST['account_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $amount_goal = mysqli_real_escape_string($conn, $_POST['accountNumber']); // ✅ renamed correctly
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // ✅ New fields
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);

    // ✅ File upload handling (QR or attachment)
    $image_name = $_FILES['qrImage']['name'] ?? '';
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($image_name);

    // create folder if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // move the file to the uploads folder
    if (move_uploaded_file($_FILES['qrImage']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO fundraisers 
                (account_id, name, date, amount_goal, description, address, longitude, latitude, image)
                VALUES 
                ('$account_id', '$name', '$date', '$amount_goal', '$description', '$address', '$longitude', '$latitude', '$target_file')";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: ../view/initiate.php?success=1");
            exit();
        } else {
            header("Location: ../view/initiate.php?error=db");
            exit();
        }

    } else {
        header("Location: ../view/initiate.php?error=upload");
        exit();
    }
}
?>
