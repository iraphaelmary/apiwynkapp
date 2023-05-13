<?php
header('Access-Control-Allow-Origin: *');
 
 

include("config/DB_config.php");
 include("class_file.php");
 
 include("view-application-details.php");
  $myName = new Name();
 
$picture = "";
$wynkid  = "";
$account_number  = "";

 $json =  json_decode(file_get_contents('php://input'), true);

 



 
    
  $account_number =  $json['wynkid'];  
 $accountNumber = $json['to_wallet']; 
$amount = str_replace("",",",$json['amount']) ;
      $sourceAccountNumber = $json['from_wallet'];    
      
      /*
$account_number =  "WYNK74832498";  
$accountNumber = "7141477095"; 
$amount = 200; 
$sourceAccountNumber = "8978802422";         
     
*/

$channel = "INVOICE";

$transRef = date("YmdGis");
$sourceBankCode = null;
$destBankCode = null;

 
     
         $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit`  WHERE `account_number` = '$wynkid'");	     
                    
         
 

        if(empty($accountNumber) or empty($sourceAccountNumber)or empty($amount))
		{
			
			 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: Some important fields are left empty."));  
			
		}else{
			
   
   
            
            
            
    
		  $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit`  WHERE `account_number` = '$wynkid'");	
		  $newphone = $myName->showName($conn, "SELECT `phone` FROM `user_unit`  WHERE `account_number` = '$wynkid'");	
		
		   $password = $myName->showName($conn, "SELECT `password` FROM `application`  WHERE  1");	
        
        
        
       $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
     //, `remita_username`, `remita_password`, `, `remita_url` 
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
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
        
     //echo $resp;
        $message = $resp['message'];
     
        if($message == "Login success")
        { $token = $resp['token'];
            // $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
		 
		 
		 
		 
		 
		  //second wallet
        
        $url = $remita_url."/request-money";
      $curl1 = curl_init($url);
curl_setopt($curl1, CURLOPT_URL, $url);
curl_setopt($curl1, CURLOPT_POST, true);
curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/json",
   "Accept: application/json",
   "Authorization: Bearer ".$token,
);
curl_setopt($curl1, CURLOPT_HTTPHEADER, $headers);
 
      $accountName = "Welfare";
        
		 
		 /*{
  "accountNumber": "1042529520",
  "amount": 100000,
  "channel": "INVOICE",
  "destBankCode": "ABC",
  "sourceAccountNumber": "7054986204",
  "sourceBankCode": "SPECS",
  "transRef": "2400000780677886"
}*/
		 
		 
		
$data = <<<DATA
{
      "accountNumber": "$accountNumber",
      "amount": "$amount",
      "channel": "$channel",
      "destBankCode": "$destBankCode",
      "sourceAccountNumber": "$sourceAccountNumber",
      "sourceBankCode": "$sourceBankCode",
      "transRef": "$transRef"
   
}
DATA;
        
        
        $data1 = $data;

curl_setopt($curl1, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);

$resp2 = curl_exec($curl1);
 
         
 // echo $resp2;   
 $err1 = curl_error($curl1);
curl_close($curl1);
if($err1){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$err1."."));  
}
    else
    {
        
         //echo $resp;  
      
 $resp1 = json_decode($resp2, true);

    //var_dump($resp1);
		
		
		/*{
  "message": "The Owner of the Request is Unknown!!",
  "code": "022",
  "error": true,
  "status": null,
  "paymentTransactionDTO": null
}*/
	$code =	$resp1['code'];
	$message =	$resp1['message'];
		
		 
		
		
        $status = false;
       // echo $resp1['code']." Coded";
        if($code == "00")
        {
     
     echo json_encode(array("statusCode"=>200, "message"=>"".$message."."));  
     	 
		/*	SELECT  `id`, `accountnumber`, `amount`, `destbankcode`, `channel`, `sourceaccountnumber`, `sourcebankcode`, `transref`, `created_date`, `registeredby`, `status` FROM `request_money` WHERE 1*/
			
			
			
			
			
			
$sql = 	 "INSERT INTO `request_money`(`accountnumber`, `amount`, `destbankcode`, `channel`, `sourceaccountnumber`, `sourcebankcode`, `transref`, `created_date`, `registeredby`, `status` ) VALUES
('$accountNumber', '$amount', '$destBankCode', '$channel', '$sourceAccountNumber', '$sourceBankCode', '$transRef', '$datetime', '$wynkid', '1')";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));   
            
            
             // $message = "Hi, ". $firstname." Wallet Created Successfully: Wallet No. ".$accountNumber."! nubanAccountNo:".$nubanAccountNo.". Polaris Bank. Thank You.";

  
  	 //$Sending = new SendingSMS(); 
  							 
		//				 $Sending->smsAPI($phone,"Welcome",$message);
            
   }
		else{
			
			
			   echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$message."."));  
			
		}
		 
              
            
        
        
    }
		}
		}
     
        
   
 
        }
        
         











?>