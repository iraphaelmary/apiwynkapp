<?php

 

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://qgvnxr.api.infobip.com/sms/2/text/advanced',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{"messages":[{"destinations":[{"to":"2348103373964"}],"from":"WYNK-2","text":"This is a sampleuuu message"}]}',
    CURLOPT_HTTPHEADER => array(
       'Authorization: App ae1fc6689028c2c53a8f18fcec7c5103-5ffc07c9-5a8e-4768-81de-723d661ceaf9',
        'Content-Type: application/json',
        'Accept: application/json'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>