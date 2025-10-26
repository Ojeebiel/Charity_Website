<?php
require '../model/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $account_id = mysqli_real_escape_string($conn, $_POST['account_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $amount_goal = mysqli_real_escape_string($conn, $_POST['amount_goal']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);

    // Directory for uploads
    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // --- Handle QR image upload ---
    $qr_image_path = "";
    if (!empty($_FILES['qr_image']['name'])) {
        $qr_filename = uniqid("QR_") . "_" . basename($_FILES['qr_image']['name']);
        $qr_target = $target_dir . $qr_filename;
        if (move_uploaded_file($_FILES['qr_image']['tmp_name'], $qr_target)) {
            $qr_image_path = $qr_target;
        }
    }

    // --- Handle attachment upload ---
    $image_path = "";
    if (!empty($_FILES['image']['name'])) {
        $img_filename = uniqid("IMG_") . "_" . basename($_FILES['image']['name']);
        $img_target = $target_dir . $img_filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $img_target)) {
            $image_path = $img_target;
        }
    }

    // --- Save data into the database ---
    $sql = "INSERT INTO fundraisers 
            (account_id, name, date, amount_goal, description, address, longitude, latitude, number, qr_image, image)
            VALUES 
            ('$account_id', '$name', '$date', '$amount_goal', '$description', '$address', '$longitude', '$latitude', '$number', '$qr_image_path', '$image_path')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../view/initiate.php?success=1");
        exit();
    } else {
        echo "❌ Database error: " . mysqli_error($conn);
        header("Location: ../view/initiate.php?error=db");
        exit();
    }
}
?>
