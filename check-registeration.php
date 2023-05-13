<?php 
header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();

	  $count_times = 0;    

	  	 
$json =  json_decode(file_get_contents('php://input'), true);
  
$wynkid =   mysqli_real_escape_string($conn, $json["wynkid"]) ;
//$wynkid =  "WYNK233787112";
 


  
 $extract_user = mysqli_query($conn, "SELECT * FROM `user_credntials` WHERE `account_number` = '$wynkid'") or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_user);
		 if ($count > 0) {
	 	 
 echo json_encode(array("statusCode"=>200, "errorMessage"=>"User information in the  database already."));  
  
		 }else
		 {
			 
 echo json_encode(array("statusCode"=>201, "errorMessage"=>"User information not in the  database already. Please check and try again later.."));  
			 
		 }

  
    
    
 
 

?>

