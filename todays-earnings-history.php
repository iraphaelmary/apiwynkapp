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
	
	 	$today=date("Y-m-d");
  
// $query =  "SELECT `id`, `code`, `loading`, `destination`, `pick_up_date`,  `created_date`, `registeredby`, `amount` FROM  `search_result` WHERE (`truck_owner` = '$username' AND `status` = '1' AND `created_date` LIKE '%".$today."%')";  
 $query =  "SELECT `id`, `code`, `loading`, `destination`, `pick_up_date`,  `created_date`, `registeredby`, `amount` FROM  `search_result` WHERE (`truck_owner` = '$username' AND `status` = '1') ORDER BY `id` DESC LIMIT 10";
	
	
	
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
		
		 $json2 = '[';
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						    $id =$row_distance[0];
						      $code =$row_distance[1];
					           $loading =$row_distance[2];
		                          $destination =$row_distance[3];
						   $pick_up_date =$row_distance[4]; 
					       $created_date =$row_distance[5];
		                      $registeredby =$row_distance[6];
		                      $amount =$row_distance[7];
		 
		 
		 $patron = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$registeredby'"); 
		 
		 $json2 .= '{ 
		 "code": "'.$code.'",
    "loading": "'.$loading.'",
    "destination": "'.$destination.'",
    "patron": "'.$patron.'",
    "created_date": "'.$created_date.'",
    "amount": "'.number_format($amount, 2).'"
    
},'; 
										
		 
		 
		 
		 
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

