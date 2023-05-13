<?php 

 

header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();
 
	
 $json =  json_decode(file_get_contents('php://input'), true);

   
 $amount = str_replace( ',', '',  $json['amount']); 


    //$amount = 60000;
 
//$query =  "SELECT `id`, `min_amount`, `max_amount`, `remita_transaction`, `vat`, `wynk_charges`, `total`, `status`, `created_date`, `registeredby` FROM `w2bcharges` WHERE  (`min_amount` <= '$amount' AND  `max_amount` >= '$amount') AND `status` = 1";



$query =  "SELECT `id`, `min_amount`, `max_amount`, `remita_transaction`, `vat`, `wynk_charges`, `total`, `status`, `created_date`, `registeredby` FROM `w2bcharges` WHERE  $amount BETWEEN `min_amount` AND `max_amount` AND `status` = 1";

//echo $query ;
 
  $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						  	$id =$row_distance[0];
  						  	$min_amount =$row_distance[1];
						   	$max_amount =$row_distance[2];
					  		$remita_transaction =$row_distance[3];
					  		$vat =$row_distance[4];
						   	$wynk_charges =$row_distance[5];
						   	$total =$row_distance[6];
		 
		 
		  echo json_encode(array("statusCode"=>200, "total_charges"=>$total, "remita_charges"=>$remita_transaction, "vat"=>$vat, "wynk_charges"=>$wynk_charges));  
	 }
	}
else
{
	 
		  echo json_encode(array("statusCode"=>201, "message"=>"Charges not found"));  
	
}








 



 
 

?>

