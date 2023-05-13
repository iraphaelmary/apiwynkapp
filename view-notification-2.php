 <?php
 header('Access-Control-Allow-Origin: *');
 include("config/DB_config.php");
 include("SendingSMS.php");
 include("class_file.php");
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

 $myName = new Name();
$emailing = "";
 
$json =  json_decode(file_get_contents('php://input'), true);

 

 

//Wynk77875279
//$username = $json['wynkid'];

 $username = 'WYNK87627590';
 if(!empty($username))
 {
 
  
   /* $sql = 	mysqli_query($conn,"INSERT INTO `transaction_information`(`code`,   `truck_owner`,  `amount`, `commissiononfee`,  `registeredby`, `created_date`, `message`, `status`, `customer` ,  `owners_share`, `means`, `narration`, `products`, `channel`,  `id_number`, `wallet_number`, `refs` ) VALUES('$clientReference','$wynkid','$amount','-','$wynkid', '$datetime','$message_all','1', '$phone_number', '0','wallet','$naration','airtime','$channel','$phone_number','$wallet_number','$airtime') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
							*/
                 
$query1 =  "SELECT  n.`id`, n.`message`, n.`title`, n.`registeredby`, n.`sent_to`, n.`status`, n.`read_status`, n.`created_at`, n.`code`, n.`truck_id`,t.`code`, t.`channel`,t.`narration`,t.`created_date` FROM `notification` n  RIGHT OUTER JOIN`transaction_information` WHERE n.`sent_to` = '$username' OR  t.`registeredby` = '$username' ORDER BY n.`id`, t.`id` DESC";
	 
	 
	 
	 
	// $query1 = "SELECT  `id`, `message`,  `title`,  `registeredby`,  `sent_to`, `status`, `read_status`, `created_at` FROM `notification`    OUTER JOIN `transaction_information`  ON n.`sent_to` = t.`registeredby`";
 
  
  $extract_distance1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
		$count1 = mysqli_num_rows($extract_distance1);
	 
	  $json2 = '[';
	 
	 
    if ($count1 > 0)
		  {
 	 while ($row_distance1=mysqli_fetch_row($extract_distance1))
    {
  						  	$id =$row_distance1[0];
  						  	$message =$row_distance1[1];
						   	$title =$row_distance1[2];
					  		$registeredby =$row_distance1[3];
					  		$sent_to =$row_distance1[4];
						   	$status =$row_distance1[5];
					  		$read_status =$row_distance1[6];
					  	    $created_at =$row_distance1[7];
                            $code =$row_distance1[8];
                            $truck_id =$row_distance1[9];
                            $code2 =$row_distance1[9];
                            $channel =$row_distance1[9];
                            $narration =$row_distance1[9];
                            $created_at =$row_distance1[9];
         
         
         $ride = "";
         if($truck_id != "" or !empty($truck_id))
         {
               $ride = "1";
             
         }
         else{
             $ride = "0";
             
         }
                           
       
         if(!empty($code))
         {
              $status = $myName->showName($conn, "SELECT  `status` FROM `search_result` WHERE `code` =  '$code'"); 
              $means = $myName->showName($conn, "SELECT `means` FROM `transaction_information` WHERE `code` =  '$code'"); 
             
         }
    
          
       
		 
		 
					$json2 .= '{
    "title": "'.$title.'",
    "code": "'.$code.'",
    "ride": "'.$ride.'",
    "actuastatuslBalance": "'.$status.'",
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

 