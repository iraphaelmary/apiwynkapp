	 <?php
	header('Access-Control-Allow-Origin: *');
include ("config/DB_config.php"); 


include("class_file.php");
 
 //include("SendingSMS.php");

 $today=date("Y-m-d");
  $myName = new Name();
 $counting = 0;
  $radius = $myName->showName($conn, "SELECT  `radius` FROM `radius` WHERE `status` = 1");

$coordinates1 = true;
$coordinates2= true;
$value_value = "";






$json =  json_decode(file_get_contents('php://input'), true);



$latitude =  $json["latitude"];
$longitude =  $json["longitude"];
$wynkid =  $json["wynkid"];

/*
$latitude =  "6.5746108";
$longitude =  "3.3620367";*/





 if(!empty($longitude))
 { 
 
     
 
     
     
if (!$latitude || !$longitude )
{
  
  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Coordinate not retrived. Please check your location settings."));  
	
}
else
{    
     
 
 

 $code = date("YmdGis").rand(87, 37382387);
 
	
	$lat1 =  $json["latitude"];
$long1 =  $json["longitude"];

$wynkid =  $json["wynkid"];
 
/*$lat1 =  "6.5746108";
$long1 =  "3.3620367";*/
 


	 
 $query =  "SELECT id,account_number,location,
       lati, longi, status, distance
  FROM (
 SELECT 
 z.id,
 z.account_number,
  z.location,
   z.lati, 
	 z.longi,
        z.status,
	    p.radius,
        p.distance_unit
                 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(p.latpoint))
                 * COS(RADIANS(z.lati))
                 * COS(RADIANS(p.longpoint - z.longi))
                
                + SIN(RADIANS(p.latpoint))
                
                 * SIN(RADIANS(z.lati))))) AS distance
  FROM online_status AS z
  JOIN (
        SELECT  ".$lat1."  AS latpoint,  ".$long1." AS longpoint,
                 ".$radius .".0 AS radius,111.045 AS distance_unit
    ) AS p ON 1=1
  WHERE  (z.status = '1'  AND z.created_date LIKE '%".$today."%' AND z.usertype = 2 AND z.account_number != '$wynkid') AND z.lati
     BETWEEN p.latpoint  - (p.radius / p.distance_unit)
         AND p.latpoint  + (p.radius / p.distance_unit)
    AND z.longi
     BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
         AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
 ) AS d
 WHERE distance <= radius
 ORDER BY distance
 LIMIT 10";





 
$value1 = "";
	
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
		 $json2 = '[';
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
      				  	  
  $id =$row_distance[0];
      
						   	$account_number =$row_distance[1];
					  	 
					   	 
					   		$location =$row_distance[2];
					   		$lati =$row_distance[3];
					   		$longi =$row_distance[4];
         
         $publish_coordinate .= $lati.",".$longi. "*";
         
		 	 				 
			
$json2 .= '{
    "latitude": "'.$lati.'",
    "longitude": "'.$longi.'"
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
          echo json_encode(array("statusCode"=>201, "errorMessage"=>"Unable to get a car at your current location at the moment. Please continue with your search."));  
    
        
    }
 

    
    
    
 
    
    
    
     //echo json_encode(array("statusCode"=>200, "errorMessage"=>$value_value, "code"=>$code, "inst_name"=>$publish_coordinate));  
 	
 
}
 
 }
else
{
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Unable to get your current location at the moment. Please check and try again."));  
    
    
}


//echo $query;





	 

	   
?>
 









<?php
/*header('Access-Control-Allow-Origin: *');
	include("config/DB_config.php");
















$publish_coordinate = "-33.91721, 151.2263*"."-33.91539, 151.2282";


	 

///echo $publish_coordinate;

	































echo json_encode(array("statusCode"=>200, "errorMessage"=>"Success", "inst_name"=>$publish_coordinate));  		
 
 
	
		//exit;
		 */
 

?>