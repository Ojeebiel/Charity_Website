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
$sql_my = "SELECT fundraiser_id, account_id, name, date, amount_donated, amount_goal, description, address, longitude, latitude, image, date 
            FROM fundraisers 
            WHERE account_id = '$account_id' AND amount_donated < amount_goal AND date != CURDATE() ";
$result_my = mysqli_query($conn, $sql_my);
$myFundraisers = [];
while ($row = mysqli_fetch_assoc($result_my)) {
    $myFundraisers[] = $row;
}

// --- Fetch fundraisers from other users ---
// --- Fetch fundraisers from other users (still open & not owned by current user) ---
$sql_others = " SELECT fundraiser_id, account_id, name, date, amount_goal, description, address, longitude, latitude, image, qr_image, number, created_at,amount_donated FROM fundraisers WHERE account_id != ? AND amount_donated < amount_goal AND date != CURDATE() ";

$stmt = $conn->prepare($sql_others);
$stmt->bind_param("i", $account_id);
$stmt->execute();
$result_others = $stmt->get_result();

$otherFundraisers = [];
while ($row = $result_others->fetch_assoc()) {
    $otherFundraisers[] = $row;
}



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



