 <?php
 header('Access-Control-Allow-Origin: *');
 include("config/DB_config.php");
 include("SendingSMS.php");
 include("class_file.php");
 
 
 $myName = new Name();
$emailing = "";
 
$json =  json_decode(file_get_contents('php://input'), true);

 

 

//Wynk77875279
 $username = $json['wynkid'];
 $code = $json['code'];
 //$code = "20230403622249";

 //$username = 'WYNK45435657';
 if(!empty($username))
 {
  
 
                 
$query1 =  "SELECT `id`, `code`,  `amount`,`message`,`customer`,`created_date`,`registeredby` , `refs`, `products`, `narration`, `channel`, `id_number`, `wallet_number`, `bank`, `account_number`, `description`, `means` FROM `transaction_information` WHERE `registeredby` = '$username' AND `channel` != 'ride' AND `code`  = '$code'";
  $extract_distance1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
		$count1 = mysqli_num_rows($extract_distance1);
  $json2 = '[';
 if ($count1 > 0)
		  {
 	 while ($row_distance1=mysqli_fetch_row($extract_distance1))
    {
  						  	$id =$row_distance1[0];
  						  	$code =$row_distance1[1];
						   	$amount =$row_distance1[2];
					  		$message =$row_distance1[3];
					  		$customer =$row_distance1[4];
						   	$created_date =$row_distance1[5];
					  		$registeredby =$row_distance1[6];
					  	    $refs =$row_distance1[7];
                            $products =$row_distance1[8];
                            $narration =$row_distance1[9];
                            $channel =$row_distance1[10];
                            $id_number =$row_distance1[11];
                            $wallet_number =$row_distance1[12];
                            $bank =$row_distance1[13];
                            $account_number =$row_distance1[14];
                            $description =$row_distance1[15];
                             $means =$row_distance1[16];
         
                     
     
    
          
       if($products == "w2w")
	   {
		   
		   $products = "Wynk Vault 2 Wynk Vault";
		    $bank_name = 'WYNK WALLET';
	   } 
		 else if($products == "w2b")
	   {
		   
		   $products = "Wynk Vault 2 Bank";
			  $bank_name = $myName->showName($conn, "SELECT `bank_name` FROM `banklist` WHERE `bankCode` = '$bank'");
	   }
		  else if($products == "ride")
	   {
		   
		   $products = "Wynk Ride";
			   $bank_name = 'WYNK WALLET';
	   }
		   else if($products == "pass")
	   {
		   
		   $products = "Captain Pass Payment";
			    $bank_name = 'WYNK WALLET';
	   }
		 else{
			 
			  $bank_name = $channel;
		 }
		 
		 
					$json2 .= '{
    "code": "'.$code.'",
    "title": "'.$products.'",
    "channel": "'.$channel.'",
    "beneficiary": "'.$customer.'",
    "account_number": "'.$account_number.'",
    "bankname": "'.$bank_name.'",
    "created_date": "'.$created_date.'",
    "amount": "'.number_format($amount,  2).'", 
	"description": "'.$description.'",
	"description": "'.$means.'",
    "id": "'.$id.'"
},'; 
		 
		 
         
         
     }
		
		
		
	$json2 .= "]";
	
	//echo $json2;
	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
 echo trim($json1);
    }
    else
    {
        echo json_encode(array("statusCode"=>201,"title"=>"No notification"));
        
    }
                 
                 
   
           
             
             
             
 
 }
else{
	
echo json_encode(array("statusCode"=>201,"title"=>"An important field is empty. Please check and try again."));	
	
}
 
 
$conn->close();
	
 
?>

 