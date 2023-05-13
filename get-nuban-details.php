<?php
header('Access-Control-Allow-Origin: *');
 
 

include("config/DB_config.php");
 
 include("SendingSMS.php");
 include("view-application-details.php");
include("class_file.php");
$myName = new Name();

 
$username  = "";
$json =  json_decode(file_get_contents('php://input'), true);
$username = $json['wynkid']; 
//$username = "wynk87627590";
  $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
     //, `remita_username`, `remita_password`, `, `remita_url` 
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
       
$remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");
  $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$username'");
 // $phone = $myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$username'");
 
 	$phone = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username' AND `primary_wallet` = 1 AND `accountNumber` != '' ORDER BY `id` DESC LIMIT 1");	
 $remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username' AND `phone` != '' AND `primary_wallet` = 1  LIMIT 1 ");
$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$username' AND `password` != '' AND `primary_wallet` = 1 LIMIT 1");


if(!empty($username))
{
 
	 
 
		 
		 
		 
		 
		 
   	
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
        {
            $token = $resp['token'];
            // $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
            $nubanAccountNo = $resp['walletAccountList']['id'];
              $accountFullName = $resp['walletAccountList'];
               $userType = $resp['userType'];
               
			
			//echo sizeof($resp['walletAccountList']);
               foreach($resp['walletAccountList'] as $add)
               {
                   
                   $nubanAccountNo = $add['nubanAccountNo'];
                    $accountFullName = $add['accountFullName'];
          // echo  " numban: ".$nubanAccountNo;
           
           break;
               }



if(!empty( $nubanAccountNo))
{
    
    	echo json_encode(array("statusCode"=>200, "message"=>$nubanAccountNo, "account_name:"=>$accountFullName ));	
}
else
{
    echo json_encode(array("statusCode"=>201, "message"=>"Nuban Account Number cannot retrieved at this moment. "));
    
}



 
        
        
    }
     
            
            
             
        
    }
    }
		 
		 
		 
		 
		 
	 
 
	 
 
?>