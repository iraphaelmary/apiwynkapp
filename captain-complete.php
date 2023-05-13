<?php 
 header('Access-Control-Allow-Origin: *');
  include("SendingSMS.php");

  include("config/DB_config.php");
 
require_once('view-application-details.php');
include("class_file.php");
 $myName = new Name();

   
        

 $randing = rand(2442,76723).rand(2442,76723).rand(23,7674).rand(234,889); 

$json =  json_decode(file_get_contents('php://input'), true);

// $data = json_decode($json);
 
$driverlicence =  $json["driverlicence"];
$captain_type =  $json["association"];
$wynkid =  $json["wynkid"];
$username =  $json["wynkid"];
$brand =  $json["brand"];
$model =  $json["model"];
$car_color =  $json["car_color"];
$year =  $json["year"];
$plate_number =  $json["plate_number"];
$capacity =  $json["capacity"];
$full_name =  $json["full_name"];
$frontview =  $json["frontview"];
$backview =  $json["backview"];
$inpection =  $json["inpection"];
$vehiclelicence =  $json["vehiclelicence"];
$vehicleregistration =  $json["vehicleregistration"];

/*
$driverlicence =  "licence";
$captain_type =  "captain_type";
$wynkid =  "wynkid";
$username =   "wynkid";
$brand =   "brand";
$model =   "model";
$car_color =   "red";
$year =  "year";
$plate_number =  "plate_number";
$capacity =  "2";
$full_name = "sdfsf sfsdf";
$frontview =  "front";
$backview =  "backview";
$inpection =  "inpection";
$vehiclelicence = "vehiclelicence";
$vehicleregistration = "vehicleregistration";
*/


