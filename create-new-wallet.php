<?php
header('Access-Control-Allow-Origin: *');
 
 

include("config/DB_config.php");
 
 include("SendingSMS.php");
 include("view-application-details.php");
include("class_file.php");


$long = "";
$lat = "";
$pin = "";
$pin2 = "";
$wynkid  = "";
$account_number  = "";
$username  = "";


 $json =  json_decode(file_get_contents('php://input'), true);

 




if(isset($json['wallet_name']))
{
    
  $wallet_name = htmlspecialchars(trim($json['wallet_name']));  
}
 
if(isset($json['wynkid']))
{
    
  $wynkid =  $json["wynkid"];
  $account_number =  $json["wynkid"];
  $username =  $json["wynkid"];
}

 /*  */
$wallet_name = "my savings";
 

 $wynkid =  "WYNK61362372";
  $account_number =  "WYNK61362372";
  $username =  "WYNK61362372";

 $myName = new Name();
 
     

     
if(empty($wallet_name) || empty($wynkid))
{
  
	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Some Important Fields Are Left Empty. Please check and try again."));
	
}
else
{ 
 
   $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
     //, `remita_username`, `remita_password`, `, `remita_url` 
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
      // $token = $myName->showName($conn, "SELECT `token` FROM `remita_setup` WHERE 1");		    

	
	
 //$remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username' AND `phone` != ''  LIMIT 1 ");
 //$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$username' AND `password` != ''  LIMIT 1");	

	
	
   $remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");	
	
   $accountNumber_WYNK = $myName->showName($conn, "SELECT  `accountNumber` FROM `wallet_info` WHERE `accountName` = '$wallet_name' AND `registeredby` = '$wynkid'");	
	
	if(!empty($accountNumber_WYNK))
	{
		  
 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Information submitted successfully. Please continue.", "email"=>$email, "username"=>$username,"walletno"=>$accountNumber, "nubanAccountNo"=>$nubanAccountNo,"bank"=>"Polaris Bank", "error"=>""));  
		
	}
	else
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
  "scheme": "$remita_scheme",
  "deviceId": "64784844-hhhd748849-g7378382"

}
DATA;
        
  //echo $data;
		
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
        
  //  echo $resp;
        $message = $resp['message'];
     
        if($message == "Login success")
        { $token = $resp['token'];
            // $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
    
	 
        
        //second wallet
        
        $url = $remita_url."/wallet-accounts";
        
     // echo  $token;
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
 
      $accountName = "Welfare";
        
$data = <<<DATA
{
      "accountName":  "My Wallet" 
   
}
DATA;
        
        
        $data1 = $data;

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp2 = curl_exec($curl);
 
 echo $resp2 ;        
     
 $err1 = curl_error($curl);
curl_close($curl);
if($err1){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$err1."."));  
}
    else
    {
        
       //echo $resp;  
      
 $resp1 = json_decode($resp2, true);

    var_dump($resp1);
        $status = false;
       // echo $resp1['code']." Coded";
        if(isset($resp1['data']) != "")
        {
     
 $status = $resp1['status'];     
 $id = $resp1['id'];
 $accountNumber1 = $resp1['accountNumber'];
 $currentBalance1 = $resp1['currentBalance'];
 $dateOpened1 = $resp1['dateOpened'];
 $schemeId1 = $resp1['schemeId'];
 $schemeName1 = $resp1['schemeName'];
 $walletAccountTypeId1 = $resp1['walletAccountTypeId'];
 $accountOwnerId1 = $resp1['accountOwnerId'];
 $accountOwnerName1 = $resp1['accountOwnerName'];
 $accountOwnerPhoneNumber1 = $resp1['accountOwnerPhoneNumber'];
 $accountName1 = $resp1['accountName'];
 $actualBalance1 = $resp1['actualBalance'];
 $trackingRef1 = $resp1['trackingRef'];
 $walletLimit1 = $resp1['walletLimit'];
 $nubanAccountNo1 = $resp1['nubanAccountNo'];
 $accountFullName1 = $resp1['accountFullName'];
 $totalCustomerBalances1 = $resp1['totalCustomerBalances'];
       
     	 
$sql = 	 "INSERT INTO `wallet_info`(`accountNumber`, `currentBalance`, `dateOpened`, `schemeId`, `schemeName`, `walletAccountTypeId`, `accountOwnerId`, `accountOwnerName`, `accountOwnerPhoneNumber`, `accountName`, `actualBalance`, `walletLimit`, `trackingRef`, `nubanAccountNo`, `accountFullName`, `totalCustomerBalances`, `status`, `created_date`, `registeredby`, `phone` , `password`, `primary_wallet`,`lati`, `longi` ) VALUES
('$accountNumber1', '$currentBalance1', '$dateOpened1', '$schemeId1', '$schemeName1', '$walletAccountTypeId1', '$accountOwnerId1', '$accountOwnerName1', '$accountOwnerPhoneNumber1', '$accountName1', '$actualBalance1', '$walletLimit1','$trackingRef1','$nubanAccountNo1','$accountFullName1','$totalCustomerBalances1','1', '$datetime', '$username', '$newphone', '$password', '0', '$lat', '$long')";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));   
            
        
			
			
 echo json_encode(array("statusCode"=>200, "errorMessage"=>"Wallet created successfully.", "wallet_name"=>$wallet_name,"walletno"=>$accountNumber1));  	
            
   }
   else
   {
    echo json_encode(array("statusCode"=>201, "errorMessage"=>"Wallet not created successfully. Please try again later. ".$resp1['message']));    
   }
		 
              
            
        
        
    }
    }
     
            
            
             
        
    }
     
         
        
   
            
            
            
   
 
        
        
        
        
  
 //echo json_encode(array("statusCode"=>200, "errorMessage"=>"Information submitted successfully. Please continue.", "email"=>$email, "username"=>$username,"walletno"=>$accountNumber, "nubanAccountNo"=>$nubanAccountNo,"bank"=>"Polaris Bank", "error"=>""));   
		
 


    
 }
 
            
}
 
 
 










?>