<?php
// login.process.php
session_start();
require '../model/dbconn.php';

// 1. Retrieve form data
$email = trim($_POST['email']);
$password = trim($_POST['password']);

// 2. Basic validation
if (empty($email) || empty($password)) {
    die("<script>alert('Please fill in all fields.'); window.history.back();</script>");
}

// 3. Prepare statement to fetch user
$sql = "SELECT account_id, name, password FROM Accounts WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// 4. Verify credentials
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Password is correct ✅
        $_SESSION['account_id'] = $user['account_id'];
        $_SESSION['name'] = $user['name'];
        
        echo "<script>
            alert('Welcome back, " . addslashes($user['name']) . "!');
            window.location.href = '../view/gallery.php';
        </script>";
        exit;
    } else {
        // Wrong password
        header("Location: ../index.php?error=true");
        exit;
    }
} else {
    // Email not found
    header("Location: ../index.php?error=true");
    exit;
}

$stmt->close();
$conn->close();
?>
