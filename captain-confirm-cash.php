<?php 
header('Access-Control-Allow-Origin: *');
 
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');
require_once('SendingSMS.php');

$myName = new Name();
 


$json =  json_decode(file_get_contents('php://input'), true);

 

 


 $username = $json['captain_wynkid'];
 
 $ref = $json['ride_code']; 
 
 
 
if(!empty($username))
{
	
	$paymentStatus = "Successful payment  confirmed by the captain";
			    // $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = "NGN";
			// $vbvmessage = $resp['data']['vbvmessage'];
			// $vbvmessage = $resp['data']['vbvmessage'];
			 $vbvmessage2 = "Successful";
			 $chargeAmount=$myName->showName($conn, "SELECT `amount` FROM `search_result` WHERE `code` = '$ref'"); 						
 $chargeResponsecode ="00";
            
            
            $allmessages = $paymentStatus." ".$vbvmessage2;
			 		
$sql = 	mysqli_query($conn,"UPDATE `transaction_information` SET `message` = '$allmessages',  `status` = '1'  WHERE  `code` = '$ref' ")or die("ERROR OCCURED: ".mysqli_error($conn)); 




  $sql = 	mysqli_query($conn,"UPDATE `search_result` SET `status` = '1' WHERE  `code` = '$ref'")or die("ERROR OCCURED: ".mysqli_error($conn)); 
	
	
	
	
	if($sql)
	{
		
		echo json_encode(array("statusCode"=>200, "message"=>"Payment Recieved Successfull")); 
	}
	else{
		
		echo json_encode(array("statusCode"=>201, "message"=>"Payment Not Recieved Successfull")); 
		
	}
	
			
			
			
			
			
    }
else{
	
	echo json_encode(array("statusCode"=>201, "message"=>"Captain information is empty")); 
	
}

 
		   
		 
	  
	  
	  
        
        
        
        // echo json_encode(array("statusCode"=>201, "errorMessage"=>"Invalid Login Details. Please check."));  
        
     
    

?>

