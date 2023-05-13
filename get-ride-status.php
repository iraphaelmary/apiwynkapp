 <?php
  header('Access-Control-Allow-Origin: *');
 include("config/DB_config.php");
 include("SendingSMS.php");
 include("class_file.php");


 $myName = new Name();
$emailing = "";
 
$json =  json_decode(file_get_contents('php://input'), true);

 
$code = $json['ride_code'];


 
 if(!empty($code))
 {
 
  
   
                 
$query1 =  "SELECT `id`, `code`,`status`,`trip_status` FROM `search_result` WHERE `code` = '$code'";
 
  
  $extract_distance1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
		$count1 = mysqli_num_rows($extract_distance1);
    if ($count1 > 0)
		  {
 	 while ($row_distance1=mysqli_fetch_row($extract_distance1))
    {
  						  	$id =$row_distance1[0];
  						  	$code =$row_distance1[1];
						   	$status =$row_distance1[2];
					  		$trip_status =$row_distance1[3];
		 
		 
   /*status = 0 = Active
   status = 1 = Paid
   status = 2 = Waiting Approval
   status = 3 = Rejected Offer
   status = 4 = Order Accepted
   status = 5 = Completed
    
   status = 7 = Arrived
   status = 8 = Trip Started
   status = 9 = Trip Ended
		 */
		 $status_value = "";
		 
		 if($status == 0)
		 {
			 $status_value = "Active";
			 
		 }
		 else if($status == 1)
		 {
			 
			$status_value = "Paid Ride"; 
		 }
		  else if($status == 2)
		 {
			 
			 $status_value = "Waiting Approval";
		 }
		  else if($status == 3)
		 {
			 
			 $status_value = "Rejected/Cancelled Offer";
		 }
		  else if($status == 4)
		 {
			 $status_value = "Accepted Ride";
			 
		 }
		  else if($status == 5)
		 {
			 
			 $status_value = "Completed Ride";
		 }
		  
		  else if($status == 7)
		 {
			 
			 $status_value = "Arrived";
			  
			   $otp = $myName->showName($conn, "SELECT  `otpnumber` FROM `trip_otp`  WHERE `order_id` = '$code'"); 
			  
			  
		 }
		   else if($status == 8)
		 {
			 
			 $status_value = "Trip Started";
		 }   else if($status == 9)
		 {
			 
			 $status_value = "Trip Ended";
		 }
		 
		 
		 
					  	 
 
    
 echo json_encode(array("statusCode"=>200,"status_code"=>$status ,"status_value"=>  $status_value,"otp"=>  $otp));   
         
         
     }
    }
	 else
         {
             
             echo json_encode(array("statusCode"=>201, "message"=>"No ride available for this code."));  
         }
                 
                 
   
           
             
             
             
 
 }
 
 
$conn->close();
	
 
?>

 