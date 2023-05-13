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

  //$username = 'WYNK74654117';
 if(!empty($username))
 {
 
  
   
                 
$query1 =  "SELECT  `id`, `message`, `title`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `code`, `truck_id` FROM `notification` WHERE   `sent_to` = '$username' ORDER BY `id` DESC";
 
  
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

 