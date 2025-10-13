<?php
// signup.process.php

// 1. Database connection
require '../model/dbconn.php';

// 2. Retrieve and sanitize form data
$name = trim($_POST['name']);
$mobile = trim($_POST['mobile']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Optional: Basic validation
if (empty($name) || empty($mobile) || empty($email) || empty($password)) {
    die("<script>alert('Please fill in all fields.'); window.history.back();</script>");
}

// 3. Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// 4. Insert into Accounts table

    //Double Check Email
$checkEmail = $conn->prepare("SELECT email FROM Accounts WHERE email = ?");
$checkEmail->bind_param("s", $email);
$checkEmail->execute();
$checkEmail->store_result();
if ($checkEmail->num_rows > 0) {
    die("<script>alert('Email already exists. Please use another one.'); window.history.back();</script>");
}
$checkEmail->close();

    //Insert
$sql = "INSERT INTO Accounts (name, mobile, email, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("ssss", $name, $mobile, $email, $hashedPassword);


//5.Execute
if ($stmt->execute()) {
    echo "<script>
        alert('Signup successful! You can now log in.');
        window.location.href = '../index.php';
    </script>";
} else {
    echo "<script>
        alert('Error during signup: " . addslashes($stmt->error) . "');
        window.history.back();
    </script>";
}

$stmt->close();
$conn->close();
?>
