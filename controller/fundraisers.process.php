<?php
// session_start();
require '../model/dbconn.php';

// ✅ Safely get account_id (or default to 0)
$account_id = $_SESSION['account_id'] ?? 0;

// --- Fetch your own fundraisers ---
$sql_my = "SELECT fundraiser_id, account_id, name, date, amount_goal, description, location, image 
            FROM fundraisers 
            WHERE account_id = '$account_id'";
$result_my = mysqli_query($conn, $sql_my);
$myFundraisers = [];
while ($row = mysqli_fetch_assoc($result_my)) {
    $myFundraisers[] = $row;
}

// --- Fetch fundraisers from other users ---
$sql_others = "SELECT fundraiser_id, account_id, name, date, amount_goal, description, location, image 
                FROM fundraisers 
                WHERE account_id != '$account_id'";
$result_others = mysqli_query($conn, $sql_others);
$otherFundraisers = [];
while ($row = mysqli_fetch_assoc($result_others)) {
    $otherFundraisers[] = $row;
}
?>
