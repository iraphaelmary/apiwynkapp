<?php
header('Access-Control-Allow-Origin: *');
 
 

include("config/DB_config.php");
 
 include("SendingSMS.php");
 include("view-application-details.php");
include("class_file.php");

 
$wynkid  = "";
$account_number  = "";
$username  = "";


 $json =  json_decode(file_get_contents('php://input'), true);

 
 
 
if(isset($json['wynkid']))
{
    
  $wynkid =  $json["wynkid"];
 
}
 
 
 
 
     

     
if(empty($wynkid))
{
  
	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Wynk ID  Fields Cannot Be Empty. Please check and try again."));
	
}
else
{ 
	//SELECT * FROM `online_status`

  
		
 $sql = "UPDATE `online_status`  SET `status` = 0, `created_date` = '$datetime' WHERE `account_number` = '$wynkid' ";
 
 
 
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 
	if ($process) {
		 
 
 echo json_encode(array("statusCode"=>200, "Message"=>"Information successfully ececuted. Thank you."));   
		
  }
  else
  {
	  
	  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: Information not successfully processed."));  
  }


    
 }
 
            

 
 
 










?>