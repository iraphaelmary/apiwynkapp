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
 

/*
$address = 'Ibadan, Nigeria';

$wynkid  = 'WYNK23378711';

$name = 'Olumide';

$lastname = 'Francis';	
	
$firstname  = 'Olumide';

$email = 'olumideogundele@gmail.com';
	

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
       $verification_type = $myName->showName($conn, "SELECT `varify_type`  FROM `user_unit` WHERE   `account_number` = '$wynkid'");
       $id_number = $myName->showName($conn, "SELECT `id_number`  FROM `user_unit` WHERE   `account_number` = '$wynkid'");
       $verifyme_url = $myName->showName($conn, "SELECT  `verifyme_url` FROM `application` WHERE `status` = 1");
  $verifyme_api_key = $myName->showName($conn, "SELECT  `verifyme_api_key` FROM `application` WHERE `status` = 1");
	
 
if(empty($phone))
{
    echo json_encode(array("statusCode"=>201, "errorMessage"=>"User information not found in the database. Please check and try again.")); 
			 
    
}
    else
    {
        
       
			
$sql = "UPDATE `user_unit` SET `name` = '$fullname',`phone` = '$phone', `email` = '$email', `address` = '$address', `created_date` = '$datetime', 
`registeredby` = '$emailing', `status` = 1,`file` = '$rphoto', `password_update` = '1', `firstname` = '$firstname', `lastname` = '$lastname',`middlename` = '$rmiddlename', `gender` = '$gender', `dob` = '$birthdate'  WHERE `account_number` = '$account_number'";
 
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 $process = true;
	if ($process) {
	 
 echo json_encode(array("statusCode"=>200, 
 "message"=>"Welcome to ".$inst_name.". Sign up successful. Just one more step. Create your pin and you're good to go.", 
 "firstname"=>$firstname, "account_number"=>$account_number, "lastname"=>$lastname, "email"=>$email, "gender"=>$gender, "phone"=>$phone, "birthdate"=>$birthdate,"passport"=>$full_passport,"smallpassport"=>$smallpassport));   
        
        
              
            
        
        
    }
     else {
 
 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Information Not Submitted Successfully. Please try again later."));  
        
    
		}
 
    }
 
 
 
 }
 
 
  










?>