<?php

header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();


$json1 = "";
$json2 = "";
$json3= "";
  $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	



$url = $remita_url."/banks/commercial";
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);


 //echo $result;
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

  $resp = json_decode($result, true);
         $resp1 = json_decode($result);
 

     $message = $resp['message'];

 
 


 //echo $message;
if($message == "success")
{
      $json2 = '[';
	
 	
   for($i=0;$i<sizeof($resp['data']);$i++)
    {
		 //echo $i."<p>";
		
	 $bankCode = $resp['data'][$i]['bankCode'];
	  $bankName = $resp['data'][$i]['bankName'];
	 $shortCode = $resp['data'][$i]['shortCode'];
	 $type = $resp['data'][$i]['type'];
					
$json2 .= '{
    "bankCode": "'.$bankCode.'",
    "shortCode": "'.$shortCode.'",
    "type": "'.$type.'",
    "bankName": "'.$bankName.'"
},'; 
	}
	
	
	
	
	
	
	
	
	
	
	
	
	/*
 	 $json2 .= "]";
	
	//echo $json2;
	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
  echo trim($json1);*/
	
}
else
{
	
	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Information cannot be retrieved at the moment. Pleae try again later.")); 
	
}


$url = $remita_url."/authenticate";

        
       
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = <<<DATA
{
  "password": "$remita_password",
  "rememberMe": true,
  "username": "$remita_username",
  "scheme": "$remita_scheme",
  "deviceId": "64784844-hhhd748849-g7378382"

}
DATA;
        
     
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
 
 //echo  $resp;
$err = curl_error($curl);
curl_close($curl);
if($err){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$err."."));  
}
    else
    {
        
        
        $resp = json_decode($resp, true);
        
     
        $message = $resp['message'];
     
        if($message == "Login success")
        { $token = $resp['token'];
             $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
		 
		 
		 
		//echo $token;
 
$url = $remita_url."/banks/microfinance";
         
      $curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Authorization: Bearer ".$token,
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($curl);


//$result = curl_exec($ch);


 //echo $result;
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

  $resp = json_decode($result, true);
         $resp1 = json_decode($result);
 

     $message = $resp['message'];

 
 


 //echo $message;
if($message == "success")
{
      
	
 	
   for($i=0;$i<sizeof($resp['data']);$i++)
    {
		 //echo $i."<p>";
		
	 $bankCode = $resp['data'][$i]['bankCode'];
	  $bankName = $resp['data'][$i]['bankName'];
	 $shortCode = $resp['data'][$i]['shortCode'];
	 $type = $resp['data'][$i]['type'];
					
$json2 .= '{
    "bankCode": "'.$bankCode.'",
    "shortCode": "'.$shortCode.'",
    "type": "'.$type.'",
    "bankName": "'.$bankName.'"
},'; 
	}
	
	
	
}
else
{
	
	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Information cannot be retrieved at the moment. Pleae try again later.")); 
	
}
		 
		 
		 
		 curl_close($ch);
        
    }
     
            
            
             
        
    }
    

 $json2 .= "]";
	
	//echo $json2;
	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
  echo trim($json1);


curl_close($ch);
?>