<?php 
header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();


$json =  json_decode(file_get_contents('php://input'), true);

 
 /*
 $meterNo = $json['meterNo']; 
$service = $json['short_name']; //ibedc
$accountType = $json['accountType']; //prepaid

//$wallet_number = $json['wallet_number']; 
//$amount = $json['amount']; 

$amount = str_replace(",","",$json['amount']) ;
$wynkid = $json['wynkid']; */
 $channel = "MOBILE"; 

$wynkid = "WYNK87627590";

$meterNo =  "54130065649";
$service = "ibedc";
$accountType = "prepaid";
$amount = "100";
 
 $clientReference = $wynkid.date('dmY').rand(234,62662);
 



if(!empty($wynkid))
{
	
	 
        
       $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
       $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
       $wynk_name = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
       
     

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
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured:".$err."."));  
}
    else
    {
        
        
        $resp = json_decode($resp, true);
        
       // echo $resp;
        $message = $resp['message'];
     
        if($message == "Login success")
        { $token = $resp['token'];
             //$pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
 
  
						  
						  //$naration = $wynk_name." ".$service;
						 
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();
$url = $remita_url."/itex/validate/meter";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
 
						  

						  
						  
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"meterNo\": \"".$meterNo."\",\n  \"accountType\": \"".$accountType."\",\n  \"service\": \"".$service."\",\n  \"amount\": \"".$amount."\",\n  \"channel\": \"MOBILE\"\n}");
						  
						  

$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Authorization: Bearer '.$token;
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
					  
  //echo $result;				  
				
if (curl_errno($ch)) {
   // echo 'Error:' . curl_error($ch);
	
	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured:".curl_error($ch)."."));  
	
}
						  else
						  {
							  
			 $resp = json_decode($result, true);
							  
						$code = $resp['code'];	  
							  
						$message = $resp['message'];	  
	 				  
							  
							  if($code == "00")
							  {
								  
								  $message2 = $resp['data']['message'];	
								
								
							
								  
								  $message_all = $message . " ".$message2;	
								  
		/*						  
								   $json2 = '[';
								     
									   foreach ($resp['data']['data']as $data ) {
      							$message = $data['message'];
     							$customerId = $data['customerId'];	
								  $name = $data['name'];	
								  $meterNumber = $data['meterNumber'];	
								  $accountNumber = $data['accountNumber'];	
								  $businessUnit = $data['businessUnit'];	
								  $businessUnitId = $data['businessUnitId'];		
								  $undertaking = $data['undertaking'];		
								  $phone = $data['phone'];		
								  $address = $data['address'];		
								  $email = $data['email'];		
								  $lastTransactionDate = $data['lastTransactionDate'];		
								  $minimumPurchase = $data['minimumPurchase'];		
								  $customerArrears = $data['customerArrears'];		
								  $tariffCode = $data['tariffCode'];		
								  $tariff = $data['tariff'];		
								  $description = $data['description'];		
								  $customerType = $data['customerType'];		
								  $responseCode = $data['responseCode'];		
								  $productCode = $data['productCode'];		
										   
	 					   
										   
$json2 .= '{
    "message": "'.$message.'",
    "customerId": "'.$customerId.'",
	"tariff": "'.$tariff.'",
    "name": "'.$name.'",
    "meterNumber": "'.$meterNumber.'",
    "accountNumber": "'.$accountNumber.'",
    "businessUnit": "'.$businessUnit.'",
    "businessUnitId": "'.$businessUnitId.'",
    "phone": "'.$phone.'",
    "email": "'.$email.'",
    "address": "'.$address.'",
    "lastTransactionDate": "'.$lastTransactionDate.'",
    "minimumPurchase": "'.$minimumPurchase.'",
    "customerArrears": "'.$customerArrears.'",
    "description": "'.$description.'",
    "$customerType": "'.$customerType.'",
    "tariffCode": "'.$tariffCode.'",
    "productCode": "'.$productCode.'",
    "clientReference": "'.$clientReference.'",
    "undertaking": "'.$undertaking.'"
},'; 
										   
										   
   }
								  
				*/				  
								  
						echo $result  ;
		/*			$json2 .= "]";
	
	 
 	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
 echo trim($json1);
  			 			*/			  
								  
								  
								  
 
		//echo json_encode(array("statusCode"=>200, "amounting"=>$amounting, "refference"=>$ref, "transaction_id"=>$transactionID, "reference"=>$reference, "client_reference"=>$clientReference));  							  
								  
	//echo $result;  							  
								  
							  }
							  else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>$message));  			  
							  }
							  
				/*			  
							  
{ "code" : "00", "message" : "VTU Purchase Successful", "data" : { "error" : false, "message" : "Airtime Purchase Successful", "amount" : "100", "ref" : "ITEX-TAMSVTU5F318D8131B64FYJEUB1361261", "date" : "2020-08-10 19:10:09", "transactionID" : "207124435341669", "responseCode" : "00", "reference" : "ITEX-TAMSVTU5F318D8131B64FYJEUB1361261", "sequence" : "207124435341669", "clientReference" : "asd4978716271752715157570" }, "metadata" : null }
							  */
							  
							  
						  }
curl_close($ch);
					  
					  
					   
					  }
					  
					  
 
					  
					  
					  
					  
			  }
				
		 
			  
			 
			 
			 
		 //echo $category."<p>"; 	
			 
 }
			
			
			
			
			
 
	
	
	
	
	
	
	
 


 





 
 

?>

