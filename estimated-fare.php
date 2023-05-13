	 <?php
	header('Access-Control-Allow-Origin: *');
include ("config/DB_config.php"); 
/* ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1); */

include("class_file.php");
$road_maintenance_charge = 0;
 
 include("SendingSMS.php");
  $myName = new Name();



$coordinates1 = true;
$coordinates2= true;
$value_value = "";
$json =  json_decode(file_get_contents('php://input'), true);

 

 


$start_long = $json['loading_long']; 
 $start_lat = $json['loading_lat']; 
  $stop_long = $json['destination_long']; 
  $stop_lat = $json['destination_lat']; 
$user = $json['wynkid'];
$username = $json['wynkid'];
     $emailing = $json['wynkid']; 
 
    
    
    
 /*
$start_long = "5.3285505"; 
 $start_lat = "7.7979306"; 
  $stop_long = "5.51449300000001"; 
  $stop_lat = "7.798266099999998"; 
$user = "WYNK87627590";
$username = "WYNK87627590";
    $emailing = "WYNK87627590"; 
 */

 
 
     
     
     //WYNK74832498, 5.1408182, 7.0982049, 5.1666678, 7.1904
     
    
     $payment_status = 0;
     
     $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
     //, `remita_username`, `remita_password`, `, `remita_url` 
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
       


  //$accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM //`wallet_info` WHERE `registeredby` = '$user'");	
  
  $accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$emailing'   AND `primary_wallet` = 1 AND `accountNumber` != ''");	 


