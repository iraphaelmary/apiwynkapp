<?php
header('Access-Control-Allow-Origin: *');
 
 

include("config/DB_config.php");
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

 

 
 
if(!isset($json['wynkid']))
{
    
  $wynkid =  $json["wynkid"];
  $account_number =  $json["wynkid"];
  $username =  $json["wynkid"];
  $bvn =  $json["bvn"];
  $nin =  $json["nin"];
  $picture =  $json["picture"];
  $doctype =  "Nepa Bill";
  
 /*
  $account_number =  "WYNK23378711";
  $username =  "WYNK23378711";
  $bvn = "22266502922";
  $nin = "65558731151";
  $picture = "WYNK60144945";
  $doctype =  "Nepa Bill";
$wynkid =  "WYNK23378711";
 */
 
 $myName = new Name();
 
 	 
 $sql = 	 "INSERT INTO `kyc_level_2`(`bvn`, `nin`, `doctype`, `picture`, `created_date`, `registeredby`, `message`) VALUES
('$bvn', '$nin', '$doctype', '$picture','$datetime', '$username', '$message')";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));    

     
if(empty($wynkid))
{
  
	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Some Important Fields Are Left Empty. Please check and try again."));
	
}
else
{ 
 
   $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
     //, `remita_username`, `remita_password`, `, `remita_url` 
     //  $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
      // $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
      // $token = $myName->showName($conn, "SELECT `token` FROM `remita_setup` WHERE 1");		    

	
	
	 $remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username' AND `phone` != ''  LIMIT 1 ");
	$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$username' AND `password` != ''  LIMIT 1");	
 	$remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");	
 
	if(empty($bvn))
	{
		  

	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Some Important Fields Are Left Empty. Please check and try again."));
		
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
        
        
        $resp = json_decode($resp, true);
        
     //echo $resp;
        $message = $resp['message'];
     
        if($message == "Login success")
        { $token = $resp['token'];
            // $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
    
	 
        
        //second wallet
        
        $url = $remita_url."/upgrade-kyc";
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
        
		 /*"bvn": "1234567890",
  "verificationId": "68455469787",
  "docType": "Nepa bill",
  "docFormat": "JPG",
  "docFile": "Base 64 String"*/
		 
		 
$data = <<<DATA
{
      "bvn": "$bvn",
      "verificationId": "$nin",
      "docType": "Nepa bill",
      "docFile": "$picture"
   
}
DATA;
       // echo $data;
        
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
        
       // echo $resp;  
      
 $resp1 = json_decode($resp2, true);
     
 $status = $resp1['status'];     
 $message = $resp1['message'];
   
        $status = false;
    
        if(isset($resp1['code']) != "Failed")
        {
     
 $status = $resp1['status'];     
 $message = $resp1['message'];
 
       
     	 
 $sql = 	 "INSERT INTO `kyc_level_2`(`bvn`, `nin`, `doctype`, `picture`, `created_date`, `registeredby`, `message`) VALUES
('$bvn', '$nin', '$doctype', '$picture','$datetime', '$username', '$message')";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));    
            
        
			
			
 echo json_encode(array("statusCode"=>200, "message"=>$message));  	
            
   }
		else
		{
			 echo json_encode(array("statusCode"=>201, "errorMessage"=>$message)); 
		}
		 
              
            
        
        
    }
    }
     
            
            
             
        
    }
     
         
        
   
            
            
            
   
 
        
        
        
        
  
 //echo json_encode(array("statusCode"=>200, "errorMessage"=>"Information submitted successfully. Please continue.", "email"=>$email, "username"=>$username,"walletno"=>$accountNumber, "nubanAccountNo"=>$nubanAccountNo,"bank"=>"Polaris Bank", "error"=>""));   
		
 


    
 }
 
            
}
 
 
}
	else
		{
			 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Wynk ID cannot be empty.")); 
		}
		 









?>