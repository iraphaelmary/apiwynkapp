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
  $today=date("Y-m-d");


$fcm = new FCM(); 
$fcmSend = new fcm();

  





 $query =  "SELECT `id`, `code`, `loading`, `destination`, `pick_up_date`, `created_date`, `registeredby`, `longi1`, `lati1`, `longi2`, `lati2`, `distance`,   `truck_id`, `truck_owner`, `trip_status`, `minutes`, `ride_share` FROM `search_result`  WHERE (`status` = 4 OR `status` = 7 OR `status` = 8) AND `ride_share` > 0";	
  
 //478

//echo  $query;
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						    $id =$row_distance[0];
						      $code =$row_distance[1];
					           $loading =$row_distance[2];
		                          $destination =$row_distance[3];
						   $pick_up_date =$row_distance[4]; 
					       $created_date =$row_distance[5];
		                      $registeredby =$row_distance[6];
                               $longi1 =$row_distance[7];
					          $lati1 =$row_distance[8];
		      $longi2 =$row_distance[9];
		      $lati2 =$row_distance[10];
		 	 $distance =$row_distance[11];
		 	 $truck_id =$row_distance[12];
		 	 $truck_owner =$row_distance[13];
		 	 $trip_status =$row_distance[14];
		 	 $minutes =$row_distance[15];
		 	 $ride_share =$row_distance[16];
		 
			 
		 
		    $radius = $myName->showName($conn, "SELECT  `radius` FROM `radius` WHERE `status` = 1");
    
 
 
    $lati = $lati1;
    $longi = $longi1;
     
 
    
 //SELECT  `id`, `account_number`, `truck_plate_number`, `location`, `lati`, `longi`, `status`, `created_date` FROM `track_patron` WHERE 1
	 
 $query =  "SELECT `id`, `account_number`,  `location`, `lati`, `longi`, `status`, `created_date`, distance
  FROM (
 SELECT 
 z.id,
 z.account_number,
 z.location,
      z.lati, 
		z.longi,
        z.status,
        z.created_date,
	    p.radius,
        p.distance_unit
                 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(p.latpoint))
                 * COS(RADIANS(z.lati))
                 * COS(RADIANS(p.longpoint - z.longi))
                
                + SIN(RADIANS(p.latpoint))
                
                 * SIN(RADIANS(z.lati))))) AS distance
  FROM track_patron AS z
  JOIN (
        SELECT  ".$lati."  AS latpoint,  ".$longi." AS longpoint,
                 ".$radius .".0 AS radius, 111.045 AS distance_unit
    ) AS p ON 1=1
  WHERE z.lati
     BETWEEN p.latpoint  - (p.radius / p.distance_unit)
         AND p.latpoint  + (p.radius / p.distance_unit)
    AND z.longi
     BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
         AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
 ) AS d
 WHERE distance <= radius
 ORDER BY distance 
 LIMIT 10";
	 
 
	
 //echo $query;
 

$value1 = "";
	
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
      				   		$id =$row_distance[0];
                           	$account_number =$row_distance[1];
						   	$listing_code =$row_distance[1];
					  	  	$location =$row_distance[2];
						   	$lati =$row_distance[3];
					  		$longi =$row_distance[4];
					  		$status =$row_distance[5];
						   	$created_date =$row_distance[6];
						    $distance_unit =$row_distance[7];
			  		
		 
		 
		 $created_date_num=$myName->showName($conn, "SELECT `created_date` FROM `share_ride_patron` WHERE `wynkid` = '$account_number' and `ride_code` = '$code'"); 
		 
		// echo $created_date_num;
		 //if($registeredby != $account_number){
		 if(empty($created_date_num))
		 {
		 
		 						
 $device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = '$account_number'"); 	
 	
		
			
				  
 $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `truck_id`, `trip`, `ride_share`) VALUES('$code','Ride Share Alert','$message','$account_number', '$registeredby', '1', '1','$datetime', '$truck_id', '2', '1')";

  $extract_distance = mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));  
	$sqlnot ="INSERT INTO `share_ride_patron`(`ride_code`, `wynkid`, `created_date`, `registeredby`, `status` ) VALUES
('$code', '$account_number','$datetime','$registeredby', '1')";

  $extract_distance = mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));    	
		 
			if(!empty($device_token))
			{
				
					$message = "There is a ride share from ".$loading." to ".$destination." would you be interested to join?";
				 
				$fcmSend->sendFCM($device_token, "Ride Share Alert",$message, "2", $message);
		
				
				//SELECT `id`, `ride_code`, `wynkid`, `created_date`, `registeredby`, `status` FROM `share_ride_patron` WHERE 1
			
//	 echo json_encode(array("statusCode"=>200, "message"=>$message, "wynkid" => $registeredby, "ride_code"=>$code));  					
				
				
				
			}			
			
		

 


  $extract_distance = mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));    
		 echo json_encode(array("statusCode"=>200, "message"=>$message, "wynkid" => $registeredby, "ride_code"=>$code));  			
		 
		 }
		 else
							{
								
								//echo json_encode(array("statusCode"=>204, "message"=>"You have gtten the ride share before."));
								echo json_encode(array("statusCode"=>204, "message"=>"Unavailable"));
								
							}
		 
		 
	/*	 }else
							{
								
								//echo json_encode(array("statusCode"=>203, "message"=>"There is ride share. But you are the original patron that shared the ride."));
								echo json_encode(array("statusCode"=>203, "message"=>"Unavailable"));
								
							}*/
		 
		 
							}
							}
							else
							{
								
							//	echo json_encode(array("statusCode"=>202, "message"=>"There is ride share. But not in your radius."));
								
								
									echo json_encode(array("statusCode"=>202, "message"=>"Unavailable"));
								
							}
							}
		 
		 	 
		 	 
	 						     
									 
	 
}
else
{
	// echo json_encode(array("statusCode"=>200, "message"=>"No ride share Available/The ride share is more than 5 mins ago."));
	 
	 echo json_encode(array("statusCode"=>201, "message"=>"Unavailable"));
}
 
						  
 

 

	   
?>
 