$wallet_number = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$emailing'   AND `primary_wallet` = 1 AND `accountNumber` != ''");	  
  
  
  
  
      // $token = $myName->showName($conn, "SELECT `token` FROM `remita_setup` WHERE 1");		    

   $remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");	  
     
     
 if(!empty($emailing))
 { 
     
       $radius = $myName->showName($conn, "SELECT  `radius` FROM `radius` WHERE `status` = 1");
     
  $today=date("Y-m-d");
 
     
   
$codec =  "WYNK-RIDE-".date("Ymd").rand(34,2536);
 
     
     $id2="";
     
 //$startcity =returnCity($start_lat, $start_long);
 $start =getAddress($start_lat, $start_long);
 $stop = getAddress($stop_lat, $stop_long);
 
    $loading_state1 = $startcity['state'];
    $loading_county1 = $startcity['country'];  
     $loading_region = $startcity['region'];  
 
  $coordinates1 =  $start;
 $coordinates2 =  $stop;
     
 $trip_status_charge = 0;
 
    $km =  trim(substr($dist['distance'],0,-2)); 
	 
	 
     
 if(empty($start_lat) or empty($stop_lat))
{
  
  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Bad Coordinate. Please re-enter the coordinates."));  
	
}
else
{    
     
 
 $dist = GetDrivingDistance($start_lat, $stop_lat, $start_long, $stop_long);
	//echo '<span  class="btn btn-danger btn-block"> Bad address. Please re-enter the address </span>';
    $kilo_value = $dist['distance'];
 $min_value = $dist['time'];
 $distance = trim(substr($dist['distance'],0,-2));
 $distance_real = trim(substr($dist['distance'],0,-2));
 
 
 $minutes_cal = trim(substr($dist['value']/60,0,-2));
 
 
 
    
      $code =   "WYNK-RIDE-".date("Gis").rand(87, 373);  
 
//$user = "Annonymous";
    
    $lat1 = $start_lat;
	$long1 = $start_long;
	
	$lat2 = $stop_lat;
	$long2 = $stop_long;
    
   $base_fare = $myName->showName($conn, "SELECT  `amount` FROM  `base_fare` WHERE  ( `status` = 1)");
		    $price_per_km = $myName->showName($conn, "SELECT  `amount` FROM  `price_per_km` WHERE  ( `status` = 1)");
         $truck_capacity_charge = $myName->showName($conn, "SELECT  `amount` FROM  `truck_capacity_charge` WHERE  (`status` = 1)");
		 
	
	  $distance_o = round($distance_real, 2);
	
	
	
                 $dist2 = GetDrivingDistance($lat1, $lati,$long1,$longi);
	//echo '<span  class="btn btn-danger btn-block"> Bad address. Please re-enter the address </span>';
    $kilo_value2 = $dist['distance'];
 $min_value2 = $dist['time'];
 $distance2 = trim(substr($dist['distance'],0,-2));
 $distance_real2 = trim(substr($dist['distance'],0,-2));
 
 
 $minutes_cal2= trim(substr($dist['value']/60,0,-2));
        
    	 $distance_o = round($distance_real, 2);
         
         
         
          
          $cityRetuning1 = returnCity($lat1, $long1);
          $cityRetuning2 =  returnCity($lat2, $long2);
	
    $loading_state1 = $cityRetuning1['state'];
    $loading_county1 = $cityRetuning1['country'];  
     $loading_region = $cityRetuning1['region'];     
         
         
    $loading_state2 = $cityRetuning2['state'];
    $loading_county2 = $cityRetuning2['country'];
    $detination_region2 = $cityRetuning2['region'];
      //  $extract_user = mysqli_query($conn, "SELECT * FROM `road_maintenance_charge` WHERE  `state` = '$state' AND `country` = '$country'") or die(mysqli_error($conn));
         
         if( $loading_region ==  $detination_region2 and $loading_county2 == $loading_county1)
         {
             
 $road_maintenance_charge = $myName->showName($conn, "SELECT `amount` FROM  `road_maintenance_charge` WHERE  `state` LIKE '%".$detination_region2."%' AND `country` = '$loading_county2'");
			 
	 
             
         }
         else{
             
           $road_maintenance_charge1 = $myName->showName($conn, "SELECT `amount` FROM  `road_maintenance_charge` WHERE  `state` LIKE '%".$detination_region."%' AND `country` = '$loading_county1'");  
             
                   $road_maintenance_charge2 = $myName->showName($conn, "SELECT `amount` FROM  `road_maintenance_charge` WHERE  `state` LIKE '%".$detination_region2."%' AND `country` = '$loading_county2'");  
             
             $road_maintenance_charge = $road_maintenance_charge1 + $road_maintenance_charge2;
			 
         }
         
         
           $total_price_per_km = floatval($price_per_km) * floatval($distance2) ;
         
         $estimated = $total_price_per_km + ($truck_capacity_charge*$minutes_cal2) + $base_fare + $road_maintenance_charge;
         $estimated = $total_price_per_km + ($truck_capacity_charge*$minutes_cal2) + $base_fare + $road_maintenance_charge;
	
	
     echo json_encode(array("statusCode"=>200,   "estimated"=>number_format($estimated), "min"=>$min_value2, "distance"=> floatval($distance2), "calculated_distance"=>$minutes_cal2, "calculated_distance"=>$total_price_per_km, "calculated_distance"=>$dist, "road_maintenance_charge"=>$road_maintenance_charge, "truck_capacity_charge"=>$truck_capacity_charge, "total_price_per_km"=>$total_price_per_km, "base_fare"=>$base_fare, "price_per_km"=>$price_per_km)); 
     
	
 

 
}
 
 }
else
{
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Invalid Input Paramater. Please check and try again."));  
    
    
}






	/*
		   
function get_coordinates($address)
{
    $address = urlencode($address);
    $url = "https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Poland&key=AIzaSyCckE5OPITrw2kfYM6PWO6uuovAlqQqvTE";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response);
    $status = $response_a->status;

    if ( $status == 'ZERO_RESULTS' )
    {
        return FALSE;
    }
    else
    {
 $return = array('lat' => $response_a->results[0]->geometry->location->lat, 'long' => $long = $response_a->results[0]->geometry->location->lng);
        return $return;
    }
}*/

 
function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=en-EN&departure_time=now&key=AIzaSyAqg-tRYd1cgnpjiOJ12e3AzuTxA80PaJk";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
	  $dist_value = $response_a['rows'][0]['elements'][0]['distance']['value'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
	$value = $response_a['rows'][0]['elements'][0]['duration']['value'];

    return array('distance' => $dist,'distanceval' => $dist_value, 'time' => $time, 'value' => $value);
} 


