<?php
$deviceToken1 = "c55C5cYbTuiT7Zfi73TN8H:APA91bFnL6hgzsEApSE_XjaKCS7GB_4tlryIEby-zD9P66i3gsU7wbbTJamUz3atVkybN3PS1K-uc03vswa6dbhtiZyQZKjs2Ja44y1eueF4yADbn24aiYgi1q3ghi4Yo0pED6Hc1rdP";
define('API_ACCESS_KEY', 'AAAAMsIhss4:APA91bHneVeDYh4Et6I0vPwiYOSZUr7nDinlqOtlKenC5_GdSCRTNP2EfHLob2yYcU_Tl-qTxtWyf5BT1wJd2YqaeswTwMmEeamjD4HBSUy1wzZVu5mPTzU4t78EIuVLgjXI-zyi-8JK');
$registrationIds = array($deviceToken1);

$msg = array
(
    'message' => 'here is a message. message',
    'title' => 'This is a title. title',
    'subtitle' => 'This is a subtitle. subtitle',
    'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
    'vibrate' => 1,
    'sound' => 1,
    'largeIcon' => 'large_icon',
    'smallIcon' => 'small_icon'
);

$fields = array
(
    'registration_ids' => $registrationIds,
    'data' => $msg
);

$headers = array
(
    'Authorization: key=' . API_ACCESS_KEY,
    'Content-Type: application/json'
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
$result = curl_exec($ch);
curl_close($ch);

echo $result;

