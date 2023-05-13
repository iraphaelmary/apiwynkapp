<?php 
header('Access-Control-Allow-Origin: *');
 
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');
require_once('SendingSMS.php');

$myName = new Name();
 


$json =  json_decode(file_get_contents('php://input'), true);

 

 


 //$username = $json['patron_wynkid'];
//$emailing  = $json['patron_wynkid'];
$emailing  = "WYNK74832498";

 $username = "WYNK74832498";

 



 //$ref = $json['ride_code']; 
 $ref = "WYNK-RIDE-120839235"; 
 
if(!empty($emailing))
{
 
  
    // $captain_id = $json['captain_id'];
    /* $captain_id = $json['captain_wynkid'];
     $code = $json['ride_code']; 
    $ref = $json['ride_code']; 
	 	$means = $json['payment_means']; 
       */
  $username = "WYNK74832498";
  $emailing  = "WYNK74832498";
   $captain_id = "WYNK77875279";
     $code = "WYNK-RIDE-120839235"; 
    $ref = "WYNK-RIDE-120839235"; 
	 	$means = "wallet"; 

        //Remita Information
  
	if($means == "wallet" or $means == "walletcash")
	{
	
	$pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$username'");
	$remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
      $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
       //echo "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$username'";

//Wallet Number of patron
  $accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$username' AND `primary_wallet` = 1");
  $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$username'");
    //Wallet Number if Captain
  $cap_accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$captain_id' AND `primary_wallet` = 1");	
		
		
		
  $amount_to_be_paid = $myName->showName($conn, "SELECT `amount` FROM `search_result` WHERE `code` = '$code'");	
		//SELECT `remita_wallet` FROM `application` WHERE 1
		
  $remita_wallet = $myName->showName($conn, "SELECT `remita_wallet` FROM `application` WHERE 1");	
		
		//SELECT `base_price`, `distance`, `time`  FROM `trip_record` WHERE 1


//SELECT  `road_maintenance`, `convinience_fee`  FROM `trip_record` WHERE 1
		
	/*	
		SELECT `base_price`, `distance`, `time`  FROM `trip_record` WHERE `code`


SELECT  `road_maintenance`, `convinience_fee`  FROM `trip_record` WHERE `code`
		*/
		
  $base_price = $myName->showName($conn, "SELECT `base_price` FROM `trip_record` WHERE `code` = '$code'");	
  $distance = $myName->showName($conn, "SELECT `distance` FROM `trip_record` WHERE `code` = '$code'");	
  $time = $myName->showName($conn, "SELECT `time` FROM `trip_record` WHERE `code` = '$code'");	
		
		
		$captain_share = $base_price + $distance + $time;
		
		
				
  $road_maintenance = $myName->showName($conn, "SELECT `road_maintenance` FROM `trip_record` WHERE `code` = '$code'");	
  $convinience_fee = $myName->showName($conn, "SELECT `convinience_fee` FROM `trip_record` WHERE `code` = '$code'");	
   
		$wynk_share =  $road_maintenance +  $convinience_fee;
    
    //echo $accountNumber;
    
      // $token = $myName->showName($conn, "SELECT `token` FROM `remita_setup` WHERE 1");		    

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
        
 //  echo $data;  
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
        $totalAmount = 100;
        
        $resp = json_decode($resp, true);
        
    // echo $resp;
        $message = $resp['message'];
     
        if($message == "Login success")
        { 
            
            $token = $resp['token'];
            // $pin = $resp['user']['pin'];
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
$url = $remita_url."/send-money";
         
       //  echo $url;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/json",
   "Accept: application/json",
   "Authorization: Bearer ".$token,
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = <<<DATA
 {
  "accountNumber": "$cap_accountNumber",
  "amount": $captain_share,
  "channel": "wallettowallet",
  "sourceBankCode": "",
  "sourceAccountNumber": "$accountNumber",
  "destBankCode": "",
  "pin": "$pin",
  "transRef": "$code",
  "isToBeSaved": false,
  "beneficiaryName": "$cap_accountNumber"
} 
DATA;
        
     
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

  

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
 
 echo $resp;       
     
 $err1 = curl_error($curl);
curl_close($curl);
if($err1){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured 1: ".$err1."."));  
}
    else
    {
        
         // echo $resp;  
      
 $resp1 = json_decode($resp, true);
$message = $resp1['code'];
    //var_dump($resp1);
        $status = false;
       // echo $resp1['code']." Coded";
        
        $vbvmessage = "";
        //echo $resp1['code'];
		
        if($resp1['code'] == "success")
        {
            	
			
		//wynk Payment starts here
	 
		$code_c = $code.rand(12,365);	
			
 $url = $remita_url."/send-money";
         
       //  echo $url;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/json",
   "Accept: application/json",
   "Authorization: Bearer ".$token,
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = <<<DATA
 {
  "accountNumber": "$remita_wallet",
  "amount": $wynk_share,
  "channel": "wallettowallet",
  "sourceBankCode": "",
  "sourceAccountNumber": "$accountNumber",
  "destBankCode": "",
  "pin": "$pin",
  "transRef": "$code_c",
  "isToBeSaved": false,
  "beneficiaryName": "WYNK"
} 
DATA;
        
 
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

  

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
 
 //echo $resp;       
     
 $err1 = curl_error($curl);
curl_close($curl);
if($err1){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured 2: ".$err1."."));  
}
    else
    {
        
 
     
 
            
            
             
        
    } 
			$paymentStatus = "Successful Payment";
			    // $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = "NGN";
			// $vbvmessage = $resp['data']['vbvmessage'];
			// $vbvmessage = $resp['data']['vbvmessage'];
			 $vbvmessage2 = "Successful";
			 $chargeAmount=$myName->showName($conn, "SELECT `amount` FROM `search_result` WHERE `code` = '$ref'"); 						
 $chargeResponsecode ="00";
            
            
            $allmessages = $paymentStatus." ".$vbvmessage2;
			 		
//$sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$allmessages',  `status` = 1,  `means` = '$means'  WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 
            
  $sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$allmessages',  `status` = 1,  `means` = '$means', `owners_share` = '$captain_share',`loadme_share` = '$wynk_share'    WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 
			          
			
		//, `loadme_share` 	
			
			
            
 //$sql = 	mysqli_query($conn,"UPDATE `search_result` SET  `status` = 1,  `means` = '$means'  WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
            
            
        
            
            
            
            
            
									
 $sql = "INSERT INTO `tracker`(`code`,  `status`,`created_date`) VALUES
('$code', '1','$datetime')";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 	
            
       $truck_owner = $myName->showName($conn, "SELECT `truck_owner` FROM `transaction_information` WHERE   `code` = '$ref'");      
            
            $truck_owner = $captain_id;
 
		if($truck_owner!= "")
		{
            
            
            
	$phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	$email_owner=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	$naming=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	
	$truck_id=$myName->showName($conn, "SELECT `truck_id` FROM `search_result` WHERE `code` = '$ref'"); 	
	$loading=$myName->showName($conn, "SELECT `loading` FROM `search_result` WHERE `code` = '$ref'"); 	
	$destination=$myName->showName($conn, "SELECT `destination` FROM `search_result` WHERE `code` = '$ref'"); 	
	$pick_up_date=$myName->showName($conn, "SELECT `pick_up_date` FROM `search_result` WHERE `code` = '$ref'"); 	
	$product=$myName->showName($conn, "SELECT `product` FROM `search_result` WHERE `code` = '$ref'"); 	
         
            
            
    $truck_plate_number =$myName->showName($conn, "SELECT `truck_plate_number` FROM `truck` WHERE `id` = '$truck_id'"); 	
   // $driver_account_number =$myName->showName($conn, "SELECT `driver` FROM `truck` WHERE `id` = '$truck_id'"); 	
    $account_number =$myName->showName($conn, "SELECT `account_number` FROM `truck` WHERE `id` = '$truck_id'"); 	
      
            
            
            

            
            
            
            
            
$customer_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$emailing'");             
$customer_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$emailing'");             
$customer_name=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$emailing'"); 
            
            
            
            
            
$owner_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$account_number'");             
$owner_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$account_number'");             
$owner_name=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$account_number'");             
            
            
            
            
            
            
            
$senderID = $inst_name;
$message = "Hi,".$naming.".
Payment made for your trip 
was successful".
"Ref:".$ref."
Amount:".number_format($chargeAmount,2)."
Vehicle plate no:".$truck_plate_number."
please login for details. ".$inst_name;
 

                         
   if(!empty($emailing))
{         
     
 $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `truck_id`) VALUES
('$ref','Trip Payment Information','$message','$emailing', '$emailing', '1', '1','$datetime', '$truck_id')";
  $extract_distance = mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));    
				
		 	
 mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));		
            
   }       
            
            
 
	$sendEmail =  '<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<table width="538">
  <tr>
    <th colspan="2">Payment made for your trip </th>
  </tr>
  <tr>
    <td width="223" height="18">Ref</td>
    <td width="303">'.$ref.'</td>
  </tr>
  <tr>
    <td>Amount</td>
    <td>'.number_format($chargeAmount, 2).'</td>
  </tr>
  <tr>
    <td>Car Number</td>
    <td>'.$truck_plate_number.'</td>
  </tr>
  <tr>
    <td>Loading Location </td>
    <td>'.$loading.' </td>
  </tr>
  <tr>
    <td>Destination</td>
    <td>'.$destination.'; </td>
  </tr>
  
  <tr>
    <td>Pick Up Date </td>
    <td> '.$pick_up_date.'</td>
  </tr>
  <tr>
    <th colspan="2">Patron\'s Information </th>
  </tr>
   <tr>
    <td>Patron Name </td>
    <td> '.$customer_name.'</td>
  </tr> <tr>
    <td>Patron Phone </td>
    <td> '.$customer_phone.'</td>
  </tr> <tr>
    <td>Patron Email </td>
    <td> '.$customer_email.'</td>
  </tr>
</table>
';
	$newEmail= "info@softnoche.com";
	//echo	$sendEmail;
	
	 					$headers = "From: " .($newEmail) . "\r\n";
                        $headers .= "Reply-To: ".($newEmail) . "\r\n";
                        $headers .= "Return-Path: ".($newEmail) . "\r\n";;
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
  $emailSend = mail($email_owner,"Successful Booking for: ".$truck_plate_number,$sendEmail,$headers);
	
 
            
 
   $Sending = new SendingSMS(); 
  							 
							 $Sending->smsAPI($phone,$senderID,$message);
            
            

            
            
            
            
            
$sendEmail_sub =  '<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<table width="538">
  <tr>
    <th colspan="2">Payment made for your ride </th>
  </tr>
  <tr>
    <td width="223" height="18">Ref</td>
    <td width="303">'.$ref.'</td>
  </tr>
  <tr>
    <td>Amount</td>
    <td>'.number_format($chargeAmount, 2).'</td>
  </tr>
  <tr>
    <td>Car Number</td>
    <td>'.$truck_plate_number.'</td>
  </tr>
  <tr>
    <td>Loading Location </td>
    <td>'.$loading.' </td>
  </tr>
  <tr>
    <td>Destination</td>
    <td>'.$destination.'; </td>
  </tr>
  
  <tr>
    <td>Pick Up Date </td>
    <td> '.$pick_up_date.'</td>
  </tr>
  <tr>
    <th colspan="2">Captain\'s Information </th>
  </tr>
   <tr>
    <td>Captain Name </td>
    <td> '.$owner_name.'</td>
  </tr> <tr>
    <td>Captain Phone </td>
    <td> '.$owner_phone.'</td>
  </tr> <tr>
    <td>Captain Email </td>
    <td> '.$owner_email.'</td>
  </tr>
</table>
';            
            
            
            	$newEmail= "info@softnoche.com";
	
	
	 					$headers = "From: " .($newEmail) . "\r\n";
                        $headers .= "Reply-To: ".($newEmail) . "\r\n";
                        $headers .= "Return-Path: ".($newEmail) . "\r\n";;
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
  $emailSend = mail($customer_email,"Successful Booking for: ".$truck_plate_number,$sendEmail_sub,$headers);
            
            
            
            $sql = 	mysqli_query($conn,"UPDATE `search_result` SET `status` = '1' , `means` = '$means' WHERE  `code` = '$ref'")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
            
            
   
            
$driver_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$truck_owner'");             
$driver_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$truck_owner'");             
$driver_name=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$truck_owner'");             
            
                
$senderID = $inst_name;
$message = "Hi,".$driver_name.".
You have a ride on ".$pick_up_date."
Ref:".$ref.".
Trip plate no:".$truck_plate_number."
Check Your ".$inst_name.". For more Info.";
 
if(!empty($driver_phone))
{
     $Sending = new SendingSMS(); 
     $Sending->smsAPI($driver_phone,$senderID,$message);    
}
        	
            
            
 
	$sendEmail =  '<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<table width="538">
  <tr>
    <th colspan="2">You Have A New Ride.</th>
  </tr>
   <tr>
    <td>Hi</td>
    <td>'.$driver_name.'</td>
  </tr>
  <tr>
    <td width="223" height="18">Ref</td>
    <td width="303">Ride ID: '.$ref.'</td>
  </tr>
 
  <tr>
    <td>Car Detail Number</td>
    <td>'.$truck_plate_number.'</td>
  </tr>
  <tr>
    <td>Loading Location </td>
    <td>'.$loading.' </td>
  </tr>
  <tr>
    <td>Destination</td>
    <td>'.$destination.'; </td>
  </tr>
 
  <tr>
    <td>Pick Up Date </td>
    <td> '.$pick_up_date.'</td>
  </tr>
  <tr>
    <th colspan="2">Patron\'s Information </th>
  </tr>
   <tr>
    <td>Customer Name </td>
    <td> '.$customer_name.'</td>
  </tr> <tr>
    <td>Customer Phone </td>
    <td> '.$customer_phone.'</td>
  </tr> <tr>
    <td>Customer Email </td>
    <td> '.$customer_email.'</td>
  </tr>
</table>
';
	$newEmail= "info@softnoche.com";
	
	
  					$headers = "From: " .($newEmail) . "\r\n";
                        $headers .= "Reply-To: ".($newEmail) . "\r\n";
                        $headers .= "Return-Path: ".($newEmail) . "\r\n";;
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
  $emailSend = mail($driver_email,"Trip Payment Information: ".$truck_plate_number,$sendEmail,$headers);
 
            
   if(!empty($truck_owner))
{         
     
 $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `truck_id`) VALUES
('$ref','Trip Payment Information','$message','$emailing', '$truck_owner', '1', '1','$datetime', '$truck_id')";
  $extract_distance = mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));    
				
		 	
 mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));		
            
   }
            /*`base_price`, `distance`, `time`, `road_maintenance`, `trip_amount`, `convinience_fee`*/
            
            
     
			  $base_price = $myName->showName($conn, "SELECT  `base_price` FROM `trip_record` WHERE  `code` = '$ref'");    
			 $distance = $myName->showName($conn, "SELECT  `distance` FROM `trip_record` WHERE `code` = '$ref'");   
			 $time = $myName->showName($conn, "SELECT  `time` FROM `trip_record` WHERE `code` = '$ref'");   
			  $trip_amount = $myName->showName($conn, "SELECT  `trip_amount` FROM `trip_record` WHERE `code` = '$ref'");   
			 $convinience_fee = $myName->showName($conn, "SELECT  `convinience_fee` FROM `trip_record` WHERE `code` = '$ref'");  $road_maintenance = $myName->showName($conn, "SELECT  `road_maintenance` FROM `trip_record` WHERE `code` = '$ref'");   
			
			
        //echo json_encode(array("statusCode"=>200, "errorMessage"=>"-".$statusParam." Successfully. Thank You.", "dest_long"=>$dest_long, "dest_lat"=>$dest_lat, "pick_long"=>$pick_long, "pick_lat"=>$pick_lat, "base_fare"=>$base_price, "time"=>$time, "road_maintenance"=>$road_maintenance, "convinience_fee"=>$convinience_fee, "total"=>$trip_amount ));     
            
