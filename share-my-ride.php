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
 


$fcm = new FCM(); 
$fcmSend = new fcm();

 
$ride_code = $json['ride_code']; 
$number_of_patron = $json['number_of_patron']; 


 
     
       
 
   $emailing = $myName->showName($conn, "SELECT `registeredby` FROM `search_result` WHERE `code`   = '$ride_code'");	
       $lati = $myName->showName($conn, "SELECT `lati` FROM `track_patron` WHERE `account_number`   = '$emailing'");		    
       $longi = $myName->showName($conn, "SELECT `longi` FROM `track_patron` WHERE `account_number`   = '$emailing'");		    

   
    
     
 if(!empty($emailing))
 { 
     
       $radius = $myName->showName($conn, "SELECT  `radius` FROM `radius` WHERE `status` = 1");
     
  $today=date("Y-m-d");
 
 
 if(empty($lati) or empty($longi))
{
  
  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Main patron location cannot be tracked. Please check back again."));  
	
}
else
{ 
	
 
		 $query =  "SELECT `id`  FROM `ride_share`  WHERE `ride_code` = '$ride_code'";	
  
 
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count <= 0)
		  {
 	 
	
	
	 $sql = mysqli_query($conn,"INSERT INTO `ride_share`(`ride_code`, `number_of_patron`, `status`, `created_date`, `registeredby`) VALUES('$ride_code','$number_of_patron','1', '$datetime','$emailing')") or die("ERROR OCCURED: ".mysqli_error($conn)); 

      
        $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));	
	
	
	if($sql)
	{
		   $truck_owner = $myName->showName($conn, "SELECT `truck_owner` FROM `search_result` WHERE `code`   = '$ride_code'");		  
		   $captain_name= $myName->showName($conn, "SELECT `firstname` FROM `user_unit` WHERE `account_number`   = '$truck_owner'");		  
		   $patron_name= $myName->showName($conn, "SELECT `firstname` FROM `user_unit` WHERE `account_number`   = '$email'");		  
		
		
				 			
 $device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = '$truck_owner'"); 	
 	
		  $sql = mysqli_query($conn,"UPDATE `search_result`  SET  `ride_share` = 1 WHERE `code` = '$ride_code'") or die("ERROR OCCURED: ".mysqli_error($conn)); 

      
        $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));	
	    
         		  
$message = "Hi ".$captain_name.",
your patron ".$patron_name."
just opted to share the ride with 
".$number_of_patron." additional patron(s).";
			
			
		 
			if(!empty($device_token))
			{
				
				$fcmSend->sendFCM($device_token, "Ride Booking Request",$message, "1", $message);
			}		
		
		  echo json_encode(array("statusCode"=>200, "message"=>"Ride Share Successfull. We are getting patrons close to you.")); 
		
	}
	else
	{
		
		
		 echo json_encode(array("statusCode"=>201, "message"=>"Ride Share Not Successfull.")); 
	}
		
		
     
    }
	else{
		
		
		 echo json_encode(array("statusCode"=>201, "message"=>"This Ride has been shared previously.")); 
	}
    }
	
}

	   
?>
 

