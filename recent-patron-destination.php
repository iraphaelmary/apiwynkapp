<?php
  header('Access-Control-Allow-Origin: *');
 include("config/DB_config.php");
 include("SendingSMS.php");
 include("class_file.php");


 $myName = new Name();
$emailing = "";
 
$json =  json_decode(file_get_contents('php://input'), true);

 
$wynkid = $json['patron_wynkid'];


if(!empty($wynkid))
{
	
	$json1 = "";
	 
	 $query =  "SELECT DISTINCT(`destination`) FROM `search_result` WHERE `registeredby` = '$wynkid' ORDER BY `id` DESC LIMIT 10";	
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
		      $json2 = '[';
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						  $destination=$row_distance[0];
		 
		$longi2 = $myName->showName($conn, "SELECT  `longi2` FROM `search_result`  WHERE `destination` = '$destination'"); 
		$lati2 = $myName->showName($conn, "SELECT  `lati2` FROM `search_result`  WHERE `destination` = '$destination'"); 
		$destinationregion = $myName->showName($conn, "SELECT  `destinationregion` FROM `search_result`  WHERE `destination` = '$destination'"); 
	 
			
$json2 .= '{
    "latitude": "'.$lati2.'",
    "longitude": "'.$longi2.'",
    "state": "'.$destinationregion.'",
    "destination": "'.$destination.'"
    
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
             
             echo json_encode(array("statusCode"=>201, "message"=>"No destination for patron yet."));  
         }
	 }

?>