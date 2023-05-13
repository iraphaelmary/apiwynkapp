<?php 
 header('Access-Control-Allow-Origin: *');
  include("SendingSMS.php");

  include("config/DB_config.php");
 
require_once('view-application-details.php');
include("class_file.php");
 $myName = new Name();

  $verifyme_url = $myName->showName($conn, "SELECT  `verifyme_url` FROM `application` WHERE `status` = 1");
  $verifyme_api_key = $myName->showName($conn, "SELECT  `verifyme_api_key` FROM `application` WHERE `status` = 1");

        



$json =  json_decode(file_get_contents('php://input'), true);

// $data = json_decode($json);
 
$verification_type =  $json["verification_type"];
$id_number =  $json["verification_number"];
$wynkid =  $json["wynkid"];

  

if(!empty($verification_type))
{
 	
    $table = "otp";

    if(empty($id_number))
    {
      	echo json_encode(array("statusCode"=>201, "message"=>"ID number is empty. Please check try again later."));  
        
    }
    else{
    

        if(empty($wynkid))
        {
            echo json_encode(array("statusCode"=>201, "message"=>"Wynk Id is empty. Please check try again later."));  
            
        }
 else
 {
   $phone = $myName->showName($conn, "SELECT  `phone` FROM `otp` WHERE `account_number` = '$wynkid'");
     
     
     if(empty($phone))
     {
         
           echo json_encode(array("statusCode"=>201, "message"=>"Phone Number not retrived. User not validated. Please check and try again."));  
     }
     else
     {
     
  $extract_user = mysqli_query($conn, "SELECT `phone`  FROM `user_unit` WHERE `phone` = '$phone'   or `account_number` = '$wynkid'  or `id_number` = '$id_number'") or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_user);
		 if($count > 0) {
	 	  
	 	 
		
$sql = "UPDATE `user_unit` SET `account_number` = '$wynkid', `phone` = '$phone' , `created_date` = '$datetime', `registeredby` = '$emailing', `status`  = 1, `id_number` = '$id_number', `varify_type` = '$verification_type'  WHERE `phone` = '$phone' or `account_number` = '$wynkid'  or `id_number` = '$id_number'";
 
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 $process = true;
	if ($process) {
        
 echo json_encode(array("statusCode"=>200, "message"=>"Information submitted successfully.")); 
    }
             else
             {
                 
                 echo json_encode(array("statusCode"=>200, "message"=>"Information not submitted successfully. Please try again later.")); 
                 
             }
		
		
		
		
		
		
		//	echo json_encode(array("statusCode"=>201, "message"=>"Information in the database. Please check and try again.")); 
			 
		 
 
		 }else
		 {
 
 
             
$sql = "INSERT INTO `user_unit`(`account_number`, `phone` , `created_date`, `registeredby`, `status`, `id_number`, `varify_type`) VALUES
('$wynkid','$phone', '$datetime',  '$emailing',1, '$id_number', '$verification_type')";
 
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 $process = true;
	if ($process) {
        
	echo json_encode(array("statusCode"=>200, "message"=>"Information submitted successfully.")); 
    }
             else
             {
                 
                 echo json_encode(array("statusCode"=>200, "message"=>"Information not submitted successfully. Please try again later.")); 
                 
             }
     
     
     
     
     }
     
     
     
     
     
     
     
     
   } }
}
}
else{
    echo json_encode(array("statusCode"=>201, "message"=>"Verification type field is empty. Please check and try again.."));  
    
}

 

 

?>

