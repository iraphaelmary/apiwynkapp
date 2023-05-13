<?php
header('Access-Control-Allow-Origin: *');
/*class SendingSMS
{
function smsAPI($recipent, $senderid, $messageBody) {
    
//$messageBody = urlencode($messageBody);
     
 
	
	

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
       'Authorization: App ae1fc6689028c2c53a8f18fcec7c5103-5ffc07c9-5a8e-4768-81de-723d661ceaf9',
        'Content-Type: application/json',
        'Accept: application/json'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
// return $response;
	
	
	
	
	/*
	
	
    
   $url ="http://api.ebulksms.com/sendsms?username=osijidale@gmail.com&apikey=6f02eddsb5558f8b07d4cab301e42ce9150101b9fd1376&sender=".$senderid."&messagetext=".$messageBody."&flash=0&recipients=".$recipent;	
 
      $send = file($url);
     
             if (!$send){
              return false;
              }      
        return true;       
  }
  */
/*
}
}*/
//0909 979 7979


class SendingSMS
{
function smsAPI($recipent, $senderid, $messageBody) 
{
	
	if (substr($recipent, 0, 1) == "0") {
  
	
$recipent = ltrim($recipent, '0');

// Add the country code for Nigeria (+234) to the beginning of the number
$recipent = "234" . $recipent;


	
}   

	
	
	
	
    $url = 'https://sms.vanso.com/rest/sms/submit';

// Request parameters
$params = array(
    "dest" => $recipent,
    "src" => "WynkSupApp",
    "systemId" => "NG.106.0919",
    "text" => $messageBody
);

// Basic authorization credentials
/*$username = "your_username";
$password = "your_password";*/
$username = 'NG.106.0919';
$password = 'B5RqUs24';
// cURL options
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $url . '?' . http_build_query($params),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        'Authorization: Basic ' . base64_encode($username . ':' . $password),
        'Accept: application/json'
    )
));

// Execute the cURL request
$response = curl_exec($curl);

// Check for any errors
if (curl_errno($curl)) {
    echo 'Error: ' . curl_error($curl);
} else {
    // Print the response
    echo $response;
}

// Close the cURL session
curl_close($curl);
 
}
}

 
 
 
?>