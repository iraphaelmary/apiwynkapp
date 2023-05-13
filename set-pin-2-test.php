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

 



/*
if(isset($json['long']))
{
    
  $long = htmlspecialchars(trim($json['long']));  
}

if(isset($json['lat']))
{
    
$lat = htmlspecialchars(trim($json['lat']));    
}
 
if(isset($json['pin']))
{
    
  $pin = htmlspecialchars(trim($json['pin']));
  $pin2 = htmlspecialchars(trim($json['pin']));
}
 
 
if(isset($json['wynkid']))
{
    
  $wynkid =  $json["wynkid"];
  $account_number =  $json["wynkid"];
  $username =  $json["wynkid"];
}
*/
 
 $long = "3.3635574";
$lat = "6.57569";
$pin = "1986";
$pin2 = "1986"; 
$wynkid  = "WYNK87627590";
  $account_number  = "WYNK87627590";
  $username  = "WYNK87627590"; 
 
 
 
 $myName = new Name();
 
     

     
if(empty($pin) || empty($wynkid))
{
  
	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Some Important Fields Are Left Empty. Please check and try again."));
	
}
else
{ 
 			
$uuid = uniqid('', true);

$salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($pin . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
         
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
		
		
		
		$number = 0;
		// WHERE `account_number` = '$account_number'
		
		
 $sql = "UPDATE `user_unit` SET  `unique_id` = '$uuid', `encrypted_password` = '$encrypted_password', `salt` = '$salt', `irrelivant` = '$pin', `pin` = '$pin' WHERE `account_number` = '$account_number' ";
 
 
 
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 $process = true;
	if ($process) {
		 
   
       $phone = $myName->showName($conn, "SELECT `phone` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $firstname = $myName->showName($conn, "SELECT `firstname` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $lastname = $myName->showName($conn, "SELECT `lastname` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $dob = $myName->showName($conn, "SELECT `dob` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $gender = $myName->showName($conn, "SELECT `gender` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $name = $myName->showName($conn, "SELECT `name` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $email = $myName->showName($conn, "SELECT `email` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $file = $myName->showName($conn, "SELECT `file` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit`  WHERE `account_number` = '$username'");	
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
        
    // echo $data;
		
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
             $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
 // echo $token;  
         
         //echo  $pin;
             
$pattern = '/^0/';
$replacement = '+234';
//$newphone =  preg_replace($pattern, $replacement, $phone).rand(1,9);


//USE This for live
//$newphone =  "+".$phone;


$newphone =  "+".$phone.rand(0,9);
//$newphone =  "+2348103373964";

            //2020-11-17
      $dateOfBirth =   date("Y-m-d", strtotime($dob));    
 //$url = "https://walletdemo.remita.net/api/wallet-external";
$url = $remita_url."/wallet-external";
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
  "phoneNumber": "$newphone",
  "firstName": "$firstname",
  "lastName": "$lastname",
  "password": "$password",
  "pin": "$pin2",
  "dateOfBirth": "$dateOfBirth",
  "gender": "$gender",
  "state": "-",
  "localGovt": "-",
  "latitude": "$lat",
  "longitude": "$long",
  "address": "-",
  "scheme": "$remita_scheme",
  "accountName":  "$name",
  "email": "$email",
  "photo": "Transfer"
  
}
DATA;
		 
		   
		 
		 

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

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
        
       
      
 $resp1 = json_decode($resp, true);

   // var_dump($resp1);
        $status = false;
      // echo $resp1['code']." Coded";
       $message =  $resp1['message'];
		 //echo $message;
        if(isset($resp1['code']) == "success")
        {
     
    $status = $resp1['data'][0]['status'];     
        $id = $resp1['data'][0]['id'];
 $accountNumber = $resp1['data'][0]['accountNumber'];
 $currentBalance = $resp1['data'][0]['currentBalance'];
 $dateOpened = $resp1['data'][0]['dateOpened'];
 $schemeId = $resp1['data'][0]['schemeId'];
 $schemeName = $resp1['data'][0]['schemeName'];
 $walletAccountTypeId = $resp1['data'][0]['walletAccountTypeId'];
 $accountOwnerId = $resp1['data'][0]['accountOwnerId'];
 $accountOwnerName = $resp1['data'][0]['accountOwnerName'];
 $accountOwnerPhoneNumber = $resp1['data'][0]['accountOwnerPhoneNumber'];
 $accountName = $resp1['data'][0]['accountName'];
 $actualBalance = $resp1['data'][0]['actualBalance'];
 $trackingRef = $resp1['data'][0]['trackingRef'];
 $walletLimit = $resp1['data'][0]['walletLimit'];
 $nubanAccountNo = $resp1['data'][0]['nubanAccountNo'];
 $accountFullName = $resp1['data'][0]['accountFullName'];
 $totalCustomerBalances = $resp1['data'][0]['totalCustomerBalances'];
       
     	 
$sql = 	 "INSERT INTO `wallet_info`(`accountNumber`, `currentBalance`, `dateOpened`, `schemeId`, `schemeName`, `walletAccountTypeId`, `accountOwnerId`, `accountOwnerName`, `accountOwnerPhoneNumber`, `accountName`, `actualBalance`, `walletLimit`, `trackingRef`, `nubanAccountNo`, `accountFullName`, `totalCustomerBalances`, `status`, `created_date`, `registeredby`, `phone` , `password`, `primary_wallet`,`lati`, `longi` ) VALUES
('$accountNumber', '$currentBalance', '$dateOpened', '$schemeId', '$schemeName', '$walletAccountTypeId', '$accountOwnerId', '$accountOwnerName', '$accountOwnerPhoneNumber', '$accountName', '$actualBalance', '$walletLimit','$trackingRef','$nubanAccountNo','$accountFullName','$totalCustomerBalances','1', '$datetime', '$username', '$newphone', '$password', '1', '$lat', '$long')";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));   
            
            
              $message = "Hi, ". $firstname." Wallet Created Successfully: Wallet No. ".$accountNumber."! nubanAccountNo:".$nubanAccountNo.". Polaris Bank. Thank You.";

  
  	 $Sending = new SendingSMS(); 
  							 
						 $Sending->smsAPI($phone,"WynkSupApp",$message);
            
   }
		else if($message == "Profile for User with Phone No. Already exist")
		{
			
			  $accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM  `wallet_info` WHERE `account_number` = '$username' AND `primary_wallet` = 1");	
			  $nubanAccountNo = $myName->showName($conn, "SELECT `nubanAccountNo` FROM  `wallet_info` WHERE `account_number` = '$username' AND `primary_wallet` = 1");	
			
			
			   	 
$sql = 	 "UPDATE `wallet_info` SET `accountNumber` = '$accountNumber',  `nubanAccountNo` = '$nubanAccountNo' WHERE `registeredby` = '$username'";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));   
			
		}
	 
        
        //second wallet
   /*     
        $url = $remita_url."/wallet-accounts";
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
        
$data = <<<DATA
{
      "accountName": "$accountName"
   
}
DATA;
        
        
        $data1 = $data;

curl_setopt($curl1, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);

$resp2 = curl_exec($curl1);
 
         
     
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
        $status = false;
       // echo $resp1['code']." Coded";
        if(isset($resp1['data']) == "")
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
            
            
             // $message = "Hi, ". $firstname." Wallet Created Successfully: Wallet No. ".$accountNumber."! nubanAccountNo:".$nubanAccountNo.". Polaris Bank. Thank You.";

  
  	 //$Sending = new SendingSMS(); 
  							 
		//				 $Sending->smsAPI($phone,"Welcome",$message);
            
   }
		 
              
            
        
        
    }*/
    }
     
            
            
             
        
    }
     
         
        
   
            
            
            
            
     
        
        //echo $message;
    }
 
        
        
        
        
  
 echo json_encode(array("statusCode"=>200, "errorMessage"=>"Information submitted successfully. Please continue.", "email"=>$email, "username"=>$username,"walletno"=>$accountNumber, "nubanAccountNo"=>$nubanAccountNo,"bank"=>"Polaris Bank", "error"=>""));   
		
  }
  else
  {
	  
	  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured:  User Information not Updated Successfully."));  
  }


    
 }
 
            

 
 
 










?>