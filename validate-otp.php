<?php 
 header('Access-Control-Allow-Origin: *');
  include("SendingSMS.php");

  include("config/DB_config.php");
 
require_once('view-application-details.php');


$json =  json_decode(file_get_contents('php://input'), true);

// $data = json_decode($json);
 
$otp =  $json["otp"];
$user =  $json["wynkid"];



if(!empty($otp))
{
	 
	$Sending = false;	
	$emailSend = false;	
    $table = "otp";
	
	 
 //$otp =$_POST['allotp'];
// $user =$_POST['username'];
 
 

    
    if(empty($user))
    {
      	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Wynk ID is empty. Please try again later."));  
        
    }
    else{
    
    
 
$statement = "select * from `".$table."` where `account_number` = '$user' AND `otpnumber` = '$otp'";
	
	 
$result = mysqli_query($conn, $statement) or die("ERROR OCCURED: ".mysqli_error($conn));
 
	$count = mysqli_num_rows($result);
if($count > 0)
{
 
$customer = mysqli_fetch_assoc($result);
//$_SESSION['email'] = $customer['username'];
$emailing = $customer['email'];
 $salt = $customer['salt'];
 $name = $customer['name'];
 $phone = $customer['phone'];
   
    
  $sql = 	mysqli_query($conn,"UPDATE `otp` SET  `status_value` = '1' WHERE `account_number` = '$user' AND  `otpnumber` = '$otp'") or die("ERROR OCCURED: ".mysqli_error($conn)); 
    
    
      echo json_encode(array("statusCode"=>200, "errorMessage"=>"OTP validated successfully. Thank you.", "phone"=>$phone, "wynkid"=>$user)); 
      //$sql = 	mysqli_query($conn,"UPDATE `user_unit`  SET  `password_update` = 1 WHERE  `account_number` = '$user'") or die("ERROR OCCURED: ".mysqli_error($conn)); 
 
   }
   
  else
  {
	  
	 
	
	  
	  	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"OTP/WynkId not valid. Please check and try again later."));  		 

		 
	  }
    }
}
 
else{
    echo json_encode(array("statusCode"=>201, "errorMessage"=>"OTP field is empty. Please check and try again.."));  
    
}

 

 

?>

