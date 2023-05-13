<?php
header('Access-Control-Allow-Origin: *');
 
 

include("config/DB_config.php");
 
 include("SendingSMS.php");
 include("view-application-details.php");
$referral_code = "";
$firstname = "";
$email = "";
$lastname = "";
$name = "";
$address = "";
 
$wynkid  = "";
include("class_file.php");
 $json =  json_decode(file_get_contents('php://input'), true);

 

 


if(isset($json['firstname']))
{
    
  $firstname = htmlspecialchars(trim($json['firstname']));  
}

if(isset($json['referral_code']))
{
    
$referral_code = htmlspecialchars(trim($json['referral_code']));    
}
if(isset($json['email']))
{
    
$email = htmlspecialchars(trim($json['email']));   
}
if(isset($json['lastname']))
{
    
  $lastname = htmlspecialchars(trim($json['lastname']));
}
if(isset($json['firstname']))
{
    
   $name = htmlspecialchars(trim($json['firstname']));
}
if(isset($json['address']))
{
    
  $address = htmlspecialchars(trim($json['address']));
}
if(isset($json['wynkid']))
{
    
  $wynkid =  $json["wynkid"];
}
 if(isset($json['password']))
{
    
  $password =  $json["password"];
}
  if(isset($json['dob']))
{
    
  $dob =  $json["dob"];
}
 

 
/* $address = 'Ibadan, Nigeria';

$wynkid  = 'WYNK23378711';

$name = 'Olumide';

$lastname = 'Francis';	
	
$firstname  = 'Olumide';

$email = 'olumideogundele7@gmail.com';
$password = 'olumide';
	 */

 
 $fullname = $firstname.' '.$lastname;
 $myName = new Name();
 
     

     
if (empty($firstname) || empty($lastname) || empty($wynkid))
{
  
   
  
  	  
	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Firstname, Lastname and Wynk Id are required fields. Please check and try again."));
	
}
else
{ 
 
 

 
$state  = 0;
$lga    =0;
$number    = 0;
  
	 $logo = "" ;
	   $account_number = $wynkid;		
	   $emailing = $wynkid;		
	 
 $phone = $myName->showName($conn, "SELECT `phone`  FROM `user_unit` WHERE   `account_number` = '$wynkid'");
        
	
 
if(empty($phone))
{
    echo json_encode(array("statusCode"=>201, "errorMessage"=>"User information not found in the database. Please check and try again.")); 
			 
    
}
    else
    {
        
       
	$extract_user = mysqli_query($conn, "SELECT * FROM `user_unit` WHERE  `email` = '$email'") or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_user);
		 if ($count > 0) {
	 	 
	 echo json_encode(array("statusCode"=>201, "errorMessage"=>"User information in the  database already. Please check and try again later.."));  
  
		 }else
		 {
			
$sql = "UPDATE `user_unit` SET `name` = '$fullname',`phone` = '$phone', `email` = '$email', `address` = '$address', `created_date` = '$datetime', 
`registeredby` = '$emailing', `status` = 1,`file` = '-', `password_update` = '1', `firstname` = '$firstname', `lastname` = '$lastname',`middlename` = '-', `gender` = '$gender', `dob` = '$dob'  WHERE `account_number` = '$account_number'";
 
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 $process = true;
	if ($process) {
		
		
					
$uuid = uniqid('', true);

$salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
         
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
		
		
 $sql = "INSERT INTO `user_credntials`(`account_number`, `wynkid`, `created_date`, `registeredby`, `status`, `unique_id`, `encrypted_password`, `salt`, `irrelivant`, `password_update`, `updated_at`) VALUES
('$wynkid','$wynkid','$datetime','$wynkid', '1',  '$uuid','$encrypted_password', '$salt', '$password', '1','$datetime')";
 
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 
		
		
 //$sql = "UPDATE `user_unit` SET  `unique_id` = '$uuid', `encrypted_password` = '$encrypted_password', `salt` = '$salt', `irrelivant` = '$pin', `pin` = '$pin' WHERE `account_number` = '$account_number' ";
 
 
 
 
 //$process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		
		
		
		
		
	 
 echo json_encode(array("statusCode"=>200, 
 "message"=>"Welcome to ".$inst_name.". Sign up successful. Just one more step. Create your pin and you're good to go.", 
 "firstname"=>$firstname, "account_number"=>$account_number, "lastname"=>$lastname, "email"=>$email, "gender"=>$gender, "phone"=>$phone, "birthdate"=>$birthdate,"passport"=>$full_passport,"smallpassport"=>$smallpassport));   
        
        
              
            
        
        
    }
     else {
 
 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Information Not Submitted Successfully. Please try again later."));  
        
    
		}
 
    }
 
 
 
 }
 }
 
 
  










?>