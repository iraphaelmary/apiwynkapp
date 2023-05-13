<?php 
header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();


$json =  json_decode(file_get_contents('php://input'), true);

  $clientReference = $wynkid.date('dmY').rand(234,62662);

 
$service = $json['short_name']; //ibedc
$paymentMethod = "cash"; //prepaid
$wallet_number = $json['wallet_number']; 
$wynkid = $json['wynkid']; 
$clientReference = $json['clientReference']; 
$productCode = $json['productCode']; //ibedc
$wynkid = $json['wynkid']; 
$amount = $json['amount']; 


 
$service = 'ibedc'; //ibedc
$paymentMethod = "cash"; //prepaid
$wallet_number = "1200212830"; 
$wynkid = "WYNK74654117"; 
  
$productCode = "51107158BDD25E26909DCDDBC9F14C171D25ECEB|eyJtZXRlck5vIjoiNTQxMzAwNjU2NDkiLCJhY2NvdW50VHlwZSI6InByZXBhaWQiLCJzZWFyY2hDb2RlIjoiTVkwMDMiLCJzZXJ2aWNlIjoiaWJlZGMiLCJhbW91bnQiOjEwMCwiY2hhbm5lbCI6IkIyQiIsImF1dGgiOnsiaXNzIjoiaXRleHZhcyIsInN1YiI6IjU5OTE0NTE5Iiwid2FsbGV0IjoiNTk5MTQ1MTkiLCJ0ZXJtaW5hbCI6IjU5OTE0NTE5IiwidXNlcm5hbWUiOiJ3YWxsZXRAc3lzdGVtc3BlY3MuY29tLm5nIiwiaWRlbnRpZmllciI6InN5c3RlbXNwZWNzIiwia2V5IjoibWtra3VydHlibnZibWprbW1pa291cnRzcG9ydCIsInZlbmRUeXBlIjoiQjJCIiwibW9kZSI6ImxpdmUiLCJlbWFpbCI6IndhbGxldEBzeXN0ZW1zcGVjcy5jb20ubmciLCJmdWxsTmFtZSI6IlJlbWl0YSBXYWxsZW5jeSBMaW1pdGVkIiwicGFyZW50SWQiOiIxNzc5Iiwib3JnYW5pc2F0aW9uQ29kZSI6IjAwMTAxMjEyMTk5IiwiaWF0IjoxNjY5MTE5MTU1LCJleHAiOjE2NjkxMjYzNTV9LCJlbnZpcm9ubWVudCI6ImxpdmUiLCJzdGFydFRpbWUiOjE2NjkxMTkxNTYuNjk2MzMzLCJhY2NvdW50IjoiNTQxMzAwNjU2NDkiLCJhZGRyZXNzIjoiTk8gNSBUSEUgQkFEQVJBIFFBUlkgQUtVUlUgSUJBREFOIE9ZTyIsIm5hbWUiOiJPTEFUVU5ERSBNUiBPWUVOVUdBIE9MQVRVTkRFIE1SIE9ZRU5VR0EgIiwib3V0c3RhbmRpbmdBbW91bnQiOjAsIm1pbmltdW1BbW91bnQiOjAsInBheW1lbnRUeXBlIjoiMSIsInBob25lIjoiIiwiZW1haWwiOiIiLCJyZWNlaXZlciI6IjIzNDgwMDAwMDAwMDEzIiwidGFycmlmQ29kZSI6Ik5NRCAgU2VydmljZSBCYW5kOiBCMTZIIiwidGhpcmRQYXJ0eUNvZGUiOiJNT0xFX05NRF9FTEVCVSAxMUtWIEZFRURFUl9USVJFQURBUkFfQjE2SCIsIm1lc3NhZ2UiOiJDdXN0b21lciBWYWxpZGF0aW9uIFN1Y2Nlc3NmdWwiLCJkZXNjcmlwdGlvbiI6IjAiLCJ0eXBlIjoicHJlcGFpZCIsInJlc3BvbnNlQ29kZSI6IjAwIn0%3D"; //ibedc
 
$amount = 100; 

