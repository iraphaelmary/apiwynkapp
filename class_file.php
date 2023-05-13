<?php
 header('Access-Control-Allow-Origin: *');
 include ("view-application-details.php"); 
class Name
{
   
    public function showName($conn, $string)
    {
        /**
        Put your database code here to extract from database.
        **/
		$name  = "";
		$evnt_details = mysqli_query($conn, $string) or die(mysqli_error($conn));
		$count = mysqli_num_rows($evnt_details);
 $evnt_retrieval = mysqli_fetch_array($evnt_details);
		
		if(isset($evnt_retrieval[0]))
		{
			
					
$name = $evnt_retrieval[0];
		
		}
		

		
        return($name );
    }
	 public function enterName($TName)
    {
        $this->name = $TName;
        /**
        Put your database code here.
        **/
    }
	
	
	 
	
     
}
function thousandsCurrencyFormat($num) {

    if( $num > 10000 ) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        
        return $x_display;
    }

    return $num;
}

function get_coordinates($address)
{
    $address = urlencode($address);
    $url = "https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Poland&key=AIzaSyCaSn2IGtrwVyG05swNh2HLFch3YI3_QvM";
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
}	


 function dataVerification($number,$url,$api_key){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
                 http_build_query(array('number' => $number)));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-API-Key: $api_key",
            "app-id: 90eb1a16-d691-4597-a50f-c81fd99c08bd",
            "Cache-Control: no-cache",
          ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        
        curl_close ($ch);
        return $server_output;
    }




 function dataVerification_nin($number_nin,$number, $url,$api_key){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
                 http_build_query(array('number' => $number, 'number_nin' => $number_nin)));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-API-Key: $api_key",
            "app-id: ".$api_key,
            "Cache-Control: no-cache",
          ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        
        curl_close ($ch);
        return $server_output;
    }
function dataVerification_sa($national_id,$dob,$firstname,$lastname, $url,$api_key){
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
                 http_build_query(array('nationalid' => $national_id, 'dob' => $dob, 'firstname' => $firstname, 'lastname' => $lastname)));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-API-Key: test_w1zgmt4dq756mdg70mjsog:HH5hLxqyz7jpuliZUC2TaFV8kcs",
            "app-id: 90eb1a16-d691-4597-a50f-c81fd99c08bd",
            "Cache-Control: no-cache",
          ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        
        curl_close ($ch);
        return $server_output;
    }

 
?>