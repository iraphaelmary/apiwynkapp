<?php 
 header('Access-Control-Allow-Origin: *');
  include("SendingSMS.php");

  include("config/DB_config.php");
 
require_once('view-application-details.php');

if(isset($_POST['phone']))
{
	 
	$Sending = false;	
	$emailSend = false;	
    $table = "user_unit";
	
	 
 $user =$_POST['phone'];
 
 
    $otp = mt_rand(1111,9999);

    
    if(empty($user))
    {
      	echo json_encode(array("statusCode"=>201, "errorMessage"=>"User information is empty. Please try again later."));  
        
    }
    else{
    
    
 
$statement = "select * from `".$table."` where `account_number` = '$user' AND `status` = '1'";
	
	 
$result = mysqli_query($conn, $statement) or die("ERROR OCCURED: ".mysqli_error($conn));

if($result)
{
if(mysqli_num_rows($result) == 1)
{
$customer = mysqli_fetch_assoc($result);
//$_SESSION['email'] = $customer['username'];
$emailing = $customer['email'];
 $salt = $customer['salt'];
 $name = $customer['name'];
 $phone = $customer['phone'];
  
 
 //SELECT  `id`, `account_number`, `otpnumber`, `status_value`FROM `otp` WHERE 1
 
 
   
    $statement1 = "SELECT  `id`, `account_number`, `otpnumber`, `status_value` FROM `otp`  where `account_number` = '$user'";
	// echo "UPDATE `otp` SET  `otpnumber` = '$otp', `status_value` = '0' WHERE `account_number`'$user'";
	 
$result1 = mysqli_query($conn, $statement1) or die("ERROR OCCURED: ".mysqli_error($conn));
	$count = mysqli_num_rows($result1);
 if ($count > 0)
{
 
    $sql = 	mysqli_query($conn,"UPDATE `otp` SET  `otpnumber` = '$otp', `status_value` = '0' WHERE `account_number` = '$user'") or die("ERROR OCCURED: ".mysqli_error($conn)); 
     
     
     
    
}
else
{ $sql = 	mysqli_query($conn,"INSERT INTO `otp`(`account_number`, `otpnumber`, `status_value`) VALUES('$user','$otp','0')") or die("ERROR OCCURED: ".mysqli_error($conn)); 
        
        
}
	   
	   
	   if(!empty($phone))
	   {
				
  $message = "Hi ".$name."! Your OTP #".$otp.". @www.softnoche.com #".$otp;

  
  	 $Sending = new SendingSMS(); 
  							 
				 	$Sending->smsAPI($phone,"WynksupApp",$message);
	 
           
       }
    
    
    
    if(!empty($emailing))
    {
 
 
     
    //  echo json_encode(array("statusCode"=>200, "errorMessage"=>"Pin changed succesfully. Thank You. Please wait."));
     
     
     
     
     
	$sendEmail =  '
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Change Password</title>


<style type="text/css">
img {
max-width: 100%;
}
body {
-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
}
body {
background-color: #f6f6f6;
}
@media only screen and (max-width: 640px) {
  body {
    padding: 0 !important;
  }
  h1 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h2 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h3 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h4 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h1 {
    font-size: 22px !important;
  }
  h2 {
    font-size: 18px !important;
  }
  h3 {
    font-size: 16px !important;
  }
  .container {
    padding: 0 !important; width: 100% !important;
  }
  .content {
    padding: 0 !important;
  }
  .content-wrap {
    padding: 10px !important;
  }
  .invoice {
    width: 100% !important;
  }
}
</style>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
		<td class="container" width="600" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
			<div class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
				<table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
				  <td class="content-wrap aligncenter" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px;" align="center" valign="top">
							<table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
										<h2 class="aligncenter" style="font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 24px; color: #000; line-height: 1.2em; font-weight: 400; text-align: center; margin: 40px 0 0;" align="center">Thanks for using  '.$inst_name.'.</h2>
									</td>
								</tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block aligncenter" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
										<table class="invoice" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 80%; margin: 10px auto;">
										  <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
										  <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0; font-weight: bold; text-align: center; color:black;" valign="top">Your OTP '.$otp.'.</td>
										  </tr></table></td>
								</tr></table></td>
		  </tr></table><div class="footer" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;"></div></div>
		</td>	
		<td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
	</tr></table>  
    
</body>
</html>
';
	$newEmail= $inst_email;
	
	
	 					$headers = "From: " .($newEmail) . "\r\n";
                        $headers .= "Reply-To: ".($newEmail) . "\r\n";
                        $headers .= "Return-Path: ".($newEmail) . "\r\n";;
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
 $emailSend = mail($emailing,"OTP from ".$inst_name,$sendEmail,$headers); 
    
    
	
	 
		
 


	   }
	   
    
    
    if($sendEmail || $Sending)
    {
        
        echo json_encode(array("statusCode"=>200, "errorMessage"=>"OTP sent to your phone number and email", "phone"=>$phone, "email"=>$emailing));  
    }else
    {
        
        echo json_encode(array("statusCode"=>201, "errorMessage"=>"OTP Information not send successfully. Please wait."));  
    }
 
	   
	   
   }
   
  else
  {
	  
	/*   echo '
						<script>
						var message = "User with email address '.$user.' not found. Please contact the administrator.";
						  alert(message);
						</script>';*/
      
      
       echo json_encode(array("statusCode"=>201, "errorMessage"=>"User with ID  '.$user.' not found. Please contact the administrator."));  
	
	  
	  			 

		 
	  }


}
else
{
    
    
          echo json_encode(array("statusCode"=>201, "errorMessage"=>"User information not found. Please contact the administrator."));  
 
    
	
	  
	  			 
 
					 
			 
}
}


}
else{
    echo json_encode(array("statusCode"=>201, "errorMessage"=>"User with ID '.$user.' not found. Please contact the administrator."));  
    
}

 

 

?>