/*"customerPhoneNumber": "08068149983",
  "paymentMethod": "cash",
  "service": "kedco",
  "clientReference": "asd4978716271752715157570",
  "productCode": "51107158BDD25E26909DCDDBC9F14C171D25ECEB|eyJtZXRlck5vIjoiNTQxMzAwNjU2NDkiLCJhY2NvdW50VHlwZSI6InByZXBhaWQiLCJzZWFyY2hDb2RlIjoiTVkwMDMiLCJzZXJ2aWNlIjoiaWJlZGMiLCJhbW91bnQiOjEwMCwiY2hhbm5lbCI6IkIyQiIsImF1dGgiOnsiaXNzIjoiaXRleHZhcyIsInN1YiI6IjU5OTE0NTE5Iiwid2FsbGV0IjoiNTk5MTQ1MTkiLCJ0ZXJtaW5hbCI6IjU5OTE0NTE5IiwidXNlcm5hbWUiOiJ3YWxsZXRAc3lzdGVtc3BlY3MuY29tLm5nIiwiaWRlbnRpZmllciI6InN5c3RlbXNwZWNzIiwia2V5IjoibWtra3VydHlibnZibWprbW1pa291cnRzcG9ydCIsInZlbmRUeXBlIjoiQjJCIiwibW9kZSI6ImxpdmUiLCJlbWFpbCI6IndhbGxldEBzeXN0ZW1zcGVjcy5jb20ubmciLCJmdWxsTmFtZSI6IlJlbWl0YSBXYWxsZW5jeSBMaW1pdGVkIiwicGFyZW50SWQiOiIxNzc5Iiwib3JnYW5pc2F0aW9uQ29kZSI6IjAwMTAxMjEyMTk5IiwiaWF0IjoxNjY5MTE5MTU1LCJleHAiOjE2NjkxMjYzNTV9LCJlbnZpcm9ubWVudCI6ImxpdmUiLCJzdGFydFRpbWUiOjE2NjkxMTkxNTYuNjk2MzMzLCJhY2NvdW50IjoiNTQxMzAwNjU2NDkiLCJhZGRyZXNzIjoiTk8gNSBUSEUgQkFEQVJBIFFBUlkgQUtVUlUgSUJBREFOIE9ZTyIsIm5hbWUiOiJPTEFUVU5ERSBNUiBPWUVOVUdBIE9MQVRVTkRFIE1SIE9ZRU5VR0EgIiwib3V0c3RhbmRpbmdBbW91bnQiOjAsIm1pbmltdW1BbW91bnQiOjAsInBheW1lbnRUeXBlIjoiMSIsInBob25lIjoiIiwiZW1haWwiOiIiLCJyZWNlaXZlciI6IjIzNDgwMDAwMDAwMDEzIiwidGFycmlmQ29kZSI6Ik5NRCAgU2VydmljZSBCYW5kOiBCMTZIIiwidGhpcmRQYXJ0eUNvZGUiOiJNT0xFX05NRF9FTEVCVSAxMUtWIEZFRURFUl9USVJFQURBUkFfQjE2SCIsIm1lc3NhZ2UiOiJDdXN0b21lciBWYWxpZGF0aW9uIFN1Y2Nlc3NmdWwiLCJkZXNjcmlwdGlvbiI6IjAiLCJ0eXBlIjoicHJlcGFpZCIsInJlc3BvbnNlQ29kZSI6IjAwIn0%3D",*/





if(!empty($wallet_number))
{
	
	 
        
       $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
       $fee = $myName->showName($conn, "SELECT `fee` FROM `application` WHERE 1");	
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
       $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
       $wynk_name = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
       $phone = $myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
       

  $remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$wynkid' AND `phone` != ''  LIMIT 1 ");
	$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$wynkid' AND `password` != ''  LIMIT 1");


     $Tamount = $amount + $fee;

   $remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");	

	$narration = "Electricy for purchase for ".$wynk_name." (".$wynkid.")";
	
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
 
  
						  
						  $narration = $wynk_name." ".$service;
						 
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();
$url = $remita_url."/itex/purchase/electricity";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
 
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"customerPhoneNumber\": \"".$phone."\",\n  \"paymentMethod\": \"cash\",\n  \"service\": \"".$service."\",\n  \"clientReference\": \"".$clientReference."\",\n  \"productCode\": \"".$productCode."\",\n  \"card\": {},\n  \"amount\": ".$Tamount.",\n  \"sourceAccountNumber\": \"".$wallet_number."\",\n  \"transactionPin\": \"".$pin."\",\n  \"narration\": \"".$narration."\",\n  \"redeemBonus\": false,\n  \"bonusAmount\": 0\n}");

		 
		 
//curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"customerPhoneNumber\": \"".$phone."\",\n  \"paymentMethod\": \"cash\",\n  \"service\": \"".$service."\",\n  \"clientReference\": \"".$clientReference."\",\n  \"productCode\": \"".$productCode."\",\n  \"card\": {}\n}");

						  
/*						  
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"meterNo\": \"".$meterNo."\",\n  \"accountType\": \"".$accountType."\",\n  \"service\": \"".$service."\",\n  \"amount\": \"".$amount."\",\n  \"channel\": \"MOBILE\"\n}");
						  */
						  

$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Authorization: Bearer '.$token;
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
					  
   echo $result;				  
				
if (curl_errno($ch)) {
   // echo 'Error:' . curl_error($ch);
	
	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured:".curl_error($ch)."."));  
	
}
						  else
						  {
							  
			 $resp = json_decode($result, true);
							  
						$code = $resp['code'];	  
							  
						$message = $resp['message'];	  
	 				    $json2 = '[';
							  
							  if($code == "00")
							  {
								/*{
  "code": "00",
  "message": "Electricity Purchase Successful",
  "data": {
    "error": false,
    "message": "Customer Payment Successful",
    "token": "3538  1451  7195  0265  1802  ",
    "address": "HAUSAWA LAYOUT 13 LINK, KANO ",
    "amount": 1,
    "tariff": "29.61",
    "type": "prepaid",
    "vat": "100",
    "responseCode": "00",
    "reference": "ITEX-KEDCO5F3175F2DFEB501E2XDR199605",
    "sequence": "6058953389370",
    "clientReference": "asd4978716271752715157570"
  },
  "metadata": null
}
Res*/ 							$message2 = $resp['data']['message'];	
								$token =  $resp['data']['token'];	
     							$address =  $resp['data']['address'];	
     							$amount =  $resp['data']['amount'];	
     							$tariff =  $resp['data']['tariff'];	
     							$type =  $resp['data']['type'];	
     							$vat =  $resp['data']['vat'];	
     							$reference =  $resp['data']['reference'];	
     							$sequence =  $resp['data']['sequence'];	
     							$clientReference =  $resp['data']['clientReference'];	
     						 
								 
									   $message_all = $message . " ".$message2;		   
										   
   
		 $sql = mysqli_query($conn,"INSERT INTO `transaction_information`(`code`,   `truck_owner`,  `amount`, `commissiononfee`,  `registeredby`, `created_date`, `message`, `status`, `customer` ,  `owners_share`, `means`, `narration`, `products`, `channel`,  `id_number`, `wallet_number` , `refs`) VALUES('$clientReference','$wynkid','$Tamount','$fee','$wynkid', '$datetime','$message_all','1', '$meter_number', '0','wallet','$token','power','$service','$meter_number','$wallet_number','$bouquetName') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 										   
	 					   
										   
$json2 .= '{
    "message": "'.$message.'",
    "token": "'.$token.'",
	"address": "'.$address.'",
    "amount": "'.$amount.'",
    "tariff": "'.$tariff.'",
    "type": "'.$type.'",
    "vat": "'.$vat.'",
    "reference": "'.$reference.'",
    "sequence": "'.$sequence.'",
    "clientReference": "'.$clientReference.'"
},'; 
										   
										   
   }
								  
								  
								  
						  
					$json2 .= "]";
	
	//echo $json2;
 	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
 echo trim($json1);
  			 						  
								  
								  
								  
 
		//echo json_encode(array("statusCode"=>200, "amounting"=>$amounting, "refference"=>$ref, "transaction_id"=>$transactionID, "reference"=>$reference, "client_reference"=>$clientReference));  							  
								  
	//echo $result;  							  
						 
							  
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

