<?php
header('Access-Control-Allow-Origin: *');
 
 

include("config/DB_config.php");
 
 include("SendingSMS.php");
 include("view-application-details.php");
include("class_file.php");
 
 
 

 
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);







$long = "";
$lat = "";
$pin = "";
$pin2 = "";
$wynkid  = "";
$account_number  = "";
$username  = "";


 $json =  json_decode(file_get_contents('php://input'), true);

 $nubanAccountNo = "";
                    $accountFullName = "";




if(isset($json['long']))
{
    
  $long = htmlspecialchars(trim($json['long']));  
}

if(isset($json['lat']))
{
    
$lat = htmlspecialchars(trim($json['lat']));    
}
 
if(isset($json['pin']))
{
    
  $pin = htmlspecialchars(trim($json['pin']));
  $pin2 = htmlspecialchars(trim($json['pin']));
}
 
 
if(isset($json['wynkid']))
{
    
  $wynkid =  $json["wynkid"];
  $account_number =  $json["wynkid"];
  $username =  $json["wynkid"];
}

 /*
 $long = "3.3635574";
$lat = "6.57569";
$pin = "1986";
$pin2 = "1986"; 
$wynkid  = "WYNK33742751";
  $account_number  = "WYNK33742751";
  $username  = "WYNK33742751"; 
 */
 
 
 $myName = new Name();
 
     

     
