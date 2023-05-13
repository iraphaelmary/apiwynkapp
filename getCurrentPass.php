 
<?php
header('Access-Control-Allow-Origin: *');
 include ("config/DB_config.php"); 

include("class_file.php");
 $myName = new Name();


$json =  json_decode(file_get_contents('php://input'), true);

 

 

 /* 
 $username = "WYNK77875279";
$emailing  = "WYNK77875279";
 */
 
 
$username = $json['captain_wynkid'];
$emailing  = $json['captain_wynkid'];
    if(!empty($username))
    {
 
 
 
     
 
$query =  "SELECT  `id`, `pass_id`, `pass_type`, `start_date`, `end_date`, `created_date`, `registeredby`, `status`, `amount` FROM `captain_pass` WHERE  `registeredby` = '$username'  ORDER BY `id` DESC LIMIT 1";
 
  $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						  	$id =$row_distance[0];
  						  	$pass_id =$row_distance[1];
						   	$pass_type =$row_distance[2];
					  		$start_date =$row_distance[3];
					  		$end_date =$row_distance[4];
						   	$created_date =$row_distance[5];
					  		$registeredby =$row_distance[6];
					  		$status =$row_distance[7];
					  	 	$amount =$row_distance[8];
  						   
					  $today = date("Y-m-d G:i:s"); 		 
	 
         
 
         
   $pass_name = $myName->showName($conn, "SELECT  `pass_name` FROM `captain_pass_setup` WHERE   `id` = '$pass_id'");   
     	 
					 $pass_type_name = "";
         if($pass_type == 1)
         {
             $pass_type_name = "Pre-Paid";
             
         }
         else  if($pass_type == 2)
         {
             $pass_type_name = "Post-Paid";
             
         } 
         


//the new one
$today_2 = strtotime(date('Y-m-d', strtotime($today)));
$expire_2 = strtotime(date('Y-m-d', strtotime($end_date)));


$secs = $expire_2 - $today_2;// == <seconds between the two times>
$days = $secs / 86400;

 



if($days <= 0)
{
    
    //echo "You have no pass. Will you like to get a pass now?";
    
     echo json_encode(array("statusCode"=>202, "errorMessage"=>"Pass expired.  Will you like to get a pass now?", "start"=>$start_date, "end"=>$end_date));  			
         
     //$sql = "UPDATE `user_unit` SET  `status` = 1 WHERE `account_number` = '$username'";
  $sql ="UPDATE `online_status` SET `status` = 10, `created_date` = '$datetime'  WHERE `account_number` = '$username'";
mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));	                                                     
                                                       
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));  
            
    
    
}
else
{
     //echo "You have no pass. Will you like to get a pass now?......";
$today_2 = new DateTime($today);
$expire_2 = new DateTime($end_date);

$difference = $today_2->diff($expire_2);

$diff = format_interval($difference);

if(empty($diff))
{
    
  echo json_encode(array("statusCode"=>202, "errorMessage"=>"Pass expired.  Will you like to get a pass now?", "start"=>$start_date, "end"=>$end_date));  
    // $sql = "UPDATE `user_unit` SET  `status` = 1 WHERE `account_number` = '$username'";
 $sql ="UPDATE `online_status` SET `status` = 10, `created_date` = '$datetime'  WHERE `account_number` = '$username'";
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
}
else
{
    
    //echo $diff;
    
     echo json_encode(array("statusCode"=>200, "message"=>"Pass still valid.", "date"=>$diff, "pass_name"=>$pass_name, "pass_type"=>$pass_type_name, "start"=>$start_date, "end"=>$end_date, "amount"=>  "&#8358; ".number_format($amount,2) ));  
}

    
}
         
         
    
         
         
          
}
		}	
else{
    
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Captain doesn't have pass yet. Please buy a pass."));  
    
  
   
}
				 
			 
			 
	}	
else
{ echo json_encode(array("statusCode"=>201, "errorMessage"=>"No user not details found. Please check and try again."));  
    
    
}
	 




function format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result .= $interval->format("%y years "); }
    if ($interval->m) { $result .= $interval->format("%m months "); }
    if ($interval->d) { $result .= $interval->format("%d days "); }
    if ($interval->h) { $result .= $interval->format("%h hours "); }
   // if ($interval->i) { $result .= $interval->format("%i minutes "); }
   // if ($interval->s) { $result .= $interval->format("%s seconds "); }

    return $result;
}

?>