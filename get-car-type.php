<?php
header('Access-Control-Allow-Origin: *');
	include("config/DB_config.php");
	
	 $query =  "SELECT  `id`, `name`  FROM `truck_type` WHERE `status` = 1 AND `name` != '' ORDER BY `id` ASC";	
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
		       $json2 = '[';
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {   $id=$row_distance[0];
		  $name=$row_distance[1];
		
	 
					 
					  //	$json1 .= "{id:".$id. ",". "name:".$name."}";
					  
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
		
		  }
 else
         {
             
             echo json_encode(array("statusCode"=>201, "message"=>"No vehicle type registered yet."));  
         }
	 
	

?>