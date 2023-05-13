 <?php

header('Access-Control-Allow-Origin: *');
 include ("config/DB_config.php"); 

include("class_file.php");


	$remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
      $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
       //echo "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$username'";

//Wallet Number of patron
  $accountNumber = $from_wallet;
  $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$username'");
    //Wallet Number if Captain
  $cap_accountNumber = $to_wallet;
		
		
		
  $amount_to_be_paid = $amount;	
		 
   $remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");	
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
        
 //  echo $data;  
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
 
// echo  $resp;
$err = curl_error($curl);
curl_close($curl);
if($err){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occurred: ".$err."."));  
}
    else
    {
        $totalAmount = 100;
        
        $resp = json_decode($resp, true);
        
     echo $resp;
        $message = $resp['message'];
     
        if($message == "Login success")
        { 
            
            $token = $resp['token'];
             $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
 // echo $token;  
         
         //echo  $pin;
             
$pattern = '/^0/';
$replacement = '+234';
//$newphone =  preg_replace($pattern, $replacement, $phone);

            //2020-11-17
     // $dateOfBirth =   date("Y-m-d", strtotime($rbirthdate));    
 //$url = "https://walletdemo.remita.net/api/wallet-external";
$url = $remita_url."/api/cash-connect/bank/list";
         
       //  echo $url;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/json",
   "Accept: application/json",
   "Authorization: Bearer ".$token,
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
/*
$data = <<<DATA
 {
  "accountNumber": "$to_wallet",
  "amount": $amount,
  "channel": "wallettowallet",
  "sourceBankCode": "",
  "sourceAccountNumber": "$from_wallet",
  "destBankCode": "",
  "pin": "$pin",
  "transRef": "$code",
  "isToBeSaved": true,
  "beneficiaryName": "$cap_accountNumber"
} 
DATA;
        
     
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);*/

  

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
 
 echo $resp;       
     
 $err1 = curl_error($curl);
curl_close($curl);
if($err1){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$err1."."));  
}
    else
    {
        
         //  
 $resp1 = json_decode($resp, true);
//$message = $resp1['code'];
 
		
		echo $resp1;
		
	}
		}
	}




















?>