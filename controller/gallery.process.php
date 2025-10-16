<?php
include('../model/dbconn.php'); // change path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data safely
    $account_id = $_POST['account_id'] ?? null;
    $caption = trim($_POST['caption'] ?? '');

    // Validate required fields
    if (!$account_id || empty($caption)) {
        die("❌ Missing account ID or caption.");
    }

    // File upload logic
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $target_dir = "../uploads/";

        // Create uploads folder if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Rename the uploaded file uniquely
        $file_ext = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
        $file_name = uniqid("IMG_", true) . "." . $file_ext;
        $target_file = $target_dir . $file_name;

        // Allow only image types
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($file_ext, $allowed_types)) {
            die("❌ Invalid file type. Only JPG, PNG, GIF, and WEBP allowed.");
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Save post data to database
            $stmt = $conn->prepare("INSERT INTO gallery (account_id, caption, image_path) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $account_id, $caption, $target_file);

            if ($stmt->execute()) {
                header("Location: ../view/gallery.php?upload=success");
                exit;
            } else {
                echo "❌ Database error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "❌ Failed to upload image.";
        }
    } else {
        echo "❌ Please select an image to upload.";
    }
}


// --------------------------
// 🔵 SELECT / FETCH POSTS
// --------------------------
function fetchGalleryPosts($conn) {
    $posts = [];
    $query = "SELECT g.*, a.name AS user_name 
            FROM gallery g
            JOIN accounts a ON g.account_id = a.account_id
            ORDER BY g.created_at DESC";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}



// ❌ REMOVE THIS LINE
// $conn->close();
?>
