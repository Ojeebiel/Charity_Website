<?php
include '../model/dbconn.php'; // adjust path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $donation_id = intval($_POST['donation_id']);
    $status = intval($_POST['status']);

    // Validate status (only allow 1 or 2)
    if (!in_array($status, [1, 2])) {
        die("Invalid status value.");
    }

    // Get the fundraiser_id and amount from the donation record
    $sql = "SELECT fundraiser_id, amount FROM donation WHERE donation_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $donation_id);
    $stmt->execute();
    $stmt->bind_result($fundraiser_id, $amount);
    $stmt->fetch();
    $stmt->close();

    if (empty($fundraiser_id)) {
        die("Donation not found.");
    }

    // Begin transaction (for safety)
    $conn->begin_transaction();

    try {
        // 1️⃣ Update donation status
        $sql = "UPDATE donation SET status = ? WHERE donation_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $status, $donation_id);
        $stmt->execute();
        $stmt->close();

        // 2️⃣ If confirmed (status = 1), add to fundraiser total
        if ($status === 1) {
            $sql = "UPDATE fundraisers 
                    SET amount_donated = amount_donated + ? 
                    WHERE fundraiser_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $amount, $fundraiser_id);
            $stmt->execute();
            $stmt->close();
        }

        // ✅ Commit transaction
        $conn->commit();

        // Redirect with success message
        if ($status === 1) {
            header("Location: ../view/fundraisers.php?msg=confirmed");
        } else {
            header("Location: ../view/fundraisers.php?msg=invalidated");
        }
        exit;

    } catch (Exception $e) {
        // ❌ Rollback on error
        $conn->rollback();
        echo "Error updating donation or fundraiser: " . $e->getMessage();
    }

    $conn->close();
}
?>
