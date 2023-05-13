 <?php
 header('Access-Control-Allow-Origin: *');
 include("config/DB_config.php");
 include("SendingSMS.php");
 include("class_file.php");


 $myName = new Name();
$emailing = "";
 
$json =  json_decode(file_get_contents('php://input'), true);

 

 


$username = $json['wynkid'];
$id = $json['id'];

 
 if(!empty($username))
 {
 
  
   
                 
$query1 =  "SELECT  `id`, `message`, `title`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `code`, `truck_id` FROM `notification` WHERE   `sent_to` = '$username' AND 	 `id`  = '$id'";
 
  
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
                            
                            
                            
                            
                             
                 
$query1 =  "UPDATE `notification` SET  `read_status` = 2  WHERE `sent_to` = '$username' AND `id`  = '$id'";
 
  
  $extract_distance1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));	 
                            
                            
        $read_status_value = "" ;
    if($read_status == 1)
	{
		$read_status_value = "Unread";
	}else
	{
		$read_status_value = "Read";
		
	}
         
    
         
        echo json_encode(array("statusCode"=>200,"title"=>$title, "code"=>$code, "message"=>$message, "read_status"=>$read_status_value, "id"=>$id));
         
         
     }
    }
                 
                 
   
           
             
             
             
 
 }
 
 
$conn->close();
	
 
?>

 