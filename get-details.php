<?php 
header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();


$json =  json_decode(file_get_contents('php://input'), true);

 

 


$username = $json['wynkid']; 



if(!empty($username))
{
	
	



   $username = $_POST['username'];
    //$username = "LM793687";
     $longitude = $_POST['longitude'];
     $latitude = $_POST['latitude']; 
    
	 //WHERE  `account_number` = '$username'
 
        
       $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
     //, `remita_username`, `remita_password`, `, `remita_url` 
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
       


  $accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$username'");		
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
        
       // echo $resp;
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
$newphone =  preg_replace($pattern, $replacement, $phone);

            //2020-11-17
      $dateOfBirth =   date("Y-m-d", strtotime($rbirthdate));    
 //$url = "https://walletdemo.remita.net/api/wallet-external";//$url = "https://walletdemo.remita.net/api/wallet-external";
$url = $remita_url."/wallet-account/status/".$accountNumber."/ACTIVE";
         
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

    //var_dump($resp1);
        $status = false;
       // echo $resp1['code']." Coded";
        if(isset($resp1['code']) == "success")
        {
     
    $status = $resp1['data']['status'];     
        $id = $resp1['data']['id'];
 $accountNumber = $resp1['data']['accountNumber'];
 $currentBalance = $resp1['data']['currentBalance'];
 $dateOpened = $resp1['data']['dateOpened'];
 $schemeId = $resp1['data']['schemeId'];
 $schemeName = $resp1['data']['schemeName'];
 $walletAccountTypeId = $resp1['data']['walletAccountTypeId'];
 $accountOwnerId = $resp1['data']['accountOwnerId'];
 $accountOwnerName = $resp1['data']['accountOwnerName'];
 $accountOwnerPhoneNumber = $resp1['data']['accountOwnerPhoneNumber'];
 $accountName = $resp1['data']['accountName'];
 $actualBalance = $resp1['data']['actualBalance'];
 $trackingRef = $resp1['data']['trackingRef'];
 $walletLimit = $resp1['data']['walletLimit'];
 $nubanAccountNo = $resp1['data']['nubanAccountNo'];
 $accountFullName = $resp1['data']['accountFullName'];
 $totalCustomerBalances = $resp1['data']['totalCustomerBalances']; 
    
     	 
$sql = 	 "UPDATE `wallet_info` SET  `currentBalance` = '$currentBalance', `actualBalance` = '$actualBalance'  WHERE  `registeredby` = '$username'";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));    
   }
        
     
        
        
              
            
        
        
    }
     
            
            
             
        
    }
    }





















//`lati`, `longi`

   $onlinestatus = $myName->showName($conn, "SELECT `status` FROM  `online_status` WHERE (`account_number` = '$username')"); 	
   $current_lat = $myName->showName($conn, "SELECT `lati` FROM  `online_status` WHERE (`account_number` = '$username')"); 	
   $current_long = $myName->showName($conn, "SELECT `longi` FROM  `online_status` WHERE (`account_number` = '$username')"); 	


$today=date("Y-m-d");

   $todayearning = $myName->showName($conn, "SELECT SUM(`amount`) FROM  `search_result` WHERE (`truck_owner` = '$username' AND `status` = '1' AND `created_date` LIKE '%".$today."%')");    

$todaytrip = $myName->showName($conn, "SELECT COUNT(`ID`) FROM  `search_result` WHERE (`truck_owner` = '$username' AND `status` = '1' AND `created_date` LIKE '%".$today."%')"); 	


if($todayearning == "")
{
    
    $todayearning = 0;
}


$averagerating = $myName->showName($conn, "SELECT  AVG(`ratings_score`) FROM `ratings` WHERE  (`captain` = '$username')"); 
 

		   
 echo json_encode(array("statusCode"=>200, "message"=>"success", "onlinestatus"=>$onlinestatus, "currentBalance"=>number_format($currentBalance), "todayearning"=> $todayearning, "averagerating"=> number_format($averagerating,1), "todaytrip"=> $todaytrip, "current_lat"=> $current_lat, "current_long"=> $current_long));  
	  
	  
	  
        
        
     
     
    
   }
else
{
	   
  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Wynk ID is missing. Please check and trry again later."));  
        
	
}
 

?>