if(empty($driverlicence) or empty($captain_type)  ){ 
    
    echo json_encode(array("statusCode"=>201, "message"=>"Important fields are left empty.."));  
}
else{




 



  $extract_user = mysqli_query($conn, "SELECT * FROM `truck`  WHERE `truck_plate_number` = '$plate_number'") or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_user);
		 if ($count > 0) {
	 	  
			 
			  
			 
		 echo json_encode(array("statusCode"=>201, "message"=>"Vehicle Information Already In The Database. Please Check And Try Again Later.."));  
		 
 
		 }else
		 {
         
         
         $sql = "INSERT INTO `truck`(`account_number`, `truck_brand`, `year`, `truck_plate_number`, `state`, `total_capacity`, `truck_type`, `calibration_chart`, `road_worthiness_cert`, `commercial_licence`, `git_insurance`, `front_view_1`, `front_view_2`, `side_view_1`, `side_view_2`, `status`, `created_date`, `registeredby`, `ccaution`, `extinguisher`, `jacket`, `extratyre`, `hat`, `color`, `code`, `location`, `lati`, `longi`, `driver`, `boot` ) VALUES
('$username', '$brand', '$year', '$plate_number', '', '$capacity', '$model', '$vehicleregistration','$inpection','$vehiclelicence','$insurance','$frontview','$frontview', '$backview', '$backview','0','$datetime', '$username', '-', '-', '-', '-', '-', '$car_color', '$randing', '-', '-', '-', '$wynkid', '$car_color')";
             
             
                     
             
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 
	if ($process) {
        
         $last_id = $conn->insert_id;
        
        $truck_id = 	strtr(base64_encode($last_id), '+/=', '-_,');
             
                       
               $firstname = $myName->showName($conn, "SELECT  `firstname` FROM  `user_unit` WHERE  `account_number` = '$username'");
               $lastname = $myName->showName($conn, "SELECT  `lastname` FROM  `user_unit` WHERE  `account_number` = '$username'");
               $emailrr = $myName->showName($conn, "SELECT  `email` FROM  `user_unit` WHERE  `account_number` = '$username'");
               $phonerr = $myName->showName($conn, "SELECT  `phone` FROM  `user_unit` WHERE  `account_number` = '$username'");
               $file = $myName->showName($conn, "SELECT  `passport` FROM  `user_unit` WHERE  `account_number` = '$username'");
             
              $sql = 	 "INSERT INTO `driver`( `account_number`, `fname`, `lname`, `email`, `phone`, `license`, `license_expiry`, `passport`, `front_view`, `back_view`, `status`, `created_date`, `registeredby` ) VALUES
('$username', '$firstname', '$lastname', '$emailrr', '$phonerr', '$driverlicence', '', '$file','-','-','1','$datetime','$username')";  
            $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
        //`captain_type`
        
       // $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
        $sql = 	 "UPDATE    `user_unit` SET `captain_type` = '$captain_type', `association` = '$captain_type', `usertype` = '2' WHERE `account_number` = '$wynkid'";  
        
        $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
        
		
		
		
		
		
		
		
		  $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit`  WHERE `account_number` = '$wynkid'");	
		  $newphone = $myName->showName($conn, "SELECT `phone` FROM `user_unit`  WHERE `account_number` = '$wynkid'");	
		
		   $password = $myName->showName($conn, "SELECT `password` FROM `application`  WHERE  1");	
        
        
        
       $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
     //, `remita_username`, `remita_password`, `, `remita_url` 
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
      // $token = $myName->showName($conn, "SELECT `token` FROM `remita_setup` WHERE 1");	
      
      
// $remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username' AND `phone` != ''  LIMIT 1 ");
//$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$username' AND `password` != ''  LIMIT 1");	      
      
      
      

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
            // $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
		 
		 
		 
		 
		 
		  //second wallet
        
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
('$accountNumber1', '$currentBalance1', '$dateOpened1', '$schemeId1', '$schemeName1', '$walletAccountTypeId1', '$accountOwnerId1', '$accountOwnerName1', '$accountOwnerPhoneNumber1', '$accountName1', '$actualBalance1', '$walletLimit1','$trackingRef1','$nubanAccountNo1','$accountFullName1','$totalCustomerBalances1','1', '$datetime', '$wynkid', '$newphone', '$password', '0', '$lat', '$long')";
 
  
  
  
  
  /*
     	 
$sql = 	 "INSERT INTO `wallet_info`(`accountNumber`, `currentBalance`, `dateOpened`, `schemeId`, `schemeName`, `walletAccountTypeId`, `accountOwnerId`, `accountOwnerName`, `accountOwnerPhoneNumber`, `accountName`, `actualBalance`, `walletLimit`, `trackingRef`, `nubanAccountNo`, `accountFullName`, `totalCustomerBalances`, `status`, `created_date`, `registeredby`, `phone` , `password`, `primary_wallet`,`lati`, `longi` ) VALUES
('$accountNumber1', '$currentBalance1', '$dateOpened1', '$schemeId1', '$schemeName1', '$walletAccountTypeId1', '$accountOwnerId1', '$accountOwnerName1', '$accountOwnerPhoneNumber1', '$accountName1', '$actualBalance1', '$walletLimit1','$trackingRef1','$nubanAccountNo1','$accountFullName1','$totalCustomerBalances1','1', '$datetime', '$wynkid', '$newphone', '$password', '0', '$lat', '$long')";
*/
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));   
            
            
             // $message = "Hi, ". $firstname." Wallet Created Successfully: Wallet No. ".$accountNumber."! nubanAccountNo:".$nubanAccountNo.". Polaris Bank. Thank You.";

  
  	 //$Sending = new SendingSMS(); 
  							 
		//				 $Sending->smsAPI($phone,"Welcome",$message);
            
   }
		 
              
            
        
        
    }
		
		 
		 
		 
		}
	}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
        
             	echo json_encode(array("statusCode"=>200, "message"=>"Information submitted successfully."));
         }
             else
             {
                 
                 	echo json_encode(array("statusCode"=>201, "message"=>"Information not submitted successfully.")); 
             }










         }



}




     

 

 

 

?>

