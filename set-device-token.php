<?php
header('Access-Control-Allow-Origin: *');
include("config/DB_config.php");
require_once('class_file.php');
 
$myName = new Name();
date_default_timezone_set('Africa/Lagos');




$json =  json_decode(file_get_contents('php://input'), true);


 
$username =  $json["wynkid"];
$devicetoken =  $json["devicetoken"]; 

 
 
 
 
 
  
$statement = "select * from `device_token` where `account_number` = '$username'";
 
 
	 
$result = mysqli_query($conn, $statement) or die("ERROR OCCURED: ".mysqli_error($conn));
 
	$count = mysqli_num_rows($result);
if($count > 0)
{
   $sql = 	mysqli_query($conn,"UPDATE `device_token` SET  `device_token` = '$devicetoken',  `updated_date` = '$datetime'  WHERE  `account_number` = '$username'") or die("ERROR OCCURED: ".mysqli_error($conn));
    
    if($sql)
    {
        
       
            echo json_encode(array("statusCode"=>200, "message"=>"Device Token Set Successfully."));  
            
       
        
    }
    else
    {
        
        echo json_encode(array("statusCode"=>201, "message"=>"Device Token Not Set Successfully. Please try again later.")); 
    }
    
    
        
    
}
    else
    {
         $sql = 	mysqli_query($conn,"INSERT INTO `device_token`(`account_number`, `device_token` , `status`, `created_date`  ) VALUES('$username','$devicetoken' ,'2', '$datetime')") or die("ERROR OCCURED: ".mysqli_error($conn));
        
        
          if($sql)
    {
        
         
       
            echo json_encode(array("statusCode"=>200, "message"=>"Device Token Set Successfully."));  
         
       
        
    }
    else
    {
        
        echo json_encode(array("statusCode"=>201, "message"=>"Device Token Not Set Successfully. Please try again later."));
    }
        
    }
    
    
    
    
   
 

 
?>

 