echo json_encode(array("statusCode"=>200, "message"=>"Payment Successfull", "id"=>$truck_id, "ride_code"=>$ref, "type"=>"fresh", "detail"=>$message, "base_fare"=>number_format($base_price,2), "time"=>number_format($time,2), "distance"=>number_format($distance,2), "road_maintenance"=>number_format($road_maintenance,2), "convinience_fee"=>number_format($convinience_fee,2), "total"=>number_format($trip_amount,2) )); 
				  
            
              //echo json_encode(array("statusCode"=>200, "errorMessage"=>"success", "message"=>$message));  
            
            
            
    
   }
       else
       {
            $sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$message',  `status` = 0 WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
           
          // echo json_encode(array("statusCode"=>201, "errorMessage"=>"Message: ".$message, "message"=>"Error: ".$message));  
           
            echo json_encode(array("statusCode"=>201, "errorMessage"=>"Transaction Not Successfull.<br>
".$message.". <br>
Transaction Ref: ".$ref.". <br>
Thank You."));                
				
       }
     
        
        
              
            
        
        
    }
     else {
     $message = $resp1['message'];
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: 3 ".$resp1['message']."-".$resp1['data']));  
     $sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$message',  `status` = 0 WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
}
 
            
            
             
        
    }
			
			
			
			
			
			
			
			
			
			
			
			
			
			
    }

 
		   
		 
	  
	  
	  
        
        
        
        // echo json_encode(array("statusCode"=>201, "errorMessage"=>"Invalid Login Details. Please check."));  
        
     
    }
    }
	else if($means == "cash")
	{
		
            	$paymentStatus = "Successful Payment From the patron";
			    // $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = "NGN";
			// $vbvmessage = $resp['data']['vbvmessage'];
			// $vbvmessage = $resp['data']['vbvmessage'];
			 $vbvmessage2 = "Successful";
			 $chargeAmount=$myName->showName($conn, "SELECT `amount` FROM `search_result` WHERE `code` = '$ref'"); 						
 $chargeResponsecode ="00";
            
            
            $allmessages = $paymentStatus." ".$vbvmessage2;
			 		
$sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$allmessages',  `status` = '10',  `means` = '$means', `owners_share` = '$captain_share',`loadme_share` = '$wynk_share'   WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 
 //$sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$allmessages',  `status` = 1,  `means` = '$means'   WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
		            
 
            
            //// the price breakdown
        $base_price = $myName->showName($conn, "SELECT `base_price` FROM `trip_record` WHERE `code` = '$ref'");	
  $distance = $myName->showName($conn, "SELECT `distance` FROM `trip_record` WHERE `code` = '$ref'");	
  $time = $myName->showName($conn, "SELECT `time` FROM `trip_record` WHERE `code` = '$ref'");	
		
		
		$captain_share = $base_price + $distance + $time;
		
		
				
  $road_maintenance = $myName->showName($conn, "SELECT `road_maintenance` FROM `trip_record` WHERE `code` = '$ref'");	
  $convinience_fee = $myName->showName($conn, "SELECT `convinience_fee` FROM `trip_record` WHERE `code` = '$ref'");	
   
		$wynk_share =  $road_maintenance +  $convinience_fee;
		
		
		
		
		

            
            
            
            
									
 $sql = "INSERT INTO `tracker`(`code`,  `status`,`created_date`) VALUES
('$code', '1','$datetime')";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 	
            
       $truck_owner = $myName->showName($conn, "SELECT `truck_owner` FROM `transaction_information` WHERE   `code` = '$ref'");      
            
            $truck_owner = $captain_id;
 
		if($truck_owner!= "")
		{
            
            
            
	$phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	$email_owner=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	$naming=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$truck_owner'"); 	
	
	$truck_id=$myName->showName($conn, "SELECT `truck_id` FROM `search_result` WHERE `code` = '$ref'"); 	
	$loading=$myName->showName($conn, "SELECT `loading` FROM `search_result` WHERE `code` = '$ref'"); 	
	$destination=$myName->showName($conn, "SELECT `destination` FROM `search_result` WHERE `code` = '$ref'"); 	
	$pick_up_date=$myName->showName($conn, "SELECT `pick_up_date` FROM `search_result` WHERE `code` = '$ref'"); 	
	$product=$myName->showName($conn, "SELECT `product` FROM `search_result` WHERE `code` = '$ref'"); 	
         
            
            
    $truck_plate_number =$myName->showName($conn, "SELECT `truck_plate_number` FROM `truck` WHERE `id` = '$truck_id'"); 	
   // $driver_account_number =$myName->showName($conn, "SELECT `driver` FROM `truck` WHERE `id` = '$truck_id'"); 	
    $account_number =$myName->showName($conn, "SELECT `account_number` FROM `truck` WHERE `id` = '$truck_id'"); 	
      
            
            
            

            
            
            
            
            
$customer_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$emailing'");             
$customer_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$emailing'");             
$customer_name=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$emailing'"); 
            
            
            
            
            
$owner_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$account_number'");             
$owner_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$account_number'");             
$owner_name=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$account_number'");             
            
            
            
            
            
            
            
$senderID = $inst_name;
$message = "Hi,".$naming.".
Payment made for your trip 
was successful".
"Ref:".$ref."
Amount:".number_format($chargeAmount,2)."
Vehicle plate no:".$truck_plate_number."
please login for details. ".$inst_name;
 

                         

   if(!empty($emailing))
{         
     
 $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `truck_id`) VALUES
('$ref','Trip Payment Information','$message','$emailing', '$emailing', '1', '1','$datetime', '$truck_id')";
  $extract_distance = mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));    
				
		 	
 mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));		
            
   }       
            
            
 
	$sendEmail =  '<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<table width="538">
  <tr>
    <th colspan="2">Payment made for your trip </th>
  </tr>
  <tr>
    <td width="223" height="18">Ref</td>
    <td width="303">'.$ref.'</td>
  </tr>
  <tr>
    <td>Amount</td>
    <td>'.number_format($chargeAmount, 2).'</td>
  </tr>
  <tr>
    <td>Car Number</td>
    <td>'.$truck_plate_number.'</td>
  </tr>
  <tr>
    <td>Loading Location </td>
    <td>'.$loading.' </td>
  </tr>
  <tr>
    <td>Destination</td>
    <td>'.$destination.'; </td>
  </tr>
  
  <tr>
    <td>Pick Up Date </td>
    <td> '.$pick_up_date.'</td>
  </tr>
  <tr>
    <th colspan="2">Patron\'s Information </th>
  </tr>
   <tr>
    <td>Patron Name </td>
    <td> '.$customer_name.'</td>
  </tr> <tr>
    <td>Patron Phone </td>
    <td> '.$customer_phone.'</td>
  </tr> <tr>
    <td>Patron Email </td>
    <td> '.$customer_email.'</td>
  </tr>