function returnCity($lat, $long)
{
     $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&key=AIzaSyCckE5OPITrw2kfYM6PWO6uuovAlqQqvTE";	
    $json = url_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    if($status=="OK") {
     
    
                  
        for ($j=0;$j<count($data->results[0]->address_components);$j++) {
            $cn=array($data->results[0]->address_components[$j]->types[0]);
            if(in_array("locality", $cn)) {
                $city= $data->results[0]->address_components[$j]->long_name;
            }
        } 
        
        for ($j=0;$j<count($data->results[0]->address_components);$j++) {
            $cn=array($data->results[0]->address_components[$j]->types[0]);
            if(in_array("country", $cn)) {
                $country= $data->results[0]->address_components[$j]->short_name;
            }
        }
             for ($j=0;$j<count($data->results[0]->address_components);$j++) {
            $cn=array($data->results[0]->address_components[$j]->types[0]);
            if(in_array("administrative_area_level_1", $cn)) {
                $region= $data->results[0]->address_components[$j]->long_name;
            }
        }
            
       
     } else{
      // echo 'Location Not Found';
     }
     //Print city 
    // return $city; 
     return array('state' => $city,'country' => $country,'region' =>  $region);
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

function getAddress($lat, $long)
{
    //send request and receive json data by latitude and longitude
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($long).'&key=AIzaSyCckE5OPITrw2kfYM6PWO6uuovAlqQqvTE';
	
	 

//$json = url_get_contents($url, false, stream_context_create($arrContextOptions));
	
$json =url_get_contents ($url);
	
	//echo $json." migty";
	
    //$json = url_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
	
  
     
    //if request status is successful
    if($status == "OK"){
        //get address from json data
        $location = $data->results[0]->formatted_address;
    }else{
        $location =  'Unnamed Address';
    }
 
    return $location;
}
 



 
function getCaptainDetail($remita_url, $remita_username,$remita_password,$accountNumber,$remita_scheme)
{
	
	  // $token = $myName->showName($conn, "SELECT `token` FROM `remita_setup` WHERE 1");		    

  // $remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");	
$url = $remita_url."/authenticate";

        
       
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = <<<DATA
{
  "password": "$remita_password",
  "rememberMe": true,
  "username": "$remita_username",
  "scheme": "$remita_scheme",
  "deviceId": "64784844-hhhd748849-g7378382"

}
DATA;
        
     
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
 
 //echo  $resp;
$err = curl_error($curl);
curl_close($curl);
if($err){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$err."."));  
}
    else
    {
        
        
        $resp = json_decode($resp, true);
        
       // echo $resp;
        $message = $resp['message'];
     
        if($message == "Login success")
        { 
			$token = $resp['token'];
             $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
  
	
		 
curl_close($ch);

			
			
			
        
    }
		
		
		
		
		
		
			
	//echo $accountNumber."<p>";	 

		$url = $remita_url."/get-account-details/".$accountNumber; 
		 
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Authorization: Bearer '.$token;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);


//echo $result;

if (curl_errno($ch)) {
  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".curl_error($ch)."."));  
}else{
	
$resp1 = json_decode($result, true);	
	
	 //var_dump($resp1);
        $status = false;
    //  echo $resp1['code'].".... Coded";
        if(isset($resp1['code']) == "success")
        {
     
/*    $status = $resp1['data']['status'];     
        $id = $resp1['data']['id'];
 $accountNumber = $resp1['data']['accountNumber'];
 $currentBalance = $resp1['data']['currentBalance'];
 $dateOpened = $resp1['data']['dateOpened'];
 $schemeId = $resp1['data']['schemeId'];
 $schemeName = $resp1['data']['schemeName'];
 $walletAccountTypeId = $resp1['data']['walletAccountTypeId'];
 $accountOwnerId = $resp1['data']['accountOwnerId'];
 $accountOwnerName = $resp1['data']['accountOwnerName'];
 $accountOwnerPhoneNumber = $resp1['data']['accountOwnerPhoneNumber'];
 $accountName = $resp1['data']['accountName'];*/
 $actualBalance = $resp1['data']['actualBalance'];
/* $trackingRef = $resp1['data']['trackingRef'];
 $walletLimit = $resp1['data']['walletLimit'];
 $nubanAccountNo = $resp1['data']['nubanAccountNo'];
 $accountFullName = $resp1['data']['accountFullName'];
 $totalCustomerBalances = $resp1['data']['totalCustomerBalances']; 
			*/
			
			
			//echo  $accountOwnerName." / ".$currentBalance." / ".$accountName."<p>";
  
 
			
			
			return($actualBalance);
			
		}
	
	
}
		 
		 
		
		
		
		
    }
	
}

	   
?>
 

