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

/*$username = "WYNK77875279";
$id = 748;*/

 
 if(!empty($username))
 {
 
  
	 
	 
   
                 
$query1 =  "UPDATE `notification` SET  `read_status` = 2  WHERE `sent_to` = '$username' AND `id`  = '$id'";
 
  
  $extract_distance1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));	 
	 
	 
        if($extract_distance1)
		{
			echo json_encode(array("statusCode"=>200,  "message"=>"Successful"));
         
		}
         else
		 {
			 echo json_encode(array("statusCode"=>201,  "message"=>"Not Successful"));
			 
		 }
        
   
                 
                 
   
           
             
             
             
 
 } 
 
 
$conn->close();
	
 
?>

 