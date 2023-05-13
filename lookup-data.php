<?php 
header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();


$json =  json_decode(file_get_contents('php://input'), true);

 
$channel = $json['channel']; 
//$channel = "MTN"; 
 
//$clientReference = date('dmY').rand(234,62662);
if(!empty($channel))
{
	
	 
        
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
  "scheme": "$remita_scheme" 

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

 //echo $result;

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
		
			   
			
			 
			 if($category == "Data")
			 {
				//echo $category." ---------- " ; 
				  for($e=0;$e<sizeof($resp1['data'][$i]['billers']);$e++)
			  {
				  
				  $name = $resp1['data'][$i]['billers'][$e]['name'];  
				 
				  
				 //echo $name." - ".$channel."<p>" ;
					
					  if( strtolower($name) ==  strtolower($channel))
					  { 
					 $service = $resp1['data'][$i]['billers'][$e]['service'];  
				  $accountType = $resp1['data'][$i]['billers'][$e]['accountType']; 
						  
						  $service = str_replace("vtu","data",$service) ;
			 // echo  $service." ".$accountType."<p>";
						  
						//  $naration = $wynk_name." ".$service;
						 
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();
$url = $remita_url."/itex/lookup/data";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"service\": \"".$service."\",\n  \"channel\": \"MOBILE\"}");

$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Authorization: Bearer '.$token;
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
					  
					  
//echo $result;			
if (curl_errno($ch)) {
   // echo 'Error:' . curl_error($ch);
	
	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".curl_error($ch)."."));  
	
}
						  else
						  {
							  
			 $resp = json_decode($result, true);
							  
						$code = $resp['code'];	  
						$productCode = $resp['data']['productCode'];	  
							  
						$message = $resp['message'];	  
							//  echo $result;	
							  
							  if($code == "00")
							  {
								  
								  //echo sizeof($resp['data']['data']);
								    $json2 = '[';
								     
									   foreach ($resp['data']['data']as $data ) {
      $type = $data['type'];
      
								   $code = $data['code'];	
								  $duration = $data['duration'];	
								  $amount = $data['amount'];	
								  $value = $data['value'];	
								  $description = $data['description'];	
								  //$productCode = $data['productCode'];		
										   
										   
										   
$json2 .= '{
    "service_name": "'.$service.'",
    "type": "'.$type.'",
    "code": "'.$code.'",
    "duration": "'.$duration.'",
    "amount": "'.$amount.'",
    "value": "'.$value.'",
    "description": "'.$description.'",
    "productCode": "'.$productCode.'"
},'; 
										   
										   
   }/*
								   for($e=0;$e<sizeof($resp['data']['data']);$e++)
								   	{
									
							   /*   
								  $type = $resp['data']['data']['type'];	
								   $code = $resp['data']['data']['code'];	
								  $duration = $resp['data']['data']['duration'];	
								  $amount = $resp['data']['data']['amount'];	
								  $value = $resp['data']['data']['value'];	
								  $description = $resp['data']['data']['description'];	
								  $productCode = $resp['data']['data']['productCode'];	
									     
									   */
/*									   	 
			
$json2 .= '{
    "service_name": "'.$service.'",
    "type": "'.$type.'",
    "code": "'.$code.'",
    "duration": "'.$duration.'",
    "amount": "'.$amount.'",
    "value": "'.$value.'",
    "description": "'.$description.'",
    "productCode": "'.$productCode.'"
},'; 
 
									 
								   }*/
								  
								  
								  
					$json2 .= "]";
	
	//echo $json2;
 	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
 echo trim($json1);
  			 
								  
								
								

								  
	//echo json_encode(array("statusCode"=>200, "message"=>$message_all));  							  
								  
							  }
							  else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>$message));  			  
							  }
							  
				/*			  
							  
{
  "code": "00",
  "message": "Successful",
  "data": {
    "status": 1,
    "data": {
      "type": "MTNDATA",
      "code": "104",
      "duration": "1 Day",
      "amount": "100",
      "value": "100MB",
      "description": "100MB 1 Day",
      "date": "2020-08-10 19:17:13",
      "responseCode\"": "00",
      "productCode": "3B07802EC656005DCCF4CA63333DE85E145005BB|eyJzZXJ2aWNlIjon0%3D"
    }
  },
  "metadata": null
}
							  */
							  
							  
						  }
curl_close($ch);
					  
					  
					   
					 }
					   /* else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>"-Data not selected. Please try again later.-"));  			  
							  }*/
					  
 
					  
					  
					  
					  
			  }
				
			 }
			    /*else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>"Date not selected. Please check and try again later."));  			  
							  }
			 */
			 
			 
		 //echo $category."<p>"; 	
			 
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















}
  else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>"Important Field Left Empty."));  			  
							  }

?>

