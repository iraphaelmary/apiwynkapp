<?php 
 header('Access-Control-Allow-Origin: *');
  include("SendingSMS.php");
//process OTP
  include("config/DB_config.php");
 
require_once('view-application-details.php');


$json =  json_decode(file_get_contents('php://input'), true);

 

 


//$start_long = $json['loading_long']; 


if(!empty($json['otp']))
{
	 
	$Sending = false;	
	$emailSend = false;	
    $table = "trip_otp";
	
	 
 $otp =$json['otp'];
 $user =$json['wynkid'];
 
 

    
    if(empty($user))
    {
      	echo json_encode(array("statusCode"=>201, "errorMessage"=>"WYNKID is empty. Please try again later."));  
        
    }
    else{
    
    
 
$statement = "select * from `".$table."` where `captain` = '$user' AND `otpnumber` = '$otp'";
	
	 
$result = mysqli_query($conn, $statement) or die("ERROR OCCURED: ".mysqli_error($conn));
 
	$count = mysqli_num_rows($result);
if($count > 0)
{
 
$customer = mysqli_fetch_assoc($result);
//$_SESSION['email'] = $customer['username'];
$account_number = $customer['account_number'];
$truck_id = $customer['truck_id'];
$order_id = $customer['order_id'];
 
    echo json_encode(array("statusCode"=>200, "errorMessage"=>"OTP updated successfully. Please start ride.", "order_id"=>$order_id, "truck_id"=>$truck_id));  
    
  $sql = 	mysqli_query($conn,"UPDATE `trip_otp` SET  `status_value` = '1', `updated_by` = '$user', `updated_at` = '$datetime' WHERE `captain` = '$user' AND  `otpnumber` = '$otp'") or die("ERROR OCCURED: ".mysqli_error($conn)); 
    
    
    
    
 
   }
   
  else
  {
	  
	 
	
	  
	  	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"OTP not valid. Please check and try again later."));  		 

		 
	  }
    }
}
 
else{
    echo json_encode(array("statusCode"=>201, "errorMessage"=>"OTP not found. Please check and try again later."));  
    
}

 

 

?>