</table>
';
	$newEmail= "info@softnoche.com";
	//echo	$sendEmail;
	
	 					$headers = "From: " .($newEmail) . "\r\n";
                        $headers .= "Reply-To: ".($newEmail) . "\r\n";
                        $headers .= "Return-Path: ".($newEmail) . "\r\n";;
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
  $emailSend = mail($email_owner,"Successful Booking for: ".$truck_plate_number,$sendEmail,$headers);
	
 
            
 
   $Sending = new SendingSMS(); 
  							 
							 $Sending->smsAPI($phone,$senderID,$message);
            
            

            
            
            
            
            
$sendEmail_sub =  '<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<table width="538">
  <tr>
    <th colspan="2">Payment made for your ride </th>
  </tr>
  <tr>
    <td width="223" height="18">Ref</td>
    <td width="303">'.$ref.'</td>
  </tr>
  <tr>
    <td>Amount</td>
    <td>'.number_format($chargeAmount, 2).'</td>
  </tr>
  <tr>
    <td>Car Number</td>
    <td>'.$truck_plate_number.'</td>
  </tr>
  <tr>
    <td>Loading Location </td>
    <td>'.$loading.' </td>
  </tr>
  <tr>
    <td>Destination</td>
    <td>'.$destination.'; </td>
  </tr>
  
  <tr>
    <td>Pick Up Date </td>
    <td> '.$pick_up_date.'</td>
  </tr>
  <tr>
    <th colspan="2">Captain\'s Information </th>
  </tr>
   <tr>
    <td>Captain Name </td>
    <td> '.$owner_name.'</td>
  </tr> <tr>
    <td>Captain Phone </td>
    <td> '.$owner_phone.'</td>
  </tr> <tr>
    <td>Captain Email </td>
    <td> '.$owner_email.'</td>
  </tr>