if(empty($pin) || empty($wynkid))
{
  
	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Some Important Fields Are Left Empty. Please check and try again."));
	
}
else
{ 
 			
$uuid = uniqid('', true);

$salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($pin . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
         
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
		
		
		
		$number = 0;
		// WHERE `account_number` = '$account_number'
		
		
 $sql = "UPDATE `user_unit` SET  `unique_id` = '$uuid', `encrypted_password` = '$encrypted_password', `salt` = '$salt', `irrelivant` = '$pin', `pin` = '$pin' WHERE `account_number` = '$account_number' ";
 
 
 
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 $process = true;
	if ($process) {
		 
   
       $phone = $myName->showName($conn, "SELECT `phone` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $firstname = $myName->showName($conn, "SELECT `firstname` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $lastname = $myName->showName($conn, "SELECT `lastname` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $dob = $myName->showName($conn, "SELECT `dob` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $gender = $myName->showName($conn, "SELECT `gender` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $name = $myName->showName($conn, "SELECT `name` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $email = $myName->showName($conn, "SELECT `email` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $file = $myName->showName($conn, "SELECT `file` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit`  WHERE `account_number` = '$username'");	
       $password = $myName->showName($conn, "SELECT `password` FROM `application`  WHERE  1");	
        
        
        
       $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
     //, `remita_username`, `remita_password`, `, `remita_url` 
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
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
        
    // echo $data;
		
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
 
// echo  $resp;
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
             $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
 // echo $token;  
         
         //echo  $pin;
             
$pattern = '/^0/';
$replacement = '+234';
//$newphone =  preg_replace($pattern, $replacement, $phone).rand(1,9);


//USE This for live
//$newphone =  "+".$phone;


//$newphone =  "+".$phone.rand(0,9);

$newphone =  "+".$phone;
//$newphone =  "+2348103373964";

            //2020-11-17
      $dateOfBirth =   date("Y-m-d", strtotime($dob));    
 //$url = "https://walletdemo.remita.net/api/wallet-external";
$url = $remita_url."/wallet-external";
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
  "phoneNumber": "$newphone",
  "firstName": "$firstname",
  "lastName": "$lastname",
  "password": "$password",
  "pin": "$pin2",
  "dateOfBirth": "$dateOfBirth",
  "gender": "$gender",
  "state": "-",
  "localGovt": "-",
  "latitude": "$lat",
  "longitude": "$long",
  "address": "-",
  "scheme": "$remita_scheme",
  "accountName":  "$name",
  "email": "remita@wynk.ng",
  "photo": "Transfer"
  
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
        
       
      
 $resp1 = json_decode($resp, true);

   // var_dump($resp1);
        $status = false;
      // echo $resp1['code']." Coded";
       $message =  $resp1['message'];
		 //echo $message;
        if(isset($resp1['code']) == "success")
        {
     
    $status = $resp1['data'][0]['status'];     
        $id = $resp1['data'][0]['id'];
 $accountNumber = $resp1['data'][0]['accountNumber'];
 $currentBalance = $resp1['data'][0]['currentBalance'];
 $dateOpened = $resp1['data'][0]['dateOpened'];
 $schemeId = $resp1['data'][0]['schemeId'];
 $schemeName = $resp1['data'][0]['schemeName'];
 $walletAccountTypeId = $resp1['data'][0]['walletAccountTypeId'];
 $accountOwnerId = $resp1['data'][0]['accountOwnerId'];
 $accountOwnerName = $resp1['data'][0]['accountOwnerName'];
 $accountOwnerPhoneNumber = $resp1['data'][0]['accountOwnerPhoneNumber'];
 $accountName = $resp1['data'][0]['accountName'];
 $actualBalance = $resp1['data'][0]['actualBalance'];
 $trackingRef = $resp1['data'][0]['trackingRef'];
 $walletLimit = $resp1['data'][0]['walletLimit'];
 $nubanAccountNo = $resp1['data'][0]['nubanAccountNo'];
 $accountFullName = $resp1['data'][0]['accountFullName'];
 $totalCustomerBalances = $resp1['data'][0]['totalCustomerBalances'];
       

            
            
			
			
		 
$remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");
  $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$username'");
 // $phone = $myName->showName($conn, "SELECT `phone` FROM `user_unit` WHERE `account_number` = '$username'");
 
 $phone = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username' AND `primary_wallet` = 1 AND `accountNumber` != '' ORDER BY `id` DESC LIMIT 1");	
 $remita_username = $myName->showName($conn, "SELECT `phone` FROM `wallet_info` WHERE `registeredby` = '$username' AND `phone` != '' AND `primary_wallet` = 1  LIMIT 1 ");
$remita_password  = $myName->showName($conn, "SELECT `password` FROM `wallet_info` WHERE `registeredby` = '$username' AND `password` != '' AND `primary_wallet` = 1 LIMIT 1");

 
			
			
			
			
 
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
        {
            $token = $resp['token'];
            // $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
            $nubanAccountNo = $resp['walletAccountList']['id'];
              $accountFullName = $resp['walletAccountList'];
               $userType = $resp['userType'];
               
			
			//echo sizeof($resp['walletAccountList']);
               foreach($resp['walletAccountList'] as $add)
               {
                   
                   $nubanAccountNo = $add['nubanAccountNo'];
                    $accountFullName = $add['accountFullName'];
          // echo  " numban: ".$nubanAccountNo;
           
           break;
               }


 



 
        
        
    }
     
            
            
             
        
    }	
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			if(empty($accountNumber))
			{
				
				$accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM  `wallet_info` WHERE `phone` = '$newphone' AND `primary_wallet` = 1 AND `accountNumber` != ''");	
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
	     	 
$sql = 	 "INSERT INTO `wallet_info`(`accountNumber`, `currentBalance`, `dateOpened`, `schemeId`, `schemeName`, `walletAccountTypeId`, `accountOwnerId`, `accountOwnerName`, `accountOwnerPhoneNumber`, `accountName`, `actualBalance`, `walletLimit`, `trackingRef`, `nubanAccountNo`, `accountFullName`, `totalCustomerBalances`, `status`, `created_date`, `registeredby`, `phone` , `password`, `primary_wallet`,`lati`, `longi` ) VALUES
('$accountNumber', '$currentBalance', '$dateOpened', '$schemeId', '$schemeName', '$walletAccountTypeId', '$accountOwnerId', '$accountOwnerName', '$accountOwnerPhoneNumber', '$accountName', '$actualBalance', '$walletLimit','$trackingRef','$nubanAccountNo','$accountFullName','$totalCustomerBalances','1', '$datetime', '$username', '$newphone', '$password', '1', '$lat', '$long')";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));   		
			
			
			
			
 //$message = "Hi ". $firstname.", Wallet Created Successfully: Wallet No. ".$accountNumber."! Nuban:".$nubanAccountNo.". Polaris Bank. Thank You.";
			
			
 $message = "Welcome to WynksupApp: ". $firstname.", VaultID No: ".$accountNumber."! Nuban:".$nubanAccountNo.". Polaris Bank. Wynk with us in Style.";

  
  	 $Sending = new SendingSMS(); 
  	  $Sending->smsAPI($phone,"WynksupApp",$message);
			
			
			
			
			
			
			
			
			
			if(!empty($email))
			{
				
				
				
				$email_message = ' 
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
	<!--[if mso]>
  <style>
    table {border-collapse:collapse;border-spacing:0;border:none;margin:0;}
    div, td {padding:0;}
    div {margin:0 !important;}
	</style>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    table, td, div, h1, p {
      font-family: Arial, sans-serif;
    }
    @media screen and (max-width: 530px) {
      .unsub {
        display: block;
        padding: 8px;
        margin-top: 14px;
        border-radius: 6px;
        background-color: #555555;
        text-decoration: none !important;
        font-weight: bold;
      }
      .col-lge {
        max-width: 100% !important;
      }
    }
    @media screen and (min-width: 531px) {
      .col-sml {
        max-width: 27% !important;
      }
      .col-lge {
        max-width: 73% !important;
      }
    }
  </style>
</head>
<body style="margin:0;padding:0;word-spacing:normal;background-color:#241C89;">
  <div role="article" aria-roledescription="email" lang="en" style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#241C89;">
    <table role="presentation" style="width:100%;border:none;border-spacing:0;">
      <tr>
        <td align="center" style="padding:0;">
          <!--[if mso]>
          <table role="presentation" align="center" style="width:600px;">
          <tr>
          <td>
          <![endif]-->
          <table role="presentation" style="width:94%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;">
            <tr>
              <td style="padding:40px 30px 30px 30px;text-align:center;font-size:24px;font-weight:bold;">
                <a href="https://wynk.ng/" style="text-decoration:none;"><img src="https://wynk.ng/admin/restricted/graphicallity/Wynk-02-new.png" width="165" alt="Logo" style="width:165px;max-width:80%;height:auto;border:none;text-decoration:none;color:#ffffff;"></a>
              </td>
            </tr>
            <tr>
              <td style="padding:30px;background-color:#ffffff;">
                <h1 style="margin-top:0;margin-bottom:16px;font-size:26px;line-height:32px;font-weight:bold;letter-spacing:-0.02em;" align="center">Welcome to '.$inst_name.'  !</h1>
                <h3 style="margin-top:0;margin-bottom:16px;font-size:26px;line-height:32px;font-weight:bold;letter-spacing:-0.02em;" align="center">Ride. Payments. Lifestyle</h3>
                <p style="margin:0;" align="center">
				  The future belongs to those who dare to dream, we are dreamers and innovators, Wynk with us into the lifestyle of your dream.</p>
              </td>
            </tr>
            <tr>
              <td style="padding:0;font-size:24px;line-height:28px;font-weight:bold;">
                <a href="https://wynk.ng/" style="text-decoration:none;"><img src="https://assets.codepen.io/210284/1200x800-2.png" width="600" alt="" style="width:100%;height:auto;display:block;border:none;text-decoration:none;color:#363636;"></a>
              </td>
            </tr>
            <tr>
              <td style="padding:35px 30px 11px 30px;font-size:0;background-color:#ffffff;border-bottom:1px solid #f0f0f5;border-color:rgba(201,201,207,.35);">
                <!--[if mso]>
                <table role="presentation" width="100%">
                <tr>
                <td style="width:145px;" align="left" valign="top">
                <![endif]-->
                <div class="col-sml" style="display:inline-block;width:100%;max-width:145px;vertical-align:top;text-align:left;font-family:Arial,sans-serif;font-size:14px;color:#363636;">
                  <img src="https://wynk.ng/wp-content/uploads/2022/10/processed-34742800-b782-48d7-b719-8644c390ad46_JFcES4Qp.jpeg" width="115" alt="" style="width:115px;max-width:80%;margin-bottom:20px;">
                </div>
                <!--[if mso]>
                </td>
                <td style="width:395px;padding-bottom:20px;" valign="top">
                <![endif]-->
                <div class="col-lge" style="display:inline-block;width:100%;max-width:395px;vertical-align:top;padding-bottom:20px;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;">
                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <!-- Title -->
                    <tr>
                      <td style="padding:0 1px; text-align:center;"><h1 style="color:#1e1e2d; font-weight:400; margin:0;font-size:32px;font-family:\'Rubik\',sans-serif;">Hi '.$firstname.'</h1>
                        <span style="display:inline-block; vertical-align:middle; border-bottom:1px solid #cecece; 
                                        width:100px;"></span></td>
                    </tr>
                    <!-- Details Table -->
                    <tr>
                      <td><table cellpadding="0" cellspacing="0" style="width: 100%; border: 1px solid #ededed">
                        <tbody>
                          <tr>
                            <td colspan="2"
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">Please find your account details below:</td>
                          </tr>
                          <tr>
                            <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">Phone Number::</td>
                            <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> '.$phone.'</td>
                          </tr>
                          <tr>
                            <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">VaultID No:</td>
                            <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">'.$accountNumber.'</td>
                          </tr>
                          <tr>
                            <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">Nuban:</td>
                            <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">'.$nubanAccountNo.'</td>
                          </tr>
                          <tr>
                            <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">Bank:</td>
                            <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;"> Polaris</td>
                          </tr>
                        </tbody>
                      </table></td>
                    </tr>
                    <tr>
                      <td style="height:40px;">&nbsp;</td>
                    </tr>
                  </table>
                  <p><br>
                    
                    
                    
                  </p>
                  <p style="margin-top:0;margin-bottom:12px;">&nbsp;</p>
                  <p style="margin:0;"><a href="https://wynk.ng/" style="background: #ff3884; text-decoration: none; padding: 10px 25px; color: #ffffff; border-radius: 4px; display:inline-block; mso-padding-alt:0;text-underline-color:#ff3884"><!--[if mso]><i style="letter-spacing: 25px;mso-font-width:-100%;mso-text-raise:20pt">&nbsp;</i><![endif]--><span style="mso-text-raise:10pt;font-weight:bold;">More About Wynk</span><!--[if mso]><i style="letter-spacing: 25px;mso-font-width:-100%">&nbsp;</i><![endif]--></a></p>
                </div>
                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->
              </td>
            </tr>
            <tr>
              <td style="padding:30px;font-size:24px;line-height:28px;font-weight:bold;background-color:#ffffff;border-bottom:1px solid #f0f0f5;border-color:rgba(201,201,207,.35);">
                <a href="https://wynk.ng/" style="text-decoration:none;"><img src="https://assets.codepen.io/210284/1200x800-1.png" width="540" alt="" style="width:100%;height:auto;border:none;text-decoration:none;color:#363636;"></a>
              </td>
            </tr>
            <tr>
              <td style="padding:30px;background-color:#ffffff;">
                <h2>Who We Are</h2>
                <p>We are making your Lifestyle stress free and that is what drives us. We dare to innovate for the benefit of both our Patrons and Captains. Our platform will Wynk you to your destination, make payments and make your day. We are a single platform for earning and enjoying your lifestyle seamlessly. The future belongs to those who dare to dream, we are dreamers and innovators, Wynk with us into the lifestyle of your dream.</p>
                <p style="margin-top:0;margin-bottom:12px;">&nbsp;</p>
                <p style="margin:0;"><a href="https://wynk.ng/" style="background: #ff3884; text-decoration: none; padding: 10px 25px; color: #ffffff; border-radius: 4px; display:inline-block; mso-padding-alt:0;text-underline-color:#ff3884">
                  <!--[if mso]><i style="letter-spacing: 25px;mso-font-width:-100%;mso-text-raise:20pt">&nbsp;</i><![endif]-->
                  <span style="mso-text-raise:10pt;font-weight:bold;">More</span>
                  <!--[if mso]><i style="letter-spacing: 25px;mso-font-width:-100%">&nbsp;</i><![endif]-->
                </a></p>
                <p style="margin:0;">&nbsp;</p>
              </td>
            </tr>
            <tr>
              <td style="padding:30px;text-align:center;font-size:12px;background-color:#404040;color:#cccccc;">
                <p style="margin:0 0 8px 0;"><a href="http://www.facebook.com/" style="text-decoration:none;"><img src="https://assets.codepen.io/210284/facebook_1.png" width="40" height="40" alt="f" style="display:inline-block;color:#cccccc;"></a> <a href="http://www.twitter.com/" style="text-decoration:none;"><img src="https://assets.codepen.io/210284/twitter_1.png" width="40" height="40" alt="t" style="display:inline-block;color:#cccccc;"></a></p>
                <p style="margin:0;font-size:14px;line-height:20px;">&reg; '.$inst_name.'. '.date("Y").'<br><a class="unsub" href="https://wynk.ng/" style="color:#cccccc;text-decoration:underline;">Unsubscribe instantly</a></p>
              </td>
            </tr>
          </table>
          <!--[if mso]>
          </td>
          </tr>
          </table>
          <![endif]-->
        </td>
      </tr>
    </table>
  </div>
</body>
</html>';
				
 			
		
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
    $mail->addAddress($email, $firstname);     //Add a recipient
    
  //  $mail->addCC('olumideogundele@gmail.com');
    $mail->addBCC('olumideogundele@gmail.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Welcome to '.$inst_name." ".$firstname;
    $mail->Body    = $email_message ;
    $mail->AltBody = $message ;

    $mail->send();
    //echo 'Message has been sent';
} catch (Exception $e) {
   // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
		
	
				
			}
            
   }
		else{
			
			  $accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM  `wallet_info` WHERE `phone` = '$newphone' AND `primary_wallet` = 1 AND `accountNumber` != ''");	
			  $nubanAccountNo = $myName->showName($conn, "SELECT `nubanAccountNo` FROM  `wallet_info` WHERE `phone` = '$newphone' AND `primary_wallet` = 1 AND `nubanAccountNo` != ''");	
			
			
			   	 
$sql = 	 "UPDATE `wallet_info` SET `accountNumber` = '$accountNumber',  `nubanAccountNo` = '$nubanAccountNo' WHERE `registeredby` = '$username'";
 
			
			
			
			
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));  
			
			
			
			
			  //$message = "Hi, ". $firstname." Wallet Created Successfully: Wallet No. ".$accountNumber."! Thank You.";
 $message = "Welcome to WynksupApp: ". $firstname.", VaultID No: ".$accountNumber."! Nuban:".$nubanAccountNo.". Polaris Bank. Wynk with us in Style.";

  
  	 $Sending = new SendingSMS(); 
  							 
						 $Sending->smsAPI($phone,"WynkSupApp",$message);
			
		}
	 
        
        //second wallet
   /*     
        $url = $remita_url."/wallet-accounts";
      $curl1 = curl_init($url);
curl_setopt($curl1, CURLOPT_URL, $url);
curl_setopt($curl1, CURLOPT_POST, true);
curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/json",
   "Accept: application/json",
   "Authorization: Bearer ".$token,
);
curl_setopt($curl1, CURLOPT_HTTPHEADER, $headers);
 
      $accountName = "Welfare";
        
$data = <<<DATA
{
      "accountName": "$accountName"
   
}
DATA;
        
        
        $data1 = $data;

curl_setopt($curl1, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);


$resp2 = curl_exec($curl1);
 
         
     
 $err1 = curl_error($curl1);
curl_close($curl1);
if($err1){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$err1."."));  
}
    else
    {
        
         //echo $resp;  
      
 $resp1 = json_decode($resp2, true);

    //var_dump($resp1);
        $status = false;
       // echo $resp1['code']." Coded";
        if(isset($resp1['data']) == "")
        {
     
    $status = $resp1['status'];     
        $id = $resp1['id'];
 $accountNumber1 = $resp1['accountNumber'];
 $currentBalance1 = $resp1['currentBalance'];
 $dateOpened1 = $resp1['dateOpened'];
 $schemeId1 = $resp1['schemeId'];
 $schemeName1 = $resp1['schemeName'];
 $walletAccountTypeId1 = $resp1['walletAccountTypeId'];
 $accountOwnerId1 = $resp1['accountOwnerId'];
 $accountOwnerName1 = $resp1['accountOwnerName'];
 $accountOwnerPhoneNumber1 = $resp1['accountOwnerPhoneNumber'];
 $accountName1 = $resp1['accountName'];
 $actualBalance1 = $resp1['actualBalance'];
 $trackingRef1 = $resp1['trackingRef'];
 $walletLimit1 = $resp1['walletLimit'];
 $nubanAccountNo1 = $resp1['nubanAccountNo'];
 $accountFullName1 = $resp1['accountFullName'];
 $totalCustomerBalances1 = $resp1['totalCustomerBalances'];
       
     	 
$sql = 	 "INSERT INTO `wallet_info`(`accountNumber`, `currentBalance`, `dateOpened`, `schemeId`, `schemeName`, `walletAccountTypeId`, `accountOwnerId`, `accountOwnerName`, `accountOwnerPhoneNumber`, `accountName`, `actualBalance`, `walletLimit`, `trackingRef`, `nubanAccountNo`, `accountFullName`, `totalCustomerBalances`, `status`, `created_date`, `registeredby`, `phone` , `password`, `primary_wallet`,`lati`, `longi` ) VALUES
('$accountNumber1', '$currentBalance1', '$dateOpened1', '$schemeId1', '$schemeName1', '$walletAccountTypeId1', '$accountOwnerId1', '$accountOwnerName1', '$accountOwnerPhoneNumber1', '$accountName1', '$actualBalance1', '$walletLimit1','$trackingRef1','$nubanAccountNo1','$accountFullName1','$totalCustomerBalances1','1', '$datetime', '$username', '$newphone', '$password', '0', '$lat', '$long')";
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));   
            
            
             // $message = "Hi, ". $firstname." Wallet Created Successfully: Wallet No. ".$accountNumber."! nubanAccountNo:".$nubanAccountNo.". Polaris Bank. Thank You.";

  
  	 //$Sending = new SendingSMS(); 
  							 
		//				 $Sending->smsAPI($phone,"Welcome",$message);
            
   }
		 
              
            
        
        
    }*/
    }
     
            
            
             
        
    }
     
         
        
   
            
            
            
            
     
        
        //echo $message;
    }
 
        
        
        
        
  
 echo json_encode(array("statusCode"=>200, "errorMessage"=>"Information submitted successfully. Please continue.", "email"=>$email, "username"=>$username,"walletno"=>$accountNumber, "nubanAccountNo"=>$nubanAccountNo,"bank"=>"Polaris Bank", "error"=>""));   
		
  }
  else
  {
	  
	  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured:  User Information not Updated Successfully."));  
  }


    
 }
 
            

 
 
 










?>