 <?php
 
header('Access-Control-Allow-Origin: *');
 include ("config/DB_config.php"); 

include("class_file.php");
 $myName = new Name();





$json =  json_decode(file_get_contents('php://input'), true);
 
 

$account_number = $json['account_number'];
$account_type  = $json['account_type'];
$bank_code  = $json['bank_code'];
		/*{
  "accountNumber": "3077619186",
  "accountType": "bank",
  "bankCode": "011"
}*/	
		

/* 
$account_number = "6052107547";
$account_type  = "bank";
$bank_code  = "070";
*/

if(!empty($account_number) || !empty($account_type) || !empty($bank_code) )
{










	$remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
      $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
   
		  // $remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$wynkid' AND `phone` != ''  LIMIT 1 ");
	//$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$wynkid' AND `password` != ''  LIMIT 1");
	
	
	
	
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
        
  //echo $data;  
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
 
 // echo  $resp;
$err = curl_error($curl);
curl_close($curl);
if($err){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occurred: ".$err."."));  
}
    else
    {
       
        
    $resp = json_decode($resp, true);
        
     ///echo $resp;
     $message = $resp['message'];
     
        if($message == "Login success")
        { 
            
            $token = $resp['token'];
             $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
 // echo $token;  
         
         //echo  $pin;
             
$pattern = '/^0/';
$replacement = '+234';
//$newphone =  preg_replace($pattern, $replacement, $phone);

            //2020-11-17
     // $dateOfBirth =   date("Y-m-d", strtotime($rbirthdate));    
 //$url = "https://walletdemo.remita.net/api/wallet-external";
$url = $remita_url."/verify-account";
         
      //echo $url;
			
	
			
			$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"accountNumber\": \"".$account_number."\",\n  \"accountType\": \"".$account_type."\",\n  \"bankCode\": \"".$bank_code."\"\n}");

$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Authorization: Bearer '.$token;
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
			
	//echo $result;
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
			else{
				
				 $resp = json_decode($result, true);
				
				$accountNumber =  $resp['accountNumber'];
				$accountName =  $resp['accountName'];
				
				
					 echo json_encode(array("statusCode"=>200, "accountNumber"=> $accountNumber,"accountName"=> $accountName)); 
	
				
				
			}
curl_close($ch);
			
			
			
	 














		}
		}

}
else
{
	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occurred: Important field is empty."));  
	
}


?>