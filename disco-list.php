<?php 
header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();


$json =  json_decode(file_get_contents('php://input'), true);

 
 //$channel = $json['channel']; 
$service = ""; 
$json1 = ""; 
 

 
	
	 
        
       $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
     //  $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
    //   $wynk_name = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
       
     

   $remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");	
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
        
        //echo $resp;
        $message = $resp['message'];
     
        if($message == "Login success")
        { $token = $resp['token'];
             //$pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
 
 
 
$url = $remita_url."/itex/billers";
  

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
 
 $ch1 = curl_init();

curl_setopt($ch1, CURLOPT_URL, $url);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Authorization: Bearer '.$token;
curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch1);

// echo $result;

if (curl_errno($ch1)) {
    //echo 'Error:' . curl_error($ch1);
	
	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".curl_error($ch1)."."));  
}
else
{
	 $resp1 = json_decode($result, true);

    //var_dump($resp1);
        $status = false;
      //echo $resp1['message']." Coded";
        if(isset($resp1['code']) == "00")
        {
    //  echo sizeof($resp1['data']);
			
			
    for($i=0;$i<sizeof($resp1['data']);$i++)
    {
		 $category = $resp1['data'][$i]['category'];  
		
			   
			//echo $category." ... <p>";
			 
			 if($category == "Electricity")
			 {
			 
				 
			 	$json2 = '[';	
				  for($e=0;$e<sizeof($resp1['data'][$i]['billers']);$e++)
			  {
				  
				  $name_disco = $resp1['data'][$i]['billers'][$e]['name'];  
				  $service = $resp1['data'][$i]['billers'][$e]['service'];  
				  $accountType = $resp1['data'][$i]['billers'][$e]['accountType']; 
				  
//echo =  "name:".$name."short_name": '.$service.';   
					  
					  
					  

					  
	// echo json_encode(array("statusCode"=>200, "name"=>$name_disco, "short_name"=>$service));  			  
 				  
					  
			$jsona = '[';		  								     
 foreach ($resp1['data'][$i]['billers'][$e]['accountType'] as $data ) {
      $name = $data['name'];
	 
 
      $jsona .= '{
    "pay_type": "'.$name.'"
    
},'; 
							 
	 
 }
					  
					  
					  $jsona .= "]";
					  
					  
							  										   
$json2 .= '{
    "name": "'.$name_disco.'",
    "short_name": "'.$service.'" 
	 
},';
					  
					  
					  /*	  
					  			  
			 
 	 
	 $json1 .= '{
    "name": "'.$name_disco.'",
    "short_name": "'.$service.'"
    '.$json2.'}';
	 */


		 
			
		
					 
					  
					  
			  }
				 			  
					$json2 .= "]";
	
	//echo $json2;
 	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
 echo trim($json1);
  			 
							 
				/*  $json22= '{
    statusCode: 200,
	'.$json1.'';
			*/
			 }
			     
			 
 }
			  

			
 
	
	
	
	
	
	
	
	
	
}
  /*else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>"Network Issues. Please try again later."));  			  
							  }
*/


}
     
            
            
             
        
    } else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>"Server Cannot Be Reached At This Moment. Please try again later."));  			  
							  }
    }














 

?>

