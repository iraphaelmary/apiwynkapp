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
	 $sql = 	mysqli_query($conn,"INSERT INTO `banklist`(`bank_name`, `bankCode`, `shortCode`, `type`, `status`, `created_date`, `registeredby` ) VALUES('$bankName','$bankCode','$shortCode','$type','1','$datetime', 'admin') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 			
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
	

	
	/*SELECT  `id`, `bank_name`, `bankCode`, `type`, `status`, `created_date`, `registeredby` FROM `banklist` WHERE 1*/
	
	
	
	
	
	
	
	
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

 
     
            
            
             
        
    
    

 $json2 .= "]";
	
	//echo $json2;
	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
  echo trim($json1);


curl_close($ch);
?>