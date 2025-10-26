<?php 

$send_data = [];

//START - Parameters to Change
//Put the SID here
$send_data['sender_id'] = "PhilSMS";
//Put the number or numbers here separated by comma w/ the country code +63
$send_data['recipient'] = "+639196046295";
//Put message content here
$send_data['message'] = "Sample broadcast message content.";
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

?>