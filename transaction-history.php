<?php 
header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();


$json =  json_decode(file_get_contents('php://input'), true);

$username = $json['wynkid']; 

 //$username = "WYNK74832498";

if(!empty($username))
{
	 
 $query =  "SELECT `id`, `code`, `truck_owner`, `trip_status`, `amount`, `commissiononfee`, `message`, `owners_share`, `loadme_share`, `customer`,  `created_date`, `refs`, `products`, `narration`, `channel`, `id_number`, `wallet_number` FROM `transaction_information` WHERE `registeredby` = '$username' AND (`status` = '1')  ORDER BY `id` DESC";
	
	
	
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
		
		 $json2 = '[';
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						    $id =$row_distance[0];
						      $code =$row_distance[1];
					           $truck_owner =$row_distance[2];
		                          $trip_status =$row_distance[3];
						   $amount =$row_distance[4]; 
					       $commissiononfee =$row_distance[5];
		                      $message =$row_distance[6];
		                      $owners_share =$row_distance[7];
		                      $loadme_share =$row_distance[8];
		                      $customer =$row_distance[9];
		                      $created_date =$row_distance[10];
		                      $refs =$row_distance[11];
		                      $products =$row_distance[12];
		                      $narration =$row_distance[13];
		                      $channel =$row_distance[14];
		                      $id_number =$row_distance[15];
		                      $wallet_number =$row_distance[16];
		 
 
		 if(!empty($code))
		 {
		     
		     if($products == 'ride')
		     {
		         $customer = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$customer'");	
		         
		     }
		     
		     
			 $message = str_replace("{","",$message);
			  $json2 .= '{ 
		 "code": "'.$code.'",
    "customer": "'.$customer.'",
    "message": "'.$message.'",
    "products": "'.$products.'",
    "narration": "'.$narration.'",
    "channel": "'.$channel.'",
    "created_date": "'.$created_date.'",
    "debitted_wallet": "'.$wallet_number.'",
    "number": "'.$id_number.'",
    "amount": "'.number_format($amount, 2).'"
    
},'; 
		 }
		
										
		 
		 
		 
		 
	 }
		
								  
					$json2 .= "]";
	
	//echo $json2;
 	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
 echo trim($json1);
		
	
	}
 
  else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>"No Earnings Today Yet!!! Please Get Online.."));  			  
							  }

 
    
   }
else
{
	   
  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Wynk ID is missing. Please check and trry again later."));  
        
	
}
 

?>

