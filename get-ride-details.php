 <?php

 include("config/DB_config.php");
 include("SendingSMS.php");
 include("class_file.php");


 $myName = new Name();
$emailing = "";
 
$json =  json_decode(file_get_contents('php://input'), true);

 $json1 = '';
 $json2 = '';

 


 $wynkid = $json['wynkid'];
 $code = $json['code'];
 

$data=[];


 //$wynkid = "WYNK39553840";
// $code = "WYNK-RIDE-230707237";
 
 if(!empty($code))
 {
 
  
   
                 
$query1 =  "SELECT `id`, `code`, `loading`, `destination`, `pick_up_date`, `truck_type`, `truck_capacity`, `status`, `created_date`, `registeredby`, `cashed`, `longi1`, `lati1`, `longi2`, `lati2`, `distance`, `amount`, `truck_id`, `truck_owner`, `trip_status`, `minutes`,`destinationregion`, `road_maintenance_charge`, `means`, `stop`,`ride_share` FROM `search_result` WHERE `code` = '$code'";
  
  
  $extract_distance1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
		$count1 = mysqli_num_rows($extract_distance1);
    if ($count1 > 0)
		  {
 	 while ($row_distance1=mysqli_fetch_row($extract_distance1))
    {
  						  	$id =$row_distance1[0];
  						  	$code =$row_distance1[1];
						   	$loading =$row_distance1[2];
					  		$destination =$row_distance1[3];
					  		$pick_up_date =$row_distance1[4];
						   	$truck_type =$row_distance1[5];
					  		$truck_capacity =$row_distance1[6];
					  	    $status =$row_distance1[7];
                            $created_date =$row_distance1[8];
                            $registeredby =$row_distance1[9];
                            $cashed =$row_distance1[10];
                            $longi1 =$row_distance1[11];
                            $lati1 =$row_distance1[12];
                            $longi2 =$row_distance1[13];
                            $lati2 =$row_distance1[14];
                            $distance =$row_distance1[15];
                            $amount =$row_distance1[16];
                            $truck_id =$row_distance1[17];
                            $truck_owner =$row_distance1[18];
                            $captain_wynkid =$row_distance1[18];
                            $trip_status =$row_distance1[19];
                            $minutes =$row_distance1[20];
                            $destinationregion =$row_distance1[21];
                            $road_maintenance_charge =$row_distance1[22];
                            $means =$row_distance1[23];
                             $stop =$row_distance1[24];
                               $ride_share =$row_distance1[25];
                             
          $patrion_name = $myName->showName($conn, "SELECT `firstname` FROM `user_unit` WHERE `account_number` = '$registeredby'");
		 
		 
		 
		 
 $query1 =  "SELECT `id`, `stop_lat`, `stop_long`, `status`, `created_date`, `registeredby`, `ride_code`, `stop_desc`  FROM `ride_stops` WHERE `ride_code` = '$code'";	
  
 
 $extract_distance1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
		$count1 = mysqli_num_rows($extract_distance1);
    if ($count1 > 0)
		  {
		
		    $json2 = '[';
 	 while ($count1=mysqli_fetch_row($extract_distance1))
    {
  						    $id1 =$count1[0];
						      $stop_lat =$count1[1];
					           $stop_long =$count1[2];
		                          $status =$count1[3];
						   $created_date =$count1[4]; 
					       $registeredby =$count1[5];
		                      $ride_code =$count1[6];
                            $stop_desc =$count1[7];
					         
		 
			 
		 
		 				 
			
/*$json2 .= '{
    "stop_lat": "'.$stop_lat.'",
    "stop_long": "'.$stop_long.'",
    "ride_code": "'.$ride_code.'",
    "stop_desc: "'.$stop_desc.'"
},'; 
		*/ 
 	$stopData = [
"stops_lat"=>$stop_lat,
"stops_lng"=>$stop_long,
"stops_desc"=>$stop_desc,
];
					 
array_push($data,$stopData);
	 
}
 
		//$json2 .= "]";
	 
	 /*
	 $stops = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
 							  
		}*/
		 
		 $response = $data;
		
		
         
         
     }
		
		
		  $current_lat = $myName->showName($conn, "SELECT `lati` FROM  `online_status` WHERE (`account_number` = '$captain_wynkid')"); 	
   $current_long = $myName->showName($conn, "SELECT `longi` FROM  `online_status` WHERE (`account_number` = '$captain_wynkid')"); 	

 
 echo json_encode(array("statusCode"=>200, "id"=>  $id ,"code"=>  $code ,"pickup"=>  $loading ,"destination"=>  $destination , "pick_up_date"=>  $pick_up_date ,"car_capacity"=>  $truck_capacity , "status"=>  $status ,"patron_wynkid"=>  $registeredby , "pickup_long"=>  $longi1 ,"pickup_lat"=>  $lati1 ,"dest_long"=>  $longi2 ,"dest_lat"=>  $lati2 ,"distance"=>  $distance ,"minutes"=>  $minutes ,"car_id"=>  $truck_id ,"captain_wynkid"=>  $truck_owner , "amount"=>$amount,"road_maintenance_charge"=>  $road_maintenance_charge ,"patrion_name"=>  $patrion_name,"stops"=> $stop, "current_lat"=> $current_lat, "current_long"=> $current_long, "ride_share"=> $ride_share));   
		
/*	ride_share
	$json2 .= "]";
	
	//echo $json2;
	 
	 $json1 = '{
    "statusCode"=> 200,
    "message"=> '.$json2.'}';
	 
	  
 //$json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
  echo trim($json1);*/
    }
	}
	 else
         {
             
             echo json_encode(array("statusCode"=>201, "message"=>"No ride available for this code."));  
         }
                 
                 
   
           
             
             
             
 
 }
 else
 {
      echo json_encode(array("statusCode"=>201, "message"=>"Ride code is missing. Please check and try again.")); 
     
     
 }
 
 
$conn->close();
	
 
?>

 