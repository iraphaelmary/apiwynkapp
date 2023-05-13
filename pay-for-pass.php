<?php 
header('Access-Control-Allow-Origin: *');

 
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');
require_once('SendingSMS.php');
require_once('fcm-send-function.php');
$myName = new Name();
 $fcm = new FCM(); 
$fcmSend = new fcm();


$json =  json_decode(file_get_contents('php://input'), true);

 
 
$username =  trim($json["captain_wynkid"]);
$id =  trim($json["pass_id"]);
$pass_id =  trim($json["pass_id"]);

//WYNK33833157

//$username =  "WYNK33833157";
//$id =  2;
//$pass_id =  2;
 
if(!empty($username))
{
    
    
    
    $code = rand(23,3762).rand(23,3762).rand(23,3762).rand(23,3762).rand(23,3762);
    
       $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
      $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
       $remita_wallet = $myName->showName($conn, "SELECT `remita_wallet` FROM `application` WHERE 1");	
       
$remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username' AND `phone` != ''  LIMIT 1 ");
$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$username' AND `password` != ''  LIMIT 1");
       
       
       // echo "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$username'";

//Wallet Number of patron
  $accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$username'");
  $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$username'");
  $naming = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$username'");
  $phone = $myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$username'");
    //Wallet Number if Captain
 // $cap_accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$captain_id'");	
  $amount_to_be_paid = $myName->showName($conn, "SELECT `payment` FROM `captain_pass_setup` WHERE `id` = '$id'");	
  $pass_type = $myName->showName($conn, "SELECT `pass_type` FROM `captain_pass_setup` WHERE `id` = '$id'");	
  $pass_duration = $myName->showName($conn, "SELECT `pass_duration` FROM `captain_pass_setup` WHERE `id` = '$id'");	
    
  //  echo $accountNumber;
    
      // $token = $myName->showName($conn, "SELECT `token` FROM `remita_setup` WHERE 1");		    

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
  "scheme": "$remita_scheme"

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
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$err."."));  
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
           //  $pin = $resp['user']['pin'];
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
  "accountNumber": "$remita_wallet",
  "amount": $amount_to_be_paid,
  "channel": "wallettowallet",
  "sourceBankCode": "",
  "sourceAccountNumber": "$accountNumber",
  "destBankCode": "",
  "pin": "$pin",
  "transRef": "$code",
  "isToBeSaved": false,
  "beneficiaryName": "WYNK pass"
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
        
         //echo $resp;  
      
 $resp1 = json_decode($resp, true);
$message = $resp1['code'];
    //var_dump($resp1);
        $status = false;
       // echo $resp1['code']." Coded";
        
        
        //echo $resp1['code'];
		
        if($resp1['code'] == "00")
        {
            	$paymentStatus = "Successful Payment";
			    // $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = "NGN";
			 $vbvmessage = $resp['data']['vbvmessage'];
			 $vbvmessage2 = "Successful";
		 			
 $chargeResponsecode ="00";
            
 // SELECT  `id`, `pass_id`, `pass_type`, `start_date`, `end_date`, `created_date`, `registeredby`, `status`, `amount` FROM `captain_pass` WHERE 1
            
             $current_date = date("Y-m-d G:i:s");
            
            
         $pass_duration_name = "";
         $start = "";
         $end = "";
            
            
            
         if($pass_duration == 1)
         {
             $pass_duration_name = "1 month";
             
             
             $start =  date("Y-m-d G:i:s");
               
  $end =   date('Y-m-d G:i:s', strtotime('+1 month'));
             
         }
         else  if($pass_duration == 2)
         {
             $pass_duration_name = "7 days";
             
             
             
             $start =  date("Y-m-d G:i:s");
               
  $end = date('Y-m-d G:i:s', strtotime('+7 day'));
             
         } 
         else  if($pass_duration == 3)
         {
             $pass_duration_name = "1 day";
              $start =  date("Y-m-d G:i:s");
               
  $end = date('Y-m-d G:i:s', strtotime('+1 day'));
         } 
     
            
          $sql = "INSERT INTO `captain_pass`(`pass_id`, `pass_type`, `start_date`, `end_date`, `created_date`, `registeredby`, `status`, `amount`,`code`) VALUES ('$pass_id','$pass_type','$start','$end','$datetime', '$username', '1', '$amount_to_be_paid', '$code')";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));  
 $senderID = $inst_name;
$message = "Hi,".$naming.".
Payment for your pass was sucessfull".
"Ref:".$code."
Amount:".number_format($amount_to_be_paid,2)."
Valid till:".$end."
please login for details. ";
 
          
   $Sending = new SendingSMS(); 
  							 
							 $Sending->smsAPI($phone,$senderID,$message);
							 
							 
							 
							 
							 
							 
							 
							 
							 
            $message_all = "Pass Payment Successfull";
            
            
            
			
						
 $device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = '$username'"); 	
 	
		 
			
			
		 
			if(!empty($device_token))
			{
				
				$fcmSend->sendFCM($device_token, "Pass Payment Successfull",$message, "3", $message);
			}			
		
			            
            
            
            
            
            
            
            
            
            
            
            
            
            
          $sql = 	mysqli_query($conn,"INSERT INTO `transaction_information`(`code`,   `truck_owner`,  `amount`, `commissiononfee`,  `registeredby`, `created_date`, `message`, `status`, `customer` ,  `owners_share`, `means`, `refs`, `products`, `narration` , `channel`,  `id_number`, `wallet_number` ) VALUES('$code','$username','$amount_to_be_paid','0','$username', '$datetime','$message_all','1', '$naming', '0','wallet','$code','pass','Pay For Pass. $pass_type','$pass_type','$accountNumber','$username') ")or die("ERROR OCCURED: ".mysqli_error($conn));        
                         
   if(!empty($username))
{         
     
 $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`) VALUES
('$code','Pass Payment Information','$message','$username', '$username', '1', '1','$datetime')";
  $extract_distance = mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));    
 
    }
      
            
           echo json_encode(array("statusCode"=>200, "errorMessage"=>"Pass Payment Sucessfull", "start"=>$start, "end"=>$end));  
       
 
            
 $sql = "UPDATE `user_unit` SET  `status` = 1 WHERE `account_number` = '$username'";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));  
            
            
            
 
 
}
else{
    
   $message = $resp1['message'];
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$resp1['message'])); 
     
}
 
    }
    }
    }
    }
    else
    {
     $message = $resp1['message'];
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: User Information Not Found."));    
    }
    
?>

