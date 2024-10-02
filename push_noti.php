<?php

require 'vendor/autoload.php';

use Google\Client;
// rml-hr-apps-notification@rml-hr-app.iam.gserviceaccount.com
function sendFirebaseNotification($deviceToken, $title, $body)
{
	$client = new Google\Client();
	$client->setAuthConfig(config: './fire-service-account-file.json'); // Service account file
	$client->addScope(scope_or_scopes: 'https://www.googleapis.com/auth/firebase.messaging');

	$accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];

	// Firebase URL for HTTP v1 API
	$firebaseUrl = 'https://fcm.googleapis.com/v1/projects/rml-hr-app/messages:send';

	$notification = [
		'message' => [
			'token' => $deviceToken,
			'notification' => [
				'title' => $title,
				'body' => $body
			],
			'android' => [
				'priority' => 'high'
			]
		]
	];

	$headers = [
		'Authorization: Bearer ' . $accessToken,
		'Content-Type: application/json',
	];

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $firebaseUrl);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification));

	$response = curl_exec($ch);
	// print_r($response);
	if ($response === FALSE) {
		die('FCM Send Error: ' . curl_error($ch));
	}

	curl_close($ch);

	return $response;
}

//$deviceToken = "d4YG2pCFSqG__lJeLE1Q4e:APA91bH40Hb1T4Ovg6NZvQGElXGZDl-DNeQjnpwnMi0CW-WXpjiJddeD6W9v_r9ViMm28zmzhi-JzOdsyw9mF7XE0Pld4YohXZrxMtx4o4pjzYLxkrcOTl7Z1F8945KJ43-YESeMndEP";
$deviceToken = "c_vg2zTrQkNwqGKwPDRDGc:APA91bGa_tpkIrL2AkS1jt6k_D-2sjJ5UnKa3hR8AQvYLi_W36D0ZFVpxcwaEDOXLUdRyrmJ2cvN5L2IBOxkMgIQ239ZFQl3FVz_z0htjb-V30Z5C1U5pZOohg0HpNRYZ8kzZ7WIGgYg";
//$deviceToken = "fzR0z7vaS5eq3Z9cuhVXA5:APA91bHXEUNoSJQTLwAQQ-Hk5s4mzxjKv2DYdzk7sF8ujVC2XBuPVdAi97B9KLuNJ2nr3Ah7gKEtW958zW0JlC-ni-mueMa_A1cTbIynYGO89oZJ7WyjrRIHe--aA3JXZ_5rTmojRHUS";
$title = "Test Notification";
$body = "This is a test push notification using OAuth 2.0.";

$response = sendFirebaseNotification($deviceToken, $title, $body);
echo $response;
