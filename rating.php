 
<?php

header('Access-Control-Allow-Origin: *');
 
 date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');
require_once('SendingSMS.php');
require_once('fcm-send-function.php');
require_once('view-application-details.php');
 $Sending = new SendingSMS(); 
$myName = new Name();
$to_wallet = "";

 $myName = new Name();
 

$json =  json_decode(file_get_contents('php://input'), true);



$code =  $json["ride_code"];
$tcode =  $json["ride_code"].date('ymd');
$wynk_id =  $json["wynk_id"];
$tip =  $json["tip"];


 if(!empty($code))
 {
   
   
	$star = $json["star"];  
	$comment =  mysqli_real_escape_string($conn,$json["comment"]);  
	$code = $json["ride_code"];  
 $rated = "";

     $captain = $myName->showName($conn, "SELECT  `truck_owner` FROM `search_result`  WHERE `code` = '$code'");
     $username = $myName->showName($conn, "SELECT  `registeredby` FROM `search_result`  WHERE `code` = '$code'");
     
	 
	 $status = 0;
     if($wynk_id == $captain)
	 {
		 $status = 1;
		 
		 $rated = $username ;
		 
	 }
	 else{
		 
		 $status = 2;
		  $rated = $captain ;
	 }
     

   
                                                                                          
                                           
  $insert =  $sqlnot1 ="INSERT INTO `ratings`(`captain`, `patron`, `review`, `ratings_score`, `created_date`, `status`, `rideid`,`registeredby`, `rated`) VALUES('$captain','$username','$comment','$star','$datetime','$status', '$code', '$wynk_id', '$rated')";
mysqli_query($conn, $sqlnot1) or die(mysqli_error($conn));
                                      
                                        
    if($insert)
             {
                  echo json_encode(array("statusCode"=>200, "errorMessage"=>"Rating Successfully Submitted. Thank You."));
                 
             }
             else{
                 
                  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Rating Not Successfully Submitted. Thank You."));
             }
             
             
              
                                        
               
	 
	 if(isset($json["tip"]))
	 {
		
	
	
 
		 
		 
		 
		 $sent_to_wynkid = $myName->showName($conn, "SELECT  `truck_owner` FROM `search_result`  WHERE `code` = '$code'");
         $username = $myName->showName($conn, "SELECT  `registeredby` FROM `search_result`  WHERE `code` = '$code'");
		 
		 
		 $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
		 
		  $remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username' AND `phone` != ''  LIMIT 1");
	$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$username' AND `password` != ''  LIMIT 1");	
	
		 
		 
 $from_wallet  = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$username' AND `accountNumber` != '' AND `status` = 1  LIMIT 1");	
		 
		 
 $to_wallet_1  = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$sent_to_wynkid' AND `accountNumber` != '' AND `status` = 1  AND `accountName` LIKE '%Welfare%'  LIMIT 1");	
 $to_wallet_2  = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$sent_to_wynkid' AND `accountNumber` != '' AND `status` = 1  LIMIT 1");	

		
		 $to_wallet  = $to_wallet_1;
		 
		 if(empty($to_wallet_1))
		 {
			 
			 $to_wallet = $to_wallet_2;
		 }
		 
		 
		 
		  $accountNumber = $myName->showName($conn, "SELECT  `accountNumber` FROM `wallet_info` WHERE  `accountNumber` = '$from_wallet' AND `registeredby` = '$username'");
		 
	$naming=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$username'"); 
	$sent_from_fname=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$username'"); 
	$sent_to_fname=$myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$sent_to_wynkid'"); 
	$sent_to_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$sent_to_wynkid'"); 
	$sent_to_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$sent_to_wynkid'"); 
	$sent_from_phone=$myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$username'"); 
	$sent_from_email=$myName->showName($conn, "SELECT `email` FROM `user_unit` WHERE `account_number` = '$username'"); 
 


//Wallet Number of patron
  $accountNumber = $from_wallet;
  $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$username'");
    //Wallet Number if Captain
  $cap_accountNumber = $to_wallet;
		
	//echo $pin;	
		 $cap_accountNumber = $to_wallet;
		
	//echo $pin;	
	 if(!empty($accountNumber))
	{ 	
  $amount_to_be_paid = $amount;	
		 $amount = $tip;
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
 
  //echo  $resp;
$err = curl_error($curl);
curl_close($curl);
if($err){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occurred: ".$err."."));  
}
    else
    {
        $totalAmount = 100;
        
        $resp = json_decode($resp, true);
        
 //echo $resp;
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
  "accountNumber": "$to_wallet",
  "amount": $amount,
  "channel": "wallettowallet",
  "sourceBankCode": "",
  "sourceAccountNumber": "$from_wallet",
  "destBankCode": "",
  "pin": "$pin",
  "transRef": "$tcode",
  "isToBeSaved": true,
  "beneficiaryName": "$cap_accountNumber"
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
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$err1."."));  
}
    else
    {
        
         // echo $resp;  
      
 $resp1 = json_decode($resp, true);
$message = $resp1['message'];
    //var_dump($resp1);
        $status = false;
       // echo $resp1['code']." Coded";
        
        $vbvmessage = "";
        //echo $resp1['code'];
		
        if($resp1['code'] == "00")
        {
            	
	 	$ref = $code;
			
			$paymentStatus = "Successful Payment";
			    // $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = "NGN";
			// $vbvmessage = $resp['data']['vbvmessage'];
			// $vbvmessage = $resp['data']['vbvmessage'];
			 $vbvmessage2 = "Successful";
			 $chargeAmount=$myName->showName($conn, "SELECT `amount` FROM `search_result` WHERE `code` = '$ref'"); 						
 $chargeResponsecode ="00";
            
            
            $allmessages = $paymentStatus." ".$vbvmessage2;
 
            
//$sql = 	mysqli_query($conn,"INSERT INTO `transaction_information`(`code`,  `truck_owner`,  `amount`, `commissiononfee`,  `registeredby`, `created_date`, `message`, `status`, `customer` ,  `owners_share`, `loadme_share`, `means`) VALUES('$code','$sent_to_wynkid','$amount','-','$emailing', '$datetime','$allmessages','1', '$emailing', '-','-','w2w') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
			
			$fee = 10;
			
			$narration ="Ride TIP V2V TXN from ".$sent_from_fname." to ".$sent_to_fname;
			
	  $sql = 	mysqli_query($conn,"INSERT INTO `transaction_information`(`code`,   `truck_owner`,  `amount`, `commissiononfee`,  `registeredby`, `created_date`, `message`, `status`, `customer` ,  `owners_share`, `means`, `refs`, `products`, `narration` , `channel`,  `id_number`, `wallet_number` ) VALUES('$code','$username','$amount','$fee','$emailing', '$datetime','$allmessages','1', '$naming', '0','wallet','$code','w2w','$narration','$narration','$to_wallet','$from_wallet') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 		
 
 	 
			$url = $remita_url."/get-account-details/".$to_wallet; 
		 
		 
		 
		 //echo $url;
		 
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
     
    $status = $resp1['data']['status'];     
        $id = $resp1['data']['id'];
 $accountNumber = $resp1['data']['accountNumber'];
 $currentBalance = $resp1['data']['currentBalance'];
  
		
			
   
   }
      }
			
			
		 $c_phone  = substr_replace($to_wallet,"******",3,-2);	
			
					
$message= "Credit Amount: NGN".$amount." A/C: ".$c_phone." DESC: ".$narration." Payment Txn Ref: ".$code." DATE: ".$datetime." BAL: NGN".$currentBalance;
 
 $Sending->smsAPI($sent_to_phone,"WynksupApp",$message);			
	
			
	 
			
			
			
			
			///sending fcm STAGE 1
				 $device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = '$sent_to_wynkid'"); 	
			
			
			if(!empty($device_token))
			{
				
				$fcmSend->sendFCM($device_token, "Credit Alert",$message, "WYNK VAULT CREDIT ALERT", $message);
			}
				
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			if(!empty($sent_to_email))
			{
				
				
				//echo $sent_to_email." <p>";
				
				$email_message = '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="x-apple-disable-message-reformatting">
	<title></title>
	<!--[if mso]>
	<noscript>
		<xml>
			<o:OfficeDocumentSettings>
				<o:PixelsPerInch>96</o:PixelsPerInch>
			</o:OfficeDocumentSettings>
		</xml>
	</noscript>
	<![endif]-->
	<style>
		table, td, div, h1, p {font-family: Arial, sans-serif;}
	</style>
</head>
<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width: 90%; border-collapse: collapse; border: 1px solid #cccccc; border-spacing: 0;">
					<tr align="center" style="background:#211E8A; text-align: center;align-content: center;">
						<td align="center" style="background:#211E8A; text-align: center;align-content: center;">
							<img src="https://wynk.ng/admin/restricted/graphicallity/Wynk-02-new.png" alt="" width="175" height="104" style="height:auto; align-content: center;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 6px 0;color:#153643;">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hi '.$sent_to_fname.', </h1>
									<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Your WYNKVAULT '.$c_phone.' was creditted. Please find information below.									</p></td>
								</tr>
								<tr>
									<td style="padding:0;"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px; background:#fff; border-radius:3px;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);padding:0 10px;">
									  <!-- Title -->
									  <tr>
									    <td style="padding:0 15px; text-align:center;"><h1 style="color:#1e1e2d; font-weight:400; margin:0;font-size:32px;font-family:\'Rubik\',sans-serif;">Transaction Information</h1>
									      <span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; 
                                        width:100px;"></span></td>
								      </tr>
									  <!-- Details Table -->
									  <tr>
 <td><table cellpadding="0" cellspacing="0" style="width: 100%; border: 1px solid #ededed">
									      <tbody>
									        <tr>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)"> Amount:</td>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> NGN'.number_format($amount,2).'</td>
								            </tr>
									        <tr>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">WYNK VaultID</td>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> '.$c_phone.'</td>
								            </tr>
									        <tr>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)"> Vault Balance:</td>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> NGN'.number_format($currentBalance,2).'</td>
								            </tr>
									        <tr>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)"> Transaction ID:</td>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> '.$code.'</td>
								            </tr>
									        <tr>
									          <td
                                                        style="padding: 10px;  border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)"> Transaction Date:</td>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> '.$datetime.'</td>
								            </tr>
									        <tr>
									          <td
                                                        style="padding: 10px; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)"> Naration:</td>
									          <td style="padding: 10px; color: #455056;">'.$narration.'</td>
								            </tr>
								          </tbody>
									      </table></td>
								      </tr>
									  <tr>
									    <td style="height:40px;">&nbsp;</td>
								      </tr>
								    </table></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#F98611;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
											&reg; '.$inst_name.', '.date('Y').'<br/>
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
												<td style="padding:0 0 0 10px;width:38px;">
													<a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
		  </td>
		</tr>
	</table>
