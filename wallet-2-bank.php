<?php 

/*ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);*/
header('Access-Control-Allow-Origin: *');
 
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');
require_once('SendingSMS.php');
require_once('fcm-send-function.php');
require_once('view-application-details.php');
 $Sending = new SendingSMS(); 
$myName = new Name(); 
 
 
 


$fcm = new FCM(); 
$fcmSend = new fcm();

$json =  json_decode(file_get_contents('php://input'), true);

 
$code = date("Ymd").rand(23,983).rand(34,287); 
 

 
$username = $json['wynkid'];
$emailing  = $json['wynkid'];
$from_wallet  = $json['from_wallet'];
$to_wallet  = $json['account_number'];
$sourceBankCode  = $json['bank_code'];
$amount  = $json['amount'];
$beneficiaryName  = $json['beneficiary_name'];
$description  = $json['description'];

$amount = str_replace(",","",$json['amount']) ;

 
 /*$amount = str_replace(",","",$json['amount']) ;  
 'wynkid': WYNK74654117
    'account_number':0041179593   
    'beneficiary_name':OGUNDELE OLUMIDE FRANCIS,
    'from_wallet': 4438308235
    'amount': 150,
   bank_code':050

 
 
 
$username = "WYNK74832498";
$emailing  = "WYNK74832498";
$from_wallet  = "3117546455";
$to_wallet  = "8978802422";
$amount  = 200;
$username = "WYNK74654117";
$emailing  = "WYNK74654117";
$from_wallet  = "4438308235";
$to_wallet  = "0041179593";
$sourceBankCode  = "050";
$amount  = 150;
$beneficiaryName  = "OGUNDELE OLUMIDE FRANCIS";

 */






$ref = "";


 
 
 
 
