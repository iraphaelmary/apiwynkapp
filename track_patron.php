<?php
 header('Access-Control-Allow-Origin: *');
 // include("SendingSMS.php");

  include("config/DB_config.php");
include("class_file.php");
   $myName = new Name();
require_once('view-application-details.php');


$json =  json_decode(file_get_contents('php://input'), true);

 
 
$latitude =  $json["latitude"];
$longitude =  $json["longitude"];
$username =  $json["wynkid"];

 

//{"wynkid":"WYNK39553840","longitude":7.3753517,"latitude":9.1473017}



   
 
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&key='.$googleapi;
	 
//	echo $url ;
	
    $json =  url_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    
    //if request status is successful
    if($status == "OK"){
        //get address from json data
        $location = $data->results[0]->formatted_address;
    }else{
        $location =  '';
    }
 
 
 
$statement = "select * from `track_patron` where `account_number` = '$username'";
 
   $truck_plate_number = $myName->showName($conn, "SELECT `truck_plate_number` FROM  `truck` WHERE (`account_number` = '$username')"); 	
	 
$result = mysqli_query($conn, $statement) or die("ERROR OCCURED: ".mysqli_error($conn));
 
	$count = mysqli_num_rows($result);
if($count > 0)
{
   $sql = 	mysqli_query($conn,"UPDATE `track_patron` SET   `location` = '$location', `lati` = '$latitude', `longi` = '$longitude',   `created_date` = '$datetime' WHERE  `account_number` = '$username'") or die("ERROR OCCURED: ".mysqli_error($conn));
    
    
    
}
    else
    {
         $sql = 	mysqli_query($conn,"INSERT INTO `track_patron`(`account_number`,  `location`, `lati`, `longi`,  `created_date` ) VALUES('$username', '$location','$latitude','$longitude',  '$datetime')") or die("ERROR OCCURED: ".mysqli_error($conn));
        
       
        
    }
    
    
    if($sql)
    {
        
          echo json_encode(array("statusCode"=>200, "errorMessage"=>"Information Submitted Successfully")); 
    }
    else
    {
         echo json_encode(array("statusCode"=>200, "errorMessage"=>"Information Not Submitted Successfully")); 
    }
    
    
    
 
 
function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
} 

 
?>

 