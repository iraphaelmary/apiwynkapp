<?php
header('Access-Control-Allow-Origin: *');
 

include("config/DB_config.php");
 
 include("SendingSMS.php");
 include("view-application-details.php");
$referral_code = "";
$firstname = "";
$email = "";
$lastname = "";
$name = "";
$address = "";
$wynkid  = "";
include("class_file.php");
 $json =  json_decode(file_get_contents('php://input'), true);

 

 $myName = new Name();
 
	 
      // $phone = $myName->showName($conn, "SELECT `phone`  FROM `user_unit` WHERE   `account_number` = '$wynkid'");
       $verification_type = $myName->showName($conn, "SELECT `varify_type`  FROM `user_unit` WHERE   `account_number` = '$wynkid'");
       $id_number = $myName->showName($conn, "SELECT `id_number`  FROM `user_unit` WHERE   `account_number` = '$wynkid'");
       $verifyme_url = $myName->showName($conn, "SELECT  `verifyme_url` FROM `application` WHERE `status` = 1");
  $verifyme_api_key = $myName->showName($conn, "SELECT  `verifyme_api_key` FROM `application` WHERE `status` = 1");
	
	
	
	
	
 $identitypassapikey = $myName->showName($conn, "SELECT `identitypassapikey` FROM `application` WHERE 1");		
$identitypassbaseurl = $myName->showName($conn, "SELECT `identitypassbaseurl` FROM `application` WHERE 1");		
        
 
        
        
   // echo json_encode(array("statusCode"=>201, "errorMessage"=>"User information not found in the database. Please check and try again."));
    
     $new_number = str_replace('234', '0', '09016452662');
	  $value = dataVerification_phone($new_number,$identitypassbaseurl."/api/v2/biometrics/merchant/data/verification/phone_number",$identitypassapikey);
		
			//https://api.myidentitypay.com/api/v2/biometrics/merchant/data/verification/phone_number  
	  
 $resp = json_decode($value, true);
    
        
       echo $value ; 
        
        
        
        
         
		 function dataVerification_phone($number,$url,$api_key){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
                 http_build_query(array('number' => $number)));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-API-Key: $api_key",
            "app-id: 90eb1a16-d691-4597-a50f-c81fd99c08bd",
            "Cache-Control: no-cache",
          ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        
        curl_close ($ch);
        return $server_output;
    }
		
		
		 
		
		 



?>