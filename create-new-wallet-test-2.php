<?php

$url = "https://wallet.remita.net/api/wallet-accounts";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Authorization: Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIrMjM0ODAzNTUzODY1OCIsImF1dGgiOiJST0xFX1VTRVIiLCJleHAiOjE2ODUwNDM2NDV9.x4E7dwe39_RFBV4IGjJnyKStSn1s60omqWYrbOaVnuo7imflvraPJRRUvO9FBJpAc4V4Jq12gw8KSDtVUzI_jw",
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = <<<DATA
{
  "accountName": "MySavings222"
}
DATA;

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);



?>

