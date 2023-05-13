<?php
 header('Access-Control-Allow-Origin: *');
 // include("SendingSMS.php");

  include("config/DB_config.php");
include("class_file.php");
   $myName = new Name();
require_once('view-application-details.php');


$json =  json_decode(file_get_contents('php://input'), true);

// $data = json_decode($json);
 
$latitude =  $json["latitude"];
$longitude =  $json["longitude"];
$username =  $json["wynkid"];







if(!empty($json["latitude"]) && !empty($json["longitude"]) && !empty($json["wynkid"])){
   
 
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($json["latitude"]).','.trim($json["longitude"]).'&key='.$googleapi;
    $json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    
    //if request status is successful
    if($status == "OK"){
        //get address from json data
        $location = $data->results[0]->formatted_address;
    }else{
        $location =  '';
    }
 
 
 
    
    
/*    
      $username = "Wynk97968286";
     $longitude = "37.09024";
     $latitude = "-95.712891";
    */
$statement = "select * from `online_status` where `account_number` = '$username'";
 
   $truck_plate_number = $myName->showName($conn, "SELECT `truck_plate_number` FROM  `truck` WHERE (`account_number` = '$username')"); 	
	 
$result = mysqli_query($conn, $statement) or die("ERROR OCCURED: ".mysqli_error($conn));
 
	$count = mysqli_num_rows($result);
if($count > 0)
{
   $sql = 	mysqli_query($conn,"UPDATE `online_status` SET  `truck_plate_number` = '$truck_plate_number', `location` = '$location', `lati` = '$latitude', `longi` = '$longitude',   `created_date` = '$datetime' WHERE  `account_number` = '$username'") or die("ERROR OCCURED: ".mysqli_error($conn));
    
       //   $sql = 	mysqli_query($conn,"INSERT INTO `online_status2`(`account_number`, `truck_plate_number`, `location`, `lati`, `longi`,  `created_date` ) VALUES('$username','$truck_plate_number','$location','$latitude','$longitude',  '$datetime')") or die("ERROR OCCURED: ".mysqli_error($conn));
    
        
    
}
    else
    {
         $sql = 	mysqli_query($conn,"INSERT INTO `online_status`(`account_number`, `truck_plate_number`, `location`, `lati`, `longi`,  `created_date` ) VALUES('$username','$truck_plate_number','$location','$latitude','$longitude',  '$datetime')") or die("ERROR OCCURED: ".mysqli_error($conn));
        
        
          //$sql = 	mysqli_query($conn,"INSERT INTO `online_status2`(`account_number`, `truck_plate_number`, `location`, `lati`, `longi`,  `created_date` ) VALUES('$username','$truck_plate_number','$location','$latitude','$longitude',  '$datetime')") or die("ERROR OCCURED: ".mysqli_error($conn));
        
        
    }
    
    
    if($sql)
    {
        
          echo json_encode(array("statusCode"=>200, "errorMessage"=>"Information Submitted Successfully")); 
    }
    else
    {
         echo json_encode(array("statusCode"=>200, "errorMessage"=>"Information Not Aubmitted Successfully")); 
    }
    
    
    
    echo $location;
}
else{
    
    
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Information not complete."));  
}
 

 
?>

 