</table>
';            
            
            
            	$newEmail= "info@softnoche.com";
	
	
	 					$headers = "From: " .($newEmail) . "\r\n";
                        $headers .= "Reply-To: ".($newEmail) . "\r\n";
                        $headers .= "Return-Path: ".($newEmail) . "\r\n";;
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
  $emailSend = mail($customer_email,"Successful Booking for: ".$truck_plate_number,$sendEmail_sub,$headers);
            
            
            
            $sql = 	mysqli_query($conn,"UPDATE `search_result` SET `status` = '10' , `means` = '$means' WHERE  `code` = '$ref'")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
            
            
   
            
$driver_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$truck_owner'");             
$driver_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$truck_owner'");             
$driver_name=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$truck_owner'");             
            
                
$senderID = $inst_name;
$message = "Hi,".$driver_name.".
You have a ride on ".$pick_up_date."
Ref:".$ref.".
Trip plate no:".$truck_plate_number."
Check Your ".$inst_name.". For more Info.";
 
if(!empty($driver_phone))
{
     $Sending = new SendingSMS(); 
     $Sending->smsAPI($driver_phone,$senderID,$message);    
}
        	
            
            
 
	$sendEmail =  '<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<table width="538">
  <tr>
    <th colspan="2">You Have A New Ride.</th>
  </tr>
   <tr>
    <td>Hi</td>
    <td>'.$driver_name.'</td>
  </tr>
  <tr>
    <td width="223" height="18">Ref</td>
    <td width="303">Ride ID: '.$ref.'</td>
  </tr>
 
  <tr>
    <td>Car Detail Number</td>
    <td>'.$truck_plate_number.'</td>
  </tr>
  <tr>
    <td>Loading Location </td>
    <td>'.$loading.' </td>
  </tr>
  <tr>
    <td>Destination</td>
    <td>'.$destination.'; </td>
  </tr>
 
  <tr>
    <td>Pick Up Date </td>
    <td> '.$pick_up_date.'</td>
  </tr>
  <tr>
    <th colspan="2">Patron\'s Information </th>
  </tr>
   <tr>
    <td>Customer Name </td>
    <td> '.$customer_name.'</td>
  </tr> <tr>
    <td>Customer Phone </td>
    <td> '.$customer_phone.'</td>
  </tr> <tr>
    <td>Customer Email </td>
    <td> '.$customer_email.'</td>
  </tr>
