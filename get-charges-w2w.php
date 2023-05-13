<?php 

 

header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();
 
	
	/*SELECT `id`, `remita_transaction`, `vat`, `wynk_charges`, `total`, `status`, `created_date`, `registeredby` FROM `w2wcharges` WHERE 1
*/
	
	
  $fee = $myName->showName($conn, "SELECT  `total` FROM `w2wcharges` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 1");	
  $remita_transaction = $myName->showName($conn, "SELECT  `remita_transaction` FROM `w2wcharges` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 1");	
  $vat = $myName->showName($conn, "SELECT  `vat` FROM `w2wcharges` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 1");	
  $wynk_charges = $myName->showName($conn, "SELECT  `wynk_charges` FROM `w2wcharges` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 1");	


 

if(!empty($fee))
{
	
	 echo json_encode(array("statusCode"=>200, "total_charges"=>$fee, "remita_charges"=>$remita_transaction, "vat"=>$vat, "wynk_charges"=>$wynk_charges));  
}
else{
 echo json_encode(array("statusCode"=>201, "rate"=>"Rate not found."));  	
	
}





 
 

?>

