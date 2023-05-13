<?php 
header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();

	  $count_times = 0;    

	  	 
$json =  json_decode(file_get_contents('php://input'), true);
 $password =   mysqli_real_escape_string($conn, $json["password"]);
$username =   mysqli_real_escape_string($conn, $json["username"]) ;
// $data = json_decode($json);
 
//$password =  $json["password"];
//$username =  $json["username"];
//$wynkid =  $json["wynkid"];



// $username = 'olumideogundele7@gmail.com';
// $password =  'olumide';



 
if(strlen($username) == 0 )
{
echo json_encode(array("statusCode"=>201, "errorMessage"=>"Username Is empty"));
}
else if(strlen($password) == 0 )
{
echo json_encode(array("statusCode"=>201, "errorMessage"=>"Username Is empty"));
}
else
{
    
    
    

   $account_number2 = $myName->showName($conn, "SELECT `account_number` FROM  `user_unit` WHERE (`account_number` = '$username' OR `email` = '$username' OR `phone` = '$username') "); 	
    
     if(empty($account_number2))
          {
              $account_number2 = $username;
              
          }
 

	
	  $count_times2 = 0; 
    
    
 if($count_times2 >= "3" or $count_times2 >= 3 )
 {
     
   echo json_encode(array("statusCode"=>201, "errorMessage"=>"You have been blocked. Please contact admin."));   
 }
else{
     
    
     
     
$statement = "select * from `user_unit` where (`account_number` = '$username' OR `email` = '$username' OR `phone` = '$username' OR `phone` LIKE '%$username%') AND `status` =  1";
	
$result = mysqli_query($conn,$statement) or die("ERROR OCCURED: ".mysqli_error($conn));

if($result)
{
if(mysqli_num_rows($result) == 1)
{
    
    
      $sql = 	mysqli_query($conn,"UPDATE `block_users` SET `count_times` = '0' WHERE  `username` = '$account_number2' or `username` = '$username'") or die("ERROR OCCURED: ".mysqli_error($conn)); 
     
    $customer = mysqli_fetch_assoc($result);

$emailing = $customer['account_number'];
$emailAdd  = $customer['email']; 
	$phoneNumber  = $customer['phone']; 
		$account_number = $customer['account_number'];

$lastname  = $customer['name'];
$firstname  = $customer['name']; 
$fullname = $lastname;

$_SESSION['lastname'] = $lastname;
$_SESSION['lastnaming'] = $lastname;

$_SESSION['fullname'] = $fullname;
$_SESSION['name'] =$fullname;
$_SESSION['naming'] =$fullname;
$_SESSION['email'] = $customer['account_number'];
	$_SESSION['loginData'] = $username;
	
		$_SESSION['iss'] = $customer['id'];
	
	$_SESSION['user_unit'] = $customer['id'];
	$_SESSION['service_unit'] = $customer['id'];
	$_SESSION['emailadd'] = $customer['email'];
$usertype =  $customer['usertype'];	
	 
$_SESSION['usertype'] = $usertype;
 $_SESSION['account_number'] =$account_number;		
  $_SESSION['account_number1'] = $customer['account_number']; 	
  $wynkid = $customer['account_number']; 	
$password_update = $customer['password_update'];	
	
	
	
	
	//SELECT  `unique_id`, `encrypted_password`, `salt` FROM `user_credntials` WHERE  `account_number`
	 $salt = $myName->showName($conn, "SELECT `salt` FROM  `user_credntials` WHERE (`account_number` = '$wynkid')"); 	
	
	
	$encrypted_password = $myName->showName($conn, "SELECT `encrypted_password` FROM  `user_credntials` WHERE (`account_number` = '$wynkid')"); 	
	


//$salt = $customer['salt'];
//$encrypted_password = $customer['encrypted_password'];
	
	
	
$hash = base64_encode(sha1($password . $salt, true) . $salt);

    
    
			//echo json_encode(array("statusCode"=>201, "errorMessage"=>$account_number2));
    
     if ($encrypted_password == $hash and (trim($emailing) == trim($username) or trim($emailAdd) == trim($username) or trim($phoneNumber) == trim($username)) )
   {
         
       if($password_update == 1)
	   {
 
	      $pipaddress = "";
	  $ipaddress= "";
	 if (getenv('HTTP_X_FORWARDED_FOR')) {
        $pipaddress = getenv('HTTP_X_FORWARDED_FOR');
        $ipaddress = getenv('REMOTE_ADDR');
 
    } else {
        $ipaddress = getenv('REMOTE_ADDR');
       
    }
	   
 $sql = 	mysqli_query($conn,"INSERT INTO `login_log`(`username`, `ip_address`, `login`, `platform`,`status`) VALUES('$username','$ipaddress','$datetime', 'customer mobile','0')") or die("ERROR OCCURED: ".mysqli_error($conn)); 
	   
	   
	
	
 

 
			  if($usertype == 3 or $usertype ==  1 or $usertype == 2 )
			 {
                 
				 	//echo json_encode(array("statusCode"=>200));
 echo json_encode(array("statusCode"=>200, "errorMessage"=>"Correct user", "username"=>$account_number2,"name"=>$firstname,"email"=>$emailAdd,"usertype"=>$usertype ,"phone"=>$phoneNumber ));  
 //echo json_encode(array("statusCode"=>200, "errorMessage"=>"Correct user", "username"=>$account_number2, "name"=>$firstname, "email"=>$emailAdd));  
				 
			 }
             else
			 {
				 	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Invalid User type."));  
                 //echo json_encode(array("statusCode"=>200));
				 
			 }
			 
			  
				 
				 
			 
  

		 
	   }
	   else
	   {
		   
		   echo json_encode(array("statusCode"=>200, "errorMessage"=>"Correct user", "username"=>$account_number2,"name"=>$firstname,"email"=>$emailAdd,"usertype"=>$usertype ,"phone"=>$phoneNumber ));  
	   } 
         
     }
    else
    {
        //here
        
		 $count_times += 1;
		  if($account_number2 == "" or empty($account_number2))
          {
              $account_number2 = $username;
              
          }
	  
	  
	  $query =  "SELECT  `id`, `count_times`, `username`, `status`, `created_date`, `registeredby` FROM `block_users` WHERE  `username` = '$account_number2'";	
 
 
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
  	  
	  
  $sql = 	mysqli_query($conn,"UPDATE `block_users` SET `count_times` = '$count_times' WHERE  `username` = '$account_number2'") or die("ERROR OCCURED: ".mysqli_error($conn)); 
	   
	}else
	{
		
			  
	  
  $sql = 	mysqli_query($conn,"INSERT INTO `block_users`(`count_times`, `username`, `status`, `created_date`, `registeredby`) VALUES('$count_times','$account_number2','1', '$datetime','$account_number2')") or die("ERROR OCCURED: ".mysqli_error($conn)); 
	   
	}
	  
	  
	  
	  
        
        
        
         echo json_encode(array("statusCode"=>201, "errorMessage"=>"Invalid Login Details..... Please check."));  
        
    }
    
    
    
    
    
    
    
}
    else
{
        
        
         if(empty($account_number2))
          {
              $account_number2 = $username;
              
          }
	  
        
        $count_times = $myName->showName($conn, "SELECT `count_times`  FROM `block_users` WHERE  `username` = '$account_number2' or   `username` = '$username'");
 
 $count_times =intval($count_times) + 1;
		 
			
		//echo json_encode(array("statusCode"=>201));
	  
        
         
	  $query =  "SELECT  `id`, `count_times`, `username`, `status`, `created_date`, `registeredby` FROM `block_users` WHERE  `username` = '$account_number2' ";	
 
 
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
  	  
	  
  $sql = 	mysqli_query($conn,"UPDATE `block_users` SET `count_times` = '$count_times' WHERE  `username` = '$account_number2'") or die("ERROR OCCURED: ".mysqli_error($conn)); 
	   
	}else
	{
		
			  
	  
  $sql = 	mysqli_query($conn,"INSERT INTO `block_users`(`count_times`, `username`, `status`, `created_date`, `registeredby`) VALUES('$count_times','$account_number2','1', '$datetime','$account_number2')") or die("ERROR OCCURED: ".mysqli_error($conn)); 
	   
	}
        
        
        
         echo json_encode(array("statusCode"=>201, "errorMessage"=>"Invalid Login Details.. Please check."));  
	  
}
}
     else
     {
        echo json_encode(array("statusCode"=>201, "errorMessage"=>"Invalid Login Details..."));  
         
     }
     
     

     
     }
    
    
    
}
 

?>