</body>
</html>';
				
	//echo $email_message." <p> Creditted ";		
		
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.wynk.ng';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'noreply@wynk.ng';                     //SMTP username
    $mail->Password   = 'hollywood2019';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	$mail->SMTPDebug = false;
	$mail->do_debug = 0;//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('noreply@wynk.ng', 'WYNK');
    $mail->addAddress($sent_to_email, $sent_to_fname);     //Add a recipient
    
  //  $mail->addCC('olumideogundele@gmail.com');
  //  $mail->addBCC('olumideogundele@gmail.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'WYNK VAULT CREDIT ALERT';
    $mail->Body    = $email_message ;
    $mail->AltBody = $message ;

    $mail->send();
    //echo 'Message has been sent';
} catch (Exception $e) {
   // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
		
	
   		
				
				
			}
			
			
			 
	
			
			

//// to sender
			
			
			
  $fee = $myName->showName($conn, "SELECT  `total` FROM `w2wcharges` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 1");	
  $remita_transaction = $myName->showName($conn, "SELECT  `remita_transaction` FROM `w2wcharges` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 1");	
  $vat = $myName->showName($conn, "SELECT  `vat` FROM `w2wcharges` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 1");	
  $wynk_charges = $myName->showName($conn, "SELECT  `wynk_charges` FROM `w2wcharges` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 1");	


			
			
			$url = $remita_url."/get-account-details/".$from_wallet; 
		 
		 
		 
		 //echo $url;
		 
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
     
    $status = $resp1['data']['status'];     
        $id = $resp1['data']['id'];
 $accountNumber = $resp1['data']['accountNumber'];
 $currentBalance = $resp1['data']['currentBalance'];
  
		
			
   
   }
      }
			
			
		 $c_phone  = substr_replace($from_wallet,"******",3,-2);		
			 
			
