<?php 

 

header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();
 
	
	
	
	
  $fee = $myName->showName($conn, "SELECT `fee` FROM `application` WHERE 1");	


 

if(!empty($fee))
{
	
	 echo json_encode(array("statusCode"=>200, "rate"=>$fee));  
}
else{
 echo json_encode(array("statusCode"=>201, "rate"=>"Rate not found."));  	
	
}





 
 

?>

