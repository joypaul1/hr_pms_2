<?php

function sendPushNotification($to, $title, $body, $data = []) {
    $serverKey = 'YOUR_SERVER_KEY'; // Replace with your Firebase Server Key
    
    $notification = [
        'title' => $title,
        'body' => $body,
    ];
    
    $fields = [
        'to' => $to, // 'to' can be a device token, topic, or condition
        'notification' => $notification,
        'data' => $data, // Custom data payload
    ];
    
    $headers = [
        'Authorization: key=' . $serverKey,
        'Content-Type: application/json'
    ];
    
    $url = 'https://fcm.googleapis.com/fcm/send';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    
    curl_close($ch);
    
    return $result;
}

// Example usage
$deviceToken = 'DEVICE_TOKEN_HERE'; // Replace with the actual device token
$title = 'Test Notification';
$body = 'This is a test notification from Firebase';
$data = [
    'key1' => 'value1',
    'key2' => 'value2'
];

$response = sendPushNotification($deviceToken, $title, $body, $data);
echo $response;

?>