$message= "Debit Amount: NGN".$amount." Charges: ".$fee." A/C: ".$c_phone." DESC: ".$narration." Payment Txn Ref: ".$code." DATE: ".$datetime." BAL: NGN".$currentBalance;
 
			
 ///sending fcm STAGE 2
				 $device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = '$username'"); 	
			
			
			if(!empty($device_token))
			{
				
				$fcmSend->sendFCM($device_token, "Debit Alert",$message, "WYNK VAULT DEBIT ALERT", $message);
			}
				
			
			
			
  							 
  $Sending->smsAPI($sent_from_phone,"WynksupApp",$message);			
			
			
   
			if(!empty($sent_from_email))
			{
			$email_message = "";	
				$email_message = '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="x-apple-disable-message-reformatting">
	<title></title>
	<!--[if mso]>
	<noscript>
		<xml>
			<o:OfficeDocumentSettings>
				<o:PixelsPerInch>96</o:PixelsPerInch>
			</o:OfficeDocumentSettings>
		</xml>
	</noscript>
	<![endif]-->
	<style>
		table, td, div, h1, p {font-family: Arial, sans-serif;}
	</style>
</head>
<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width: 80%; border-collapse: collapse; border: 1px solid #cccccc; border-spacing: 0;">
					<tr align="center" style="background:#211E8A; text-align: center;align-content: center;">
						<td align="center" style="background:#211E8A; text-align: center;align-content: center;">
							<img src="https://wynk.ng/admin/restricted/graphicallity/Wynk-02-new.png" alt="" width="175" height="104" style="height:auto; align-content: center;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 6px 0;color:#153643;">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Hi '.$sent_from_fname.'</h1>
									<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Your WYNKVAULT '.$c_phone.' was debitted. Please find information below.									</p></td>
								</tr>
								<tr>
									<td style="padding:0;"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px; background:#fff; border-radius:3px;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);padding:0 10px;">
									  <!-- Title -->
									  <tr>
									    <td style="padding:0 15px; text-align:center;"><h1 style="color:#1e1e2d; font-weight:400; margin:0;font-size:32px;font-family:\'Rubik\',sans-serif;">Transaction Information</h1>
									      <span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; 
                                        width:100px;"></span></td>
								      </tr>
									  <!-- Details Table -->
									  <tr>
									    <td><table cellpadding="0" cellspacing="0"
                                            style="width: 100%; border: 1px solid #ededed">
									      <tbody>
									        <tr>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)"> Amount:</td>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> NGN'.number_format($amount,2).'</td>
								            </tr>
											
											     <tr>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)"> Charges:</td>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> NGN'.number_format($fee,2).'</td>
								            </tr>
											
											
											
											
									        <tr>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">WYNK VaultID</td>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> '.$c_phone.'</td>
								            </tr>
									        <tr>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)"> Vault Balance:</td>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> NGN'.number_format($currentBalance,2).'</td>
								            </tr>
									        <tr>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)"> Transaction ID:</td>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> '.$code.'</td>
								            </tr>
									        <tr>
									          <td
                                                        style="padding: 10px;  border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)"> Transaction Date:</td>
									          <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> '.$datetime.'</td>
								            </tr>
									        <tr>
									          <td
                                                        style="padding: 10px; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)"> Naration:</td>
									          <td style="padding: 10px; color: #455056;">'.$narration.'</td>
								            </tr>
								          </tbody>
									      </table></td>
								      </tr>
									  <tr>
									    <td style="height:40px;">&nbsp;</td>
								      </tr>
								    </table></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#F98611;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
											&reg; '.$inst_name.', '.date('Y').'<br/>
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
												<td style="padding:0 0 0 10px;width:38px;">
													<a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
		  </td>
		</tr>
	</table>
