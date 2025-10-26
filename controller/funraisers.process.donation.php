<?php
include '../model/dbconn.php'; // adjust path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $donation_id = intval($_POST['donation_id']);
    $status = intval($_POST['status']);
    $mobile = intval($_POST['mobile']);
    $amount = intval($_POST['amount']);
    $name = htmlspecialchars($_POST['name']);


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





        if ($status === 1) {
            $send_data = [];

            //START - Parameters to Change
            //Put the SID here
            $send_data['sender_id'] = "PhilSMS";
            //Put the number or numbers here separated by comma w/ the country code +63
            $send_data['recipient'] = "+63".$mobile;
            //Put message content here
            $send_data['message'] = "Greetings " .$name. "! We would like to let you know your payment of P".$amount. " is acknowledge by the donor thank you!";
            //Put your API TOKEN here
            $token = "1756|L4FZYfzK7fG35EoaoYvxBV7lWhEZMhOmLBMNym7s ";
            //END - Parameters to Change

            //No more parameters to change below.
            $parameters = json_encode($send_data);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [];
            $headers = array(
                "Content-Type: application/json",
                "Authorization: Bearer $token"
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $get_sms_status = curl_exec($ch);

            var_dump($get_sms_status);
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
