<?php
// session_start();
require '../model/dbconn.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "✅ POST received<br>";
    print_r($_POST);
} else {
    echo "❌ Not a POST request";
}

// ✅ Safely get account_id (or default to 0)
$account_id = $_SESSION['account_id'] ?? 0;

// --- Fetch your own fundraisers ---
$sql_my = "SELECT fundraiser_id, account_id, name, date, amount_goal, description, address, longitude, latitude, image 
            FROM fundraisers 
            WHERE account_id = '$account_id'";
$result_my = mysqli_query($conn, $sql_my);
$myFundraisers = [];
while ($row = mysqli_fetch_assoc($result_my)) {
    $myFundraisers[] = $row;
}

// --- Fetch fundraisers from other users ---
$sql_others = "SELECT fundraiser_id, account_id, name, date, amount_goal, description, address, longitude, latitude, image 
                FROM fundraisers 
                WHERE account_id != '$account_id'";
$result_others = mysqli_query($conn, $sql_others);
$otherFundraisers = [];
while ($row = mysqli_fetch_assoc($result_others)) {
    $otherFundraisers[] = $row;
}
print_r($_POST);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values
    $account_id = $_POST['account_id'];
    $recipient_id = $_POST['recipient_id'];
    $fundraiser_id = $_POST['fundraiser_id'];
    $amount = $_POST['amount'];
    $ref_number = $_POST['ref_number'];

    // Insert into database
    $query = "INSERT INTO donation (account_id, recipient_id, fundraiser_id, amount, ref_number)
              VALUES ('$account_id', '$recipient_id', '$fundraiser_id', '$amount', '$ref_number')";

    if (mysqli_query($conn, $query)) {
        echo "Donation successfully recorded!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>



