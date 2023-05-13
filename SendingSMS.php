<?php
header('Access-Control-Allow-Origin: *');
class SendingSMS
{
function smsAPI($recipent, $senderid, $messageBody) {
    
//$messageBody = urlencode($messageBody);
     
 
	
	//3a04bf1deb4834ba5ffabff98d6c5949-3465e4b6-6de6-4406-a11d-e2e2f56f7ec3

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
    CURLOPT_POSTFIELDS =>'{"messages":[{"destinations":[{"to":"'.$recipent.'"}],"from":"'.$senderid.'","text":"'.$messageBody.'"}]}',
    CURLOPT_HTTPHEADER => array(
       'Authorization: App 3a04bf1deb4834ba5ffabff98d6c5949-3465e4b6-6de6-4406-a11d-e2e2f56f7ec3',
        'Content-Type: application/json',
        'Accept: application/json'
    ),
));



$response = curl_exec($curl);

curl_close($curl);
// return $response;
	
	
	
	

	
	
    
      
  
   
}



/*

function smsAPI($recipent, $senderid, $messageBody) {
    
$messageBody =  $messageBody;
      
      $url = "https://api.ebulksms.com:8080/sendsms.json";

 
$data = array(
    "SMS" => array(
        "auth" => array(
            "username" => "jerry@wynk.ng",
            "apikey" => "e332273f65c89831ed600bbd01c59e61656ffd38"
        ),
        "message" => array(
            "sender" => "WynksupApp",
            "messagetext" => $messageBody,
            "flash" => "0"
        ),
        "recipients" => array(
            "gsm" => array(
                array(
                    "msidn" => $recipent,
                    "msgid" => $recipent.rand(344,872)
                )
            )
        ),
        "dndsender" => 1
    )
);

// Encode the data in JSON format
$jsonData = json_encode($data);

// Set the HTTP headers
$headers = array(
    "Content-Type: application/json",
    "Content-Length: " . strlen($jsonData)
);

// Send the HTTP request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);

// Process the API response
$jsonResponse = json_decode($response, true);
if ($jsonResponse["response"]["status"] == "SUCCESS") {
    return 1;
} else {
    return 0;
}

}
	*/
	
	
}





 
 
 
?>