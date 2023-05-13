<?php
	header('Access-Control-Allow-Origin: *');
include ("config/DB_config.php"); 
/* ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1); */

include("class_file.php");
$road_maintenance_charge = 0;
 
 include("SendingSMS.php");
  $myName = new Name();



$coordinates1 = true;
$coordinates2= true;
$value_value = "";
$json =  json_decode(file_get_contents('php://input'), true);
require_once('fcm-send-function.php');
require_once('view-application-details.php');
 $Sending = new SendingSMS(); 
 
$code = date("Ymd");

$fcm = new FCM(); 
$fcmSend = new fcm();

 
 						
 $device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = 'WYNK33742751'"); 	
 	
			$message = "We are happy to inform you that the issue with your account has been resolved. You should now be able to access and use your account normally. We apologize again for any inconvenience this may have caused, and thank you for your patience while we worked to resolve the issue. If you have any further concerns or questions, please do not hesitate to contact us on 09099797979. WYNK";
			
			
		 
			if(!empty($device_token))
			{
				
				$fcmSend->sendFCM($device_token, "We are sorry!!",$message, "2", $message);
				
				
				
          $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `truck_id`, `trip`) VALUES
('$code','We are sorry!!','$message','WYNK33742751', 'WYNK33742751', '1', '1','$datetime', '0', '0')";
				
				$sql = 	mysqli_query($conn,$sqlnot )or die("ERROR OCCURED: ".mysqli_error($conn)); 	
				
				if($sql){
					echo "Sent";
				}
				else
				{
echo "Not Sent";
					
				}

			}			

	   
?>
 

