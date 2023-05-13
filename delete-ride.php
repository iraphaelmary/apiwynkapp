<?php
header('Access-Control-Allow-Origin: *');
 
 

include("config/DB_config.php");
 
 include("SendingSMS.php");
 include("view-application-details.php");
include("class_file.php");


$status = 0;



 $query =  "SELECT `id`, `code`, `created_date` from `search_result` where  `status` = 2 or `status` = 0";	
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						     $id = $row_distance[0];
        $code = $row_distance[1];
        $savedTime = $row_distance[2];
        
 
   // echo $code."<p>";
    
    
    $savedTime = strtotime($savedTime);
    $now = time();


//echo round(($now - $savedTime) / 60,2)." <p>";

    if (round(($now - $savedTime) / 60,2) >= 5){
        
         $sql = "DELETE FROM `search_result` WHERE `code` = '$code' ";
          //  $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            
            
             $sql = "DELETE FROM `notification` WHERE `code` = '$code' ";
        $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
        
        
          $sql = "DELETE FROM `transaction_information` WHERE `code` = '$code' ";
        $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
      //echo "Your account is unlocked ".$code."<p>";
    } elseif (round(($now - $savedTime) / 60,2) < 5){
      // echo "Your account is locked"."<p>";
    }
        
					  		
    }
		      
		  }
 

    // Uncomment below Line if $savedTime is in MySQL DATETIME Format
    // $savedTime = strtotime($savedTime);

 
 /*
if(isset($json['wynkid']))
{
    
  $wynkid =  $json["wynkid"];
 
}
 
 
 
 
     

     
if(empty($wynkid))
{
  
	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Wynk ID  Fields Cannot Be Empty. Please check and try again."));
	
}
else
{ 
  
		
 $sql = "DELETE FROM `user_unit` WHERE `account_number` = '$wynkid' ";
 
 
 
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 
	if ($process) {
		 
 
 echo json_encode(array("statusCode"=>200, "Message"=>"Information Deleted successfully. Thank you."));   
		
  }
  else
  {
	  
	  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured:  User Information not Deleted Successfully."));  
  }


    
 }
 
            

 
 */
 










?>