</body>
</html>';
				
//	echo $sent_from_email." <p> Debitted ";			
	//echo $email_message." <p> Debitted ";			
		
try {
    //Server settings
    $mail1->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail1->isSMTP();                                            //Send using SMTP
    $mail1->Host       = 'mail.wynk.ng';                     //Set the SMTP server to send through
    $mail1->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail1->Username   = 'noreply@wynk.ng';                     //SMTP username
    $mail1->Password   = 'hollywood2019';                               //SMTP password
    $mail1->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail1->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	$mail1->SMTPDebug = false;
	$mail1->do_debug = 0;//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail1->setFrom('noreply@wynk.ng', 'WYNK');
    $mail1->addAddress($sent_from_email, $sent_from_fname);     //Add a recipient
    
  //  $mail->addCC('olumideogundele@gmail.com');
   // $mail->addBCC('olumideogundele@gmail.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail1->isHTML(true);                                  //Set email format to HTML
    $mail1->Subject = 'WYNK VAULT DEBIT ALERT';
    $mail1->Body    = $email_message ;
    $mail1->AltBody = $message ;

    $mail1->send();
    //echo 'Message has been sent';
} catch (Exception $e) {
   // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
		
	
   		
				
				
			}
			
		      
      
    
            
//echo json_encode(array("statusCode"=>200, "message"=>"Payment Successfull", "code"=>$ref, "amount"=>number_format($amount,2), "charges"=>number_format($fee,2), "notification"=>$message )); 
				  
            
              //echo json_encode(array("statusCode"=>200, "errorMessage"=>"success", "message"=>$message));  
            
            
            
    
   }
       else
       {
           // $sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$message',  `status` = 0 WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
		   
		   
		 //  $data = $resp1['data'];
           
          // echo json_encode(array("statusCode"=>201, "errorMessage"=>"Message: ".$message, "message"=>"Error: ".$message));  
           
         //   echo json_encode(array("statusCode"=>201, "errorMessage"=>"Transaction Not Successfull. ".$message.". ".$data.". Thank You."));                
				
       }
     
        
        
              
            
        
    /*    
    }
     else {
     $message = $resp1['message'];
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$resp1['message']));  
     //$sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$message',  `status` = 0 WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
}*/
 
            
            
             
        
    }
			
			
			
			
			
			
			
			
			
			
			
			
			
			
    }

 
		   
		 
	  
	  
	  
        
        
        
    
     
    }
    }
	 else{
    
     //echo json_encode(array("statusCode"=>201, "errorMessage"=>"Your wallet information cannot be found. Please check and try again later.". $username));  
   	
}
		 
	 }
                                  
                                                    
                                                    
                                                    
                                                    
                                          
											
										  	
 }
			 
					 
		   
	 
?>