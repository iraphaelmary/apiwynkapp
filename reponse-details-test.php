<?php
header('Access-Control-Allow-Origin: *');
 
 

include("config/DB_config.php");
 
 include("SendingSMS.php");
 include("view-application-details.php");
include("class_file.php");
 $myName = new Name();
 
$phone  = "";
$username  = "";


 $json =  json_decode(file_get_contents('php://input'), true);

 


 
    
  $phone =  $json['phone'];  
 
 
 
 $phone  = "2348108968214";
 
 

 
     

     
if(empty($phone))
{
  
	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Important Field Are Left Empty. Please check and try again."));
	
}
else
{
	
	
	
	       $account_number = $myName->showName($conn, "SELECT `account_number` FROM `user_unit` WHERE `phone` = '$phone' AND  `phone` LIKE '%$phone%'");	
	       $name = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `phone` = '$phone'  AND  `phone` LIKE '%$phone%'");	
      
	
	
	   $wallet_number = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = trim('$account_number') AND `primary_wallet` = 1 AND `accountNumber` != '' ORDER BY `id` DESC LIMIT 1");	
	
	
	
	
	
 		 
            
            
   
        
  
 echo json_encode(array("statusCode"=>200, "wynkid"=>$account_number, "name"=>$name, "wallet_number"=>$wallet_number));   


    
 }
 
            

 
 
 










?>