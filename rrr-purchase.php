<?php 
header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
/*	ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);*/
 require_once('config/DB_config.php');
require_once('class_file.php');
require_once('fcm-send-function.php');
require_once('view-application-details.php');
 
 


$fcm = new FCM(); 
$fcmSend = new fcm();

$myName = new Name();


$json =  json_decode(file_get_contents('php://input'), true);
/*{
  "pin": "1234",
  "rrr": "160800168011",
  "amount": 52661.25,
  "sourceAccountNo": "8400381438",
  "serviceTypeId": "",
  "transRef": "7673450245826",
  "narration": "Acceptance Fee",
  "redeemBonus": false,
  "bonusAmount": 0,
  "specificChannel": ""
}*/
 
$rrr = $json['rrr']; 
$wynkid = $json['wynkid']; 
$sourceAccountNo = $json['walletnumber']; 
 $amount = str_replace(",","",$json['amount']) ;


/*
 
$rrr = "160800168011"; 
$wynkid = "WYNK112344"; 
$sourceAccountNo = "8400381438"; 

 
 $amount = "52661.25";

*/



 
 $transRef = date('dmY').rand(234,62662);
 $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
   $wynk_name = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$wynkid'");	

$device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = '$wynkid'"); 	
//$clientReference = date('dmY').rand(234,62662);

//$pin = "1234"; 
if(!empty($rrr))
{
	$naration = "RRR Purchase for ".$rrr." by ".$wynkid." (".$wynk_name.") from ".$sourceAccountNo;
	
	
	
  $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
   $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
    //   $wynk_name = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
       
     

   $remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");	
	
	
/*	 $remita_url= "https://walletdemo.remita.net/api";
      $remita_username= "+2348160921372";
      $remita_password= "aLLahuakbar#1";
      $remita_scheme= "53797374656d73706563732077616c6c6574";*/
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
        
        
        $resp = json_decode($resp, true);
        
        //echo $resp;
        $message = $resp['message'];
     
        if($message == "Login success")
        { $token = $resp['token'];
             //$pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
 
 $url =  $remita_url."/pay-billers/rrr/pay";
 

 
 
  
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Authorization: Bearer ".$token,
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = <<<DATA
{
  "pin": "$pin",
  "rrr": "$rrr",
  "amount": $amount,
  "sourceAccountNo": "$sourceAccountNo",
  "serviceTypeId": "",
  "transRef": "$transRef",
  "narration": "$naration",
  "redeemBonus": false,
  "bonusAmount": 0,
  "specificChannel": ""
}
DATA;

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($curl);
		 
		 
		 
		// echo $resp;
 $resp = json_decode($resp, true);
	
		 
		 

curl_close($curl);
//var_dump($resp);
		  $message = $resp['message'];
        $code = $resp['code'];
     
        if($code == "00")
        {  
            
			
		 echo json_encode(array("statusCode"=>200, "message"=>$message));  	
			
			$sql = 	mysqli_query($conn,"INSERT INTO `transaction_information`(`code`,   `truck_owner`,  `amount`, `commissiononfee`,  `registeredby`, `created_date`, `message`, `status`, `customer` ,  `owners_share`, `means`, `narration`, `products`, `channel`,  `id_number`, `wallet_number`, `refs` ) VALUES('$transRef','$wynkid','$amount','-','$wynkid', '$datetime','$message','1', '$rrr', '0','wallet','$naration','RRR','rrr','$rrr','$sourceAccountNo','$rrr') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
							
								  
								  					
 
 	
		 
			
			
		 
			if(!empty($device_token))
			{
				
				$fcmSend->sendFCM($device_token, "RRR Purchase Successfull",$naration, "3", $naration);
			}		
						
			
 
		}
		else{
					
			
			 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$message."."));  if(!empty($device_token))
			{
				
 $fcmSend->sendFCM($device_token, "RRR Purchase NOT Successfull","RRR Purchase NOT Successfull", "3", "RRR Purchase NOT Successfull");
			}		
				
		}
		 
		 
		 
            
            
             
        
    } else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>"Server Cannot Be Reached At This Moment. Please try again later."));  			  
							  }
    }















}
  else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>"Important Field Left Empty."));  			  
							  }

?>

