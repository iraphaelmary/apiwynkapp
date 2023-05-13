<?php

class FCM
{
   
    public function sendFCM($token, $message_title, $messge_body, $messge_subtitle, $messge_tickertext)
    {
 
$deviceToken1 = $token;
define('API_ACCESS_KEY', 'AAAAMsIhss4:APA91bHneVeDYh4Et6I0vPwiYOSZUr7nDinlqOtlKenC5_GdSCRTNP2EfHLob2yYcU_Tl-qTxtWyf5BT1wJd2YqaeswTwMmEeamjD4HBSUy1wzZVu5mPTzU4t78EIuVLgjXI-zyi-8JK');
$registrationIds = array($deviceToken1);

$msg = array
(
    'message' => $messge_body,
    'title' => $message_title,
    'subtitle' => $messge_subtitle,
    'tickerText' => $messge_tickertext,
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

//echo $result;

}

}
?>
