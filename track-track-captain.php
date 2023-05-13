<?php
header('Access-Control-Allow-Origin: *');
include("config/DB_config.php");
require_once('class_file.php');
 
$myName = new Name();
date_default_timezone_set('Africa/Lagos');




$json =  json_decode(file_get_contents('php://input'), true);


 
$username =  $json["wynkid"];
$longitude =  $json["longitude"];
$latitude =  $json["latitude"];
$value =  $json["value"];
 
 
  
$statement = "select * from `online_status` where `account_number` = '$username'";
 
   $truck_plate_number = $myName->showName($conn, "SELECT `truck_plate_number` FROM  `truck` WHERE (`account_number` = '$username')"); 	
	 
$result = mysqli_query($conn, $statement) or die("ERROR OCCURED: ".mysqli_error($conn));
 
	$count = mysqli_num_rows($result);
if($count > 0)
{
   $sql = 	mysqli_query($conn,"UPDATE `online_status` SET  `truck_plate_number` = '$truck_plate_number', `lati` = '$latitude', `longi` = '$longitude', `status` = '$value', `created_date` = '$datetime',`usertype` = '2' WHERE  `account_number` = '$username'") or die("ERROR OCCURED: ".mysqli_error($conn));
    
    if($sql)
    {
        
        echo json_encode(array("statusCode"=>200, "message"=>"Captain is online now."));  
    }
    else
    {
        
        echo json_encode(array("statusCode"=>201, "message"=>"Captain is online cannot be put online at this time. Please try again later.")); 
    }
    
    
        
    
}
    else
    {
         $sql = 	mysqli_query($conn,"INSERT INTO `online_status`(`account_number`, `truck_plate_number`, `location`, `lati`, `longi`, `status`, `created_date`, `usertype` ) VALUES('$username','$truck_plate_number','$location','$latitude','$longitude', '$value','$datetime','2')") or die("ERROR OCCURED: ".mysqli_error($conn));
        
        
          if($sql)
    {
        
        echo json_encode(array("statusCode"=>200, "message"=>"Captain is online now."));  
    }
    else
    {
        
        echo json_encode(array("statusCode"=>201, "message"=>"Captain is online cannot be put online at this time. Please try again later.")); 
    }
        
    }
    
    
    
    
   
 

 
?>

 