<?php
 
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
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($long).'&key=AIzaSyBZHrS0RwVvcqxuS_9y5trTV9VOdpD-N_8';
	
	 

//$json = url_get_contents($url, false, stream_context_create($arrContextOptions));
	
$json = url_get_contents($url);
	
	//echo $json." migty";
	
    //$json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
	
  
     $location = $data->results[0]->formatted_address;
	
	
 
    //if request status is successful
    if($status == "OK"){
        //get address from json data
        $location = $data->results[0]->formatted_address;
    }else{
        $location =  'Unnamed Address';
    }
 
    return $location;
}
 



$address = getAddress("6.5744351", "3.3669615");

echo $address;


?>