<?php
session_start();

require '../model/dbconn.php';


$sql = "SELECT name, date, amount_goal, description, location, image FROM fundraisers";
$result = mysqli_query($conn, $sql);

$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}
echo "Count: " . count($rows);


// Store array in session
$_SESSION['fundraisers'] = $rows;

// Redirect to output.php
session_write_close();
header("Location: fundraisers.php");
exit();



?>