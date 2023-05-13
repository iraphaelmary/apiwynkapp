<?php 
header('Access-Control-Allow-Origin: *');
 
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');
require_once('SendingSMS.php');

$myName = new Name();
 


$json =  json_decode(file_get_contents('php://input'), true);

 

 


 $username = $json['wynkid'];
 $emailing = $json['wynkid'];
$wallet_number  = $json['wallet_number'];

 /*
 $username = "WYNK33833157";
 $emailing = "WYNK33833157";
$wallet_number  = "5935705439";
 */
 
if(!empty($wallet_number))
{
 
		 $accountName = $myName->showName($conn, "SELECT `accountName` FROM `wallet_info` WHERE `accountNumber` = '$wallet_number' AND `status` = 1  AND `accountName` != '' LIMIT 1");
	

	
	if($accountName == "" or empty($accountName) )
	{
		
	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Name cannnot be confirmed at this time. Please check and try again later."));  	
	}
	else{
		
		$registeredby = $myName->showName($conn, "SELECT `registeredby` FROM `wallet_info` WHERE `accountNumber` = '$wallet_number' AND `status` = 1");
	
	//echo	"SELECT `name` FROM `user_unit` WHERE `account_number` = '$registeredby' AND `status` = 1";
	
	
	 $name = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$registeredby' AND `status` = 1");
	 $phone = $myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$registeredby' AND `status` = 1");
	
//echo json_encode(array("statusCode"=>200, "message"=>"Information Retieved Successfully","accountName"=>$name." - ".$accountName ));  
		
echo json_encode(array("statusCode"=>200,"wynkid"=>$registeredby, "message"=>"Information Retieved Successfully","accountName"=>$accountName,"phone"=>$phone ));  
	}
	
	 
	
	
	
	
	
	
	
	
	
	
	
	
}
else
{
	
	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Important Information Missing")); 
}
 

?>

