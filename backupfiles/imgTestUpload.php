<?php
// Connect to your MySQL database
$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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

<!DOCTYPE html>
<html>
<head>
    <title>Upload Image Test</title>
</head>
<body>
    <h2>Upload Image</h2>

    <?php
    if (isset($_GET['success'])) {
        echo "<p style='color:green;'>Image uploaded successfully!</p>";
    } elseif (isset($_GET['error'])) {
        echo "<p style='color:red;'>Something went wrong. Error: " . htmlspecialchars($_GET['error']) . "</p>";
    }
    ?>

    <form action="imgTestUpload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" required>
        <button type="submit" name="upload">Upload</button>
    </form>

    <hr>

    <h3>Uploaded Images</h3>
    <?php
    $result = mysqli_query($conn, "SELECT * FROM test_images ORDER BY upload_date DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style='margin-bottom:10px;'>
                <img src='" . $row['image_path'] . "' width='150'><br>
                " . htmlspecialchars($row['image_name']) . "
              </div>";
    }
    ?>
</body>
</html>
