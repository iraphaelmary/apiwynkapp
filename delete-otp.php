<?php
header('Access-Control-Allow-Origin: *');
 include("config/DB_config.php");
 
 $sql = "DELETE FROM `otp` WHERE `status_value` = '1'";
            $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$sql = "DELETE FROM `trip_otp` WHERE `status_value` = '1'";
            $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));

 




 $query =  "SELECT `id`, `message`, `title`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `code`, `truck_id`, `trip` FROM `notification` WHERE `title` LIKE '%OTP%' AND `read_status` = '2'";	
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						     $id = $row_distance[0];
        $code = $row_distance[1];
        $savedTime = $row_distance[7];
        
 
   // echo $code."<p>";
    
    
    $savedTime = strtotime($savedTime);
    $now = time();


//echo round(($now - $savedTime) / 60,2)." <p>";

    if (round(($now - $savedTime) / 60,2) >= 1){
        
         $sql = "DELETE FROM `notification` WHERE `id` = '$id'";
            $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            
            
      //echo "Your account is unlocked ".$code."<p>";
    } elseif (round(($now - $savedTime) / 60,2) < 1){
      // echo "Your account is locked"."<p>";
    }
        
					  		
    }
		      
		  }



?>