</table>
';
	$newEmail= "info@softnoche.com";
	
	
  					$headers = "From: " .($newEmail) . "\r\n";
                        $headers .= "Reply-To: ".($newEmail) . "\r\n";
                        $headers .= "Return-Path: ".($newEmail) . "\r\n";;
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
  $emailSend = mail($driver_email,"Trip Payment Information: ".$truck_plate_number,$sendEmail,$headers);
 
            
   if(!empty($truck_owner))
{         
     
 $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `truck_id`) VALUES
('$ref','Trip Payment Information','$message','$emailing', '$truck_owner', '1', '1','$datetime', '$truck_id')";
  $extract_distance = mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));    
				
		 	
 mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));		
            
   }
            
            
            
             
     
			  $base_price = $myName->showName($conn, "SELECT  `base_price` FROM `trip_record` WHERE  `code` = '$ref'");    
			 $distance = $myName->showName($conn, "SELECT  `distance` FROM `trip_record` WHERE `code` = '$ref'");   
			 $time = $myName->showName($conn, "SELECT  `time` FROM `trip_record` WHERE `code` = '$ref'");   
			  $trip_amount = $myName->showName($conn, "SELECT  `trip_amount` FROM `trip_record` WHERE `code` = '$ref'");   
			 $convinience_fee = $myName->showName($conn, "SELECT  `convinience_fee` FROM `trip_record` WHERE `code` = '$ref'");  $road_maintenance = $myName->showName($conn, "SELECT  `road_maintenance` FROM `trip_record` WHERE `code` = '$ref'");   
			
			
        //echo json_encode(array("statusCode"=>200, "errorMessage"=>"-".$statusParam." Successfully. Thank You.", "dest_long"=>$dest_long, "dest_lat"=>$dest_lat, "pick_long"=>$pick_long, "pick_lat"=>$pick_lat, "base_fare"=>$base_price, "time"=>$time, "road_maintenance"=>$road_maintenance, "convinience_fee"=>$convinience_fee, "total"=>$trip_amount ));     
            
