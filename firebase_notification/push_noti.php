<?php

// Path to your service account JSON file
$serviceAccountJsonPath = '../fire-service-account-file.json';

// URL-safe Base64 encoding function
function base64UrlEncode($data)
{
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
}

// Function to get OAuth 2.0 access token
function getAccessToken($serviceAccountJsonPath)
{
    // Prepare JWT header and payload
    $jwtHeader = json_encode([
        'alg' => 'RS256',
        'typ' => 'JWT'
    ]);

    $now = time();
    $serviceAccount = json_decode(file_get_contents($serviceAccountJsonPath));

    // Ensure service account JSON was parsed correctly
    if (!$serviceAccount || !isset($serviceAccount->client_email, $serviceAccount->private_key)) {
        die('Invalid service account JSON.');
    }

    $jwtPayload = json_encode([
        'iss' => $serviceAccount->client_email,
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        'aud' => 'https://oauth2.googleapis.com/token',
        'iat' => $now,
        'exp' => $now + 3600 // 1 hour expiration
    ]);

    // Base64 URL encoding for JWT
    $jwtToSign = base64UrlEncode($jwtHeader) . '.' . base64UrlEncode($jwtPayload);

    // Extract the private key and prepare for signing
    $privateKey = $serviceAccount->private_key;
    $privateKeyResource = openssl_pkey_get_private($privateKey);

    if (!$privateKeyResource) {
        die('Failed to parse private key.');
    }

    // Sign the JWT using the private key
    if (!openssl_sign($jwtToSign, $signature, $privateKeyResource, 'sha256')) {
        die('Failed to sign the JWT.');
    }

    $jwtSignature = base64UrlEncode($signature);

    // The complete JWT
    $jwt = $jwtToSign . '.' . $jwtSignature;

    // Free the private key resource
    openssl_free_key($privateKeyResource);

    // Get OAuth 2.0 token from Google
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'assertion' => $jwt
    ]));

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        die('OAuth token request error: ' . curl_error($ch));
    }

    $response = json_decode($result, true);
    curl_close($ch);

    if (!isset($response['access_token'])) {
        die('Failed to get access token: ' . $result);
    }

    return $response['access_token'];
}

// Function to send the notification using FCM v1 API
function sendNotification($projectId, $firebaseToken, $title, $body, $accessToken)
{
    $url = 'https://fcm.googleapis.com/v1/projects/' . $projectId . '/messages:send';

    $message = [
        'message' => [
            'token' => $firebaseToken,
            'notification' => [
                'title' => $title,
                'body' => $body
            ]
        ]
    ];

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        die('FCM Send Error: ' . curl_error($ch));
    }

    curl_close($ch);
    return $result;
}

// Example usage
$serviceAccountJsonPath = '../fire-service-account-file.json';
$projectId = 'rml-hr-app';
$firebaseToken = 'cDKHicqISGax6ogBBKwACw:APA91bGV7I2wprzpswo7znIMj4L8K62yv4X_AIIfRIj_BKMg_rhRlSe0XoFNIl0sgM-2ycRFgl6C_bDHTYehLiUVsSu31HxPfPtzmcJmZVsnTCWDUAmsMUvkazrlqUGuwSUXgePh7kvb';
$title = 'My Notification Title';
$body = 'This is the notification message';

// Get access token
$accessToken = getAccessToken($serviceAccountJsonPath);

// Send notification
$response = sendNotification($projectId, $firebaseToken, $title, $body, $accessToken);

// Print response
echo "Notification Title: $title\n";
echo "Notification Body: $body\n";
echo "FCM Response: $response\n";

?>
