<?php

$apiKey = "AAAAMsIhss4:APA91bHneVeDYh4Et6I0vPwiYOSZUr7nDinlqOtlKenC5_GdSCRTNP2EfHLob2yYcU_Tl-qTxtWyf5BT1wJd2YqaeswTwMmEeamjD4HBSUy1wzZVu5mPTzU4t78EIuVLgjXI-zyi-8JK";
$deviceToken = "c55C5cYbTuiT7Zfi73TN8H:APA91bFnL6hgzsEApSE_XjaKCS7GB_4tlryIEby-zD9P66i3gsU7wbbTJamUz3atVkybN3PS1K-uc03vswa6dbhtiZyQZKjs2Ja44y1eueF4yADbn24aiYgi1q3ghi4Yo0pED6Hc1rdP";
$message = "Hello from WYNK";

$fields = array(
    'to' => $deviceToken,
    'data' => array("message" => $message)
);

$headers = array(
    'Authorization: key=' . $apiKey,
    'Content-Type: application/json'
);

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
echo $result;

?>