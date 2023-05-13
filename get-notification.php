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

// $username = "Wynk77875279";
 if(!empty($username))
 {
 
  
   
                 
$query1 =  "SELECT  `id`, `message`, `title`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `code`, `truck_id`,`ride_share` FROM `notification` WHERE   `sent_to` = '$username' AND 	 `read_status`  = '1'AND 	 `trip`  = '1' ORDER BY `id` DESC LIMIT 1";
 
  
  $extract_distance1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
		$count1 = mysqli_num_rows($extract_distance1);
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
                            $ride_share =$row_distance1[10];
         
         
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
    
          
        echo json_encode(array("statusCode"=>200,"title"=>$title, "code"=>$code, "ride"=>$ride, "status"=>$status, "id"=>$id, "payment_mode"=>$means, "ride_share"=>$ride_share));
         
         
     }
    }
    else
    {
        echo json_encode(array("statusCode"=>201,"title"=>"No notification Available Yet."));
        
    }
                 
                 
   
           
             
             
             
 
 }
 
 
$conn->close();
	
 
?>

 