if(!empty($emailing))
{
 
$accountNumber = $myName->showName($conn, "SELECT  `accountNumber` FROM `wallet_info` WHERE  `accountNumber` = '$from_wallet' AND `registeredby` = '$username'");
	
	
	
	//echo "SELECT  `accountNumber` FROM `wallet_info` WHERE  `accountNumber` = '$from_wallet' AND `registeredby` = '$username'";
	
$sent_to_wynkid = $myName->showName($conn, "SELECT  `registeredby` FROM `wallet_info` WHERE  `accountNumber` = '$to_wallet' AND `status` = 1");	
	
	//echo $accountNumber;
	
  
     if(!empty($accountNumber))
	{ 
	
	
	$remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
//      $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
  //     $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
       //echo "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$username'";


  //$remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username'");
//	$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$username'");
		
		  $remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username' AND `phone` != ''  LIMIT 1 ");
	$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$username' AND `password` != ''  LIMIT 1");	

//Wallet Number of patron
  $accountNumber = $from_wallet;
  $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$username'");
  $phone = $myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$username'");
    //Wallet Number if Captain
  $cap_accountNumber = $to_wallet;
		
	//echo $pin;	
		
  $amount_to_be_paid = $amount;	
$remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username' AND `phone` != ''  LIMIT 1 ");
$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$username' AND `password` != ''  LIMIT 1");
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
 
  //echo  $resp;
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
            // $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
   //echo $token;  
         
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

 	$naration = "V2B transfer from ".$username."(".$amount.") to ".$beneficiaryName ."- ".$description	;
			
$data = <<<DATA
 {
  "accountNumber": "$to_wallet",
  "amount": $amount,
  "channel": "wallettoBank",
  "sourceBankCode": "",
  "sourceAccountNumber": "$from_wallet",
  "destBankCode": "$sourceBankCode",
  "pin": "$pin",
  "transRef": "$code",
  "isToBeSaved": true,
   "narration": "$naration",
  "phoneNumber": "$phone",
  "beneficiaryName": "$beneficiaryName"
} 
DATA;
     
     
    // echo $data;   
     
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
$message = $resp1['message'];
    //var_dump($resp1);
        $status = false;
       // echo $resp1['code']." Coded";
        
        $vbvmessage = "";
        //echo $resp1['code'];
		
        if($resp1['code'] == "00")
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
 
			
/*            
$sql = 	mysqli_query($conn,"INSERT INTO `transaction_information`(`code`,  `truck_owner`,  `amount`, `commissiononfee`,  `registeredby`, `created_date`, `message`, `status`, `customer` ,  `owners_share`, `loadme_share`, `means`) VALUES('$code','$sent_to_wynkid','$amount','-','$emailing', '$datetime','$allmessages.$naration','1', '$emailing', '-','-','w2b') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
 */
 	
			
			 
			
	  $sql = 	mysqli_query($conn,"INSERT INTO `transaction_information`(`code`,   `truck_owner`,  `amount`, `commissiononfee`,  `registeredby`, `created_date`, `message`, `status`, `customer` ,  `owners_share`, `means`, `refs`,`products`, `narration` , `channel`,  `id_number`, `wallet_number`, `bank` , `account_number` , `description` ) VALUES('$code','$sent_to_wynkid','$amount','$fee','$emailing', '$datetime','$allmessages','1', '$beneficiaryName', '0','wallet','$code','w2b','$naration','$naration','$to_wallet','$from_wallet','$sourceBankCode','$to_wallet','$description') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 			
			
			
		 
			
				$url = $remita_url."/get-account-details/".$from_wallet; 
		 
		 
		 
		 //echo $url;
		 
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Authorization: Bearer '.$token;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);


 //echo $result;

if (curl_errno($ch)) {
  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".curl_error($ch)."."));  
}else{
	
$resp1 = json_decode($result, true);	
	
	 //var_dump($resp1);
        $status = false;
    //  echo $resp1['code'].".... Coded";
        if(isset($resp1['code']) == "success")
        {
     
    $status = $resp1['data']['status'];     
        $id = $resp1['data']['id'];
 $accountNumber = $resp1['data']['accountNumber'];
 $currentBalance = $resp1['data']['currentBalance'];
  
		
			
   
   }
      }
			
			
			
			
	 $charges=$myName->showName($conn, "SELECT   `total`  FROM `w2bcharges` WHERE  $amount BETWEEN `min_amount` AND `max_amount` AND `status` = 1");		
			
 $c_phone  = substr_replace($from_wallet,"******",3,-2);		
			 
			
$message= "Debit Amount: NGN".$amount." Charges: ".$charges." A/C: ".$c_phone." DESC: ".$narration." Payment Txn Ref: ".$code." DATE: ".$datetime." BAL: NGN".$currentBalance;
 
			
 ///sending fcm STAGE 2
				 $device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = '$username'"); 	
			
			
 $device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = '$username'"); 	
 	
			
			
		 
			if(!empty($device_token))
			{
				
				$fcmSend->sendFCM($device_token, "Debit Alert",$message, "WYNK VALUT DEBIT ALERT", $message);
			};			
		
			
			
			
			/*
            
       $truck_owner = $myName->showName($conn, "SELECT `truck_owner` FROM `transaction_information` WHERE   `code` = '$ref'");      
         
 
		if($truck_owner!= "")
		{
            
            
            
	$phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	$email_owner=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	$naming=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	
	 
            
      
            
            
$customer_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$emailing'");             
$customer_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$emailing'");             
$customer_name=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$emailing'"); 
            
            
            
            
            
//$owner_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$account_number'");             
//$owner_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$account_number'");             
//$owner_name=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$account_number'");             
            
            
            
            
            
            
            
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
            
            
*/
            
            
         
    
            
echo json_encode(array("statusCode"=>200, "message"=>$message. ". Payment Successfull", "code"=>$ref, "amount"=>number_format($amount,2) , "description"=>$description )); 
				  
            
              //echo json_encode(array("statusCode"=>200, "errorMessage"=>"success", "message"=>$message));  
            
            
            
    
   }
       else
       {
            $sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$message',  `status` = 0 WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
		   
		   
		   $data = $resp1['data'];
           
         echo json_encode(array("statusCode"=>201, "errorMessage"=>"Message: ".$message, "message"=>"Error: ".$message));  
           
         //   echo json_encode(array("statusCode"=>201, "errorMessage"=>"Transaction Not Successfull. ".$message.". ".$data.". Thank You."));                
				
       }
     
        
        
              
            
        
    /*    
    }
     else {
     $message = $resp1['message'];
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$resp1['message']));  
     //$sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$message',  `status` = 0 WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
}*/
 
            
            
             
        
    }
			
			
			
			
			
			
			
			
			
			
			
			
			
			
    }

 
		   
		 
	  
	  
	  
        
        
        
    
     
    }
    }
	 else{
    
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Your wallet information cannot be found. Please check and try again later.". $username));  
   	
}
		
}
else{
    
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Important Information Missing"));  
  
}
 

?>

