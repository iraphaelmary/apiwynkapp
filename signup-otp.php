<?php 
 header('Access-Control-Allow-Origin: *');
  include("SendingSMS.php");

  include("config/DB_config.php");
 
require_once('view-application-details.php');
require_once('class_file.php');

$myName = new Name();
$json =  json_decode(file_get_contents('php://input'), true);

// $data = json_decode($json);
 
 $phone =  $json["phone"];
 
//$phone =   "2348140609393";

$validated_number = validate_nigeria_phone_number($phone);
if ($validated_number) {
    //echo "Valid Nigerian phone number: " . $validated_number;


$phone = $validated_number;
$phone2 = $validated_number;


if(!empty($phone))
{
	 
 
    $table = "otp";
	
	 
 //$otp =$_POST['allotp'];
 //$phone =$_POST['phone'];
 
   $account_number = "WYNK".rand(10, 99).rand(10, 99).rand(11, 89).rand(10, 99);	
   $otp = mt_rand(1111,9999);
    
    if(empty($phone))
    {
      	echo json_encode(array("statusCode"=>201, "message"=>"Phone Number is empty. Please try again later."));  
        
    }
    else{
    
    
		 
$query = "select `id`, `account_number`, `name`,`created_date` from `user_unit` WHERE (`phone` = '$phone' OR `phone` LIKE '%".$phone."%')";
 
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						  $id =$row_distance[0];
						   $account_number =$row_distance[1];
					  $name =$row_distance[2];
					  $created_date =$row_distance[3];
    
	 
	
	    $wallet_num = $myName->showName($conn, "SELECT  `accountNumber` FROM `wallet_info` WHERE `registeredby`  = '$account_number' AND `accountName` != '' AND `primary_wallet` = 1 LIMIT 1");
		 
		 
		 if(!empty($wallet_num) or !empty($name))
		 {
 echo json_encode(array("statusCode"=>202, "message"=>"User Already registered.", "name"=>$name, "phone"=>$phone, "wynkid"=>$account_number, "wallet_number"=> $wallet_num, "created_date"=> $created_date));  
			 
		 }
		 else{
			 
			 		 
$query = "DELETE from `user_unit` WHERE (`phone` = '$phone' OR `phone` LIKE '%".$phone."%' OR `account_number` = '".$account_number."')";
 
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
			 
			 
			 
			 
			 			 		 
$query = "DELETE from `wallet_info` WHERE (`phone` = '$phone' OR `phone` LIKE '%".$phone."%' OR `registeredby` = '".$account_number."')";
 
 //$extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
			 
			 
			
	
		 
 
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
    echo json_encode(array("statusCode"=>200, "message"=>"OTP sent previously sent to this phone number. Thank You.", "phone"=>$phone, "otp"=>$otpnumber, "wynkid"=> $account_number));  
    
 
 
   }
   
  else
  {
	  
	 
	$sql = 	mysqli_query($conn,"INSERT INTO `otp`(`account_number`, `otpnumber`, `status_value`, `phone`) VALUES('$account_number','$otp','0','$phone2')") or die("ERROR OCCURED: ".mysqli_error($conn)); 
	  
	   if($sql)
	   {
				
  $message =  $inst_name." registeration OTP! Your OTP #".$otp.". Please use it within 3 minutes.";

  $str2 = substr($phone, 3);


 

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
    echo json_encode(array("statusCode"=>200, "message"=>"OTP sent previously sent to this phone number. Thank You.", "phone"=>$phone, "otp"=>$otpnumber, "wynkid"=> $account_number));  
    
 
 
   }
   
  else
  {
	  
	 
	$sql = 	mysqli_query($conn,"INSERT INTO `otp`(`account_number`, `otpnumber`, `status_value`, `phone`) VALUES('$account_number','$otp','0','$phone2')") or die("ERROR OCCURED: ".mysqli_error($conn)); 
	  
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
 }
 
else{
    echo json_encode(array("statusCode"=>201, "message"=>"Phone number is missing. OTP not sent. Please try again later."));  
    
}

} else {
     
	
	  echo json_encode(array("statusCode"=>201, "message"=>"Invalid Nigerian phone number. Please use 09099797979 format. Thank you."));  
}



function validate_nigeria_phone_number($phone_number) {
    // Remove all non-numeric characters
    $phone_number = preg_replace("/[^0-9]/", "", $phone_number);
    
    // Add "234" to the beginning if not already there
    if (substr($phone_number, 0, 3) != "234") {
        $phone_number = "234" . substr($phone_number, -10);
    }
    
    // Check if length is 13
    if (strlen($phone_number) == 13) {
        return $phone_number;
    } else {
        return false;
    }
}


?>

