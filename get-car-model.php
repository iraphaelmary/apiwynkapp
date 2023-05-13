<?php
header('Access-Control-Allow-Origin: *');
	include("config/DB_config.php");


$json =  json_decode(file_get_contents('php://input'), true);

 
 
$car_type_id =  $json["car_type_id"];





	$strOptions = "";
	 if(!empty($car_type_id)){
  $first = $car_type_id;
	 $query =  "SELECT `id`,  `name` FROM `model` WHERE `brand` = '$first' ORDER BY `name` ASC";	
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
        
         $json2 = '[';
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						  $id=$row_distance[0];
		  $name=$row_distance[1];
		
	  
					  
				 
			
$json2 .= '{
    "id": "'.$id.'",
    "name": "'.$name.'"
},'; 
				
				  
	}
	 
	
	
	
	$json2 .= "]";
	
	//echo $json2;
	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
  echo trim($json1);
  
  
  //echo substr($json1, 0, -4);
	  //echo rtrim($json1, ",");
       //echo json_encode(array("statusCode"=>200, "message"=>$json2));     
		  }
           else
         {
             
             echo json_encode(array("statusCode"=>201, "message"=>"No car model registered yet."));  
         }
	 }   else
         {
             
             echo json_encode(array("statusCode"=>201, "message"=>"Car Type ID missing."));  
         }

?>