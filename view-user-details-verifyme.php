 
<?php
header('Access-Control-Allow-Origin: *');
 include ("config/DB_config.php"); 

include("class_file.php");
 $myName = new Name();


 
 $json =  json_decode(file_get_contents('php://input'), true);
 
if(isset($json['wynkid']))
{
    
  $wynkid =  $json["wynkid"];
  $account_number =  $json["wynkid"];
  $username =  $json["wynkid"];
}
//WYNK77875279

/*
 
$wynkid = "WYNK18618830";
  $account_number =  "WYNK18618830";
  $username =  "WYNK18618830";
 */
    if(!empty($wynkid))
    {
 
      //  $username = $_POST['username'];
 
$query =  "SELECT `id`, `name`, `account_number`, `phone`, `email`, `address`, `file`, `state`, `lga`,  `firstname`, `lastname`, `middlename`, `dob`, `gender`, `passport`  FROM `user_unit` WHERE  `account_number` = '$wynkid' ORDER BY `id` ASC LIMIT 1";
 
  $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						  	$id =$row_distance[0];
  						  	$name =$row_distance[1];
						   	$account_number =$row_distance[2];
					  		$phone =$row_distance[3];
					  		$email =$row_distance[4];
						   	$address =$row_distance[5];
					  		$pictures =$row_distance[6];
					  		$state =$row_distance[7];
					  		 
         
  						  	$lga =$row_distance[8];
  						  	$firstname =$row_distance[9];
						   	$lastname =$row_distance[10];
					  		$middlename =$row_distance[11];
					  		$dob =$row_distance[12];
					  		$gender =$row_distance[13];
					  		 $passport =$row_distance[14];
  $full_passport = "http://wynk.ng/stagging-api/".$passport;
  
  $smallpass  = $account_number.".png";
  
  
     echo json_encode(array("statusCode"=>200, "message"=>$account_number, "firstname"=>$firstname, "lastname"=>$lastname, "middlename"=>$middlename, "email"=>$email, "phone"=>$phone, "dob"=>$dob, "gender"=>$gender, "birthdate"=>$dob,"passport"=>$full_passport,"smallpassport"=> $smallpass));  			
         
         
         
          
}
		}	
else{
    
 
    
    
  
    echo json_encode(array("statusCode"=>201, "errorMessage"=>"User details not found. Please check and try again."));  
}
				 
			 
			 
	}	
else
{
    
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Invalid Input Paramater. Please check and try again."));  
}
	 
?>