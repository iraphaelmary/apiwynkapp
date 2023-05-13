<?php 
/*
 ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1); */
header('Access-Control-Allow-Origin: *');
 
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');
require_once('SendingSMS.php');
require_once('fcm-send-function.php');
require_once('view-application-details.php');
 $Sending = new SendingSMS(); 
$myName = new Name(); 



$fcm = new FCM(); 
$fcmSend = new fcm();
 

 
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);






$json =  json_decode(file_get_contents('php://input'), true);

 
$code = "WYNK-".date("Ymd").rand(23,983).rand(34,287); 
 


 
$username = $json['wynkid'];
$emailing  = $json['wynkid'];
$from_wallet  = $json['from_wallet'];
$to_wallet  = $json['to_wallet'];


$amount = str_replace(",","",$json['amount']) ;

 




		 $device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = '$WYNK74654117'"); 	
			echo $device_token;
			
			if(!empty($device_token))
			{
				
				$fcmSend->sendFCM($device_token, "Credit Alert",$message, "WYNK VALUT CREDIT ALERT", $message);
				
				
				echo $fcmSend;
			}
else
{
	
	echo "Not sent";
}
				

 
 


  
              
    
			
			
			
			
			
			
			
 
		   
		 
	  
  
 

?>

