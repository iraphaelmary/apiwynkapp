<?php 
header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();


$json =  json_decode(file_get_contents('php://input'), true);


$account = $json['account']; 
 $code = $json['code']; 
$amount = $json['amount']; 
 
 // $amount = 10; 
 $productCode = $json['productCode']; 
 $wallet_number = $json['wallet_number']; 
$wynkid = $json['wynkid']; 





 
 /*   
 $account = "2190450936"; 
 $code = 624; 
 $amount = 30000; 
 $productCode = "3B07802EC656005DCCF4CA63333DE85E145005BB|eyJzZXJ2aWNlIjon0%3D"; 
 $wallet_number = "2190450936"; 
$wynkid = "WYNK80768556"; */
  

$clientReference = date('dmY').rand(234,62662);
if(!empty($wynkid))
{
	
	 
        
       $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");	
       $fee = $myName->showName($conn, "SELECT `fee` FROM `application` WHERE 1");	
	
	$Tamount = $amount + $fee;
	
	
	
	
	
       $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
     $wynk_name = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
     $phone = $myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
       
     $remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$wynkid' AND `phone` != ''  LIMIT 1 ");
$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$wynkid' AND `password` != ''  LIMIT 1");

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
 
 	 $narration = "Smile Purchase for ".$wynk_name."(".$wynkid.")";
 
$url = $remita_url."/itex/internet/subscribe";
  
	 //echo  "{\n  \"phone\": \"".$phone."\",\n  \"type\": \"subscription\",\n  \"code\": \"".$code."\",\n  \"amount\": \"".$Tamount."\",\n  \"paymentMethod\": \"cash\",\n  \"service\": \"smile\",\n  \"clientReference\": \"".$clientReference."\",\n  \"productCode\": \"".$productCode."\",\n  \"card\": ".$card.",\n  \"sourceAccountNumber\": \"".$wallet_number."\",\n  \"transactionPin\": \"".$pin."\",\n  \"narration\": \"".$narration."\"\n,\n  \"redeemBonus\": \"false\"\n,\n  \"bonusAmount\": \"0.0\"\n}";
		 
		  
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"phone\": \"$phone\",\n  \"type\": \"subscription\",\n  \"code\": \"$code\",\n  \"amount\": \"$Tamount\",\n  \"paymentMethod\": \"cash\",\n  \"service\": \"smile\",\n  \"clientReference\": \"$clientReference\",\n  \"productCode\": \"$productCode\",\n  \"card\": {},\n  \"sourceAccountNumber\": \"$wallet_number\",\n  \"transactionPin\": \"$pin\",\n  \"narration\": \"$narration\"\n}");

$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Authorization: Bearer '.$token;
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);



		 			
if (curl_errno($ch)) {
   // echo 'Error:' . curl_error($ch);
	
	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured:".curl_error($ch)."."));  
	
}
						  else
						  {
							  
			 $resp = json_decode($result, true);
							  
						$code = $resp['code'];	  
							  
					$message  = $resp['message'];	  
	 				  	  //  $json2 = '[';
							  
							  if($code == "00")
							  {
								  
								  // echo $result;
								  
								  
								  
				  $message_all = $message . " ".$message2;		   
										   
  $sql = 	mysqli_query($conn,"INSERT INTO `transaction_information`(`code`,   `truck_owner`,  `amount`, `commissiononfee`,  `registeredby`, `created_date`, `message`, `status`, `customer` ,  `owners_share`, `means`, `refs`, `products`, `narration` , `channel`,  `id_number`, `wallet_number` ) VALUES('$clientReference','$wynkid','$Tamount','$fee','$wynkid', '$datetime','$message_all','1', '$wynk_name', '0','wallet','$clientReference','smile','$narration','$narration','$account','$wallet_number') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 						  
								  
			echo json_encode(array("statusCode"=>200, "message"=>"Success: ".	$message));  					  
								  
								  
								 // $message2 = $resp['data']['message'];	
								  
										 //echo $result;  
								  
							/*	   foreach ($resp['data']['bouquets']as $data ) {
      							$code = $data['code'];
      							$name = $data['name'];
      							$amount = $data['amount'];
      							$primaryAmount = $data['primaryAmount'];
      
					// echo $amount."<p>"   ;
									   
									   
									   
									   									   
										   
$json2 .= '{
    "code": "'.$code.'",
    "name": "'.$name.'",
    "amount": "'.$amount.'",
    "primaryAmount": "'.$primaryAmount.'"
    
},'; 
									   
								   }*/
					/*			  
											  
					$json2 .= "]";
	
	//echo $json2;
 	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
 echo trim($json1);
  			 	  */
								  
								  
							  }
							  else
							  {
							 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured. Please try again later.".	$message));  			  	
								  
								  // echo $result;
							  }
						  }
								
		 
curl_close($ch);
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
 





}
		
		else{
			
		echo json_encode(array("statusCode"=>201, "errorMessage"=>"Authentication Not Valid. ".	$message));  			  	
		}
}
}
 
  else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>"Important Field Left Empty."));  			  
							  }

?>