echo json_encode(array("statusCode"=>200, "message"=>"Payment Successfull", "id"=>$truck_id, "ride_code"=>$ref, "type"=>"fresh", "detail"=>$message, "base_fare"=>number_format($base_price,2), "time"=>number_format($time,2), "distance"=>number_format($distance,2), "road_maintenance"=>number_format($road_maintenance,2), "convinience_fee"=>number_format($convinience_fee,2), "total"=>number_format($trip_amount,2) )); 
            
            
//echo json_encode(array("statusCode"=>200, "message"=>"Payment Successfull", "id"=>$truck_id, "ride_code"=>$ref, "type"=>"fresh", "detail"=>$message)); 
				  
            
              //echo json_encode(array("statusCode"=>200, "errorMessage"=>"success", "message"=>$message));  
            
            
            
    
   }
       else
       {
            $sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$message',  `status` = 0 WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
           
          // echo json_encode(array("statusCode"=>201, "errorMessage"=>"Message: ".$message, "message"=>"Error: ".$message));  
           
            echo json_encode(array("statusCode"=>201, "errorMessage"=>"Transaction Not Successfull.<br>
".$message.". <br>
Transaction Ref: ".$ref.". <br>
Thank You."));                
				
       }
     
        
        
              
            
        
        
   
		
	}
		
}
else{
    
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Important Information Missing"));  
     $sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = 'Not Successful',  `status` = 0 WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
}
 

?>

