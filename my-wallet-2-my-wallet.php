<?php 
header('Access-Control-Allow-Origin: *');
 
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');
require_once('SendingSMS.php');

$myName = new Name();
 


$json =  json_decode(file_get_contents('php://input'), true);

 
$code = date("Ymd").rand(23,983).rand(34,287); 
 


$username = $json['wynkid'];
$emailing  = $json['wynkid'];
$from_wallet  = $json['from_wallet'];
$to_wallet  = $json['to_wallet'];
$amount  = $json['amount'];

 
 
if(!empty($emailing))
{
 
$accountNumber = $myName->showName($conn, "SELECT  `accountNumber` FROM `wallet_info` WHERE  `accountNumber` = '$from_wallet' AND `registeredby` = '$username' AND `status` = 1");
	
	
	
$sent_to_wynkid = $myName->showName($conn, "SELECT  `registeredby` FROM `wallet_info` WHERE  `accountNumber` = '$to_wallet' AND `status` = 1");	
	
	
	
  
    if(!empty($accountNumber))
	{
	
	
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
        
    // echo $resp;
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
$url = $remita_url."/send-money";
         
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
        
     
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

  

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
 
 //echo $resp;       
     
 $err1 = curl_error($curl);
curl_close($curl);
if($err1){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$err1."."));  
}
    else
    {
        
         // echo $resp;  
      
 $resp1 = json_decode($resp, true);
$message = $resp1['code'];
    //var_dump($resp1);
        $status = false;
       // echo $resp1['code']." Coded";
        
        $vbvmessage = "";
        //echo $resp1['code'];
		
        if($resp1['code'] == "success")
        {
            	
	 	$ref = $code;
			
			$paymentStatus = "Successful Payment";
			    // $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = "NGN";
			// $vbvmessage = $resp['data']['vbvmessage'];
			// $vbvmessage = $resp['data']['vbvmessage'];
			 $vbvmessage2 = "Successful";
			 $chargeAmount=$myName->showName($conn, "SELECT `amount` FROM `search_result` WHERE `code` = '$ref'"); 						
 $chargeResponsecode ="00";
            
            
            $allmessages = $paymentStatus." ".$vbvmessage2;
 
            
$sql = 	mysqli_query($conn,"INSERT INTO `transaction_information`(`code`,  `truck_owner`,  `amount`, `commissiononfee`,  `registeredby`, `created_date`, `message`, `status`, `customer` ,  `owners_share`, `loadme_share`, `means`) VALUES('$code','$sent_to_wynkid','$amount','-','$emailing', '$datetime','$allmessages','1', '$emailing', '-','-','w2w') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
 
 	
            
       $truck_owner = $myName->showName($conn, "SELECT `truck_owner` FROM `transaction_information` WHERE   `code` = '$ref'");      
         
 
		if($truck_owner!= "")
		{
            
            
            
	$phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	$email_owner=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	$naming=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	
	 
            
      
            
            
$customer_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$emailing'");             
$customer_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$emailing'");             
$customer_name=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$emailing'"); 
            
            
            
            
            
$owner_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$account_number'");             
$owner_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$account_number'");             
$owner_name=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$account_number'");             
            
            
            
            
            
            
            
$senderID = $inst_name;
$message = "Hi,".$customer_name.".
wallet transfer to ".$naming."
was successful".
"Ref:".$ref."
Amount:".number_format($chargeAmount,2)."
Date:".$datetime;
 

                         
   if(!empty($emailing))
{         
     
 $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `truck_id`) VALUES
('$ref','Wallet 2 Wallet Information','$message','$emailing', '$emailing', '1', '1','$datetime', '')";
  $extract_distance = mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));    
				
		 	
 mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));		
            
   }       
             
 
   //$Sending = new SendingSMS(); 
  							 
							// $Sending->smsAPI($phone,$senderID,$message);
            
            

            
            
         
    
            
echo json_encode(array("statusCode"=>200, "message"=>"Payment Successfull", "code"=>$ref, "amount"=>number_format($amount,2) )); 
				  
            
              //echo json_encode(array("statusCode"=>200, "errorMessage"=>"success", "message"=>$message));  
            
            
            
    
   }
       else
       {
            $sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$message',  `status` = 0 WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
           
          // echo json_encode(array("statusCode"=>201, "errorMessage"=>"Message: ".$message, "message"=>"Error: ".$message));  
           
            echo json_encode(array("statusCode"=>201, "errorMessage"=>"Transaction Not Successfull.<br>
".$message.". <br>
Transaction Ref: ".$ref.". <br>
Thank You."));                
				
       }
     
        
        
              
            
        
        
    }
     else {
     $message = $resp1['message'];
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$resp1['message']));  
     //$sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$message',  `status` = 0 WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
}
 
            
            
             
        
    }
			
			
			
			
			
			
			
			
			
			
			
			
			
			
    }

 
		   
		 
	  
	  
	  
        
        
        
    
     
    }
    }
	 else{
    
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Your wallet information cannot be found. Please check and try again later."));  
   	
}
		
}
else{
    
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Important Information Missing"));  
  
}
 

?>

