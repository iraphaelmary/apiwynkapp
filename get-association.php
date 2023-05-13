<?php
 
header('Access-Control-Allow-Origin: *');
	include("config/DB_config.php");

$json1 = "";
	 
	 $query =  "SELECT `id`, `name` FROM `association` WHERE  `status` = 1 ORDER BY `name` ASC";	
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
             
             echo json_encode(array("statusCode"=>201, "message"=>"No association registered yet."));  
         }
	 

?>