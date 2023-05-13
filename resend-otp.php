<?php 
 header('Access-Control-Allow-Origin: *');
  include("SendingSMS.php");

  include("config/DB_config.php");
 
require_once('view-application-details.php');

$json =  json_decode(file_get_contents('php://input'), true);

// $data = json_decode($json);
 
$phone =  $json["phone"];

if(!empty($phone))
{
	 
 
    $table = "otp";
	
	 
$statement = "DELETE FROM `otp` WHERE `phone` = '$phone'";
	
	 
$result = mysqli_query($conn, $statement) or die("ERROR OCCURED: ".mysqli_error($conn));
	
	
	
	
	
	
 //$otp =$_POST['allotp'];
 //$phone =$_POST['phone'];
 
   $account_number = "WYNK".rand(10, 99).rand(10, 99).rand(11, 89).rand(10, 99);	
   $otp = mt_rand(1111,9999);
    
    if(empty($phone))
    {
      	echo json_encode(array("statusCode"=>201, "message"=>"Phone Number is empty. Please try again later."));  
        
    }
    else{
    
    
 
$statement = "select * from `".$table."` where `phone` = '$phone' AND `status_value` = '0'";
	
	 
$result = mysqli_query($conn, $statement) or die("ERROR OCCURED: ".mysqli_error($conn));
 
	$count = mysqli_num_rows($result);
if($count > 0)
{
 $customer = mysqli_fetch_assoc($result);
//$_SESSION['email'] = $customer['username'];
$otpnumber = $customer['otpnumber'];
  $phone = $customer['phone'];
  $account_number		 = $customer['account_number'];
    echo json_encode(array("statusCode"=>200, "message"=>"OTP sent to this phone number. Thank You.", "phone"=>$phone, "otp"=>$otpnumber, "wynkid"=> $account_number));  
    
 
 
   }
   
  else
  {
	  
	 
	$sql = 	mysqli_query($conn,"INSERT INTO `otp`(`account_number`, `otpnumber`, `status_value`, `phone`) VALUES('$account_number','$otp','0','$phone')") or die("ERROR OCCURED: ".mysqli_error($conn)); 
	  
	   if($sql)
	   {
				
  $message =  $inst_name." registeration OTP! Your OTP #".$otp.". Please use it within 3 minutes.";

  $str2 = substr($phone, 3);


$newnumber= "0".$str2;

  	 $Sending = new SendingSMS(); 
  							 
			$sendSMS =	 $Sending->smsAPI($phone,"WynksupApp",$message);
	 
 echo json_encode(array("statusCode"=>200, "message"=>"OTP sent successfully.", "phone"=>$phone, "wynkid"=> $account_number, "otp"=>  $otp)); 
       }
      else{
          
           echo json_encode(array("statusCode"=>201, "message"=>"We cannot send OTP at this time. Please try again later.", "phone"=>$phone)); 
          
      }

		 
	  }
    }
}
 
else{
    echo json_encode(array("statusCode"=>201, "message"=>"Phone number is missing. OTP not sent. Please try again later."));  
    
}

 

 

?>

